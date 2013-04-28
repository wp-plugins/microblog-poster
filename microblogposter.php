<?php
/**
 *
 * Plugin Name: Microblog Poster
 * Description: Automatically publishes your new blog content to Social Networks. Auto-updates Twitter, Facebook, Plurk, Identica, Delicious..
 * Version: 1.2.4
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
        
        MicroblogPoster_Poster::update_twitter($update, $post_content);
        MicroblogPoster_Poster::update_plurk($update, $post_content);
	MicroblogPoster_Poster::update_identica($update, $post_content);
	MicroblogPoster_Poster::update_delicious($post_title, $permalink, $tags, $post_content);
        MicroblogPoster_Poster::update_friendfeed($post_title, $permalink, $post_content);
        MicroblogPoster_Poster::update_facebook($update, $post_content);
    }
    
    /**
    * Updates status on twitter
    *
    * @param string  $update Text to be posted on microblogging site
    * @param array $post_content
    * @return void
    */
    public static function update_twitter($update, $post_content)
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
                MicroblogPoster_Poster::send_signed_request(
                    $twitter_account['consumer_key'],
                    $twitter_account['consumer_secret'],
                    $twitter_account['access_token'],
                    $twitter_account['access_token_secret'],
                    "https://api.twitter.com/1/statuses/update.json",
                    array("status"=>$update)
                ); 
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
    public static function update_plurk($update, $post_content)
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
                MicroblogPoster_Poster::send_signed_request(
                    $plurk_account['consumer_key'],
                    $plurk_account['consumer_secret'],
                    $plurk_account['access_token'],
                    $plurk_account['access_token_secret'],
                    "http://www.plurk.com/APP/Timeline/plurkAdd",
                    array("content"=>$update, "qualifier"=>"says")
                );
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
    public static function update_identica($update, $post_content)
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

                $curl->send_post_data($url, $post_args);
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
    public static function update_delicious($title, $link, $tags, $post_content)
    {
	
        $curl = new MicroblogPoster_Curl();
        $delicious_accounts = MicroblogPoster_Poster::get_accounts('delicious');
        
        if(!empty($delicious_accounts))
        {
            foreach($delicious_accounts as $delicious_account)
            {
                if($delicious_account['message_format'])
                {
                    $title = str_ireplace(array('{title}'), array($post_content[0]), $delicious_account['message_format']);
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

                $link=urlencode($link);
                $title = urlencode($title);
                $tags = urlencode($tags);

                $url = "https://api.del.icio.us/v1/posts/add?url=$link&description=$title&shared=yes";
                if($include_tags)
                {
                    $url .= "&tags=$tags";
                }
                $curl->fetch_url($url);
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
    public static function update_friendfeed($title, $link, $post_content)
    {
	
	$curl = new MicroblogPoster_Curl();
        $friendfeed_accounts = MicroblogPoster_Poster::get_accounts('friendfeed');
        
        if(!empty($friendfeed_accounts))
        {
            foreach($friendfeed_accounts as $friendfeed_account)
            {
                if($friendfeed_account['message_format'])
                {
                    $title = str_ireplace(array('{title}'), array($post_content[0]), $friendfeed_account['message_format']);
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

                $curl->send_post_data($url, $post_args);
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
    public static function update_facebook($update, $post_content)
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

                    $result = $curl->send_post_data($url, $post_args);
                    $result = json_decode($result, true);
                    if(!isset($result['id']))
                    {
                        global  $wpdb;
                        $table_accounts = $wpdb->prefix . 'microblogposter_accounts';
                        
                        $sql = "UPDATE {$table_accounts}
                            SET extra=''
                            WHERE account_id={$facebook_account['account_id']}";

                        $wpdb->query($sql);
                    }
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
        $curl->send_post_data($url, $parameters);
        return;
    
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
    * 
    * get_shortcodes
    * 
    * @return  array
    */
    private static function get_shortcodes()
    {
        return array('{title}', '{url}', '{short_url}');
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

//Displays a checkbox that allows users to disable Microblog Poster on a per post basis.
function microblogposter_meta()
{
    $default_behavior_name = "microblogposter_default_behavior";
    $default_behavior_value = get_option($default_behavior_name, "");
    ?>
    <input type="checkbox" id="microblogposteroff" name="microblogposteroff" <?php if($default_behavior_value) echo 'checked="checked"';?> /> 
    <label for="microblogposteroff">Disable Microblog Poster this time?</label>
    <?php
}

//Add the checkbox defined above to post edit screen.
function microblogposter_meta_box()
{
    add_meta_box('microblogposter_domain','MicroblogPoster','microblogposter_meta','post','side','high');
}
add_action('admin_menu', 'microblogposter_meta_box');

//Options

require_once "microblogposter_options.php";


?>