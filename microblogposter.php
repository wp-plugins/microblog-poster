<?php
/**
 *
 * Plugin Name: Microblog Poster
 * Description: Easily update your microblog with 'post title + shortened backlink' of your new post.  
 * Version: 1.0
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
        
        $bitly_api = new MicroblogPoster_Bitly();
        $bitly_api_user_value = get_option("microblogposter_plg_bitly_api_user", "");
        $bitly_api_key_value = get_option("microblogposter_plg_bitly_api_key", "");
        if($bitly_api_user_value and $bitly_api_key_value)
        {
            $bitly_api->setCredentials($bitly_api_user_value, $bitly_api_key_value);
            $shortened_permalink = $bitly_api->shorten($permalink);
            $update = $post_title . " $shortened_permalink";
        }
        
        MicroblogPoster_Poster::update_twitter($update);
        MicroblogPoster_Poster::update_plurk($update);
    }
    
    /**
    * Updates status on twitter
    *
    * @param   string  $update Text to be posted on microblogging site
    * @return  void
    */
    public static function update_twitter($update)
    {   
        $twitter_consumer_key_name = "microblogposter_plg_twitter_consumer_key";
        $twitter_consumer_secret_name = "microblogposter_plg_twitter_consumer_secret";
        $twitter_access_token_name = "microblogposter_plg_twitter_access_token";
        $twitter_access_token_secret_name = "microblogposter_plg_twitter_access_token_secret";
        
        $twitter_consumer_key_value = get_option($twitter_consumer_key_name, "");
        $twitter_consumer_secret_value = get_option($twitter_consumer_secret_name, "");
        $twitter_access_token_value = get_option($twitter_access_token_name, "");
        $twitter_access_token_secret_value = get_option($twitter_access_token_secret_name, "");
        
        if(!$twitter_consumer_key_value or
           !$twitter_consumer_secret_value or
           !$twitter_access_token_value or
           !$twitter_access_token_secret_value)
        {
            return;
        }
        
        MicroblogPoster_Poster::send_signed_request(
            $twitter_consumer_key_value,
            $twitter_consumer_secret_value,
            $twitter_access_token_value,
            $twitter_access_token_secret_value,
            "https://api.twitter.com/1/statuses/update.json",
            array("status"=>$update)
        );
        return;
        
    }
    
    /**
    * Updates status on plurk
    *
    * @param   string  $update Text to be posted on microblogging site
    * @return  void
    */
    public static function update_plurk($update)
    {   
        $plurk_consumer_key_name = "microblogposter_plg_plurk_consumer_key";
        $plurk_consumer_secret_name = "microblogposter_plg_plurk_consumer_secret";
        $plurk_access_token_name = "microblogposter_plg_plurk_access_token";
        $plurk_access_token_secret_name = "microblogposter_plg_plurk_access_token_secret";
        
        $plurk_consumer_key_value = get_option($plurk_consumer_key_name, "");
        $plurk_consumer_secret_value = get_option($plurk_consumer_secret_name, "");
        $plurk_access_token_value = get_option($plurk_access_token_name, "");
        $plurk_access_token_secret_value = get_option($plurk_access_token_secret_name, "");
        
        if(!$plurk_consumer_key_value or
           !$plurk_consumer_secret_value or
           !$plurk_access_token_value or
           !$plurk_access_token_secret_value)
        {
            return;
        }
        
        MicroblogPoster_Poster::send_signed_request(
            $plurk_consumer_key_value,
            $plurk_consumer_secret_value,
            $plurk_access_token_value,
            $plurk_access_token_secret_value,
            "http://www.plurk.com/APP/Timeline/plurkAdd",
            array("content"=>$update, "qualifier"=>"says")
        );
        return;
        
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
    
}


add_action('publish_post', array('MicroblogPoster_Poster', 'update'));

//Displays a checkbox that allows users to disable Microblog Poster on a per post basis.
function microblogposter_meta()
{
    ?>
    <input type="checkbox" id="microblogposteroff" name="microblogposteroff"/> 
    <label for="microblogposteroff">Disable Microblog Poster this time?</label>
    <?php
}

//Add the checkbox defined above to post edit screen.
function microblogposter_meta_box()
{
    add_meta_box('microblogposter_domain','Microblog Poster','microblogposter_meta','post','side','high');
}
add_action('admin_menu', 'microblogposter_meta_box');

//Options

require_once "microblogposter_options.php";


?>