<?php 
$option = shopcozi_theme_options();
$column = $option['shopcozi_service_column'];
$content = shopcozi_homepage_service_data();

if($column==1){
	$col = 12;
}elseif($column==2){
	$col = 6;
}elseif($column==3){
	$col = 4;
}else{
	$col = 3;
}

if($option['shopcozi_service_show']==true){
?>
<section id="service" class="service-section theme-py-3">
	<div class="container">

		<?php if($option['shopcozi_service_title']!=''){ ?>
		<div class="row justify-content-center text-center wow animate__animated animate__fadeInUp">
			<div class="col-12">
				<div class="section-title-container">
					<h3 class="section-title section-title-bold">
						<b></b>
						<span class="section-title-wrap"><?php echo esc_html($option['shopcozi_service_title']); ?></span>
						<b></b>
					</h3>
				</div>
			</div>
		</div>
		<?php } ?>

		<?php if($option['shopcozi_service_style']=='one'){ ?>
		<div class="row">
			<?php 
            if(!empty($content)) { 
                foreach ($content as $val) {
	                $icon = isset( $val['icon'] ) ?  $val['icon'] : '';
	                $title = isset( $val['title'] ) ?  $val['title'] : '';
	                $desc = isset( $val['desc'] ) ?  $val['desc'] : '';
	                $link = isset( $val['link'] ) ?  $val['link'] : '';
            ?>
			<div class="col-lg-<?php echo esc_attr($col); ?> col-md-6 col-12 mb-4">
				<div class="service one zoom_after">
					<div class="service-icon"><i class="<?php echo esc_attr($icon); ?>"></i></div>
					<div class="service-content">
						<?php if($title!=''){ ?>
						<span class="title">
							<?php if($link!=''){ ?>
							<a href="<?php esc_url($link); ?>">
							<?php } ?>
								<?php echo esc_html($title); ?>
							<?php if($link!=''){ ?>
							</a>
							<?php } ?>
						</span>
						<?php } ?>

						<?php if($desc!=''){ ?>
						<span class="text"><?php echo esc_html($desc); ?></span>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } } ?>
		</div>
		<?php } ?>
		
		<?php if($option['shopcozi_service_style']=='two'){ ?>
		<div class="row service_two wow animate__animated animate__fadeInUp">
			<?php 
            if(!empty($content)) { 
                foreach ($content as $val) {
	                $icon = isset( $val['icon'] ) ?  $val['icon'] : '';
	                $title = isset( $val['title'] ) ?  $val['title'] : '';
	                $desc = isset( $val['desc'] ) ?  $val['desc'] : '';
	                $link = isset( $val['link'] ) ?  $val['link'] : '';
            ?>
			<div class="col-lg-<?php echo esc_attr($col); ?> col-md-6 col-12 mb-4">
				<div class="service two">
					<div class="service-icon"><i class="<?php echo esc_attr($icon); ?>"></i></div>
					<div class="service-content">
						<?php if($title!=''){ ?>
						<h5 class="title mb-1">
							<?php if($link!=''){ ?>
							<a href="<?php esc_url($link); ?>">
							<?php } ?>
								<?php echo esc_html($title); ?>
							<?php if($link!=''){ ?>
							</a>
							<?php } ?>
						</h5>
						<?php } ?>

						<?php if($desc!=''){ ?>
						<p class="text mb-0"><?php echo esc_html($desc); ?></p>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } } ?>
		</div>
		<?php } ?>
	</div>
</section>
<?php } ?>