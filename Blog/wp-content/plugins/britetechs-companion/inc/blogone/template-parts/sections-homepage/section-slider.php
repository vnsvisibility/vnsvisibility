<?php 
$option = blogone_theme_options();
$category = $option['blogone_slider_category'];
$tag = $option['blogone_slider_tag'];
$exclude_post_ids = explode(',', $option['blogone_slider_exclude_ids']);
$orderby = $option['blogone_slider_orderby'];
$order = $option['blogone_slider_order'];
$posts_per_page = $option['blogone_slider_posts_per_page'];

$args = array(
	'post_type' => 'post',
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'desc',
	'posts_per_page' => $posts_per_page,
);

if ( $category > 0 ) {
	$args['category__in'] = $category;
}

if ( $tag > 0 ) {
	$args['tag__in'] = $tag;
}

if ( $exclude_post_ids > 0 ) {
	$args['post__not_in'] = $exclude_post_ids;
}

if ( $orderby && $orderby != 'default' ) {
	$args['orderby'] = $orderby;
}

if ( $order ) {
	$args['order'] = $order;
}

// echo '<pre>';
// print_r($args);
// echo '</pre>';

$content_show = false;

if($option['blogone_slider_category_show']==true){
	$content_show = true;
}else if($option['blogone_slider_title_show']==true){
	$content_show = true;
}else if($option['blogone_slider_date_show']==true){
	$content_show = true;
}else if($option['blogone_slider_excerpt_show']==true){
	$content_show = true;
}else if($option['blogone_slider_btn_show']==true){
	$content_show = true;
}else if($option['blogone_slider_author_show']==true){
	$content_show = true;
}

$loop = new WP_Query( $args );
$theme_check = wp_get_theme();

if($option['blogone_slider_show'] == true){
	?>
	<section class="bs-section slider_section">
		<div class="container">
			<div id="blg-home-slider" class="blg-home-slider owl-carousel owl-theme blg-coman-slider" data-collg="<?php echo esc_html(($theme_check == 'Bloggly') ? 3 : 1); ?>" data-colmd="<?php echo esc_html(($theme_check == 'Bloggly') ? 2 : 1); ?>" data-colsm="1" data-colxs="1" data-itemspace="<?php echo esc_html(($theme_check == 'Bloggly') ? 40 : 0); ?>" data-loop="true" data-autoplay="<?php echo esc_html(($theme_check == 'Bloggly') ? 'false' : 'true'); ?>" data-smartspeed="<?php echo esc_attr($option['blogone_slider_speed']); ?>" data-autoplayTimeout="<?php echo esc_attr($option['blogone_slider_speed']); ?>" data-animateIn="<?php echo esc_attr($option['blogone_slider_animation_start']); ?>" data-animateOut="<?php echo esc_attr($option['blogone_slider_animation_end']); ?>" data-nav="true" data-dots="false">
				<?php 
				if ( $loop->have_posts() ) :
					while ( $loop->have_posts() ) : $loop->the_post();
						?>
						<div class="item">
							<div class="bs-slider_section">
								<div class="bs-slider_img">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail('blogone_blog_slide_thumb'); ?>
									</a>
								</div>

								<?php if($content_show==true){ ?>
									<div class="slider_content blog_content">
										<?php
										if($option['blogone_slider_category_show']==true){
											get_template_part( 'template-parts/entry/meta-category' );
										}

										if($option['blogone_slider_title_show']==true){
											get_template_part( 'template-parts/entry/entry-title' );
										}

										if($option['blogone_slider_date_show']==true){
											get_template_part( 'template-parts/entry/meta-date' );
										}

										if($option['blogone_slider_excerpt_show']==true){
											get_template_part( 'template-parts/entry/entry-slider-content' );
										}

										if($option['blogone_slider_btn_show']==true || $option['blogone_slider_author_show']==true){
											global $authordata;
											?>
											<div class="bs-blog_auther">
												<?php if($option['blogone_slider_btn_show']==true && $option['blogone_slider_readmore'] != '' ){ ?>
													<a href="<?php the_permalink(); ?>" class="bs-book_btn"><?php echo esc_html($option['blogone_slider_readmore']); ?> <span></span><span></span><span></span><span></span></a>
												<?php } ?>

												<?php if($option['blogone_slider_author_show']==true){ ?>
													<div class="bs-author">
														<a href="<?php echo esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ); ?>" class="auth">
															<?php echo get_avatar( get_the_author_meta( 'ID' ), 44 ); ?>
															<?php echo esc_html(get_the_author()); ?>
														</a>
													</div>
												<?php } ?>
											</div>
										<?php } ?>												
									</div>
								<?php } ?>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();

				endif;			
				?>
			</div>
		</div>
		<?php if($theme_check == 'Blogair'){ ?>
			<div class="body-decorations"></div>
		<?php } ?>
	</section>
	<?php } ?>