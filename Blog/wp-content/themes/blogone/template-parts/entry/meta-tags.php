<?php if( has_tag() ){ ?>
<div class="bs-blog-category blog_tags">
	<span class="tags"><?php _e('Tags:','blogone') ?></span>
	<?php the_tags( '', get_the_ID() ); ?>
</div>
<?php } ?>