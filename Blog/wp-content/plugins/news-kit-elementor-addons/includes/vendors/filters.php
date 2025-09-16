<?php
/**
 * List of all filters 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'nekit_posts_date_apply_url_filter', function($html) {
    return '<span class="date-meta-wrap post-meta-item"><a href="' .esc_url(get_the_permalink()). '" target="'.esc_attr($html[1]).'">' .$html[0]. '</a></span>';
});
add_filter( 'nekit_posts_date_filter', function($html) {
    return '<span class="date-meta-wrap post-meta-item">' .$html. '</span>';
});
add_filter( 'nekit_posts_comments_filter', function($html) {
    return '<span class="comments-meta-wrap post-meta-item"><a href="'.esc_url(get_the_permalink()) .'#comments">' .$html. '</a></span>';
});
add_filter( 'nekit_posts_author_apply_url_filter', function($html) {
    return '<span class="author-meta-wrap post-meta-item"><a href="' .esc_url(get_author_posts_url(get_the_author_meta( 'ID' ))). '" target="'. esc_attr($html[1]) .'">' .$html[0]. '</a></span>';
});
add_filter( 'nekit_posts_author_filter', function($html) {
    return '<span class="author-meta-wrap post-meta-item">' .$html. '</span>';
});

add_filter( 'nekit_posts_category_filter', function($html) {
    return '<div class="category-wrap">' .$html. '</div>';
});

add_filter( 'nekit_theme_builder_callback_value_filter', function($type,$page) {
    switch($type) {
        case 'builder-callback-condition': $condition_value = 'entire-site';
                                        break;
        case 'inner-builder-callback-condition': $new_value = explode( '-', $page );
                                                $condition_value = $new_value[0] . '-nekitallnekit';
                                            break;
        default: $condition_value = 'entire-site';
    }
    return $condition_value;
}, 10, 2);

add_filter('nekit_array_pop_filter', function($array) {
    // Use array_pop to remove the last value from the array
    array_pop($array);

    return $array;
});

add_filter( 'body_class', function( $classes ){
    $classes[] = 'nekit';
    return $classes;
});

add_filter( 'nekit_radio_image_control_options_filter', function( $options ){
    $meets_elementor_version = version_compare( ELEMENTOR_VERSION, '3.28.0', '>=' );
    if( ! empty( $options ) && is_array( $options ) ){
        $new_options = [];
        foreach( $options as $option_key => $option ) {
            if( ! $meets_elementor_version ) {
                $option[ 'url' ] = $option[ 'image' ];
                unset( $option[ 'image' ] );
            }
            $new_options[ $option_key ] = $option;
        }
        return $new_options;
    } else {
        return $options;
    }
});