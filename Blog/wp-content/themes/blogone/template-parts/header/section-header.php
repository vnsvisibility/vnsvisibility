<?php
$option = blogone_theme_options();
?>
<header class="bs-header_wrapper">
	
	<?php do_action('blogone_header_inner_before'); ?>

	<div class="bs-navigation_wrapper <?php if( $option['blogone_h_sticky_show'] == true ){ echo 'is_sticky'; } ?>">
		<div class="container">
			<div class="navbar navbar-expand-lg bs-navbar_wraper">				

				<?php 
				blogone_logo();
				?>

				<?php do_action('blogone_header_area'); ?>
			</div>
		</div>
	</div>

	<?php do_action('blogone_header_inner_after'); ?>

	<div class="body-overlay"></div>
</header>