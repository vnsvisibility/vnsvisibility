<?php 
$option = blogone_theme_options();

if($option['blogone_topbar_canvas_show'] == true){
?>
<div class="col-lg-5 col-md-2 col-3">
	<div class="bs-right_info-bar">
		<ul>
			<li>
				<a href="#" class="bs-info-list hover-theme-btn">
					<i class="fa fa-th-list"></i>
				</a>
			</li>
		</ul>
	</div>
	<div class="sidebar-one">
		<div class="sidebar-one__overlay"></div>
		<div class="sidebar-one__content">
			<?php if($option['blogone_topbar_canvas_logo'] != ''){ ?>
			<div class="sidebar-one__logo">
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<img src="<?php echo esc_url($option['blogone_topbar_canvas_logo']); ?>" width="120">
				</a>
			</div>
			<?php } ?>

			<?php if($option['blogone_topbar_canvas_desc'] != ''){ ?>
			<p class="sidebar-one__text">
				<?php echo wp_kses_post($option['blogone_topbar_canvas_desc']); ?>
			</p>
			<?php } ?>
			
			<?php if($option['blogone_topbar_canvas_search_show']==true){ ?>
			<?php if($option['blogone_topbar_canvas_search_title'] != ''){ ?>
			<h4 class="sidebar-one__title"><?php echo esc_html($option['blogone_topbar_canvas_search_title']); ?></h4>
			<?php } ?>
			<div class="bs-header_form">
				<form method="get" action="">	
					<input type="search" placeholder="<?php echo esc_attr($option['blogone_topbar_canvas_search_label']); ?>" name="s">
					<button class="btn btn-theme btn-search"><i class="fa fa-search"></i></button>
				</form>
			</div>
			<?php } ?>
			<button type="button" class="sidebar-one__close hover-theme-btn">
				<i class="fa fa-times"></i>
			</button>
		</div>
	</div>
</div>
<?php } ?>