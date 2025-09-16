<?php 
/**
 * Right sidebar
 *
 *
 */
 
if ( ! is_active_sidebar('sidebar-1') ) {
	return;
}
?>
<div class="col-xl-4 col-lg-4 col-md-12 col-12 wow fadeInUp">
	<div class="sidebar sticky-sidebar">
		<?php dynamic_sidebar('sidebar-1'); ?>		
	</div>
</div>