<?php
/**
 * News Carousel Widget Two
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Carousel_Widget_Two extends \Nekit_Modules\Carousel_Module {
	protected $widget_name = 'nekit-news-carousel-two';
	public static $widget_count = 'two';

	public function get_custom_help_url() {
		return 'https://blazethemes.com/plugins/blaze-elementor/addons/#news-carousel-widget-two';
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$elementClass = 'nekit-news-carousel-two-posts-wrap nekit-carousel-widget nekit-widget-section';
		$elementClass .= ' skin--' . $settings['widget_skin'];
        if( isset( $settings['post_elements_align'] ) ) {
			$elementClass .= ' alignment--' . $settings['post_elements_align'];
		}
        $elementClass .= ( $settings['show_slider_arrow_on_hover'] == 'yes' ) ? esc_attr( ' arrow-on-hover--on' ) : esc_attr( ' arrow-on-hover--off' );
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
		$widget_column = ( isset( $settings['widget_column'] ) ) ? $settings['widget_column']: 4;
		$widget_column_tablet = ( isset( $settings['widget_column_tablet'] ) ) ? $settings['widget_column_tablet']: 3;
		$widget_column_mobile = ( isset( $settings['widget_column_mobile'] ) ) ? $settings['widget_column_mobile']: 1;
		?>
            <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
                <div class="news-carousel <?php echo esc_attr( 'layout--' . $this::$widget_count ); ?>">
                    <div class="news-carousel-post-wrap" data-loop="<?php echo esc_attr( nekit_bool_to_string( $settings['carousel_loop'] == 'yes' ) ); ?>" data-arrows="<?php echo esc_attr( nekit_bool_to_string( $settings['carousel_arrows'] == 'yes' ) ); ?>" data-auto="<?php echo esc_attr( nekit_bool_to_string( $settings['carousel_auto'] == 'yes' ) ); ?>" data-columns="<?php echo absint( $settings['widget_column'] ); ?>" data-columns-tablet="<?php echo esc_attr( $widget_column_tablet ); ?>" data-columns-mobile="<?php echo esc_attr( $widget_column_mobile ); ?>"  data-speed="<?php echo esc_attr( $settings['carousel_speed'] ); ?>" data-prev-icon="<?php echo esc_attr( nekit_get_base_attribute_value([ 'icon'	=> $settings['controller_prev_icon'] ]) ); ?>" data-next-icon="<?php echo esc_attr( nekit_get_base_attribute_value([ 'icon'	=> $settings['controller_next_icon'] ]) ); ?>" data-fade="<?php echo esc_attr( nekit_bool_to_string( $settings['carousel_fade'] == 'yes' ) ); ?>">
                        <?php
                            $post_args = $this->get_posts_args_for_query();
                            $post_query = new \WP_Query($post_args);
                            if( $post_query->have_posts() ) :
                                while( $post_query->have_posts() ) : $post_query->the_post();
                                    ?>
                                        <article class="post-item carousel-item <?php if(!has_post_thumbnail()) { echo esc_attr('no-feat-img');} ?>">
                                            <div class="nekit-item-box-wrap">
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
                                                                $posts_elements_sorting = isset( $settings['posts_elements_sorting'] ) ? $settings['posts_elements_sorting']: ['post-categories', 'post-title', 'post-meta'];
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
                                                                        case 'post-categories' : if( $settings['show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 );
                                                                                            break;
                                                                    }
                                                                endforeach;
                                                            ?>
                                                        </div>
                                                    </div>
                                                </figure>
                                            </div>
                                        </article>
                                    <?php
                                endwhile;
								wp_reset_postdata();
                            endif;
                        ?>
                    </div>
                </div>
            </div>
		<?php
	}
}