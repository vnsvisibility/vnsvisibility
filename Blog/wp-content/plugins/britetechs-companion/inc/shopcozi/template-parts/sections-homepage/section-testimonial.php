<?php 
$option = shopcozi_theme_options();
$content = shopcozi_homepage_testimonial_data();

if($option['shopcozi_testimonial_slider_show']==true && $option['shopcozi_testimonial_slider_nav_show']==true && $option['shopcozi_testimonial_slider_nav_position']!='default'){
	$slider_nav = true;
}else{
	$slider_nav = false;
}

if($option['shopcozi_testimonial_slider_dots_show']==true){
	$slider_dots = true;
}else{
	$slider_dots = false;
}

if($option['shopcozi_testimonial_show']==true){
?>
<section id="testimonial" class="testimonial-section theme-py-3">
	<div class="container">
		<?php if($option['shopcozi_testimonial_title']!=''){ ?>
		<div class="row wow animate__animated animate__fadeInUp">
			<div class="col-12">
				<div class="section-title-container">
					<h3 class="section-title section-title-bold">
						<b></b>
						<span class="section-title-wrap"><?php echo esc_html($option['shopcozi_testimonial_title']); ?></span>
						<b></b>
						
						<?php if($option['shopcozi_testimonial_slider_show']==true && $option['shopcozi_testimonial_slider_nav_show']==true && $option['shopcozi_testimonial_slider_nav_position']=='default' ){ ?>
						<div class="owl-slider-nav owl-nav">
							<button type="button" role="presentation" class="owl-prev">
								<i class="fa fa-chevron-left"></i>
							</button>
							<button type="button" role="presentation" class="owl-next">
								<i class="fa fa-chevron-right"></i>
							</button>
						</div>
						<?php } ?>
					</h3>
				</div>
			</div>
		</div>
		<?php } ?>

		<div class="row justify-content-end wow animate__animated animate__fadeInUp">
			<div class="col-12">
				<?php if($option['shopcozi_testimonial_slider_show']==true){ ?>
				<div id="testimonial-slider" class="owl-carousel owl-theme" data-collg="3" data-colmd="2" data-colsm="2" data-colxs="1" data-itemspace="15" data-loop="false" data-autoplay="false" data-smartspeed="300" data-nav="<?php echo esc_attr($slider_nav); ?>" data-dots="<?php echo esc_attr($slider_dots); ?>">
				<?php }else{ ?>
				<div class="row g-3">
				<?php } ?>

					<?php 
		            if(!empty($content)) { 
		                foreach ($content as $val) {
			                $image = shopcozi_get_media_url( $val['image'] );
			                $title = isset( $val['title'] ) ?  $val['title'] : '';
			                $designation = isset( $val['designation'] ) ?  $val['designation'] : '';
			                $desc = isset( $val['desc'] ) ?  $val['desc'] : '';
			                $link = isset( $val['link'] ) ?  $val['link'] : '';
		            ?>
					
					<?php if($option['shopcozi_testimonial_slider_show']==true){ ?>
		            <div class="item">
					<?php } else { ?>
					<div class="col-lg-4 col-md-6 col-12">
					<?php } ?>

						<div class="testimonial one">
							<div class="testimonial-content">
								<p class="testimonial-text text-left">
									<span class="testimonial-icon"><i class="fa-solid fa-quote-left"></i></span>
									<?php echo wp_kses_post( $desc ); ?>											
								</p>
								<div class="testimonial-action">
									<?php if($image!=''){ ?>
									<figure class="testimonial-img">
										<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $title ); ?>">
									</figure>
									<?php } ?>

									<aside class="testimonial-info">
										<?php if($title!=''){ ?>
										<span class="testimonial-title">
											<?php if($link!=''){ ?>
											<a href="<?php echo esc_url( $link ); ?>">
											<?php } ?>
												<?php echo wp_kses_post( $title ); ?>
											<?php if($link!=''){ ?>
											</a>
											<?php } ?>
										</span>
										<?php } ?>

										<?php if($designation!=''){ ?>
										<span class="testimonial-pos"><?php echo wp_kses_post( $designation ); ?></span>
										<?php } ?>
									</aside>
								</div>										
							</div>
						</div>
					</div>
					<?php } } ?>
				
				<?php if($option['shopcozi_testimonial_slider_show']==true){ ?>
				</div>
				<?php }else{ ?>
				</div>
				<?php } ?>							
			</div>			
		</div>
	</div>
</section>
<?php } ?>