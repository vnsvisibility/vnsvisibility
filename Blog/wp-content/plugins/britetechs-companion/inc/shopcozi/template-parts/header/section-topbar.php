<?php 
$option = shopcozi_theme_options();
$page_options = shopcozi_get_page_options();
$topbar_texts = shopcozi_header_topbar_data();
$topbar_icons = shopcozi_header_topbar_icons_data();
$h_container_width = $option['shopcozi_h_container_width'];

if($page_options['sc_header_container_width']=='0'){
	$h_container_width = $h_container_width;
}else{
	$h_container_width = $page_options['sc_header_container_width'];
}

$h_style = $option['shopcozi_h_style'];
switch ($h_style) {
	case 'one':
		$topbar_class = 'light';
		$topbar_icon_class = 'style-two';
		break;
	case 'two':
		$topbar_class = 'dark';
		$topbar_icon_class = 'style-three';
		break;
	case 'three':
		$topbar_class = 'primary';
		$topbar_icon_class = 'style-two';
		break;
	default:
		$topbar_class = 'primary';
		$topbar_icon_class = 'style-two';
		break;
}

if($option['shopcozi_topbar_show']==true){
?>
<div class="top-header <?php echo esc_attr($topbar_class); ?> py-2">
	<div class="top-header-inside">
		<div class="<?php echo esc_attr($h_container_width); ?>">
			<div class="row align-items-center">
				<div class="col-lg-8 col-12">
					<section class="widget-left d-flex justify-content-lg-start justify-content-md-start justify-content-center">
						<aside class="widget">
							<h6 class="widget-title">Contact Info</h6>
							<ul>
								<?php 
		                        if(!empty($topbar_texts)) { 
		                            foreach ($topbar_texts as $val) {
		                        ?>
								<li>
									<?php if( isset($val['link']) && $val['link']!=null){ ?>
									<a href="<?php echo esc_url($val['link']); ?>">
									<?php } ?>
										<i class="<?php echo esc_attr($val['icon']); ?>"></i> <?php echo esc_html($val['text']); ?>
									<?php if( isset($val['link']) && $val['link']!=null){ ?>
									</a>
									<?php } ?>
								</li>
								<?php } } ?>
							</ul>
						</aside>
					</section>
				</div>
				<div class="col-lg-4 col-12">
					<section class="widget-right justify-content-lg-end justify-content-center">
						<aside class="widget widget-social">
							<ul class="<?php echo esc_attr($topbar_icon_class); ?>">
								<?php 
		                        if(!empty($topbar_icons)) { 
		                            foreach ($topbar_icons as $val) {
		                            	if( isset($val['link']) && $val['link']!=null){
		                        ?>
								<li>
									<a href="<?php echo esc_url($val['link']); ?>" <?php if($option['shopcozi_topbar_icons_target']==true){ echo 'target="_blank"'; } ?>>
										<i class="<?php echo esc_attr($val['icon']); ?>"></i>
									</a>
								</li>
								<?php } } } ?>
							</ul>
						</aside>
					</section>
				</div>
			</div>
		</div>				
	</div>
</div>
<?php } ?>