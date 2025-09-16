<?php 
global $shop2u_options;
$section_disable = get_theme_mod('shop2u_banner_disable',$shop2u_options['shop2u_banner_disable']);
$section_subtitle = get_theme_mod('shop2u_banner_subtitle',$shop2u_options['shop2u_banner_subtitle']);
$section_title = get_theme_mod('shop2u_banner_title',$shop2u_options['shop2u_banner_title']);
$section_desc = get_theme_mod('shop2u_banner_desc',$shop2u_options['shop2u_banner_desc']);
$column = 2;
$content = shop2u_homepage_banner_data();

$section_header_show = false;
if(
	$section_subtitle != '' || 
	$section_title != '' || 
	$section_desc!='' ){

	$section_header_show = true;
}

if($section_disable==false){
?>
<section class="section info-section">
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

	  	<div class="row wow fadeInUp">
	  		<?php 
	  		$column = 12 / $column;

            if(!empty($content)) { 
                foreach ($content as $val) {
                	$image = shop2u_get_media_url( $val['image'] );
	                $subtitle = isset( $val['subtitle'] ) ?  $val['subtitle'] : '';
	                $title = isset( $val['title'] ) ?  $val['title'] : '';
	                $desc = isset( $val['desc'] ) ?  $val['desc'] : '';
	                $align = isset( $val['align'] ) ?  $val['align'] : 'left';
	                $button_label = isset( $val['button_label'] ) ?  $val['button_label'] : '';
	                $button_link = isset( $val['button_link'] ) ?  $val['button_link'] : '#';
	                $button_target = isset( $val['button_target'] ) ?  $val['button_target'] : true;
            ?>
	  		<div class="col-lg-<?php echo esc_attr($column); ?> col-md-12 col-12">
	  			<div class="single_banner offer-banner">
	  				<div class="offer-banner-img">
	  					<a href="<?php echo esc_url( $button_link ); ?>">
	  						<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $title ); ?>">
	  					</a>
	  				</div>
	  				<div class="banner_content <?php echo esc_attr($align); ?>_contect">
	  					<?php if($subtitle!=''){ ?>
						<h6><?php echo wp_kses_post( $subtitle ); ?></h6>
						<?php } ?>

						<?php if($title!=''){ ?>
						<h3><a href="<?php echo esc_url( $button_link ); ?>"><?php echo wp_kses_post( $title ); ?></a></h3>
						<?php } ?>

						<?php if($desc!=''){ ?>
						<p class="wow fadeInUp"><?php echo wp_kses_post( $desc ); ?></p>
						<?php } ?>

						<?php if($button_link!=''){ ?>
						<a class="btn btn-primary main-btn wow fadeInUp" href="<?php echo esc_url( $button_link ); ?>" <?php if($button_target){ echo 'target="_blank"';} ?>><?php echo esc_html( $button_label ); ?> <i class="fa-solid fa-arrow-right-long"></i></a>
						<?php } ?>					 	
				    </div>
	  			</div>
	  		</div>
	  		<?php } } ?>
	  	</div>
	</div>
</section>
<?php } ?>