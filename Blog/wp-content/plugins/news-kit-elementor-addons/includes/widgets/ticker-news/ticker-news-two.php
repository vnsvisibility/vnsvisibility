<?php
/**
 * Ticker News Two Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Ticker_News_Two_Widget extends \Nekit_Modules\Ticker_News_Module {
	protected $widget_name = 'nekit-ticker-news-two';
    public static $widget_count = 'two';

	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/#ticker-news-two-widget';
	}

	public function get_categories() {
		return [ 'nekit-post-layouts-widgets-group' ];
	}

	public function get_keywords() {
		return [ 'news', 'ticker', 'highlight' ];
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		//  post title attributes
		$titleClass = 'post-title';
		if( $settings['post_title_animation_choose'] == 'elementor' ) {
            if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
        } else {
            if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
        }
        $this->add_render_attribute( 'title_hover', 'class', $titleClass );
        $elementClass = 'nekit-ticker-news-two nekit-ticker';
        if( $settings['show_ticker_news_title'] != 'yes' || $settings['ticker_news_title'] == '' ) $elementClass .= ' no-widget-title';
        $nextarrow = ( $settings['slider_next_arrow']['value'] ) ? $settings['slider_next_arrow']['value'] : '';
        $previousarrow = ( $settings['slider_previous_arrow']['value'] ) ? $settings['slider_previous_arrow']['value'] : '';
		$this->add_render_attribute( 'wrapper','class',$elementClass );
		?>
            <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>
                data-arrows="<?php echo esc_attr( wp_json_encode( $settings['slider_settings_arrows'] == 'yes') ); ?>"
                data-autoplay="<?php echo esc_attr( wp_json_encode( $settings['slider_settings_autoplay'] == 'yes' ) ); ?>"
                data-autoplay-speed="<?php echo esc_attr( wp_json_encode( $settings['slider_settings_autoplay_speed'] ) ); ?>"
                data-speed="<?php echo esc_attr( wp_json_encode( $settings['slider_settings_speed'] ) ); ?>"
                data-fade="<?php echo esc_attr( wp_json_encode( $settings['slider_settings_fade'] == 'yes' ) ); ?>"
                data-infinite="<?php echo esc_attr( wp_json_encode( $settings['slider_settings_infinite'] == 'yes') ); ?>"
                data-nextarrow="<?php echo esc_attr( $nextarrow ); ?>"
                data-previousarrow="<?php echo esc_attr( $previousarrow ); ?>"
                data-vertical="<?php echo esc_attr( wp_json_encode( $settings['slider_vertical'] == 'yes' ) ); ?>"
            >
                <?php
                    if( $settings['show_ticker_news_title'] == 'yes' ) :
                        if( $settings['ticker_news_title'] != '' ) :
                            ?>
                                <div class="ticker_label_title ticker-title nekit-ticker-label">
                                    <?php
                                        if( ! empty( $settings['ticker_news_title'] ) ) :
        	                            	?>
                                    		<span class="ticker_label_title_string"><?php echo esc_html( $settings['ticker_news_title'] ); ?></span>
                                	<?php endif; ?>
                                </div>
                            <?php
                        endif;
                    endif;
                ?>
                <div class="nekit-ticker-box">
                    <?php
							$nekit_direction = 'left';
							$nekit_dir = 'ltr';
                            if( is_rtl() ) :
                                $nekit_direction = 'right';
                                $nekit_dir = 'ltr';
                            endif;
                    ?>

                    <ul class="ticker-item-wrap" direction="<?php echo esc_attr( $nekit_direction ); ?>" dir="<?php echo esc_attr( $nekit_dir ); ?>">
                        <?php
                            if( $settings['content_type'] == 'posts' ):
                                $posts_args = $this->get_posts_args_for_query();
                                $ticker_query = new \WP_Query( $posts_args );
                                if( $ticker_query->have_posts() ) :
                                    while( $ticker_query->have_posts() ) : $ticker_query->the_post();
                                    ?>
                                        <li class="ticker-item">
                                            <div class="title-wrap">
                                                <h2 <?php echo wp_kses_post($this->get_render_attribute_string( 'title_hover' )); ?>>
                                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="<?php echo esc_attr( $settings['links_target'] ); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h2>
                                            </div>
                                        </li>
                                    <?php
                                    endwhile;
                                    wp_reset_postdata();
                                endif;
                            endif;

                            if( $settings['content_type'] == 'custom' ): 
                                foreach( $settings['repeater_field'] as $custom ):
                                ?>
                                    <li class="ticker-item">
                                        <div class="title-wrap">
                                            <h2 <?php echo wp_kses_post($this->get_render_attribute_string( 'title_hover' )); ?>>
                                                <?php
                                                    $custom_url = '<a href="' . esc_url( $custom['custom_url'] ) . '" target="'. esc_attr( $settings['links_target'] ) . '">';
                                                    if( $custom['custom_url'] != '' ) echo wp_kses_post($custom_url);
                                                        echo esc_html($custom['custom_title']);
                                                    if( $custom['custom_url'] != '' ) echo '</a>';
                                                ?>
                                            </h2>
                                        </div>
                                    </li>
                                <?php
                                endforeach;
                            endif;
                        ?>
                    </ul>
                </div>
            </div>
		<?php
	}
}