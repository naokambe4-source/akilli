<?php
/**
 * Comments.
 *
 * @package AkilliCreative
 */

defined( 'ABSPATH' ) || exit;
if ( post_password_required() ) {
	return;
}
?>
<section class="ak-comments" id="yorumlar" aria-label="Yorumlar">
	<?php if ( have_comments() ) : ?>
		<h2><?php echo esc_html( sprintf( '%d yorum', get_comments_number() ) ); ?></h2>
		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 40,
				)
			);
			?>
		</ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>
	<?php
	comment_form(
		array(
			'title_reply'   => 'Yorum yazın',
			'label_submit'  => 'Yorumu gönder',
			'comment_notes_before' => '<p>E-posta adresiniz yayımlanmayacak.</p>',
		)
	);
	?>
</section>
