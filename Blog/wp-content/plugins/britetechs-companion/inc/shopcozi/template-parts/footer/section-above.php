<?php 
$option = shopcozi_theme_options();
$content = shopcozi_footer_above_content_data();
$page_options = shopcozi_get_page_options();
$container_class = $option['shopcozi_footer_container_width'];

if($page_options['sc_footer_container_width']=='0'){
	$container_class = $container_class;
}else{
	$container_class = $page_options['sc_footer_container_width'];
}

if($option['shopcozi_footer_above_show']==true){
?>
<div class="footer-above">
	<div class="<?php echo esc_attr($container_class); ?>">
		<div class="row justify-content-center">
			<?php 
            if(!empty($content)) { 
                foreach ($content as $val) {
	                $icon = isset( $val['icon'] ) ?  $val['icon'] : '';
	                $title = isset( $val['title'] ) ?  $val['title'] : '';
	                $link = isset( $val['link'] ) ?  $val['link'] : '';
            ?>
			<div class="col-lg-3 col-md-6 col-6">
				<aside class="iconbox justify-content-lg-center justify-content-md-left justify-content-left">
					<?php if($icon!=''){ ?>
			  		<div class="iconbox-icon">
			  			<i class="<?php echo esc_attr($icon); ?>"></i>
			  		</div>
			  		<?php } ?>

			  		<?php if($title!=''){ ?>
			  		<div class="iconbox-detail">
			  			<span>
			  				<?php if($link!=''){ ?>
			  				<a href="<?php echo esc_attr($link); ?>">
			  				<?php } ?>
			  					<?php echo esc_html($title); ?>
				  			<?php if($link!=''){ ?>
				  			</a>
				  			<?php } ?>
			  			</span>
			  		</div>
			  		<?php } ?>
			  	</aside>
			</div>
			<?php } } ?>
		</div>
	</div>
</div>
<?php } ?>