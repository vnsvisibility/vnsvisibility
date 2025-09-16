<?php
/**
 * News Grid Widget Three
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Grid_Widget_Three extends \Nekit_Modules\Grid_Module {
	protected $widget_name = 'nekit-news-grid-three';
	public static $widget_count = 'three';

	public function get_custom_help_url() {
		return 'https://blazethemes.com/plugins/blaze-elementor/addons/#news-grid-widget-three';
	}

    protected function render() {
		$settings = $this->get_settings_for_display();
        $settings['widget_count'] = esc_html( $this::$widget_count );
		$elementClass = 'nekit-news-grid-' .esc_attr( $this::$widget_count ). '-posts-wrap nekit-grid-widget nekit-widget-section';
		$elementClass .= ' skin--' . $settings['widget_skin'];
        if( isset( $settings['post_elements_align'] ) ) {
			$elementClass .= ' alignment--' . $settings['post_elements_align'];
		}
		$elementClass .= ' layout--' . $this::$widget_count;
		$elementClass .= ' card-animation--' . $settings['card_hover_effects_dropdown'];
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

        $widget_column_tablet = isset( $settings['widget_column_tablet'] ) ? $settings['widget_column_tablet'] : 3;
        $widget_column_mobile = isset( $settings['widget_column_mobile'] ) ? $settings['widget_column_mobile'] : 1;
		?>
			<div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
				<div class="news-grid-post-wrap<?php echo esc_attr( ' column--' . nekit_convert_number_to_numeric_string($settings['widget_column']) ); ?> <?php echo esc_attr( ' column-tablet--' . nekit_convert_number_to_numeric_string($widget_column_tablet) ); ?> <?php echo esc_attr( ' column-mobile--' . nekit_convert_number_to_numeric_string($widget_column_mobile) ); ?>">
					<?php
						$posts_args = $this->get_posts_args_for_query();
						$post_query = new \WP_Query($posts_args);
						if( $post_query->have_posts() ) :
							$settings['maxPage'] = $post_query->max_num_pages;
							while( $post_query->have_posts() ) : $post_query->the_post();
								?>
									<article class="post-item grid-item paged-1 <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
										<div class="nekit-item-box-wrap">
											<?php if( $settings['show_post_thumbnail'] = 'yes' ) : ?>
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
                                                    <div class="post-element">
                                                        <div class="post-element-inner">
                                                            <?php
                                                                if( $settings['show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 );
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
												</figure>
											<?php endif; ?>
										</div>
									</article>
								<?php
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
													if( nekit_get_base_value(['icon' => $settings['replace_pagination__prev_icon']]) ) echo wp_kses_post( nekit_get_base_value(['icon' => $settings['replace_pagination__prev_icon']]));
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