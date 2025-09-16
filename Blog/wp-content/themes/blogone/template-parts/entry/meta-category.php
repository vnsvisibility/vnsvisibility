<?php if( has_category() ) { ?>
<div class="bs-blog-category">
	<?php the_category( ' ', get_the_ID() ); ?>
</div>
<?php } ?>