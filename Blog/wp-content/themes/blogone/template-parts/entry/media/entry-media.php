<?php
$post_format = get_post_format(); /* Video, Audio, Gallery, Quote */
$blog_thumb_size = 'blogone_blog_single_thumb';

$show_blog_thumbnail = 1;
if( ( $post_format == 'gallery' || $post_format === false || $post_format == 'standard' ) && !has_post_thumbnail() ){
	$show_blog_thumbnail = 0;
}

if( $show_blog_thumbnail ){

	if( $post_format == 'gallery' || $post_format === false || $post_format == 'standard' ){ ?>

		<?php 
		if( $post_format == 'gallery' ){ 
			$gallery = get_post_meta($post->ID, 'blogone_gallery', true);
			$gallery_ids = explode(',', $gallery);
			if( is_array($gallery_ids) ){
				array_unshift($gallery_ids, get_post_thumbnail_id());
			}
		?>
		<div id="thumbnail-blog-slider-<?php the_ID(); ?>" class="thumbnail-blog-slider owl-carousel owl-theme" data-collg="1" data-colmd="1" data-colsm="1" data-colxs="1" data-itemspace="0" data-loop="true" data-autoplay="true" data-smartspeed="1200" data-nav="true" data-dots="false">
			<?php foreach( $gallery_ids as $gallery_id ){ ?>
				<div class="item">
					<?php echo wp_get_attachment_image( $gallery_id, $blog_thumb_size, 0, array('class' => 'thumbnail-blog') ); ?>
				</div>
			<?php } ?>
		</div>
		<?php } ?>
		
		<?php if( ($post_format === false || $post_format == 'standard') ){ ?>
		<div class="blog-thumb blog-thumb-hover">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail($blog_thumb_size, array('class' => 'thumbnail-blog')); ?>
			</a>
			<?php the_post_thumbnail($blog_thumb_size, array('class' => 'thumbnail-blog')); ?>
		</div>
		<?php } ?>

	<?php } ?>

	<?php 
	$html_tag_frame = 'ifra';
	$html_tag_frame .= 'me';

	if( $post_format == 'video' ){
		$video_url = get_post_meta($post->ID, 'blogone_video_url', true);

			if( $video_url != '' ){
				if( strstr($video_url, 'youtube.com') || strstr($video_url, 'youtu.be') ){
				preg_match('%(?:youtube\.com/(?:user/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_url, $match);
				if( count($match) >= 2 ){
					$video_url = '//www.youtube.com/embed/' . $match[1];
				}
			}
			elseif( strstr($video_url, 'vimeo.com') ){
				preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $video_url, $match);
				if( count($match) >= 2 ){
					$video_url = '//player.vimeo.com/video/' . $match[1];
				}
				else{
					$video_id = explode('/', $video_url);
					if( is_array($video_id) && !empty($video_id) ){
						$video_id = $video_id[count($video_id) - 1];
						$video_url = '//player.vimeo.com/video/' . $video_id;
					}
				}
			}
		}

		?>
		<div class="blogone-video">
			<<?php echo $html_tag_frame; ?> width="100%" height="450" src="<?php echo esc_url($video_url); ?>" allowfullscreen></<?php echo $html_tag_frame; ?>>
		</div>
		<?php
	}
	 
	if( $post_format == 'audio' ){
		$audio_url = get_post_meta($post->ID, 'blogone_audio_url', true);
		if( strlen($audio_url) > 4 ){
			$file_format = substr($audio_url, -3, 3);
			if( in_array($file_format, array('mp3', 'ogg', 'wav')) ){
				echo do_shortcode('[audio '.$file_format.'="'.esc_url($audio_url).'"]');
			}else{

				$atts = array(
					'url' => $audio_url,
				);

				extract(shortcode_atts(array(
					'params'		=> "color=ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false"
					,'url'			=> ''
					,'width'		=> '100%'
					,'height'		=> '166'
					,$html_tag_frame		=> 1
				),$atts));
				
				$atts = compact( 'params', 'url', 'width', 'height', 'iframe' );

				if( $iframe ){
					$url = 'https://w.soundcloud.com/player/?url=' . $atts['url'] . '&' . $atts['params'];
					$unique_class = 'blogone-soundcloud-'.rand();
					$style = '.'.esc_attr($unique_class).' iframe{width: '.esc_attr($atts['width']).'; height:'.esc_attr($atts['height']).'px;}';
					$style = '<style type="text/css" scoped>'.$style.'</style>';
					echo '<div class="blogone-soundcloud '.esc_attr($unique_class).'">'.$style.'<'.$html_tag_frame.' src="'.esc_url( $url ).'"></'.$html_tag_frame.'></div>';
				}
			}
		}
	} 
} 
?>