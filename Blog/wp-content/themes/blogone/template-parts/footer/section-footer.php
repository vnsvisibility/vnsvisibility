<?php 
$option = blogone_theme_options();

$bs_main_footer_class = '';
if($option['blogone_footer_bg_image']!=''){
	$bs_main_footer_class = 'bg_image';
}
?>

<footer class="bs-footer_wrapper">
	
	<?php do_action('blogone_footer_inner_before'); ?>

	<div class="bs-main_footer <?php echo esc_attr($bs_main_footer_class); ?>">
		<div class="container">
			
			<?php do_action('blogone_footer_area'); ?>

		</div>
	</div>

	<?php do_action('blogone_footer_inner_after'); ?>

</footer>