<?php 
global $shop2u_options;
$section_disable = get_theme_mod('shop2u_testimonial_disable',$shop2u_options['shop2u_testimonial_disable']);
$section_subtitle = get_theme_mod('shop2u_testimonial_subtitle',$shop2u_options['shop2u_testimonial_subtitle']);
$section_title = get_theme_mod('shop2u_testimonial_title',$shop2u_options['shop2u_testimonial_title']);
$section_desc = get_theme_mod('shop2u_testimonial_desc',$shop2u_options['shop2u_testimonial_desc']);
$content = shop2u_homepage_testimonial_data();

$section_header_show = false;
if(
	$section_subtitle != '' || 
	$section_title != '' || 
	$section_desc!='' ){

	$section_header_show = true;
}

if($section_disable==false){
?>
<section class="section testimonial-section">
	<div class="container">

		<?php if( $section_header_show == true ){ ?>
	 	<div class="row">
	 	 	<div class="col-lg-7 col-md-12 col-12 mx-lg-auto mb-4">
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
	 	</div>
	 	<?php } ?>

	 	<div class="owl-carousel owl-theme testimonial-carousel">
	 		<?php 
            if(!empty($content)) { 
                foreach ($content as $val) {
                    $image = shop2u_get_media_url( $val['image'] );
                    $title = isset( $val['title'] ) ?  $val['title'] : '';
                    $position = isset( $val['position'] ) ?  $val['position'] : '';
                    $desc = isset( $val['desc'] ) ?  $val['desc'] : '';
                    $rating = isset( $val['rating'] ) ?  $val['rating'] : 5;
            ?>
	 	 	<div class="item">
                <div class="testimonial-item">
                	<div class="execllent_toggol">
                	 	<div class="testi_content">
			                <?php if($title!=''){ ?>
							<h3><?php echo wp_kses_post($title); ?></h3>
							<?php } ?>
			                <?php if($position!=''){ ?>
							<span><?php echo wp_kses_post($position); ?></span>
							<?php } ?>
		                </div>
						<div class="testi_rating">
							<?php
							// Rated Loop
							for ($i=1; $i <= $rating; $i++) { 
								echo '<i class="fa fa-star"></i>';
							} 
							// Derated Loop
							$rating = 5 - $rating;
							for ($i=1; $i <= $rating; $i++) { 
								echo '<i class="fa fa-star-o"></i>';
							}
							?>
						</div>
				    </div>

				    <div class="testi_text">
			    	<?php if($desc!=''){ ?>
					<p><?php echo wp_kses_post($desc); ?></p>
					<?php } ?>							
					</div>

					<div class="testi_img">
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $title ); ?>">
					</div>
					<div class="testi_icon">
                        <div class="testi_corn"><i class="fa fa-quote-left"></i></div>
                    </div>
                </div>
	 	 	</div>
		    <?php } } ?>
	 	</div>
	</div>
</section>
<?php } ?>