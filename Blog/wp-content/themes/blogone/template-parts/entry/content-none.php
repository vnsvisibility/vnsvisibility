<div id="post-<?php the_ID(); ?>" <?php post_class('blog-post-item post-grid-layout'); ?>>

	<?php get_template_part('template-parts/entry/media/entry','media'); ?>

	<div class="blog_content">

		<h4 class="title"><?php esc_html_e( 'No Posts Found', 'blogone' ); ?></h4>

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>
			<p><?php echo sprintf( esc_html__( 'Ready to publish your first post? %1$sGet started here%2$s.', 'blogone' ), '<a href="'. esc_url( admin_url( 'post-new.php' ) ) .'" target="_blank">', '</a>' ); ?></p>
		<?php } elseif ( is_search() ) { ?>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'blogone' ); ?></p>
		<?php } elseif ( is_category() ) { ?>
			<p><?php esc_html_e( 'There aren\'t any posts currently published in this category.', 'blogone' ); ?></p>
		<?php } elseif ( is_tax() ) { ?>
			<p><?php esc_html_e( 'There aren\'t any posts currently published under this taxonomy.', 'blogone' ); ?></p>
		<?php } elseif ( is_tag() ) { ?>
			<p><?php esc_html_e( 'There aren\'t any posts currently published under this tag.', 'blogone' ); ?></p>
		<?php } else { ?>
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'blogone' ); ?></p>
		<?php } ?>
	</div>		
</div><!-- #post-<?php the_ID(); ?> -->