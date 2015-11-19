<?php

add_action('admin_init', 'microblogposter_admin_init');
add_action('admin_menu', 'microblogposter_settings');

function microblogposter_admin_init()
{
    /* Register our script. */
    wp_register_script( 'microblogposter-fancybox-js-script', plugins_url('/fancybox/jquery.fancybox-1.3.4.pack.js', __FILE__) );
    wp_register_style( 'microblogposter-fancybox-css-script', plugins_url('/fancybox/jquery.fancybox-1.3.4.css', __FILE__) );
}

function microblogposter_settings()
{
    
    add_submenu_page('options-general.php', 'MicroblogPoster Options', 'MicroblogPoster', 'administrator', 'microblogposter.php', 'microblogposter_settings_output');
    
}

function microblogposter_settings_output()
{
    global  $wpdb;

    $table_accounts = $wpdb->prefix . 'microblogposter_accounts';
    $table_logs = $wpdb->prefix . 'microblogposter_logs';
    
    //Options names
    $url_shortener_name = "microblogposter_plg_url_shortener";
    $bitly_api_user_name = "microblogposter_plg_bitly_api_user";
    $bitly_api_key_name = "microblogposter_plg_bitly_api_key";
    $bitly_access_token_name = "microblogposter_plg_bitly_access_token";
    $googl_api_client_id_name = "microblogposter_plg_googl_api_client_id";
    $googl_api_client_secret_name = "microblogposter_plg_googl_api_client_secret";
    $googl_api_refresh_token_name = "microblogposter_plg_googl_api_refresh_token";//not used in same manner
    $adfly_api_key_name = "microblogposter_plg_adfly_api_key";
    $adfly_api_user_id_name = "microblogposter_plg_adfly_api_user_id";
    $adfly_api_domain_name = "microblogposter_plg_adfly_api_domain_type";
    $adfly_api_custom_domain_name = "microblogposter_plg_adfly_api_custom_domain";
    $adfocus_api_key_name = "microblogposter_plg_adfocus_api_key";
    $ppw_user_id_name = "microblogposter_plg_ppw_user_id";
    $default_behavior_name = "microblogposter_default_behavior";
    $default_behavior_update_name = "microblogposter_default_behavior_update";
    $default_pbehavior_name = "microblogposter_default_pbehavior";
    $default_pbehavior_update_name = "microblogposter_default_pbehavior_update";
    $page_mode_name = "microblogposter_page_mode";
    $excluded_categories_name = "microblogposter_excluded_categories";
    $enabled_custom_types_name = "microblogposter_enabled_custom_types";
    $enabled_custom_updates_name = "microblogposter_enabled_custom_updates";
    $customer_license_key_name = "microblogposterpro_plg_customer_license_key";
    $pro_control_dash_mode_name = "microblogposter_plg_control_dash_mode";
    $shortcode_title_max_length_name = "microblogposter_plg_shortcode_title_max_length";
    $shortcode_firstwords_max_length_name = "microblogposter_plg_shortcode_firstwords_max_length";
    $shortcode_excerpt_max_length_name = "microblogposter_plg_shortcode_excerpt_max_length";
    $microblogposter_plg_old_posts_active_name = "microblogposter_plg_old_posts_active";
    $microblogposter_plg_old_posts_nb_posts_name = "microblogposter_plg_old_posts_nb_posts";
    $microblogposter_plg_old_posts_min_age_name = "microblogposter_plg_old_posts_min_age";
    $microblogposter_plg_old_posts_max_age_name = "microblogposter_plg_old_posts_max_age";
    $microblogposter_plg_old_posts_interval_name = "microblogposter_plg_old_posts_interval";
    $microblogposter_plg_old_posts_expire_age_name = "microblogposter_plg_old_posts_expire_age";
    $excluded_categories_old_name = "microblogposter_excluded_categories_old";
    
    
    $url_shortener_value = get_option($url_shortener_name, "");
    $bitly_api_user_value = get_option($bitly_api_user_name, "");
    $bitly_api_key_value = get_option($bitly_api_key_name, "");
    $bitly_access_token_value = get_option($bitly_access_token_name, "");
    $googl_api_client_id_value = get_option($googl_api_client_id_name, "");
    $googl_api_client_secret_value = get_option($googl_api_client_secret_name, "");
    $adfly_api_key_value = get_option($adfly_api_key_name, "");
    $adfly_api_user_id_value = get_option($adfly_api_user_id_name, "");
    $adfly_api_domain_value = get_option($adfly_api_domain_name, "");
    $adfly_api_custom_domain_value = get_option($adfly_api_custom_domain_name, "");
    $adfocus_api_key_value = get_option($adfocus_api_key_name, "");
    $ppw_user_id_value = get_option($ppw_user_id_name, "");
    $default_behavior_value = get_option($default_behavior_name, "");
    $default_behavior_update_value = get_option($default_behavior_update_name, "");
    $default_pbehavior_value = get_option($default_pbehavior_name, "");
    $default_pbehavior_update_value = get_option($default_pbehavior_update_name, "");
    $page_mode_value = get_option($page_mode_name, "");
    $excluded_categories_value = get_option($excluded_categories_name, "");
    $excluded_categories_value = json_decode($excluded_categories_value, true);
    $enabled_custom_types_value = get_option($enabled_custom_types_name, "");
    $enabled_custom_types_value = json_decode($enabled_custom_types_value, true);
    $enabled_custom_updates_value = get_option($enabled_custom_updates_name, "");
    $enabled_custom_updates_value = json_decode($enabled_custom_updates_value, true);
    $customer_license_key_value = get_option($customer_license_key_name, "");
    $pro_control_dash_mode_value = get_option($pro_control_dash_mode_name, "");
    $shortcode_title_max_length_value = get_option($shortcode_title_max_length_name, "110");
    $shortcode_firstwords_max_length_value = get_option($shortcode_firstwords_max_length_name, "90");
    $shortcode_excerpt_max_length_value = get_option($shortcode_excerpt_max_length_name, "400");
    $microblogposter_plg_old_posts_active_value = get_option($microblogposter_plg_old_posts_active_name, 0);
    $microblogposter_plg_old_posts_nb_posts_value = get_option($microblogposter_plg_old_posts_nb_posts_name, 1);
    $microblogposter_plg_old_posts_min_age_value = get_option($microblogposter_plg_old_posts_min_age_name, 30);
    $microblogposter_plg_old_posts_max_age_value = get_option($microblogposter_plg_old_posts_max_age_name, 180);
    $microblogposter_plg_old_posts_interval_value = get_option($microblogposter_plg_old_posts_interval_name, 24);
    $microblogposter_plg_old_posts_expire_age_value = get_option($microblogposter_plg_old_posts_expire_age_name, 30);
    $excluded_categories_old_value = get_option($excluded_categories_old_name, "");
    $excluded_categories_old_value = json_decode($excluded_categories_old_value, true);
    
    
    $mbp_manual_share_tab_selected = false;
    if(isset($_POST["submit_manual_post"]))
    {
        if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Enterprise_Options','handle_manual_post'))
        {
            $manual_share_completed = MicroblogPoster_Poster_Enterprise_Options::handle_manual_post();
            $mbp_manual_share_tab_selected = true;
        }
    }
    
    $mbp_old_posts_tab_selected = false;
    if(isset($_POST["microblogposter_plg_old_posts_save"]))
    {
        $microblogposter_plg_old_posts_active_value = trim($_POST[$microblogposter_plg_old_posts_active_name]);
        $microblogposter_plg_old_posts_interval_value_temp = round(trim($_POST[$microblogposter_plg_old_posts_interval_name]));
        if(intval($microblogposter_plg_old_posts_interval_value_temp) && 
           intval($microblogposter_plg_old_posts_interval_value_temp) >= 1 && intval($microblogposter_plg_old_posts_interval_value_temp) <= 4380)
        {
            $microblogposter_plg_old_posts_interval_value = $microblogposter_plg_old_posts_interval_value_temp;
        }
        $microblogposter_plg_old_posts_nb_posts_value_temp = round(trim($_POST[$microblogposter_plg_old_posts_nb_posts_name]));
        if(intval($microblogposter_plg_old_posts_nb_posts_value_temp) && 
           intval($microblogposter_plg_old_posts_nb_posts_value_temp) >= 1 && intval($microblogposter_plg_old_posts_nb_posts_value_temp) <= 3)
        {
            $microblogposter_plg_old_posts_nb_posts_value = $microblogposter_plg_old_posts_nb_posts_value_temp;
        }
        $microblogposter_plg_old_posts_min_age_value_temp = round(trim($_POST[$microblogposter_plg_old_posts_min_age_name]));
        if(intval($microblogposter_plg_old_posts_min_age_value_temp) >= 0 && intval($microblogposter_plg_old_posts_min_age_value_temp) <= 3650)
        {
            $microblogposter_plg_old_posts_min_age_value = $microblogposter_plg_old_posts_min_age_value_temp;
        }
        $microblogposter_plg_old_posts_max_age_value_temp = round(trim($_POST[$microblogposter_plg_old_posts_max_age_name]));
        if(intval($microblogposter_plg_old_posts_max_age_value_temp) >= 0 && intval($microblogposter_plg_old_posts_max_age_value_temp) <= 3650)
        {
            $microblogposter_plg_old_posts_max_age_value = $microblogposter_plg_old_posts_max_age_value_temp;
        }
        $microblogposter_plg_old_posts_expire_age_value_temp = round(trim($_POST[$microblogposter_plg_old_posts_expire_age_name]));
        if(intval($microblogposter_plg_old_posts_expire_age_value_temp) >= 0 && intval($microblogposter_plg_old_posts_expire_age_value_temp) <= 3650)
        {
            $microblogposter_plg_old_posts_expire_age_value = $microblogposter_plg_old_posts_expire_age_value_temp;
        }
        $excluded_categories_old_value = $_POST[$excluded_categories_old_name];
        $excluded_categories_old_value = json_encode($excluded_categories_old_value);
        
        update_option($microblogposter_plg_old_posts_active_name, $microblogposter_plg_old_posts_active_value);
        update_option($microblogposter_plg_old_posts_nb_posts_name, $microblogposter_plg_old_posts_nb_posts_value);
        update_option($microblogposter_plg_old_posts_min_age_name, $microblogposter_plg_old_posts_min_age_value);
        update_option($microblogposter_plg_old_posts_max_age_name, $microblogposter_plg_old_posts_max_age_value);
        update_option($microblogposter_plg_old_posts_interval_name, $microblogposter_plg_old_posts_interval_value);
        update_option($microblogposter_plg_old_posts_expire_age_name, $microblogposter_plg_old_posts_expire_age_value);
        update_option($excluded_categories_old_name, $excluded_categories_old_value);
        $excluded_categories_old_value = json_decode($excluded_categories_old_value, true);
        
        $accounts_old = MicroblogPoster_Poster::get_accounts_all();
        if(is_array($accounts_old) && !empty($accounts_old))
        {
            foreach($accounts_old as $account_old)
            {
                if(isset($account_old['extra']) && $account_old['extra'])
                {
                    $extra_old = json_decode($account_old['extra'], true);
                }
                else
                {
                    $extra_old = array();
                }
                $extra_old['old_posts_active'] = 0;
                $extra_old['message_format_old'] = '';
                $checkbox_name_old = 'mbp_social_account_microblogposter_old_'.$account_old['account_id'];
                $message_format_name_old = 'mbp_social_account_microblogposter_msg_old_'.$account_old['account_id'];
                if(isset($_POST[$checkbox_name_old]) && trim($_POST[$checkbox_name_old]) == '1')
                {
                    $extra_old['old_posts_active'] = 1;
                }
                $extra_old['message_format_old'] = trim($_POST[$message_format_name_old]);
                $extra_old = json_encode($extra_old);
                //$wpdb->escape_by_ref($extra_old);
                $account_id_old = $account_old['account_id'];
                /*$sql = "UPDATE {$table_accounts}
                    SET extra='{$extra_old}' 
                    WHERE account_id={$account_id_old}";

                $wpdb->query($sql);*/
                
                $wpdb->update(
                        $table_accounts, 
                        array(
                            'extra' => $extra_old
                        ),
                        array(
                            'account_id' => $account_id_old
                        )
                );
            }
        }
        
        if($microblogposter_plg_old_posts_active_value == '1')
        {
            if( !wp_next_scheduled( 'microblogposter_plg_old_posts_publish' ) )
            {
                wp_schedule_event( time(), 'microblogposter_plg_cron_interval', 'microblogposter_plg_old_posts_publish' );
            }
        }
        else
        {
            wp_clear_scheduled_hook('microblogposter_plg_old_posts_publish');
        }
        
        $mbp_old_posts_tab_selected = true;
    }
    $excluded_categories_old = array();
    if(is_array($excluded_categories_old_value))
    {
        $excluded_categories_old = $excluded_categories_old_value;
    }
    
    if(isset($_POST["update_license_key"]))
    {
        $customer_license_key_value = trim($_POST[$customer_license_key_name]);
        $verified = false;
        $customer_license_key_value_arr = array('key'=>$customer_license_key_value, 'verified'=>$verified);
        if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro_Options','verify_license_key'))
        {
            $curl_license_key = new MicroblogPoster_Curl();
            $verified = MicroblogPoster_Poster_Pro_Options::verify_license_key($curl_license_key, $customer_license_key_value);
            $customer_license_key_value_arr['verified'] = $verified;
        }
        $customer_license_key_value = json_encode($customer_license_key_value_arr);
        
        update_option($customer_license_key_name, $customer_license_key_value);
    }
    $customer_license_key_value = json_decode($customer_license_key_value, true);
    
    $mbp_logs_tab_selected = false;
    if(isset($_POST["empty_logs"]))
    {
        $sql="DELETE FROM {$table_logs}";
        $wpdb->query($sql);
        $mbp_logs_tab_selected = true;
    }
    
    if(isset($_POST["update_options"]))
    {
        //$url_shortener_value = $_POST[$url_shortener_name];
        $url_shortener_value = sanitize_text_field( $_POST[$url_shortener_name] );
        //$bitly_api_user_value = trim($_POST[$bitly_api_user_name]);
        $bitly_api_user_value = sanitize_text_field($_POST[$bitly_api_user_name]);
        //$bitly_api_key_value = trim($_POST[$bitly_api_key_name]);
        $bitly_api_key_value = sanitize_text_field($_POST[$bitly_api_key_name]);
        //$bitly_access_token_value = trim($_POST[$bitly_access_token_name]);
        $bitly_access_token_value = sanitize_text_field($_POST[$bitly_access_token_name]);
        //$googl_api_client_id_value = trim($_POST[$googl_api_client_id_name]);
        $googl_api_client_id_value = sanitize_text_field($_POST[$googl_api_client_id_name]);
        //$googl_api_client_secret_value = trim($_POST[$googl_api_client_secret_name]);
        $googl_api_client_secret_value = sanitize_text_field($_POST[$googl_api_client_secret_name]);
        //$adfly_api_key_value = trim($_POST[$adfly_api_key_name]);
        $adfly_api_key_value = sanitize_text_field($_POST[$adfly_api_key_name]);
        //$adfly_api_user_id_value = trim($_POST[$adfly_api_user_id_name]);
        $adfly_api_user_id_value = sanitize_text_field($_POST[$adfly_api_user_id_name]);
        //$adfly_api_domain_value = trim($_POST[$adfly_api_domain_name]);
        $adfly_api_domain_value = sanitize_text_field($_POST[$adfly_api_domain_name]);
        //$adfly_api_custom_domain_value = trim($_POST[$adfly_api_custom_domain_name]);
        $adfly_api_custom_domain_value = sanitize_text_field($_POST[$adfly_api_custom_domain_name]);
        //$adfocus_api_key_value = trim($_POST[$adfocus_api_key_name]);
        $adfocus_api_key_value = sanitize_text_field($_POST[$adfocus_api_key_name]);
        //$ppw_user_id_value = trim($_POST[$ppw_user_id_name]);
        $ppw_user_id_value = sanitize_text_field($_POST[$ppw_user_id_name]);
        //$default_behavior_value = $_POST[$default_behavior_name];
        $default_behavior_value = sanitize_text_field($_POST[$default_behavior_name]);
        //$default_behavior_update_value = $_POST[$default_behavior_update_name];
        $default_behavior_update_value = sanitize_text_field($_POST[$default_behavior_update_name]);
        //$default_pbehavior_value = $_POST[$default_pbehavior_name];
        $default_pbehavior_value = sanitize_text_field($_POST[$default_pbehavior_name]);
        //$default_pbehavior_update_value = $_POST[$default_pbehavior_update_name];
        $default_pbehavior_update_value = sanitize_text_field($_POST[$default_pbehavior_update_name]);
        //$page_mode_value = $_POST[$page_mode_name];
        $page_mode_value = sanitize_text_field($_POST[$page_mode_name]);
        $excluded_categories_value = $_POST[$excluded_categories_name];
        $excluded_categories_value = json_encode($excluded_categories_value);
        $enabled_custom_types_value = $_POST[$enabled_custom_types_name];
        $enabled_custom_types_value = json_encode($enabled_custom_types_value);
        $enabled_custom_updates_value = $_POST[$enabled_custom_updates_name];
        $enabled_custom_updates_value = json_encode($enabled_custom_updates_value);
        $pro_control_dash_mode_value = $_POST[$pro_control_dash_mode_name];
        $shortcode_title_max_length_value_temp = round(trim($_POST[$shortcode_title_max_length_name]));
        if(intval($shortcode_title_max_length_value_temp) && 
           intval($shortcode_title_max_length_value_temp) >= 30 && intval($shortcode_title_max_length_value_temp) <= 120)
        {
            $shortcode_title_max_length_value = $shortcode_title_max_length_value_temp;
        }
        $shortcode_firstwords_max_length_value_temp = round(trim($_POST[$shortcode_firstwords_max_length_name]));
        if(intval($shortcode_firstwords_max_length_value_temp) && 
           intval($shortcode_firstwords_max_length_value_temp) >= 30 && intval($shortcode_firstwords_max_length_value_temp) <= 120)
        {
            $shortcode_firstwords_max_length_value = $shortcode_firstwords_max_length_value_temp;
        }
        $shortcode_excerpt_max_length_value_temp = round(trim($_POST[$shortcode_excerpt_max_length_name]));
        if(intval($shortcode_excerpt_max_length_value_temp) && 
           intval($shortcode_excerpt_max_length_value_temp) >= 100 && intval($shortcode_excerpt_max_length_value_temp) <= 600)
        {
            $shortcode_excerpt_max_length_value = $shortcode_excerpt_max_length_value_temp;
        }
        
        update_option($url_shortener_name, $url_shortener_value);
        update_option($bitly_api_user_name, $bitly_api_user_value);
        update_option($bitly_api_key_name, $bitly_api_key_value);
        update_option($bitly_access_token_name, $bitly_access_token_value);
        update_option($googl_api_client_id_name, $googl_api_client_id_value);
        update_option($googl_api_client_secret_name, $googl_api_client_secret_value);
        update_option($adfly_api_key_name, $adfly_api_key_value);
        update_option($adfly_api_user_id_name, $adfly_api_user_id_value);
        update_option($adfly_api_domain_name, $adfly_api_domain_value);
        update_option($adfly_api_custom_domain_name, $adfly_api_custom_domain_value);
        update_option($adfocus_api_key_name, $adfocus_api_key_value);
        update_option($ppw_user_id_name, $ppw_user_id_value);
        update_option($default_behavior_name, $default_behavior_value);
        update_option($default_behavior_update_name, $default_behavior_update_value);
        
        update_option($page_mode_name, $page_mode_value);
        if($page_mode_value == '1')
        {
            update_option($default_pbehavior_name, $default_pbehavior_value);
            update_option($default_pbehavior_update_name, $default_pbehavior_update_value);
        }
        else
        {
            $default_pbehavior_value = get_option($default_pbehavior_name, "");
            $default_pbehavior_update_value = get_option($default_pbehavior_update_name, "");
        }
        
        update_option($excluded_categories_name, $excluded_categories_value);
        $excluded_categories_value = json_decode($excluded_categories_value, true);
        update_option($enabled_custom_types_name, $enabled_custom_types_value);
        $enabled_custom_types_value = json_decode($enabled_custom_types_value, true);
        update_option($enabled_custom_updates_name, $enabled_custom_updates_value);
        $enabled_custom_updates_value = json_decode($enabled_custom_updates_value, true);
        
        update_option($pro_control_dash_mode_name, $pro_control_dash_mode_value);
        update_option($shortcode_title_max_length_name, $shortcode_title_max_length_value);
        update_option($shortcode_firstwords_max_length_name, $shortcode_firstwords_max_length_value);
        update_option($shortcode_excerpt_max_length_name, $shortcode_excerpt_max_length_value);
        
        ?>
        <div class="updated"><p><strong><?php _e('Options saved.', 'microblog-poster');?></strong></p></div>
        <?php
        
    }
    
    $excluded_categories = array();
    if(is_array($excluded_categories_value))
    {
        $excluded_categories = $excluded_categories_value;
    }
    $enabled_custom_types = array();
    if(is_array($enabled_custom_types_value))
    {
        $enabled_custom_types = $enabled_custom_types_value;
    }
    $enabled_custom_updates = array();
    if(is_array($enabled_custom_updates_value))
    {
        $enabled_custom_updates = $enabled_custom_updates_value;
    }
    
    $http_auth_sites = array('friendfeed','delicious','diigo','instapaper');
    $tags_sites = array('delicious','diigo');
    $featured_image_sites = array('blogger', 'twitter');
    
    $mbp_accounts_tab_selected = false;
    if(isset($_GET["t"]) && $_GET["t"]==2)
    {
        $mbp_accounts_tab_selected = true;
    }
    
    if(isset($_POST["new_account_hidden"]))
    {
        $mbp_accounts_tab_selected = true;
        
        if(isset($_POST['account_type']))
        {
            //$account_type = trim($_POST['account_type']);
            $account_type = sanitize_text_field( $_POST['account_type'] );
        }
        $extra = array();
        if(in_array($account_type, $tags_sites))
        {
            $extra['include_tags'] = 0;
            if(isset($_POST['include_tags']) && trim($_POST['include_tags']) == '1')
            {
                $extra['include_tags'] = 1;
            }
        }
        if(in_array($account_type, $featured_image_sites))
        {
            $extra['include_featured_image'] = 0;
            if(isset($_POST['include_featured_image']) && trim($_POST['include_featured_image']) == '1')
            {
                $extra['include_featured_image'] = 1;
            }
        }
        if($account_type=='diigo')
        {
            if(isset($_POST['api_key']))
            {
                //$extra['api_key'] = trim($_POST['api_key']);
                $extra['api_key'] = sanitize_text_field( $_POST['api_key'] );
            }
        }
        if(isset($_POST['consumer_key']))
        {
            //$consumer_key = trim($_POST['consumer_key']);
            $consumer_key = sanitize_text_field( $_POST['consumer_key'] );
        }
        if(isset($_POST['consumer_secret']))
        {
            //$consumer_secret = trim($_POST['consumer_secret']);
            $consumer_secret = sanitize_text_field( $_POST['consumer_secret'] );
        }
        if(isset($_POST['access_token']))
        {
            //$access_token = trim($_POST['access_token']);
            $access_token = sanitize_text_field( $_POST['access_token'] );
        }
        if(isset($_POST['access_token_secret']))
        {
            //$access_token_secret = trim($_POST['access_token_secret']);
            $access_token_secret = sanitize_text_field( $_POST['access_token_secret'] );
        }
        if(isset($_POST['username']))
        {
            //$username = trim($_POST['username']);
            $username = sanitize_text_field( $_POST['username'] );
        }
        if(isset($_POST['password']))
        {
            $password = trim($_POST['password']);
            if(in_array($account_type, $http_auth_sites))
            {
                $password = stripslashes($password);
                $password = MicroblogPoster_SupportEnc::enc($password);
                $extra['penc'] = 1;
                
            }
            
        }
        
        
        if(isset($_POST['message_format']))
        {
            $message_format = trim($_POST['message_format']);
            //$message_format = sanitize_text_field( $_POST['message_format'] );
        }
        if(isset($_POST['post_type_fb']))
        {
            //$extra['post_type'] = trim($_POST['post_type_fb']);
            $extra['post_type'] = sanitize_text_field( $_POST['post_type_fb'] );
        }
        if(isset($_POST['post_type_lkn']))
        {
            //$extra['post_type'] = trim($_POST['post_type_lkn']);
            $extra['post_type'] = sanitize_text_field( $_POST['post_type_lkn'] );
        }
        if(isset($_POST['post_type_vk']))
        {
            //$extra['post_type'] = trim($_POST['post_type_vk']);
            $extra['post_type'] = sanitize_text_field( $_POST['post_type_vk'] );
        }
        if(isset($_POST['default_image_url']))
        {
            //$extra['default_image_url'] = trim($_POST['default_image_url']);
            $extra['default_image_url'] = sanitize_text_field( $_POST['default_image_url'] );
        }
        if(isset($_POST['mbp_plurk_qualifier']))
        {
            //$extra['qualifier'] = trim($_POST['mbp_plurk_qualifier']);
            $extra['qualifier'] = sanitize_text_field( $_POST['mbp_plurk_qualifier'] );
        }
        if(isset($_POST['mbp_post_type_xing']))
        {
            $extra['post_type'] = sanitize_text_field( $_POST['mbp_post_type_xing'] );
        }
        
        if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account'))
        {
            if(isset($_POST['mbp_facebook_target_type']))
            {
                //$extra['target_type'] = trim($_POST['mbp_facebook_target_type']);
                $extra['target_type'] = sanitize_text_field( $_POST['mbp_facebook_target_type'] );
            }
            if(isset($_POST['mbp_facebook_page_id']))
            {
                //$extra['page_id'] = trim($_POST['mbp_facebook_page_id']);
                $extra['page_id'] = sanitize_text_field( $_POST['mbp_facebook_page_id'] );
            }
            if(isset($_POST['mbp_facebook_group_id']))
            {
                //$extra['group_id'] = trim($_POST['mbp_facebook_group_id']);
                $extra['group_id'] = sanitize_text_field( $_POST['mbp_facebook_group_id'] );
            }
            
            if(isset($_POST['mbp_linkedin_target_type']))
            {
                //$extra['target_type'] = trim($_POST['mbp_linkedin_target_type']);
                $extra['target_type'] = sanitize_text_field( $_POST['mbp_linkedin_target_type'] );
            }
            if(isset($_POST['mbp_linkedin_group_id']))
            {
                //$extra['group_id'] = trim($_POST['mbp_linkedin_group_id']);
                $extra['group_id'] = sanitize_text_field( $_POST['mbp_linkedin_group_id'] );
            }
            if(isset($_POST['mbp_linkedin_company_id']))
            {
                //$extra['company_id'] = trim($_POST['mbp_linkedin_company_id']);
                $extra['company_id'] = sanitize_text_field( $_POST['mbp_linkedin_company_id'] );
            }
            
            if(isset($_POST['mbp_post_type_tmb']))
            {
                //$extra['post_type'] = trim($_POST['mbp_post_type_tmb']);
                $extra['post_type'] = sanitize_text_field( $_POST['mbp_post_type_tmb'] );
            }
            
            if(isset($_POST['mbp_vkontakte_target_type']))
            {
                //$extra['target_type'] = trim($_POST['mbp_vkontakte_target_type']);
                $extra['target_type'] = sanitize_text_field( $_POST['mbp_vkontakte_target_type'] );
            }
            
        }
        else
        {
            if(isset($_POST['mbp_facebook_target_type']))
            {
                $extra['target_type'] = 'profile';
            }
            if(isset($_POST['mbp_linkedin_target_type']))
            {
                $extra['target_type'] = 'profile';
            }
            if(isset($_POST['mbp_post_type_tmb']))
            {
                $extra['post_type'] = 'text';
            }
            if(isset($_POST['mbp_vkontakte_target_type']))
            {
                $extra['target_type'] = 'profile';
            }
        }
        
        if(isset($_POST['mbp_vkontakte_target_id']))
        {
            //$extra['target_id'] = trim($_POST['mbp_vkontakte_target_id']);
            $extra['target_id'] = sanitize_text_field( $_POST['mbp_vkontakte_target_id'] );
        }
        if(isset($_POST['mbp_tumblr_blog_hostname']))
        {
            //$extra['blog_hostname'] = trim($_POST['mbp_tumblr_blog_hostname']);
            $extra['blog_hostname'] = sanitize_text_field( $_POST['mbp_tumblr_blog_hostname'] );
        }
        if(isset($_POST['mbp_blogger_blog_id']))
        {
            //$extra['blog_id'] = trim($_POST['mbp_blogger_blog_id']);
            $extra['blog_id'] = sanitize_text_field( $_POST['mbp_blogger_blog_id'] );
        }
        if($account_type == 'twitter' && $consumer_key && $consumer_secret && $access_token && $access_token_secret)
        {
            $extra['authorized'] = 1;
        }
        
        $extra = json_encode($extra);
        //$wpdb->escape_by_ref($extra);
        
        if($username)
        {
            /*$sql = "INSERT IGNORE INTO {$table_accounts} 
                (username,password,consumer_key,consumer_secret,access_token,access_token_secret,type,message_format,extra)
                VALUES
                ('$username','$password','$consumer_key','$consumer_secret','$access_token','$access_token_secret','$account_type','$message_format','$extra')";

            $wpdb->query($sql);*/
            
            $wpdb->insert(
                    $table_accounts, 
                    array(
                        'username' => $username,
                        'password' => $password,
                        'consumer_key' => $consumer_key,
                        'consumer_secret' => $consumer_secret,
                        'access_token' => $access_token,
                        'access_token_secret' => $access_token_secret,
                        'type' => $account_type,
                        'message_format' => $message_format,
                        'extra' => $extra
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s'
                    )
            );
            
            if($wpdb->insert_id)
            {
                ?>
                <div class="updated"><p><strong><?php _e('Account added successfully.', 'microblog-poster');?></strong></p></div>
                <?php
            }
        }
        
    }
    
    if(isset($_POST["update_account_hidden"]))
    {
        $mbp_accounts_tab_selected = true;
        
        if(isset($_POST['account_id']) && intval(trim($_POST['account_id'])))
        {
            $account_id = intval(trim($_POST['account_id']));
            
            $sql="SELECT * FROM $table_accounts WHERE account_id = %d LIMIT 1";
            $rows = $wpdb->get_results($wpdb->prepare($sql, $account_id));
            $current_account = $rows[0];

            $extra = array();
            if(isset($current_account->extra) && $current_account->extra)
            {
                $extra = json_decode($current_account->extra, true);
            }

            if(isset($_POST['account_type']))
            {
                //$account_type = trim($_POST['account_type']);
                $account_type = sanitize_text_field( $_POST['account_type'] );
            }
            if(in_array($account_type, $tags_sites))
            {
                $extra['include_tags'] = 0;
                if(isset($_POST['include_tags']) && trim($_POST['include_tags']) == '1')
                {
                    $extra['include_tags'] = 1;
                }
            }
            if(in_array($account_type, $featured_image_sites))
            {
                $extra['include_featured_image'] = 0;
                if(isset($_POST['include_featured_image']) && trim($_POST['include_featured_image']) == '1')
                {
                    $extra['include_featured_image'] = 1;
                }
            }
            if($account_type=='diigo')
            {
                if(isset($_POST['api_key']))
                {
                    //$extra['api_key'] = trim($_POST['api_key']);
                    $extra['api_key'] = sanitize_text_field( $_POST['api_key'] );
                }
            }
            if(isset($_POST['consumer_key']))
            {
                //$consumer_key = trim($_POST['consumer_key']);
                $consumer_key = sanitize_text_field( $_POST['consumer_key'] );
            }
            if(isset($_POST['consumer_secret']))
            {
                //$consumer_secret = trim($_POST['consumer_secret']);
                $consumer_secret = sanitize_text_field( $_POST['consumer_secret'] );
            }
            if(isset($_POST['access_token']))
            {
                //$access_token = trim($_POST['access_token']);
                $access_token = sanitize_text_field( $_POST['access_token'] );
            }
            if(isset($_POST['access_token_secret']))
            {
                //$access_token_secret = trim($_POST['access_token_secret']);
                $access_token_secret = sanitize_text_field( $_POST['access_token_secret'] );
            }
            if(isset($_POST['username']))
            {
                //$username = trim($_POST['username']);
                $username = sanitize_text_field( $_POST['username'] );
            }
            if(isset($_POST['password']))
            {
                $password = trim($_POST['password']);
                if(in_array($account_type, $http_auth_sites))
                {
                    $password = stripslashes($password);
                    $password = MicroblogPoster_SupportEnc::enc($password);
                    $extra['penc'] = 1;
                }
            }


            if(isset($_POST['message_format']))
            {
                $message_format = trim($_POST['message_format']);
                //$message_format = sanitize_text_field( $_POST['message_format'] );
            }
            if(isset($_POST['post_type_fb']))
            {
                //$extra['post_type'] = trim($_POST['post_type_fb']);
                $extra['post_type'] = sanitize_text_field( $_POST['post_type_fb'] );
            }
            if(isset($_POST['post_type_lkn']))
            {
                //$extra['post_type'] = trim($_POST['post_type_lkn']);
                $extra['post_type'] = sanitize_text_field( $_POST['post_type_lkn'] );
            }
            if(isset($_POST['post_type_vk']))
            {
                //$extra['post_type'] = trim($_POST['post_type_vk']);
                $extra['post_type'] = sanitize_text_field( $_POST['post_type_vk'] );
            }
            if(isset($_POST['default_image_url']))
            {
                //$extra['default_image_url'] = trim($_POST['default_image_url']);
                $extra['default_image_url'] = sanitize_text_field( $_POST['default_image_url'] );
            }
            if(isset($_POST['mbp_plurk_qualifier']))
            {
                //$extra['qualifier'] = trim($_POST['mbp_plurk_qualifier']);
                $extra['qualifier'] = sanitize_text_field( $_POST['mbp_plurk_qualifier'] );
            }
            if(isset($_POST['mbp_post_type_xing']))
            {
                $extra['post_type'] = sanitize_text_field( $_POST['mbp_post_type_xing'] );
            }
            if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account'))
            {
                if(isset($_POST['mbp_facebook_page_id']))
                {
                    //$extra['page_id'] = trim($_POST['mbp_facebook_page_id']);
                    $extra['page_id'] = sanitize_text_field( $_POST['mbp_facebook_page_id'] );
                }
                if(isset($_POST['mbp_facebook_group_id']))
                {
                    //$extra['group_id'] = trim($_POST['mbp_facebook_group_id']);
                    $extra['group_id'] = sanitize_text_field( $_POST['mbp_facebook_group_id'] );
                }

                if(isset($_POST['mbp_linkedin_group_id']))
                {
                    //$extra['group_id'] = trim($_POST['mbp_linkedin_group_id']);
                    $extra['group_id'] = sanitize_text_field( $_POST['mbp_linkedin_group_id'] );
                }
                if(isset($_POST['mbp_linkedin_company_id']))
                {
                    //$extra['company_id'] = trim($_POST['mbp_linkedin_company_id']);
                    $extra['company_id'] = sanitize_text_field( $_POST['mbp_linkedin_company_id'] );
                }

                if(isset($_POST['mbp_post_type_tmb']))
                {
                    //$extra['post_type'] = trim($_POST['mbp_post_type_tmb']);
                    $extra['post_type'] = sanitize_text_field( $_POST['mbp_post_type_tmb'] );
                }
            }

            if(isset($_POST['mbp_vkontakte_target_id']))
            {
                //$extra['target_id'] = trim($_POST['mbp_vkontakte_target_id']);
                $extra['target_id'] = sanitize_text_field( $_POST['mbp_vkontakte_target_id'] );
            }
            if(isset($_POST['access_token_vk']))
            {
                //$extra['access_token'] = trim($_POST['access_token_vk']);
                $extra['access_token'] = sanitize_text_field( $_POST['access_token_vk'] );
                $extra['expires'] = '0';
            }
            if(isset($_POST['mbp_tumblr_blog_hostname']))
            {
                //$extra['blog_hostname'] = trim($_POST['mbp_tumblr_blog_hostname']);
                $extra['blog_hostname'] = sanitize_text_field( $_POST['mbp_tumblr_blog_hostname'] );
            }
            if(isset($_POST['mbp_blogger_blog_id']))
            {
                //$extra['blog_id'] = trim($_POST['mbp_blogger_blog_id']);
                $extra['blog_id'] = sanitize_text_field( $_POST['mbp_blogger_blog_id'] );
            }

            if($account_type == 'twitter' && $consumer_key && $consumer_secret && $access_token && $access_token_secret)
            {
                $extra['authorized'] = 1;
            }
            elseif($account_type == 'twitter' && (!$consumer_key || !$consumer_secret || !$access_token || !$access_token_secret))
            {
                $extra['authorized'] = 0;
            }

            $extra = json_encode($extra);
            //$wpdb->escape_by_ref($extra);

            if($username)
            {
                /*$sql = "UPDATE {$table_accounts}
                    SET username='{$username}',
                    password='{$password}',
                    consumer_key='{$consumer_key}',
                    consumer_secret='{$consumer_secret}',
                    access_token='{$access_token}',
                    access_token_secret='{$access_token_secret}',
                    message_format='{$message_format}',
                    extra='{$extra}'";

                $sql .= " WHERE account_id={$account_id}";

                $wpdb->query($sql);*/
                
                $wpdb->update(
                        $table_accounts, 
                        array(
                            'username' => $username,
                            'password' => $password,
                            'consumer_key' => $consumer_key,
                            'consumer_secret' => $consumer_secret,
                            'access_token' => $access_token,
                            'access_token_secret' => $access_token_secret,
                            'message_format' => $message_format,
                            'extra' => $extra
                        ),
                        array(
                            'account_id' => $account_id
                        )
                );
                
                ?>
                <div class="updated"><p><strong><?php _e('Account updated successfully.', 'microblog-poster');?></strong></p></div>
                <?php
            }
        }
        
    }
    
    if(isset($_POST["delete_account_hidden"]))
    {
        $mbp_accounts_tab_selected = true;
        
        if(isset($_POST['account_id']) && intval(trim($_POST['account_id'])))
        {
            $account_id = intval(trim($_POST['account_id']));
            
            $sql = "DELETE FROM {$table_accounts} WHERE account_id = %d";
            $wpdb->query($wpdb->prepare($sql, $account_id));
            
            ?>
            <div class="updated"><p><strong><?php _e('Account deleted successfully.', 'microblog-poster');?></strong></p></div>
            <?php
        }
        
        
    }
    
    // Facebook accounts authorization process
    
    $server_name = $_SERVER['SERVER_NAME'];
    if(isset($_SERVER['HTTP_HOST']))
    {
        $server_name = $_SERVER['HTTP_HOST'];
    }
    $request_uri = $_SERVER['REQUEST_URI'];
    $request_uri_arr = explode('&', $request_uri, 2);
    $request_uri = $request_uri_arr[0];
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off')?'https':'http';
    $redirect_uri = $protocol.'://'.$server_name.$request_uri;
    $code = null;
    $redirect_after_auth = false;
    $redirect_after_auth1 = false;
    if(isset($_GET['state']) && isset($_GET['code']))
    {
        $mbp_accounts_tab_selected = true;
        
        if(preg_match('|^microblogposter\_|i',trim($_GET['state'])))
        {
            $code = trim($_GET['code']);
            $auth_user_data = explode('_', trim($_GET['state']));
            $auth_user_id = (int) $auth_user_data[1];
            
            if(is_int($auth_user_id))
            {
                $sql="SELECT * FROM $table_accounts WHERE account_id = %d";
                $rows = $wpdb->get_results($wpdb->prepare($sql, $auth_user_id));
                $row = $rows[0];
                $extra = json_decode($row->extra, true);
                $account_details = $extra;
                
                $log_data = array();
                $log_data['account_id'] = $row->account_id;
                $log_data['account_type'] = "facebook";
                $log_data['username'] = $row->username.' - Authorization';
                $log_data['post_id'] = 0;
                $log_data['action_result'] = 0;
                $log_data['update_message'] = '';
                
                if($code)
                {
                    $curl = new MicroblogPoster_Curl();
                    
                    $access_url = "https://graph.facebook.com/oauth/access_token?client_id={$row->consumer_key}&client_secret={$row->consumer_secret}&redirect_uri={$redirect_uri}&code={$code}";
                    
                    $response = $curl->fetch_url($access_url);
                    parse_str($response, $params);
                    $account_details['access_token'] = $params['access_token'];
                    $account_details['expires'] = 0;
                    if(isset($params['expires']))
                    {
                        $account_details['expires'] = time()+$params['expires'];
                    }
                    
                    if(!isset($params['access_token']))
                    {
                        $log_data['log_message'] = $response;
                        MicroblogPoster_Poster::insert_log($log_data);
                    }

                    

                    $user_url = "https://graph.facebook.com/me?fields=id,first_name,last_name&access_token={$params['access_token']}";
                    
                    $response = $curl->fetch_url($user_url);
                    $params1 = json_decode($response, true);
                    $account_details['user_id'] = '';
                    if(isset($params1['first_name']) && isset($params1['last_name']))
                    {
                        $account_details['user_id'] = $params1['id'];
                    }
                    else
                    {
                        $log_data['log_message'] = $response;
                        MicroblogPoster_Poster::insert_log($log_data);
                    }
                    
                    
                    $app_access_url = "https://graph.facebook.com/oauth/access_token?client_id={$row->consumer_key}&client_secret={$row->consumer_secret}&grant_type=client_credentials";
                    
                    $response = $curl->fetch_url($app_access_url);
                    parse_str($response, $params2);
                    $app_access_token = $params2['access_token'];
                    if(!isset($params2['access_token']))
                    {
                        $log_data['log_message'] = $response;
                        MicroblogPoster_Poster::insert_log($log_data);
                    }
                    
                    
                    if($account_details['target_type'] == 'page')
                    {
                        if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro_Options','get_facebook_page_access_token'))
                        {
                            $fb_page_access_token = MicroblogPoster_Poster_Pro_Options::get_facebook_page_access_token($curl, $account_details['user_id'], $params['access_token'], $account_details['page_id'], $app_access_token);
                            $account_details['access_token'] = $fb_page_access_token['access_token'];
                            $account_details['expires'] = $fb_page_access_token['expires'];
                        }
                    }
                    elseif($account_details['target_type'] == 'group')
                    {
                        if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro_Options','get_facebook_group_access_token'))
                        {
                            $fb_group_access_token = MicroblogPoster_Poster_Pro_Options::get_facebook_group_access_token($curl, $account_details['user_id'], $params['access_token'], $app_access_token);
                            $account_details['access_token'] = $fb_group_access_token['access_token'];
                            $account_details['expires'] = $fb_group_access_token['expires'];
                        } 
                    }
                    else
                    {
                        $account_details['access_token'] = $app_access_token;
                        $account_details['expires'] = 0;
                    }
                    
                    
                    $redirect_after_auth = true;
                }
                
                $account_details_enc = json_encode($account_details);
                //$wpdb->escape_by_ref($account_details);
                
                /*$sql = "UPDATE {$table_accounts}
                    SET extra='{$account_details}'
                    WHERE account_id={$auth_user_id}";

                $wpdb->query($sql);*/
                
                $wpdb->update(
                        $table_accounts, 
                        array(
                            'extra' => $account_details_enc
                        ),
                        array(
                            'account_id' => $auth_user_id
                        )
                );
            }
            
            
        }
        elseif(preg_match('|^linkedin_microblogposter\_|i',trim($_GET['state'])))
        {
            $code = trim($_GET['code']);
            $auth_user_data = explode('_', trim($_GET['state']));
            $auth_user_id = (int) $auth_user_data[2];
            $linkedin_update_all_access_tokens = false;
            
            if(is_int($auth_user_id))
            {
                $sql="SELECT * FROM $table_accounts WHERE account_id = %d";
                $rows = $wpdb->get_results($wpdb->prepare($sql, $auth_user_id));
                $row = $rows[0];
                $extra = json_decode($row->extra, true);
                $account_details = $extra;
                $linkedin_consumer_key = $row->consumer_key;
                $linkedin_consumer_secret = $row->consumer_secret;

                $log_data = array();
                $log_data['account_id'] = $row->account_id;
                $log_data['account_type'] = "linkedin";
                $log_data['username'] = $row->username;
                $log_data['post_id'] = 0;
                $log_data['action_result'] = 0;
                $log_data['update_message'] = 'Linkedin Authorization';
                
                if($code)
                {
                    $url = "https://www.linkedin.com/uas/oauth2/accessToken";
                    $post_args = array(
                        'grant_type' => 'authorization_code',
                        'code' => $code,
                        'redirect_uri' => $redirect_uri,
                        'client_id' => $row->consumer_key,
                        'client_secret' => $row->consumer_secret
                    );

                    $curl = new MicroblogPoster_Curl();
                    $json_res = $curl->send_post_data($url, $post_args);
                    $response = json_decode($json_res, true);
                    
                    if(isset($response['access_token']))
                    {
                        $account_details['access_token'] = $response['access_token'];
                        $account_details['expires'] = time()+$response['expires_in'];
                        $linkedin_update_all_access_tokens = true;
                    }
                    else
                    {
                        $log_data['log_message'] = $json_res;
                        MicroblogPoster_Poster::insert_log($log_data);
                    }
                    
                    $redirect_after_auth = true;
                }

                $account_details_enc = json_encode($account_details);
                //$wpdb->escape_by_ref($account_details_enc);
                
                /*$sql = "UPDATE {$table_accounts}
                    SET extra='{$account_details_enc}'
                    WHERE account_id={$auth_user_id}";

                $wpdb->query($sql);*/
                
                $wpdb->update(
                        $table_accounts, 
                        array(
                            'extra' => $account_details_enc
                        ),
                        array(
                            'account_id' => $auth_user_id
                        )
                );
            }
            
            if($linkedin_update_all_access_tokens)
            {
                /*$sql="SELECT * FROM $table_accounts WHERE type='linkedin' 
                    AND consumer_key='{$linkedin_consumer_key}' 
                    AND consumer_secret='{$linkedin_consumer_secret}'";
                $rows = $wpdb->get_results($sql);*/
                
                $sql="SELECT * FROM $table_accounts WHERE type = %s 
                    AND consumer_key = %s 
                    AND consumer_secret = %s";
                $rows = $wpdb->get_results(
                            $wpdb->prepare(
                                    $sql, 
                                    'linkedin', 
                                    $linkedin_consumer_key, 
                                    $linkedin_consumer_secret));
                
                if(is_array($rows) && !empty($rows))
                {
                    foreach($rows as $row)
                    {
                        if($row->extra)
                        {
                            $lkn_acc_extra_auth = json_decode($row->extra, true);
                            $lkn_acc_extra_auth['access_token'] = $account_details['access_token'];
                            $lkn_acc_extra_auth['expires'] = $account_details['expires'];
                            $lkn_acc_extra_auth = json_encode($lkn_acc_extra_auth);
                            //$wpdb->escape_by_ref($lkn_acc_extra_auth);

                            /*$sql = "UPDATE {$table_accounts}
                                SET extra='{$lkn_acc_extra_auth}'
                                WHERE account_id={$row->account_id}";

                            $wpdb->query($sql);*/
                            
                            $wpdb->update(
                                    $table_accounts, 
                                    array(
                                        'extra' => $lkn_acc_extra_auth
                                    ),
                                    array(
                                        'account_id' => $row->account_id
                                    )
                            );
                        }
                    }
                }
                
            }
        }
        elseif(preg_match('|^blogger_microblogposter\_|i',trim($_GET['state'])))
        {
            $code = trim($_GET['code']);
            $auth_user_data = explode('_', trim($_GET['state']));
            $auth_user_id = (int) $auth_user_data[2];
            
            if(is_int($auth_user_id))
            {
                $sql="SELECT * FROM $table_accounts WHERE account_id = %d";
                $rows = $wpdb->get_results($wpdb->prepare($sql, $auth_user_id));
                $row = $rows[0];
                $extra = json_decode($row->extra, true);
                $account_details = $extra;
                $blogger_consumer_key = $row->consumer_key;
                $blogger_consumer_secret = $row->consumer_secret;

                $log_data = array();
                $log_data['account_id'] = $row->account_id;
                $log_data['account_type'] = "blogger";
                $log_data['username'] = $row->username;
                $log_data['post_id'] = 0;
                $log_data['action_result'] = 0;
                $log_data['update_message'] = 'Blogger Authorization';
                
                if($code)
                {
                    $url = "https://accounts.google.com/o/oauth2/token";
                    $post_args = array(
                        'grant_type' => 'authorization_code',
                        'code' => $code,
                        'redirect_uri' => $redirect_uri,
                        'client_id' => $blogger_consumer_key,
                        'client_secret' => $blogger_consumer_secret
                    );

                    $curl = new MicroblogPoster_Curl();
                    $json_res = $curl->send_post_data($url, $post_args);
                    $response = json_decode($json_res, true);
                    
                    if(isset($response['access_token']) && isset($response['token_type']) && $response['token_type'] == 'Bearer')
                    {
                        $account_details['access_token'] = $response['access_token'];
                        if (isset($response['refresh_token']) && $response['refresh_token'])
                        {
                            $account_details['refresh_token'] = $response['refresh_token'];
                        }
                        else
                        {
                            /*$sql="SELECT * FROM $table_accounts WHERE type='blogger' 
                                AND consumer_key='{$blogger_consumer_key}' 
                                AND consumer_secret='{$blogger_consumer_secret}'";
                            $rows = $wpdb->get_results($sql);*/
                            
                            $sql="SELECT * FROM $table_accounts WHERE type = %s 
                                AND consumer_key = %s 
                                AND consumer_secret = %s";
                            $rows = $wpdb->get_results(
                                        $wpdb->prepare(
                                                $sql, 
                                                'blogger', 
                                                $blogger_consumer_key, 
                                                $blogger_consumer_secret));
                            if(is_array($rows) && !empty($rows))
                            {
                                foreach($rows as $row)
                                {
                                    if($row->extra)
                                    {
                                        $blogger_acc_extra_auth = json_decode($row->extra, true);
                                        if (isset($blogger_acc_extra_auth['refresh_token']))
                                        {
                                            $account_details['refresh_token'] = $blogger_acc_extra_auth['refresh_token'];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                        $account_details['expires'] = time()+$response['expires_in'];
                    }
                    else
                    {
                        $log_data['log_message'] = $json_res;
                        MicroblogPoster_Poster::insert_log($log_data);
                    }
                    
                    $redirect_after_auth = true;
                }

                $account_details_enc = json_encode($account_details);
                //$wpdb->escape_by_ref($account_details_enc);
                
                /*$sql = "UPDATE {$table_accounts}
                    SET extra='{$account_details_enc}'
                    WHERE account_id={$auth_user_id}";

                $wpdb->query($sql);*/
                
                $wpdb->update(
                        $table_accounts, 
                        array(
                            'extra' => $account_details_enc
                        ),
                        array(
                            'account_id' => $auth_user_id
                        )
                );
            }
            
        }
        elseif(preg_match('|^googl_microblogposter_plg|i',trim($_GET['state'])))
        {
            $code = trim($_GET['code']);
            
            $googl_api_client_id_value = get_option($googl_api_client_id_name, "");
            $googl_api_client_secret_value = get_option($googl_api_client_secret_name, "");

            $log_data = array();
            $log_data['account_id'] = 0;
            $log_data['account_type'] = "goo.gl";
            $log_data['username'] = 'None';
            $log_data['post_id'] = 0;
            $log_data['action_result'] = 0;
            $log_data['update_message'] = 'Goo.gl Authorization';

            if($code)
            {
                $url = "https://accounts.google.com/o/oauth2/token";
                $post_args = array(
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => $redirect_uri,
                    'client_id' => $googl_api_client_id_value,
                    'client_secret' => $googl_api_client_secret_value
                );

                $curl = new MicroblogPoster_Curl();
                $json_res = $curl->send_post_data($url, $post_args);
                $response = json_decode($json_res, true);

                if(isset($response['refresh_token']) && isset($response['token_type']) && $response['token_type'] == 'Bearer')
                {
                    update_option($googl_api_refresh_token_name, $response['refresh_token']);
                }
                elseif(isset($response['access_token']) && isset($response['token_type']) && $response['token_type'] == 'Bearer')
                {
                    
                }
                else
                {
                    $log_data['log_message'] = $json_res;
                    MicroblogPoster_Poster::insert_log($log_data);
                }

                $redirect_after_auth1 = true;
            }
        }
    }
    if(isset($_GET['microblogposter_auth_tumblr']) && isset($_GET['account_id']))
    {
        
        $tumblr_account_id = (int) $_GET['account_id'];
        if(is_int($tumblr_account_id))
        {
            /*$sql="SELECT * FROM $table_accounts WHERE account_id={$tumblr_account_id}";
            $rows = $wpdb->get_results($sql);*/
            $sql="SELECT * FROM $table_accounts WHERE account_id = %d";
            $rows = $wpdb->get_results($wpdb->prepare($sql, $tumblr_account_id));
            $row = $rows[0];
            $tmb_acc_extra_auth = json_decode($row->extra, true);
            $tumblr_c_key = $row->consumer_key;
            $tumblr_c_secret = $row->consumer_secret;
            $tumblr_consumer = new MicroblogPosterOAuthConsumer($tumblr_c_key, $tumblr_c_secret, null);
            $tumblr_req_token_url = 'http://www.tumblr.com/oauth/request_token';
            $params = array('oauth_callback'=>$redirect_uri.'&microblogposter_access_tumblr=tumblr_microblogposter_'.$tumblr_account_id);
            $tumblr_sig_method = new MicroblogPosterOAuthSignatureMethod_HMAC_SHA1();
            $tumblr_req_token_step = MicroblogPosterOAuthRequest::from_consumer_and_token($tumblr_consumer, null, "GET", $tumblr_req_token_url, $params);
            $tumblr_req_token_step->sign_request($tumblr_sig_method, $tumblr_consumer, null);
            $curl = new MicroblogPoster_Curl();
            $response = $curl->fetch_url($tumblr_req_token_step);
            parse_str($response, $params);
            $tumblr_at_key = $params['oauth_token'];
            $tumblr_at_secret = $params['oauth_token_secret'];
            $tmb_acc_extra_auth['authorized'] = '0';
            //$wpdb->escape_by_ref($tumblr_at_key);
            //$wpdb->escape_by_ref($tumblr_at_secret);
            $tmb_acc_extra_auth = json_encode($tmb_acc_extra_auth);
            //$wpdb->escape_by_ref($tmb_acc_extra_auth);
            /*$sql = "UPDATE {$table_accounts}
                    SET access_token='{$tumblr_at_key}', 
                        access_token_secret='{$tumblr_at_secret}',
                        extra='{$tmb_acc_extra_auth}'    
                    WHERE account_id={$tumblr_account_id}";

            $wpdb->query($sql);*/
            
            $wpdb->update(
                    $table_accounts, 
                    array(
                        'access_token' => $tumblr_at_key,
                        'access_token_secret' => $tumblr_at_secret,
                        'extra' => $tmb_acc_extra_auth
                    ),
                    array(
                        'account_id' => $tumblr_account_id
                    )
            );
            
            $authorize_url_name = 'authorize_url_'.$tumblr_account_id;
            $$authorize_url_name = 'http://www.tumblr.com/oauth/authorize'.'?oauth_token='.$params['oauth_token'].
                    '&oauth_callback='.urlencode($redirect_uri).'&microblogposter_access_tumblr=tumblr_microblogposter_'.$tumblr_account_id;
            
            $mbp_accounts_tab_selected = true;
        }
    }
    if(isset($_GET['microblogposter_access_tumblr']) && isset($_GET['oauth_verifier']))
    {
        if(preg_match('|^tumblr_microblogposter\_|i',trim($_GET['microblogposter_access_tumblr'])))
        {
            $auth_user_data = explode('_', trim($_GET['microblogposter_access_tumblr']));
            $tumblr_account_id = (int) $auth_user_data[2];
            /*$sql="SELECT * FROM $table_accounts WHERE account_id={$tumblr_account_id}";
            $rows = $wpdb->get_results($sql);*/
            $sql="SELECT * FROM $table_accounts WHERE account_id = %d";
            $rows = $wpdb->get_results($wpdb->prepare($sql, $tumblr_account_id));
            $row = $rows[0];
            $tmb_acc_extra_auth = json_decode($row->extra, true);
            $tumblr_c_key = $row->consumer_key;
            $tumblr_c_secret = $row->consumer_secret;
            $tumblr_at_key = $row->access_token;
            $tumblr_at_secret = $row->access_token_secret;
            $tumblr_consumer = new MicroblogPosterOAuthConsumer($tumblr_c_key, $tumblr_c_secret, null);
            $tumblr_token = new MicroblogPosterOAuthToken($tumblr_at_key, $tumblr_at_secret, null);
            $tumblr_acc_token_url = 'http://www.tumblr.com/oauth/access_token';
            $params = array('oauth_verifier'=>trim($_GET['oauth_verifier']));
            $tumblr_sig_method = new MicroblogPosterOAuthSignatureMethod_HMAC_SHA1();
            $tumblr_acc_token_step = MicroblogPosterOAuthRequest::from_consumer_and_token($tumblr_consumer, $tumblr_token, "GET", $tumblr_acc_token_url, $params);
            $tumblr_acc_token_step->sign_request($tumblr_sig_method, $tumblr_consumer, $tumblr_token);
            $curl = new MicroblogPoster_Curl();
            $response = $curl->fetch_url($tumblr_acc_token_step);
            parse_str($response, $params);
            $tumblr_at_key1 = $params['oauth_token'];
            $tumblr_at_secret1 = $params['oauth_token_secret'];
            $tmb_acc_extra_auth['authorized'] = '1';
            $tmb_acc_extra_auth['expires'] = 0;
            //$wpdb->escape_by_ref($tumblr_at_key1);
            //$wpdb->escape_by_ref($tumblr_at_secret1);
            $tmb_acc_extra_auth = json_encode($tmb_acc_extra_auth);
            //$wpdb->escape_by_ref($tmb_acc_extra_auth);
            /*$sql = "UPDATE {$table_accounts}
                    SET access_token='{$tumblr_at_key1}', 
                        access_token_secret='{$tumblr_at_secret1}',
                        extra='{$tmb_acc_extra_auth}'
                    WHERE account_id={$tumblr_account_id}";

            $wpdb->query($sql);*/
            
            $wpdb->update(
                    $table_accounts, 
                    array(
                        'access_token' => $tumblr_at_key1,
                        'access_token_secret' => $tumblr_at_secret1,
                        'extra' => $tmb_acc_extra_auth
                    ),
                    array(
                        'account_id' => $tumblr_account_id
                    )
            );
            $redirect_after_auth = true;
        }
    }
    if(isset($_GET['microblogposter_auth_twitter']) && isset($_GET['account_id']))
    {
        
        $twitter_account_id = (int) $_GET['account_id'];
        if(is_int($twitter_account_id))
        {   
            /*$sql="SELECT * FROM $table_accounts WHERE account_id={$twitter_account_id}";
            $rows = $wpdb->get_results($sql);*/
            $sql="SELECT * FROM $table_accounts WHERE account_id = %d";
            $rows = $wpdb->get_results($wpdb->prepare($sql, $twitter_account_id));
            $row = $rows[0];
            
            $log_data = array();
            $log_data['account_id'] = $row->account_id;
            $log_data['account_type'] = "twitter";
            $log_data['username'] = $row->username;
            $log_data['post_id'] = 0;
            $log_data['action_result'] = 0;
            $log_data['update_message'] = 'Twitter Authorization Step 1';
            
            $twt_acc_extra_auth = json_decode($row->extra, true);
            $twitter_c_key = $row->consumer_key;
            $twitter_c_secret = $row->consumer_secret;
            $twitter_consumer = new MicroblogPosterOAuthConsumer($twitter_c_key, $twitter_c_secret, null);
            $twitter_req_token_url = 'https://api.twitter.com/oauth/request_token';
            $params = array('oauth_callback'=>$redirect_uri.'&microblogposter_access_twitter=twitter_microblogposter_'.$twitter_account_id);
            $twitter_sig_method = new MicroblogPosterOAuthSignatureMethod_HMAC_SHA1();
            $twitter_req_token_step = MicroblogPosterOAuthRequest::from_consumer_and_token($twitter_consumer, null, "POST", $twitter_req_token_url, $params);
            $twitter_req_token_step->sign_request($twitter_sig_method, $twitter_consumer, null);
            $curl = new MicroblogPoster_Curl();
            $response = $curl->send_post_data('https://api.twitter.com/oauth/request_token', $twitter_req_token_step->get_parameters());
            if($response && stripos($response, 'oauth_token=')===false)
            {
                $log_data['log_message'] = $response;
                MicroblogPoster_Poster::insert_log($log_data);
            }
            parse_str($response, $params);
            $twitter_at_key = $params['oauth_token'];
            $twitter_at_secret = $params['oauth_token_secret'];
            $twt_acc_extra_auth['authorized'] = '0';
            //$wpdb->escape_by_ref($twitter_at_key);
            //$wpdb->escape_by_ref($twitter_at_secret);
            $twt_acc_extra_auth = json_encode($twt_acc_extra_auth);
            //$wpdb->escape_by_ref($twt_acc_extra_auth);
            /*$sql = "UPDATE {$table_accounts}
                    SET access_token='{$twitter_at_key}', 
                        access_token_secret='{$twitter_at_secret}',
                        extra='{$twt_acc_extra_auth}'    
                    WHERE account_id={$twitter_account_id}";

            $wpdb->query($sql);*/
            
            $wpdb->update(
                    $table_accounts, 
                    array(
                        'access_token' => $twitter_at_key,
                        'access_token_secret' => $twitter_at_secret,
                        'extra' => $twt_acc_extra_auth
                    ),
                    array(
                        'account_id' => $twitter_account_id
                    )
            );
            
            $authorize_url_name = 'authorize_url_'.$twitter_account_id;
            $$authorize_url_name = 'https://api.twitter.com/oauth/authorize'.'?oauth_token='.$params['oauth_token'].
                    '&force_login=1&microblogposter_access_twitter=twitter_microblogposter_'.$twitter_account_id;
            
            $mbp_accounts_tab_selected = true;
        }
    }
    if(isset($_GET['microblogposter_access_twitter']) && isset($_GET['oauth_verifier']))
    {
        if(preg_match('|^twitter_microblogposter\_|i',trim($_GET['microblogposter_access_twitter'])))
        {
            $auth_user_data = explode('_', trim($_GET['microblogposter_access_twitter']));
            $twitter_account_id = (int) $auth_user_data[2];
            /*$sql="SELECT * FROM $table_accounts WHERE account_id={$twitter_account_id}";
            $rows = $wpdb->get_results($sql);*/
            $sql="SELECT * FROM $table_accounts WHERE account_id = %d";
            $rows = $wpdb->get_results($wpdb->prepare($sql, $twitter_account_id));
            $row = $rows[0];
            
            $log_data = array();
            $log_data['account_id'] = $row->account_id;
            $log_data['account_type'] = "twitter";
            $log_data['username'] = $row->username;
            $log_data['post_id'] = 0;
            $log_data['action_result'] = 0;
            $log_data['update_message'] = 'Twitter Authorization Step 2';
            
            $twt_acc_extra_auth = json_decode($row->extra, true);
            $twitter_c_key = $row->consumer_key;
            $twitter_c_secret = $row->consumer_secret;
            $twitter_at_key = $row->access_token;
            $twitter_at_secret = $row->access_token_secret;
            $twitter_consumer = new MicroblogPosterOAuthConsumer($twitter_c_key, $twitter_c_secret, null);
            $twitter_token = new MicroblogPosterOAuthToken($twitter_at_key, $twitter_at_secret, null);
            $twitter_acc_token_url = 'https://api.twitter.com/oauth/access_token';
            $params = array('oauth_verifier'=>trim($_GET['oauth_verifier']));
            $twitter_sig_method = new MicroblogPosterOAuthSignatureMethod_HMAC_SHA1();
            $twitter_acc_token_step = MicroblogPosterOAuthRequest::from_consumer_and_token($twitter_consumer, $twitter_token, "POST", $twitter_acc_token_url, $params);
            $twitter_acc_token_step->sign_request($twitter_sig_method, $twitter_consumer, $twitter_token);
            $curl = new MicroblogPoster_Curl();
            $response = $curl->send_post_data('https://api.twitter.com/oauth/access_token', $twitter_acc_token_step->get_parameters());
            if($response && stripos($response, 'oauth_token=')===false)
            {
                $log_data['log_message'] = $response;
                MicroblogPoster_Poster::insert_log($log_data);
            }
            parse_str($response, $params);
            $twitter_at_key1 = $params['oauth_token'];
            $twitter_at_secret1 = $params['oauth_token_secret'];
            $twt_acc_extra_auth['authorized'] = '1';
            //$wpdb->escape_by_ref($twitter_at_key1);
            //$wpdb->escape_by_ref($twitter_at_secret1);
            $twt_acc_extra_auth = json_encode($twt_acc_extra_auth);
            //$wpdb->escape_by_ref($twt_acc_extra_auth);
            /*$sql = "UPDATE {$table_accounts}
                    SET access_token='{$twitter_at_key1}', 
                        access_token_secret='{$twitter_at_secret1}',
                        extra='{$twt_acc_extra_auth}'
                    WHERE account_id={$twitter_account_id}";

            $wpdb->query($sql);*/
            
            $wpdb->update(
                    $table_accounts, 
                    array(
                        'access_token' => $twitter_at_key1,
                        'access_token_secret' => $twitter_at_secret1,
                        'extra' => $twt_acc_extra_auth
                    ),
                    array(
                        'account_id' => $twitter_account_id
                    )
            );
            $redirect_after_auth = true;
        }
    }
    if(isset($_GET['microblogposter_auth_xing']) && isset($_GET['account_id']))
    {
        $xing_account_id = (int) $_GET['account_id'];
        if(is_int($xing_account_id))
        {
            $sql="SELECT * FROM $table_accounts WHERE account_id = %d";
            $rows = $wpdb->get_results($wpdb->prepare($sql, $xing_account_id));
            $row = $rows[0];
            $xing_acc_extra_auth = json_decode($row->extra, true);
            $xing_c_key = $row->consumer_key;
            $xing_c_secret = $row->consumer_secret;
            $xing_consumer = new MicroblogPosterOAuthConsumer($xing_c_key, $xing_c_secret, null);
            $xing_req_token_url = 'https://api.xing.com/v1/request_token';
            $params = array('oauth_callback'=>$redirect_uri.'&microblogposter_access_xing=xing_microblogposter_'.$xing_account_id);
            $xing_sig_method = new MicroblogPosterOAuthSignatureMethod_HMAC_SHA1();
            $xing_req_token_step = MicroblogPosterOAuthRequest::from_consumer_and_token($xing_consumer, null, "GET", $xing_req_token_url, $params);
            $xing_req_token_step->sign_request($xing_sig_method, $xing_consumer, null);
            $curl = new MicroblogPoster_Curl();
            $response = $curl->fetch_url($xing_req_token_step);
            parse_str($response, $params);
            $xing_at_key = $params['oauth_token'];
            $xing_at_secret = $params['oauth_token_secret'];
            $xing_acc_extra_auth['authorized'] = '0';
            $xing_acc_extra_auth = json_encode($xing_acc_extra_auth);
            $wpdb->update(
                    $table_accounts, 
                    array(
                        'access_token' => $xing_at_key,
                        'access_token_secret' => $xing_at_secret,
                        'extra' => $xing_acc_extra_auth
                    ),
                    array(
                        'account_id' => $xing_account_id
                    )
            );
            $authorize_url_name = 'authorize_url_'.$xing_account_id;
            $$authorize_url_name = 'https://api.xing.com/v1/authorize'.'?oauth_token='.$params['oauth_token'].
                    '&oauth_callback='.urlencode($redirect_uri).'&microblogposter_access_xing=xing_microblogposter_'.$xing_account_id;
            
            $mbp_accounts_tab_selected = true;
        }
    }
    if(isset($_GET['microblogposter_access_xing']) && isset($_GET['oauth_verifier']))
    {
        if(preg_match('|^xing_microblogposter\_|i',trim($_GET['microblogposter_access_xing'])))
        {
            $auth_user_data = explode('_', trim($_GET['microblogposter_access_xing']));
            $xing_account_id = (int) $auth_user_data[2];
            $sql="SELECT * FROM $table_accounts WHERE account_id = %d";
            $rows = $wpdb->get_results($wpdb->prepare($sql, $xing_account_id));
            $row = $rows[0];
            $xing_acc_extra_auth = json_decode($row->extra, true);
            $xing_c_key = $row->consumer_key;
            $xing_c_secret = $row->consumer_secret;
            $xing_at_key = $row->access_token;
            $xing_at_secret = $row->access_token_secret;
            $xing_consumer = new MicroblogPosterOAuthConsumer($xing_c_key, $xing_c_secret, null);
            $xing_token = new MicroblogPosterOAuthToken($xing_at_key, $xing_at_secret, null);
            $xing_acc_token_url = 'https://api.xing.com/v1/access_token';
            $params = array('oauth_verifier'=>trim($_GET['oauth_verifier']));
            $xing_sig_method = new MicroblogPosterOAuthSignatureMethod_HMAC_SHA1();
            $xing_acc_token_step = MicroblogPosterOAuthRequest::from_consumer_and_token($xing_consumer, $xing_token, "GET", $xing_acc_token_url, $params);
            $xing_acc_token_step->sign_request($xing_sig_method, $xing_consumer, $xing_token);
            $curl = new MicroblogPoster_Curl();
            $response = $curl->fetch_url($xing_acc_token_step);
            parse_str($response, $params);
            $xing_at_key1 = $params['oauth_token'];
            $xing_at_secret1 = $params['oauth_token_secret'];
            $xing_acc_extra_auth['authorized'] = '1';
            $xing_acc_extra_auth['expires'] = 0;
            $xing_acc_extra_auth['user_id'] = $params['user_id'];
            $xing_acc_extra_auth = json_encode($xing_acc_extra_auth);
            $wpdb->update(
                    $table_accounts, 
                    array(
                        'access_token' => $xing_at_key1,
                        'access_token_secret' => $xing_at_secret1,
                        'extra' => $xing_acc_extra_auth
                    ),
                    array(
                        'account_id' => $xing_account_id
                    )
            );
            $redirect_after_auth = true;
        }
    }
    
    $shortcodes_intro = __( 'You can use shortcodes:', 'microblog-poster' );
    $title_shortcode = "{TITLE} = " . __( 'Title of the blog post.', 'microblog-poster' );
    $url_shortcode = "{URL} = " . __( 'Url of the blog post.', 'microblog-poster' );
    $short_url_shortcode = "{SHORT_URL} = " . __( 'The blog post shortened url.', 'microblog-poster' );
    $site_url_shortcode = "{SITE_URL} = " . __( 'Your blog/site url.', 'microblog-poster' );
    $manual_excerpt_shortcode = "{MANUAL_EXCERPT} = " . __( 'Manually entered post excerpt, otherwise empty string.', 'microblog-poster' );
    $excerpt_shortcode = "{EXCERPT} = " . __( 'If provided equals to manual excerpt, otherwise auto generated.', 'microblog-poster' );
    $content_first_words_shortcode = "{CONTENT_FIRST_WORDS} = " . __( 'First few words of your content, suitable for twitter-like sites.', 'microblog-poster' );
    $author_shortcode = "{AUTHOR} = " . __( "The author's name.", 'microblog-poster' );
    
    $description_shortcodes = $shortcodes_intro . ' ' . $title_shortcode . ' ' . $url_shortcode . ' ' . $short_url_shortcode;
    $description_shortcodes .= ' ' . $site_url_shortcode . ' ' . $manual_excerpt_shortcode . ' ' . $excerpt_shortcode;
    $description_shortcodes .= ' ' . $content_first_words_shortcode . ' ' . $author_shortcode;
    
    $description_shortcodes_m = $shortcodes_intro . ' ' . $title_shortcode . ' ' . $url_shortcode . ' ' . $short_url_shortcode;
    $description_shortcodes_m .= ' ' . $site_url_shortcode . ' ' . $content_first_words_shortcode . ' ' . $author_shortcode;
    
    $description_shortcodes_m_ff = $shortcodes_intro . ' ' . $title_shortcode;
    $description_shortcodes_m_ff .= ' ' . $content_first_words_shortcode . ' ' . $author_shortcode;
    
    $description_shortcodes_bookmark = $shortcodes_intro . ' ' . $title_shortcode;
    $description_shortcodes_bookmark .= ' ' . $manual_excerpt_shortcode . ' ' . $excerpt_shortcode;
    $description_shortcodes_bookmark .= ' ' . $content_first_words_shortcode . ' ' . $author_shortcode;
    
    $description_mandatory_username = __('Mandatory. Easily identify it, not used for posting.', 'microblog-poster');
    ?>
    
   
    <div class="wrap">
        <div id="icon-plugins" class="icon32"><br /></div>
        <h2 id="mbp-intro">
            <?php _e('<span class="microblogposter-name">MicroblogPoster</span> Settings', 'microblog-poster');?>
            <?php if(!MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                <span class="mbp-intro-text"><?php _e('Advanced features are available with the Pro / Enterprise Add-on', 'microblog-poster');?></span>
                <a class="mbp-intro-text" href="http://efficientscripts.com/microblogposteraddons" target="_blank"><?php _e('Upgrade Now', 'microblog-poster');?></a>
            <?php endif;?>
        </h2>
        
        <p>
            <?php _e('The idea behind <span class="microblogposter-name">MicroblogPoster</span> is to promote your wordpress blog and reach more people through social networks.', 'microblog-poster');?> <br />
            <?php _e('There\'s a general agreement in the SEO community that social signals strengthen your blog\'s page rank and authority.', 'microblog-poster');?><br />
            <?php _e('<span class="microblogposter-name">MicroblogPoster</span> is simply an intermediary between your blog and your own social network accounts.', 'microblog-poster');?><br /> 
            <?php _e('You\'ll never see "posted by MicroblogPoster" in your updates, you\'ll see "posted by your own App name" or simply "by API".', 'microblog-poster');?><br />
            <?php _e('If you like <span class="microblogposter-name">MicroblogPoster</span> or just find it useful, please <a class="mbp-add-review-link" href="https://wordpress.org/support/view/plugin-reviews/microblog-poster" target="_blank">Add a review</a>', 'microblog-poster');?>
        </p>
            
        <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account') && !$customer_license_key_value['key']):?>
            <div class="error"><p><strong><?php _e('In order to complete the MicroblogPoster\'s Pro / Enterprise Add-on installation, please Save your Customer License Key.', 'microblog-poster');?></strong></p></div>
        <?php elseif(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account') && $customer_license_key_value['key']):?>
            <div>
                <?php _e('Customer License Key', 'microblog-poster');?> : <?php echo $customer_license_key_value['key'];?>
                <?php if($customer_license_key_value['verified']):?><span class="mbp-green">(<?php _e('Valid', 'microblog-poster');?>)</span><?php else:?><span class="mbp-red">(<?php _e('Not Valid', 'microblog-poster');?>)</span><?php endif;?>
                <a href="#" id="mbp_microblogposter_edit_switch" onclick="mbp_microblogposter_edit_license_key();return false;" ><?php _e('Edit', 'microblog-poster');?></a>
            </div>
        <?php endif;?>
            
        <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>    
            <form id="license_key_form" name="license_key_form" method="post" action="">
                <input type="text" id="<?php echo $customer_license_key_name;?>" name="<?php echo $customer_license_key_name;?>" value="<?php echo $customer_license_key_value['key'];?>" size="35" />
                <input type="submit" name="update_license_key" class="button" value="<?php _e('Save License Key', 'microblog-poster');?>" />
            </form>
        <?php endif;?>
        
        
        <div id="mbp-menu-wrapper">
            <ul id="mbp-menu">
                <li id="mbp-general-tab" class="mbp-tab-background mbp-tab-first"><?php _e('General Options', 'microblog-poster');?></li><!--
             --><li id="mbp-accounts-tab" class="mbp-tab-background"><?php _e('Social Networks Accounts', 'microblog-poster');?></li><!--
             --><li id="mbp-old-posts-publish-tab" class="mbp-tab-background"><?php _e('**Auto Publish Old Posts**', 'microblog-poster');?></li><!--                                                                                     
             --><li id="mbp-manual-post-tab" class="mbp-tab-background"><?php _e('Manual Auto Publishing', 'microblog-poster');?></li><!--
             --><li id="mbp-logs-tab" class="mbp-tab-background mbp-tab-last"><?php _e('Logs/History', 'microblog-poster');?></li>
            </ul> 
        </div>
        
        
        <div id="mbp-general-section" class="mbp-single-tab-wrapper">
            <h3 id="general-header"><?php _e('Choose your general options', 'microblog-poster');?> :</h3>
            <form name="options_form" method="post" action="">
                <table class="form-table">
                    <tr>
                        <td colspan="2">
                            <h3><span class="mbp-blue-title"><?php _e('Url Shortener', 'microblog-poster');?> :</span></h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            
                            <h3>
                                <input type="radio" name="<?php echo $url_shortener_name;?>" value="bitly" <?php if($url_shortener_value == 'bitly') echo 'checked';?> />
                                <img src="<?php echo plugins_url('/images/bitly_icon.png', __FILE__);?>" /> : <span class="description"> <a href="http://efficientscripts.com/help/microblogposter/bitlyhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span>
                            </h3>

                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left"><?php _e('Bitly API Username :', 'microblog-poster');?></td>
                        <td>
                            <input type="text" id="<?php echo $bitly_api_user_name;?>" name="<?php echo $bitly_api_user_name;?>" value="<?php echo $bitly_api_user_value;?>" size="35" />
                            <span class="description">(Bitly API Username)</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left"><?php _e('Bitly API Key :', 'microblog-poster');?></td>
                        <td>
                            <input type="text" id="<?php echo $bitly_api_key_name;?>" name="<?php echo $bitly_api_key_name;?>" value="<?php echo $bitly_api_key_value;?>" size="35" />
                            <span class="description">(Bitly API Key)</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left">&nbsp;</td>
                        <td><?php _e('OR', 'microblog-poster');?></td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left"><?php _e('Bitly Access Token :', 'microblog-poster');?></td>
                        <td>
                            <input type="text" id="<?php echo $bitly_access_token_name;?>" name="<?php echo $bitly_access_token_name;?>" value="<?php echo $bitly_access_token_value;?>" size="35" />
                            <span class="description">(Bitly Access Token)</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="padding-top-bottom">
                            <?php _e('The combination of username/API key for authenticating with Bitly is now <span class="mbp-deprecated">deprecated</span> (still works).', 'microblog-poster');?><br /> 
                            <?php _e('Recommended way is the oauth access token only authentication.', 'microblog-poster');?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            
                            <h3>
                                <input type="radio" name="<?php echo $url_shortener_name;?>" value="googl" <?php if($url_shortener_value == 'googl') echo 'checked';?> />
                                <img src="<?php echo plugins_url('/images/googl_icon.png', __FILE__);?>" /> : <span class="description"> <a href="http://efficientscripts.com/help/microblogposter/googlhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span>
                            </h3>

                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left"><?php _e('Goo.gl Client ID :', 'microblog-poster');?></td>
                        <td>
                            <input type="text" id="<?php echo $googl_api_client_id_name;?>" name="<?php echo $googl_api_client_id_name;?>" value="<?php echo $googl_api_client_id_value;?>" size="35" />
                            <span class="description">(Goo.gl Client ID)</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left"><?php _e('Goo.gl Client Secret :', 'microblog-poster');?></td>
                        <td>
                            <input type="text" id="<?php echo $googl_api_client_secret_name;?>" name="<?php echo $googl_api_client_secret_name;?>" value="<?php echo $googl_api_client_secret_value;?>" size="35" />
                            <span class="description">(Goo.gl Client Secret)</span>
                        </td>
                    </tr>
                    <tr>
                        <?php
                            $googl_api_refresh_token_value = get_option($googl_api_refresh_token_name, "");
                            $googl_authorize_url = "https://accounts.google.com/o/oauth2/auth?response_type=code&client_id={$googl_api_client_id_value}&redirect_uri={$redirect_uri}&state=googl_microblogposter_plg&scope=https://www.googleapis.com/auth/urlshortener&access_type=offline";
                        ?>
                        <td colspan="2" class="padding-left padding-top1-bottom authorization">
                            <?php if($googl_api_refresh_token_value && $googl_api_client_id_value && $googl_api_client_secret_value):?>
                            <div>
                                <?php _e('Authorization is valid permanently. Refresh only if you changed Client ID and Client Secret.', 'microblog-poster');?><br />
                                <a href="<?php echo $googl_authorize_url; ?>" ><?php _e('Refresh authorization now', 'microblog-poster');?></a>
                            </div>
                            <?php elseif($googl_api_client_id_value && $googl_api_client_secret_value):?>
                            <div><br /><?php _e('Please authorize before you can shorten urls.', 'microblog-poster');?>&nbsp;<a href="<?php echo $googl_authorize_url; ?>" ><?php _e('Authorize', 'microblog-poster');?></a></div>
                            <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="padding-top-bottom">
                            <?php _e('Please <span class="mbp-deprecated">Save the Client ID and Client Secret first</span> then you can Authorize/Re-Authorize the goo.gl account.', 'microblog-poster');?>
                        </td>
                    </tr>
                    <?php if(!MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Enterprise_Options','handle_manual_post')):?>
                    <tr>
                        <td colspan="2">
                            <h3>
                                <a href="#" id="mbp_microblogposter_additional-shorteners_switch" onclick="mbp_microblogposter_additional_shorteners();return false;" ><?php _e('Show Additional Shorteners...', 'microblog-poster');?></a>
                                
                            </h3>
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td colspan="2">
                            <h3 class="mbp-additional-shorteners-upgrade">
                                <?php _e('Additional Shorteners are only available with the Enterprise Add-on.', 'microblog-poster');?>
                                <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                                <a href="http://efficientscripts.com/login" target="_blank"><?php _e('Upgrade Now', 'microblog-poster');?></a>
                                <?php else:?>
                                <a href="http://efficientscripts.com/microblogposteraddons" target="_blank"><?php _e('Upgrade Now', 'microblog-poster');?></a>
                                <?php endif;?>
                            </h3>
                        </td>
                    </tr>
                    <?php endif;?>
                    <tr class="mbp-additional-shorteners">
                        <td colspan="2">
                            <h3>
                                <input type="radio" name="<?php echo $url_shortener_name;?>" value="adfly" <?php if($url_shortener_value == 'adfly') echo 'checked';?> />
                                <img src="<?php echo plugins_url('/images/adfly_icon.png', __FILE__);?>" /> : <span class="description"> <a href="http://efficientscripts.com/help/microblogposter/adflyhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span>
                            </h3>
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td class="label-input padding-left"><?php _e('Adf.ly Api Key :', 'microblog-poster');?></td>
                        <td>
                            <input type="text" id="<?php echo $adfly_api_key_name;?>" name="<?php echo $adfly_api_key_name;?>" value="<?php echo $adfly_api_key_value;?>" size="35" />
                            <span class="description">(Adf.ly Api Key)</span>
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td class="label-input padding-left"><?php _e('Adf.ly User Id :', 'microblog-poster');?></td>
                        <td>
                            <input type="text" id="<?php echo $adfly_api_user_id_name;?>" name="<?php echo $adfly_api_user_id_name;?>" value="<?php echo $adfly_api_user_id_value;?>" size="35" />
                            <span class="description">(Adf.ly User Id)</span>
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td class="label-input padding-left"><?php _e('Adf.ly Domain :', 'microblog-poster');?></td>
                        <td>
                            <input type="radio" name="<?php echo $adfly_api_domain_name;?>" value="adfly" <?php if($adfly_api_domain_value == 'adfly') echo 'checked';?> />adf.ly <?php _e('(ay.gy will be used for twitter)', 'microblog-poster');?>
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td class="label-input padding-left"></td>
                        <td>
                            <input type="radio" name="<?php echo $adfly_api_domain_name;?>" value="qgs" <?php if($adfly_api_domain_value == 'qgs') echo 'checked';?> />q.gs
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td class="label-input padding-left"></td>
                        <td>
                            <input type="radio" name="<?php echo $adfly_api_domain_name;?>" value="custom" <?php if($adfly_api_domain_value == 'custom') echo 'checked';?> /><?php _e('custom', 'microblog-poster');?> (custom)
                            <input type="text" id="<?php echo $adfly_api_custom_domain_name;?>" name="<?php echo $adfly_api_custom_domain_name;?>" value="<?php echo $adfly_api_custom_domain_value;?>" size="28" />
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td colspan="2" class="padding-top-bottom">
                            <?php _e('<span class="mbp-deprecated">Facebook blocks sharing adf.ly related links.</span>', 'microblog-poster');?>
                            <?php _e('<span class="mbp-deprecated"> Twitter only accepts ay.gy links</span> (auto replacement of adf.ly)', 'microblog-poster');?><br />
                            <?php _e('We don\'t know if the custom domain will work with Facebook or Twitter.', 'microblog-poster');?><br />
                            <?php _e('All the other social sites seem to accept adf.ly related links.', 'microblog-poster');?>
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td colspan="2">
                            <h3>
                                <input type="radio" name="<?php echo $url_shortener_name;?>" value="adfocus" <?php if($url_shortener_value == 'adfocus') echo 'checked';?> />
                                <img src="<?php echo plugins_url('/images/adfocus_icon.png', __FILE__);?>" /> : <span class="description"> <a href="http://efficientscripts.com/help/microblogposter/adfocushelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span>
                            </h3>
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td class="label-input padding-left"><?php _e('Adfoc.us Api Key :', 'microblog-poster');?></td>
                        <td>
                            <input type="text" id="<?php echo $adfocus_api_key_name;?>" name="<?php echo $adfocus_api_key_name;?>" value="<?php echo $adfocus_api_key_value;?>" size="35" />
                            <span class="description">(Adfoc.us Api Key)</span>
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td colspan="2" class="padding-top-bottom">
                            <?php _e('<span class="mbp-deprecated">Facebook blocks sharing adfoc.us related links.</span>', 'microblog-poster');?><br />
                            <?php _e('All the other social sites seem to accept adfoc.us related links.', 'microblog-poster');?>
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td colspan="2">
                            <h3>
                                <input type="radio" name="<?php echo $url_shortener_name;?>" value="ppw" <?php if($url_shortener_value == 'ppw') echo 'checked';?> />
                                <img src="<?php echo plugins_url('/images/ppw_icon.png', __FILE__);?>" /> : <span class="description"> <a href="http://efficientscripts.com/help/microblogposter/ppwhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span>
                            </h3>
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td class="label-input padding-left"><?php _e('P.pw User ID :', 'microblog-poster');?></td>
                        <td>
                            <input type="text" id="<?php echo $ppw_user_id_name;?>" name="<?php echo $ppw_user_id_name;?>" value="<?php echo $ppw_user_id_value;?>" size="35" />
                            <span class="description">(P.pw User ID)</span>
                        </td>
                    </tr>
                    <tr class="mbp-additional-shorteners">
                        <td colspan="2" class="padding-top-bottom">
                            <?php _e('All the social sites seem to accept p.pw related links.', 'microblog-poster');?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="row-sep"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h3><span class="mbp-blue-title"><?php _e('Posts :', 'microblog-poster');?></span></h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="padding-left">
                            <h3><?php _e('Default per NEW POST behavior :', 'microblog-poster');?></h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left1"><?php _e('Don\'t cross-post automatically :', 'microblog-poster');?></td>
                        <td><input type="checkbox" id="microblogposter_default_behavior" name="microblogposter_default_behavior" value="1" <?php if($default_behavior_value) echo 'checked="checked"';?> /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="padding-left">
                            <h3><?php _e('Default per POST UPDATE behavior :', 'microblog-poster');?></h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left1"><?php _e('Don\'t cross-post automatically :', 'microblog-poster');?></td>
                        <td><input type="checkbox" id="microblogposter_default_behavior_update" name="microblogposter_default_behavior_update" value="1" <?php if($default_behavior_update_value) echo 'checked="checked"';?> />&nbsp;&nbsp;<?php _e('(This is most likely to be checked.)', 'microblog-poster');?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="row-sep"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h3><span class="mbp-blue-title"><?php _e('Pages :', 'microblog-poster');?></span></h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input"><?php _e('Enable <span class="microblogposter-name">MicroblogPoster</span> for pages :', 'microblog-poster');?></td>
                        <td><input type="checkbox" id="microblogposter_page_mode" name="microblogposter_page_mode" value="1" <?php if($page_mode_value) echo 'checked="checked"';?> /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="padding-left">
                            <h3><?php _e('Default per NEW PAGE behavior :', 'microblog-poster');?></h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left1"><?php _e('Don\'t cross-post automatically :', 'microblog-poster');?></td>
                        <td><input type="checkbox" id="microblogposter_default_pbehavior" name="microblogposter_default_pbehavior" value="1" <?php if($default_pbehavior_value) echo 'checked="checked"';?> /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="padding-left">
                            <h3><?php _e('Default per PAGE UPDATE behavior :', 'microblog-poster');?></h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left1"><?php _e('Don\'t cross-post automatically :', 'microblog-poster');?></td>
                        <td><input type="checkbox" id="microblogposter_default_pbehavior_update" name="microblogposter_default_pbehavior_update" value="1" <?php if($default_pbehavior_update_value) echo 'checked="checked"';?> />&nbsp;&nbsp;<?php _e('(This is most likely to be checked.)', 'microblog-poster');?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="row-sep"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h3><span class="mbp-blue-title"><?php _e('Custom Post Types :', 'microblog-poster');?></span></h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="mbp-excluded-category-header">
                            <?php _e('Check Custom Post Types for which you want to enable <span class="microblogposter-name">MicroblogPoster</span>.', 'microblog-poster');?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="mbp-excluded-category-td">
                    <?php
                        $args = array(
                            'public' => true,
                            '_builtin' => false
                        );
                        $custom_post_types=get_post_types($args, 'names', 'and');
                        if(is_array($custom_post_types) && !empty($custom_post_types))
                        {
                            foreach ($custom_post_types as $custom_post_type)
                            {
                                microblogposter_display_custom_type($custom_post_type, '<span class="mbp-separator-span"></span>', $enabled_custom_types, $enabled_custom_updates);
                            }
                        }
                        else
                        {
                            ?>
                            <?php _e('Currently, no custom types are active.', 'microblog-poster');?>
                            <?php        
                        }
                    ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="row-sep"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h3><span class="mbp-blue-title"><?php _e('Categories to exclude posts from Cross Posting :', 'microblog-poster');?></span></h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="mbp-excluded-category-header">
                            <?php _e('Check categories for which you want to disable automatically <span class="microblogposter-name">MicroblogPoster</span> from cross-posting.', 'microblog-poster');?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="mbp-excluded-category-td">
                    <?php
                        $args = array(
                            'orderby' => 'name',
                            'parent' => 0,
                            'hide_empty' => 0
                        );
                        $categories = get_categories($args);
                        foreach ($categories as $category)
                        {
                            microblogposter_display_category($category, '<span class="mbp-separator-span"></span>', $excluded_categories);
                        }
                    ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="row-sep"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h3><span class="mbp-blue-title"><?php _e('Shortcodes adjustments :', 'microblog-poster');?></span></h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="mbp-excluded-category-header"><?php _e('Change only if you know what you\'re doing, otherwise default values are just fine.', 'microblog-poster');?></td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left">{TITLE} <?php _e('max length:', 'microblog-poster');?></td>
                        <td><input type="text" id="<?php echo $shortcode_title_max_length_name;?>" name="<?php echo $shortcode_title_max_length_name;?>" value="<?php echo $shortcode_title_max_length_value;?>" size="10" />&nbsp;<?php _e('characters', 'microblog-poster');?>.&nbsp;&nbsp;(<?php _e('default value', 'microblog-poster');?>=110, <?php _e('range between', 'microblog-poster');?> 30 <?php _e('and', 'microblog-poster');?> 120)</td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left">{CONTENT_FIRST_WORDS} <?php _e('length:', 'microblog-poster');?></td>
                        <td><input type="text" id="<?php echo $shortcode_firstwords_max_length_name;?>" name="<?php echo $shortcode_firstwords_max_length_name;?>" value="<?php echo $shortcode_firstwords_max_length_value;?>" size="10" />&nbsp;<?php _e('characters', 'microblog-poster');?>.&nbsp;&nbsp;(<?php _e('default value', 'microblog-poster');?>=90, <?php _e('range between', 'microblog-poster');?> 30 <?php _e('and', 'microblog-poster');?> 120)</td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left">{EXCERPT} <?php _e('length:', 'microblog-poster');?><br /><?php _e('(Used when auto generated)', 'microblog-poster');?></td>
                        <td><input type="text" id="<?php echo $shortcode_excerpt_max_length_name;?>" name="<?php echo $shortcode_excerpt_max_length_name;?>" value="<?php echo $shortcode_excerpt_max_length_value;?>" size="10" />&nbsp;<?php _e('characters', 'microblog-poster');?>.&nbsp;&nbsp;(<?php _e('default value', 'microblog-poster');?>=400, <?php _e('range between', 'microblog-poster');?> 100 <?php _e('and', 'microblog-poster');?> 600)</td>
                    </tr>
                    
                </table>
                <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                <h3 id="pro-addon-header"><?php _e('Pro / Enterprise Add-on Section:', 'microblog-poster');?></h3>
                <table class="form-table">
                    <tr>
                        <td colspan="2">
                            <h3><span class="mbp-blue-title"><?php _e('MicroblogPoster\'s Control Dashboard :', 'microblog-poster');?></span></h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" id="mbp-excluded-category-header">
                            <?php _e('If you\'re posting to your blog by email,', 'microblog-poster');?><br /> 
                            <?php _e('you\'ll need to disable the MicroblogPoster\'s Control Dashboard in order to cross-post successfully.', 'microblog-poster');?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input"><?php _e('Disable the control dashboard:', 'microblog-poster');?></td>
                        <td><input type="checkbox" id="microblogposter_plg_control_dash_mode" name="microblogposter_plg_control_dash_mode" value="1" <?php if($pro_control_dash_mode_value) echo 'checked="checked"';?> /></td>
                    </tr>
                </table>
                <?php endif;?>
                <p class="submit">
                    <input type="submit" name="update_options" class="update-options button-primary" value="<?php _e('Update Options', 'microblog-poster');?>" />
                </p>
            </form>
        </div>
        
        <div id="mbp-social-networks-accounts" class="mbp-single-tab-wrapper">
        <h3 id="network-accounts-header"><?php _e('Configure Your Social Networks Accounts :', 'microblog-poster');?></h3>
        
        <span class="new-account" ><?php _e('Add New Account', 'microblog-poster');?></span>
            
        <?php 
        $update_accounts = array();
        ?>
        
        <div id="social-network-accounts">
        <div class="social-network-accounts-site">
            <img src="<?php echo plugins_url('/images/twitter_icon.png', __FILE__);?>" />
            <h4><?php _e('Twitter Accounts', 'microblog-poster');?></h4>
        </div>
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='twitter'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
        
            $authorized = false;
            $include_featured_image = false;
            if($row->extra)
            {
                $twt_acc_extra = json_decode($row->extra, true);
                if(isset($twt_acc_extra['authorized']) && $twt_acc_extra['authorized']=='1')
                {
                    $authorized = true;
                }
                $include_featured_image = (isset($twt_acc_extra['include_featured_image']) && $twt_acc_extra['include_featured_image'] == 1)?true:false;
            }
            elseif($row->consumer_key && $row->consumer_secret && $row->access_token && $row->access_token_secret)
            {
                $authorized = true;
            }
            
            $authorize_step = 1;
            $authorize_url = $redirect_uri.'&microblogposter_auth_twitter=1&account_id='.$row->account_id;
            $authorize_url_name = 'authorize_url_'.$row->account_id;
            if(isset($$authorize_url_name))
            {
                $authorize_url = $$authorize_url_name;
                $authorize_step = 2;
            }
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        
                        <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                        <div class="delete-wrapper">
                            <?php _e('Twitter Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="twitter-div" class="one-account">
                            <div class="help-div"><span class="description"> Twitter&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/twitterhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                            <div class="input-div">
                                <?php _e('Username:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="username" name="username" value="<?php echo $row->username;?>"/>
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"><?php echo $row->message_format;?></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes_m;?></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div">
                                <?php _e('Include featured image:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="checkbox" id="include_featured_image" name="include_featured_image" value="1" <?php if ($include_featured_image) echo "checked";?>/>
                                <span class="description">
                                    <?php _e('Do you want to include featured image in your updates?', 'microblog-poster');?>
                                    <?php if(!MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                                        <a href="http://efficientscripts.com/microblogposteraddons" target="_blank"><?php _e('Upgrade Now', 'microblog-poster');?></a>
                                    <?php endif;?>  
                                </span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div">
                                <?php _e('Consumer Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="<?php echo $row->consumer_key;?>" />
                                <span class="description">(Application Consumer Key)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Consumer Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="<?php echo $row->consumer_secret;?>" />
                                <span class="description">(Application Consumer Secret)</span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">
                                    <?php _e('The two fields below \'Access Token\' and \'Access Token Secret\' are either generated interactively or you provided them manually.', 'microblog-poster');?>&nbsp;
                                    <?php _e('In any case these two fields are MANDATORY in order to successfully post to twitter.', 'microblog-poster');?>
                                </span>
                            </div>
                            <div class="input-div">
                                <?php _e('Access Token:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="access_token" value="<?php echo $row->access_token;?>" />
                                <span class="description">(Access Token)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Access Token Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="access_token_secret" value="<?php echo $row->access_token_secret;?>" />
                                <span class="description">(Access Token Secret)</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="twitter" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" ><?php _e('Save', 'microblog-poster');?></button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        <?php _e('Twitter Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del"><?php _e('Delete?', 'microblog-poster');?></span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="twitter" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="del-account-fb button-primary del-account<?php echo $row->account_id;?>" ><?php _e('Delete', 'microblog-poster');?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>"><?php _e('Edit', 'microblog-poster');?></span>
                <span class="del-account del<?php echo $row->account_id;?>"><?php _e('Del', 'microblog-poster');?></span>
                <div>
                    <?php if($authorized): ?>
                        <div><?php _e('Authorization is valid permanently', 'microblog-poster');?></div>
                        <a href="<?php echo $authorize_url; ?>" ><?php _e('Refresh authorization now', 'microblog-poster');?></a>
                        <?php _e('(2 steps required)', 'microblog-poster');?>
                    <?php else:?>
                        <a href="<?php echo $authorize_url; ?>" ><?php _e('Authorize this Twitter account', 'microblog-poster');?></a>
                        <?php if($authorize_step==1) _e('(2 steps required)', 'microblog-poster');?>
                        <?php if($authorize_step==2) _e('Final step, click once again.', 'microblog-poster');?>
                    <?php endif;?>
                </div>
            </div>
            
        <?php endforeach;?>
        
        <div class="social-network-accounts-site">
            <img src="<?php echo plugins_url('/images/plurk_icon.png', __FILE__);?>" />
            <h4><?php _e('Plurk Accounts', 'microblog-poster');?></h4>
        </div>
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='plurk'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
            $plurk_qualifier = "says";
            $extra = json_decode($row->extra, true);
            if(is_array($extra))
            {
                if(isset($extra['qualifier']))
                {
                    $plurk_qualifier = $extra['qualifier'];
                }
            }
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                        <div class="delete-wrapper">
                            <?php _e('Plurk Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="plurk-div" class="one-account">
                            <div class="help-div"><span class="description">Plurk&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/plurkhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                            <div class="input-div">
                                <?php _e('Username:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="username" name="username" value="<?php echo $row->username;?>"/>
                            </div>
                            <div class="input-div">
                                <?php _e('Qualifier:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <select name="mbp_plurk_qualifier">
                                    <option value="loves" <?php if($plurk_qualifier=='loves') echo 'selected="selected";'?>>loves</option>
                                    <option value="likes" <?php if($plurk_qualifier=='likes') echo 'selected="selected";'?>>likes</option>
                                    <option value="shares" <?php if($plurk_qualifier=='shares') echo 'selected="selected";'?>>shares</option>
                                    <option value="gives" <?php if($plurk_qualifier=='gives') echo 'selected="selected";'?>>gives</option>
                                    <option value="hates" <?php if($plurk_qualifier=='hates') echo 'selected="selected";'?>>hates</option>
                                    <option value="wants" <?php if($plurk_qualifier=='wants') echo 'selected="selected";'?>>wants</option>
                                    <option value="has" <?php if($plurk_qualifier=='has') echo 'selected="selected";'?>>has</option>
                                    <option value="will" <?php if($plurk_qualifier=='will') echo 'selected="selected";'?>>will</option>
                                    <option value="asks" <?php if($plurk_qualifier=='asks') echo 'selected="selected";'?>>asks</option>
                                    <option value="wishes" <?php if($plurk_qualifier=='wishes') echo 'selected="selected";'?>>wishes</option>
                                    <option value="was" <?php if($plurk_qualifier=='was') echo 'selected="selected";'?>>was</option>
                                    <option value="feels" <?php if($plurk_qualifier=='feels') echo 'selected="selected";'?>>feels</option>
                                    <option value="thinks" <?php if($plurk_qualifier=='thinks') echo 'selected="selected";'?>>thinks</option>
                                    <option value="says" <?php if($plurk_qualifier=='says') echo 'selected="selected";'?>>says</option>
                                    <option value="is" <?php if($plurk_qualifier=='is') echo 'selected="selected";'?>>is</option>
                                    <option value=":" <?php if($plurk_qualifier==':') echo 'selected="selected";'?>>:</option>
                                    <option value="freestyle" <?php if($plurk_qualifier=='freestyle') echo 'selected="selected";'?>>freestyle</option>
                                    <option value="hopes" <?php if($plurk_qualifier=='hopes') echo 'selected="selected";'?>>hopes</option>
                                    <option value="needs" <?php if($plurk_qualifier=='needs') echo 'selected="selected";'?>>needs</option>
                                    <option value="wonders" <?php if($plurk_qualifier=='wonders') echo 'selected="selected";'?>>wonders</option>
                                </select>
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"><?php echo $row->message_format;?></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes_m;?></span>
                            </div>
                            <div class="input-div">
                                <?php _e('Consumer Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="<?php echo $row->consumer_key;?>" />
                                <span class="description">(Application Consumer Key)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Consumer Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="<?php echo $row->consumer_secret;?>" />
                                <span class="description">(Application Consumer Secret)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Access Token:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="access_token" value="<?php echo $row->access_token;?>" />
                                <span class="description">(Access Token)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Access Token Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="access_token_secret" value="<?php echo $row->access_token_secret;?>" />
                                <span class="description">(Access Token Secret)</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="plurk" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" ><?php _e('Save', 'microblog-poster');?></button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        <?php _e('Plurk Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del"><?php _e('Delete?', 'microblog-poster');?></span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="plurk" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="del-account-fb button-primary del-account<?php echo $row->account_id;?>" ><?php _e('Delete', 'microblog-poster');?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>"><?php _e('Edit', 'microblog-poster');?></span>
                <span class="del-account del<?php echo $row->account_id;?>"><?php _e('Del', 'microblog-poster');?></span>
            </div>
            
        <?php endforeach;?>
        
        
        <div class="social-network-accounts-site">
            <img src="<?php echo plugins_url('/images/delicious_icon.png', __FILE__);?>" />
            <h4><?php _e('Delicious Accounts', 'microblog-poster');?></h4>
        </div>  
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='delicious'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
            $is_raw = MicroblogPoster_SupportEnc::is_enc($row->extra);
            $dl_acc_extra = json_decode($row->extra, true);
            if(is_array($dl_acc_extra))
            {
                $include_tags = (isset($dl_acc_extra['include_tags']) && $dl_acc_extra['include_tags'] == 1)?true:false;
            }
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                        <div class="delete-wrapper">
                            <?php _e('Delicious Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="delicious-div" class="one-account">
                            <div class="input-div">
                                <?php _e('Username:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="username" value="<?php echo $row->username;?>" />
                            </div>
                            <div class="input-div">
                                <?php _e('Password:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="password" value="<?php echo ($is_raw)? $row->password : MicroblogPoster_SupportEnc::dec($row->password);?>" />
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"><?php echo $row->message_format;?></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes_bookmark;?></span>
                            </div>
                            <div class="input-div">
                                <?php _e('Include tags:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="checkbox" id="include_tags" name="include_tags" value="1" <?php if ($include_tags) echo "checked";?>/>
                                <span class="description"><?php _e('Do you want to include tags in the bookmarks?', 'microblog-poster');?></span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="delicious" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" ><?php _e('Save', 'microblog-poster');?></button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        <?php _e('Delicious Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del"><?php _e('Delete?', 'microblog-poster');?></span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="delicious" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="del-account-fb button-primary del-account<?php echo $row->account_id;?>" ><?php _e('Delete', 'microblog-poster');?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>"><?php _e('Edit', 'microblog-poster');?></span>
                <span class="del-account del<?php echo $row->account_id;?>"><?php _e('Del', 'microblog-poster');?></span>
            </div>
        <?php endforeach;?>
        
        <div class="social-network-accounts-site">
            <img src="<?php echo plugins_url('/images/facebook_icon.png', __FILE__);?>" />
            <h4><?php _e('Facebook Accounts', 'microblog-poster');?></h4>
        </div>
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='facebook'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
            
            $fb_acc_extra = null;
            $fb_scope = "publish_actions";
            $post_type = "";
            $target_type = "profile";
            $page_id = '';
            $group_id = '';
            if($row->extra)
            {
                $fb_acc_extra = json_decode($row->extra, true);
                $post_type = $fb_acc_extra['post_type'];
                $default_image_url = $fb_acc_extra['default_image_url'];
                if(isset($fb_acc_extra['target_type']))
                {
                    $target_type = $fb_acc_extra['target_type'];
                }
                if(isset($fb_acc_extra['page_id']))
                {
                    $page_id = $fb_acc_extra['page_id'];
                }
                if(isset($fb_acc_extra['group_id']))
                {
                    $group_id = $fb_acc_extra['group_id'];
                }
            }
            
            if($target_type == "page")
            {
                $fb_scope = "publish_actions,publish_pages,manage_pages";
            }
            elseif($target_type == "group")
            {
                $fb_scope = "publish_actions,publish_pages,manage_pages,user_managed_groups";
            }
            $fb_scope = urlencode($fb_scope);
            
            $authorize_url = "http://www.facebook.com/dialog/oauth/?client_id={$row->consumer_key}&redirect_uri={$redirect_uri}&state=microblogposter_{$row->account_id}&scope={$fb_scope}";
            
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        
                        <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                        <div class="delete-wrapper">
                            <?php _e('Facebook Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="facebook-div" class="one-account">
                            <div class="help-div"><span class="description">Facebook&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/facebookhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                            <div class="input-div">
                                <?php _e('Username:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="username" name="username" value="<?php echo $row->username;?>"/>
                            </div>
                            <div class="input-div">
                                <?php _e('Facebook target type:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                
                                <?php if($target_type=='page'):?>
                                    <span class="mbp-facebook-target-type-span"><?php _e('Page timeline', 'microblog-poster');?></span>
                                <?php elseif($target_type=='group'):?>
                                    <span class="mbp-facebook-target-type-span"><?php _e('Group timeline', 'microblog-poster');?></span>
                                <?php else:?>
                                    <span class="mbp-facebook-target-type-span"><?php _e('Profile timeline', 'microblog-poster');?></span>
                                <?php endif;?>
                            </div>
                            <?php if($target_type=='page'):?>
                                <div class="input-div">
                                    <?php _e('Page ID:', 'microblog-poster');?>
                                </div>
                                <div class="input-div-large">
                                    <input type="text" id="mbp_facebook_page_id" name="mbp_facebook_page_id" value="<?php echo $page_id;?>" />
                                    <span class="description"><?php _e('Your Facebook Page ID. (numeric)', 'microblog-poster');?></span>
                                </div>
                            <?php elseif($target_type=='group'):?>
                                <div class="input-div">
                                    <?php _e('Group ID:', 'microblog-poster');?>
                                </div>
                                <div class="input-div-large">
                                    <input type="text" id="mbp_facebook_group_id" name="mbp_facebook_group_id" value="<?php echo $group_id;?>" />
                                    <span class="description"><?php _e('Your Facebook Group ID. (numeric)', 'microblog-poster');?></span>
                                </div>
                            <?php endif;?>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"><?php echo $row->message_format;?></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes;?></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div input-div-radio">
                                <?php _e('Post Type:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="radio" name="post_type_fb" value="text" <?php if($post_type=='text') echo 'checked'; ?>> <?php _e('Text', 'microblog-poster');?> <span class="description"><?php _e('(Text only status update.)', 'microblog-poster');?></span><br>
                                <input type="radio" name="post_type_fb" value="link" <?php if($post_type=='link') echo 'checked'; ?>> <?php _e('Link', 'microblog-poster');?> <span class="description"><?php _e('(Text message + Facebook link box.)', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">
                                    <?php _e('If you choose to post with link box you\'ll need a thumbnail for your link. If your new post contains a featured image, MicroblogPoster will take that one.', 'microblog-poster');?>
                                    <?php _e('If not, no explicit image url will be submitted and facebook will try to fetch appropriate thumbnail for your post. If there is no image, your link will appear without thumbnail.', 'microblog-poster');?>
                                    <?php _e('Otherwise if you don\'t like image/thumbnail facebook is auto fetching then specify a default image url just below. This default thumbnail url will be posted for each new post that doesn\'t have featured image.', 'microblog-poster');?>

                                </span>
                            </div>
                            <div class="input-div">
                                <?php _e('Default Image Url:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="default_image_url" name="default_image_url" value="<?php if(isset($default_image_url)) echo $default_image_url;?>"/>
                                <span class="description"><?php _e('Default Thumbnail for link box.', 'microblog-poster');?> <a href="http://efficientscripts.com/help/microblogposter/generalhelp#def_img_url" target="_blank"><?php _e('Help', 'microblog-poster');?></a></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div">
                                <?php _e('Application ID/API Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="<?php echo $row->consumer_key;?>" />
                                <span class="description">(Application ID / API Key)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Application Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="<?php echo $row->consumer_secret;?>" />
                                <span class="description">(Application Secret)</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="facebook" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" ><?php _e('Save', 'microblog-poster');?></button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        <?php _e('Facebook Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del"><?php _e('Delete?', 'microblog-poster');?></span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="facebook" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="del-account-fb button-primary del-account<?php echo $row->account_id;?>" ><?php _e('Delete', 'microblog-poster');?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>"><?php _e('Edit', 'microblog-poster');?></span>
                <span class="del-account del<?php echo $row->account_id;?>"><?php _e('Del', 'microblog-poster');?></span>
                <?php if(isset($fb_acc_extra['access_token']) && $fb_acc_extra['access_token']):?>
                    <?php if($fb_acc_extra['expires'] == '0'):?>
                        <div><?php _e('Authorization is valid permanently', 'microblog-poster');?></div>
                        <div><a href="<?php echo $authorize_url; ?>" ><?php _e('Re-Authorize this facebook account', 'microblog-poster');?></a></div>
                    <?php else:?>
                        <div><?php _e('Authorization is valid until', 'microblog-poster');?> <?php echo date('d-m-Y', $fb_acc_extra['expires']); ?></div>
                        <div><a href="<?php echo $authorize_url; ?>" ><?php _e('Refresh authorization now', 'microblog-poster');?></a></div>
                    <?php endif;?>
                <?php else:?>
                        <div><a href="<?php echo $authorize_url; ?>" ><?php _e('Authorize this facebook account', 'microblog-poster');?></a></div>
                <?php endif;?>
            </div>
            
        <?php endforeach;?>
            
        <div class="social-network-accounts-site">
            <img src="<?php echo plugins_url('/images/diigo_icon.png', __FILE__);?>" />
            <h4><?php _e('Diigo Accounts', 'microblog-poster');?></h4>
        </div>  
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='diigo'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
            $is_raw = MicroblogPoster_SupportEnc::is_enc($row->extra);
            $extra = json_decode($row->extra, true);
            if(is_array($extra))
            {
                $include_tags = (isset($extra['include_tags']) && $extra['include_tags'] == 1)?true:false;
                $api_key = $extra['api_key'];
            }
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                        <div class="delete-wrapper">
                            <?php _e('Diigo Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="diigo-div" class="one-account">
                            <div class="help-div"><span class="description">Diigo&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/diigohelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                            <div class="input-div">
                                <?php _e('Username:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="username" value="<?php echo $row->username;?>" />
                            </div>
                            <div class="input-div">
                                <?php _e('Password:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="password" value="<?php echo ($is_raw)? $row->password : MicroblogPoster_SupportEnc::dec($row->password);?>" />
                            </div>
                            <div class="input-div">
                                <?php _e('API Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="api_key" value="<?php echo $api_key;?>" />
                                <span class="description">(API Key)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"><?php echo $row->message_format;?></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes_bookmark;?></span>
                            </div>
                            <div class="input-div">
                                <?php _e('Include tags:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="checkbox" id="include_tags" name="include_tags" value="1" <?php if ($include_tags) echo "checked";?>/>
                                <span class="description"><?php _e('Do you want to include tags in the bookmarks?', 'microblog-poster');?></span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="diigo" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" ><?php _e('Save', 'microblog-poster');?></button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        <?php _e('Diigo Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del"><?php _e('Delete?', 'microblog-poster');?></span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="diigo" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="del-account-fb button-primary del-account<?php echo $row->account_id;?>" ><?php _e('Delete', 'microblog-poster');?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>"><?php _e('Edit', 'microblog-poster');?></span>
                <span class="del-account del<?php echo $row->account_id;?>"><?php _e('Del', 'microblog-poster');?></span>
            </div>
        <?php endforeach;?>
            
        <div class="social-network-accounts-site">
            <img src="<?php echo plugins_url('/images/linkedin_icon.png', __FILE__);?>" />
            <h4><?php _e('Linkedin Accounts', 'microblog-poster');?></h4>
        </div>
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='linkedin'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
        
            $linkedin_scope = urlencode("r_basicprofile w_share rw_company_admin");
            $lkn_acc_extra = null;
            $target_type = "profile";
            $group_id = '';
            $company_id = '';
            
            if($row->extra)
            {
                $lkn_acc_extra = json_decode($row->extra, true);
                $post_type = $lkn_acc_extra['post_type'];
                $default_image_url = $lkn_acc_extra['default_image_url'];
                if(isset($lkn_acc_extra['target_type']))
                {
                    $target_type = $lkn_acc_extra['target_type'];
                }
                if(isset($lkn_acc_extra['group_id']))
                {
                    $group_id = $lkn_acc_extra['group_id'];
                }
                if(isset($lkn_acc_extra['company_id']))
                {
                    $company_id = $lkn_acc_extra['company_id'];
                }
            }
            
            $authorize_url = "https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id={$row->consumer_key}&redirect_uri={$redirect_uri}&state=linkedin_microblogposter_{$row->account_id}&scope={$linkedin_scope}";
            
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        
                        <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                        <div class="delete-wrapper">
                            <?php _e('Linkedin Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="facebook-div" class="one-account">
                            <div class="help-div"><span class="description">Linkedin&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/linkedinhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                            <div class="input-div">
                                <?php _e('Username:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="username" name="username" value="<?php echo $row->username;?>"/>
                            </div>
                            <div class="input-div">
                                <?php _e('Linkedin target type:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <?php if($target_type=='company'):?>
                                    <span class="mbp-linkedin-target-type-span"><?php _e('Company timeline', 'microblog-poster');?></span>
                                <?php elseif($target_type=='group'):?>
                                    <span class="mbp-linkedin-target-type-span"><?php _e('Group timeline', 'microblog-poster');?></span>
                                <?php else:?>
                                    <span class="mbp-linkedin-target-type-span"><?php _e('Profile timeline', 'microblog-poster');?></span>
                                <?php endif;?>
                            </div>
                            <?php if($target_type=='group'):?>
                                <div class="input-div">
                                    <?php _e('Group ID:', 'microblog-poster');?>
                                </div>
                                <div class="input-div-large">
                                    <input type="text" id="mbp_linkedin_group_id" name="mbp_linkedin_group_id" value="<?php echo $group_id;?>" />
                                    <span class="description"><?php _e('Your Linkedin Group ID.', 'microblog-poster');?></span>
                                </div>
                            <?php elseif($target_type=='company'):?>
                                <div class="input-div">
                                    <?php _e('Company ID:', 'microblog-poster');?>
                                </div>
                                <div class="input-div-large">
                                    <input type="text" id="mbp_linkedin_company_id" name="mbp_linkedin_company_id" value="<?php echo $company_id;?>" />
                                    <span class="description"><?php _e('Your Linkedin Company ID.', 'microblog-poster');?></span>
                                </div>
                            <?php endif;?>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"><?php echo $row->message_format;?></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes;?></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div input-div-radio">
                                <?php _e('Post Type:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <!--input type="radio" name="post_type_lkn" value="text" <?php if($post_type=='text') echo 'checked'; ?>> Text <span class="description">Text only status update.</span><br-->
                                <input type="radio" name="post_type_lkn" value="link" <?php if($post_type=='link') echo 'checked'; ?>> <?php _e('Link', 'microblog-poster');?> <span class="description"><?php _e('(Text message + Linkedin link box.)', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">
                                    <?php _e('Posting with link box you\'ll need a thumbnail for your link. If your post contains a featured image, MicroblogPoster will take that one.', 'microblog-poster');?>
                                    <?php _e('If not, no explicit image url will be submitted and your update will appear without a thumbnail.', 'microblog-poster');?>
                                    <?php _e('If you want always to have an image going with your link then specify a default image url just below.', 'microblog-poster');?>
                                    <?php _e('This default thumbnail url will be posted for each new post that doesn\'t have featured image.', 'microblog-poster');?>
                                </span>
                            </div>
                            <div class="input-div">
                                <?php _e('Default Image Url:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="default_image_url" name="default_image_url" value="<?php if(isset($default_image_url)) echo $default_image_url;?>"/>
                                <span class="description"><?php _e('Default Thumbnail for link box.', 'microblog-poster');?> <a href="http://efficientscripts.com/help/microblogposter/generalhelp#def_img_url" target="_blank"><?php _e('Help', 'microblog-poster');?></a></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div">
                                <?php _e('Application ID/API Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="<?php echo $row->consumer_key;?>" />
                                <span class="description">(Application ID / API Key)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Application Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="<?php echo $row->consumer_secret;?>" />
                                <span class="description">(Application Secret)</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="linkedin" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" ><?php _e('Save', 'microblog-poster');?></button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        <?php _e('Linkedin Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del"><?php _e('Delete?', 'microblog-poster');?></span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="linkedin" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="del-account-fb button-primary del-account<?php echo $row->account_id;?>" ><?php _e('Delete', 'microblog-poster');?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>"><?php _e('Edit', 'microblog-poster');?></span>
                <span class="del-account del<?php echo $row->account_id;?>"><?php _e('Del', 'microblog-poster');?></span>
                <?php if(isset($lkn_acc_extra['access_token']) && $lkn_acc_extra['access_token']):?>
                <div><?php _e('Authorization is valid until', 'microblog-poster');?> <?php echo date('d-m-Y', $lkn_acc_extra['expires']); ?></div>
                <div><a href="<?php echo $authorize_url; ?>" ><?php _e('Refresh authorization now', 'microblog-poster');?></a></div>
                <?php else:?>
                <div><a href="<?php echo $authorize_url; ?>" ><?php _e('Authorize this linkedin account', 'microblog-poster');?></a></div>
                <?php endif;?>
            </div>
            
        <?php endforeach;?>
            
        <div class="social-network-accounts-site">
            <img src="<?php echo plugins_url('/images/tumblr_icon.png', __FILE__);?>" />
            <h4><?php _e('Tumblr Accounts', 'microblog-poster');?></h4>
        </div>
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='tumblr'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
        
            $authorized = false;
            $tmb_blog_hostname = '';
            if($row->extra)
            {
                $tmb_acc_extra = json_decode($row->extra, true);
                $tmb_post_type = $tmb_acc_extra['post_type'];
                if(isset($tmb_acc_extra['authorized']) && $tmb_acc_extra['authorized']=='1')
                {
                    $authorized = true;
                }
                if(isset($tmb_acc_extra['blog_hostname']))
                {
                    $tmb_blog_hostname = $tmb_acc_extra['blog_hostname'];
                }
            }
            
            $authorize_step = 1;
            $authorize_url = $redirect_uri.'&microblogposter_auth_tumblr=1&account_id='.$row->account_id;
            $authorize_url_name = 'authorize_url_'.$row->account_id;
            if(isset($$authorize_url_name))
            {
                $authorize_url = $$authorize_url_name;
                $authorize_step = 2;
            }
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        
                        <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                        <div class="delete-wrapper">
                            <?php _e('Tumblr Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="tumblr-div" class="one-account">
                            <div class="help-div"><span class="description">Tumblr&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/tumblrhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                            <div class="input-div">
                                <?php _e('Username:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="username" name="username" value="<?php echo $row->username;?>"/>
                                <span class="description"><?php _e('Easily identify it later, not used for posting.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">
                                <?php _e('Blog Hostname:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="mbp_tumblr_blog_hostname" name="mbp_tumblr_blog_hostname" value="<?php echo $tmb_blog_hostname;?>"/>
                                <span class="description"><?php _e('Example:', 'microblog-poster');?> 'blogname.tumblr.com'</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"><?php echo $row->message_format;?></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes;?></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div input-div-radio">
                                <?php _e('Post Type:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="radio" name="mbp_post_type_tmb" value="text" <?php if($tmb_post_type=='text') echo 'checked="checked"';?> > <?php _e('Text', 'microblog-poster');?> <span class="description"><?php _e('(Text status update.)', 'microblog-poster');?></span><br>
                                <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                                <input type="radio" name="mbp_post_type_tmb" value="link" <?php if($tmb_post_type=='link') echo 'checked="checked"';?> > <?php _e('Link', 'microblog-poster');?> <span class="description"><?php _e('Tumblr link box status update.', 'microblog-poster');?></span>
                                <?php endif;?>
                            </div>
                            <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                            <div class="input-div">
                                
                            </div>
                            <div class="input-div-large">
                                <span class="description-small">
                                    <?php _e('Link box + description of your post. Message Format field above isn\'t used.', 'microblog-poster');?>
                                </span>
                            </div>
                            <?php endif;?>
                            <div class="input-div">
                                <?php _e('Consumer Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="<?php echo $row->consumer_key;?>" />
                                <span class="description">(Application Consumer Key)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Consumer Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="<?php echo $row->consumer_secret;?>" />
                                <span class="description">(Application Consumer Secret)</span>
                            </div>
                        </div>

                        <input type="hidden" name="access_token" value="<?php echo $row->access_token;?>" />
                        <input type="hidden" name="access_token_secret" value="<?php echo $row->access_token_secret;?>" />
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="tumblr" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" ><?php _e('Save', 'microblog-poster');?></button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        <?php _e('Tumblr Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del"><?php _e('Delete?', 'microblog-poster');?></span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="tumblr" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="del-account-fb button-primary del-account<?php echo $row->account_id;?>" ><?php _e('Delete', 'microblog-poster');?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>"><?php _e('Edit', 'microblog-poster');?></span>
                <span class="del-account del<?php echo $row->account_id;?>"><?php _e('Del', 'microblog-poster');?></span>
                <div>
                    
                    <?php if($authorized): ?>
                        <div><?php _e('Authorization is valid permanently', 'microblog-poster');?></div>
                        <a href="<?php echo $authorize_url; ?>" ><?php _e('Refresh authorization now', 'microblog-poster');?></a>
                        <?php _e('(2 steps required)', 'microblog-poster');?>
                    <?php else:?>
                        <a href="<?php echo $authorize_url; ?>" ><?php _e('Authorize this Tumblr account', 'microblog-poster');?></a>
                        <?php if($authorize_step==1) _e('(2 steps required)', 'microblog-poster');?>
                        <?php if($authorize_step==2) _e('Final step, click once again.', 'microblog-poster');?>
                    <?php endif;?>
                    
                </div>
            </div>
            
        <?php endforeach;?>
        <div class="social-network-accounts-site">
            <img src="<?php echo plugins_url('/images/blogger_icon.png', __FILE__);?>" />
            <h4><?php _e('Blogger Accounts', 'microblog-poster');?></h4>
        </div>
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='blogger'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
        
            $authorized = false;
            if($row->extra)
            {
                $blogg_acc_extra = json_decode($row->extra, true);
                if(isset($blogg_acc_extra['refresh_token']))
                {
                    $authorized = true;
                }
                if(isset($blogg_acc_extra['blog_id']))
                {
                    $blogg_blog_id = $blogg_acc_extra['blog_id'];
                }
                $include_featured_image = (isset($blogg_acc_extra['include_featured_image']) && $blogg_acc_extra['include_featured_image'] == 1)?true:false;
            }
            
            $authorize_url = "https://accounts.google.com/o/oauth2/auth?response_type=code&client_id={$row->consumer_key}&redirect_uri={$redirect_uri}&state=blogger_microblogposter_{$row->account_id}&scope=http://www.blogger.com/feeds/&access_type=offline";
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        
                        <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                        <div class="delete-wrapper">
                            <?php _e('Blogger Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="blogger-div" class="one-account">
                            <div class="help-div"><span class="description">Blogger/Blogspot&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/bloggerhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                            <div class="input-div">
                                <?php _e('Username:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="username" name="username" value="<?php echo $row->username;?>"/>
                                <span class="description"><?php _e('Easily identify it later, not used for posting.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">
                                <?php _e('Blog Id:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="mbp_blogger_blog_id" name="mbp_blogger_blog_id" value="<?php echo $blogg_blog_id;?>"/>
                                <span class="description"><?php _e('Example:', 'microblog-poster');?> '1237342953579224633'</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"><?php echo $row->message_format;?></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes;?></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div">
                                <?php _e('Include featured image:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="checkbox" id="include_featured_image" name="include_featured_image" value="1" <?php if ($include_featured_image) echo "checked";?>/>
                                <span class="description"><?php _e('Do you want to include featured image in your updates?', 'microblog-poster');?></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div">
                                <?php _e('Client Id:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="<?php echo $row->consumer_key;?>" />
                                <span class="description">(Client Id)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Client Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="<?php echo $row->consumer_secret;?>" />
                                <span class="description">(Client Secret)</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="blogger" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" ><?php _e('Save', 'microblog-poster');?></button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        <?php _e('Blogger Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del"><?php _e('Delete?', 'microblog-poster');?></span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="blogger" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="del-account-fb button-primary del-account<?php echo $row->account_id;?>" ><?php _e('Delete', 'microblog-poster');?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>"><?php _e('Edit', 'microblog-poster');?></span>
                <span class="del-account del<?php echo $row->account_id;?>"><?php _e('Del', 'microblog-poster');?></span>
                <div>
                    
                    <?php if($authorized): ?>
                        <div><?php _e('Authorization is valid permanently', 'microblog-poster');?></div>
                        <a href="<?php echo $authorize_url; ?>" ><?php _e('Refresh authorization now', 'microblog-poster');?></a>
                    <?php else:?>
                        <a href="<?php echo $authorize_url; ?>" ><?php _e('Authorize this Blogger account', 'microblog-poster');?></a>
                    <?php endif;?>
                    
                </div>
            </div>
            
        <?php endforeach;?>
            
        <div class="social-network-accounts-site">
            <img src="<?php echo plugins_url('/images/instapaper_icon.png', __FILE__);?>" />
            <h4><?php _e('Instapaper Accounts', 'microblog-poster');?></h4>
        </div>  
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='instapaper'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
            $is_raw = MicroblogPoster_SupportEnc::is_enc($row->extra);
            $extra = json_decode($row->extra, true);
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                        <div class="delete-wrapper">
                            <?php _e('Instapaper Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="delicious-div" class="one-account">
                            <div class="input-div">
                                <?php _e('Username:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="username" value="<?php echo $row->username;?>" />
                            </div>
                            <div class="input-div">
                                <?php _e('Password:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="password" value="<?php echo ($is_raw)? $row->password : MicroblogPoster_SupportEnc::dec($row->password);?>" />
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"><?php echo $row->message_format;?></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes_bookmark;?></span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="instapaper" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" ><?php _e('Save', 'microblog-poster');?></button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        <?php _e('Instapaper Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del"><?php _e('Delete?', 'microblog-poster');?></span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="instapaper" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="del-account-fb button-primary del-account<?php echo $row->account_id;?>" ><?php _e('Delete', 'microblog-poster');?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>"><?php _e('Edit', 'microblog-poster');?></span>
                <span class="del-account del<?php echo $row->account_id;?>"><?php _e('Del', 'microblog-poster');?></span>
            </div>
        <?php endforeach;?>
            
        <div class="social-network-accounts-site">
            <img src="<?php echo plugins_url('/images/vkontakte_icon.png', __FILE__);?>" />
            <h4><?php _e('VKontakte Accounts', 'microblog-poster');?></h4>
        </div>
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='vkontakte'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
            
            $vk_acc_extra = null;
            $vk_scope = "wall,offline";
            $post_type = "";
            $target_type = "profile";
            $target_id = '';
            
            if($row->extra)
            {
                $vk_acc_extra = json_decode($row->extra, true);
                $post_type = $vk_acc_extra['post_type'];
                if(isset($vk_acc_extra['target_type']))
                {
                    $target_type = $vk_acc_extra['target_type'];
                }
                if(isset($vk_acc_extra['target_id']))
                {
                    $target_id = $vk_acc_extra['target_id'];
                }
            }
            
            $redirect_uri_vk = 'http://api.vkontakte.ru/blank.html';
            $authorize_url = "https://api.vkontakte.ru/oauth/authorize?client_id={$row->consumer_key}&redirect_uri={$redirect_uri_vk}&state=vkontakte_microblogposter_{$row->account_id}&scope={$vk_scope}&response_type=token";
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        
                        <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                        <div class="delete-wrapper">
                            <?php _e('VKontakte Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="vkontakte-div" class="one-account">
                            <div class="help-div"><span class="description">VKontakte&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/vkontaktehelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                            <div class="input-div">
                                <?php _e('Username:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="username" name="username" value="<?php echo $row->username;?>"/>
                            </div>
                            <div class="input-div">
                                <?php _e('VKontakte target type:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                
                                <?php if($target_type=='page'):?>
                                    <span class="mbp-vkontakte-target-type-span"><?php _e('Public Page wall', 'microblog-poster');?></span>
                                <?php elseif($target_type=='group'):?>
                                    <span class="mbp-vkontakte-target-type-span"><?php _e('Group wall', 'microblog-poster');?></span>
                                <?php elseif($target_type=='event'):?>
                                    <span class="mbp-vkontakte-target-type-span"><?php _e('Event wall', 'microblog-poster');?></span>
                                <?php else:?>
                                    <span class="mbp-vkontakte-target-type-span"><?php _e('Profile wall', 'microblog-poster');?></span>
                                <?php endif;?>
                            </div>
                            <div class="input-div">
                                
                                <?php if($target_type=='page'):?>
                                    <?php _e('Page ID', 'microblog-poster');?>
                                <?php elseif($target_type=='group'):?>
                                    <?php _e('Group ID', 'microblog-poster');?>
                                <?php elseif($target_type=='event'):?>
                                    <?php _e('Event ID', 'microblog-poster');?>
                                <?php else:?>
                                    <?php _e('Profile ID', 'microblog-poster');?>
                                <?php endif;?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="mbp_vkontakte_target_id" name="mbp_vkontakte_target_id" value="<?php echo $target_id;?>" />
                                <span class="description"> <?php echo ucfirst($target_type);?> ID. (<?php _e('numeric', 'microblog-poster');?>)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"><?php echo $row->message_format;?></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes;?></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div input-div-radio">
                                <?php _e('Post Type:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="radio" name="post_type_vk" value="text" <?php if($post_type=='text') echo 'checked'; ?>> <?php _e('Text', 'microblog-poster');?> - <span class="description"><?php _e('Text only status update.', 'microblog-poster');?></span><br>
                                <input type="radio" name="post_type_vk" value="link" <?php if($post_type=='link') echo 'checked'; ?>> <?php _e('Link', 'microblog-poster');?> - <span class="description"><?php _e('(Text message + VKontakte link box.)', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">
                                    <?php _e('If you choose to post with link box, VKontakte is auto fetching an image from your post and add it to the link box.', 'microblog-poster');?>
                                </span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div">
                                <?php _e('Application ID/API Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="<?php echo $row->consumer_key;?>" />
                                <span class="description">(Application ID)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Application Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="<?php echo $row->consumer_secret;?>" />
                                <span class="description">(Application Secret)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Access Token:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="access_token_vk" value="<?php echo $vk_acc_extra['access_token'];?>" />
                                <span class="description">(Access Token)</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="vkontakte" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" ><?php _e('Save', 'microblog-poster');?></button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        <?php _e('VKontakte Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del"><?php _e('Delete?', 'microblog-poster');?></span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="vkontakte" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="del-account-fb button-primary del-account<?php echo $row->account_id;?>" ><?php _e('Delete', 'microblog-poster');?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>"><?php _e('Edit', 'microblog-poster');?></span>
                <span class="del-account del<?php echo $row->account_id;?>"><?php _e('Del', 'microblog-poster');?></span>
                <?php if(isset($vk_acc_extra['access_token']) && $vk_acc_extra['access_token']):?>
                    <?php if($vk_acc_extra['expires'] == '0'):?>
                        <div><?php _e('Authorization is valid permanently', 'microblog-poster');?></div>
                        <div><a href="<?php echo $authorize_url; ?>" target="_blank"><?php _e('Re-Authorize this vkontakte account', 'microblog-poster');?></a></div>
                    <?php else:?>
                        <div><?php _e('Authorization is valid until', 'microblog-poster');?> <?php echo date('d-m-Y', $vk_acc_extra['expires']); ?></div>
                        <div><a href="<?php echo $authorize_url; ?>" target="_blank"><?php _e('Refresh authorization now', 'microblog-poster');?></a></div>
                    <?php endif;?>
                <?php else:?>
                        <div><a href="<?php echo $authorize_url; ?>" target="_blank"><?php _e('Authorize this vkontakte account', 'microblog-poster');?></a></div>
                <?php endif;?>
            </div>
            
        <?php endforeach;?>
        
        <div class="social-network-accounts-site">
            <img src="<?php echo plugins_url('/images/xing_icon.png', __FILE__);?>" />
            <h4><?php _e('Xing Accounts', 'microblog-poster');?></h4>
        </div>
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='xing'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
        
            $authorized = false;
            
            if($row->extra)
            {
                $xing_acc_extra = json_decode($row->extra, true);
                $xing_post_type = $xing_acc_extra['post_type'];
                if(isset($xing_acc_extra['authorized']) && $xing_acc_extra['authorized']=='1')
                {
                    $authorized = true;
                }
            }
            
            $authorize_step = 1;
            $authorize_url = $redirect_uri.'&microblogposter_auth_xing=1&account_id='.$row->account_id;
            $authorize_url_name = 'authorize_url_'.$row->account_id;
            if(isset($$authorize_url_name))
            {
                $authorize_url = $$authorize_url_name;
                $authorize_step = 2;
            }
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        
                        <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                        <div class="delete-wrapper">
                            <?php _e('Xing Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="tumblr-div" class="one-account">
                            <div class="help-div"><span class="description">Xing&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/xinghelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                            <div class="input-div">
                                <?php _e('Username:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="username" name="username" value="<?php echo $row->username;?>"/>
                                <span class="description"><?php _e('Easily identify it later, not used for posting.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"><?php echo $row->message_format;?></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes;?></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div input-div-radio">
                                <?php _e('Post Type:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="radio" name="mbp_post_type_xing" value="text" <?php if($xing_post_type=='text') echo 'checked="checked"';?> > <?php _e('Text', 'microblog-poster');?> - <span class="description"><?php _e('(Text status update.)', 'microblog-poster');?></span><br>
                                
                                <input type="radio" name="mbp_post_type_xing" value="link" <?php if($xing_post_type=='link') echo 'checked="checked"';?> > <?php _e('Link', 'microblog-poster');?> - <span class="description"><?php _e('Xing link box status update.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">
                                <?php _e('Consumer Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="<?php echo $row->consumer_key;?>" />
                                <span class="description">(Application Consumer Key)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Consumer Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="<?php echo $row->consumer_secret;?>" />
                                <span class="description">(Application Consumer Secret)</span>
                            </div>
                        </div>

                        <input type="hidden" name="access_token" value="<?php echo $row->access_token;?>" />
                        <input type="hidden" name="access_token_secret" value="<?php echo $row->access_token_secret;?>" />
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="xing" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" ><?php _e('Save', 'microblog-poster');?></button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        <?php _e('Xing Account:', 'microblog-poster');?> <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del"><?php _e('Delete?', 'microblog-poster');?></span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="xing" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                            <button type="button" class="del-account-fb button-primary del-account<?php echo $row->account_id;?>" ><?php _e('Delete', 'microblog-poster');?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>"><?php _e('Edit', 'microblog-poster');?></span>
                <span class="del-account del<?php echo $row->account_id;?>"><?php _e('Del', 'microblog-poster');?></span>
                <div>
                    
                    <?php if($authorized): ?>
                        <div><?php _e('Authorization is valid permanently', 'microblog-poster');?></div>
                        <a href="<?php echo $authorize_url; ?>" ><?php _e('Refresh authorization now', 'microblog-poster');?></a>
                        <?php _e('(2 steps required)', 'microblog-poster');?>
                    <?php else:?>
                        <a href="<?php echo $authorize_url; ?>" ><?php _e('Authorize this Xing account', 'microblog-poster');?></a>
                        <?php if($authorize_step==1) _e('(2 steps required)', 'microblog-poster');?>
                        <?php if($authorize_step==2) _e('Final step, click once again.', 'microblog-poster');?>
                    <?php endif;?>
                    
                </div>
            </div>
            
        <?php endforeach;?> 
        </div><!--end #social-network-accounts -->
        
        
        
        <div style="display:none">
            <div id="new_account">
                <form id="new_account_form" method="post" action="" enctype="multipart/form-data" >

                    <h3 class="new-account-header"><?php _e('<span class="microblogposter-name">MicroblogPoster</span> Plugin', 'microblog-poster');?></h3>
                    <div id="account_type_wrapper">
                    <label for="account_type" class="label-account-type"><?php _e('Account type:', 'microblog-poster');?></label>
                    <select id="account_type" name="account_type">
                        <option value="twitter">Twitter</option>
                        <option value="plurk">Plurk</option>
                        <option value="delicious">Delicious</option>
                        <option value="facebook">Facebook</option>
                        <option value="diigo">Diigo</option>
                        <option value="linkedin">Linkedin</option>
                        <option value="tumblr">Tumblr</option>
                        <option value="blogger">Blogger</option>
                        <option value="instapaper">Instapaper</option>
                        <option value="vkontakte">VKontakte</option>
                        <option value="xing">Xing</option>
                    </select> 
                    </div>


                    <div id="twitter-div" class="one-account">
                        <div class="help-div"><span class="description"> Twitter&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/twitterhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" />
                        </div>
                        <div class="input-div">
                            <?php _e('Message Format:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <textarea id="message_format" name="message_format" rows="2"></textarea>
                            <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small"><?php echo $description_shortcodes_m;?></span>
                        </div>
                        <div class="mbp-separator"></div>
                        <div class="input-div">
                            <?php _e('Include featured image:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="checkbox" id="include_featured_image" name="include_featured_image" value="1" />
                            <span class="description">
                                <?php _e('Do you want to include featured image in your updates?', 'microblog-poster');?>
                                <?php if(!MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                                    <a href="http://efficientscripts.com/microblogposteraddons" target="_blank"><?php _e('Upgrade Now', 'microblog-poster');?></a>
                                <?php endif;?>  
                            </span>
                        </div>
                        <div class="mbp-separator"></div>
                        <div class="input-div">
                            <?php _e('Consumer Key:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_key" value="" />
                            <span class="description">(Application Consumer Key)</span>
                        </div>
                        <div class="input-div">
                            <?php _e('Consumer Secret:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_secret" value="" />
                            <span class="description">(Application Consumer Secret)</span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small">
                                <?php _e('Leave the fields \'Access Token\' and \'Access Token Secret\' below blank if you want to authorize your account interactively.', 'microblog-poster');?>
                                <?php _e('If you provide them, your account will be ready to post immediately and you won\'t have to authorize interactively.', 'microblog-poster');?>
                                <?php _e('Not providing these two fields is meant to allow you posting to multiple twitter accounts with a single twitter App. ', 'microblog-poster');?>
                                <?php _e('You then authorize each account interactively against your App.', 'microblog-poster');?>
                            </span>
                        </div>
                        <div class="input-div">
                            <?php _e('Access Token:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="access_token" value="" />
                            <span class="description"><?php _e('Optional.', 'microblog-poster');?> (Access Token)</span>
                        </div>
                        <div class="input-div">
                            <?php _e('Access Token Secret:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="access_token_secret" value="" />
                            <span class="description"><?php _e('Optional.', 'microblog-poster');?> (Access Token Secret)</span>
                        </div>
                    </div>
                    <div id="plurk-div" class="one-account">
                        <div class="help-div"><span class="description">Plurk&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/plurkhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                        </div>
                        <div class="input-div">
                            <?php _e('Qualifier:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <select name="mbp_plurk_qualifier">
                                <option value="loves">loves</option>
                                <option value="likes">likes</option>
                                <option value="shares">shares</option>
                                <option value="gives">gives</option>
                                <option value="hates">hates</option>
                                <option value="wants">wants</option>
                                <option value="has">has</option>
                                <option value="will">will</option>
                                <option value="asks">asks</option>
                                <option value="wishes">wishes</option>
                                <option value="was">was</option>
                                <option value="feels">feels</option>
                                <option value="thinks">thinks</option>
                                <option value="says" selected="selected">says</option>
                                <option value="is">is</option>
                                <option value=":">:</option>
                                <option value="freestyle">freestyle</option>
                                <option value="hopes">hopes</option>
                                <option value="needs">needs</option>
                                <option value="wonders">wonders</option>
                            </select>
                        </div>
                        <div class="input-div">
                            <?php _e('Message Format:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <textarea id="message_format" name="message_format" rows="2"></textarea>
                            <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small"><?php echo $description_shortcodes_m;?></span>
                        </div>
                        <div class="input-div">
                            <?php _e('Consumer Key:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_key" value="" />
                            <span class="description">(Application Consumer Key)</span>
                        </div>
                        <div class="input-div">
                            <?php _e('Consumer Secret:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_secret" value="" />
                            <span class="description">(Application Consumer Secret)</span>
                        </div>
                        <div class="input-div">
                            <?php _e('Access Token:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="access_token" value="" />
                            <span class="description">(Access Token)</span>
                        </div>
                        <div class="input-div">
                            <?php _e('Access Token Secret:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="access_token_secret" value="" />
                            <span class="description">(Access Token Secret)</span>
                        </div>
                    </div>
                    <div id="friendfeed-div" class="one-account">
                        <div class="help-div"><span class="description">FriendFeed&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/friendfeedhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                        </div>
                        <div class="input-div">
                            <?php _e('Remote Key:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="password" value="" />
                            <span class="description">(Remote Key)</span>
                        </div>
                        <div class="input-div">
                            <?php _e('Message Format:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <textarea id="message_format" name="message_format" rows="2"></textarea>
                            <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small"><?php echo $description_shortcodes_m_ff;?></span>
                        </div>
                    </div>
                    <div id="delicious-div" class="one-account">
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                        </div>
                        <div class="input-div">
                            <?php _e('Password:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="password" value="" />
                        </div>
                        <div class="input-div">
                            <?php _e('Message Format:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <textarea id="message_format" name="message_format" rows="2"></textarea>
                            <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                        </div>
                        <div class="input-div">
                            
                        </div>
                        <div class="input-div-large">
                            <span class="description-small"><?php echo $description_shortcodes_bookmark;?></span>
                        </div>
                        <div class="input-div">
                            <?php _e('Include tags:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="checkbox" id="include_tags" name="include_tags" value="1"/>
                            <span class="description"><?php _e('Do you want to include tags in the bookmarks?', 'microblog-poster');?></span>
                        </div>
                    </div>
                    <div id="facebook-div" class="one-account">
                        <div class="help-div"><span class="description">Facebook&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/facebookhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                            <span class="description"><?php echo $description_mandatory_username;?></span>
                        </div>
                        <div class="input-div">
                            <?php _e('Facebook target type:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <select name="mbp_facebook_target_type" id="mbp_facebook_target_type">
                                <option value="profile"><?php _e('Profile timeline', 'microblog-poster');?></option>
                                <option value="page"><?php _e('Page timeline', 'microblog-poster');?></option>
                                <option value="group"><?php _e('Group timeline', 'microblog-poster');?></option>
                            </select>
                            <span class="description"><?php _e('Where you want to auto post.', 'microblog-poster');?></span>
                        </div>
                        <div id="mbp-facebook-input-div">
                            <div id="mbp-facebook-page-id-div">
                                <div class="input-div">
                                    <?php _e('Page ID:', 'microblog-poster');?>
                                </div>
                                <div class="input-div-large">
                                    <input type="text" id="mbp_facebook_page_id" name="mbp_facebook_page_id" value="" />
                                    <span class="description"><?php _e('Your Facebook Page ID. (numeric)', 'microblog-poster');?></span>
                                </div>
                            </div>
                            <div id="mbp-facebook-group-id-div">
                                <div class="input-div">
                                    <?php _e('Group ID:', 'microblog-poster');?>
                                </div>
                                <div class="input-div-large">
                                    <input type="text" id="mbp_facebook_group_id" name="mbp_facebook_group_id" value="" />
                                    <span class="description"><?php _e('Your Facebook Group ID. (numeric)', 'microblog-poster');?></span>
                                </div>
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes;?></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div input-div-radio">
                                <?php _e('Post Type:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="radio" name="post_type_fb" value="text" checked="checked"> <?php _e('Text', 'microblog-poster');?> <span class="description"><?php _e('(Text only status update.)', 'microblog-poster');?></span><br>
                                <input type="radio" name="post_type_fb" value="link"> <?php _e('Link', 'microblog-poster');?> <span class="description"><?php _e('(Text message + Facebook link box.)', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">
                                    <?php _e('If you choose to post with link box you\'ll need a thumbnail for your link. If your new post contains a featured image, MicroblogPoster will take that one.', 'microblog-poster');?>
                                    <?php _e('If not, no explicit image url will be submitted and facebook will try to fetch appropriate thumbnail for your post. If there is no image, your link will appear without thumbnail.', 'microblog-poster');?>
                                    <?php _e('Otherwise if you don\'t like image/thumbnail facebook is auto fetching then specify a default image url just below. This default thumbnail url will be posted for each new post that doesn\'t have featured image.', 'microblog-poster');?>

                                </span>
                            </div>
                            <div class="input-div">
                                <?php _e('Default Image Url:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="default_image_url" name="default_image_url" />
                                <span class="description"><?php _e('Default Thumbnail for link box.', 'microblog-poster');?> <a href="http://efficientscripts.com/help/microblogposter/generalhelp#def_img_url" target="_blank"><?php _e('Help', 'microblog-poster');?></a></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div">
                                <?php _e('Application ID/API Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="" />
                                <span class="description">(Application ID / API Key)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Application Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="" />
                                <span class="description">(Application Secret)</span>
                            </div>
                        </div>
                        <div id="mbp-facebook-upgrade-now"><?php _e('Available with the Pro / Enterprise Add-on.', 'microblog-poster');?> <a href="http://efficientscripts.com/microblogposteraddons" target="_blank"><?php _e('Upgrade Now', 'microblog-poster');?></a></div>
                    </div>
                    <div id="diigo-div" class="one-account">
                        <div class="help-div"><span class="description">Diigo&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/diigohelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                        </div>
                        <div class="input-div">
                            <?php _e('Password:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="password" value="" />
                        </div>
                        <div class="input-div">
                            <?php _e('API Key:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="api_key" value="" />
                            <span class="description">(API Key)</span>
                        </div>
                        <div class="input-div">
                            <?php _e('Message Format:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <textarea id="message_format" name="message_format" rows="2"></textarea>
                            <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small"><?php echo $description_shortcodes_bookmark;?></span>
                        </div>
                        <div class="input-div">
                            <?php _e('Include tags:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="checkbox" id="include_tags" name="include_tags" value="1"/>
                            <span class="description"><?php _e('Do you want to include tags in the bookmarks?', 'microblog-poster');?></span>
                        </div>
                    </div>
                    <div id="linkedin-div" class="one-account">
                        <div class="help-div"><span class="description">Linkedin&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/linkedinhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                            <span class="description"><?php echo $description_mandatory_username;?></span>
                        </div>
                        <div class="input-div">
                            <?php _e('Linkedin target type:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <select name="mbp_linkedin_target_type" id="mbp_linkedin_target_type">
                                <option value="profile"><?php _e('Profile timeline', 'microblog-poster');?></option>
                                <option value="company"><?php _e('Company timeline', 'microblog-poster');?></option>
                            </select>
                            <span class="description"><?php _e('Where you want to auto post.', 'microblog-poster');?></span>
                        </div>
                        <div id="mbp-linkedin-input-div">
                            <div id="mbp-linkedin-group-id-div">
                                <div class="input-div">
                                    <?php _e('Group ID:', 'microblog-poster');?>
                                </div>
                                <div class="input-div-large">
                                    <input type="text" id="mbp_linkedin_group_id" name="mbp_linkedin_group_id" value="" />
                                    <span class="description"><?php _e('Your Linkedin Group ID.', 'microblog-poster');?></span>
                                </div>
                            </div>
                            <div id="mbp-linkedin-company-id-div">
                                <div class="input-div">
                                    <?php _e('Company ID:', 'microblog-poster');?>
                                </div>
                                <div class="input-div-large">
                                    <input type="text" id="mbp_linkedin_company_id" name="mbp_linkedin_company_id" value="" />
                                    <span class="description"><?php _e('Your Linkedin Company ID.', 'microblog-poster');?></span>
                                </div>
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes;?></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div input-div-radio">
                                <?php _e('Post Type:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <!--input type="radio" name="post_type_lkn" value="text" checked="checked"> Text <span class="description">Text only status update.</span><br-->
                                <input type="radio" name="post_type_lkn" value="link" checked="checked"> <?php _e('Link', 'microblog-poster');?> <span class="description"><?php _e('(Text message + Linkedin link box.)', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">
                                    <?php _e('Posting with link box you\'ll need a thumbnail for your link. If your post contains a featured image, MicroblogPoster will take that one.', 'microblog-poster');?>
                                    <?php _e('If not, no explicit image url will be submitted and your update will appear without a thumbnail.', 'microblog-poster');?>
                                    <?php _e('If you want always to have an image going with your link then specify a default image url just below.', 'microblog-poster');?>
                                    <?php _e('This default thumbnail url will be posted for each new post that doesn\'t have featured image.', 'microblog-poster');?>
                                </span>
                            </div>
                            <div class="input-div">
                                <?php _e('Default Image Url:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="default_image_url" name="default_image_url" />
                                <span class="description"><?php _e('Default Thumbnail for link box.', 'microblog-poster');?> <a href="http://efficientscripts.com/help/microblogposter/generalhelp#def_img_url" target="_blank"><?php _e('Help', 'microblog-poster');?></a></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div">
                                <?php _e('Application ID/API Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="" />
                                <span class="description">(Application ID / API Key)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Application Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="" />
                                <span class="description">(Application Secret)</span>
                            </div>
                        </div>
                        <div id="mbp-linkedin-upgrade-now"><?php _e('Available with the Pro / Enterprise Add-on.', 'microblog-poster');?> <a href="http://efficientscripts.com/microblogposteraddons" target="_blank"><?php _e('Upgrade Now', 'microblog-poster');?></a></div>
                    </div>
                    <div id="tumblr-div" class="one-account">
                        <div class="help-div"><span class="description">Tumblr&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/tumblrhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" />
                            <span class="description"><?php echo $description_mandatory_username;?></span>
                        </div>
                        <div class="input-div">
                            <?php _e('Blog Hostname:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="mbp_tumblr_blog_hostname" name="mbp_tumblr_blog_hostname" />
                            <span class="description"><?php _e('Example:', 'microblog-poster');?> 'blogname.tumblr.com'</span>
                        </div>
                        <div class="input-div">
                            <?php _e('Message Format:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <textarea id="message_format" name="message_format" rows="2"></textarea>
                            <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small"><?php echo $description_shortcodes;?></span>
                        </div>
                        <div class="mbp-separator"></div>
                        <div class="input-div input-div-radio">
                            <?php _e('Post Type:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="radio" class="post_type_tmb_class" name="mbp_post_type_tmb" id="post_type_tmb_text" value="text" checked="checked"> <?php _e('Text', 'microblog-poster');?> <span class="description"><?php _e('(Text status update.)', 'microblog-poster');?></span><br>
                            <input type="radio" class="post_type_tmb_class" name="mbp_post_type_tmb" value="link"> <?php _e('Link', 'microblog-poster');?> <span class="description"><?php _e('Tumblr link box status update.', 'microblog-poster');?></span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small">
                                <?php _e('Link box + description of your post. Message Format field above isn\'t used.', 'microblog-poster');?>
                            </span>
                        </div>
                        <div id="mbp-tumblr-input-div">
                            <div class="input-div">
                                <?php _e('Consumer Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="" />
                                <span class="description">(Application Consumer Key)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Consumer Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="" />
                                <span class="description">(Application Consumer Secret)</span>
                            </div>
                        </div>
                        <div id="mbp-tumblr-upgrade-now"><?php _e('Available with the Pro / Enterprise Add-on.', 'microblog-poster');?> <a href="http://efficientscripts.com/microblogposteraddons" target="_blank"><?php _e('Upgrade Now', 'microblog-poster');?></a></div>
                    </div>
                    <div id="blogger-div" class="one-account">
                        <div class="help-div"><span class="description">Blogger/Blogspot&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/bloggerhelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" />
                            <span class="description"><?php echo $description_mandatory_username;?></span>
                        </div>
                        <div class="input-div">
                            <?php _e('Blog Id:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="mbp_blogger_blog_id" name="mbp_blogger_blog_id" />
                            <span class="description"><?php _e('Example:', 'microblog-poster');?> '1237342953579224633'</span>
                        </div>
                        <div class="input-div">
                            <?php _e('Message Format:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <textarea id="message_format" name="message_format" rows="2"></textarea>
                            <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small"><?php echo $description_shortcodes;?></span>
                        </div>
                        <div class="mbp-separator"></div>
                        <div class="input-div">
                            <?php _e('Include featured image:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="checkbox" id="include_featured_image" name="include_featured_image" value="1" />
                            <span class="description"><?php _e('Do you want to include featured image in your updates?', 'microblog-poster');?></span>
                        </div>
                        <div class="mbp-separator"></div>
                        <div class="input-div">
                            <?php _e('Client Id:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_key" value="" />
                            <span class="description">(Client Id)</span>
                        </div>
                        <div class="input-div">
                            <?php _e('Client Secret:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_secret" value="" />
                            <span class="description">(Client Secret)</span>
                        </div>
                    </div>
                    <div id="instapaper-div" class="one-account">
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                        </div>
                        <div class="input-div">
                            <?php _e('Password:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="password" value="" />
                        </div>
                        <div class="input-div">
                            <?php _e('Message Format:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <textarea id="message_format" name="message_format" rows="2"></textarea>
                            <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small"><?php echo $description_shortcodes_bookmark;?></span>
                        </div>
                    </div>
                    <div id="vkontakte-div" class="one-account">
                        <div class="help-div"><span class="description">VKontakte&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/vkontaktehelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                            <span class="description"><?php echo $description_mandatory_username;?></span>
                        </div>
                        <div class="input-div">
                            <?php _e('VKontakte target type:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <select name="mbp_vkontakte_target_type" id="mbp_vkontakte_target_type">
                                <option value="profile"><?php _e('Profile wall', 'microblog-poster');?></option>
                                <option value="page"><?php _e('Public Page wall', 'microblog-poster');?></option>
                                <option value="group"><?php _e('Group wall', 'microblog-poster');?></option>
                                <option value="event"><?php _e('Event wall', 'microblog-poster');?></option>
                            </select>
                            <span class="description"><?php _e('Where you want to auto post.', 'microblog-poster');?></span>
                        </div>
                        <div id="mbp-vkontakte-input-div">
                            <div class="input-div">
                                <span class="mbp_vkontakte_target_type_string"></span> 
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="mbp_vkontakte_target_id" name="mbp_vkontakte_target_id" value="" />
                                <span class="description"> <span class="mbp_vkontakte_target_type_string"></span>. (<?php _e('numeric', 'microblog-poster');?>)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Message Format:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <textarea id="message_format" name="message_format" rows="2"></textarea>
                                <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small"><?php echo $description_shortcodes;?></span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div input-div-radio">
                                <?php _e('Post Type:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="radio" name="post_type_vk" value="text" checked="checked"> <?php _e('Text', 'microblog-poster');?> - <span class="description"><?php _e('Text only status update.', 'microblog-poster');?></span><br>
                                <input type="radio" name="post_type_vk" value="link"> <?php _e('Link', 'microblog-poster');?> - <span class="description"><?php _e('(Text message + VKontakte link box.)', 'microblog-poster');?></span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">
                                    <?php _e('If you choose to post with link box, VKontakte is auto fetching an image from your post and add it to the link box.', 'microblog-poster');?>
                                </span>
                            </div>
                            <div class="mbp-separator"></div>
                            <div class="input-div">
                                <?php _e('Application ID/API Key:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="" />
                                <span class="description">(Application ID)</span>
                            </div>
                            <div class="input-div">
                                <?php _e('Application Secret:', 'microblog-poster');?>
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="" />
                                <span class="description">(Application Secret)</span>
                            </div>
                        </div>
                        <div id="mbp-vkontakte-upgrade-now"><?php _e('Available with the Pro / Enterprise Add-on.', 'microblog-poster');?> <a href="http://efficientscripts.com/microblogposteraddons" target="_blank"><?php _e('Upgrade Now', 'microblog-poster');?></a></div>
                    </div>
                    <div id="xing-div" class="one-account">
                        <div class="help-div"><span class="description"> Xing&nbsp;:&nbsp;<a href="http://efficientscripts.com/help/microblogposter/xinghelp" target="_blank"><?php _e('Help with screenshots in english', 'microblog-poster');?></a></span></div>
                        <div class="input-div">
                            <?php _e('Username:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" />
                        </div>
                        <div class="input-div">
                            <?php _e('Message Format:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <textarea id="message_format" name="message_format" rows="2"></textarea>
                            <span class="description"><?php _e('Message that\'s actually posted.', 'microblog-poster');?></span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small"><?php echo $description_shortcodes_m;?></span>
                        </div>
                        <div class="mbp-separator"></div>
                        <div class="input-div input-div-radio">
                            <?php _e('Post Type:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="radio" name="post_type_xing" value="text" checked="checked"> <?php _e('Text', 'microblog-poster');?> - <span class="description"><?php _e('Text only status update.', 'microblog-poster');?></span><br>
                            <input type="radio" name="post_type_xing" value="link"> <?php _e('Link', 'microblog-poster');?> - <span class="description"><?php _e('(Text message + Xing link box.)', 'microblog-poster');?></span>
                        </div>
                        <div class="mbp-separator"></div>
                        <div class="input-div">
                            <?php _e('Consumer Key:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_key" value="" />
                            <span class="description">(Application Consumer Key)</span>
                        </div>
                        <div class="input-div">
                            <?php _e('Consumer Secret:', 'microblog-poster');?>
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_secret" value="" />
                            <span class="description">(Application Consumer Secret)</span>
                        </div>
                    </div>

                    <input type="hidden" name="new_account_hidden" value="1" />
                    <div class="button-holder">
                        <button type="button" class="button cancel-account" ><?php _e('Cancel', 'microblog-poster');?></button>
                        <button type="button" class="button-primary save-account" ><?php _e('Save', 'microblog-poster');?></button>
                    </div>

                </form>
            </div>
        </div>
        </div>
    
    
    
    <style>
        .microblogposter-name
        {
            color: #008100;
        }
        .form-table td
        {
            font-size: 10px;
            line-height: 1em;
            padding: 0 0 5px 0;
        }
        .form-table td.label-input
        {
            width: 200px;
        }
        .form-table td.padding-left
        {
            padding-left: 15px;
        }
        .form-table td.padding-left1
        {
            padding-left: 25px;
        }
        .form-table td.padding-top-bottom
        {
            padding-top: 25px;
            padding-bottom: 25px;
        }
        .form-table td.padding-top1-bottom
        {
            padding-top: 10px;
            padding-bottom: 25px;
        }
        .form-table td.row-sep
        {
            padding-bottom: 25px;
        }
        .form-table td.authorization
        {
            font-size: 13px;
        }
        .help-div
        {
            margin-left: 20px;
            margin-bottom: 25px;
        }
        .input-div
        {
            margin-left: 20px;
            margin-bottom: 5px;
            display: inline-block;
            width: 150px;
        }
        .input-div-radio
        {
            vertical-align: top;
        }
        .input-div-large
        {
            margin-bottom: 5px;
            display: inline-block;
            width: 610px;
        }
        .input-div input
        {
            width: 200px;
        }
        .label-account-type
        {
            font-size: 14px;
            margin-left: 10px;
        }
        .new-account-header
        {
            text-align: center;
        }
        #account_type
        {
            width: 150px;
        }
        #account_type_wrapper
        {
            width: 285px;
            height: 30px;
            margin: 0 auto;
            padding-top: 5px;
            background-color: #f2f2f2;
            border-radius: 10px;
        }
        .one-account
        {
            margin-top: 20px;
            background-color: #F3F3F7;
            border-radius: 10px;
            padding-top: 20px;
            padding-bottom: 10px;
        }
        textarea#message_format
        {
            /*resize: none;*/
            width: 290px;
        }
        .button-holder
        {
            width: 180px;
            margin: 30px auto;
        }
        .button-holder-del
        {
            width: 170px;
            margin: 30px auto;
        }
        .edit-account
        {
            padding: 1px 8px;
            background: #0066FF;
            color: #FFFFFF;
            border: 1px solid #0066FF;
            border-radius: 3px;
            cursor: pointer;
        }
        .edit-account:hover
        {
            color: #CCCCCC;
            border-color: #BBBBBB;
        }
        .new-account
        {
            background: #00B800;
            color: #FFFFFF;
            margin-bottom: 20px;
            border-radius: 3px;
            cursor: pointer;
            padding: 3px 10px;
        }
        .new-account:hover
        {
            color: #FFFF00;
            border-color: #BBBBBB;
        }
        .del-account
        {
            padding: 1px 8px;
            background: #FFFFFF;
            color: #FF0000;
            border-radius: 3px;
            border-color: #FF0000;
            border: 1px solid #FF0000;
            cursor: pointer;
        }
        .del-account:hover
        {
            color: #B20000;
            border-color: #FF0000;
        }
        .del-account-fb
        {
            background: #FFFFFF;
            color: #FF0000;
            border-color: #FF0000;
        }
        .del-account-fb:hover
        {
            color: #B20000;
            border-color: #B20000;
        }
        .update-options
        {
            
        }
        .account-wrapper
        {
            width: 350px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #99E399;
        }
        #network-accounts-header
        {
            margin-top: 0px;
            margin-bottom: 20px;
            /*width: 275px;
            border-bottom: 3px solid #99E399;*/
            font-size: 14px;
        }
        #general-header
        {
            margin-top: 0px;
            /*width: 140px;
            border-bottom: 3px solid #99E399;*/
            font-size: 14px;
        }
        #pro-addon-header
        {
            margin-top: 20px;
            /*width: 265px;
            border-bottom: 3px solid #99E399;*/
            font-size: 14px;
        }
        #logs-header
        {
            margin-top: 0px;
            /*width: 120px;
            border-bottom: 3px solid #99E399;*/
            display: inline-block;
            font-size: 14px;
        }
        #manual-post-header
        {
            margin-top: 0px;
            /*width: 465px;
            border-bottom: 3px solid #99E399;
            display: inline-block;*/
            font-size: 14px;
        }
        #old-posts-header
        {
            margin-top: 0px;
            /*width: 450px;
            border-bottom: 3px solid #99E399;
            display: inline-block;*/
            font-size: 14px;
        }
        #social-network-accounts
        {
            margin-top: 35px;
            margin-left: 15px;
        }
        #social-network-accounts .social-network-accounts-site
        {
            margin-bottom: 20px;
            
        }
        #social-network-accounts h4
        {
            background-color: #EBEBEB;
            margin: 0px 0px;
            padding: 3px 5px;
            border-radius: 5px;
            display: inline-block;
            vertical-align: top;
            font-size: 14px;
            width: 330px;
        }
        .delete-wrapper
        {
            text-align: center;
        }
        .delete-wrapper-del
        {
            color: #FF0000;
        }
        .delete-wrapper-user
        {
            color: #0066FF;
        }
        .account-username
        {
            color: #2C2C2C;
            font-weight: bold;
        }
        .description-small
        {
            font-family: sans-serif;
            font-size: 10px;
            font-style: italic;
            color: #666666;
        }
        #mbp-logs-wrapper table
        {
            table-layout:fixed;
            width: 970px;
            border-collapse:collapse;
        }
        #mbp-logs-wrapper table td
        {
            padding: 3px;
            word-wrap: break-word;
            border: 2px solid #E6E6E6;
        }
        .logs-dt
        {
            width: 150px; 
        }
        .logs-username
        {
            width: 200px;
        }
        .logs-message
        {
            width: 500px;
        }
        .logs-post-id
        {
            width: 100px;
        }
        .logs-text-fail
        {
            color: red;
        }
        .logs-text-success
        {
            color: #008100;
        }
        .logs-text-username
        {
            color: #0066FF;
        }
        .logs-text-type
        {
            color: #5200A3;
        }
        .logs-text-type-old
        {
            color: #00008A;
        }
        #mbp-menu-wrapper
        {
            display: inline-block;
            vertical-align: bottom;
            height: 44px;
        }
        #mbp-menu
        {
            list-style: none outside none;
            margin: 25px 0px 0px 0px;
        }
        #mbp-menu li
        {
            display: inline;
            /*margin-right: 1px;*/
            color: #222222;
            padding: 5px 10px;
            font-size: 14px;
            border-top: 1px solid #222222;
            border-right: 1px solid #a8a8a8;
        }
        
        .mbp-tab-background
        {
            background-color: #CCE6CC;
            border-bottom: 2px solid #222222;
        }
        .mbp-tab-background:hover
        {
            background-color: #E6F2E6;
            cursor: pointer;
            border-bottom: none;
        }
        .mbp-selected-tab
        {
            background-color: #FFFFFF;
            border-bottom: none;
        }
        .mbp-tab-first
        {
            border-left: 1px solid #222222;
        }
        #mbp-menu #mbp-logs-tab
        {
            border-right: 1px solid #222222;
        }
        .mbp-warning
        {
            background-color: #FFFFE0;
            border: 1px solid #E6DB55;
            border-radius: 3px;
            margin-bottom: 20px;
        }
        .mbp-warning p
        {
            margin-left: 10px;
        }
        .mbp-blue-title
        {
            color: #21759B;
            font-weight: bold;
        }
        .mbp-separator
        {
            min-height: 10px;
        }
        #mbp-excluded-category-td .mbp-excluded-category
        {
            margin-bottom: 5px;
        }
        #mbp-excluded-category-td .mbp-separator-span
        {
            padding-right: 15px;
        }
        #mbp-excluded-category-header
        {
            padding-bottom: 20px;
        }
        .mbp-deprecated
        {
            color: #ff0000;
        }
        #mbp-facebook-upgrade-now, #mbp-linkedin-upgrade-now, #mbp-tumblr-upgrade-now, #mbp-vkontakte-upgrade-now
        {
            margin: 20px auto 20px auto;
            width: 400px;
        }
        #mbp_facebook_target_type, #mbp_linkedin_target_type, #mbp_vkontakte_target_type
        {
            width: 130px;
        }
        .mbp-facebook-target-type-span, .mbp-linkedin-target-type-span, .mbp-vkontakte-target-type-span
        {
            width: 130px;
            font-weight: bold;
        }
        .mbp-green
        {
            color: green;
        }
        .mbp-red
        {
            color: red;
        }
        .mbp-blue
        {
            color: blue;
        }
        .mbp-single-tab-wrapper
        {
            border-top: 1px solid #888888;
            border-left: 1px solid #888888;
            border-bottom: 1px solid #888888;
            border-right: 1px solid #888888;
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
            border-top-right-radius: 2px;
            padding-top: 40px;
            padding-left: 20px;
        }
        #mbp_empty_logs_form_wrapper
        {
            display: inline-block;
            margin-left: 750px;
            margin-bottom: 20px;
        }
        #mbp-intro
        {
            display: inline-block;
        }
        #mbp-intro .mbp-intro-text
        {
            color: #001A66;
            font-size: 13px;
        }
        .mbp-add-review-link
        {
            color: #001A66;
            font-size: 13px;
        }
        span.mbp-intro-text
        {
            margin-left: 20px;
            margin-right: 5px;
        }
        .mbp_manual_post_link_wrapper
        {
            margin-left: 65px;
        }
        #mbp_manual_post_post_type
        {
            margin-bottom: 10px;
        }
        #mbp_manual_post_dash_head
        {
            margin-left: 20px;
        }
        #mbp_mp_description,#mbp_mp_message
        {
            resize: none;
        }
        .mbp_mp_description_text
        {
            color: #666666;
        }
        #mbp_microblogposter_additional-shorteners_switch
        {
            color: #001a66;
        }
        h3.mbp-additional-shorteners-upgrade
        {
            color: #222222;
        }
        h3.mbp-additional-shorteners-upgrade a
        {
            color: #001a66;
        }
        #mbp-manual-post-wrapper .mbp-manual-post-text
        {
            color: #001A66;
            font-size: 14px;
        }
        #mbp-manual-post-wrapper .mbp-manual-post-text-red
        {
            color: red;
            font-size: 13px;
        }
        #mbp-manual-post-wrapper span.mbp-manual-post-text
        {
            margin-right: 5px;
        }
        #mbp-manual-post-intro
        {
            margin-bottom: 15px;
        }
        #mbp-old-posts-status-area
        {
            margin-left: 85px;
            display: inline-block;
            width: 180px;
        }
        #mbp-old-posts-intro-area
        {
            margin-bottom: 40px;
        } 
    </style>

    <div id="mbp-old-posts-publish-wrapper" class="mbp-single-tab-wrapper">
        <h3 id="old-posts-header"><?php _e('Auto re-publish your old blog posts to social accounts :', 'microblog-poster');?></h3>
        
        <p id="mbp-old-posts-intro-area">
            <?php _e('<span class="microblogposter-name">MicroblogPoster</span> can now auto re-publish your <strong>old blog posts</strong> to social accounts in order to keep them alive.', 'microblog-poster');?><br />
            <?php _e('You need to specify the minimum and maximum of the post age and all posts, published on your blog in between, will be candidates.', 'microblog-poster');?><br />
            <?php _e('This feature utilizes the WP Cron functionality and will be run every x (specify it below) hours.', 'microblog-poster');?><br />
            <br />
            <strong><?php _e('How to activate :', 'microblog-poster');?></strong><br />
            1. <?php _e('Check the \'Activate old posts auto publishing\'.', 'microblog-poster');?><br />
            2. <?php _e('Choose your settings.', 'microblog-poster');?><br />
            3. <?php _e('Select the social accounts you want to be active for old posts re-publishing.', 'microblog-poster');?><br />
            4. <?php _e('Hit Save button.', 'microblog-poster');?><br />
            5. <?php _e('Almost immediately you should see first old post(s) re-published in the Logs/History tab. They are labelled \'Old\'.', 'microblog-poster');?><br /> 
            <?php _e('Next run will occur after approximately x hours.', 'microblog-poster');?><br />
        </p>
        <form id="mbp_old_posts_form" name="mbp_old_posts_form" method="post" action="">
            
            
            <table class="form-table">
                
                
                <tr>
                    <td class="label-input"><span class="mbp-blue-title"><?php _e('Activate old posts auto publishing :', 'microblog-poster');?></span></td>
                    <td>
                        <input type="checkbox" id="<?php echo $microblogposter_plg_old_posts_active_name;?>" name="<?php echo $microblogposter_plg_old_posts_active_name;?>" value="1" <?php if($microblogposter_plg_old_posts_active_value=='1') echo 'checked';?>/>
                        <div id="mbp-old-posts-status-area"><?php _e('Current Status :', 'microblog-poster');?> <?php if($microblogposter_plg_old_posts_active_value=='1') _e( '<strong class=\'mbp-green\'>ACTIVATED</strong>', 'microblog-poster' ); else _e( '<strong class=\'mbp-red\'>DEACTIVATED</strong>', 'microblog-poster' );?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="row-sep"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="mbp-blue-title"><?php _e('General settings :', 'microblog-poster');?></span>
                    </td>
                </tr>
                <tr>
                    <td class="label-input"><?php _e('WP Cron Interval:', 'microblog-poster');?></td>
                    <td><input type="text" id="<?php echo $microblogposter_plg_old_posts_interval_name;?>" name="<?php echo $microblogposter_plg_old_posts_interval_name;?>" value="<?php echo $microblogposter_plg_old_posts_interval_value;?>" size="10"/>&nbsp;<strong><?php _e('hours', 'microblog-poster');?></strong>.&nbsp;&nbsp;(<?php _e('default value', 'microblog-poster');?>=24, <?php _e('range between', 'microblog-poster');?> 1 <?php _e('and reasonably', 'microblog-poster');?> +&infin;)</td>
                </tr>
                <tr>
                    <td class="label-input"><?php _e('Number of posts to auto publish each time:', 'microblog-poster');?></td>
                    <td><input type="text" id="<?php echo $microblogposter_plg_old_posts_nb_posts_name;?>" name="<?php echo $microblogposter_plg_old_posts_nb_posts_name;?>" value="<?php echo $microblogposter_plg_old_posts_nb_posts_value;?>" size="10"/>&nbsp;<strong><?php _e('posts', 'microblog-poster');?></strong>.&nbsp;&nbsp;(<?php _e('default value', 'microblog-poster');?>=1, <?php _e('range between', 'microblog-poster');?> 1 <?php _e('and', 'microblog-poster');?> 3)</td>
                </tr>
                <tr>
                    <td class="label-input"><?php _e('Min age of published post to be eligible. (0 for no min limit):', 'microblog-poster');?></td>
                    <td><input type="text" id="<?php echo $microblogposter_plg_old_posts_min_age_name;?>" name="<?php echo $microblogposter_plg_old_posts_min_age_name;?>" value="<?php echo $microblogposter_plg_old_posts_min_age_value;?>" size="10"/>&nbsp;<strong><?php _e('days', 'microblog-poster');?></strong>.&nbsp;&nbsp;(<?php _e('default value', 'microblog-poster');?>=30, <?php _e('range between', 'microblog-poster');?> 0 <?php _e('and reasonably', 'microblog-poster');?> +&infin;)</td>
                </tr>
                <tr>
                    <td class="label-input"><?php _e('Max age of published post to be eligible. (0 for no max limit):', 'microblog-poster');?></td>
                    <td><input type="text" id="<?php echo $microblogposter_plg_old_posts_max_age_name;?>" name="<?php echo $microblogposter_plg_old_posts_max_age_name;?>" value="<?php echo $microblogposter_plg_old_posts_max_age_value;?>" size="10"/>&nbsp;<strong><?php _e('days', 'microblog-poster');?></strong>.&nbsp;&nbsp;(<?php _e('default value', 'microblog-poster');?>=180, <?php _e('range between', 'microblog-poster');?> 0 <?php _e('and reasonably', 'microblog-poster');?> +&infin;)</td>
                </tr>
                <tr>
                    <td class="label-input"><?php _e('Period after which the re-published old post is eligible again (0 for never):', 'microblog-poster');?></td>
                    <td><input type="text" id="<?php echo $microblogposter_plg_old_posts_expire_age_name;?>" name="<?php echo $microblogposter_plg_old_posts_expire_age_name;?>" value="<?php echo $microblogposter_plg_old_posts_expire_age_value;?>" size="10"/>&nbsp;<strong><?php _e('days', 'microblog-poster');?></strong>.&nbsp;&nbsp;(<?php _e('default value', 'microblog-poster');?>=30, <?php _e('range between', 'microblog-poster');?> 0 <?php _e('and reasonably', 'microblog-poster');?> +&infin;)</td>
                </tr>
                <tr>
                    <td colspan="2" class="row-sep"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="mbp-blue-title"><?php _e('Categories to exclude old posts from Cross Posting:', 'microblog-poster');?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" id="mbp-excluded-category-header"><?php _e('Check categories for which you want to disable old posts auto publishing.', 'microblog-poster');?></td>
                </tr>
                <tr>
                    <td colspan="2" id="mbp-excluded-category-td">
                <?php
                    $args = array(
                        'orderby' => 'name',
                        'parent' => 0,
                        'hide_empty' => 0
                    );
                    $categories = get_categories($args);
                    foreach ($categories as $category)
                    {
                        microblogposter_display_category_old($category, '<span class="mbp-separator-span"></span>', $excluded_categories_old);
                    }
                ?>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <input type="submit" id="microblogposter_plg_old_posts_save" name="microblogposter_plg_old_posts_save" class="button-primary" value="<?php _e('Save', 'microblog-poster');?>" />
            </p>
            
            <div id="mbp_manual_post_dash_head">
                <strong><?php _e('Select the social accounts to update:', 'microblog-poster');?></strong>
            </div>
            <?php microblogposter_show_mini_control_dashboard_old();?>
        </form>
    </div>
    
    <div id="mbp-manual-post-wrapper" class="mbp-single-tab-wrapper">
        
        <?php if(!MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Enterprise_Options','handle_manual_post')):?>
            <div id="mbp-manual-post-intro">
                <span class="mbp-manual-post-text"><?php _e('Sharing manually to your social accounts is available with the Enterprise Add-on', 'microblog-poster');?></span>
                <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                <a class="mbp-manual-post-text" href="http://efficientscripts.com/login" target="_blank"><?php _e('Upgrade Now', 'microblog-poster');?></a>
                <?php else:?>
                <a class="mbp-manual-post-text" href="http://efficientscripts.com/microblogposteraddons" target="_blank"><?php _e('Upgrade Now', 'microblog-poster');?></a>
                <?php endif;?>
            </div>
        <?php elseif(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Enterprise_Options','handle_manual_post') && !$customer_license_key_value['verified']):?>
            <div id="mbp-manual-post-intro">
                <span class="mbp-manual-post-text-red"><?php _e('Please verify your License Key before you can manually auto share.', 'microblog-poster');?></span>
            </div>
        <?php endif;?>
        <h3 id="manual-post-header"><?php _e('Manually auto share to your configured social accounts:', 'microblog-poster');?></h3>
        <p>
            <?php _e('You can share an <strong>url</strong> or a simple <strong>text status update</strong> to all your configured social accounts.', 'microblog-poster');?><br />
            <?php _e('This is totally independent from your blog, by auto sharing you don\'t create any new item in your blog.', 'microblog-poster');?><br />
            <?php _e('Manual auto posting will appear in Logs/History, as usual, only labelled \'Manual\'. ', 'microblog-poster');?> 
        </p>
        <?php
            if(isset($manual_share_completed) && $manual_share_completed === true)
            {
                ?>
                <div class="updated"><p><strong><?php _e('Successfully posted to social accounts.', 'microblog-poster');?></strong></p></div>
                <?php
            }
            elseif(isset($manual_share_completed) && $manual_share_completed === false)
            {
                ?>
                <div class="error"><p><strong><?php _e('Please fill in the required fields.', 'microblog-poster');?></strong></p></div>
                <?php
            }
            elseif(isset($manual_share_completed) && $manual_share_completed == 'License Invalid')
            {
                ?>
                <div class="error"><p><strong><?php _e('Please validate your Customer License Key.', 'microblog-poster');?></strong></p></div>
                <?php
            }
        ?>
        <form id="mbp_manual_post_form" name="mbp_manual_post_form" method="post" action="">
            
            <div id="mbp_manual_post_post_type">
                <strong><?php _e('Post Type:', 'microblog-poster');?></strong>
            </div>
            
            <div>
                <input type="radio" id="mbp_mp_post_type_link" name="mbp_mp_post_type" class="mbp_mp_post_type" value="link" checked />
                <label for="mbp_mp_post_type_link"><span class="mbp-blue"><?php _e('Link', 'microblog-poster');?></span></label>
            </div>
            <div class="mbp_manual_post_link_wrapper">
                <div class="">
                    <?php _e('Title', 'microblog-poster');?> <small>*</small>:
                </div>
                <div class="">
                    <input type="text" id="mbp_mp_title" name="mbp_mp_title" value="" size="65" />
                </div>
                <div class="">
                    <?php _e('Url', 'microblog-poster');?> <small>*</small>:
                </div>
                <div class="">
                    <input type="text" id="mbp_mp_url" name="mbp_mp_url" value="" size="65" />
                </div>
                <div class="">
                    <?php _e('Description', 'microblog-poster');?>:
                </div>
                <div class="">
                    <textarea id="mbp_mp_description" name="mbp_mp_description" rows="4" cols="65"></textarea><br />
                    <span class="mbp_mp_description_text"><?php _e('Optional. Description/Excerpt of the Url, used with Facebook, Linkedin, Tumblr.', 'microblog-poster');?></span>
                </div>
            </div>
            
            
            <div>
                <input type="radio" id="mbp_mp_post_type_text" name="mbp_mp_post_type" class="mbp_mp_post_type" value="text" />
                <label for="mbp_mp_post_type_text"><span class="mbp-blue"><?php _e('Text', 'microblog-poster');?></span></label>
            </div>
            <div class="mbp_manual_post_link_wrapper">
                <div class="">
                    <?php _e('Message', 'microblog-poster');?> <small>*</small>:
                </div>
                <div class="">
                    <textarea id="mbp_mp_message" name="mbp_mp_message" rows="4" cols="65"></textarea><br />
                    <span class="mbp_mp_description_text">
                        <?php _e('Text message as it will be shared. Message formats below aren\'t used for \'text\' type.', 'microblog-poster');?><br />
                        <?php _e('Currently doesn\'t work with Linkedin. And Diigo, Delicious and Instapaper don\'t support sharing text.', 'microblog-poster');?>
                    </span>
                </div>
            </div>

            <p class="submit">
                <input type="submit" id="submit_manual_post" name="submit_manual_post" class="button-primary" value="<?php _e('Share', 'microblog-poster');?>" />
            </p>
            
            <div id="mbp_manual_post_dash_head">
                <strong><?php _e('Select the social accounts to update:', 'microblog-poster');?></strong>
            </div>
            <?php microblogposter_show_mini_control_dashboard();?>

        </form>
    </div>
    
    
    <div id="mbp-logs-wrapper" class="mbp-single-tab-wrapper">
        
        <h3 id="logs-header"><?php _e('Logs Section:', 'microblog-poster');?></h3>
        
        <div id="mbp_empty_logs_form_wrapper">
            <form id="mbp_empty_logs_form" name="mbp_empty_logs_form" method="post" action="">
                <input type="submit" name="empty_logs" class="button-primary" value="<?php _e('Empty Logs', 'microblog-poster');?>" />
            </form>
        </div>
        
        <table>
        <tr>
        <th class="logs-dt"><?php _e('DateTime', 'microblog-poster');?></th>
        <th class="logs-username"><?php _e('Username', 'microblog-poster');?></th>
        <th class="logs-message"><?php _e('Log message', 'microblog-poster');?></th>
        <th class="logs-post-id"><?php _e('Post ID', 'microblog-poster');?></th>
        </tr>
    <?php
        $sql="SELECT * FROM $table_logs ORDER BY log_id DESC LIMIT 200";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $color_class = "";
            if($row->action_result==1)
            {
                $color_class = "logs-text-success";
            }
            elseif($row->action_result==2)
            {
                $color_class = "logs-text-fail";
            }
    ?>
        <tr class="logs-one-row">
        <td class="logs-dt"><?php echo $row->log_datetime; ?></td>
        <td class="logs-username">
            <?php echo $row->username." "; ?><span class="logs-text-username">[<?php echo $row->account_type; ?>]</span>
            <?php if($row->log_type == 'manual'):?><span class="logs-text-type">[<?php _e('Manual', 'microblog-poster');?>]</span><?php endif;?>
            <?php if($row->log_type == 'old'):?><span class="logs-text-type-old">[<?php _e('Old', 'microblog-poster');?>]</span><?php endif;?>
        </td>
        <td class="logs-message"><span class="<?php echo $color_class; ?>"><?php echo htmlentities($row->log_message); ?></span><?php if($row->action_result==1) echo " - ".htmlentities($row->update_message); ?></td>
        <td class="logs-post-id"><?php echo $row->post_id; ?></td>
        </tr>
    <?php endforeach;?>
        
        </table> 
    </div>
    </div><!--end wrap div-->
    
    <?php
        wp_enqueue_script( 'microblogposter-fancybox-js-script' );
        wp_enqueue_style( 'microblogposter-fancybox-css-script' );
    ?>
    <script>
        jQuery(document).ready(function($) {
            // $() will work as an alias for jQuery() inside of this function
            $(".new-account").live("click", function(){
                $.fancybox({
                    'content'       : $('#new_account').html(),
                    'transitionIn'	: 'none',
                    'transitionOut'	: 'none',
                    'autoDimensions': false,
                    'width'		: 850,
                    'height'	: 500,
                    'scrolling'	: 'auto',
                    'titleShow'	: false,
                    'onComplete'	: function() {
                        $('div#fancybox-content #plurk-div,div#fancybox-content #friendfeed-div,div#fancybox-content #delicious-div,div#fancybox-content #facebook-div,div#fancybox-content #diigo-div,div#fancybox-content #linkedin-div,div#fancybox-content #tumblr-div,div#fancybox-content #blogger-div,div#fancybox-content #instapaper-div,div#fancybox-content #vkontakte-div,div#fancybox-content #xing-div').hide().find('input,select,textarea').attr('disabled','disabled');
                        
                        $(".save-account").removeAttr('disabled');
                        
                        $("div#fancybox-content #mbp-facebook-upgrade-now").hide();
                        $("div#fancybox-content #mbp-facebook-page-id-div").hide().find('input').attr('disabled','disabled');
                        $("div#fancybox-content #mbp-facebook-group-id-div").hide().find('input').attr('disabled','disabled');
                        
                        $("div#fancybox-content #mbp-linkedin-upgrade-now").hide();
                        $("div#fancybox-content #mbp-linkedin-group-id-div").hide().find('input').attr('disabled','disabled');
                        $("div#fancybox-content #mbp-linkedin-company-id-div").hide().find('input').attr('disabled','disabled');
                        
                        $("div#fancybox-content #mbp-tumblr-upgrade-now").hide();
                            
                        <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                        
                        <?php else:?>
                            $("div#fancybox-content #twitter-div #include_featured_image").attr('disabled','disabled');
                        <?php endif;?>
                    }
                });
                
            });
            
            $(".cancel-account").live("click", function(){
                $.fancybox.close();
            });
            
            $(".save-account").live("click", function(){
                
                $('div#fancybox-content #new_account_form').submit();
                $.fancybox.close();
                
            });
            
            
            
            $("#account_type").live("change", function(){
                var type = $(this).val();
                //console.log(type);
                $('div#fancybox-content #twitter-div,div#fancybox-content #plurk-div,div#fancybox-content #friendfeed-div,div#fancybox-content #delicious-div,div#fancybox-content #facebook-div,div#fancybox-content #diigo-div,div#fancybox-content #linkedin-div,div#fancybox-content #tumblr-div,div#fancybox-content #blogger-div,div#fancybox-content #instapaper-div,div#fancybox-content #vkontakte-div,div#fancybox-content #xing-div').hide().find('input,select,textarea').attr('disabled','disabled');
                $('div#fancybox-content #'+type+'-div').show().find('input,select,textarea').removeAttr('disabled');
                $(".save-account").removeAttr('disabled');
                if(type=='facebook')
                {
                    var target_type_selected_option = $('div#fancybox-content #mbp_facebook_target_type option:selected');
                    target_type_selected_option.removeAttr('selected');
                    $("div#fancybox-content #mbp-facebook-input-div").show().find('input').removeAttr('disabled');
                    $("div#fancybox-content #mbp-facebook-upgrade-now").hide();
                    $("div#fancybox-content #mbp-facebook-page-id-div").hide().find('input').attr('disabled','disabled');
                    $("div#fancybox-content #mbp-facebook-group-id-div").hide().find('input').attr('disabled','disabled');
                }
                if(type=='linkedin')
                {
                    var target_type_selected_option = $('div#fancybox-content #mbp_linkedin_target_type option:selected');
                    target_type_selected_option.removeAttr('selected');
                    $("div#fancybox-content #mbp-linkedin-input-div").show().find('input').removeAttr('disabled');
                    $("div#fancybox-content #mbp-linkedin-upgrade-now").hide();
                    $("div#fancybox-content #mbp-linkedin-group-id-div").hide().find('input').attr('disabled','disabled');
                    $("div#fancybox-content #mbp-linkedin-company-id-div").hide().find('input').attr('disabled','disabled');
                }
                if(type=='tumblr')
                {
                    var target_type_selected_option = $('div#fancybox-content #tumblr-div input[name=mbp_post_type_tmb]:checked');
                    if(target_type_selected_option.val() == 'link')
                    {
                        target_type_selected_option.removeAttr('checked');
                        $('div#fancybox-content #tumblr-div #post_type_tmb_text').attr('checked','checked');
                        $("div#fancybox-content #mbp-tumblr-input-div").show().find('input').removeAttr('disabled');
                        $("div#fancybox-content #mbp-tumblr-upgrade-now").hide();
                        $(".save-account").removeAttr('disabled');
                    }
                    
                }
                if(type=='vkontakte')
                {
                    var target_type_selected_option = $('div#fancybox-content #mbp_vkontakte_target_type option:selected');
                    target_type_selected_option.removeAttr('selected');
                    $("div#fancybox-content #mbp-vkontakte-input-div").show().find('input').removeAttr('disabled');
                    $("div#fancybox-content #mbp-vkontakte-upgrade-now").hide();
                    $("div#fancybox-content .mbp_vkontakte_target_type_string").html('<?php _e('Profile ID', 'microblog-poster');?>');
                }
                if(type=='twitter')
                {
                    <?php if(!MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                        $("div#fancybox-content #twitter-div #include_featured_image").attr('disabled','disabled');
                    <?php endif;?>  
                }
            });
            
            
            
            $("#mbp_facebook_target_type").live("change", function(){
                var target_type = $(this).val();
                
                <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                    if(target_type == 'page')
                    {
                        $("div#fancybox-content #mbp-facebook-group-id-div").hide().find('input').attr('disabled','disabled');
                        $("div#fancybox-content #mbp-facebook-page-id-div").show().find('input').removeAttr('disabled');
                    }
                    else if(target_type == 'group')
                    {
                        $("div#fancybox-content #mbp-facebook-page-id-div").hide().find('input').attr('disabled','disabled');
                        $("div#fancybox-content #mbp-facebook-group-id-div").show().find('input').removeAttr('disabled');
                    }
                    else if(target_type == 'profile')
                    {
                        $("div#fancybox-content #mbp-facebook-page-id-div").hide().find('input').attr('disabled','disabled');
                        $("div#fancybox-content #mbp-facebook-group-id-div").hide().find('input').attr('disabled','disabled');
                    }     
                <?php else:?>
                    if(target_type == 'page' || target_type == 'group')
                    {
                        $("div#fancybox-content #mbp-facebook-input-div").hide().find('input').attr('disabled','disabled');
                        $("div#fancybox-content #mbp-facebook-upgrade-now").show();
                        $(".save-account").attr('disabled','disabled');
                    }
                    else if(target_type == 'profile')
                    {
                        $("div#fancybox-content #mbp-facebook-input-div").show().find('input').removeAttr('disabled');
                        $("div#fancybox-content #mbp-facebook-upgrade-now").hide();
                        $(".save-account").removeAttr('disabled');
                    }     
                <?php endif;?>
                
                
            });
            
            $("#mbp_linkedin_target_type").live("change", function(){
                var target_type = $(this).val();
                
                <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                    if(target_type == 'group')
                    {
                        $("div#fancybox-content #mbp-linkedin-group-id-div").show().find('input').removeAttr('disabled');
                        $("div#fancybox-content #mbp-linkedin-company-id-div").hide().find('input').attr('disabled','disabled');
                    }
                    else if(target_type == 'company')
                    {
                        $("div#fancybox-content #mbp-linkedin-company-id-div").show().find('input').removeAttr('disabled');
                        $("div#fancybox-content #mbp-linkedin-group-id-div").hide().find('input').attr('disabled','disabled');
                    }
                    else if(target_type == 'profile')
                    {
                        $("div#fancybox-content #mbp-linkedin-group-id-div").hide().find('input').attr('disabled','disabled');
                        $("div#fancybox-content #mbp-linkedin-company-id-div").hide().find('input').attr('disabled','disabled');
                    }
                <?php else:?>
                    if(target_type == 'group' || target_type == 'company')
                    {
                        $("div#fancybox-content #mbp-linkedin-input-div").hide().find('input').attr('disabled','disabled');
                        $("div#fancybox-content #mbp-linkedin-upgrade-now").show();
                        $(".save-account").attr('disabled','disabled');
                    }
                    else if(target_type == 'profile')
                    {
                        $("div#fancybox-content #mbp-linkedin-input-div").show().find('input').removeAttr('disabled');
                        $("div#fancybox-content #mbp-linkedin-upgrade-now").hide();
                        $(".save-account").removeAttr('disabled');
                    }     
                <?php endif;?>
                
                
            });
            
            $(".post_type_tmb_class").live("change", function(){
                var target_type = $(this).val();
                
                <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                        
                <?php else:?>
                    if(target_type == 'link')
                    {
                        $("div#fancybox-content #mbp-tumblr-input-div").hide().find('input').attr('disabled','disabled');
                        $("div#fancybox-content #mbp-tumblr-upgrade-now").show();
                        $(".save-account").attr('disabled','disabled');
                    }
                    else if(target_type == 'text')
                    {
                        $("div#fancybox-content #mbp-tumblr-input-div").show().find('input').removeAttr('disabled');
                        $("div#fancybox-content #mbp-tumblr-upgrade-now").hide();
                        $(".save-account").removeAttr('disabled');
                    }     
                <?php endif;?>
                
                
            });
            
            $("#mbp_vkontakte_target_type").live("change", function(){
                var target_type = $(this).val();
                
                <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                    if(target_type == 'page')
                    {
                        $("div#fancybox-content .mbp_vkontakte_target_type_string").html('<?php _e('Page ID', 'microblog-poster');?>');
                    }
                    else if(target_type == 'group')
                    {
                        $("div#fancybox-content .mbp_vkontakte_target_type_string").html('<?php _e('Group ID', 'microblog-poster');?>');
                    } 
                    else if(target_type == 'event')
                    {
                        $("div#fancybox-content .mbp_vkontakte_target_type_string").html('<?php _e('Event ID', 'microblog-poster');?>');
                    } 
                    else if(target_type == 'profile')
                    {
                        $("div#fancybox-content .mbp_vkontakte_target_type_string").html('<?php _e('Profile ID', 'microblog-poster');?>');
                    } 
                <?php else:?>
                    if(target_type == 'page' || target_type == 'group' || target_type == 'event')
                    {
                        $("div#fancybox-content #mbp-vkontakte-input-div").hide().find('input').attr('disabled','disabled');
                        $("div#fancybox-content #mbp-vkontakte-upgrade-now").show();
                        $(".save-account").attr('disabled','disabled');
                    }
                    else if(target_type == 'profile')
                    {
                        $("div#fancybox-content #mbp-vkontakte-input-div").show().find('input').removeAttr('disabled');
                        $("div#fancybox-content #mbp-vkontakte-upgrade-now").hide();
                        $(".save-account").removeAttr('disabled');
                    }     
                <?php endif;?>
                
                
            });
            
            
            <?php foreach($update_accounts as $account_id):?>
                $(".edit<?php echo $account_id;?>").live("click", function(){
                    $.fancybox({
                        'content'       : $('#update_account<?php echo $account_id;?>').html(),
                        'transitionIn'	: 'none',
                        'transitionOut'	: 'none',
                        'autoDimensions': false,
                        'width'		: 850,
                        'height'	: 500,
                        'scrolling'	: 'auto',
                        'titleShow'	: false,
                        'onComplete'	: function() {
                            
                            <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account')):?>
                        
                            <?php else:?>
                                $("div#fancybox-content #twitter-div #include_featured_image").attr('disabled','disabled');
                            <?php endif;?>
                        }
                    });
                });
                $(".save-account<?php echo $account_id;?>").live("click", function(){

                    $('div#fancybox-content #update_account_form<?php echo $account_id;?>').submit();
                    $.fancybox.close();
                    
                });
                
                $(".del<?php echo $account_id;?>").live("click", function(){
                    $.fancybox({
                        'content'       : $('#delete_account<?php echo $account_id;?>').html(),
                        'transitionIn'	: 'none',
                        'transitionOut'	: 'none',
                        'autoDimensions': false,
                        'width'		: 400,
                        'height'	: 120,
                        'scrolling'	: 'no',
                        'titleShow'	: false
                    });
                });
                $(".del-account<?php echo $account_id;?>").live("click", function(){

                    $('div#fancybox-content #delete_account_form<?php echo $account_id;?>').submit();
                    $.fancybox.close();
                });
            <?php endforeach;?>
            
            <?php if($mbp_accounts_tab_selected):?>
                $('#mbp-general-section').hide();
                $('#mbp-logs-wrapper').hide();
                $('#mbp-manual-post-wrapper').hide();
                $('#mbp-old-posts-publish-wrapper').hide();
                $("#mbp-accounts-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            <?php elseif($mbp_logs_tab_selected):?>
                $('#mbp-social-networks-accounts').hide();
                $('#mbp-general-section').hide();
                $('#mbp-manual-post-wrapper').hide();
                $('#mbp-old-posts-publish-wrapper').hide();
                $("#mbp-logs-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            <?php elseif($mbp_manual_share_tab_selected):?>
                $('#mbp-social-networks-accounts').hide();
                $('#mbp-general-section').hide();
                $('#mbp-logs-wrapper').hide();
                $('#mbp-old-posts-publish-wrapper').hide();
                $("#mbp-manual-post-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            <?php elseif($mbp_old_posts_tab_selected):?>
                $('#mbp-social-networks-accounts').hide();
                $('#mbp-general-section').hide();
                $('#mbp-logs-wrapper').hide();
                $('#mbp-old-posts-publish-tab').addClass('mbp-selected-tab').removeClass('mbp-tab-background');
                $('#mbp-manual-post-wrapper').hide();
            <?php else:?>
                $('#mbp-social-networks-accounts').hide();
                $('#mbp-logs-wrapper').hide();
                $('#mbp-manual-post-wrapper').hide();
                $('#mbp-old-posts-publish-wrapper').hide();
                $("#mbp-general-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            <?php endif;?>
            
            
            $("#mbp-general-tab").live("click", function(){
                $('#mbp-social-networks-accounts').hide();
                $('#mbp-logs-wrapper').hide();
                $('#mbp-manual-post-wrapper').hide();
                $('#mbp-old-posts-publish-wrapper').hide();
                $('#mbp-general-section').show();
                
                $("#mbp-accounts-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-logs-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-old-posts-publish-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-manual-post-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-general-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            });
            $("#mbp-accounts-tab").live("click", function(){
                $('#mbp-logs-wrapper').hide();
                $('#mbp-manual-post-wrapper').hide();
                $('#mbp-general-section').hide();
                $('#mbp-old-posts-publish-wrapper').hide();
                $('#mbp-social-networks-accounts').show();
                
                $("#mbp-logs-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-manual-post-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-general-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-old-posts-publish-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-accounts-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            });
            $("#mbp-old-posts-publish-tab").live("click", function(){
                $('#mbp-logs-wrapper').hide();
                $('#mbp-manual-post-wrapper').hide();
                $('#mbp-general-section').hide();
                $('#mbp-social-networks-accounts').hide();
                $('#mbp-old-posts-publish-wrapper').show();
                
                $("#mbp-logs-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-manual-post-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-general-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-accounts-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-old-posts-publish-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            });
            $("#mbp-manual-post-tab").live("click", function(){
                $('#mbp-logs-wrapper').hide();
                $('#mbp-general-section').hide();
                $('#mbp-social-networks-accounts').hide();
                $('#mbp-old-posts-publish-wrapper').hide();
                $('#mbp-manual-post-wrapper').show();
                
                $("#mbp-logs-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-general-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-accounts-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-old-posts-publish-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-manual-post-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            });
            $("#mbp-logs-tab").live("click", function(){
                $('#mbp-social-networks-accounts').hide();
                $('#mbp-general-section').hide();
                $('#mbp-manual-post-wrapper').hide();
                $('#mbp-old-posts-publish-wrapper').hide();
                $('#mbp-logs-wrapper').show();
                
                $("#mbp-accounts-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-general-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-manual-post-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-old-posts-publish-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-logs-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            });
            
            <?php if(!$page_mode_value):?>
                $('#microblogposter_default_pbehavior').attr('disabled','disabled');
                $('#microblogposter_default_pbehavior_update').attr('disabled','disabled');
            <?php endif;?>
                
            $("#microblogposter_page_mode").live("click", function(){
                if($(this).is(':checked'))
                {
                    $('#microblogposter_default_pbehavior').removeAttr('disabled');
                    $('#microblogposter_default_pbehavior_update').removeAttr('disabled');
                }
                else
                {
                    $('#microblogposter_default_pbehavior').attr('disabled','disabled');
                    $('#microblogposter_default_pbehavior_update').attr('disabled','disabled');
                }
            });
            
            $('#mbp_empty_logs_form').submit(function() {
                return confirm("<?php _e('Delete permanently all your logs?', 'microblog-poster');?>");
            });
            
            <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Pro','filter_single_account') && $customer_license_key_value['key']):?>
                $("#license_key_form").hide().find('input').attr('disabled','disabled');
            <?php endif;?>  
            
            
            <?php if($redirect_after_auth):?>
                window.location = "<?php echo $redirect_uri.'&t=2';?>";
            <?php endif;?>
                
            <?php if($redirect_after_auth1):?>
                window.location = "<?php echo $redirect_uri;?>";
            <?php endif;?>
                
            <?php if(!MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Enterprise_Options','handle_manual_post') || (MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Enterprise_Options','handle_manual_post') && !$customer_license_key_value['verified'])):?>
                $('#submit_manual_post').attr('disabled','disabled');
                $('#mbp_mp_title').attr('disabled','disabled');
                $('#mbp_mp_url').attr('disabled','disabled');
                $('#mbp_mp_description').attr('disabled','disabled');
                $('#mbp_mp_message').attr('disabled','disabled');
                $('.mbp_mp_post_type').attr('disabled','disabled');
                $('.mbp_social_account_microblogposter_msgc').attr('disabled','disabled');
                $('.mbp_social_account_microblogposter_boxc').attr('disabled','disabled');
                
                $(".mbp-additional-shorteners").hide().find('input').attr('disabled','disabled');
            <?php endif;?>
                
            <?php if( in_array(get_locale(), array('de_DE', 'de_CH')) ):?>
                $('#mbp-menu-wrapper #mbp-menu li').css({ "font-size": "13px"});
            <?php endif;?>
        });
        
        function mbp_microblogposter_edit_license_key()
        {
            if(jQuery("#license_key_form").is(':visible'))
            {
                jQuery("#license_key_form").hide().find('input').attr('disabled','disabled');
                jQuery("#mbp_microblogposter_edit_switch").html('<?php _e('Edit', 'microblog-poster');?>');
            }
            else
            {
                jQuery("#license_key_form").show().find('input').removeAttr('disabled');
                jQuery("#mbp_microblogposter_edit_switch").html('<?php _e('Hide', 'microblog-poster');?>');
            }    
            
            
        }
        
        function mbp_social_accounts_microblogposter_uncheck_all(type)
        {
            <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Enterprise_Options','handle_manual_post') && $customer_license_key_value['verified']):?>
            if(!jQuery('#microblogposteroff').is(':checked'))
            {
                jQuery('.mbp_social_account_microblogposter_'+type).removeAttr('checked');
            }
            <?php endif;?>
            
        }
        function mbp_social_accounts_microblogposter_check_all(type)
        {
            <?php if(MicroblogPoster_Poster::is_method_callable('MicroblogPoster_Poster_Enterprise_Options','handle_manual_post') && $customer_license_key_value['verified']):?>
            if(!jQuery('#microblogposteroff').is(':checked'))
            {
                jQuery('.mbp_social_account_microblogposter_'+type).attr('checked','checked');
            }
            <?php endif;?>
        }
        function mbp_social_accounts_microblogposter_uncheck_all_old(type)
        {
            jQuery('.mbp_social_account_microblogposter_old_'+type).removeAttr('checked');
        }
        function mbp_social_accounts_microblogposter_check_all_old(type)
        {
            jQuery('.mbp_social_account_microblogposter_old_'+type).attr('checked','checked');
        }
        function mbp_microblogposter_additional_shorteners()
        {
            if(jQuery(".mbp-additional-shorteners").is(':visible'))
            {
                jQuery(".mbp-additional-shorteners").hide().find('input').attr('disabled','disabled');
                jQuery("#mbp_microblogposter_additional-shorteners_switch").html('<?php _e('Show Additional Shorteners...', 'microblog-poster');?>');
            }
            else
            {
                jQuery(".mbp-additional-shorteners").show()//.find('input').removeAttr('disabled');
                jQuery("#mbp_microblogposter_additional-shorteners_switch").html('<?php _e('Hide Additional Shorteners', 'microblog-poster');?>');
            }    
        }

    </script>
    
    <?php
    
}

function microblogposter_display_category($category, $sep, $excluded_categories)
{
    
    ?>
    <?php echo $sep;?><input type="checkbox" class="mbp-excluded-category" id="microblogposter_category_<?php echo $category->term_id;?>" name="microblogposter_excluded_categories[]" value="<?php echo $category->term_id;?>" <?php if(in_array($category->term_id, $excluded_categories)) echo 'checked="checked"';?> /> <label for="microblogposter_category_<?php echo $category->term_id;?>" ><?php echo $category->name;?></label> <br/>
    <?php
    
    $categories1 = get_categories(array('parent' => $category->term_id, 'hide_empty' => 0));
    if($categories1)
    {
        foreach($categories1 as $category1)
        {
            microblogposter_display_category($category1, $sep.'<span class="mbp-separator-span"></span>', $excluded_categories);
        }
    }
}

function microblogposter_display_category_old($category, $sep, $excluded_categories)
{
    
    ?>
    <?php echo $sep;?><input type="checkbox" class="mbp-excluded-category" id="microblogposter_category_old_<?php echo $category->term_id;?>" name="microblogposter_excluded_categories_old[]" value="<?php echo $category->term_id;?>" <?php if(in_array($category->term_id, $excluded_categories)) echo 'checked="checked"';?> /> <label for="microblogposter_category_old_<?php echo $category->term_id;?>" ><?php echo $category->name;?></label> <br/>
    <?php
    
    $categories1 = get_categories(array('parent' => $category->term_id, 'hide_empty' => 0));
    if($categories1)
    {
        foreach($categories1 as $category1)
        {
            microblogposter_display_category_old($category1, $sep.'<span class="mbp-separator-span"></span>', $excluded_categories);
        }
    }
}

function microblogposter_display_custom_type($custom_type, $sep, $enabled_custom_types, $enabled_custom_updates)
{
    
    ?>
    <?php echo $sep;?>
    <input type="checkbox" class="mbp-excluded-category" id="microblogposter_enabled_custom_types_<?php echo $custom_type;?>" name="microblogposter_enabled_custom_types[]" value="<?php echo $custom_type;?>" <?php if(in_array($custom_type, $enabled_custom_types)) echo 'checked="checked"';?> /> 
    <label for="microblogposter_enabled_custom_types_<?php echo $custom_type;?>" ><?php echo $custom_type;?></label> 
    &nbsp;&nbsp;-&nbsp;&nbsp;<?php _e('Don\'t cross-post automatically on Update', 'microblog-poster');?>&nbsp;<input type="checkbox" class="mbp-excluded-category" id="microblogposter_enabled_custom_updates_<?php echo $custom_type;?>" name="microblogposter_enabled_custom_updates[]" value="<?php echo $custom_type;?>" <?php if(in_array($custom_type, $enabled_custom_updates)) echo 'checked="checked"';?> /> 
    &nbsp;(<?php _e('This is most likely to be checked.', 'microblog-poster');?>)<br/>
    <?php
    
}

/**
* Shows the MicroblogPoster's control dashboard
*
* @return string (html)
*/
function microblogposter_show_mini_control_dashboard()
{
    ?>
    <br />
    <style>
        .mbp_social-network-accounts-site
        {
            margin-top: 10px;
            margin-left: 20px;
            width: 100%;
        }
        .mbp_social-network-accounts-site h4
        {
            background-color: #EBEBEB;
            margin: 0px 0px;
            padding: 3px 5px;
            border-radius: 5px;
            display: inline-block;
            vertical-align: top;
            font-size: 14px;
            width: 90%;
        }
        .mbp_social-network-accounts-site a
        {
            font-size: 10px;
        }
        .mbp_social-network-accounts-site div
        {
            margin-left: 250px;
        }
        .mbp_social-network-accounts-site div span.description-small
        {
            margin-left: 5px;
        }
        .mbp_social-network-accounts-accounts
        {
            margin-left: 45px;
        }
        .mbp_social_account_microblogposter_msgc
        {
            width: 290px;
            /*resize: none;*/
        }
    </style>

    <input type="hidden" name="mbp_control_dashboard_microblogposter" value="1" /> 
    <?php 
        $twitter_accounts = MicroblogPoster_Poster::get_accounts_object('twitter');
        if(!empty($twitter_accounts)):
            microblogposter_show_common_account_dashboard_head('twitter');
            foreach($twitter_accounts as $twitter_account):
                microblogposter_show_common_account_dashboard($twitter_account, 'twitter');
    ?>

    <?php
            endforeach;
        endif;
    ?>


    <?php 
        $plurk_accounts = MicroblogPoster_Poster::get_accounts_object('plurk');
        if(!empty($plurk_accounts)):
            microblogposter_show_common_account_dashboard_head('plurk');
            foreach($plurk_accounts as $plurk_account):
                microblogposter_show_common_account_dashboard($plurk_account, 'plurk');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $friendfeed_accounts = MicroblogPoster_Poster::get_accounts_object('friendfeed');
        if(!empty($friendfeed_accounts)):
            microblogposter_show_common_account_dashboard_head('friendfeed'); 
            foreach($friendfeed_accounts as $friendfeed_account):
                microblogposter_show_common_account_dashboard($friendfeed_account, 'friendfeed');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $delicious_accounts = MicroblogPoster_Poster::get_accounts_object('delicious');
        if(!empty($delicious_accounts)):
            microblogposter_show_common_account_dashboard_head('delicious'); 
            foreach($delicious_accounts as $delicious_account):
                microblogposter_show_common_account_dashboard($delicious_account, 'delicious');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $facebook_accounts = MicroblogPoster_Poster::get_accounts_object('facebook');
        if(!empty($facebook_accounts)):
            microblogposter_show_common_account_dashboard_head('facebook'); 
            foreach($facebook_accounts as $facebook_account):
                microblogposter_show_common_account_dashboard($facebook_account, 'facebook');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $diigo_accounts = MicroblogPoster_Poster::get_accounts_object('diigo');
        if(!empty($diigo_accounts)):
            microblogposter_show_common_account_dashboard_head('diigo'); 
            foreach($diigo_accounts as $diigo_account):
                microblogposter_show_common_account_dashboard($diigo_account, 'diigo');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $linkedin_accounts = MicroblogPoster_Poster::get_accounts_object('linkedin');
        if(!empty($linkedin_accounts)):
            microblogposter_show_common_account_dashboard_head('linkedin'); 
            foreach($linkedin_accounts as $linkedin_account):
                microblogposter_show_common_account_dashboard($linkedin_account, 'linkedin');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $tumblr_accounts = MicroblogPoster_Poster::get_accounts_object('tumblr');
        if(!empty($tumblr_accounts)):
            microblogposter_show_common_account_dashboard_head('tumblr'); 
            foreach($tumblr_accounts as $tumblr_account):
                microblogposter_show_common_account_dashboard($tumblr_account, 'tumblr');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $blogger_accounts = MicroblogPoster_Poster::get_accounts_object('blogger');
        if(!empty($blogger_accounts)):
            microblogposter_show_common_account_dashboard_head('blogger'); 
            foreach($blogger_accounts as $blogger_account):
                microblogposter_show_common_account_dashboard($blogger_account, 'blogger');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $instapaper_accounts = MicroblogPoster_Poster::get_accounts_object('instapaper');
        if(!empty($instapaper_accounts)):
            microblogposter_show_common_account_dashboard_head('instapaper'); 
            foreach($instapaper_accounts as $instapaper_account):
                microblogposter_show_common_account_dashboard($instapaper_account, 'instapaper');
    ?>

    <?php
            endforeach;
        endif;
    ?>
    
    <?php 
        $vkontakte_accounts = MicroblogPoster_Poster::get_accounts_object('vkontakte');
        if(!empty($vkontakte_accounts)):
            microblogposter_show_common_account_dashboard_head('vkontakte'); 
            foreach($vkontakte_accounts as $vkontakte_account):
                microblogposter_show_common_account_dashboard($vkontakte_account, 'vkontakte');
    ?>

    <?php
            endforeach;
        endif;
    ?>
    
    <?php 
        $xing_accounts = MicroblogPoster_Poster::get_accounts_object('xing');
        if(!empty($xing_accounts)):
            microblogposter_show_common_account_dashboard_head('xing'); 
            foreach($xing_accounts as $xing_account):
                microblogposter_show_common_account_dashboard($xing_account, 'xing');
    ?>

    <?php
            endforeach;
        endif;
    ?>


    <?php
}

function microblogposter_show_common_account_dashboard_head($site)
{
    ?>
    <div class="mbp_social-network-accounts-site">
        <img src="<?php echo plugins_url('/images/' . $site . '_icon.png', __FILE__);?>" />
        <?php
            $site_label = $site;
            if($site == 'vkontakte'){$site_label = 'vKontakte';}
        ?>
        <?php if( in_array(get_locale(), array('fr_FR', 'pt_PT', 'pt_BR', 'es_ES', 'es_MX', 'es_PE', 'it_IT')) ):?>
            <h4><?php _e('Accounts', 'microblog-poster');?> <?php echo ucfirst($site_label);?></h4>
        <?php else:?>
            <h4><?php echo ucfirst($site_label);?> <?php _e('Accounts', 'microblog-poster');?></h4>
        <?php endif;?>
        <div>
            <a href="#" onclick="mbp_social_accounts_microblogposter_uncheck_all('<?php echo $site;?>');return false;" ><?php _e('Uncheck All', 'microblog-poster');?></a> <a href="#" onclick="mbp_social_accounts_microblogposter_check_all('<?php echo $site;?>');return false;" ><?php _e('Check All', 'microblog-poster');?></a>
            <?php if(in_array($site, array('friendfeed','delicious', 'diigo', 'instapaper'))):?>
                <span class="description-small"><?php _e('Available shortcodes:', 'microblog-poster');?> {TITLE}</span>
            <?php else:?>
                <span class="description-small"><?php _e('Available shortcodes:', 'microblog-poster');?> {TITLE}, {URL}, {SHORT_URL}</span>
            <?php endif;?>
        </div>
    </div>
    <?php
}

function microblogposter_show_common_account_dashboard($account, $site)
{
    $message_format_mp = '';
    if(isset($account->extra) && $account->extra)
    {
        $extra = json_decode($account->extra, true);
        $message_format_mp = $extra['message_format_mp'];
    }
    ?>
    <div class="mbp_social-network-accounts-accounts">
        <input type="checkbox" class="mbp_social_account_microblogposter_boxc mbp_social_account_microblogposter_<?php echo $site;?>" id="mbp_social_account_microblogposter_<?php echo $account->account_id;?>" name="mbp_social_account_microblogposter_<?php echo $account->account_id;?>" value="1" checked="checked" /> 
        <label for="mbp_social_account_microblogposter_<?php echo $account->account_id;?>"><?php echo $account->username;?></label>
        <br />
        <label for="mbp_social_account_microblogposter_msg_<?php echo $account->account_id;?>"><?php _e('Message Format for Manual Posting:', 'microblog-poster');?></label>
        <textarea class="mbp_social_account_microblogposter_msgc" id="mbp_social_account_microblogposter_msg_<?php echo $account->account_id;?>" name="mbp_social_account_microblogposter_msg_<?php echo $account->account_id;?>" rows="2"><?php echo $message_format_mp;?></textarea>
        
    </div>
    <?php
}

/**
* Shows the MicroblogPoster's control dashboard
*
* @return string (html)
*/
function microblogposter_show_mini_control_dashboard_old()
{
    ?>
    <br />
    <style>
        .mbp_social-network-accounts-site-old
        {
            margin-top: 10px;
            margin-left: 20px;
            width: 100%;
        }
        .mbp_social-network-accounts-site-old h4
        {
            background-color: #EBEBEB;
            margin: 0px 0px;
            padding: 3px 5px;
            border-radius: 5px;
            display: inline-block;
            vertical-align: top;
            font-size: 14px;
            width: 90%;
        }
        .mbp_social-network-accounts-site-old a
        {
            font-size: 10px;
        }
        .mbp_social-network-accounts-site-old div
        {
            margin-left: 210px;
        }
        .mbp_social-network-accounts-site-old div span.description-small
        {
            margin-left: 5px;
        }
        .mbp_social-network-accounts-accounts
        {
            margin-left: 45px;
        }
        .mbp_social_account_microblogposter_msgcc
        {
            width: 290px;
            /*resize: none;*/
        }
    </style>

    <input type="hidden" name="mbp_control_dashboard_microblogposter" value="1" /> 
    <?php 
        $twitter_accounts = MicroblogPoster_Poster::get_accounts_object('twitter');
        if(!empty($twitter_accounts)):
            microblogposter_show_common_account_dashboard_head_old('twitter');
            foreach($twitter_accounts as $twitter_account):
                microblogposter_show_common_account_dashboard_old($twitter_account, 'twitter');
    ?>

    <?php
            endforeach;
        endif;
    ?>


    <?php 
        $plurk_accounts = MicroblogPoster_Poster::get_accounts_object('plurk');
        if(!empty($plurk_accounts)):
            microblogposter_show_common_account_dashboard_head_old('plurk');
            foreach($plurk_accounts as $plurk_account):
                microblogposter_show_common_account_dashboard_old($plurk_account, 'plurk');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $friendfeed_accounts = MicroblogPoster_Poster::get_accounts_object('friendfeed');
        if(!empty($friendfeed_accounts)):
            microblogposter_show_common_account_dashboard_head_old('friendfeed'); 
            foreach($friendfeed_accounts as $friendfeed_account):
                microblogposter_show_common_account_dashboard_old($friendfeed_account, 'friendfeed');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $delicious_accounts = MicroblogPoster_Poster::get_accounts_object('delicious');
        if(!empty($delicious_accounts)):
            microblogposter_show_common_account_dashboard_head_old('delicious'); 
            foreach($delicious_accounts as $delicious_account):
                microblogposter_show_common_account_dashboard_old($delicious_account, 'delicious');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $facebook_accounts = MicroblogPoster_Poster::get_accounts_object('facebook');
        if(!empty($facebook_accounts)):
            microblogposter_show_common_account_dashboard_head_old('facebook'); 
            foreach($facebook_accounts as $facebook_account):
                microblogposter_show_common_account_dashboard_old($facebook_account, 'facebook');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $diigo_accounts = MicroblogPoster_Poster::get_accounts_object('diigo');
        if(!empty($diigo_accounts)):
            microblogposter_show_common_account_dashboard_head_old('diigo'); 
            foreach($diigo_accounts as $diigo_account):
                microblogposter_show_common_account_dashboard_old($diigo_account, 'diigo');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $linkedin_accounts = MicroblogPoster_Poster::get_accounts_object('linkedin');
        if(!empty($linkedin_accounts)):
            microblogposter_show_common_account_dashboard_head_old('linkedin'); 
            foreach($linkedin_accounts as $linkedin_account):
                microblogposter_show_common_account_dashboard_old($linkedin_account, 'linkedin');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $tumblr_accounts = MicroblogPoster_Poster::get_accounts_object('tumblr');
        if(!empty($tumblr_accounts)):
            microblogposter_show_common_account_dashboard_head_old('tumblr'); 
            foreach($tumblr_accounts as $tumblr_account):
                microblogposter_show_common_account_dashboard_old($tumblr_account, 'tumblr');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $blogger_accounts = MicroblogPoster_Poster::get_accounts_object('blogger');
        if(!empty($blogger_accounts)):
            microblogposter_show_common_account_dashboard_head_old('blogger'); 
            foreach($blogger_accounts as $blogger_account):
                microblogposter_show_common_account_dashboard_old($blogger_account, 'blogger');
    ?>

    <?php
            endforeach;
        endif;
    ?>

    <?php 
        $instapaper_accounts = MicroblogPoster_Poster::get_accounts_object('instapaper');
        if(!empty($instapaper_accounts)):
            microblogposter_show_common_account_dashboard_head_old('instapaper'); 
            foreach($instapaper_accounts as $instapaper_account):
                microblogposter_show_common_account_dashboard_old($instapaper_account, 'instapaper');
    ?>

    <?php
            endforeach;
        endif;
    ?>
    
    <?php 
        $vkontakte_accounts = MicroblogPoster_Poster::get_accounts_object('vkontakte');
        if(!empty($vkontakte_accounts)):
            microblogposter_show_common_account_dashboard_head_old('vkontakte'); 
            foreach($vkontakte_accounts as $vkontakte_account):
                microblogposter_show_common_account_dashboard_old($vkontakte_account, 'vkontakte');
    ?>

    <?php
            endforeach;
        endif;
    ?>
    
    <?php 
        $xing_accounts = MicroblogPoster_Poster::get_accounts_object('xing');
        if(!empty($xing_accounts)):
            microblogposter_show_common_account_dashboard_head_old('xing'); 
            foreach($xing_accounts as $xing_account):
                microblogposter_show_common_account_dashboard_old($xing_account, 'xing');
    ?>

    <?php
            endforeach;
        endif;
    ?>


    <?php
}

function microblogposter_show_common_account_dashboard_head_old($site)
{
    ?>
    <div class="mbp_social-network-accounts-site-old">
        <img src="<?php echo plugins_url('/images/' . $site . '_icon.png', __FILE__);?>" />
        <?php
            $site_label = $site;
            if($site == 'vkontakte'){$site_label = 'vKontakte';}
        ?>
        <?php if( in_array(get_locale(), array('fr_FR', 'pt_PT', 'pt_BR', 'es_ES', 'es_MX', 'es_PE', 'it_IT')) ):?>
            <h4><?php _e('Accounts', 'microblog-poster');?> <?php echo ucfirst($site_label);?></h4>
        <?php else:?>
            <h4><?php echo ucfirst($site_label);?> <?php _e('Accounts', 'microblog-poster');?></h4>
        <?php endif;?>
        <div>
            <a href="#" onclick="mbp_social_accounts_microblogposter_uncheck_all_old('<?php echo $site;?>');return false;" ><?php _e('Uncheck All', 'microblog-poster');?></a> <a href="#" onclick="mbp_social_accounts_microblogposter_check_all_old('<?php echo $site;?>');return false;" ><?php _e('Check All', 'microblog-poster');?></a>
            
            <?php if(in_array($site, array('delicious', 'diigo', 'instapaper'))):?>
                <span class="description-small"><?php _e('Available shortcodes:', 'microblog-poster');?> {TITLE}, {MANUAL_EXCERPT}, {EXCERPT}, {CONTENT_FIRST_WORDS}, {AUTHOR}</span>
            <?php elseif(in_array($site, array('twitter','plurk'))):?>
                <span class="description-small"><?php _e('Available shortcodes:', 'microblog-poster');?> {TITLE}, {URL}, {SHORT_URL}, {SITE_URL}, {CONTENT_FIRST_WORDS}, {AUTHOR}</span>
            <?php elseif(in_array($site, array('friendfeed'))):?>
                <span class="description-small"><?php _e('Available shortcodes:', 'microblog-poster');?> {TITLE}, {CONTENT_FIRST_WORDS}, {AUTHOR}</span>
            <?php else:?>
                <span class="description-small"><?php _e('Available shortcodes:', 'microblog-poster');?> {TITLE}, {URL}, {SHORT_URL}, {SITE_URL}, {MANUAL_EXCERPT}, {EXCERPT}, {CONTENT_FIRST_WORDS}, {AUTHOR}</span>
            <?php endif;?>
            
        </div>
    </div>
    <?php
}

function microblogposter_show_common_account_dashboard_old($account, $site)
{
    $message_format_old = '';
    $active = 0;
    if(isset($account->extra) && $account->extra)
    {
        $extra = json_decode($account->extra, true);
        $message_format_old = $extra['message_format_old'];
        $active = $extra['old_posts_active'];
    }
    ?>
    <div class="mbp_social-network-accounts-accounts">
        <input type="checkbox" class="mbp_social_account_microblogposter_boxcc mbp_social_account_microblogposter_old_<?php echo $site;?>" id="mbp_social_account_microblogposter_old_<?php echo $account->account_id;?>" name="mbp_social_account_microblogposter_old_<?php echo $account->account_id;?>" value="1" <?php if($active==1) echo "checked=\"checked\""; ?> /> 
        <label for="mbp_social_account_microblogposter_old_<?php echo $account->account_id;?>"><?php echo $account->username;?></label>
        <br />
        <label for="mbp_social_account_microblogposter_msg_old_<?php echo $account->account_id;?>"><?php _e('Message Format for Old Posts:', 'microblog-poster');?></label>
        <textarea class="mbp_social_account_microblogposter_msgcc" id="mbp_social_account_microblogposter_msg_old_<?php echo $account->account_id;?>" name="mbp_social_account_microblogposter_msg_old_<?php echo $account->account_id;?>" rows="2"><?php echo $message_format_old;?></textarea>
        
    </div>
    <?php
}

?>