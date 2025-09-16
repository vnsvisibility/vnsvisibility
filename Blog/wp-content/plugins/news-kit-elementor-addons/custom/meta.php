<?php
    if( ! function_exists( 'nekit_add_author_social_meta_fields' ) ) :
        /**
         * Add new fields above 'Update' button user page.
         *
         * @param WP_User $user User object.
         */
        function nekit_add_author_social_meta_fields( $user ) {
            $facebook_url = ( get_the_author_meta( 'facebook_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'facebook_url', $user->ID ) ) : '';
            $twitter_url = ( get_the_author_meta( 'twitter_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'twitter_url', $user->ID ) ) : '';
            $linkedin_url = ( get_the_author_meta( 'linkedin_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'linkedin_url', $user->ID ) ) : '';
            $instagram_url = ( get_the_author_meta( 'instagram_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'instagram_url', $user->ID ) ) : '';
            $youtube_url = ( get_the_author_meta( 'youtube_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'youtube_url', $user->ID ) ) : '';
            $tiktok_url = ( get_the_author_meta( 'tiktok_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'tiktok_url', $user->ID ) ) : '';
            $whatsapp_url = ( get_the_author_meta( 'whatsapp_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'whatsapp_url', $user->ID ) ) : '';
            $reddit_url = ( get_the_author_meta( 'reddit_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'reddit_url', $user->ID ) ) : '';
            $wechat_url = ( get_the_author_meta( 'wechat_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'wechat_url', $user->ID ) ) : '';
            $tumblr_url = ( get_the_author_meta( 'tumblr_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'tumblr_url', $user->ID ) ) : '';
            $discord_url = ( get_the_author_meta( 'discord_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'discord_url', $user->ID ) ) : '';
            $google_plus_url = ( get_the_author_meta( 'google_plus_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'google_plus_url', $user->ID ) ) : '';
            $sina_weibo_url = ( get_the_author_meta( 'sina_weibo_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'sina_weibo_url', $user->ID ) ) : '';
            $kuaishou_url = ( get_the_author_meta( 'kuaishou_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'kuaishou_url', $user->ID ) ) : '';
            $twitch_url = ( get_the_author_meta( 'twitch_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'twitch_url', $user->ID ) ) : '';
            $qzone_url = ( get_the_author_meta( 'qzone_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'qzone_url', $user->ID ) ) : '';
            $flickr_url = ( get_the_author_meta( 'flickr_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'flickr_url', $user->ID ) ) : '';
            $skype_url = ( get_the_author_meta( 'skype_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'skype_url', $user->ID ) ) : '';
            $snapchat_url = ( get_the_author_meta( 'snapchat_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'snapchat_url', $user->ID ) ) : '';
            $telegram_url = ( get_the_author_meta( 'telegram_url', $user->ID ) ) ? esc_url( get_the_author_meta( 'telegram_url', $user->ID ) ) : '';
            ?>
            <h2><?php esc_html_e( 'Social Networks', 'news-kit-elementor-addons' ); ?></h2>
            <table class="form-table">
                <?php wp_nonce_field( 'nekit_admin_submit_user_meta_creation_action', 'nekit_admin_meta_form_nonce' ); ?>
                <tr>
                    <th><label for="facebook_url"><?php esc_html_e( 'Facebook Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="facebook_url" id="facebook_url" value="<?php echo esc_url( $facebook_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="twitter_url"><?php esc_html_e( 'Twitter Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="twitter_url" id="twitter_url" value="<?php echo esc_url( $twitter_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="linkedin_url"><?php esc_html_e( 'Linkedin Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="linkedin_url" id="linkedin_url" value="<?php echo esc_url( $linkedin_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="instagram_url"><?php esc_html_e( 'Instagram Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="instagram_url" id="instagram_url" value="<?php echo esc_url( $instagram_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="youtube_url"><?php esc_html_e( 'Youtube Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="youtube_url" id="youtube_url" value="<?php echo esc_url( $youtube_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="tiktok_url"><?php esc_html_e( 'TikTok Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="tiktok_url" id="tiktok_url" value="<?php echo esc_url( $tiktok_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="whatsapp_url"><?php esc_html_e( 'WhatsApp Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="whatsapp_url" id="whatsapp_url" value="<?php echo esc_url( $whatsapp_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="reddit_url"><?php esc_html_e( 'Reddit Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="reddit_url" id="reddit_url" value="<?php echo esc_url( $reddit_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="wechat_url"><?php esc_html_e( 'WeChat Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="wechat_url" id="wechat_url" value="<?php echo esc_url( $wechat_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="tumblr_url"><?php esc_html_e( 'Tumblr Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="tumblr_url" id="tumblr_url" value="<?php echo esc_url( $tumblr_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="sina_weibo_url"><?php esc_html_e( 'Sina Weibo Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="sina_weibo_url" id="sina_weibo_url" value="<?php echo esc_url( $sina_weibo_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="google_plus_url"><?php esc_html_e( 'Google+ Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="google_plus_url" id="google_plus_url" value="<?php echo esc_url( $google_plus_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="discord_url"><?php esc_html_e( 'Discord Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="discord_url" id="discord_url" value="<?php echo esc_url( $discord_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="flickr_url"><?php esc_html_e( 'Flickr Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="flickr_url" id="flickr_url" value="<?php echo esc_url( $flickr_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="skype_url"><?php esc_html_e( 'Skype Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="skype_url" id="skype_url" value="<?php echo esc_url( $skype_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="snapchat_url"><?php esc_html_e( 'Snapchat Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="snapchat_url" id="snapchat_url" value="<?php echo esc_url( $snapchat_url ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label for="telegram_url"><?php esc_html_e( 'Telegram Url', 'news-kit-elementor-addons' ); ?></label></th>
                    <td>
                        <input type="url" name="telegram_url" id="telegram_url" value="<?php echo esc_url( $telegram_url ); ?>" class="regular-text code">
                    </td>
                </tr>
            </table>
            <?php
        }
        add_action( 'show_user_profile', 'nekit_add_author_social_meta_fields' );
        add_action( 'edit_user_profile', 'nekit_add_author_social_meta_fields' );
    endif;

    if( ! function_exists( 'nekit_save_author_social_meta_fields' ) ) :
        /**
         * Save additional profile fields.
         *
         * @param  int $user_id Current user ID.
         */
        function nekit_save_author_social_meta_fields( $user_id ) {
            if ( ! current_user_can( 'edit_user', $user_id ) ) {
                return false;
            }
            //* Check if nonce is set...
            if ( ! isset( $_POST['nekit_admin_meta_form_nonce'] ) ) {
                return;
            }
            //* Check if nonce is valid...
            if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash($_POST['nekit_admin_meta_form_nonce'])), 'nekit_admin_submit_user_meta_creation_action' ) ) {
                return;
            }
            $facebook_url = isset( $_POST['facebook_url'] ) ? sanitize_url( $_POST['facebook_url'] ) : '';
            update_user_meta( $user_id, 'facebook_url', sanitize_url( $facebook_url ) );

            $twitter_url = isset( $_POST['twitter_url'] ) ? sanitize_url( $_POST['twitter_url'] ) : '';
            update_user_meta( $user_id, 'twitter_url', sanitize_url( $twitter_url ) );

            $linkedin_url = isset( $_POST['linkedin_url'] ) ? sanitize_url( $_POST['linkedin_url'] ) : '';
            update_user_meta( $user_id, 'linkedin_url', sanitize_url( $linkedin_url ) );

            $instagram_url = isset( $_POST['instagram_url'] ) ? sanitize_url( $_POST['instagram_url'] ) : '';
            update_user_meta( $user_id, 'instagram_url', sanitize_url( $instagram_url ) );

            $youtube_url = isset( $_POST['youtube_url'] ) ? sanitize_url( $_POST['youtube_url'] ) : '';
            update_user_meta( $user_id, 'youtube_url', sanitize_url( $youtube_url ) );

            $tiktok_url = isset( $_POST['tiktok_url'] ) ? sanitize_url( $_POST['tiktok_url'] ) : '';
            update_user_meta( $user_id, 'tiktok_url', sanitize_url( $tiktok_url ) );

            $whatsapp_url = isset( $_POST['whatsapp_url'] ) ? sanitize_url( $_POST['whatsapp_url'] ) : '';
            update_user_meta( $user_id, 'whatsapp_url', sanitize_url( $whatsapp_url ) );

            $reddit_url = isset( $_POST['reddit_url'] ) ? sanitize_url( $_POST['reddit_url'] ) : '';
            update_user_meta( $user_id, 'reddit_url', sanitize_url( $reddit_url ) );

            $wechat_url = isset( $_POST['wechat_url'] ) ? sanitize_url( $_POST['wechat_url'] ) : '';
            update_user_meta( $user_id, 'wechat_url', sanitize_url( $wechat_url ) );

            $sina_weibo_url = isset( $_POST['sina_weibo_url'] ) ? sanitize_url( $_POST['sina_weibo_url'] ) : '';
            update_user_meta( $user_id, 'sina_weibo_url', sanitize_url( $sina_weibo_url ) );

            $tumblr_url = isset( $_POST['tumblr_url'] ) ? sanitize_url( $_POST['tumblr_url'] ) : '';
            update_user_meta( $user_id, 'tumblr_url', sanitize_url( $tumblr_url ) );

            $google_plus_url = isset( $_POST['google_plus_url'] ) ? sanitize_url( $_POST['google_plus_url'] ) : '';
            update_user_meta( $user_id, 'google_plus_url', sanitize_url( $google_plus_url ) );

            $discord_url = isset( $_POST['discord_url'] ) ? sanitize_url( $_POST['discord_url'] ) : '';
            update_user_meta( $user_id, 'discord_url', sanitize_url( $discord_url ) );

            $twitch_url = isset( $_POST['twitch_url'] ) ? sanitize_url( $_POST['twitch_url'] ) : '';
            update_user_meta( $user_id, 'twitch_url', sanitize_url( $twitch_url ) );

            $kuaishou_url = isset( $_POST['kuaishou_url'] ) ? sanitize_url( $_POST['kuaishou_url'] ) : '';
            update_user_meta( $user_id, 'kuaishou_url', sanitize_url( $kuaishou_url ) );

            $quora_url = isset( $_POST['quora_url'] ) ? sanitize_url( $_POST['quora_url'] ) : '';
            update_user_meta( $user_id, 'quora_url', sanitize_url( $quora_url ) );

            $flickr_url = isset( $_POST['flickr_url'] ) ? sanitize_url( $_POST['flickr_url'] ) : '';
            update_user_meta( $user_id, 'flickr_url', sanitize_url( $flickr_url ) );

            $skype_url = isset( $_POST['skype_url'] ) ? sanitize_url( $_POST['skype_url'] ) : '';
            update_user_meta( $user_id, 'skype_url', sanitize_url( $skype_url ) );

            $snapchat_url = isset( $_POST['snapchat_url'] ) ? sanitize_url( $_POST['snapchat_url'] ) : '';
            update_user_meta( $user_id, 'snapchat_url', sanitize_url( $snapchat_url ) );

            $telegram_url = isset( $_POST['telegram_url'] ) ? sanitize_url( $_POST['telegram_url'] ) : '';
            update_user_meta( $user_id, 'telegram_url', sanitize_url( $telegram_url ) );
        }

        add_action( 'personal_options_update', 'nekit_save_author_social_meta_fields' );
        add_action( 'edit_user_profile_update', 'nekit_save_author_social_meta_fields' );
    endif;