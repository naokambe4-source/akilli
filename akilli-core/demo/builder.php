<?php
/**
 * Helpers that turn structured demo data into Gutenberg block markup.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

if ( function_exists( 'akilli_demo_block' ) ) {
	return;
}

/**
 * Self-closing dynamic block.
 *
 * @param string $name  Block name (without namespace).
 * @param array  $attrs Attributes.
 * @return string
 */
function akilli_demo_block( $name, $attrs = array() ) {
	return get_comment_delimited_block_content( 'akilli/' . $name, $attrs, '' ) . "\n\n";
}

/**
 * Core paragraph.
 *
 * @param string $html Inline HTML.
 * @return string
 */
function akilli_demo_p( $html ) {
	return "<!-- wp:paragraph -->\n<p>" . $html . "</p>\n<!-- /wp:paragraph -->\n\n";
}

/**
 * Core heading.
 *
 * @param string $text  Text.
 * @param int    $level Level.
 * @return string
 */
function akilli_demo_h( $text, $level = 2 ) {
	$attrs = 2 === $level ? '' : ' {"level":' . (int) $level . '}';
	return '<!-- wp:heading' . $attrs . " -->\n<h" . (int) $level . ' class="wp-block-heading">' . $text . '</h' . (int) $level . ">\n<!-- /wp:heading -->\n\n";
}

/**
 * Core list.
 *
 * @param string[] $items   Items (inline HTML).
 * @param bool     $ordered Ordered.
 * @return string
 */
function akilli_demo_list( $items, $ordered = false ) {
	$tag   = $ordered ? 'ol' : 'ul';
	$attrs = $ordered ? ' {"ordered":true}' : '';
	$out   = '<!-- wp:list' . $attrs . " -->\n<" . $tag . ' class="wp-block-list">';
	foreach ( $items as $item ) {
		$out .= "<!-- wp:list-item -->\n<li>" . $item . "</li>\n<!-- /wp:list-item -->";
	}
	return $out . '</' . $tag . ">\n<!-- /wp:list -->\n\n";
}

/**
 * Pairs [title, text] → repeater items.
 *
 * @param array  $pairs Pairs.
 * @param string $a     First key.
 * @param string $b     Second key.
 * @return array
 */
function akilli_demo_pairs( $pairs, $a = 'title', $b = 'text' ) {
	$out = array();
	foreach ( (array) $pairs as $p ) {
		$out[] = array(
			$a => $p[0],
			$b => $p[1],
		);
	}
	return $out;
}

/**
 * Service detail page body.
 *
 * @param array $s Service data.
 * @return string
 */
function akilli_demo_service_blocks( $s ) {
	$out = '';
	foreach ( (array) $s['intro'] as $p ) {
		$out .= akilli_demo_p( $p );
	}
	if ( ! empty( $s['scope'] ) ) {
		$out .= akilli_demo_block(
			'features',
			array(
				'eyebrow' => 'Kapsam',
				'title'   => 'Hizmet kapsamı',
				'style'   => 'list',
				'items'   => akilli_demo_pairs( $s['scope'] ),
			)
		);
	}
	if ( ! empty( $s['for'] ) ) {
		$out .= akilli_demo_block(
			'features',
			array(
				'eyebrow' => 'Kimler için',
				'title'   => 'Kimler için uygun?',
				'style'   => 'cards',
				'items'   => akilli_demo_pairs( $s['for'] ),
			)
		);
	}
	if ( ! empty( $s['needs'] ) ) {
		$out .= akilli_demo_block(
			'features',
			array(
				'eyebrow' => 'İhtiyaçlar',
				'title'   => 'Çözdüğümüz ihtiyaçlar',
				'style'   => 'numbered',
				'items'   => akilli_demo_pairs( $s['needs'] ),
			)
		);
	}
	if ( ! empty( $s['deliver'] ) ) {
		$out .= akilli_demo_block(
			'checklist',
			array(
				'eyebrow' => 'Teslimatlar',
				'title'   => 'Teslim ettiklerimiz',
				'items'   => implode( "\n", $s['deliver'] ),
			)
		);
	}
	if ( ! empty( $s['process'] ) ) {
		$out .= akilli_demo_block(
			'process',
			array(
				'eyebrow' => 'Süreç',
				'title'   => 'Çalışma süreci',
				'text'    => 'Her adımın sonunda onayınızı alıyor, bir sonraki adıma öyle geçiyoruz.',
				'steps'   => akilli_demo_pairs( $s['process'] ),
			)
		);
	}
	if ( ! empty( $s['faq'] ) ) {
		$out .= akilli_demo_block(
			'faq',
			array(
				'eyebrow' => 'SSS',
				'title'   => 'Sık sorulan sorular',
				'items'   => akilli_demo_pairs( $s['faq'], 'q', 'a' ),
			)
		);
	}
	return $out;
}

/**
 * Service category page body.
 *
 * @param array $c Category data.
 * @return string
 */
function akilli_demo_category_blocks( $c ) {
	$out = akilli_demo_block(
		'split',
		array(
			'eyebrow' => 'Yaklaşımımız',
			'title'   => wp_strip_all_tags( $c['title'] ) . ' çalışmalarımızı nasıl ele alıyoruz?',
			'text'    => implode( "\n\n", $c['intro'] ),
		)
	);
	$out .= akilli_demo_block(
		'checklist',
		array(
			'eyebrow' => 'Standartlarımız',
			'title'   => 'Her projede ortak olanlar',
			'items'   => implode( "\n", $c['common'] ),
		)
	);
	$out .= akilli_demo_block(
		'faq',
		array(
			'eyebrow' => 'SSS',
			'title'   => 'Sık sorulan sorular',
			'items'   => akilli_demo_pairs( $c['faq'], 'q', 'a' ),
		)
	);
	return $out;
}

/**
 * Blog post body.
 *
 * @param array $content Content rows.
 * @return string
 */
function akilli_demo_post_blocks( $content ) {
	$out = '';
	foreach ( $content as $row ) {
		switch ( $row[0] ) {
			case 'h2':
				$out .= akilli_demo_h( $row[1], 2 );
				break;
			case 'h3':
				$out .= akilli_demo_h( $row[1], 3 );
				break;
			case 'ul':
				$out .= akilli_demo_list( $row[1] );
				break;
			case 'ol':
				$out .= akilli_demo_list( $row[1], true );
				break;
			default:
				$out .= akilli_demo_p( $row[1] );
		}
	}
	return $out;
}
