<?php
/**
 * Tags Cloud Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widgets;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Tags_Cloud_Widget extends \Nekit_Modules\Tags_Cloud_Module {
    protected $widget_name = 'nekit-tags-cloud';
    public function get_custom_help_url() {
		return 'https://forum.blazethemes.com/news-elementor/addons/#nekit-tags-cloud';
	}

    public function get_categories() {
		return [ 'nekit-widgets-group' ];
	}

    public function get_keywords() {
		return [ 'tags', 'tag', 'post tags' ];
	}

    protected function render() {
        $settings = $this->get_settings_for_display();
        $elementClass = 'nekit-tags-cloud';
        $elementClass .= esc_attr(" icon-position--" . $settings['tag_icon_position'] );
        $utils_object = new \Nekit_Utilities\Utils();
        $this->add_render_attribute( 'wrapper','class',$elementClass );
    ?>
        <div <?php echo wp_kses_post($this->get_render_attribute_string( 'wrapper' )); ?>>
            <?php
                $post_tags = get_tags( ['number' => $settings['number_of_tags'] ] );
                if( ! empty( $post_tags ) ) : 
                    ?>
                    <div class="post-tags-wrap">
                        <?php 
                            foreach( $post_tags as $post_tag ) :
                                $tag_count = $post_tag->count; ?>
                                <span class="post-tag-icon-wrap">
                                    <?php 
                                        if( $settings['show_icon'] == 'yes' && $settings['tag_icon_position'] == 'before') 
                                            echo '<span class="tag-icon">'.wp_kses_post(nekit_get_base_value( [ 'icon' => $settings['tag_icon'] ] )). '</span>';
                                    ?>
                                            <span class="post-tag">
                                                <a href="<?php echo esc_attr( get_term_link( $post_tag->term_id ) ); ?>" <?php 
                                                    if( $settings['open_in_new_tab'] == 'yes' ) echo 'target="_blank"'; ?>>
                                                        <?php echo esc_html( $post_tag->name ); ?>
                                                </a>
                                            </span>
                                    <?php
                                        if( $settings['show_icon'] == 'yes' && $settings['tag_icon_position'] == 'after' ) 
                                            echo '<span class="tag-icon">' .wp_kses_post(nekit_get_base_value( [ 'icon' => $settings['tag_icon'] ] )). '</span>';
                                    ?>
                                </span>
                            <?php
                            endforeach;
                        ?>
                    </div>
                <?php
                endif;
            ?>
        </div>
    <?php
    }
}