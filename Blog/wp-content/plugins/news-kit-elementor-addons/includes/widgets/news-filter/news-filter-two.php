<?php
/**
 * News Filter Two
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class Filter_Widget_Two extends \Nekit_Modules\Filter_Module {
     protected $widget_name = 'nekit-news-filter-two';
     public static $widget_count = 'two';
     
     public function get_custom_help_url() {
         return 'https://blazethemes.com/plugins/blaze-elementor/addons/#nekit-news-filter-two';
        }
        
        public function get_keywords() {
            return ['news','filter','two'];
        }

    protected function render() {
		$settings = $this->get_settings_for_display();        
		$elementClass = 'nekit-news-filter-two nekit-filter-widget nekit-widget-section';
        $elementClass .= ' skin--' . $settings['widget_skin'];
        $elementClass .= ' tab-alignment--' . $settings['tab_alignment'];
        $elementClass .= ( $settings['adjust_layout_on_smaller_width'] == 'yes' ) ? ' adjust-layout--on' : ' adjust-layout--off';
        $elementClass .= ' card-animation--' . $settings['card_hover_effects_dropdown'];
		if( $settings['show_post_thumbnail'] != 'yes' ) $elementClass .= ' section-no-thumbnail';
        $post_categories = $settings['post_categories'];
		$post_authors = $settings['post_authors'];
		$post_tags = $settings['post_tags'];
        $filter_by = is_null( $settings['filter_by'] ) ? 'categories' : $settings['filter_by'];
        $filters = [];
		if( $filter_by == 'categories' && ! empty( $settings['post_categories'] ) ) $filters = $settings['post_categories'];
		if( $filter_by == 'tags' && ! empty( $settings['post_tags'] ) ) $filters = $settings['post_tags'];
		if( $filter_by == 'authors' && ! empty( $settings['post_authors'] ) ) $filters = $settings['post_authors'];
		if( $settings['show_all_tab'] == 'yes' ) array_unshift( $filters, esc_html__( 'All', 'news-kit-elementor-addons' ) );
		$imageClass = '';
		if ( $settings['image_hover_animation'] ) {
            $imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
		}
        $this->add_render_attribute( 'image_hover', 'class', $imageClass );
		$titleClass = 'post-title';
		if( $settings['post_title_animation_choose'] == 'elementor' ) {
            if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
        } else {
            if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
        }
        $this->add_render_attribute( 'title_hover', 'class', $titleClass );       
        $this->add_render_attribute( 'wrapper', 'class', $elementClass );
        $first_element = ( ! empty( $filters ) ) ? $filters[0] : '';
        $tab_id_post = ( $settings['show_all_tab'] == 'yes' && ! empty( $filters ) ) ? ' tab-all' : ' tab-' . $first_element;
        $adjust_layouts = ( $settings['adjust_layout_on_smaller_width'] == 'yes' ) ? 'on' : 'off';
        $settings['imageClass'] = $this->get_render_attribute_string( 'image_hover' );
		$settings['titleClass'] = $this->get_render_attribute_string( 'title_hover' );
		?>
        <script>
            nekitWidgetData[<?php echo wp_json_encode( $this->get_id() ); ?>] = <?php echo wp_json_encode( $settings ); ?>
        </script>
			<div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?> data-adjustLayout="<?php echo esc_attr( $adjust_layouts ); ?>" data-widgetLayout="<?php echo esc_attr( 'two' ); ?>">
                <div class="post_title_filter_wrap">
                    <?php
                        if( $filters ) : 
                            $tab_title = ''; ?>
                                <div class="filter-tab-wrapper">
									<?php
                                        echo '<span class="tab-title active-tab isActive"></span>';
                                        echo '<div class="burger-tab-title-wrap">';
                                            echo '<span class="burger-icon"><i class="fas fa-sort-down"></i></span>';
                                            echo '<div class="tab-title-wrap">';
                                                echo '<ul class="title-list-wrap">';
                                                    foreach( $filters as $postCat => $postCatVal ) :
                                                        $user_name = '';
                                                        if( $settings['show_all_tab'] == 'yes' ){
                                                            $tab_title = ( $postCat > 0 ) ? esc_attr( $postCatVal ) : 'nekit-filter-all';
                                                            if( $postCat > 0 && $filter_by == 'authors' ) $user_name =  get_user_by( 'ID', $postCatVal )->data->display_name;
                                                        }else{
                                                            $tab_title = $postCatVal;
                                                            if( $filter_by == 'authors' ) $user_name =  get_user_by( 'ID', $postCatVal )->data->display_name;
                                                        }
                                                ?>
                                                        <li class="tab-title<?php if( $postCat < 1 ) echo esc_attr( ' isActive' ); ?>" data-tab="<?php echo esc_attr($tab_title); ?>">
                                                            <?php
                                                                if( $postCat == 0 && $settings['show_all_tab'] == 'yes' ) echo esc_html( $postCatVal );
                                                                if( $postCat >= 0 && ( $filter_by == 'categories' ) ) echo esc_html( get_cat_name( $postCatVal ) );
                                                                if( $postCat >= 0 && ( $filter_by == 'tags' ) ) echo esc_html( get_tag( $postCatVal, ARRAY_N ) );
                                                                if( $postCat >= 0 && ( $filter_by == 'authors' ) ) echo esc_html( $user_name );
                                                            ?>
                                                        </li>
                                                <?php
                                                    endforeach;
                                                echo '</ul><!-- .title-list-wrap -->';
                                            echo '</div><!-- .tab-title-wrap -->';
									    echo '</div><!-- .burger-tab-title-wrap -->';
									?>
								</div>
                    <?php endif; ?>
                </div>
                <?php
				    echo '<div class="news-filter-post-wrap isActive'. esc_attr( $tab_id_post ) .'">';
                        echo '<div class="tab-content">';
                            $posts_args = $this->get_posts_args_for_query();
                            if( $settings['show_all_tab'] != 'yes' && $filter_by == 'categories' && ( ! empty( $post_categories ) ) )  $posts_args['cat'] = $post_categories[0];
                            if( $settings['show_all_tab'] != 'yes' && $filter_by == 'tags' && ( ! empty( $post_tags ) ) )  $posts_args['tag__in'] = $post_tags[0];
                            if( $settings['show_all_tab'] != 'yes' && $filter_by == 'authors' && ( ! empty( $post_authors ) ) )  $posts_args['author'] = $post_authors[0];
                            $post_query = new \WP_Query($posts_args);
                            if( $post_query->have_posts() ) :
                                $total_post =  $post_query->post_count;
                                while( $post_query->have_posts() ) : $post_query->the_post();
                                    $current_post =  $post_query->current_post;
                                    if( $current_post === 0 ) echo '<div class="primary-row">';
                                        if( $current_post === 5 ) echo '<div class="secondary-row trailing-post">';
                                            if( $current_post === 0 ) echo '<div class="featured-post">';
                                                if( $current_post === 1 ) echo '<div class="trailing-post">';
                                                    ?>
                                                        <article class="post-item filter-item <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
                                                            <div class="nekit-item-box-wrap">
                                                                <?php if( $settings['show_post_thumbnail'] == 'yes' ) : ?>
                                                                    <figure class="post-thumb-wrap">
                                                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" <?php echo wp_kses_post($this->get_render_attribute_string( 'image_hover' )); ?>>
                                                                            <div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
                                                                                <?php if( has_post_thumbnail() ) { 
                                                                                        the_post_thumbnail($settings['image_size'], array(
                                                                                            'title' => the_title_attribute(array(
                                                                                                'echo'  => false
                                                                                            ))
                                                                                        ));
                                                                                    }
                                                                                ?>
                                                                            </div>
                                                                        </a>
                                                                        <?php
                                                                            if( $settings['show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 );
                                                                        ?>
                                                                    </figure>
                                                                <?php endif; ?>
                                                                <div class="post-element">
                                                                    <div class="post-element-inner">
                                                                        <?php
                                                                            $posts_elements_sorting = isset( $settings['posts_elements_sorting'] ) ? $settings['posts_elements_sorting']: ['post-title', 'post-meta', 'post-excerpt', 'post-button'];
                                                                            foreach( $posts_elements_sorting as $posts_element ) :
                                                                                switch( $posts_element ) {
                                                                                    case 'post-title' : 
                                                                                                        if( $settings['show_post_title'] == 'yes' ) :
                                                                                                            ?>
                                                                                                                <h2 <?php echo wp_kses_post($this->get_render_attribute_string( 'title_hover' )); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                                                                                                            <?php
                                                                                                        endif;
                                                                                                    break;
                                                                                    case 'post-meta' : ?>
                                                                                                        <div class="post-meta">
                                                                                                            <?php
                                                                                                                if( $settings['show_post_author'] == 'yes' ) echo wp_kses_post(nekit_get_posts_author([
                                                                                                                    'base'	=> isset( $settings['post_author_icon_position'] ) ? $settings['post_author_icon_position'] : 'prefix',
                                                                                                                    'icon'	=> isset( $settings['post_author_icon'] ) ? $settings['post_author_icon']: [
                                                                                                                        'value' =>  'far fa-user-circle',
                                                                                                                        'library'   =>  'fa-regular'
                                                                                                                    ],
                                                                                                                    'url'	=>	'yes'
                                                                                                                ]));
                                                                                                                if( $settings['show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
                                                                                                                    'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
                                                                                                                    'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
                                                                                                                        'value' =>  'fas fa-calendar',
                                                                                                                        'library'   =>  'fa-solid'
                                                                                                                    ],
                                                                                                                    'url'	=>	'yes'
                                                                                                                ]));
                                                                                                                if( $settings['show_post_comments'] == 'yes' ) echo wp_kses_post(nekit_get_posts_comments([
                                                                                                                    'base'  =>  isset( $settings['post_comments_icon_position'] ) ? $settings['post_comments_icon_position'] : 'prefix',
                                                                                                                    'icon'  =>  isset( $settings['post_comments_icon'] ) ? $settings['post_comments_icon']: [
                                                                                                                        'value' =>  'far fa-comment',
                                                                                                                        'library'   =>  'fa-regular'
                                                                                                                    ]
                                                                                                                ]));
                                                                                                            ?>
                                                                                                        </div>
                                                                                                        <?php
                                                                                                    break;
                                                                                    case 'post-excerpt' : 
                                                                                                        if( $settings['show_post_excerpt'] == 'yes' ) : 
                                                                                                            nekit_get_post_excerpt_output($settings['show_post_excerpt_length'] ? $settings['show_post_excerpt_length']: 0);
                                                                                                        endif;
                                                                                                        break;
                                                                                    case 'post-button' : if( $settings['show_post_button'] == 'yes' ) : ?>
                                                                                                            <a class="post-link-button" href="<?php the_permalink() ?>">
                                                                                                                <?php echo esc_html( $settings['post_button_text'] ); ?>
                                                                                                                <?php
                                                                                                                    echo wp_kses_post(apply_filters( 'nekit_post_button_icon_output_filter', '<i class="fas fa-angle-right"></i>', isset( $settings['post_button_icon'] ) ? $settings['post_button_icon'] : [
                                                                                                                        'value' => 'fas fa-angle-right',
                                                                                                                        'library'   =>  'fa-solid'
                                                                                                                    ]));
                                                                                                                ?>
                                                                                                            </a>
                                                                                                        <?php
                                                                                                        endif;
                                                                                                        break;
                                                                                }
                                                                            endforeach;
                                                                        ?>
                                                                    </div><!-- .post-element-inner -->
                                                                </div>
                                                            </div>
                                                        </article>
                                                    <?php
                                                if( $current_post === 0 ) {
                                                    echo '</div><!-- .featured-post -->';
                                                    if( $total_post === $current_post + 1 ) echo '</div><!-- .primary-row -->';
                                                } else if( $current_post === 4 ) {
                                                    echo '</div><!-- .trailing-post -->';
                                                    echo '</div><!-- .primary-row -->';
                                                } else if( $current_post < 4 && $total_post === $current_post + 1 ) {
                                                    echo '</div><!-- .trailing-post -->';
                                                    echo '</div><!-- .primary-row -->';
                                                } else if( $current_post > 4 && $total_post === $current_post + 1 ) {
                                                    echo '</div><!-- .secondary-row -->';
                                                } else if( $total_post === $current_post + 1 ) {
                                                    echo '</div><!-- *complete-row -->';
                                                }
                                endwhile;
                                wp_reset_postdata();
                            endif;
                        echo '</div><!-- .tab-content -->';
                    echo '</div><!-- .news-filter-post-wrap -->';
                ?>
			</div>
		<?php
	}
 }