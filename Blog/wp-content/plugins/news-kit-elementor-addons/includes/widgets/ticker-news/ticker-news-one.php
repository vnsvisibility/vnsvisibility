<?php
/**
 * Ticker News Widget
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Ticker_News_Widget extends \Nekit_Modules\Ticker_News_Module {
	protected $widget_name = 'nekit-ticker-news-one';
	public static $widget_count = 'one';

	public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/#ticker-news-widget';
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
		$imageClass = '';
		if ( $settings['image_hover_animation'] ) {
			$imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
		}
		?>
            <div class="nekit-ticker-news-wrap nekit-ticker <?php echo esc_attr( 'layout--' . $settings['ticker_news_layout'] ); ?><?php if( $settings['show_post_thumbnail'] != 'yes' ) echo ' section-no-thumbnail'; if( $settings['icon_animation'] != 'yes') echo " no-icon-animation"; ?>" data-duration="<?php echo esc_attr($settings['ticker_news_duration']); ?>">
                <?php
                    if( $settings['show_ticker_news_title'] == 'yes' ) {
                        ?>
                        <div class="ticker_label_title ticker-title nekit-ticker-label">
                            <?php
                                if( nekit_get_base_value(['icon'=>$settings['ticker_news_title_icon']]) ) {
                                ?>
                                    <span class="icon">
                                        <?php echo wp_kses_post( nekit_get_base_value( ['icon'=>$settings['ticker_news_title_icon'] ] ) ); ?>
                                    </span>
                                <?php
                                }

                                if(!empty($settings['ticker_news_title'])) {
	                            	?>
                            		<span class="ticker_label_title_string"><?php echo esc_html( $settings['ticker_news_title'] ); ?></span>
                        	<?php } ?>
                        </div>

                        <?php
                    }
                ?>
                <div class="nekit-ticker-box">
                    <ul class="ticker-item-wrap">
                        <?php
                            $posts_args = $this->get_posts_args_for_query();
                            $ticker_query = new \WP_Query( $posts_args );
                            if( $ticker_query->have_posts() ) :
                                while( $ticker_query->have_posts() ) : $ticker_query->the_post();
                                ?>
                                    <li class="ticker-item post-item <?php echo esc_attr( implode("--",$settings['posts_structure_sorting']) ); ?><?php if( ! has_post_thumbnail() ) echo '  no-feat-img'; ?>">
										<?php
											foreach($settings['posts_structure_sorting'] as $posts_structure) :
												switch($posts_structure) {
													case 'post-thumbnail': ?>
																			<?php if( has_post_thumbnail() && $settings['show_post_thumbnail'] == 'yes' ) : ?>
																				<figure class="feature_image">
																					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
																					<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																							<?php
																								the_post_thumbnail($settings['image_size'], array(
																											'title' => the_title_attribute(array(
																												'echo'  => false
																											)),
																											'class'	=> esc_attr( $imageClass )
																										));
																							?>
																						</div>
																					</a>
																				</figure>
																			<?php endif; ?>
																	<?php
																		break;
													case 'post-meta': 
													?>
																		<div class="title-wrap">
																			<?php
																				foreach($settings['posts_elements_sorting'] as $posts_element) :
																					switch($posts_element) {
																						case 'post-title': if( $settings['show_post_title'] == 'yes' ) {
																									?>
																										<h2 <?php echo wp_kses_post($this->get_render_attribute_string( 'title_hover' )); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
																									<?php
																								}
																								break;																								
																						case 'post-date': if( $settings['show_post_date'] == 'yes' ) 
																								echo wp_kses_post(nekit_get_posts_date([
																									'icon'	=>	( isset( $settings['post_date_icon'] ) ) ? $settings['post_date_icon']: ['value' =>  'fas fa-calendar','library'   =>  'fa-solid'],
																									'base'	=>	$settings['post_date_icon_position']
																								]));
																								break;
																					}
																				endforeach;
																			?>
																		</div>
																	<?php
														break;
												}
											endforeach;
										?>
                                    </li>
                                <?php
                                endwhile;
								wp_reset_postdata();
                            endif;
                        ?>
                    </ul>
                </div>
                <?php
                    if( $settings['ticker_news_slider_controller'] == 'yes' ) :
                ?>
                        <div class="nekit-ticker-controls">
                            <button class="nekit-ticker-pause"><i class="fas fa-pause"></i></button>
                        </div>
                <?php endif; ?>
            </div>
		<?php
	}
}