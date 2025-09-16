<?php
/**
 * Helper filters
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

 if( ! function_exists( 'nekit_get_post_categories_badge' ) ) :
    /**
     * Function contains post categories html
     * @return float
     */
    function nekit_get_post_categories_badge( $post_id, $number ) {
    	$n_categories = wp_get_post_categories($post_id, array( 'number' => absint( $number ) ));
		echo '<ul class="badge-item">';
			foreach( $n_categories as $n_category ) :
				echo '<li class="cat-item ' .esc_attr( 'cat-' . $n_category ). '"><a href="' .esc_url( get_category_link( $n_category ) ). '" rel="category tag">' .esc_html(get_cat_name( $n_category )). '</a></li>';
			endforeach;
		echo '</ul>';
    }
endif;

if( ! function_exists( 'nekit_get_post_tags_badge' ) ) :
    /**
     * Function contains post tags html
     * @return float
     */
    function nekit_get_post_tags_badge( $post_id, $number ) {
    	$nekit_tags = wp_get_post_tags($post_id, array( 'number' => absint( $number ) ));
		echo '<ul class="badge-item">';
			foreach( $nekit_tags as $nekit_tag ) :
				echo '<li class="tag-item ' .esc_attr( 'tag-' . $nekit_tag->term_id ). '"><a href="' .esc_url( get_tag_link( $nekit_tag ) ). '" rel="category tag">' .esc_html( $nekit_tag->name ). '</a></li>';
			endforeach;
		echo '</ul>';
    }
endif;

if ( ! function_exists( 'nekit_posted_by_badge' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function nekit_posted_by_badge($post_id = '') {
		$author_id = $post_id ? get_post_field( 'post_author', $post_id ) : get_the_author_meta( 'ID' );
		$author_name = $post_id ? get_the_author_meta( 'display_name' , $author_id ) : get_the_author();
		$byline =  '<span class="author vcard"><a class="url fn n author_name" href="' . esc_url( get_author_posts_url( $author_id ) ) . '">' . esc_html( $author_name ) . '</a></span>';
		echo '<span class="badge-item"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

 if( ! function_exists( 'nekit_get_local_time_with_format' )) :
    /**
     * Checks if the paramter format is valid and returns time 
    *
    * @package News Kit Elementor Addons
    * @since 1.0.0
    */
    function nekit_get_local_time_with_format() {
        $current_time = localtime(time(), true);
        $time = $current_time['tm_hour'] . ' : ' . $current_time['tm_min'] . ' : ' . $current_time['tm_sec'];
        return apply_filters( 'nekit_get_local_time_with_format_filter', $time );
    }
 endif;

 if( ! function_exists( 'nekit_get_random_news_url' )) :
    /**
     * Checks if the the post exists or returns site url 
    *
    * @package News Kit Elementor Addons
    * @since 1.0.0
    */
    function nekit_get_random_news_url() {
        $random_news = get_posts([
            'numberposts' => 1,
            'post_type' => 'post',
            'ignore_sticky_posts'   => true,
            'orderby' => 'rand'
        ]);
        $url = ($random_news) ? get_the_permalink($random_news[0]->ID ) : home_url();
        return apply_filters( 'nekit_get_random_news_url_filter', esc_url($url) );
    }
 endif;

 if( ! function_exists( 'nekit_get_widgets_post_order_options_array' )) :
    /**
     * Generates the possible order and orderby paramter and returns the array options 
    *
    * @package News Kit Elementor Addons
    * @since 1.0.0
    */
    function nekit_get_widgets_post_order_options_array() {
        $post_order_args = [
            'date-desc' => esc_html__( 'Newest - Oldest', 'news-kit-elementor-addons' ),
            'date-asc'  => esc_html__( 'Oldest - Newest', 'news-kit-elementor-addons' )
        ];
        return apply_filters( 'nekit_get_widgets_post_order_options_array_filter', $post_order_args );
    }
 endif;

 if( ! function_exists( 'nekit_get_card_skin_effects_array' )) :
    /**
     * Generates the possible card skin array options 
    *
    * @package News Kit Elementor Addons
    * @since 1.0.0
    */
    function nekit_get_card_skin_effects_array() {
        $card_skin_effects_args = [
            'none'	=>	esc_html__( 'None', 'news-kit-elementor-addons' ),
            'one'	=>	esc_html__( 'Effect 1', 'news-kit-elementor-addons' )
        ];
        return apply_filters( 'nekit_get_card_skin_effects_array_filter', $card_skin_effects_args );
    }
 endif;

 if( ! function_exists( 'nekit_get_post_title_animation_effects_array' )) :
    /**
     * Generates the possible post title animation array options
    *
    * @package News Kit Elementor Addons
    * @since 1.0.0
    */
    function nekit_get_post_title_animation_effects_array() {
        $post_title_animation_args = [
            'none'	=>  esc_html__( 'None', 'news-kit-elementor-addons' ),
            'one'	=>  esc_html__( 'Effect 1', 'news-kit-elementor-addons' ),
            'two'	=>  esc_html__( 'Effect 2', 'news-kit-elementor-addons' )
        ];
        return apply_filters( 'nekit_get_post_title_animation_effects_array_filter', $post_title_animation_args );
    }
 endif;

 if( ! function_exists( 'nekit_get_widgets_post_count_max' ) ) :
    /**
     * Filters the widgets post count max parameter value
     * 
     * @since 1.0.0
     */
    function nekit_get_widgets_post_count_max( $widget = 'widget' ) {
        switch( $widget ) {
            case 'nekit-full-width-banner': $count = 4;
                                break;
            case 'nekit-main-banner-five': $count = 4;
                                break;
            case 'nekit-main-banner-five-trail': $count = 8;
                                break;
            case 'nekit-main-banner-four': $count = 4;
                                break;
            case 'nekit-main-banner-one': $count = 4;
                                break;
            case 'nekit-main-banner-three': $count = 4;
                                break;
            case 'nekit-main-banner-three-trail': $count = 3;
                                break;
            case 'nekit-main-banner-two': $count = 4;
                                break;
            case 'nekit-news-block-one': $count = 6;
                                break;
            case 'nekit-news-block-two': $count = 5;
                                break;
            case 'nekit-news-block-three': $count = 4;
                                break;
            case 'nekit-news-block-four': $count = 4;
                                break;
            case 'nekit-news-filter-one': $count = 6;
                                break;
            case 'nekit-news-filter-two': $count = 5;
                                break;
            case 'nekit-news-filter-three': $count = 4;
                                break;
            case 'nekit-news-filter-four': $count = 4;
                                break;
            default: $count = 6;
        }
        return apply_filters( 'nekit_get_widgets_post_count_max_filter', $count );
    }
endif;

if( ! function_exists( 'nekit_get_advanced_heading_layouts_array' ) ) :
    /**
     * Filters the widgets columns max parameter value
     * 
     * @since 1.0.0
     */
    function nekit_get_advanced_heading_layouts_array() {
        $args = [
            'one'   =>  [
                'title' =>  esc_html__( 'Layout One','news-kit-elementor-addons' ),
                'image'   =>  NEKIT_URL . 'admin/assets/images/layouts/advanced-heading/six.jpg'
            ],
            'two'   =>  [
                'title' =>  esc_html__( 'Layout Two','news-kit-elementor-addons' ),
                'image'   =>  NEKIT_URL . 'admin/assets/images/layouts/advanced-heading/five.jpg'
            ],
            'three'   =>  [
                'title' =>  esc_html__( 'Layout Three','news-kit-elementor-addons' ),
                'image'   =>  NEKIT_URL . 'admin/assets/images/layouts/advanced-heading/seven.jpg'
            ],
            'four'   =>  [
                'title' =>  esc_html__( 'Layout Four','news-kit-elementor-addons' ),
                'image'   =>  NEKIT_URL . 'admin/assets/images/layouts/advanced-heading/three.jpg'
            ],
            'five'   =>  [
                'title' =>  esc_html__( 'Layout Five','news-kit-elementor-addons' ),
                'image'   =>  NEKIT_URL . 'admin/assets/images/layouts/advanced-heading/two.jpg'
            ]
        ];
        return apply_filters( 'nekit_pro_get_advanced_heading_layouts_array_filter', $args );
    }
endif;

if( ! function_exists( 'nekit_get_advanced_heading_animation_options_array' ) ) :
    /**
     * Filters the animation options parameter value
     * 
     * @since 1.0.0
     */
    function nekit_get_advanced_heading_animation_options_array() {
        $args = [
            'slide_up'  =>  esc_html__( 'Slide Up', 'news-kit-elementor-addons' ),
            'slide_down'=>  esc_html__( 'Slide Down', 'news-kit-elementor-addons' ),
            'slide_right'   =>  esc_html__( 'Slide Right', 'news-kit-elementor-addons' ),
            'slide_left'    =>  esc_html__( 'Slide Left', 'news-kit-elementor-addons' )
        ];
        return apply_filters( 'nekit_get_advanced_heading_animation_options_array_filter', $args );
    }
endif;

if( ! function_exists( 'nekit_get_advanced_heading_animation_shape_options_array' ) ) :
    /**
     * Filters the animation shape options parameter value
     * 
     * @since 1.0.0
     */
    function nekit_get_advanced_heading_animation_shape_options_array() {
        $args = [
            'circle'    =>  esc_html__( 'Circle', 'news-kit-elementor-addons' ),
            'underline_zigzag'  =>  esc_html__( 'Underline Zigzag', 'news-kit-elementor-addons' )
        ];
        return apply_filters( 'nekit_get_advanced_heading_animation_shape_options_array_filter', $args );
    }
endif;

if( ! function_exists( 'nekit_get_advanced_heading_text_style_options_array' ) ) :
    /**
     * Filters the animation text style options parameter value
     * 
     * @since 1.0.0
     */
    function nekit_get_advanced_heading_text_style_options_array() {
        $args = [
            'normal'    => esc_html__( 'Normal', 'news-kit-elementor-addons' ),
            'animated'  => esc_html__( 'Animated', 'news-kit-elementor-addons' ),
            'highlighted'   => esc_html__( 'Highlighted', 'news-kit-elementor-addons' )
        ];
        return apply_filters( 'nekit_get_advanced_heading_text_style_options_array_filter', $args );
    }
endif;

if( ! function_exists( 'nekit_get_social_share_url_options_array' ) ) :
    /**
     * Filters the social share urls options array values
     * 
     * @since 1.0.0
     */
    function nekit_get_social_share_url_options_array() {
        $postUrl = 'http' . ( isset( $_SERVER['HTTPS'] ) ? 's' : '' ) . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $args = [
            'facebook'  =>  'https://www.facebook.com/sharer/sharer.php?u=',
            'twitter'   =>  'https://twitter.com/intent/tweet?url=',
            'linkedin'  =>  'https://www.linkedin.com/sharing/share-offsite/?url=',
            'email' =>  'mailto:?subject={title}&body=',
            'gmail' =>  'https://mail.google.com/mail/?view=cm&to={email_address}&su={title}&body=',
            'instagram' =>  'http://www.instagram.com',
            'whatsapp'  =>  'https://api.whatsapp.com/send?phone={phone_number}&text='
        ];
        return apply_filters( 'nekit_get_social_share_url_options_array_filter', $args );
    }
endif;

if( ! function_exists( 'nekit_get_widgets_column_max' ) ) :
    /**
     * Filters the widgets columns max parameter value
     * 
     * @since 1.0.0
     */
    function nekit_get_widgets_column_max() {
        return apply_filters( 'nekit_get_widgets_column_max_filter', 3 );
    }
endif;

if( ! function_exists( 'nekit_get_widgets_column_gap_max' ) ) :
    /**
     * Filters the widgets column gap max parameter value
     * 
     * @since 1.0.0
     */
    function nekit_get_widgets_column_gap_max( ) {
        return apply_filters( 'nekit_get_widgets_column_gap_max_filter', 4 );
    }
endif;

if( ! function_exists( 'nekit_get_widgets_row_gap_max' ) ) :
    /**
     * Filters the widgets row gap max parameter value
     * 
     * @since 1.0.0
     */
    function nekit_get_widgets_row_gap_max( ) {
        return apply_filters( 'nekit_get_widgets_row_gap_max_filter', 4 );
    }
endif;

 if( ! function_exists( 'nekit_convert_number_to_numeric_string' )) :
    /**
     * Function to convert int parameter to numeric string
     * 
     * @return string
     */
    function nekit_convert_number_to_numeric_string( $int ) {
        switch( $int ){
            case 2:
                return "two";
                break;
            case 3:
                return "three";
                break;
            case 4:
                return "four";
                break;
            case 5:
                return "five";
                break;
            case 6:
                return "six";
                break;
            default:
                return "one";
        }
    }
 endif;
 
 if( ! function_exists( 'nekit_get_posts_date' ) ) :
    /**
     * Function to add date value
     * 
     * @return html string
     */
    function nekit_get_posts_date( $base ) {
        $target = isset( $base['target'] ) ? $base['target'] : '_self';
        $date_string = get_the_date();
        $position = isset( $base['base'] ) ? $base['base'] : 'prefix';
        if( ! nekit_get_base_value( $base )  ) $position = 'none';
        switch($position) {
            case 'suffix': $fnc_value = sprintf( '<span class="post-published-date">%1s</span><span class="published-date-context post-published-date-suffix">%s</span>', $date_string, nekit_get_base_value( $base ) );
                 break;
            case 'prefix': $fnc_value = sprintf( '<span class="published-date-context post-published-date-prefix">%s</span><span class="post-published-date">%1s</span>', nekit_get_base_value( $base ) , $date_string );
                 break;
            default: $fnc_value = sprintf( '<span class="post-published-date">%1s</span>', $date_string );
        }
        
        if( isset( $base['url'] ) && $base['url'] == 'yes'  ){
            return apply_filters('nekit_posts_date_apply_url_filter', [$fnc_value, $target] );
        } else {
            return apply_filters( 'nekit_posts_date_filter', $fnc_value );
        }
    }
 endif;

 if( ! function_exists( 'nekit_get_posts_comments' ) ) :
    /**
     * Function to add comments number value
     * 
     * @return html string
     */
    function nekit_get_posts_comments( $base ) {
        $comments_string = get_comments_number();
        $position = isset( $base['base'] ) ? $base['base'] : 'default';
        if( ! nekit_get_base_value( $base ) ) $position = 'none';
        switch($position) {
            case 'suffix': $fnc_value = sprintf( '<span class="post-comments">%1s</span><span class="post-comments-suffix post-comments-context">%s</span>', $comments_string, nekit_get_base_value( $base ) );
                 break;
            case 'prefix': $fnc_value = sprintf( '<span class="post-comments-prefix post-comments-context">%s</span><span class="post-comments">%1s</span>', nekit_get_base_value( $base ), $comments_string );
                 break;
            default: $fnc_value = sprintf( '<span class="post-comments">%1s</span>', $comments_string );
        }
        return apply_filters( 'nekit_posts_comments_filter', $fnc_value );
    }
 endif;

 if( ! function_exists( 'nekit_get_post_excerpt_output' ) ) :
    /**
     * Function to trim the excerpt content
     * 
     * @return html string
     */
    function nekit_get_post_excerpt_output($length) {
        $excerpt = get_the_excerpt();
        if( ! $excerpt ) return;
    ?>
        <div class="post-excerpt"><?php echo wp_kses_post(apply_filters( 'nekit_get_post_excerpt_output_filter', $excerpt, $length )); ?></div>
    <?php
    }
 endif;

 if( ! function_exists( 'nekit_get_posts_author' ) ) :
    /**
     * Function to add author value
     * 
     * @return html string
     */
    function nekit_get_posts_author( $base ) {
        $target = isset ( $base['target'] ) ? $base['target'] : '_self';
        $author_string = get_the_author();
        $position = isset( $base['base'] ) ? $base['base'] : 'default';
        if( ! nekit_get_base_value( $base ) ) $position = 'none';
        switch($position) {
            case 'suffix': $fnc_value = sprintf( '<span class="post-author">%1s</span><span class="post-author-suffix author-context">%s</span>', $author_string, nekit_get_base_value( $base ) );
                 break;
            case 'prefix': $fnc_value = sprintf( '<span class="post-author-prefix author-context">%s</span><span class="post-author">%1s</span>', nekit_get_base_value( $base ), $author_string );
                 break;
            default: $fnc_value = sprintf( '<span class="post-author">%1s</span>', $author_string );
        }
        if( isset( $base['url'] ) && $base['url'] == 'yes' ){
            return apply_filters( 'nekit_posts_author_apply_url_filter', [$fnc_value,$target] );
        } else {
            return apply_filters( 'nekit_posts_author_filter', $fnc_value );
        }
    }
 endif;

 if( ! function_exists( 'nekit_get_base_value' ) ) :
    /**
     * Function to add base value
     * 
     * @return html string
     */
    function nekit_get_base_value($base_value) {
        if( isset( $base_value['text'] ) && $base_value['text'] ) {
            return esc_html($base_value['text']);
        } else {
            if( isset($base_value['icon']) && $base_value['icon']['library'] == 'svg' ) :
                return '<img src="' .esc_url($base_value['icon']['value']['url']). '"/>';
            else :
                if( empty( $base_value['icon']['value'] ) ) {
                    return '';
                } else {
                    return '<i class="' .esc_attr($base_value['icon']['value']). '"></i>';
                }
            endif;
        }
    }
 endif;

 if( ! function_exists( 'nekit_get_base_attribute_value' ) ) :
    /**
     * Function to add base value
     * 
     * @return html string
     */
    function nekit_get_base_attribute_value($base_value) {
        if( isset( $base_value['text'] ) && $base_value['text'] ) {
            return esc_html($base_value['text']);
        } else {
            if( isset($base_value['icon']) && $base_value['icon']['library'] == 'svg' ) :
                return esc_url($base_value['icon']['value']['url']);
            else :
                if( empty( $base_value['icon']['value'] ) ) {
                    return esc_attr('no-icon');
                } else {
                    return esc_attr($base_value['icon']['value']);
                }
            endif;
        }
    }
 endif;

 if( ! function_exists( 'nekit_get_switcher_attr_value' ) ) :
    /**
     * Function to convert switcher value to string
     * 
     * @return html string
     */
    function nekit_get_switcher_attr_value($switcher_value) {
        $switcher_value = ( $switcher_value == 'yes' ) ? 'yes' : 'no';
        return esc_html($switcher_value);
    }
 endif;

 if( !function_exists( 'nekit_get_settings' ) ) :
    /**
     * Function that retrives the plugin settings
     * 
     * @return array
     * @params empty
     */
    function nekit_get_settings($args = []) {
        if( ! isset($args['key']) && empty($args['key']) ) {
            $settings = get_option('nekit_admin_settings');
            return apply_filters ( 'nekit_get_settings_filter', $settings );
        } else {
            $settings = get_option('nekit_admin_settings');
            if( $settings ) {
                $settings = isset( $settings[$args['key']] ) ? $settings[$args['key']]: '';
                return apply_filters ( 'nekit_get_settings_filter', $settings );
            } else {
                return apply_filters ( 'nekit_get_settings_filter', $settings );
            }
            
        }
    }
 endif;

 if( !function_exists( 'nekit_update_settings' ) ) :
    /**
     * Function that updates the plugin settings
     * 
     * @return array
     * @params empty
     */
    function nekit_update_settings($setting) {
        $settings = get_option('nekit_admin_settings');
        if( $settings ) {
            $old_settings = $settings;
            $settings[$setting['key']] = $setting['value'];
        } else {
            $settings = [];
            $settings[$setting['key']] = $setting['value'];
        }
        if( isset( $old_settings ) ) update_option( 'nekit_admin_old_settings', $old_settings );
        return update_option( 'nekit_admin_settings', $settings );
    }
endif;

if( !function_exists( 'nekit_delete_settings' ) ) :
    /**
     * Function that deletes the plugin settings
     * 
     * @return array
     * @params empty
     */
    function nekit_delete_settings($setting) {
        $settings = get_option('nekit_admin_settings');
        if( $settings ) {
            $old_settings = $settings;
            foreach( $old_settings[$setting['key']] as $old_setting_index => $old_setting ) {
                if( $old_setting['id'] == $setting['id']  ) {
                    unset($settings[$setting['key']][$old_setting_index]);
                }
            }
            update_option( 'nekit_admin_old_settings', $old_settings );
        }
        return update_option( 'nekit_admin_settings', $settings );
    }
endif;

if( !function_exists( 'nekit_get_conditions_settings_builder_id' ) ) :
    /**
     * Function that gets the plugin conditions settings
     * 
     * @return array
     * @params empty
     */
    function nekit_get_conditions_settings_builder_id($setting) {
        if( $setting['parent'] !== '404-builder' ) :
            $builder_update_compatibility_args = [
                'post_type' => 'nekit-mm-cpt',
                'meta_query'	=>	[
                    [
                        'key'	=>	'nekit_builder_in_use',
                        // 'value'	=>	$setting['parent'],
                        'compare'	=>	'NOT EXISTS'
                    ]
                ]
            ];
            $builder_update_compatibility_query = new WP_Query( $builder_update_compatibility_args );
            if( $builder_update_compatibility_query->have_posts() ) :
                while( $builder_update_compatibility_query->have_posts() ) :
                    $builder_update_compatibility_query->the_post();
                    if( ! metadata_exists( 'post', get_the_ID(), 'nekit_builder_in_use' ) ) update_post_meta( get_the_ID(), 'nekit_builder_in_use', true );   /* update compatible */
                endwhile;
                wp_reset_postdata();
            endif;
        endif;
        $builder_posts_args = [
            'post_type' => 'nekit-mm-cpt',
            'meta_query'    => [
                [
                    'key'   => 'builder_type',
                    'value' => esc_html($setting['parent']),
                    'compare'  => '='
                ],
                [
                    'key' => 'nekit_builder_in_use',
                    'value' => '1',
                    'compare' => '='
                ]
            ]
        ];
        if( $setting['parent'] == '404-builder' ) {
            $nekit_404_active_template = get_option( 'nekit_404_active_template' );
            if( ! $nekit_404_active_template ) return;
            $builder_posts_args['post_to_include'] = [$nekit_404_active_template];
            $builder_posts = get_posts($builder_posts_args);
            if( $builder_posts ) {
                return $builder_posts[0]->ID;
            } else {
                return false;
            }
        }
        if( ! in_array( $setting['parent'], ['single-builder', 'archive-builder'] ) ) {
            $builder_posts_args['meta_query'][] = [
                'key'   => 'builder_placement',
                'value' => esc_html($setting['child']),
                'compare'  => 'LIKE'
            ];
            $builder_posts_args['meta_query'][] = [
                'key'   => 'builder_placement_exclude',
                'value' => esc_html($setting['child']),
                'compare'  => 'NOT LIKE'
            ];
        }
        if( $setting['parent'] == 'single-builder' ) {
            if( is_singular() && ! is_front_page() ) { // on single post and page
                $current_post_id = get_the_ID();
                $builder_posts_args['meta_query'][] = [
                    'relation'  => "OR",
                    [
                        'key'   => 'builder_placement',
                        'value' => esc_html($setting['child']),
                        'compare'  => 'LIKE'
                    ],
                    [
                        'key'   => 'builder_placement',
                        'value' => esc_html('nekit' .$current_post_id. 'nekit'),
                        'compare'  => 'LIKE'
                    ]
                ];
                $builder_posts_args['meta_query'][] = [
                    'key'   => 'builder_placement_exclude',
                    'value' => esc_html('nekit' .$current_post_id. 'nekit'),
                    'compare'  => 'NOT LIKE'
                ];
            } else {
                $builder_posts_args['meta_query'][] = [
                    'key'   => 'builder_placement',
                    'value' => esc_html($setting['child']),
                    'compare'  => 'LIKE'
                ];
            }
        }

        if( $setting['parent'] == 'archive-builder' ) {
            if( is_category() || is_author() || is_tag() ) { // on category, tags and author archive page
                $current_archive_id = get_queried_object_id();
                $builder_posts_args['meta_query'][] = [
                    'relation' => 'OR',
                    [
                        'key'   => 'builder_placement',
                        'value' => esc_html($setting['child']),
                        'compare'  => 'LIKE'
                    ],
                    [
                        'key'   => 'builder_placement',
                        'value' => esc_html('nekit' .$current_archive_id. 'nekit'),
                        'compare'  => 'LIKE'
                    ]
                ];
                $builder_posts_args['meta_query'][] = [
                    'key'   => 'builder_placement_exclude',
                    'value' => esc_html('nekit' .$current_archive_id. 'nekit'),
                    'compare'  => 'NOT LIKE'
                ];
            } else {
                $builder_posts_args['meta_query'][] = [
                    'key'   => 'builder_placement',
                    'value' => esc_html($setting['child']),
                    'compare'  => 'LIKE'
                ];
            }
        }

        $builder_posts = get_posts($builder_posts_args);
        if( $builder_posts ) {
            if( $setting['parent'] === 'popup-builder' ) :
                if( ! empty( $builder_posts ) ) :
                    $builder_ids = [];
                    foreach( $builder_posts as $popup_builder ) :
                        $builder_ids[] = $popup_builder->ID;
                    endforeach;
                    return $builder_ids;
                endif;
            else :
                return $builder_posts[0]->ID;
            endif;
        } else {
            $is_archives = strpos( $setting['child'], 'archive' );
            $is_singular = strpos( $setting['child'], 'singular' );
            if( $is_archives !== false ) {
                $builder_posts_args = [
                    'post_type' => 'nekit-mm-cpt',
                    'meta_query'    => [
                        [
                            'key'   => 'builder_type',
                            'value' => esc_html($setting['parent']),
                            'compare'  => '='
                        ],
                        [
                            'relation'  => 'OR',
                            [
                                'key'   => 'builder_placement',
                                'value' => 'archives-all',
                                'compare'  => 'LIKE'
                            ],
                            [
                                'key'   => 'builder_placement',
                                'value' => esc_html( $setting['child'] ),
                                'compare'  => 'LIKE'
                            ]
                        ],
                        [
                            'key'   => 'builder_placement_exclude',
                            'value' => esc_html($setting['child']),
                            'compare'  => 'NOT LIKE'
                        ],
                        [
                            'key' => 'nekit_builder_in_use',
                            'value' => '1',
                            'compare' => '='
                        ]
                    ]
                ];
                $builder_posts = get_posts($builder_posts_args);
                if( $builder_posts ) {
                    if( $setting['parent'] === 'popup-builder' ) :
                        if( ! empty( $builder_posts ) ) :
                            $builder_ids = [];
                            foreach( $builder_posts as $popup_builder ) :
                                $builder_ids[] = $popup_builder->ID;
                            endforeach;
                            return $builder_ids;
                        endif;
                    else :
                        return $builder_posts[0]->ID;
                    endif;
                } else {
                    $builder_placement_value = 'entire-site';
                    if( in_array( $setting['parent'], ['archive-builder', 'single-builder'] ) ) {
                        $builder_placement_value = 'all';
                    }
                    $builder_posts_args = [
                        'post_type' => 'nekit-mm-cpt',
                        'meta_query'    => [
                            [
                                'key'   => 'builder_placement',
                                'value' => esc_html( $builder_placement_value ),
                                'compare'  => 'LIKE'
                            ],
                            [
                                'key'   => 'builder_placement_exclude',
                                'value' => esc_html($setting['child']),
                                'compare'  => 'NOT LIKE'
                            ],
                            [
                                'key'   => 'builder_type',
                                'value' => esc_html($setting['parent']),
                                'compare'  => '='
                            ],
                            [
                                'key' => 'nekit_builder_in_use',
                                'value' => '1',
                                'compare' => '='
                            ]
                        ]
                    ];
                    $builder_posts = get_posts($builder_posts_args);
                    if( $builder_posts ) {
                        if( $setting['parent'] === 'popup-builder' ) :
                            if( ! empty( $builder_posts ) ) :
                                $builder_ids = [];
                                foreach( $builder_posts as $popup_builder ) :
                                    $builder_ids[] = $popup_builder->ID;
                                endforeach;
                                return $builder_ids;
                            endif;
                        else :
                            return $builder_posts[0]->ID;
                        endif;
                    } else {
                        return false;
                    }
                }
            } else if( $is_singular !== false ) {
                $builder_posts_args = [
                    'post_type' => 'nekit-mm-cpt',
                    'meta_query'    => [
                        [
                            'key'   => 'builder_placement',
                            'value' => 'singular-all',
                            'compare'  => 'LIKE'
                        ],
                        [
                            'key'   => 'builder_placement_exclude',
                            'value' => esc_html($setting['child']),
                            'compare'  => 'NOT LIKE'
                        ],
                        [
                            'key'   => 'builder_type',
                            'value' => esc_html($setting['parent']),
                            'compare'  => '='
                        ],
                        [
                            'key' => 'nekit_builder_in_use',
                            'value' => '1',
                            'compare' => '='
                        ]
                    ]
                ];
                $builder_posts = get_posts($builder_posts_args);
                if( $builder_posts ) {
                    if( $setting['parent'] === 'popup-builder' ) :
                        if( ! empty( $builder_posts ) ) :
                            $builder_ids = [];
                            foreach( $builder_posts as $popup_builder ) :
                                $builder_ids[] = $popup_builder->ID;
                            endforeach;
                            return $builder_ids;
                        endif;
                    else :
                        return $builder_posts[0]->ID;
                    endif;
                } else {
                    $builder_posts_args = [
                        'post_type' => 'nekit-mm-cpt',
                        'meta_query'    => [
                            [
                                'key'   => 'builder_placement',
                                'value' => 'entire-site',
                                'compare'  => 'LIKE'
                            ],
                            [
                                'key'   => 'builder_placement_exclude',
                                'value' => esc_html($setting['child']),
                                'compare'  => 'NOT LIKE'
                            ],
                            [
                                'key'   => 'builder_type',
                                'value' => esc_html($setting['parent']),
                                'compare'  => '='
                            ],
                            [
                                'key' => 'nekit_builder_in_use',
                                'value' => '1',
                                'compare' => '='
                            ]
                        ]
                    ];
                    $builder_posts = get_posts($builder_posts_args);
                    if( $builder_posts ) {
                        if( $setting['parent'] === 'popup-builder' ) :
                            if( ! empty( $builder_posts ) ) :
                                $builder_ids = [];
                                foreach( $builder_posts as $popup_builder ) :
                                    $builder_ids[] = $popup_builder->ID;
                                endforeach;
                                return $builder_ids;
                            endif;
                        else :
                            return $builder_posts[0]->ID;
                        endif;
                    } else {
                        return false;
                    }
                }
            } else {
                $builder_posts_args = [
                    'post_type' => 'nekit-mm-cpt',
                    'meta_query'    => [
                        [
                            'key'   => 'builder_placement',
                            'value' => 'entire-site',
                            'compare'  => 'LIKE'
                        ],
                        [
                            'key'   => 'builder_placement_exclude',
                            'value' => esc_html($setting['child']),
                            'compare'  => 'NOT LIKE'
                        ],
                        [
                            'key'   => 'builder_type',
                            'value' => esc_html($setting['parent']),
                            'compare'  => '='
                        ],
                        [
                            'key' => 'nekit_builder_in_use',
                            'value' => '1',
                            'compare' => '='
                        ]
                    ]
                ];
                $builder_posts = get_posts( $builder_posts_args );
                if( $builder_posts ) {
                    if( $setting['parent'] === 'popup-builder' ) :
                        if( ! empty( $builder_posts ) ) :
                            $builder_ids = [];
                            foreach( $builder_posts as $popup_builder ) :
                                $builder_ids[] = $popup_builder->ID;
                            endforeach;
                            return $builder_ids;
                        endif;
                    else :
                        return $builder_posts[0]->ID;
                    endif;
                } else {
                    return false;
                }
            }
        }
    }
endif;

if( !function_exists( 'nekit_get_builders' ) ) :
    /**
     * Function that extracts the builder w.r.t given parameter
     * 
     * @return array
     * @params empty
     */
    function nekit_get_builders($builder_type) {
        if( 'saved-templates' == $builder_type ) {
            $builder_posts_args = [
                'post_type' => 'elementor_library',
                'meta_key' => '_elementor_template_type',
			    'meta_value' => ['page', 'section', 'container'],
                'posts_per_page'  => -1
            ];
        } else {
            $builder_posts_args = [
                'post_type' => 'nekit-mm-cpt',
                'posts_per_page'  => -1,
                'meta_query'    => [
                    [
                        'key'   => 'builder_type',
                        'value' => esc_html($builder_type),
                        'compare'  => '='
                    ]
                ]
            ];
        }
        $builder_posts = get_posts($builder_posts_args);
        if( $builder_posts ) {
            $builder_posts_info = [];
            foreach( $builder_posts as $builder_post ) :
                if( ! metadata_exists( 'post', $builder_post->ID, 'nekit_builder_in_use' ) ) :  /* update compatible */
                    update_post_meta( $builder_post->ID, 'nekit_builder_in_use', true );
                endif;

                $builder_posts_info[] = [
                    'id'    => absint( $builder_post->ID ),
                    'title' => esc_html($builder_post->post_title),
                    'builder_placement' => get_post_meta($builder_post->ID, 'builder_placement', true),
                    'builder_placement_exclude' => get_post_meta($builder_post->ID, 'builder_placement_exclude', true),
                    'nekit_builder_in_use' => get_post_meta( $builder_post->ID, 'nekit_builder_in_use', true )
                ];
            endforeach;
            return apply_filters( 'nekit_builder_info_filter', $builder_posts_info );
        } else {
            return apply_filters( 'nekit_builder_info_filter', false );
        }
    }
endif;

if( !function_exists( 'nekit_update_builder_post_meta' ) ) :
    /**
     * Function that updates the builder meta settings
     * 
     * @return array
     * @params empty
     */
    function nekit_update_builder_post_meta($conditionType, $builder_placement, $builder_id) {
        // update the builder condition
        if( $conditionType == 'include' ) :
            $current_builder_previous_data = get_post_meta( $builder_id, 'builder_placement', true );
            $found_key = array_search( $builder_placement, $current_builder_previous_data, true );
            if( ! $found_key ) {
                $current_builder_previous_data[] = esc_html($builder_placement);
                $update_builder_meta = update_post_meta( $builder_id, 'builder_placement', $current_builder_previous_data );
                return $update_builder_meta;
            } else {
                return false;
            }
        else : // update exclude condition
            $current_builder_previous_data = get_post_meta( $builder_id, 'builder_placement_exclude', true );
            $found_key = array_search( $builder_placement, $current_builder_previous_data, true );
            if( ! $found_key ) {
                $current_builder_previous_data[] = esc_html($builder_placement);
                $update_builder_meta = update_post_meta( $builder_id, 'builder_placement_exclude', $current_builder_previous_data );
                return $update_builder_meta;
            } else {
                return false;
            }
        endif;
    }
endif;

if( ! function_exists( 'nekit_get_social_platform_html' ) ) :
    /**
     * Function that returns social platform html
     * 
     * @return array
     * @params takes target attribute
     */
    function nekit_get_social_platform_html( $target ) {
        $social_platforms_args = [
            'facebook_url'  =>  'fab fa-facebook-square',
            'twitter_url'   =>  'fab fa-twitter-square',
            'linkedin_url' =>  'fab fa-linkedin',
            'instagram_url' =>  'fab fa-instagram-square',
            'youtube_url'   =>  'fab fa-youtube',
            'tiktok_url'    =>  'fab fa-tiktok',
            'whatsapp_url'  =>  'fab fa-whatsapp-square',
            'reddit_url'    =>  'fab fa-reddit-square',
            'wechat_url'    =>  'fab fa-weixin',
            'tumblr_url'    =>  'fab fa-tumblr-square',
            'sina_weibo_url'    =>  'fab fa-weibo',
            'google_plus_url'   =>  'fab fa-google-plus-square',
            'discord_url'   =>  'fab fa-discord',
            'flickr_url'    =>  'fab fa-flickr',
            'skype_url' =>  'fab fa-skype',
            'snapchat_url'  =>  'fab fa-snapchat-square',
            'telegram_url'  =>  'fab fa-telegram-plane'
        ];
        $social_platforms_return_values = [];
        if( $social_platforms_args ) :
            foreach( $social_platforms_args as $social_platform => $social_icon ) :
                $platform = get_the_author_meta( $social_platform );
                if( ! empty( $platform ) ) :
                    $social_platforms_return_values[] = '<span class="platform-icon"><a href="'. esc_url( $platform ). '" target="'.esc_attr( $target ).'"><i class="'. esc_attr( $social_icon ) .'"></i></a></span>';
                endif;
            endforeach;
        endif;
        return $social_platforms_return_values;
    }
endif;

if( ! function_exists( 'nekit_get_post_categories' ) ) :
    /**
     * Function contains post categories html
     * @return float
     */
    function nekit_get_post_categories( $post_id, $number ) {
    	$n_categories = wp_get_post_categories($post_id, array( 'number' => absint( $number ) ));
		echo '<ul class="post-categories">';
			foreach( $n_categories as $n_category ) :
				echo '<li class="cat-item ' .esc_attr( 'cat-' . $n_category ). '"><a href="' .esc_url( get_category_link( $n_category ) ). '" rel="category tag">' .esc_html(get_cat_name( $n_category )). '</a></li>';
			endforeach;
		echo '</ul>';
    }
endif;

if( ! function_exists( 'nekit_bool_to_string' ) ) :
	// boolean value to string 
	function nekit_bool_to_string( $bool ) {
		$string = ( $bool ) ? '1' : '0';
		return $string;
	}
endif;