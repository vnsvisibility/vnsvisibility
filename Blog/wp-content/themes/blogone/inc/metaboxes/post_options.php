<?php 
$options = array();

$default_sidebars = function_exists('blogone_get_list_sidebars')? blogone_get_list_sidebars(): array();
$sidebar_options = array(
				'0'	=> esc_html__('Default', 'blogone')
				);
foreach( $default_sidebars as $key => $_sidebar ){
	$sidebar_options[$_sidebar['id']] = $_sidebar['name'];
}

$options[] = array(
				'id'		=> 'post_layout_heading'
				,'label'	=> esc_html__('Post Layout', 'blogone')
				,'desc'		=> ''
				,'type'		=> 'heading'
			);

$options[] = array(
				'id'		=> 'post_layout'
				,'label'	=> esc_html__('Post Layout', 'blogone')
				,'desc'		=> ''
				,'type'		=> 'select'
				,'options'	=> array(
									'0-1-0'  	=> esc_html__('No Sidebar', 'blogone')
									,'1-1-0' 	=> esc_html__('Left Sidebar', 'blogone')
									,'0-1-1' 	=> esc_html__('Right Sidebar', 'blogone')
								)
			);
			
$options[] = array(
				'id'		=> 'post_audio_heading'
				,'label'	=> esc_html__('Post Audio', 'blogone')
				,'desc'		=> ''
				,'type'		=> 'heading'
			);	
			
$options[] = array(
				'id'		=> 'audio_url'
				,'label'	=> esc_html__('Audio URL', 'blogone')
				,'desc'		=> esc_html__('Enter MP3, OGG, WAV file URL or SoundCloud URL', 'blogone')
				,'type'		=> 'text'
			);

$options[] = array(
				'id'		=> 'post_video_heading'
				,'label'	=> esc_html__('Post Video', 'blogone')
				,'desc'		=> ''
				,'type'		=> 'heading'
			);			
			
$options[] = array(
				'id'		=> 'video_url'
				,'label'	=> esc_html__('Video URL', 'blogone')
				,'desc'		=> esc_html__('Enter Youtube or Vimeo video URL', 'blogone')
				,'type'		=> 'text'
			);		
?>