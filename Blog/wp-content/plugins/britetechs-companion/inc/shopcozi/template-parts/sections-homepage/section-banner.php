<?php 
$option = shopcozi_theme_options();
$content = shopcozi_homepage_banner_data();

if($option['shopcozi_banner_slider_show']==true && $option['shopcozi_banner_slider_nav_show']==true && $option['shopcozi_banner_slider_nav_position']!='default'){
	$slider_nav = true;
}else{
	$slider_nav = false;
}

if($option['shopcozi_banner_slider_dots_show']==true){
	$slider_dots = true;
}else{
	$slider_dots = false;
}

if($option['shopcozi_banner_show']==true){
?>
<section id="banner" class="banner-section theme-py-3">
	<div class="container">
		<?php if($option['shopcozi_banner_title']!=''){ ?>
		<div class="row wow animate__animated animate__fadeInUp">
			<div class="col-12">
				<div class="section-title-container">
					<h4 class="section-title section-title-bold"><b></b>
						<span class="section-title-wrap"><?php echo esc_html($option['shopcozi_banner_title']); ?></span>
						<b></b>

						<?php if($option['shopcozi_banner_slider_show']==true && $option['shopcozi_banner_slider_nav_show']==true && $option['shopcozi_banner_slider_nav_position']=='default'){ ?>
						<div class="owl-slider-nav owl-nav">
							<button type="button" role="presentation" class="owl-prev">
								<i class="fa fa-chevron-left"></i>
							</button>
							<button type="button" role="presentation" class="owl-next">
								<i class="fa fa-chevron-right"></i>
							</button>
						</div>
						<?php } ?>
					</h4>
				</div>
			</div>
		</div>
		<?php } ?>

		<div class="row justify-content-center wow animate__animated animate__fadeInUp">
			<div class="col-12">
				<?php if($option['shopcozi_banner_slider_show']==true){ ?>
				<div id="banner-slider" class="owl-carousel owl-theme" data-collg="2" data-colmd="2" data-colsm="2" data-colxs="1" data-itemspace="15" data-loop="false" data-autoplay="false" data-smartspeed="800" data-nav="<?php echo esc_attr($slider_nav); ?>" data-dots="<?php echo esc_attr($slider_dots); ?>">
				<?php }else{ ?>
				<div class="row g-3">
				<?php } ?>

					<?php 
		            if(!empty($content)) { 
		                foreach ($content as $val) {
			                $image = shopcozi_get_media_url( $val['image'] );
			                $subtitle = isset( $val['subtitle'] ) ?  $val['subtitle'] : '';
			                $title = isset( $val['title'] ) ?  $val['title'] : '';
			                $desc = isset( $val['desc'] ) ?  $val['desc'] : '';
			                $button_label = isset( $val['button_label'] ) ?  $val['button_label'] : '';
			                $button_link = isset( $val['button_link'] ) ?  $val['button_link'] : '';
			                $button_target = isset( $val['button_target'] ) ?  $val['button_target'] : false;
		            ?>

		            <?php if($option['shopcozi_banner_slider_show']==true){ ?>
		            <div class="item">
					<?php } else { ?>
					<div class="col-lg-6 col-md-6 col-12">
					<?php } ?>
						<div class="banner one">
							<?php if($image!=''){ ?>
							<div class="banner-img">
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $title ); ?>">
							</div>
							<?php } ?>
							<div class="banner-content">
								<?php if($subtitle!=''){ ?>
								<span><?php echo wp_kses_post( $subtitle ); ?></span>
								<?php } ?>

								<?php if($title!=''){ ?>
								<h4><?php echo wp_kses_post( $title ); ?></h4>
								<?php } ?>

								<?php if($desc!=''){ ?>
								<p><?php echo wp_kses_post( $desc ); ?></p>
								<?php } ?>

								<?php if($button_link!=''){ ?>
								<a class="button secondary btn-small is-rounded" href="<?php echo esc_url( $button_link ); ?>" <?php if($button_target){ echo 'target="_blank"';} ?>><?php echo wp_kses_post( $button_label ); ?> <i class="fa-solid fa-arrow-right-long"></i></a>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php } } ?>

				<?php if($option['shopcozi_banner_slider_show']==true){ ?>
				</div>
				<?php }else{ ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
<?php } ?>