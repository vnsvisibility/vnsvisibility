<?php
/**
 * News Block Three
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
 class News_Block_Three extends \Nekit_Modules\Block_Module {
    protected $widget_name = 'nekit-news-block-three';
    public static $widget_count = 'three';

    public function get_custom_help_url() {
        return 'https://blazethemes.com/plugins/blaze-elementor/addons/#nekit-news-block-three';
    }
       
    public function get_keywords() {
        return ['news','block','three'];
    }

    public function nekit_featured_post( $args ) {
        if( $args['show_post_thumbnail'] == 'yes' ) : ?>
            <figure class="post-thumb-wrap">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" <?php echo wp_kses_post($args['image_class']); ?>>
                    <?php
                        if( has_post_thumbnail() ) { 
                            ?>
                            <div class="post-thumb-parent<?php if( $args['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
                                <?php
                                    the_post_thumbnail($args['image_size'], array(
                                        'title' => the_title_attribute(array(
                                            'echo'  => false
                                        ))
                                    ));
                                ?>
                            </div>
                            <?php
                        }
                    ?>
                </a>
                <?php
                    if( $args['show_post_categories'] == 'yes' && $args['widget_count'] != 'two' ) nekit_get_post_categories( get_the_ID(), 2 );
                ?>
            </figure>
        <?php 
        endif;
    }

    protected function render() {
		$settings = $this->get_settings_for_display();
        $settings['widget_count'] = esc_html( $this::$widget_count );
		$elementClass = 'nekit-news-block-' .esc_attr( $this::$widget_count ). '-posts-wrap nekit-block-widget nekit-widget-section';
		$elementClass .= ' skin--' . $settings['widget_skin'];
        $elementClass .= ( $settings['adjust_layout_on_smaller_width'] == 'yes' ) ? ' adjust-layout--on' : ' adjust-layout--off';
        $elementClass .= ' card-animation--' . $settings['card_hover_effects_dropdown'];
		if( $settings['show_post_thumbnail'] != 'yes' ) $elementClass .= ' section-no-thumbnail';
		$elementClass .= ' layout--' . $this::$widget_count;
		$this->add_render_attribute( 'wrapper', 'class', $elementClass );

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
		?>
			<div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
				<div class="news-block-post-wrap">
					<?php
						$posts_args = $this->get_posts_args_for_query();
						$post_query = new \WP_Query($posts_args);
						if( $post_query->have_posts() ) :
                            $settings['maxPage'] = $post_query->max_num_pages;
                            $total_post =  $post_query->post_count;
							while( $post_query->have_posts() ) : $post_query->the_post();
                                $current_post =  $post_query->current_post;
                                if( $current_post % 7 === 0 ) echo '<div class="primary-row paged-1"><div class="featured-post">';
                                    if( $current_post % 7 === 1 ) echo '<div class="trailing-post">';
                                        ?>
                                            <article class="post-item block-item paged-1 <?php if(!has_post_thumbnail()) { echo esc_attr('no-feat-img'); } ?>">
                                                <div class="nekit-item-box-wrap">
                                                    <?php
                                                        $featured_post = [
                                                            'show_post_thumbnail'   => $settings['show_post_thumbnail'],
                                                            'image_overlay_option'   => $settings['image_overlay_option'],
                                                            'image_size'   => $settings['image_size'],
                                                            'image_class'   => $this->get_render_attribute_string( 'image_hover' ),
                                                            'show_post_categories'   => $settings['show_post_categories'],
                                                            'widget_count'   => $this::$widget_count
                                                        ];
                                                        if( $current_post % 7 != 0 ):
                                                            $this->nekit_featured_post( $featured_post );
                                                        endif;
                                                    ?>
                                                    <div class="post-element">
                                                        <div class="post-element-inner">
                                                            <?php
                                                                if( $settings['show_post_categories'] == 'yes' && $this::$widget_count == 'two' ) nekit_get_post_categories( get_the_ID(), 2 );
                                                                $posts_elements_sorting = isset( $settings['posts_elements_sorting'] ) ? $settings['posts_elements_sorting'] : ['post-title', 'post-meta', 'post-excerpt', 'post-button'];
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
                                                    <?php
                                                        if( $current_post % 7 === 0 ) :
                                                            $this->nekit_featured_post( $featured_post );
                                                        endif;
                                                    ?>
                                                </div>
                                            </article>
                                        <?php
                                    if( $current_post % 7 === 0 )  {
                                        echo '</div><!-- .featured-post -->';
                                        if( $total_post == $current_post + 1 ) echo '</div><!-- .primary-row -->';
                                    } else if( $current_post  % 7 === 6 )  {
                                        echo '</div><!-- .trailing-post -->';
                                        echo '</div><!-- .primary-row -->';
                                    } else if( $current_post % 7 > 0 && $total_post == $current_post + 1 ) {
                                        echo '</div><!-- .trailing-post -->';
                                        echo '</div><!-- .primary-row -->';
                                    }
							endwhile;
							wp_reset_postdata();
						endif;
					?>
				</div>
                <?php
					$pagination_type = isset( $settings['pagination_type'] ) ? apply_filters( 'nekit_widget_pagination_get_setting_filter', 'none', $settings['pagination_type'] ) : 'none';
					if( $pagination_type != 'none' ) :
						echo '<div class="nekit-widget-pagination ' .esc_attr( 'type--' . $pagination_type ). '">';
							switch( $pagination_type ) {
								case 'replace': 
									?>
										<div class="button-wrap">
											<button class="pagination-button prev-button nekit-load-more" disabled>
												<?php
													if( nekit_get_base_value(['icon' => $settings['replace_pagination__prev_icon']]) ) echo wp_kses_post( nekit_get_base_value(['icon' => $settings['replace_pagination__prev_icon']]) );
													echo esc_attr( $settings["replace_pagination__prev_text"] );
												?>
											</button>
											<button class="pagination-button next-button nekit-load-more">
												<?php
													echo esc_attr( $settings["replace_pagination__next_text"] );
													if( nekit_get_base_value(['icon' => $settings['replace_pagination__next_icon']]) ) echo wp_kses_post( nekit_get_base_value(['icon' => $settings['replace_pagination__next_icon']]) );
												?>
											</button>
										</div>
									<?php
											break;
								case 'append':
											echo '<button class="nekit-load-more ajax-load">' .esc_html( $settings["append_pagination_button_text"] );
												if( nekit_get_base_value(['icon' => $settings['append_pagination_button_icon']]) ) echo wp_kses_post( nekit_get_base_value(['icon' => $settings['append_pagination_button_icon']]) );
											echo '</button>';
										break;
							}
						echo '</div>';
					endif;
				?>
				<script>
					nekitWidgetData[<?php echo wp_json_encode( $this->get_id() ); ?>] = <?php echo wp_json_encode( $settings ); ?>;
				</script>
			</div>
		<?php
	}
 }