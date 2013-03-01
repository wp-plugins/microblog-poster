<?php

add_action('admin_menu', 'microblogposter_settings');

function microblogposter_settings()
{
    
    add_submenu_page('options-general.php', 'MicroblogPoster Options', 'MicroblogPoster', 'administrator', 'microblogposter.php', 'microblogposter_settings_output');
    
}

function microblogposter_settings_output()
{
    //Options names
    
    $bitly_api_user_name = "microblogposter_plg_bitly_api_user";
    $bitly_api_key_name = "microblogposter_plg_bitly_api_key";
    
    $twitter_consumer_key_name = "microblogposter_plg_twitter_consumer_key";
    $twitter_consumer_secret_name = "microblogposter_plg_twitter_consumer_secret";
    $twitter_access_token_name = "microblogposter_plg_twitter_access_token";
    $twitter_access_token_secret_name = "microblogposter_plg_twitter_access_token_secret";
    
    $plurk_consumer_key_name = "microblogposter_plg_plurk_consumer_key";
    $plurk_consumer_secret_name = "microblogposter_plg_plurk_consumer_secret";
    $plurk_access_token_name = "microblogposter_plg_plurk_access_token";
    $plurk_access_token_secret_name = "microblogposter_plg_plurk_access_token_secret";
    
    $identica_username_name = "microblogposter_plg_identica_username";
    $identica_password_name = "microblogposter_plg_identica_password";
    
    $delicious_username_name = "microblogposter_plg_delicious_username";
    $delicious_password_name = "microblogposter_plg_delicious_password";
    
    
    $bitly_api_user_value = get_option($bitly_api_user_name, "");
    $bitly_api_key_value = get_option($bitly_api_key_name, "");
    
    $twitter_consumer_key_value = get_option($twitter_consumer_key_name, "");
    $twitter_consumer_secret_value = get_option($twitter_consumer_secret_name, "");
    $twitter_access_token_value = get_option($twitter_access_token_name, "");
    $twitter_access_token_secret_value = get_option($twitter_access_token_secret_name, "");
    
    $plurk_consumer_key_value = get_option($plurk_consumer_key_name, "");
    $plurk_consumer_secret_value = get_option($plurk_consumer_secret_name, "");
    $plurk_access_token_value = get_option($plurk_access_token_name, "");
    $plurk_access_token_secret_value = get_option($plurk_access_token_secret_name, "");
    
    $identica_username_value = get_option($identica_username_name, "");
    $identica_password_value = get_option($identica_password_name, "");
    
    $delicious_username_value = get_option($delicious_username_name, "");
    $delicious_password_value = get_option($delicious_password_name, "");
    
    if(isset($_POST["update_options"]))
    {
        
        $bitly_api_user_value = $_POST[$bitly_api_user_name];
        $bitly_api_key_value = $_POST[$bitly_api_key_name];
        
        $twitter_consumer_key_value = $_POST[$twitter_consumer_key_name];
        $twitter_consumer_secret_value = $_POST[$twitter_consumer_secret_name];
        $twitter_access_token_value = $_POST[$twitter_access_token_name];
        $twitter_access_token_secret_value = $_POST[$twitter_access_token_secret_name];
        
        $plurk_consumer_key_value = $_POST[$plurk_consumer_key_name];
        $plurk_consumer_secret_value = $_POST[$plurk_consumer_secret_name];
        $plurk_access_token_value = $_POST[$plurk_access_token_name];
        $plurk_access_token_secret_value = $_POST[$plurk_access_token_secret_name];
        
        $identica_username_value = $_POST[$identica_username_name];
        $identica_password_value = $_POST[$identica_password_name];
        
        $delicious_username_value = $_POST[$delicious_username_name];
        $delicious_password_value = $_POST[$delicious_password_name];
        
        update_option($bitly_api_user_name, $bitly_api_user_value);
        update_option($bitly_api_key_name, $bitly_api_key_value);
        
        update_option($twitter_consumer_key_name, $twitter_consumer_key_value);
        update_option($twitter_consumer_secret_name, $twitter_consumer_secret_value);
        update_option($twitter_access_token_name, $twitter_access_token_value);
        update_option($twitter_access_token_secret_name, $twitter_access_token_secret_value);
        
        update_option($plurk_consumer_key_name, $plurk_consumer_key_value);
        update_option($plurk_consumer_secret_name, $plurk_consumer_secret_value);
        update_option($plurk_access_token_name, $plurk_access_token_value);
        update_option($plurk_access_token_secret_name, $plurk_access_token_secret_value);
        
        update_option($identica_username_name, $identica_username_value);
        update_option($identica_password_name, $identica_password_value);
        
        update_option($delicious_username_name, $delicious_username_value);
        update_option($delicious_password_name, $delicious_password_value);
        
        ?>
        <div class="updated"><p><strong>Options saved.</strong></p></div>
        <?php
        
    }
    
    ?>
    
    <style>
        .form-table td
        {
            font-size: 10px;
            line-height: 1em;
            padding: 0 0 5px 0;
        }
    </style>
    
    <div class="wrap">
    <div id="icon-plugins" class="icon32"><br /></div>
    <h2>MicroblogPoster Settings</h2>
    <form name="options_form" method="post" action="">
        <table class="form-table">
            <tr>
                <td colspan="2">
                    <h3>Your Bitly Credentials: <span class="description">Help: Search for 'bitly api key'</span></h3>
                    
                </td>
            </tr>
            <tr>
                <td>Bitly API User:</td>
                <td><input type="text" id="<?php echo $bitly_api_user_name;?>" name="<?php echo $bitly_api_user_name;?>" value="<?php echo $bitly_api_user_value;?>" size="30" /></td>
            </tr>
            <tr>
                <td>Bitly API Key:</td>
                <td><input type="text" id="<?php echo $bitly_api_key_name;?>" name="<?php echo $bitly_api_key_name;?>" value="<?php echo $bitly_api_key_value;?>" size="30" /></td>
            </tr>
            
            <tr>
                <td colspan="2"><h3>Your Twitter OAuth Credentials: <span class="description">Help: Search for 'create an application twitter api'</span></h3></td>
            </tr>
            <tr>
                <td>Consumer Key:</td>
                <td>
                    <input type="text" id="<?php echo $twitter_consumer_key_name;?>" name="<?php echo $twitter_consumer_key_name;?>" value="<?php echo $twitter_consumer_key_value;?>" size="45" />
                    <span class="description">Your Twitter Application Consumer Key.</span>
                </td>
            </tr>
            <tr>
                 <td>Consumer Secret:</td>
                <td>
                    <input type="text" id="<?php echo $twitter_consumer_secret_name;?>" name="<?php echo $twitter_consumer_secret_name;?>" value="<?php echo $twitter_consumer_secret_value;?>" size="45" />
                    <span class="description">Your Twitter Application Consumer Secret.</span>
                </td>
            </tr>
            <tr>
                 <td>Access Token:</td>
                <td>
                    <input type="text" id="<?php echo $twitter_access_token_name;?>" name="<?php echo $twitter_access_token_name;?>" value="<?php echo $twitter_access_token_value;?>" size="45" />
                    <span class="description">Your Twitter Account Access Token</span>
                </td>
            </tr>
            <tr>
                 <td>Access Token Secret:</td>
                <td>
                    <input type="text" id="<?php echo $twitter_access_token_secret_name;?>" name="<?php echo $twitter_access_token_secret_name;?>" value="<?php echo $twitter_access_token_secret_value;?>" size="45" />
                    <span class="description">Your Twitter Account Access Token Secret</span>
                </td>
            </tr>
            
            <tr>
                <td colspan="2"><h3>Your Plurk OAuth Credentials: <span class="description">Help: Search for 'create an application plurk api'</span></h3></td>
            </tr>
            <tr>
                <td>Consumer Key:</td>
                <td>
                    <input type="text" id="<?php echo $plurk_consumer_key_name;?>" name="<?php echo $plurk_consumer_key_name;?>" value="<?php echo $plurk_consumer_key_value;?>" size="45" />
                    <span class="description">Your Plurk Application Consumer Key.</span>
                </td>
            </tr>
            <tr>
                 <td>Consumer Secret:</td>
                <td>
                    <input type="text" id="<?php echo $plurk_consumer_secret_name;?>" name="<?php echo $plurk_consumer_secret_name;?>" value="<?php echo $plurk_consumer_secret_value;?>" size="45" />
                    <span class="description">Your Plurk Application Consumer Secret.</span>
                </td>
            </tr>
            <tr>
                 <td>Access Token:</td>
                <td>
                    <input type="text" id="<?php echo $plurk_access_token_name;?>" name="<?php echo $plurk_access_token_name;?>" value="<?php echo $plurk_access_token_value;?>" size="45" />
                    <span class="description">Your Plurk Account Access Token</span>
                </td>
            </tr>
            <tr>
                 <td>Access Token Secret:</td>
                <td>
                    <input type="text" id="<?php echo $plurk_access_token_secret_name;?>" name="<?php echo $plurk_access_token_secret_name;?>" value="<?php echo $plurk_access_token_secret_value;?>" size="45" />
                    <span class="description">Your Plurk Account Access Token Secret</span>
                </td>
            </tr>
            
            <tr>
                <td colspan="2">
                    <h3>Your Identi.ca Credentials</h3>
                    
                </td>
            </tr>
            <tr>
                <td>Identi.ca Username:</td>
                <td><input type="text" id="<?php echo $identica_username_name;?>" name="<?php echo $identica_username_name;?>" value="<?php echo $identica_username_value;?>" size="30" /></td>
            </tr>
            <tr>
                <td>Identi.ca Password:</td>
                <td><input type="text" id="<?php echo $identica_password_name;?>" name="<?php echo $identica_password_name;?>" value="<?php echo $identica_password_value;?>" size="30" /></td>
            </tr>
            
            <tr>
                <td colspan="2">
                    <h3>Your Delicious Credentials</h3>
                    
                </td>
            </tr>
            <tr>
                <td>Delicious Username:</td>
                <td><input type="text" id="<?php echo $delicious_username_name;?>" name="<?php echo $delicious_username_name;?>" value="<?php echo $delicious_username_value;?>" size="30" /></td>
            </tr>
            <tr>
                <td>Delicious Password:</td>
                <td><input type="text" id="<?php echo $delicious_password_name;?>" name="<?php echo $delicious_password_name;?>" value="<?php echo $delicious_password_value;?>" size="30" /></td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="update_options" class="button-primary" value="Update Options" />
        </p>
    </form>
    </div>
    <?php
    
}
?>