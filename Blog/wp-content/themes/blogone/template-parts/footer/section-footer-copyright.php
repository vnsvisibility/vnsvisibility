<?php 
$option = blogone_theme_options();

if( function_exists('blogone_copyright_content_data')){
	$content = blogone_copyright_content_data();
}else{
	$content = array();
}


$footer_copyright = $option['blogone_footer_copyright'];
if( BLOGONE_THEME_NAME == 'Blogone Pro' && $footer_copyright!='' ){
  $ft_copyright = $footer_copyright;
}else{
	$ft_copyright = $option['blogone_footer_copyright'];
  $ft_copyright .= sprintf( __( ' %1$s theme by %2$s', 'blogone' ), '<a href="' . esc_url( 'https://www.britetechs.com/', 'blogone' ) . '">Blogone</a>', 'Britetechs' );
}

$options = array(
	'%current_year%',
	'%copy%'
);

$replace = array(
	date('Y'),
	'&copy;'
);

$copyright = str_replace( $options, $replace, $ft_copyright );

if( $option['blogone_footer_copyright_show'] == true ){
?>
<div class="blg-copy-right">
	<div class="row">
		<?php if($footer_copyright!=''){ ?>
		<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<div class="copyright-text">        
				<p><?php echo wp_kses_post($copyright); ?></p>
			</div>
		</div>
		<?php } ?>
		
		<div class="col-xl-6 col-lg-6 col-md-6 col-12">
			<div class="copyright-page-link">
				<ul class="page-link-list">
					<?php 
		            if(!empty($content)) { 
		                foreach ($content as $val) {
			                $text = isset( $val['text'] ) ?  $val['text'] : '';
			                $link = isset( $val['link'] ) ?  $val['link'] : '#';
		            ?>
					<li class="page-link">
						<a href="<?php echo esc_url($link); ?>"><?php echo esc_html($text); ?> </a>
					</li>
					<?php } } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php } ?>