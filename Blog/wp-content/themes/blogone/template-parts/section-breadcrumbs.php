<?php 
$option = blogone_theme_options();

$breadcrumb_area_class = '';
if($option['blogone_breadcrumb_bg_image']!=''){
	$breadcrumb_area_class = 'bg_image';
}

if( $option['blogone_breadcrumb_show'] == true ){
?>
<section class="breadcrumb-area <?php echo esc_attr($breadcrumb_area_class); ?>">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumb-content">
					<?php if( $option['blogone_breadcrumb_title_show'] == true ){ ?>
					<div class="breadcrumb-heading">
						<?php 
						blogone_breadcrumbs_title();
						?>
					</div>
					<?php } ?>
					
					<?php 
					if( $option['blogone_breadcrumb_path_show'] == true ){
						blogone_breadcrumbs();
					}
					?>
				</div>
				
			</div>
		</div>
	</div>
</section>
<?php } ?>