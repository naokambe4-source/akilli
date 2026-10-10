<?php
/**
 * Search form.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
$uid = wp_unique_id( 'ak-s-' );
?>
<form role="search" method="get" class="ak-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $uid ); ?>"><span class="screen-reader-text">Sitede ara</span>
		<input type="search" id="<?php echo esc_attr( $uid ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Hizmet, proje veya yazı arayın…" autocomplete="off">
	</label>
	<button type="submit"><?php echo akilli_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span class="screen-reader-text">Ara</span></button>
</form>
