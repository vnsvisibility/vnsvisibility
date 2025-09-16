<?php
$option = blogone_theme_options();
$icons = blogone_topbar_social_data();

if($option['blogone_topbar_show'] == true){
?>
<div class="bs-info-bar">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-4 col-md-5 col-9">
				<div class="bs-social_widget">
					<ul class="bs-social_nav">
						<?php 
                        if(!empty($icons)) { 
                            foreach ($icons as $val) {
                            	$icon = $val['icon']?$val['icon']:'fa fa-facebook';
                            	$link = $val['link']?$val['link']:'#';
                            	$target = $option['blogone_topbar_social_target']?true:false;
                        ?>
						<li class="bs-social_item">
							<a href="<?php echo esc_url($link); ?>" class="bs-social_link" <?php if($target==true){ echo 'target="_blank"'; } ?>>
								<i class="<?php echo esc_attr($icon); ?>"></i>
							</a>
						</li>
						<?php } } ?>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-md-5 col-12 d-none d-md-block">
				<?php if($option['blogone_topbar_search_show']==true){ ?>
				<div class="bs-header_form">
					<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">	
						<input type="search" placeholder="<?php echo esc_attr($option['blogone_topbar_search_label']); ?>" name="s">
						<button class="btn btn-theme btn-search"><i class="fa fa-search"></i></button>
					</form>
				</div>
				<?php } ?>
			</div>
			
			<?php do_action('blogone_topbar_area'); ?>
			
		</div>		
	</div>
</div>
<?php } ?>