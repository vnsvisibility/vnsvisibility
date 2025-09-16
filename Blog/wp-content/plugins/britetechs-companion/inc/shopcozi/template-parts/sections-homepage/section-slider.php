<?php 
$option = shopcozi_theme_options();
$slides = shopcozi_homepage_slider_data();
$right_texts = shopcozi_homepage_slider_r_content_data();

$container_class = 'container';
$container_width = $option['shopcozi_slider_container_width'];
if($container_width=='container-fluid'){
	$container_class = 'container-fluid g-0';
}

if($option['shopcozi_slider_show']==true){
?>
<section id="slider" class="slider-section">
	<div class="<?php echo esc_attr($container_class); ?>">
		<div class="row">
			<div class="col-lg-<?php if($option['shopcozi_slider_r_content_show']==true){ echo '9'; }else{ echo '12'; } ?> col-md-12 col-12">
				<div id="main-slider" class="owl-carousel owl-theme" data-collg="1" data-colmd="1" data-colsm="1" data-colxs="1" data-itemspace="0" data-loop="false" data-autoplay="true" data-smartspeed="800" data-nav="true" data-dots="true">
					<?php 
                    if(!empty($slides)) { 
                        foreach ($slides as $val) {
                        	$image = shopcozi_get_media_url( $val['image'] );
			                $bg_overlay = isset( $val['bg_overlay'] ) ?  $val['bg_overlay'] : '';
			                $subtitle = isset( $val['subtitle'] ) ?  $val['subtitle'] : '';
			                $subtitle_color = isset( $val['subtitle_color'] ) ?  $val['subtitle_color'] : 'ffffff';
			                $title = isset( $val['title'] ) ?  $val['title'] : '';
			                $title_color = isset( $val['title_color'] ) ?  $val['title_color'] : 'ffffff';
			                $desc = isset( $val['desc'] ) ?  $val['desc'] : '';
			                $desc_color = isset( $val['desc_color'] ) ?  $val['desc_color'] : 'ffffff';
			                $align = isset( $val['align'] ) ?  $val['align'] : 'start';
			                $button1_label = isset( $val['button1_label'] ) ?  $val['button1_label'] : '';
			                $button1_link = isset( $val['button1_link'] ) ?  $val['button1_link'] : '';
			                $button1_target = isset( $val['button1_target'] ) ?  $val['button1_target'] : '';
			                $right_image = shopcozi_get_media_url( $val['right_image'] );

			                if($bg_overlay!=''){
			                	$subtitle_color = $title_color = $desc_color = 'ffffff';
			                }
                    ?>
					<div class="slide item">

						<?php if($image!=''){ ?>
						<img class="slide-img" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $title ); ?>">
						<?php } ?>

						<div class="slider-content one" <?php if($bg_overlay!=''){ echo 'style="background-color:'.esc_attr($bg_overlay).';"'; } ?>>
							<div class="container">
								<div class="row align-items-center justify-content-<?php echo esc_attr($align); ?>">
									<div class="<?php if($right_image!=''){ echo 'col-lg-7 col-md-7'; } ?> col-12 my-auto text-<?php echo esc_attr($align); ?>">

										<?php if($subtitle!=''){ ?>
										<h6 class="subtitle">
											<span
												<?php 
												if($subtitle_color!=''){
													echo 'style="color:#'.esc_attr($subtitle_color).'; border-color:#'.esc_attr($subtitle_color).';"';
												}
												?>
											><?php echo wp_kses_post( $subtitle ); ?></span>
										</h6>
										<?php } ?>

										<?php if($title!=''){ ?>
										<h2 class="title"
											<?php 
												if($title_color!=''){
													echo 'style="color:#'.esc_attr($title_color).';"';
												}
												?>
										><?php echo wp_kses_post( $title ); ?></h2>
										<?php } ?>

										<?php if($desc!=''){ ?>
										<p class="desc"
											<?php 
												if($desc_color!=''){
													echo 'style="color:#'.esc_attr($desc_color).';"';
												}
												?>
										><?php echo wp_kses_post( $desc ); ?></p>
										<?php } ?>

										<?php if($button1_link!=''){ ?>
										<a class="btn btn-primary btn-lg mt-2" href="<?php echo esc_url( $button1_link ); ?>" <?php if($button1_target){ echo 'target="_blank"';} ?>><?php echo esc_html( $button1_label ); ?> <i class="fa-solid fa-arrow-right-long"></i></a>
										<?php } ?>
									</div>

									<?php if($right_image!=''){ ?>
									<div class="col-lg-5 col-md-5 col-12 mb-av-0 mx-auto my-auto">
										<div class="slide-right-img">
											<img src="<?php echo esc_url($right_image); ?>" alt="<?php echo esc_attr($title); ?>">
										</div>
									</div>
									<?php } ?>								
								</div>
							</div>						
						</div>
					</div>
					<?php } } ?>
				</div>
			</div>

			<?php if($option['shopcozi_slider_r_content_show']==true){ ?>
			<div class="col-lg-3 col-md-12 col-12 pt-lg-0 pt-md-4 pt-4">
				<div class="row gy-4">
					<?php 
                    if(!empty($right_texts)) { 
                        foreach ($right_texts as $val) {
                        	$image = shopcozi_get_media_url( $val['image'] );
			                $title = isset( $val['title'] ) ?  $val['title'] : '';
			                $desc = isset( $val['desc'] ) ?  $val['desc'] : '';
			                $align = isset( $val['align'] ) ?  $val['align'] : 'start';
			                $button_label = isset( $val['button_label'] ) ?  $val['button_label'] : '';
			                $button_link = isset( $val['button_link'] ) ?  $val['button_link'] : '';
			                $button_target = isset( $val['button_target'] ) ?  $val['button_target'] : '';
                    ?>
					<div class="col-lg-12 col-md-6 col-12">
						<div class="slider-info">
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $title ); ?>">
							<div class="slider-info-area justify-content-<?php echo esc_attr($align); ?>">
								<div class="slider-info-content text-<?php echo esc_attr($align); ?>">
									<?php if($title!=''){ ?>
									<h5 class="slider-info-title"><?php echo wp_kses_post( $title ); ?></h5>
									<?php } ?>
									<?php if($desc!=''){ ?>
									<p class="slider-info-text m-0"><?php echo wp_kses_post( $desc ); ?></p>
									<?php } ?>
									<?php if($button_link!=''){ ?>
									<a class="button primary is-small is-rounded mt-2" href="<?php echo esc_url( $button_link ); ?>" <?php if($button_target){ echo 'target="_blank"';} ?>><?php echo esc_html( $button_label ); ?> <i class="fa-solid fa-arrow-right-long"></i></a>
									<?php } ?>									
								</div>
							</div>
						</div>
					</div>
					<?php } } ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>	
</section>
<?php } ?>