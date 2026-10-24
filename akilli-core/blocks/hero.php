<?php
/**
 * Block: hero — bold headline, proof chips and floating cards.
 * Variables: $a (attributes).
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;

$words  = akilli_lines( $a['words'] );
$title  = (string) $a['title'];
$visual = in_array( $a['visual'], array( 'agency', 'poster', 'cards', 'gl', 'image', 'none' ), true ) ? $a['visual'] : 'agency';
if ( 'gl' === $visual ) {
	wp_enqueue_script( 'akilli-hero-gl' );
}
$rotator = '';
if ( $words && false !== strpos( $title, '{kelime}' ) ) {
	$rotator = '<span class="ak-rotator" data-ak-rotator data-words="' . esc_attr( wp_json_encode( $words ) ) . '" aria-hidden="true"><span class="ak-rotator__word">' . esc_html( $words[0] ) . '</span></span><span class="screen-reader-text">' . esc_html( implode( ', ', $words ) ) . '</span>';
}
$title_html = str_replace( '{kelime}', $rotator, wp_kses( $title, akilli_inline_kses() ) );
$chips      = akilli_lines( $a['chips'] );
$cards      = array_values(
	array_filter(
		(array) $a['cards'],
		function ( $c ) {
			return ! empty( $c['image'] ) || ! empty( $c['title'] );
		}
	)
);
$positions  = array( 'tl', 'bl', 'tr', 'br', 'ml', 'mr' );
?>
<section class="ak-hero ak-hero--<?php echo esc_attr( $visual ); ?>"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?> data-ak-hero>
	<div class="ak-hero__glow" aria-hidden="true"></div>

	<?php
	if ( 'agency' === $visual ) :
		$orbit_icons = array(
			array( 'growth', 'SEO' ),
			array( 'megaphone', 'Reklam' ),
			array( 'cart', 'E-ticaret' ),
			array( 'spark', 'Yapay zekâ' ),
			array( 'instagram', 'Sosyal medya' ),
			array( 'web', 'Web' ),
			array( 'figma', 'Tasarım' ),
			array( 'code', 'Yazılım' ),
		);
		$platforms   = akilli_lines( $a['platforms'] );
		?>
		<div class="ak-wrap ak-agency">
			<div class="ak-agency__copy">
				<?php if ( $a['eyebrow'] ) : ?>
					<p class="ak-agency__kicker"><?php echo esc_html( $a['eyebrow'] ); ?></p>
				<?php endif; ?>
				<h1 class="ak-hero__title ak-agency__title" data-ak-split><?php echo $title_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- kses above. ?></h1>
				<?php if ( $a['text'] ) : ?>
					<p class="ak-agency__text"><?php akilli_inline( $a['text'] ); ?></p>
				<?php endif; ?>
				<div class="ak-hero__actions">
					<?php
					echo akilli_button( $a['btn1_text'], $a['btn1_url'], 'primary' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo akilli_button( $a['btn2_text'], $a['btn2_url'], 'ghost' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
				<?php if ( ! empty( $a['analysis'] ) ) : ?>
					<form class="ak-analyze" action="<?php echo esc_url( strtok( akilli_quote_url(), '#' ) ); ?>" method="get">
						<p class="ak-analyze__label" id="ak-analyze-label">Sitenizi ücretsiz inceleyelim</p>
						<div class="ak-analyze__row">
							<label class="screen-reader-text" for="ak-analyze-site">Web sitenizin adresi</label>
							<input id="ak-analyze-site" type="text" name="site" inputmode="url" autocomplete="url" placeholder="siteniz.com" maxlength="190" aria-describedby="ak-analyze-label">
							<button type="submit" class="ak-btn ak-btn--dark"><span class="ak-btn__label">Ücretsiz analiz</span><?php echo akilli_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
						</div>
						<p class="ak-analyze__hint">Siteniz yok mu? <a href="<?php echo esc_url( akilli_quote_url() ); ?>">Kurulum teklifi alın</a></p>
					</form>
				<?php endif; ?>
				<?php if ( $chips ) : ?>
					<ul class="ak-agency__chips">
						<?php foreach ( $chips as $chip ) : ?>
							<li><?php echo akilli_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $chip ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<?php
			$shots = array_values( array_filter( wp_list_pluck( $cards, 'image' ) ) );
			?>
			<div class="ak-agency__visual<?php echo $shots ? ' has-collage' : ''; ?>" aria-hidden="true" data-ak-stage>
				<?php if ( $shots ) : ?>
					<div class="ak-collage">
						<?php
						for ( $col = 0; $col < 3; $col++ ) :
							$off = ( $col * 2 ) % count( $shots );
							$set = array_merge( array_slice( $shots, $off ), array_slice( $shots, 0, $off ) );
							?>
							<div class="ak-collage__col ak-collage__col--<?php echo (int) $col; ?>">
								<div class="ak-collage__track">
									<?php
									foreach ( array_merge( $set, $set ) as $sid ) {
										echo '<figure class="ak-collage__shot">' . wp_get_attachment_image( (int) $sid, 'medium_large', false, array( 'alt' => '', 'loading' => 'lazy', 'sizes' => '200px' ) ) . '</figure>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									}
									?>
								</div>
							</div>
						<?php endfor; ?>
					</div>
					<div class="ak-badge360">
						<svg class="ak-badge360__text" viewBox="0 0 200 200"><defs><path id="ak360p" d="M100,100 m-78,0 a78,78 0 1,1 156,0 a78,78 0 1,1 -156,0"/></defs><text><textPath href="#ak360p">360° KREATİF AJANS • AKILLI CREATIVE • </textPath></text></svg>
						<span class="ak-badge360__core"><?php akilli_orbit_mark( 'ak-badge360__mark' ); ?></span>
					</div>
				<?php else : ?>
				<div class="ak-system">
					<span class="ak-system__ring ak-system__ring--1"></span>
					<span class="ak-system__ring ak-system__ring--2"></span>
					<span class="ak-system__ring ak-system__ring--3"></span>
					<span class="ak-system__beam"></span>
					<div class="ak-system__core"><?php akilli_orbit_mark( 'ak-system__mark' ); ?></div>
					<ul class="ak-system__nodes">
						<?php foreach ( $orbit_icons as $i => $node ) : ?>
							<li style="--a:<?php echo (int) ( $i * 45 ); ?>deg"><span><?php echo akilli_icon( $node[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><em><?php echo esc_html( $node[1] ); ?></em></span></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>
				<div class="ak-uicard ak-uicard--audit">
					<strong>Site analizi</strong>
					<ul>
						<li><span>Mobil hız</span><i class="is-ok"></i></li>
						<li><span>Teknik SEO</span><i class="is-ok"></i></li>
						<li><span>Yapay zekâ görünürlüğü</span><i class="is-warn"></i></li>
					</ul>
				</div>
				<div class="ak-uicard ak-uicard--lead">
					<span class="ak-uicard__dot"><?php echo akilli_icon( 'mail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span><strong>Yeni teklif talebi</strong><small>Kurumsal web sitesi</small></span>
				</div>
			</div>
		</div>
		<?php if ( $platforms ) : ?>
			<div class="ak-wrap ak-platforms">
				<p>Çalıştığımız altyapılar</p>
				<ul>
					<?php foreach ( $platforms as $pl ) : ?>
						<li><?php echo esc_html( $pl ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( 'poster' === $visual ) : ?>
		<div class="ak-wrap ak-poster">
			<div class="ak-poster__copy">
				<?php if ( $a['eyebrow'] ) : ?>
					<p class="ak-hero__badge"><span class="ak-pulse" aria-hidden="true"></span><?php echo esc_html( $a['eyebrow'] ); ?></p>
				<?php endif; ?>
				<h1 class="ak-hero__title ak-poster__title" data-ak-split><?php echo $title_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- kses above. ?></h1>
				<?php if ( $a['text'] ) : ?>
					<p class="ak-hero__text ak-poster__text"><?php akilli_inline( $a['text'] ); ?></p>
				<?php endif; ?>
			</div>
			<div class="ak-poster__stage" aria-hidden="true" data-ak-stage>
				<?php akilli_orbit_mark( 'ak-poster__orbit' ); ?>
				<div class="ak-device ak-device--laptop">
					<div class="ak-device__screen">
						<?php
						if ( $a['image'] ) {
							echo wp_get_attachment_image( (int) $a['image'], 'large', false, array( 'loading' => 'eager', 'fetchpriority' => 'high', 'alt' => '', 'sizes' => '(max-width:900px) 80vw, 560px' ) );
						}
						?>
					</div>
					<div class="ak-device__base"></div>
				</div>
				<div class="ak-device ak-device--phone">
					<div class="ak-device__screen">
						<?php
						if ( $a['image_mobile'] ) {
							echo wp_get_attachment_image( (int) $a['image_mobile'], 'medium_large', false, array( 'loading' => 'eager', 'alt' => '', 'sizes' => '180px' ) );
						}
						?>
					</div>
				</div>
			</div>
			<div class="ak-poster__foot">
				<?php if ( $chips ) : ?>
					<ul class="ak-poster__chips">
						<?php foreach ( $chips as $chip ) : ?>
							<li><span class="ak-poster__check"><?php echo akilli_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span><?php echo esc_html( $chip ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<div class="ak-hero__actions">
					<?php
					echo akilli_button( $a['btn1_text'], $a['btn1_url'], 'primary ak-btn--xl' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo akilli_button( $a['btn2_text'], $a['btn2_url'], 'ghost', 'arrow-down' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
				<?php
				$wa = akilli_whatsapp_url();
				if ( ! empty( $a['show_whatsapp'] ) && $wa ) :
					?>
					<p class="ak-poster__wa"><a href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener"><?php echo akilli_icon( 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>WhatsApp: <strong><?php echo esc_html( akilli_get_setting( 'whatsapp' ) ); ?></strong></a></p>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( 'cards' === $visual && $cards ) : ?>
		<div class="ak-hero__cards" aria-hidden="true">
			<?php foreach ( array_slice( $cards, 0, 6 ) as $i => $c ) : ?>
				<div class="ak-fcard ak-fcard--<?php echo esc_attr( $positions[ $i ] ); ?>" style="--d:<?php echo esc_attr( ( $i % 2 ? -1 : 1 ) * ( 14 + $i * 6 ) ); ?>px;--t:<?php echo esc_attr( 5 + $i ); ?>s;--r:<?php echo esc_attr( $i % 2 ? 4 : -4 ); ?>deg" data-ak-float>
					<?php if ( ! empty( $c['image'] ) ) : ?>
						<div class="ak-fcard__img"><?php echo wp_get_attachment_image( (int) $c['image'], 'medium_large', false, array( 'loading' => 0 === $i ? 'eager' : 'lazy', 'alt' => '', 'sizes' => '240px' ) ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $c['title'] ) || ! empty( $c['text'] ) ) : ?>
						<div class="ak-fcard__cap">
							<?php if ( ! empty( $c['title'] ) ) : ?>
								<strong><?php echo esc_html( $c['title'] ); ?></strong>
							<?php endif; ?>
							<?php if ( ! empty( $c['text'] ) ) : ?>
								<span><?php echo esc_html( $c['text'] ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( ! in_array( $visual, array( 'poster', 'agency' ), true ) ) : ?>
	<div class="ak-wrap ak-hero__head">
		<?php if ( $a['eyebrow'] ) : ?>
			<p class="ak-hero__badge"><span class="ak-pulse" aria-hidden="true"></span><?php echo esc_html( $a['eyebrow'] ); ?></p>
		<?php endif; ?>
		<h1 class="ak-hero__title" data-ak-split><?php echo $title_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- kses above. ?></h1>
		<?php if ( $a['text'] ) : ?>
			<p class="ak-hero__text"><?php akilli_inline( $a['text'] ); ?></p>
		<?php endif; ?>
		<div class="ak-hero__actions">
			<?php
			echo akilli_button( $a['btn1_text'], $a['btn1_url'], 'primary' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo akilli_button( $a['btn2_text'], $a['btn2_url'], 'ghost', 'arrow-down' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</div>
		<?php if ( $chips ) : ?>
			<ul class="ak-hero__chips">
				<?php foreach ( $chips as $chip ) : ?>
					<li><?php echo akilli_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $chip ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

	<?php endif; ?>

	<?php if ( in_array( $visual, array( 'gl', 'image' ), true ) ) : ?>
		<figure class="ak-hero__plate" data-ak-plate>
			<div class="ak-hero__visual" aria-hidden="true">
				<?php
				if ( $a['image'] ) {
					echo wp_get_attachment_image( (int) $a['image'], 'full', false, array( 'class' => 'ak-hero__img', 'loading' => 'eager', 'fetchpriority' => 'high', 'sizes' => '100vw', 'alt' => '' ) );
				}
				if ( 'gl' === $visual ) {
					echo '<canvas class="ak-hero__gl" data-ak-gl></canvas>';
				}
				?>
			</div>
		</figure>
	<?php endif; ?>

	<?php
	if ( $a['show_services'] ) :
		$tree = akilli_get_service_tree();
		if ( $tree ) :
			?>
			<nav class="ak-wrap ak-hero__services" aria-label="Hizmet disiplinleri">
				<ul>
					<?php
					foreach ( $tree as $node ) :
						$p    = $node['post'];
						$icon = get_post_meta( $p->ID, '_ak_icon', true );
						?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $p ) ); ?>">
								<span class="ak-hero__svc-icon" aria-hidden="true"><?php echo akilli_icon( $icon ? $icon : 'spark' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
								<span class="ak-hero__svc-name"><?php echo esc_html( get_the_title( $p ) ); ?></span>
								<span class="ak-hero__svc-count"><?php echo esc_html( count( $node['children'] ) . ' hizmet' ); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
			<?php
		endif;
	endif;
	?>
</section>
