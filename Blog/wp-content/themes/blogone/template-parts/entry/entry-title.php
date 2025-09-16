<?php do_action( 'blogone_entry_title_before' ); ?>

<h4 class="title">
	<?php if( !is_single() && !is_page() || is_page_template() ){ ?>

    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
        <?php the_title(); ?>
    </a>

    <?php } else { ?>

        <?php the_title(); ?>

    <?php } ?>
</h4>

<?php do_action( 'blogone_entry_title_after' ); ?>