<?php
/**
 * Answer-engine / generative-search helpers (AEO / GEO):
 * - /llms.txt and /llms-full.txt (https://llmstxt.org) generated from content,
 * - robots.txt rules for AI training crawlers (opt-in),
 * - knowsAbout for the organization schema.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * AI visibility.
 */
class Akilli_AI {

	/**
	 * Crawlers that collect content for model training (not answer/search bots).
	 *
	 * @var string[]
	 */
	const TRAINING_BOTS = array( 'GPTBot', 'Google-Extended', 'CCBot', 'ClaudeBot', 'Applebot-Extended', 'meta-externalagent', 'Bytespider' );

	/**
	 * Hooks.
	 */
	public static function init() {
		add_action( 'parse_request', array( __CLASS__, 'maybe_serve' ), 0 );
		add_filter( 'robots_txt', array( __CLASS__, 'robots' ), 20, 2 );
		add_filter( 'redirect_canonical', array( __CLASS__, 'no_trailing_slash' ), 10, 2 );
	}

	/**
	 * Keep /llms.txt without a trailing-slash redirect.
	 *
	 * @param string $redirect Redirect URL.
	 * @param string $requested Requested URL.
	 * @return string|false
	 */
	public static function no_trailing_slash( $redirect, $requested ) {
		return preg_match( '#/llms(-full)?\.txt$#', (string) wp_parse_url( $requested, PHP_URL_PATH ) ) ? false : $redirect;
	}

	/**
	 * Serve the files when requested.
	 *
	 * @param WP $wp Request.
	 */
	public static function maybe_serve( $wp ) {
		if ( ! akilli_get_setting( 'llms_enabled' ) ) {
			return;
		}
		$path = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_parse_url( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ) : '';
		$home = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
		$rel  = ltrim( substr( $path, strlen( rtrim( $home, '/' ) ) ), '/' );
		if ( 'llms.txt' !== $rel && 'llms-full.txt' !== $rel ) {
			return;
		}
		$full = 'llms-full.txt' === $rel;
		$key  = 'akilli_llms_' . ( $full ? 'full' : 'index' );
		$body = get_transient( $key );
		if ( false === $body ) {
			$body = self::build( $full );
			set_transient( $key, $body, 12 * HOUR_IN_SECONDS );
		}
		status_header( 200 );
		header( 'Content-Type: text/plain; charset=utf-8' );
		header( 'X-Content-Type-Options: nosniff' );
		if ( '0' === (string) get_option( 'blog_public' ) ) {
			header( 'X-Robots-Tag: noindex' );
		}
		echo $body; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- plain text, built from sanitized content.
		exit;
	}

	/**
	 * Clear the cache when content changes.
	 */
	public static function flush() {
		delete_transient( 'akilli_llms_index' );
		delete_transient( 'akilli_llms_full' );
	}

	/**
	 * Plain one-line text.
	 *
	 * @param string $s Input.
	 * @return string
	 */
	private static function line( $s ) {
		return trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( (string) $s ), ENT_QUOTES, 'UTF-8' ) ) );
	}

	/**
	 * Readable body text of a post (dynamic blocks rendered, markup removed).
	 *
	 * @param WP_Post $p Post.
	 * @return string
	 */
	private static function body( $p ) {
		$html = do_blocks( $p->post_content );
		$html = preg_replace( '#<(script|style|form|svg|nav)[^>]*>.*?</\1>#is', ' ', $html );
		$html = preg_replace( '#<(h[1-6])[^>]*>#i', "\n\n## ", $html );
		$html = preg_replace( '#<(li)[^>]*>#i', "\n- ", $html );
		$html = preg_replace( '#</(p|div|section|ul|ol|dt|dd|summary|details|h[1-6])>#i', "\n", $html );
		$text = html_entity_decode( wp_strip_all_tags( $html ), ENT_QUOTES, 'UTF-8' );
		$text = preg_replace( "/[ \t]+/", ' ', $text );
		$text = preg_replace( "/\n\s*\n\s*(\n\s*)+/", "\n\n", $text );
		return trim( preg_replace( '/^ +/m', '', $text ) );
	}

	/**
	 * Build llms.txt (index) or llms-full.txt.
	 *
	 * @param bool $full Include full page text.
	 * @return string
	 */
	public static function build( $full = false ) {
		$name = (string) akilli_get_setting( 'company_name' );
		$out  = '# ' . $name . "\n\n";
		$sum  = self::line( akilli_get_setting( 'llms_summary' ) );
		if ( $sum ) {
			$out .= '> ' . $sum . "\n\n";
		}
		$facts = array_filter(
			array(
				'Web sitesi'         => home_url( '/' ),
				'E-posta'            => akilli_get_setting( 'email' ),
				'Telefon / WhatsApp' => akilli_get_setting( 'phone' ),
				'Adres'              => akilli_get_setting( 'address' ),
				'Çalışma saatleri'   => akilli_get_setting( 'working_hours' ),
				'Teklif'             => strtok( akilli_quote_url(), '#' ),
			)
		);
		foreach ( $facts as $k => $v ) {
			$out .= '- ' . $k . ': ' . self::line( $v ) . "\n";
		}
		foreach ( akilli_lines( akilli_get_setting( 'llms_facts' ) ) as $f ) {
			$out .= '- ' . self::line( $f ) . "\n";
		}
		$out .= "\n";

		$tree = akilli_get_service_tree();
		if ( $tree ) {
			$out .= "## Hizmetler\n\n";
			foreach ( $tree as $node ) {
				$c    = $node['post'];
				$out .= '### [' . self::line( get_the_title( $c ) ) . '](' . get_permalink( $c ) . ")\n\n";
				if ( has_excerpt( $c ) ) {
					$out .= self::line( get_the_excerpt( $c ) ) . "\n\n";
				}
				foreach ( $node['children'] as $ch ) {
					$out .= '- [' . self::line( get_the_title( $ch ) ) . '](' . get_permalink( $ch ) . ')' . ( has_excerpt( $ch ) ? ': ' . self::line( get_the_excerpt( $ch ) ) : '' ) . "\n";
				}
				$out .= "\n";
			}
		}

		$pages = get_pages(
			array(
				'sort_column' => 'menu_order,post_title',
				'post_status' => 'publish',
			)
		);
		if ( $pages ) {
			$out .= "## Sayfalar\n\n";
			foreach ( $pages as $pg ) {
				if ( (int) get_option( 'page_on_front' ) === $pg->ID ) {
					continue;
				}
				$out .= '- [' . self::line( get_the_title( $pg ) ) . '](' . get_permalink( $pg ) . ')' . ( $pg->post_excerpt ? ': ' . self::line( $pg->post_excerpt ) : '' ) . "\n";
			}
			$out .= "\n";
		}

		$projects = get_posts(
			array(
				'post_type'   => 'ak_proje',
				'numberposts' => 30,
			)
		);
		if ( $projects ) {
			$out .= "## Çalışmalar\n\n";
			foreach ( $projects as $pr ) {
				$demo = get_post_meta( $pr->ID, '_ak_demo_key', true ) ? ' (örnek proje)' : '';
				$out .= '- [' . self::line( get_the_title( $pr ) ) . '](' . get_permalink( $pr ) . ')' . $demo . ( has_excerpt( $pr ) ? ': ' . self::line( get_the_excerpt( $pr ) ) : '' ) . "\n";
			}
			$out .= "\n";
		}

		$posts = get_posts( array( 'numberposts' => 30 ) );
		if ( $posts ) {
			$out .= "## Blog\n\n";
			foreach ( $posts as $po ) {
				$out .= '- [' . self::line( get_the_title( $po ) ) . '](' . get_permalink( $po ) . ')' . ( has_excerpt( $po ) ? ': ' . self::line( get_the_excerpt( $po ) ) : '' ) . "\n";
			}
			$out .= "\n";
		}

		if ( ! $full ) {
			$out .= "## Optional\n\n- [Tüm içerik (tam metin)](" . home_url( '/llms-full.txt' ) . ")\n";
			return $out;
		}

		$out .= "---\n\n# Tam metin\n\n";
		$items = array();
		foreach ( $tree as $node ) {
			$items[] = $node['post'];
			foreach ( $node['children'] as $ch ) {
				$items[] = $ch;
			}
		}
		$items = array_merge( $items, $posts );
		foreach ( $items as $p ) {
			$out .= '## ' . self::line( get_the_title( $p ) ) . "\n\nKaynak: " . get_permalink( $p ) . "\nGüncelleme: " . get_the_modified_date( 'Y-m-d', $p ) . "\n\n" . self::body( $p ) . "\n\n";
		}
		return $out;
	}

	/**
	 * robots.txt additions.
	 *
	 * @param string $output Output.
	 * @param bool   $public Site is public.
	 * @return string
	 */
	public static function robots( $output, $public ) {
		if ( ! $public ) {
			return $output;
		}
		$add = '';
		if ( akilli_get_setting( 'ai_block_training' ) ) {
			$add .= "\n# Yapay zekâ model eğitimi botları (Akıllı Creative ayarı)\n";
			foreach ( self::TRAINING_BOTS as $bot ) {
				$add .= 'User-agent: ' . $bot . "\nDisallow: /\n\n";
			}
		}
		if ( akilli_get_setting( 'llms_enabled' ) ) {
			$add .= '# LLM özeti: ' . home_url( '/llms.txt' ) . "\n";
		}
		return $output . $add;
	}

	/**
	 * Service names for Organization.knowsAbout.
	 *
	 * @return string[]
	 */
	public static function knows_about() {
		$out = array();
		foreach ( akilli_get_service_tree() as $node ) {
			$out[] = self::line( get_the_title( $node['post'] ) );
			foreach ( $node['children'] as $ch ) {
				$out[] = self::line( get_the_title( $ch ) );
			}
		}
		return $out;
	}
}

foreach ( array( 'save_post', 'deleted_post', 'trashed_post' ) as $akilli_hook ) {
	add_action( $akilli_hook, array( 'Akilli_AI', 'flush' ) );
}
add_action( 'update_option_akilli_core_settings', array( 'Akilli_AI', 'flush' ) );
