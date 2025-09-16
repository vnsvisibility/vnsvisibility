<?php
$option = blogone_theme_options();
$orderby = $option['blogone_category_orderby'];
$order = $option['blogone_category_order'];
$hide_empty = isset($option['blogone_category_hide_empty']) && $option['blogone_category_hide_empty'] == true ? 1 : 0 ;
$style = $option['blogone_category_style'];
$theme_check = wp_get_theme();

$args = array(
    'taxonomy'   => 'category',
    'hide_empty'   => $hide_empty,
);

if ( $orderby && $orderby != '' ) {
	$args['orderby'] = $orderby;
}

if ( $order != '' ) {
	$args['order'] = $order;
}

$row_class = 'row bs-g-5';
$col_class = 'col-xl-3 col-lg-3 col-md-6 col-12';

if( $style != 'grid' ){
	$row_class = 'row';
	$col_class = 'item';
}

if($option['blogone_category_show']==true){
?>
<section class="bs-categories_section pb-5">
	<div class="container">

		<?php if( $style == 'grid' ){ ?>
		<div class="<?php echo esc_attr($row_class); ?>">
		<?php } ?>

			<?php if( $style == 'slider' ){ ?>
			<div id="category-slider" class="blg-coman-slider category-slider owl-carousel owl-theme owl-loaded owl-drag" data-collg="<?php echo esc_html(($theme_check == 'Bloggly') ? 6 : 4); ?>" data-colmd="<?php echo esc_html(($theme_check == 'Bloggly') ? 6 : 3); ?>" data-colsm="<?php echo esc_html(($theme_check == 'Bloggly') ? 4 : 1); ?>" data-colxs="<?php echo esc_html(($theme_check == 'Bloggly') ? 2 : 1); ?>" data-itemspace="30" data-loop="false" data-autoplay="false" data-smartspeed="1200" data-nav="true" data-dots="false">
			<?php 
			}
	        $post_categories = get_terms( $args );
	        $count = count($post_categories);
	        if ( $count > 0 ){
	            foreach ( $post_categories as $post_category ) {

	            $thumbnail_id = get_term_meta( $post_category->term_id, 'thumbnail_id', true );
	            $image = wp_get_attachment_url( $thumbnail_id );
	            if($image==''){
	            	$image = blogone_placeholder_img_src();
	            }
	        ?>
			<div class="<?php echo esc_attr($col_class); ?>">
				<div class="bs-categories_item">
					<div class="bs-categories_img">
						<a href="<?php echo esc_url( get_category_link( $post_category->term_id ) ); ?>">
							<img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($post_category->name); ?>">
						</a>
					</div>

					<?php if( $option['blogone_categirt_title_show'] == true ){ ?>
					<div class="bs-blog-category">
						<a href="<?php echo esc_url( get_category_link( $post_category->term_id ) ); ?>" class="blogarise-categories"><?php echo esc_html($post_category->name); ?></a>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php } } ?>

			<?php if( $style == 'slider' ){ ?>
			</div>
			<?php } ?>

		<?php if( $style == 'grid' ){ ?>
		</div><!-- .row -->
		<?php } ?>
	</div>
</section>
<?php } ?>