<?php
/**
 *
 * Plugin Name: Microblog Poster
 * Plugin URI: http://efficientscripts.com/microblogposter
 * Description: Automatically publishes your new blog content to Social Networks. Auto-updates Twitter, Facebook, Linkedin, Plurk, Diigo, Delicious..
 * Version: 1.3.0
 * Author: cybperic
 * Author URI: http://profiles.wordpress.org/users/cybperic/
 *
 *
 */

require_once "microblogposter_curl.php";
require_once "microblogposter_oauth.php";
require_once "microblogposter_bitly.php";



class MicroblogPoster_Poster
{
    
    /**
    * Activate function of this plugin called on activate action hook
    * 
    * 
    * @return  void
    */
    public static function activate()
    {
        global  $wpdb;
        
        $table_accounts = $wpdb->prefix . 'microblogposter_accounts';
        $table_logs = $wpdb->prefix . 'microblogposter_logs';
        
        $sql = "CREATE TABLE IF NOT EXISTS {$table_accounts} (
            account_id int(11) NOT NULL AUTO_INCREMENT,
            username varchar(200) NOT NULL DEFAULT '',
            password varchar(200) DEFAULT NULL,
            consumer_key varchar(200) DEFAULT NULL,
            consumer_secret varchar(200) DEFAULT NULL,
            access_token varchar(200) DEFAULT NULL,
            access_token_secret varchar(200) DEFAULT NULL,
            type varchar(100) NOT NULL DEFAULT '',
            message_format text,
            extra text,
            PRIMARY KEY (account_id),
            UNIQUE username_type (username,type)
	)";
	
        $wpdb->query($sql);
        
        $sql = "CREATE TABLE IF NOT EXISTS {$table_logs} (
            log_id int(11) NOT NULL AUTO_INCREMENT,
            account_id int(11) NOT NULL,
            account_type varchar(100) NOT NULL DEFAULT '',
            username varchar(200) NOT NULL DEFAULT '',
            post_id bigint UNSIGNED NOT NULL,
            action_result tinyint NOT NULL,
            update_message text,
            log_type varchar(50) NOT NULL DEFAULT 'regular',
            log_message text,
            log_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (log_id)
        )";
        
        $wpdb->query($sql);
        
        //twitter
        $twitter_consumer_key_name = "microblogposter_plg_twitter_consumer_key";
        $twitter_consumer_secret_name = "microblogposter_plg_twitter_consumer_secret";
        $twitter_access_token_name = "microblogposter_plg_twitter_access_token";
        $twitter_access_token_secret_name = "microblogposter_plg_twitter_access_token_secret";
        
        $twitter_consumer_key_value = get_option($twitter_consumer_key_name, "");
        $twitter_consumer_secret_value = get_option($twitter_consumer_secret_name, "");
        $twitter_access_token_value = get_option($twitter_access_token_name, "");
        $twitter_access_token_secret_value = get_option($twitter_access_token_secret_name, "");
        
        if($twitter_consumer_key_value and
           $twitter_consumer_secret_value and
           $twitter_access_token_value and
           $twitter_access_token_secret_value)
        {
            $sql = "INSERT IGNORE INTO {$table_accounts} 
            (username,password,consumer_key,consumer_secret,access_token,access_token_secret,type,message_format,extra)
            VALUES
            ('twitter1','','$twitter_consumer_key_value','$twitter_consumer_secret_value','$twitter_access_token_value','$twitter_access_token_secret_value','twitter','','')";
        
            $wpdb->query($sql);
            
            update_option($twitter_consumer_key_name, '');
            update_option($twitter_consumer_secret_name, '');
            update_option($twitter_access_token_name, '');
            update_option($twitter_access_token_secret_name, '');
        }
        
        //plurk
        $plurk_consumer_key_name = "microblogposter_plg_plurk_consumer_key";
        $plurk_consumer_secret_name = "microblogposter_plg_plurk_consumer_secret";
        $plurk_access_token_name = "microblogposter_plg_plurk_access_token";
        $plurk_access_token_secret_name = "microblogposter_plg_plurk_access_token_secret";
        
        $plurk_consumer_key_value = get_option($plurk_consumer_key_name, "");
        $plurk_consumer_secret_value = get_option($plurk_consumer_secret_name, "");
        $plurk_access_token_value = get_option($plurk_access_token_name, "");
        $plurk_access_token_secret_value = get_option($plurk_access_token_secret_name, "");
        
        if($plurk_consumer_key_value and
           $plurk_consumer_secret_value and
           $plurk_access_token_value and
           $plurk_access_token_secret_value)
        {
            $sql = "INSERT IGNORE INTO {$table_accounts} 
            (username,password,consumer_key,consumer_secret,access_token,access_token_secret,type,message_format,extra)
            VALUES
            ('plurk1','','$plurk_consumer_key_value','$plurk_consumer_secret_value','$plurk_access_token_value','$plurk_access_token_secret_value','plurk','','')";
        
            $wpdb->query($sql);
            
            update_option($plurk_consumer_key_name, '');
            update_option($plurk_consumer_secret_name, '');
            update_option($plurk_access_token_name, '');
            update_option($plurk_access_token_secret_name, '');
        }
        
        //identica
        $identica_username_name = "microblogposter_plg_identica_username";
        $identica_password_name = "microblogposter_plg_identica_password";
        
        $identica_username_value = get_option($identica_username_name, "");
        $identica_password_value = get_option($identica_password_name, "");
        
        if($identica_username_value and
           $identica_password_value)
        {
            $sql = "INSERT IGNORE INTO {$table_accounts} 
            (username,password,consumer_key,consumer_secret,access_token,access_token_secret,type,message_format,extra)
            VALUES
            ('$identica_username_value','$identica_password_value','','','','','identica','','')";
        
            $wpdb->query($sql);
            
            update_option($identica_username_name, '');
            update_option($identica_password_name, '');
        }
        
        //delicious
        
        $delicious_username_name = "microblogposter_plg_delicious_username";
        $delicious_password_name = "microblogposter_plg_delicious_password";
        
        $delicious_username_value = get_option($delicious_username_name, "");
        $delicious_password_value = get_option($delicious_password_name, "");
        
        if($delicious_username_value and
           $delicious_password_value)
        {
            $sql = "INSERT IGNORE INTO {$table_accounts} 
            (username,password,consumer_key,consumer_secret,access_token,access_token_secret,type,message_format,extra)
            VALUES
            ('$delicious_username_value','$delicious_password_value','','','','','delicious','','')";
        
            $wpdb->query($sql);
            
            update_option($delicious_username_name, '');
            update_option($delicious_password_name, '');
        }
        
        //friendfeed
        
        $friendfeed_username_name = "microblogposter_plg_friendfeed_username";
        $friendfeed_password_name = "microblogposter_plg_friendfeed_password";
        
        $friendfeed_username_value = get_option($friendfeed_username_name, "");
        $friendfeed_password_value = get_option($friendfeed_password_name, "");
        
        if($friendfeed_username_value and
           $friendfeed_password_value)
        {
            $sql = "INSERT IGNORE INTO {$table_accounts} 
            (username,password,consumer_key,consumer_secret,access_token,access_token_secret,type,message_format,extra)
            VALUES
            ('$friendfeed_username_value','$friendfeed_password_value','','','','','friendfeed','','')";
        
            $wpdb->query($sql);
            
            update_option($friendfeed_username_name, '');
            update_option($friendfeed_password_name, '');
        }
    }
    
    /**
    * Main function of this plugin called on publish_post action hook
    * 
    *
    * @param   int  $post_ID ID of the new/updated post
    * @return  void
    */
    public static function update($post_ID)
    {
        //If this time Microblog Poster is disabled return immediatelly
	if ($_POST['microblogposteroff'] == "on")
        {
            return;
        }
        
        $post = get_post($post_ID);
        $post->post_content = strip_tags($post->post_content);
        $post->post_content = preg_replace("|(\r\n)+|", " ", $post->post_content);
        $post->post_content = preg_replace("|(\t)+|", "", $post->post_content);
        $post->post_content = preg_replace("|\&nbsp\;|", "", $post->post_content);
        $post_content_actual = $post->post_content;
        $post_content_actual_lkn = substr($post_content_actual, 0, 300);
        
        
        $post_thumbnail_id = get_post_thumbnail_id($post_ID);
        $featured_image_src = '';
        if($post_thumbnail_id)
        {
            $image_attributes = wp_get_attachment_image_src($post_thumbnail_id, 'thumbnail');
            $featured_image_src_thumbnail = $image_attributes[0];
            $image_attributes = wp_get_attachment_image_src($post_thumbnail_id, 'medium');
            $featured_image_src_medium = $image_attributes[0];
        }
        
	$post_title = $post->post_title;
        $post_title = substr($post_title, 0, 110);
        if(strlen($post_title) == 110)
        {
            $post_title = substr($post_title, 0, strrpos($post_title, " "));
            $post_title .= "...";
        }
        $permalink = get_permalink($post_ID);
	$update = $post_title . " $permalink";
        
        $post_content = array();
        $post_content[] = home_url();
        $post_content[] = $post_title;
        $post_content[] = $permalink;
        
        $bitly_api = new MicroblogPoster_Bitly();
        $bitly_api_user_value = get_option("microblogposter_plg_bitly_api_user", "");
        $bitly_api_key_value = get_option("microblogposter_plg_bitly_api_key", "");
        if($bitly_api_user_value and $bitly_api_key_value)
        {
            $bitly_api->setCredentials($bitly_api_user_value, $bitly_api_key_value);
            $shortened_permalink = $bitly_api->shorten($permalink);
            if($shortened_permalink)
            {
                $update = $post_title . " $shortened_permalink";
                $permalink = $shortened_permalink;
                $post_content[] = $shortened_permalink;
            }
        }
	
	
	$tags = "";
	$posttags = get_the_tags($post_ID);
	if ($posttags) {
	    foreach($posttags as $tag) {
		    $tags .= $tag->slug . ','; 
	    }
	}
	$tags = rtrim($tags,',');
        
        @ini_set('max_execution_time', '0');
        
        MicroblogPoster_Poster::update_twitter($update, $post_content, $post_ID);
        MicroblogPoster_Poster::update_plurk($update, $post_content, $post_ID);
	MicroblogPoster_Poster::update_identica($update, $post_content, $post_ID);
	MicroblogPoster_Poster::update_delicious($post_title, $permalink, $tags, $post_content, $post_ID);
        MicroblogPoster_Poster::update_friendfeed($post_title, $permalink, $post_content, $post_ID);
        MicroblogPoster_Poster::update_facebook($update, $post_content, $post_ID, $post_title, $permalink, $post_content_actual_lkn, $featured_image_src_thumbnail);
        MicroblogPoster_Poster::update_diigo($post_title, $permalink, $tags, $post_content, $post_ID);
        MicroblogPoster_Poster::update_linkedin($update, $post_content, $post_ID, $post_title, $permalink, $post_content_actual_lkn, $featured_image_src_medium);
        
        MicroblogPoster_Poster::maintain_logs();
    }
    
    /**
    * Updates status on twitter
    *
    * @param string  $update Text to be posted on microblogging site
    * @param array $post_content
    * @return void
    */
    public static function update_twitter($update, $post_content, $post_ID)
    {   
        
        $twitter_accounts = MicroblogPoster_Poster::get_accounts('twitter');
        
        if(!empty($twitter_accounts))
        {
            foreach($twitter_accounts as $twitter_account)
            {
                if($twitter_account['message_format'])
                {
                    $update = str_ireplace(MicroblogPoster_Poster::get_shortcodes(), $post_content, $twitter_account['message_format']);
                }
                $result = MicroblogPoster_Poster::send_signed_request(
                    $twitter_account['consumer_key'],
                    $twitter_account['consumer_secret'],
                    $twitter_account['access_token'],
                    $twitter_account['access_token_secret'],
                    "https://api.twitter.com/1.1/statuses/update.json",
                    array("status"=>$update)
                );
                
                $action_result = 2;
                $result_dec = json_decode($result, true);
                if($result_dec && isset($result_dec['id']))
                {
                    $action_result = 1;
                    $result = "Success";
                }
                
                $log_data = array();
                $log_data['account_id'] = $twitter_account['account_id'];
                $log_data['account_type'] = "twitter";
                $log_data['username'] = $twitter_account['username'];
                $log_data['post_id'] = $post_ID;
                $log_data['action_result'] = $action_result;
                $log_data['update_message'] = $update;
                $log_data['log_message'] = $result;
                MicroblogPoster_Poster::insert_log($log_data);
            }
        }
        
    }
    
    /**
    * Updates status on plurk
    *
    * @param string  $update Text to be posted on microblogging site
    * @param array $post_content
    * @return void
    */
    public static function update_plurk($update, $post_content, $post_ID)
    {   
        
        $plurk_accounts = MicroblogPoster_Poster::get_accounts('plurk');
        
        if(!empty($plurk_accounts))
        {
            foreach($plurk_accounts as $plurk_account)
            {
                if($plurk_account['message_format'])
                {
                    $update = str_ireplace(MicroblogPoster_Poster::get_shortcodes(), $post_content, $plurk_account['message_format']);
                }
                $result = MicroblogPoster_Poster::send_signed_request(
                    $plurk_account['consumer_key'],
                    $plurk_account['consumer_secret'],
                    $plurk_account['access_token'],
                    $plurk_account['access_token_secret'],
                    "http://www.plurk.com/APP/Timeline/plurkAdd",
                    array("content"=>$update, "qualifier"=>"says")
                );
                
                $action_result = 2;
                $result_dec = json_decode($result, true);
                if($result_dec && isset($result_dec['plurk_id']))
                {
                    $action_result = 1;
                    $result = "Success";
                }
                
                $log_data = array();
                $log_data['account_id'] = $plurk_account['account_id'];
                $log_data['account_type'] = "plurk";
                $log_data['username'] = $plurk_account['username'];
                $log_data['post_id'] = $post_ID;
                $log_data['action_result'] = $action_result;
                $log_data['update_message'] = $update;
                $log_data['log_message'] = $result;
                MicroblogPoster_Poster::insert_log($log_data);
            }
        }
        
    }
    
    /**
    * Updates status on identi.ca
    *
    * @param string  $update Text to be posted on microblogging site
    * @param array $post_content
    * @return void
    */
    public static function update_identica($update, $post_content, $post_ID)
    {
	
        $curl = new MicroblogPoster_Curl();
        $identica_accounts = MicroblogPoster_Poster::get_accounts('identica');
        
        if(!empty($identica_accounts))
        {
            foreach($identica_accounts as $identica_account)
            {
                
                if($identica_account['message_format'])
                {
                    $update = str_ireplace(MicroblogPoster_Poster::get_shortcodes(), $post_content, $identica_account['message_format']);
                }
                $is_raw = MicroblogPoster_SupportEnc::is_enc($identica_account['extra']);
                if(!$is_raw)
                {
                    $identica_account['password'] = MicroblogPoster_SupportEnc::dec($identica_account['password']);
                }
                $curl->set_credentials($identica_account['username'],$identica_account['password']);

                $url = "http://identi.ca/api/statuses/update.json";
                $post_args = array(
                    'status' => $update
                );

                $result = $curl->send_post_data($url, $post_args);
                
                $action_result = 0;
                
                $log_data = array();
                $log_data['account_id'] = $identica_account['account_id'];
                $log_data['account_type'] = "identica";
                $log_data['username'] = $identica_account['username'];
                $log_data['post_id'] = $post_ID;
                $log_data['action_result'] = $action_result;
                $log_data['update_message'] = $update;
                $log_data['log_message'] = $result;
                MicroblogPoster_Poster::insert_log($log_data);
            }
        }
        
	
    }
    
    /**
    * Updates status on delicious.com
    *
    * @param   string  $title Text to be posted on microblogging site
    * @param   string  $link
    * @param   string  $tags
    * @param array $post_content 
    * @return  void
    */
    public static function update_delicious($title, $link, $tags, $post_content, $post_ID)
    {
	
        $curl = new MicroblogPoster_Curl();
        $delicious_accounts = MicroblogPoster_Poster::get_accounts('delicious');
        
        if(!empty($delicious_accounts))
        {
            foreach($delicious_accounts as $delicious_account)
            {
                if($delicious_account['message_format'])
                {
                    $title = str_ireplace(array('{title}'), array($post_content[1]), $delicious_account['message_format']);
                }
                $is_raw = MicroblogPoster_SupportEnc::is_enc($delicious_account['extra']);
                if(!$is_raw)
                {
                    $delicious_account['password'] = MicroblogPoster_SupportEnc::dec($delicious_account['password']);
                }
                $extra = json_decode($delicious_account['extra'], true);
                if(is_array($extra))
                {
                    $include_tags = (isset($extra['include_tags']) && $extra['include_tags'] == 1)?true:false;
                }
                $curl->set_credentials($delicious_account['username'],$delicious_account['password']);
                $curl->set_user_agent("Mozilla/6.0 (Windows NT 6.2; WOW64; rv:16.0.1) Gecko/20121011 Firefox/16.0.1");

                $link_enc=urlencode($link);
                $title_enc = urlencode($title);
                $tags_enc = urlencode($tags);
                $update_message = $title." - ".$link;

                $url = "https://api.del.icio.us/v1/posts/add?url=$link_enc&description=$title_enc&shared=yes";
                if($include_tags)
                {
                    $url .= "&tags=$tags_enc";
                    $update_message .= " ($tags)";
                }
                $result = $curl->fetch_url($url);
                
                $action_result = 2;
                if($result && stripos($result, 'code="done"')!==false)
                {
                    $action_result = 1;
                    $result = "Success";
                }
                
                $log_data = array();
                $log_data['account_id'] = $delicious_account['account_id'];
                $log_data['account_type'] = "delicious";
                $log_data['username'] = $delicious_account['username'];
                $log_data['post_id'] = $post_ID;
                $log_data['action_result'] = $action_result;
                $log_data['update_message'] = $update_message;
                $log_data['log_message'] = $result;
                MicroblogPoster_Poster::insert_log($log_data);
            }
        }
        
    }
    
    /**
    * Updates status on http://friendfeed.com/
    *
    * @param   string  $title Text to be posted on microblogging site
    * @param   string  $link
    * @param   array $post_content
    * @return  void
    */
    public static function update_friendfeed($title, $link, $post_content, $post_ID)
    {
	
	$curl = new MicroblogPoster_Curl();
        $friendfeed_accounts = MicroblogPoster_Poster::get_accounts('friendfeed');
        
        if(!empty($friendfeed_accounts))
        {
            foreach($friendfeed_accounts as $friendfeed_account)
            {
                if($friendfeed_account['message_format'])
                {
                    $title = str_ireplace(array('{title}'), array($post_content[1]), $friendfeed_account['message_format']);
                }
                $is_raw = MicroblogPoster_SupportEnc::is_enc($friendfeed_account['extra']);
                if(!$is_raw)
                {
                    $friendfeed_account['password'] = MicroblogPoster_SupportEnc::dec($friendfeed_account['password']);
                }
                $curl->set_credentials($friendfeed_account['username'],$friendfeed_account['password']);
	
                $url = "http://friendfeed-api.com/v2/entry";
                $post_args = array(
                    'body' => $title,
                    'link' => $link
                );

                $result = $curl->send_post_data($url, $post_args);
                
                $update_message = $title." - ".$link;
                
                $action_result = 2;
                $result_dec = json_decode($result, true);
                if($result_dec && isset($result_dec['id']))
                {
                    $action_result = 1;
                    $result = "Success";
                }
                
                $log_data = array();
                $log_data['account_id'] = $friendfeed_account['account_id'];
                $log_data['account_type'] = "friendfeed";
                $log_data['username'] = $friendfeed_account['username'];
                $log_data['post_id'] = $post_ID;
                $log_data['action_result'] = $action_result;
                $log_data['update_message'] = $update_message;
                $log_data['log_message'] = $result;
                MicroblogPoster_Poster::insert_log($log_data);
            }
            
        }
	
    }
    
    /**
    * Updates status on facebook
    *
    * @param string  $update Text to be posted on microblogging site
    * @param array $post_content 
    * @return void
    */
    public static function update_facebook($update, $post_content, $post_ID, $post_title, $permalink, $post_content_actual, $featured_image_src)
    {
        
        $curl = new MicroblogPoster_Curl();
        $facebook_accounts = MicroblogPoster_Poster::get_accounts('facebook');
        
        if(!empty($facebook_accounts))
        {
            foreach($facebook_accounts as $facebook_account)
            {
                if(!$facebook_account['extra'])
                {
                    continue;
                }
                
                if($facebook_account['message_format'])
                {
                    $update = str_ireplace(MicroblogPoster_Poster::get_shortcodes(), $post_content, $facebook_account['message_format']);
                }
                $extra = json_decode($facebook_account['extra'], true);
                
                if(isset($extra['user_id']) && isset($extra['access_token']))
                {
                    
                    $url = "https://graph.facebook.com/{$extra['user_id']}/feed";
                    $post_args = array(
                        'access_token' => $extra['access_token'],
                        'message' => $update
                    );

                    if(isset($extra['post_type']) && $extra['post_type'] == 'link')
                    {
                        $post_args['name'] = $post_title;
                        $post_args['link'] = $permalink;
                        $post_args['description'] = $post_content_actual;
                        $picture_url = '';
                        if(isset($extra['default_image_url']) && $extra['default_image_url'])
                        {
                            $picture_url = $extra['default_image_url'];
                        }
                        if($featured_image_src)
                        {
                            $picture_url = $featured_image_src;
                        }
                        $post_args['picture'] = $picture_url;
                    }
                    
                    $result = $curl->send_post_data($url, $post_args);
                    $result_dec = json_decode($result, true);
                    
                    $action_result = 2;
                    if($result_dec && isset($result_dec['id']))
                    {
                        $action_result = 1;
                        $result = "Success";
                    }

                    $log_data = array();
                    $log_data['account_id'] = $facebook_account['account_id'];
                    $log_data['account_type'] = "facebook";
                    $log_data['username'] = $facebook_account['username'];
                    $log_data['post_id'] = $post_ID;
                    $log_data['action_result'] = $action_result;
                    $log_data['update_message'] = $update;
                    $log_data['log_message'] = $result;
                    MicroblogPoster_Poster::insert_log($log_data);
                }
                
            }
            
        }
    }
    
    /**
    * Updates status on diigo.com
    *
    * @param   string  $title Text to be posted on microblogging site
    * @param   string  $link
    * @param   string  $tags
    * @param array $post_content 
    * @return  void
    */
    public static function update_diigo($title, $link, $tags, $post_content, $post_ID)
    {
	
        $curl = new MicroblogPoster_Curl();
        $diigo_accounts = MicroblogPoster_Poster::get_accounts('diigo');
        
        if(!empty($diigo_accounts))
        {
            foreach($diigo_accounts as $diigo_account)
            {
                if($diigo_account['message_format'])
                {
                    $title = str_ireplace(array('{title}'), array($post_content[1]), $diigo_account['message_format']);
                }
                $is_raw = MicroblogPoster_SupportEnc::is_enc($diigo_account['extra']);
                if(!$is_raw)
                {
                    $diigo_account['password'] = MicroblogPoster_SupportEnc::dec($diigo_account['password']);
                }
                $extra = json_decode($diigo_account['extra'], true);
                if(is_array($extra))
                {
                    $include_tags = (isset($extra['include_tags']) && $extra['include_tags'] == 1)?true:false;
                    $api_key = $extra['api_key'];
                }
                $curl->set_credentials($diigo_account['username'], $diigo_account['password']);
                $curl->set_user_agent("Mozilla/6.0 (Windows NT 6.2; WOW64; rv:16.0.1) Gecko/20121011 Firefox/16.0.1");

                $link_enc=urlencode($link);
                $title_enc = urlencode($title);
                $tags_enc = urlencode($tags);
                $update_message = $title." - ".$link;

                $url = "https://secure.diigo.com/api/v2/bookmarks";
                $post_args = array(
                    'key' => $api_key,
                    'title' => $title,
                    'url' => $link,
                    'shared' => 'yes'
                );
                if($include_tags)
                {
                    $post_args['tags'] = $tags;
                    $update_message .= " ($tags)";
                }
                $result = $curl->send_post_data($url, $post_args);
                $result_dec = json_decode($result, true);
                
                $action_result = 2;
                if($result_dec && isset($result_dec['code']) && $result_dec['code'] == 1)
                {
                    $action_result = 1;
                    $result = "Success";
                }
                else
                {
                    $result = "Please recheck your username/password and API Key.";
                }
                
                $log_data = array();
                $log_data['account_id'] = $diigo_account['account_id'];
                $log_data['account_type'] = "diigo";
                $log_data['username'] = $diigo_account['username'];
                $log_data['post_id'] = $post_ID;
                $log_data['action_result'] = $action_result;
                $log_data['update_message'] = $update_message;
                $log_data['log_message'] = $result;
                MicroblogPoster_Poster::insert_log($log_data);
            }
        }
        
    }
    
    /**
    * Updates status on linkedin
    *
    * @param string  $update Text to be posted on microblogging site
    * @param array $post_content 
    * @return void
    */
    public static function update_linkedin($update, $post_content, $post_ID, $post_title, $permalink, $post_content_actual, $featured_image_src)
    {
        
        $curl = new MicroblogPoster_Curl();
        $linkedin_accounts = MicroblogPoster_Poster::get_accounts('linkedin');
        
        if(!empty($linkedin_accounts))
        {
            foreach($linkedin_accounts as $linkedin_account)
            {
                if(!$linkedin_account['extra'])
                {
                    continue;
                }
                
                if($linkedin_account['message_format'])
                {
                    $update = str_ireplace(MicroblogPoster_Poster::get_shortcodes(), $post_content, $linkedin_account['message_format']);
                }
                $extra = json_decode($linkedin_account['extra'], true);
                
                if(isset($extra['access_token']))
                {
                    
                    $url = "https://api.linkedin.com/v1/people/~/shares/?oauth2_access_token={$extra['access_token']}";
                    
                    $body = new stdClass();
                    $body->comment = $update;
                    
                    if(isset($extra['post_type']) && $extra['post_type'] == 'link')
                    {
                        $body->content = new stdClass();
                        $body->content->title = $post_title;
                        $body->content->{'submitted-url'} = $permalink;
                        $body->content->description = $post_content_actual;
                        $picture_url = '';// 180 wid, 110 hei
                        if(isset($extra['default_image_url']) && $extra['default_image_url'])
                        {
                            $picture_url = $extra['default_image_url'];
                        }
                        if($featured_image_src)
                        {
                            $picture_url = $featured_image_src;
                        }
                        $body->content->{'submitted-image-url'} = $picture_url;
                    }
                    
                    $body->visibility = new stdClass();
                    $body->visibility->code = 'anyone';
                    $body_json = json_encode($body);

                    $curl->set_headers(array('Content-Type'=>'application/json'));
                    $result = $curl->send_post_data_json($url, $body_json);
                    
                    
                    $action_result = 2;
                    if($result && stripos($result, '<update-key>')!==false && stripos($result, '</update-key>')!==false)
                    {
                        $action_result = 1;
                        $result = "Success";
                    }

                    $log_data = array();
                    $log_data['account_id'] = $linkedin_account['account_id'];
                    $log_data['account_type'] = "linkedin";
                    $log_data['username'] = $linkedin_account['username'];
                    $log_data['post_id'] = $post_ID;
                    $log_data['action_result'] = $action_result;
                    $log_data['update_message'] = $update;
                    $log_data['log_message'] = $result;
                    MicroblogPoster_Poster::insert_log($log_data);
                }
                
            }
            
        }
    }
    
    /**
    * Sends OAuth signed request
    *
    * @param   string  $c_key Application consumer key
    * @param   string  $c_secret Application consumer secret
    * @param   string  $token Account access token
    * @param   string  $token_secret Account access token secret
    * @param   string  $api_url URL of the API end point
    * @param   string  $params Parameters to be passed
    * @return  void
    */
    public static function send_signed_request($c_key, $c_secret, $token, $token_secret, $api_url, $params)
    {
        $consumer = new MicroblogPosterOAuthConsumer($c_key, $c_secret);
        $access_token = new MicroblogPosterOAuthConsumer($token, $token_secret);
        
        $request = MicroblogPosterOAuthRequest::from_consumer_and_token(
                $consumer,
                $access_token,
                "POST",
                $api_url,
                $params
        );
        $hmac_method = new MicroblogPosterOAuthSignatureMethod_HMAC_SHA1();
        $request->sign_request($hmac_method, $consumer, $access_token);
        
        if(($pos=strpos($request,"?")) !== false)
        {
            $url = substr($request,0,$pos);
            $parameters = substr($request,$pos+1);
        }
        
        $curl = new MicroblogPoster_Curl();
        $result = $curl->send_post_data($url, $parameters);
        return $result;
    
    }
    
    /**
    * Get accounts from db
    *
    * @param   string  $type Type of account (=site)
    * @return  array
    */
    private static function get_accounts($type)
    {
        global  $wpdb;

        $table_accounts = $wpdb->prefix . 'microblogposter_accounts';
        
        $sql="SELECT * FROM $table_accounts WHERE type='{$type}'";
        $rows = $wpdb->get_results($sql, ARRAY_A);
        
        return $rows;
    }
    
    /**
    * Insert new log into db
    *
    * @param   array  $log_data Log message
    * @return  bool
    */
    public static function insert_log($log_data)
    {
        global  $wpdb;

        $table_logs = $wpdb->prefix . 'microblogposter_logs';
        
        $wpdb->escape_by_ref($log_data['log_message']);
        $wpdb->escape_by_ref($log_data['update_message']);
        $wpdb->escape_by_ref($log_data['username']);
        
        $sql="INSERT INTO $table_logs (account_id, account_type, username, post_id, action_result, update_message, log_message) 
            VALUES ('{$log_data['account_id']}','{$log_data['account_type']}','{$log_data['username']}','{$log_data['post_id']}','{$log_data['action_result']}','{$log_data['update_message']}','{$log_data['log_message']}')";
        $wpdb->query($sql);
        
        return true;
    }
    
    /**
    * Keeps logs table under 2000 rows
    *
    * @return  void
    */
    private static function maintain_logs()
    {
        global  $wpdb;

        $table_logs = $wpdb->prefix . 'microblogposter_logs';
        
        $sql="SELECT log_id FROM $table_logs ORDER BY log_id DESC LIMIT 2000";
        $rows = $wpdb->get_results($sql);
        if(is_array($rows) && count($rows)==2000)
        {
            $log_ids = "(";
            foreach($rows as $row)
            {
                $log_ids .= $row->log_id.",";
            }
            $log_ids = rtrim($log_ids, ",");
            $log_ids .= ")";
            
            $sql="DELETE FROM {$table_logs} WHERE log_id NOT IN {$log_ids}";
            $wpdb->query($sql);
        }
        
        return true;
    }
    
    /**
    * 
    * get_shortcodes
    * 
    * @return  array
    */
    private static function get_shortcodes()
    {
        return array('{site_url}', '{title}', '{url}', '{short_url}');
    }
    
}

class MicroblogPoster_SupportEnc
{
    /**
    * Encodes the given string
    * 
    * @param string $str
    * @return  string
    */
    public static function enc($str)
    {
        $str = 'microblogposter_'.$str;
        $str = base64_encode($str);
        return $str;
    }
    
    /**
    * Decodes the given string
    * 
    * @param string $str
    * @return  string
    */
    public static function dec($str)
    {
        $str = base64_decode($str);
        $str = str_replace('microblogposter_', '', $str);
        return $str;
    }
    
    /**
    * Checks if enc
    * 
    * @param string $e
    * @return  bool
    */
    public static function is_enc($e)
    {
        $is_raw = true;
        $extra = json_decode($e, true);
        if(is_array($extra))
        {
            $is_raw = (isset($extra['penc']) && $extra['penc'] == 1)?false:true;
        }
        return $is_raw;
    }
}

register_activation_hook(__FILE__, array('MicroblogPoster_Poster', 'activate'));

add_action('publish_post', array('MicroblogPoster_Poster', 'update'));

$page_mode_name = "microblogposter_page_mode";
$page_mode_value = get_option($page_mode_name, "");
if($page_mode_value)
{
    add_action('publish_page', array('MicroblogPoster_Poster', 'update'));
}


//Displays a checkbox that allows users to disable Microblog Poster on a per post basis.
function microblogposter_meta()
{
    $default_behavior_name = "microblogposter_default_behavior";
    $default_behavior_value = get_option($default_behavior_name, "");
    $default_behavior_update_name = "microblogposter_default_behavior_update";
    $default_behavior_update_value = get_option($default_behavior_update_name, "");
    
    $screen = get_current_screen();
    if($screen->action != 'add')
    {
        $default_behavior_value = $default_behavior_update_value;
    }
    ?>
    <input type="checkbox" id="microblogposteroff" name="microblogposteroff" <?php if($default_behavior_value) echo 'checked="checked"';?> /> 
    <label for="microblogposteroff">Disable Microblog Poster this time?</label>
    <?php
}

//Displays a checkbox that allows users to disable Microblog Poster on a per page basis.
function microblogposter_pmeta()
{
    $default_pbehavior_name = "microblogposter_default_pbehavior";
    $default_pbehavior_value = get_option($default_pbehavior_name, "");
    $default_pbehavior_update_name = "microblogposter_default_pbehavior_update";
    $default_pbehavior_update_value = get_option($default_pbehavior_update_name, "");
    
    $screen = get_current_screen();
    if($screen->action != 'add')
    {
        $default_pbehavior_value = $default_pbehavior_update_value;
    }
    ?>
    <input type="checkbox" id="microblogposteroff" name="microblogposteroff" <?php if($default_pbehavior_value) echo 'checked="checked"';?> /> 
    <label for="microblogposteroff">Disable Microblog Poster this time?</label>
    <?php
}

//Add the checkbox defined above to post edit screen.
function microblogposter_meta_box()
{
    add_meta_box('microblogposter_domain','MicroblogPoster','microblogposter_meta','post','side','high');
    $page_mode_name = "microblogposter_page_mode";
    $page_mode_value = get_option($page_mode_name, "");
    if($page_mode_value)
    {
        add_meta_box('microblogposter_domain','MicroblogPoster','microblogposter_pmeta','page','side','high');
    }
}
add_action('admin_menu', 'microblogposter_meta_box');

//Options

require_once "microblogposter_options.php";


?>