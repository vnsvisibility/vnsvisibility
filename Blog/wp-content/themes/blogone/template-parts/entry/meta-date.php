<div class="bs-blog_meta">
	<span class="bs-date blog_meta-title">
		<i class="fas fa-calendar-alt"></i>
		<a href="<?php echo esc_url( get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')));  ?>"><?php the_time( get_option('date_format') ); ?></a>
	</span>
	<span class="bs-time blog_meta-title">
		<i class="fas fa-comment"></i>
		<?php
		printf(
			/* translators: 1: number of comments, 2: post title */
			_nx(
				'<a href="%2$s#respond"><time>%1$s Comment</time></a>',
				'<a href="%2$s#respond"><time>%1$s Comments</time></a>',
				get_comments_number(),
				'Posts meta comment',
				'blogone'
			),
			number_format_i18n( get_comments_number() ),
			esc_url(get_the_permalink())
		);
   		?>
	</span>
</div>