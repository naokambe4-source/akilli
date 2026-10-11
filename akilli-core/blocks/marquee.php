<?php
/**
 * Block: marquee band.
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$items = akilli_lines( $a['items'] );
if ( ! $items ) {
	return;
}
$row = function ( $hidden ) use ( $items ) {
	echo '<ul class="ak-marquee__row"' . ( $hidden ? ' aria-hidden="true"' : '' ) . '>';
	foreach ( $items as $item ) {
		echo '<li>' . esc_html( $item ) . '<span class="ak-marquee__sep" aria-hidden="true"></span></li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	echo '</ul>';
};
?>
<div class="ak-marquee"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-marquee__track">
		<?php
		$row( false );
		$row( true );
		?>
	</div>
</div>
