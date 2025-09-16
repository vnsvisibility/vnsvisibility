<?php 
global $shop2u_options;
$section_disable = get_theme_mod('shop2u_prod_recent_disable',$shop2u_options['shop2u_prod_recent_disable']);
$section_subtitle = get_theme_mod('shop2u_prod_recent_subtitle',$shop2u_options['shop2u_prod_recent_subtitle']);
$section_title = get_theme_mod('shop2u_prod_recent_title',$shop2u_options['shop2u_prod_recent_title']);
$section_desc = get_theme_mod('shop2u_prod_recent_desc',$shop2u_options['shop2u_prod_recent_desc']);
$posts_per_page = get_theme_mod('shop2u_prod_recent_posts_per_page',$shop2u_options['shop2u_prod_recent_posts_per_page']);

$section_header_show = false;
if(
	$section_subtitle != '' || 
	$section_title != '' || 
	$section_desc!='' ){

	$section_header_show = true;
}

if(class_exists( 'woocommerce' ) && $section_disable==false){

	$args = array(
	    'post_type'      => 'product',
	    'post_status'    => 'publish',
	    'orderby'        => 'date',
	    'order'          => 'desc',
	    'meta_query' => array(),
		'tax_query' => array(
			'relation' => 'AND',
		),
	);

	if($posts_per_page!=''){
		$args['posts_per_page'] = $posts_per_page;
	}else{
		$args['posts_per_page'] = -1;
	}

	$loop = new WP_Query($args);
?>
<section id="recent_products" class="section product-section bg-primary-light woocommerce">
    <div class="container">
        <div class="row">

        	<?php if( $section_header_show == true ){ ?>
			<div class="col-lg-7 col-md-12 col-12 mx-lg-auto mb-3">
				<div class="sp-theme-heading text-center wow fadeInUp">
					<?php if($section_subtitle!=''){ ?>
					<span class="badge"><?php echo wp_kses_post($section_subtitle); ?></span>
					<?php } ?>

					<?php if($section_title!=''){ ?>
					<h2><?php echo wp_kses_post($section_title); ?></h2>
					<?php } ?>

					<?php if($section_desc!=''){ ?>
					<p><?php echo wp_kses_post($section_desc); ?></p>
					<?php } ?>
				</div>
			</div>
			<?php } ?>

			<?php
			$post_ids = get_posts(
			    array(
			        'post_type' => 'product',
			        'post_status'    => 'publish',
			        'posts_per_page' => $args['posts_per_page'],
			        'meta_query' => array(),
					'tax_query' => array(
						'relation' => 'AND',
					),
			        'fields' => 'ids',
			    )
			);

	        $product_categories = get_terms( 
		        						array(
									        'taxonomy' => 'product_cat',
									        'object_ids' => $post_ids,
									        'hide_empty' => true,
									    )
	        						);

	        $count = count($product_categories);
	        if ( $count > 0 ){
	        ?>
			<div class="col-lg-8 ol-md-8 col-12 mx-lg-auto d-flex justify-content-center mb-4">
	            <ul class="product-filters wow fadeInUp">
	            	<li data-filter="*" class="filter-active"><?php esc_html_e('All','shop2u'); ?></li>
	            	<?php 
	            	foreach ( $product_categories as $product_category ){
	            	?>
	              	<li data-filter=".<?php echo esc_attr($product_category->slug); ?>">
	              		<?php  echo esc_html($product_category->name); ?>
	              	</li>
	              	<?php } ?>
	            </ul>
            </div>
        	<?php } ?>
		</div>

        <div class="row products">
        	<?php
        	if ( $loop->have_posts() ) :
        		while ( $loop->have_posts() ) : $loop->the_post(); 
				global $product;
        	?>
	        <?php wc_get_template_part('content', 'product-recent'); ?>
	    	<?php endwhile; wp_reset_postdata(); ?>
	    	<?php endif; ?>
        </div>
    </div>
</section>
<?php } ?>