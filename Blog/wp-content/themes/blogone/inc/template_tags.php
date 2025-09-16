<?php

function blogone_body_classes( $classes ) {
    $option = blogone_theme_options();

    if($option['blogone_mode'] == 'light' ){
        $classes[] = 'lite_primary_bg';
    }

    if($option['blogone_mode'] == 'dark' ){
        $classes[] = 'dark_primary_bg';
    }

    if($option['blogone_container_full'] == true ){
        $classes[] = 'full-container';
    }

    if($option['blogone_layout'] == 'boxed' ){
        return array_merge( $classes, array( 'boxed' ) );
    }else{
        return $classes;
    }
}
add_filter( 'body_class', 'blogone_body_classes');

if ( ! function_exists( 'blogone_logo' ) ) {
    function blogone_logo(){
        $class = array();
        $html = '';
        
        if ( function_exists( 'has_custom_logo' ) ) {
            if ( has_custom_logo()) {
                $html .= get_custom_logo();
            }else{
                $html .= '<h1 class="site-title"><a href="'.esc_url( home_url( '/' ) ).'" rel="home">' . get_bloginfo('name') . '</a></h1>';
                
                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) {
                    $html .= '<p class="site-description mb-0">'.$description.'</p>';
                }
            }
        }
        ?>
        <div class="bs-logo <?php echo esc_attr( join( ' ', $class ) ); ?>"><?php echo wp_kses_post($html); ?></div>
        <?php
    }
}

if ( ! function_exists( 'blogone_navigations' ) ) {
    function blogone_navigations(){
        if ( has_nav_menu( 'primary' ) || ! has_nav_menu( 'expanded' ) ) {
        ?>
        <ul class="primary-menu-list">
            <?php 
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'container'  => '',
                    'items_wrap' => '%3$s',
                    'theme_location' => 'primary',
                ) );
            }else if( ! has_nav_menu( 'expanded' ) ) {
                wp_list_pages( array(
                    'match_menu_classes' => true,
                    'show_sub_menu_icons' => true,
                    'title_li' => false,
                    'walker'   => new Blogone_Walker_Page(),
                ) );
            }
            ?>
        </ul>
        <?php
        }
    }
}

if( !function_exists('blogone_breadcrumbs_title') ){
    function blogone_breadcrumbs_title(){
        ?>
        <h2>
            <?php 
            if ( is_day() ) : 
                    
                printf( __( 'Daily Archives: %s', 'blogone' ), get_the_date() ); 
            
            elseif ( is_month() ) :
            
                printf( __( 'Monthly Archives: %s', 'blogone' ), get_the_date( 'F Y' ) );
                
            elseif ( is_year() ) :
            
                printf( __( 'Yearly Archives: %s', 'blogone' ), get_the_date( 'Y' )  );
                
            elseif ( is_category() ) :
            
                printf( __( 'Category Archives: %s', 'blogone' ), single_cat_title( '', false ) );

            elseif ( is_tag() ) :
            
                printf( __( 'Tag Archives: %s', 'blogone' ), single_tag_title( '', false ) );
                
            elseif ( is_404() ) :

                printf( __( 'Error 404', 'blogone' ));
                
            elseif ( is_author() ) :
            
                printf( __( 'Author: %s', 'blogone' ), get_the_author( '', false ) );

            elseif ( is_archive() ):

                if( is_post_type_archive() ){

                    printf( __( '%s', 'blogone' ), post_type_archive_title( '', false ) );

                }else{

                    printf( __( 'Archives: %s', 'blogone' ), post_type_archive_title( '', false ) );

                }

            elseif ( is_front_page() ):

                printf( __( 'Home', 'blogone' ) );

            elseif ( is_home() ):

                single_post_title();

            else :
                the_title();
            endif;
            ?>
        </h2>
        <?php
    }
}

if( !function_exists('blogone_breadcrumbs') ){
    function blogone_breadcrumbs(){

        $delimiter_char = '<i class="fas fa-chevron-right"></i>';

        if( class_exists('WooCommerce') ){
            if( 
                function_exists('woocommerce_breadcrumb') && 
                function_exists('is_woocommerce') && 
                is_woocommerce() ){
                woocommerce_breadcrumb(
                    array(
                        'wrap_before'=>'<span class="breadcrumb-links">',
                        'delimiter'=>isset($delimiter_char) ?'<span>'.$delimiter_char.'</span>':'',
                        'wrap_after'=>'</span>'
                    )
                );
                return;
            }
        }

        $allowed_html = array(
            'a'     => array('href' => array(), 'title' => array()),
            'span' => array('class' => array()),
            'div'  => array('class' => array()),
            'i'  => array('class' => array())
        );

        $output = '';

        $delimiter = isset($delimiter_char) ?'<span>'.$delimiter_char.'</span>':'';
        
        $ar_title = array(
                    'home'          => '<i class="fas fa-home"></i>'
                    ,'search'       => __('Search results for ', 'blogone')
                    ,'404'          => __('Error 404', 'blogone')
                    ,'tagged'       => __('Tagged ', 'blogone')
                    ,'author'       => __('Articles posted by ', 'blogone')
                    ,'page'         => __('Page', 'blogone')
                    );
      
        $before = '<span class="current">'; /* tag before the current crumb */
        $after = '</span>'; /* tag after the current crumb */

        global $wp_rewrite, $post;

        $rewriteUrl = $wp_rewrite->using_permalinks();

        if( !is_home() && !is_front_page() || is_paged() ){

            $output .= '<span class="breadcrumb-links">';
     
            $homeLink = esc_url( home_url('/') ); 
            $output .= '<a href="' . $homeLink . '">' . $ar_title['home'] . '</a> ' . $delimiter . ' ';
     
            if( is_category() ){
                global $wp_query;
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
                if( $thisCat->parent != 0 ){ 
                    $output .= get_category_parents($parentCat, true, ' ' . $delimiter . ' ');
                }
                $output .= $before . single_cat_title('', false) . $after;
            }
            elseif( is_search() ){
                $output .= $before . $ar_title['search'] . '"' . get_search_query() . '"' . $after;
            }elseif( is_day() ){
                $output .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                $output .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
                $output .= $before . get_the_time('d') . $after;
            }elseif( is_month() ){
                $output .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                $output .= $before . get_the_time('F') . $after;
            }elseif( is_year() ){
                $output .= $before . get_the_time('Y') . $after;
            }elseif( is_single() && !is_attachment() ){
                if( get_post_type() != 'post' ){
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    $post_type_name = $post_type->labels->singular_name;
                    if( $rewriteUrl ){
                        $output .= '<a href="' . $homeLink . $slug['slug'] . '/' . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
                    }else{
                        $output .= '<a href="' . $homeLink . '?post_type=' . get_post_type() . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
                    }
                    $output .= $before . get_the_title() . $after;
                }else{
                    $cat = get_the_category(); $cat = $cat[0];
                    $output .= get_category_parents($cat, true, ' ' . $delimiter . ' ');
                    $output .= $before . get_the_title() . $after;
                }
            }elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ){
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                $post_type_name = $post_type->labels->singular_name;
                if( is_tag() ){
                    $output .= $before . $ar_title['tagged'] . '"' . single_tag_title('', false) . '"' . $after;
                }
                elseif( is_taxonomy_hierarchical(get_query_var('taxonomy')) ){
                    if( $rewriteUrl ){
                        $output .= '<a href="' . $homeLink . $slug['slug'] . '/' . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
                    }else{
                        $output .= '<a href="' . $homeLink . '?post_type=' . get_post_type() . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
                    }           
                    
                    $curTaxanomy = get_query_var('taxonomy');
                    $curTerm = get_query_var( 'term' );
                    $termNow = get_term_by( 'name', $curTerm, $curTaxanomy );
                    $pushPrintArr = array();
                    if( $termNow !== false ){
                        while( (int)$termNow->parent != 0 ){
                            $parentTerm = get_term((int)$termNow->parent,get_query_var('taxonomy'));
                            array_push($pushPrintArr,'<a href="' . get_term_link((int)$parentTerm->term_id,$curTaxanomy) . '">' . $parentTerm->name . '</a> ' . $delimiter . ' ');
                            $curTerm = $parentTerm->name;
                            $termNow = get_term_by( 'name', $curTerm, $curTaxanomy );
                        }
                    }
                    $pushPrintArr = array_reverse($pushPrintArr);
                    array_push($pushPrintArr,$before  . get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) )->name  . $after);
                    $output .= implode($pushPrintArr);
                }else{
                    $output .= $before . $post_type_name . $after;
                }
            }elseif( is_attachment() ){
                if( (int)$post->post_parent > 0 ){
                    $parent = get_post($post->post_parent);
                    $cat = get_the_category($parent->ID);
                    if( count($cat) > 0 ){
                        $cat = $cat[0];
                        $output .= get_category_parents($cat, true, ' ' . $delimiter . ' ');
                    }
                    $output .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
                }
                $output .= $before . get_the_title() . $after;
            }elseif( is_page() && !$post->post_parent ){
                $output .= $before . get_the_title() . $after;
            }elseif( is_page() && $post->post_parent ){
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while( $parent_id ){
                    $page = get_post($parent_id);
                    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                    $parent_id  = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach( $breadcrumbs as $crumb ){
                    $output .= $crumb . ' ' . $delimiter . ' ';
                }
                $output .= $before . get_the_title() . $after;
            }elseif( is_tag() ){
                $output .= $before . $ar_title['tagged'] . '"' . single_tag_title('', false) . '"' . $after;
            }elseif( is_author() ){
                global $author;
                $userdata = get_userdata($author);
                $output .= $before . $ar_title['author'] . $userdata->display_name . $after;
            }elseif( is_404() ){
                $output .= $before . $ar_title['404'] . $after;
            }
            if( get_query_var('paged') || get_query_var('page') ){
                if( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_page_template() ||  is_post_type_archive() || is_archive() ){ 
                    $output .= $before .' ('; 
                }
                $output .= $ar_title['page'] . ' ' . ( get_query_var('paged')?get_query_var('paged'):get_query_var('page') );
                if( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_page_template() ||  is_post_type_archive() || is_archive() ){ 
                    $output .= ')'. $after; 
                }
            }
            $output .= '</span>';
        }
        
        echo wp_kses($output, $allowed_html);
        
        wp_reset_postdata();
    }
}

if ( ! function_exists( 'blogone_edit_link' ) ) :
    function blogone_edit_link() {
        edit_post_link(
            sprintf(
                /* translators: %s: Post title. */
                __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'blogone' ),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if ( ! function_exists( 'blogone_author_detail' ) ) :
    function blogone_author_detail(){
        $author_id = get_the_author_meta( 'ID' );
        if(get_the_author_meta( 'description', $author_id )==''){
            return;
        }
    ?>
    <section class="mt-4">
        <aside class="widget about-widget post-widget-box">
            <div class="widget_content d-flex align-items-center">
                <div class="bs-author_profile">
                    <?php echo get_avatar( get_the_author_meta( 'ID') , 200 ); ?>
                </div>
                <div class="bs-author_content">
                    <h4 class="auth_name"><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>" class="author_title"><?php the_author(); ?></a></h4>
                    <p class="subtitle"><?php the_author_meta( 'description' ); ?></p>                    
                </div>
            </div>  
        </aside>
    </section>
    <?php 
    }
endif;

if ( ! function_exists( 'blogone_page_links' ) ) :
    function blogone_page_links(){
    ?>
    <div class="row mt-4">
        <?php
        $prev_post = get_previous_post();
        if( $prev_post ){
        ?>
        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
            <aside class="widget recent-post-widget post-widget-box">
                <div class="widget_content">
                    <ul class="sidebar_blog-list">
                        <li class="blog_list-item">
                            <?php if( has_post_thumbnail( $prev_post ) ){ ?>
                            <div class="img-box">
                                <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" rel="prev">
                                    <?php echo get_the_post_thumbnail( $prev_post, 'medium' ); ?>
                                </a>
                            </div>
                            <?php } ?>
                            
                            <div class="text-box blog_content">
                                <div class="blog-title">
                                    <h4 class="title">
                                        <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" rel="prev"><?php echo get_the_title( $prev_post ); ?></a>
                                    </h4>
                                </div>
                                <a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="bs-book_btn"><?php _e('Prev Post','blogone'); ?> <span></span><span></span><span></span><span></span></a>
                            </div> 
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
        <?php } ?>

        <?php
        $next_post = get_next_post();
        if( $next_post ){
        ?>
        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
            <aside class="widget recent-post-widget post-widget-box">
                <div class="widget_content">
                    <ul class="sidebar_blog-list">
                        <li class="blog_list-item justify-content-end">                          
                            <div class="text-box blog_content">
                                <div class="blog-title">
                                    <h4 class="title">
                                        <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>"><?php echo get_the_title( $next_post ); ?></a>
                                    </h4>
                                </div>
                                <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="bs-book_btn"><?php _e('Next Post','blogone'); ?> <span></span><span></span><span></span><span></span></a>
                            </div>

                            <?php if( has_post_thumbnail( $next_post ) ){ ?>
                            <div class="img-box ml-4 mr-0">
                                <a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>">
                                    <?php echo get_the_post_thumbnail( $next_post, 'medium' ); ?>
                                </a>
                            </div>
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
        <?php } ?>
    </div>
    <?php 
    }
endif;

/*** Get excerpt ***/
if( !function_exists ('blogone_string_limit_words') ){
    function blogone_string_limit_words($string, $word_limit){
        $words = explode(' ', $string, ($word_limit + 1));
        if( count($words) > $word_limit ){
            array_pop($words);
        }
        return implode(' ', $words);
    }
}

if( !function_exists ('blogone_the_excerpt_max_words') ){
    function blogone_the_excerpt_max_words( $word_limit = -1, $post = '', $strip_tags = true, $extra_str = '', $echo = true ) {
        if( $post ){
            $excerpt = blogone_get_the_excerpt_by_id($post->ID);
        }
        else{
            $excerpt = get_the_excerpt();
        }
            
        if( !is_array($strip_tags) && $strip_tags ){
            $excerpt = wp_strip_all_tags($excerpt);
            $excerpt = strip_shortcodes($excerpt);
        }
        
        if( is_array($strip_tags) ){
            $excerpt = wp_kses($excerpt, $strip_tags); // allow, not strip
        }
            
        if( $word_limit != -1 ){
            $result = blogone_string_limit_words($excerpt, $word_limit);
            if( $result != $excerpt ){
                $result .= $extra_str;
            }
        }   
        else{
            $result = $excerpt;
        }
            
        if( $echo ){
            echo do_shortcode($result);
        }
        return $result;
    }
}

if( !function_exists('blogone_get_the_excerpt_by_id') ){
    function blogone_get_the_excerpt_by_id( $post_id = 0 )
    {
        global $wpdb;
        $query = "SELECT post_excerpt, post_content FROM $wpdb->posts WHERE ID = %d LIMIT 1";
        $result = $wpdb->get_results( $wpdb->prepare($query, $post_id), ARRAY_A );
        if( $result[0]['post_excerpt'] ){
            return $result[0]['post_excerpt'];
        }
        else{
            $content = $result[0]['post_content'];
            if( false !== strpos( $content, '<!--nextpage-->' ) ){
                $pages = explode( '<!--nextpage-->', $content );
                return $pages[0];
            }
            return $content;
        }
    }
}

/**
 * Custom excerpt length
 */
if ( ! function_exists( 'blogone_custom_excerpt_length' ) ) :
    add_filter( 'excerpt_length', 'blogone_custom_excerpt_length', 100 );
    function blogone_custom_excerpt_length( $length ) {
        global $post;

        $option = blogone_theme_options();

        if( is_archive() ){
            $excerpt_length = $option['blogone_archive_excerpt_length'];
        }else{
            $excerpt_length = 50;
        }

        return absint( apply_filters( 'blogone_excerpt_length', $excerpt_length ) );
    }
endif;

/**
 * Remove […]
 */
if ( ! function_exists( 'blogone_new_excerpt_more' ) ) :
    add_filter('excerpt_more', 'blogone_new_excerpt_more', 15 );
    function blogone_new_excerpt_more( $more ) {
        global $post;

        $option = blogone_theme_options();

        if( is_archive() ){
            $excerpt_readmore = $option['blogone_archive_readmore_label'];
        }else{
            $excerpt_readmore = __('Read More','blogone');
        }

        return apply_filters( 'blogone_excerpt_more_output', sprintf(
            ' ... <div><a class="more-link bs-book_btn" href="%s">%1s</a></div>',
            esc_url( get_the_permalink() ),
            $excerpt_readmore
            ) );
    }
endif;

/* Content Read More */

if ( ! function_exists( 'blogone_blog_content_more' ) ) :
    add_filter( 'the_content_more_link', 'blogone_blog_content_more', 15 );
    function blogone_blog_content_more( $more ) {
        global $post;
        
        $option = blogone_theme_options();
        
        if( is_archive() ){
            $excerpt_readmore = $option['blogone_archive_readmore_label'];
        }else{
            $excerpt_readmore = __('Read More','blogone');
        }

        return apply_filters( 'blogone_content_more_link_output', sprintf( '<div><a title="%1$s" class="more-link bs-book_btn" href="%2$s">%3$s%4$s</a></div>',
            the_title_attribute( 'echo=0' ),
            esc_url( get_permalink( get_the_ID() ) . apply_filters( 'blogone_more_jump','#more-' . get_the_ID() ) ),
            wp_kses_post( $excerpt_readmore ),
            '<span class="screen-reader-text">' . get_the_title() . '</span>'
        ) );
    }
endif;

if( ! function_exists('blogone_get_list_sidebars') ){
    function blogone_get_list_sidebars(){
        return $GLOBALS['wp_registered_sidebars'];
    }
}

function blogone_placeholder_img_src( $size = 'medium' ) {
    $src               = get_template_directory_uri() . '/img/placeholder_img.png';
    $placeholder_image = get_option( 'blogone_placeholder_image', 0 );

    if ( ! empty( $placeholder_image ) ) {
        if ( is_numeric( $placeholder_image ) ) {
            $image = wp_get_attachment_image_src( $placeholder_image, $size );

            if ( ! empty( $image[0] ) ) {
                $src = $image[0];
            }
        } else {
            $src = $placeholder_image;
        }
    }

    return apply_filters( 'blogone_placeholder_img_src', $src );
}

function blogone_help_tip( $tip, $allow_html = false ) {
    if ( $allow_html ) {
        $sanitized_tip = wc_sanitize_tooltip( $tip );
    } else {
        $sanitized_tip = esc_attr( $tip );
    }

    return apply_filters( 'wc_help_tip', '<span class="blogone-help-tip" tabindex="0" aria-label="' . $sanitized_tip . '" data-tip="' . $sanitized_tip . '"></span>', $sanitized_tip, $tip, $allow_html );
}

// Content starter pack data
function blogone_wp_starter_pack() {

    // Define and register starter contents

    $starter_content = array(
        'widgets'     => array(
            'sidebar-1'   => array(
                'search',
                'categories',
                'tag',
                'meta',
            ),
            'footer-1'    => array(
                'my_text' => array(
                    'text',
                    array(
                        'title' => _x('About US', 'My text starter contents', 'blogone'),
                        'text'  =>  _x('Lorem ipsum dolor sit amet consectetur dipisicing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua Ut enim ad minim veniam.', 'My text starter contents', 'blogone'),
                    ),
                ),
            ),
            'footer-2'    => array(
                'search' => array(
                    'search',
                    array(
                        'title' => _x( 'search', 'My text starter contents', 'blogone' ),
                    )
                ),
            ),
            'footer-3'    => array(
                'categories'=> array(
                    'categories',
                    array(
                        'title' => _x( 'categories', 'My text starter contents', 'blogone' ),
                    )
                ),
            ),
        ),
        'posts'       => array(
            'home',
            'about',
            'contact',
            'blog',
        ),
        'options'     => array(
            'show_on_front'  => 'page',
            'page_on_front'  => '{{home}}',
            'page_for_posts' => '{{blog}}',
            'header_image'   => '',
        ),
        'nav_menus'   => array(
            'primary'    => array(
                'name'  => __( 'Primary Menu', 'blogone' ),
                'items' => array(
                    'link_home',
                    'page_about',
                    'page_blog',
                    'page_contact',
                    'page_loremuipsum' => array(
                        'type'      => 'post_type',
                        'object'    => 'page',
                        'object_id' => '{{loremipsum}}',
                    ),
                ),
            ),
        ),
    );

    return apply_filters( 'blogone_wp_starter_pack', $starter_content );
}

// Get Started Notice

add_action( 'wp_ajax_blogone_dismissed_notice_handler', 'blogone_ajax_notice_handler' );
function blogone_ajax_notice_handler() {
    if ( isset( $_POST['type'] ) ) {
        $type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
        update_option( 'dismissed-' . $type, TRUE );
    }
}

function blogone_deprecated_hook_admin_notice() {
        if ( ! get_option('dismissed-get_started', FALSE ) ) {
            ?>
            <div class="updated notice notice-get-started-class is-dismissible" data-notice="get_started">
                <div class="blogone-getting-started-notice clearfix">
                    <div class="blogone-theme-screenshot">
                        <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/screenshot.png" class="screenshot" alt="<?php esc_attr_e( 'Theme Screenshot', 'blogone' ); ?>" />
                    </div>
                    <div class="blogone-theme-notice-content">
                        <h2 class="blogone-notice-h2">
                        <?php
                        printf(
                            /* translators: 1: welcome page link starting html tag, 2: welcome page link ending html tag. */
                            esc_html__( 'Welcome! Thank you for choosing %1$s!', 'blogone' ), '<strong>'. wp_get_theme()->get('Name'). '</strong>' );
                        ?>
                        </h2>

                        <p class="plugin-install-notice"><?php echo sprintf(__('Install and activate <strong>Britetechs Companion</strong> plugin for taking full advantage of all the features this theme has to offer.', 'blogone')) ?></p>

                        <?php printf(
                            /* translators: 1: welcome page link starting html tag, 2: welcome page link ending html tag. */
                            __( '<a class="blogone-btn-get-started button button-primary button-hero blogone-button-padding" href="#" data-name="" data-slug=""> Get started with %1$s</a>', 'blogone' ), '<strong>'. wp_get_theme()->get('Name'). '</strong>' );
                        ?>

                        <?php
                            /* translators: %1$s: Anchor link start %2$s: Anchor link end */
                            printf(
                                'OR <a class="button button-danger button-hero blogone-button-padding" target="_blank" href="https://www.britetechs.com/theme/%2$s-pro/"> Upgrade To %1$s</a>',
                                '<strong>'. wp_get_theme()->get('Name'). ' Pro</strong>',
                                wp_get_theme()->get('TextDomain')
                            );
                        ?>
                        <span class="blogone-push-down">
                        <?php
                            /* translators: %1$s: Anchor link start %2$s: Anchor link end */
                            printf(
                                'OR %1$sCustomize theme%2$s</a></span>',
                                '<a target="_blank" href="' . esc_url( admin_url( 'customize.php' ) ) . '">',
                                '</a>'
                            );
                        ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php }
}
add_action( 'admin_notices', 'blogone_deprecated_hook_admin_notice' );

// Plugin Installer

function blogone_admin_install_plugin() {

    include_once ABSPATH . '/wp-admin/includes/file.php';
    include_once ABSPATH . '/wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . '/wp-admin/includes/plugin-install.php';

    if ( ! file_exists( WP_PLUGIN_DIR . '/britetechs-companion' ) ) {
        $api = plugins_api( 'plugin_information', array(
            'slug'   => sanitize_key( wp_unslash( 'britetechs-companion' ) ),
            'fields' => array(
                'sections' => false,
            ),
        ) );

        $skin     = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $api->download_link );
    }

    // Activate plugin.
    if ( current_user_can( 'activate_plugin' ) ) {
        $result = activate_plugin( 'britetechs-companion/britetechs-companion.php' );
    }
}
add_action( 'wp_ajax_install_act_plugin', 'blogone_admin_install_plugin' );