<?php
global $authordata;

$option = blogone_theme_options();

$btn_show = $option['blogone_archive_btn_show'];
$author_show = $option['blogone_archive_author_show'];

if($btn_show==true || $author_show==true){
?>
<div class="bs-blog_auther">
	<?php if( $btn_show==true && $option['blogone_archive_readmore_label'] != '' ){ ?>
	<a href="<?php the_permalink(); ?>" class="bs-book_btn"><?php echo esc_html($option['blogone_archive_readmore_label']); ?> <span></span><span></span><span></span><span></span></a>
	<?php } ?>
	
	<?php if($author_show==true){ ?>
	<div class="bs-author">
		<a href="<?php echo esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ); ?>" class="auth">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 44 ); ?>
			<?php echo esc_html(get_the_author()); ?>
		</a>
	</div>
	<?php } ?>
</div>
<?php } ?>