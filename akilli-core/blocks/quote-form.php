<?php
/**
 * Block: quote form.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ak-section ak-quote"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap ak-quote__layout<?php echo $a['show_aside'] ? '' : ' ak-quote__layout--single'; ?>">
		<div class="ak-quote__main ak-panel">
			<?php akilli_section_head( $a ); ?>
			<?php echo Akilli_Forms::render( 'teklif' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php if ( $a['show_aside'] ) : ?>
			<aside class="ak-quote__aside" aria-label="Teklif süreci">
				<h2 class="ak-quote__aside-title">Formu gönderdikten sonra</h2>
				<ol class="ak-quote__steps">
					<li><strong>İnceleme</strong><span>Talebinizi okur, gerekirse örnek sitelerinizi ve rakiplerinizi inceleriz.</span></li>
					<li><strong>Kısa görüşme</strong><span>15–30 dakikalık bir görüşmeyle hedeflerinizi ve önceliklerinizi netleştiririz.</span></li>
					<li><strong>Yazılı teklif</strong><span>Kapsamı, teslim edilecekleri, takvimi ve ücreti açıkça yazan bir teklif hazırlarız.</span></li>
				</ol>
				<div class="ak-quote__direct">
					<p>Hemen konuşmak isterseniz:</p>
					<?php akilli_contact_links( 'ak-clinks--stack' ); ?>
				</div>
			</aside>
		<?php endif; ?>
	</div>
</section>
