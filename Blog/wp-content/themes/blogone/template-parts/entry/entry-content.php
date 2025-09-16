<?php do_action( 'blogone_entry_content_before' ); ?>

<div class="entry-content">
	<?php 

    if( !is_single() && !is_page() ){

        the_excerpt();

    }else{

        the_content( sprintf(
                        /* translators: %s: Name of current post. */
                        wp_kses( __( 'Read More %s <span class="meta-nav">&rarr;</span>', 'blogone' ), array( 'span' => array( 'class' => array() ) ) ),
                        the_title( '<span class="screen-reader-text">"', '"</span>', false )
                    ) );        
    }

    if( get_post_format() === false || get_post_format() == 'standard' ){

        wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blogone' ),
                        'after'  => '</div>',
                    ) );

    }

    blogone_edit_link();
    ?>
</div>

<?php do_action( 'blogone_entry_content_before' ); ?>