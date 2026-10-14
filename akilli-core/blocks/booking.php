<?php
/**
 * Block: meeting day picker — next N working days, each links to the quote
 * form with ?gun=YYYY-MM-DD (prefilled as "preferred meeting day").
 *
 * @package AkilliCore
 */

defined( 'ABSPATH' ) || exit;
$count = max( 3, min( 14, (int) $a['days'] ) );
$days  = array();
$ts    = current_time( 'timestamp' ); // phpcs:ignore WordPress.DateTime.CurrentTimeTimestamp.Requested
$names = array( 'Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt' );
for ( $i = 0; count( $days ) < $count && $i < 30; $i++ ) {
	$d = strtotime( '+' . $i . ' day', $ts );
	$w = (int) gmdate( 'w', $d );
	if ( 0 === $w || 6 === $w ) {
		continue;
	}
	$days[] = array(
		'iso'   => gmdate( 'Y-m-d', $d ),
		'day'   => gmdate( 'j', $d ),
		'name'  => 0 === $i ? 'Bugün' : ( 1 === $i ? 'Yarın' : $names[ $w ] ),
		'month' => wp_date( 'M', $d ),
		'label' => wp_date( 'j F l', $d ),
	);
}
$base = akilli_quote_url();
$base = strtok( $base, '#' );
?>
<section class="ak-section ak-booking"<?php echo $a['_id'] ? ' id="' . esc_attr( $a['_id'] ) . '"' : ''; ?>>
	<div class="ak-wrap">
		<?php akilli_section_head( $a, 'h2', 'ak-head--center' ); ?>
		<ol class="ak-booking__days" data-reveal>
			<?php foreach ( $days as $i => $d ) : ?>
				<li style="--i:<?php echo (int) $i; ?>">
					<a href="<?php echo esc_url( add_query_arg( 'gun', $d['iso'], $base ) . '#teklif-formu' ); ?>" aria-label="<?php echo esc_attr( $d['label'] . ' için görüşme talep et' ); ?>"<?php echo 0 === $i ? ' class="is-first"' : ''; ?>>
						<span class="ak-booking__name"><?php echo esc_html( $d['name'] ); ?></span>
						<span class="ak-booking__num"><?php echo esc_html( $d['day'] ); ?></span>
						<span class="ak-booking__month"><?php echo esc_html( $d['month'] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ol>
		<div class="ak-booking__foot">
			<?php if ( $a['note'] ) : ?>
				<p><?php echo akilli_icon( 'clock' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php echo esc_html( $a['note'] ); ?></p>
			<?php endif; ?>
			<?php akilli_contact_links(); ?>
		</div>
	</div>
</section>
