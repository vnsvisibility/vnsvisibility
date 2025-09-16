<?php 
global $shop2u_options;
$section_disable = get_theme_mod('shop2u_slider_disable',$shop2u_options['shop2u_slider_disable']);
$slider_left_disable = get_theme_mod('shop2u_slider_left_disable',$shop2u_options['shop2u_slider_left_disable']);
$content = shop2u_homepage_slider_data();
$content2 = shop2u_homepage_slider_left_content_data();
if($section_disable==false){
?>
<section class="section slider-section py-4">
	<div class="container">
	    <div class="row">
	    	<?php if($slider_left_disable==false){ ?>
	 		<div class="col-lg-3 col-12  width_low">
	 		  	<div class="row">
	 		  		<?php 
                    if(!empty($content2)) { 
                        foreach ($content2 as $val) {
                        	$image = shop2u_get_media_url( $val['image'] );
			                $subtitle = isset( $val['subtitle'] ) ?  $val['subtitle'] : '';
			                $title = isset( $val['title'] ) ?  $val['title'] : '';
			                $desc = isset( $val['desc'] ) ?  $val['desc'] : '';
			                $button_label = isset( $val['button_label'] ) ?  $val['button_label'] : '';
			                $button_link = isset( $val['button_link'] ) ?  $val['button_link'] : '#';
			                $button_target = isset( $val['button_target'] ) ?  $val['button_target'] : true;
                    ?>
	 		  	    <div class="col-lg-12 col-md-6 col-12 mb-22">
	 		  	   	    <aside class="offer-banner banner-1">
			 		    	<div class="offer-banner-img">
			 		    	  	<a href="<?php echo esc_url( $button_link ); ?>">
			 		    	  		<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $title ); ?>">
			 		    	  	</a>
			 		    	</div>
			 		    	<div class="banner_content">
			 		    		<?php if($subtitle!=''){ ?>
								<span class="label wow fadeInUp"><?php echo wp_kses_post( $subtitle ); ?></span>
								<?php } ?>

								<?php if($title!=''){ ?>
								<h3 class="wow fadeInUp"><?php echo wp_kses_post( $title ); ?></h3>
								<?php } ?>

								<?php if($desc!=''){ ?>
								<p class="wow fadeInUp"><?php echo wp_kses_post( $desc ); ?></p>
								<?php } ?>

								<?php if($button_link!=''){ ?>
								<a class="btn btn-primary main-btn wow fadeInUp" href="<?php echo esc_url( $button_link ); ?>" <?php if($button_target){ echo 'target="_blank"';} ?>><?php echo esc_html( $button_label ); ?> <i class="fa-solid fa-arrow-right-long"></i></a>
								<?php } ?>		                        
		                    </div>
			 		   </aside>
	 		  	   	</div>
	 		  	   	<?php } } ?>
	 		  	</div>  	
	 		</div>
	 		<?php } ?>

	 		<div class="col-lg-<?php if($slider_left_disable==false){ echo '9'; }else{ echo '12'; } ?> col-md-12 col-sm-12 banner-column width_high">
	 		    <div class="sp-home-slider owl-carousel owl-theme">
	 		    	<?php 
                    if(!empty($content)) { 
                        foreach ($content as $val) {
                        	$image = shop2u_get_media_url( $val['image'] );
			                $subtitle = isset( $val['subtitle'] ) ?  $val['subtitle'] : '';
			                $title = isset( $val['title'] ) ?  $val['title'] : '';
			                $desc = isset( $val['desc'] ) ?  $val['desc'] : '';
			                $button1_label = isset( $val['button1_label'] ) ?  $val['button1_label'] : '';
			                $button1_link = isset( $val['button1_link'] ) ?  $val['button1_link'] : '#';
			                $button1_target = isset( $val['button1_target'] ) ?  $val['button1_target'] : true;
			                $button2_label = isset( $val['button2_label'] ) ?  $val['button2_label'] : '';
			                $button2_link = isset( $val['button2_link'] ) ?  $val['button2_link'] : '#';
			                $button2_target = isset( $val['button2_target'] ) ?  $val['button2_target'] : true;
                    ?>
	 		    	<div class="item">
	 		    	  	<div class="shop-item">
	 		    	  	    <div class="inner-box">
	 		    	  	   		<div class="row clearfix">
	 		    	  	   		    <div class="content-column col-lg-6 col-md-6 col-sm-12">
	 		    	  	   		 		<div class="inner-column main-content">
	 		    	  	   		 			<?php if($subtitle!=''){ ?>
											<div class="title"><?php echo wp_kses_post( $subtitle ); ?></div>
											<?php } ?>
	 		    	  	   		 		 	
	 		    	  	   		 		 	<?php if($title!=''){ ?>
											<h2><?php echo wp_kses_post( $title ); ?></h2>
											<?php } ?>
	 		    	  	   		 		 	
	 		    	  	   		 		 	<?php if($desc!=''){ ?>
											<p class="text"><?php echo wp_kses_post( $desc ); ?></p>
											<?php } ?>

	 		    	  	   		 		 	<div class="button-box text-left">
	 		    	  	   		 		 		<?php if($button1_link!=''){ ?>
												<a class="btn btn-primary main-btn" href="<?php echo esc_url( $button1_link ); ?>" <?php if($button1_target){ echo 'target="_blank"';} ?>><?php echo esc_html( $button1_label ); ?> <i class="fa-solid fa-arrow-right-long"></i></a>
												<?php } ?>
	 		    	  	   		 		 	  	<?php if($button2_link!=''){ ?>
												<a class="btn btn-secondary main-btn" href="<?php echo esc_url( $button2_link ); ?>" <?php if($button2_target){ echo 'target="_blank"';} ?>><?php echo esc_html( $button2_label ); ?> <i class="fa-solid fa-arrow-right-long"></i></a>
												<?php } ?>	 		    	  	   		 		 	  	
	 		    	  	   		 		 	</div>
	 		    	  	   		 		</div>
	 		    	  	   		 	</div>
	    	  	   		 		 	<div class="image-column col-lg-6 col-md-6 col-sm-12">
	    	  	   		 		 	  	<div class="inner-column">
	    	  	   		 		 	  	   	<div class="image animated">
	    	  	   		 		 	  	   	 	<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_html( $title ); ?>">
	    	  	   		 		 	  	   	</div>
	    	  	   		 		 	  	</div>
	    	  	   		 		 	</div>
	 		    	  	   		</div>
	 		    	  	    </div>
	 		    	  	</div>
	 		    	</div>
	 		    	<?php } } ?>
	 		    </div>
	 	    </div>
	    </div>  	   
	</div>
</section>
<?php } ?>