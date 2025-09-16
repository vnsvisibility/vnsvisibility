<?php 
$option = blogone_theme_options();
$category = $option['blogone_blog_category'];
$exclude_post_ids = explode(',', $option['blogone_blog_exclude_ids']);
$orderby = $option['blogone_blog_orderby'];
$order = $option['blogone_blog_order'];
$posts_per_page = $option['blogone_blog_posts_per_page'];

if($option['blogone_blog_column']==1){
	$blog_col_class = 'col-xl-12 col-lg-12 col-md-12 col-12';
}else if($option['blogone_blog_column']==2){
	$blog_col_class = 'col-xl-6 col-lg-6 col-md-6 col-12';
}else if($option['blogone_blog_column']==3){
	$blog_col_class = 'col-xl-4 col-lg-4 col-md-4 col-12';
}

if($option['blogone_blog_show']==true){
?>
<section class="bs-section bs-blog_section">
	<div class="container">
		<div class="row bs-g-5">

			<?php 
			if($option['blogone_blog_sidebar']=='1-1-0'){
				get_sidebar('left');
			}
			?>

			<div class="col-xl-<?php if($option['blogone_blog_sidebar']=='0-1-0'){ echo '12'; }else{ echo '8'; } ?> col-lg-<?php if($option['blogone_blog_sidebar']=='0-1-0'){ echo '12'; }else{ echo '8'; } ?> col-md-12 col-12">
				<div class="row bs-g-5" <?php if($option['blogone_blog_masonary']==true){ echo 'data-masonry="{&quot;percentPosition&quot;: true }"'; } ?>>
					<?php

		            $paged  = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
		            $args = array(
		            	'post_type'      => 'post',
		            	'post_status'    => 'publish',
		            	'posts_per_page' => -1,
		            	'paged'          => $paged,
		            );

		            if($posts_per_page!=''){
		        		$args['posts_per_page'] = $posts_per_page;
		        	}

		            if (  isset($category) ) {
		                $args['category__in'] = $category;
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
		            
		            $loop = new WP_Query($args);
		            $wp_query = $loop;

		            $blog_thumb_size = 'blogone_blog_single_thumb';

					// Check if posts exist
					if ( $loop->have_posts() ) :

						// loop
						while ( $loop->have_posts() ) : $loop->the_post();
						?>
						<div class="<?php echo esc_attr($blog_col_class); ?> col-12 wow fadeInUp ">
							<div id="post-<?php the_ID(); ?>" <?php post_class('blog-post-item post-grid-layout'); ?>>

								<div class="blog-thumb blog-thumb-hover">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail($blog_thumb_size, array('class' => 'thumbnail-blog')); ?>
									</a>
									<?php the_post_thumbnail($blog_thumb_size, array('class' => 'thumbnail-blog')); ?>
								</div>

								<div class="blog_content">
									<?php 
									if($option['blogone_blog_category_show']==true){
										get_template_part('template-parts/entry/meta','category');
									}

									if($option['blogone_blog_title_show']==true){
										get_template_part('template-parts/entry/entry','title'); 
									}

									if($option['blogone_blog_date_show']==true){
										get_template_part('template-parts/entry/meta','date');
									}

									if($option['blogone_blog_excerpt_show']==true){ 
										get_template_part('template-parts/entry/entry','content');
									}
									

									if($option['blogone_blog_btn_show']==true || $option['blogone_blog_author_show']==true){
									global $authordata;
									?>
									<div class="bs-blog_auther">
										<?php if($option['blogone_blog_btn_show']==true && $option['blogone_blog_readmore'] != ''){ ?>
										<a href="<?php the_permalink(); ?>" class="bs-book_btn"><?php echo esc_html($option['blogone_blog_readmore']); ?> <span></span><span></span><span></span><span></span></a>
										<?php } ?>
										
										<?php if($option['blogone_blog_author_show']==true){ ?>
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
							</div><!-- #post-<?php the_ID(); ?> -->
						</div>
						<?php
						endwhile;

						the_posts_pagination( array(
                                'prev_text' => '<i class="fa fa-angle-double-left"></i>',
                                'next_text' => '<i class="fa fa-angle-double-right"></i>',
                            ) );

						wp_reset_postdata();
						wp_reset_query();						

					else:

						get_template_part('template-parts/entry/content','none');

					endif;
					?>
				</div>				
			</div>
			
			<?php 
			if($option['blogone_blog_sidebar']=='0-1-1'){
				get_sidebar();
			}
			?>

		</div>
	</div>
</section>
<?php } ?>