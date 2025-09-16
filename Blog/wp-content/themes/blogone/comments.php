<?php 
/**
 * This template for displaying comments
 *
 */
$option = blogone_theme_options();

if( ( is_page() && $option['blogone_page_author_show'] == true ) || ( is_single() && $option['blogone_single_author_show'] == true ) ){
	blogone_author_detail();
}


blogone_page_links();

if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( 1 === $comments_number ) {
					_x( 'One comment', 'comments title', 'blogone' );
				} else {
					printf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s Comment',
						'%1$s Comments',
						$comments_number,
						'comments title',
						'blogone'
					),
					number_format_i18n( $comments_number )
				);
			}
			?>
		</h3>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 42,
				) );
			?>
		</ol>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

	<?php
		// If comments are closed and there are comments
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e('Comments are closed.', 'blogone' ); ?></p>
	<?php endif; ?>

	<?php
		comment_form( array(
			'title_reply_before' => '<h3 id="comments-title" class="comment-reply-title">',
			'title_reply_after'  => '</h3>',
		) );
	?>
</div><!-- .comments-area -->