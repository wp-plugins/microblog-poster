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
    $bitly_api_user_name = "microblogposter_plg_bitly_api_user";
    $bitly_api_key_name = "microblogposter_plg_bitly_api_key";
    $default_behavior_name = "microblogposter_default_behavior";
    $default_behavior_update_name = "microblogposter_default_behavior_update";
    $default_pbehavior_name = "microblogposter_default_pbehavior";
    $default_pbehavior_update_name = "microblogposter_default_pbehavior_update";
    $page_mode_name = "microblogposter_page_mode";
    
    
    $bitly_api_user_value = get_option($bitly_api_user_name, "");
    $bitly_api_key_value = get_option($bitly_api_key_name, "");
    $default_behavior_value = get_option($default_behavior_name, "");
    $default_behavior_update_value = get_option($default_behavior_update_name, "");
    $default_pbehavior_value = get_option($default_pbehavior_name, "");
    $default_pbehavior_update_value = get_option($default_pbehavior_update_name, "");
    $page_mode_value = get_option($page_mode_name, "");
    
    
    if(isset($_POST["update_options"]))
    {
        $bitly_api_user_value = $_POST[$bitly_api_user_name];
        $bitly_api_key_value = $_POST[$bitly_api_key_name];
        $default_behavior_value = $_POST[$default_behavior_name];
        $default_behavior_update_value = $_POST[$default_behavior_update_name];
        $default_pbehavior_value = $_POST[$default_pbehavior_name];
        $default_pbehavior_update_value = $_POST[$default_pbehavior_update_name];
        $page_mode_value = $_POST[$page_mode_name];
        
        update_option($bitly_api_user_name, $bitly_api_user_value);
        update_option($bitly_api_key_name, $bitly_api_key_value);
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
        
        ?>
        <div class="updated"><p><strong>Options saved.</strong></p></div>
        <?php
        
    }
    
    $http_auth_sites = array('identica','friendfeed','delicious','diigo');
    $tags_sites = array('delicious','diigo');
    
    $mbp_accounts_tab_selected = false;
    
    if(isset($_POST["new_account_hidden"]))
    {
        $mbp_accounts_tab_selected = true;
        
        if(isset($_POST['account_type']))
        {
            $account_type = trim($_POST['account_type']);
        }
        if(in_array($account_type, $tags_sites))
        {
            $extra['include_tags'] = 0;
            if(isset($_POST['include_tags']) && trim($_POST['include_tags']) == '1')
            {
                $extra['include_tags'] = 1;
            }
        }
        if($account_type=='diigo')
        {
            if(isset($_POST['api_key']))
            {
                $extra['api_key'] = trim($_POST['api_key']);
            }
        }
        if(isset($_POST['consumer_key']))
        {
            $consumer_key = trim($_POST['consumer_key']);
        }
        if(isset($_POST['consumer_secret']))
        {
            $consumer_secret = trim($_POST['consumer_secret']);
        }
        if(isset($_POST['access_token']))
        {
            $access_token = trim($_POST['access_token']);
        }
        if(isset($_POST['access_token_secret']))
        {
            $access_token_secret = trim($_POST['access_token_secret']);
        }
        if(isset($_POST['username']))
        {
            $username = trim($_POST['username']);
        }
        if(isset($_POST['password']))
        {
            $password = trim($_POST['password']);
            if(in_array($account_type, $http_auth_sites))
            {
                $password = stripslashes($password);
                $password = MicroblogPoster_SupportEnc::enc($password);
                $extra['penc'] = 1;
                $extra = json_encode($extra);
                $wpdb->escape_by_ref($extra);
            }
            
        }
        if(isset($_POST['facebook_profile_url']))
        {
            $password = trim($_POST['facebook_profile_url']);
        }
        if(isset($_POST['message_format']))
        {
            $message_format = trim($_POST['message_format']);
        }
        
        if($username)
        {
            $sql = "INSERT IGNORE INTO {$table_accounts} 
                (username,password,consumer_key,consumer_secret,access_token,access_token_secret,type,message_format,extra)
                VALUES
                ('$username','$password','$consumer_key','$consumer_secret','$access_token','$access_token_secret','$account_type','$message_format','$extra')";

            $wpdb->query($sql);
        }
        
        
        ?>
        <div class="updated"><p><strong>Account added successfully.</strong></p></div>
        <?php
    }
    
    if(isset($_POST["update_account_hidden"]))
    {
        $mbp_accounts_tab_selected = true;
        
        if(isset($_POST['account_id']))
        {
            $account_id = trim($_POST['account_id']);
        }
        $sql="SELECT * FROM $table_accounts WHERE account_id={$account_id} LIMIT 1";
        $rows = $wpdb->get_results($sql);
        $current_account = $rows[0];
        
        $extra = array();
        if(isset($current_account->extra) && $current_account->extra)
        {
            $extra = json_decode($current_account->extra, true);
        }
        
        if(isset($_POST['account_type']))
        {
            $account_type = trim($_POST['account_type']);
        }
        if(in_array($account_type, $tags_sites))
        {
            $extra['include_tags'] = 0;
            if(isset($_POST['include_tags']) && trim($_POST['include_tags']) == '1')
            {
                $extra['include_tags'] = 1;
            }
        }
        if($account_type=='diigo')
        {
            if(isset($_POST['api_key']))
            {
                $extra['api_key'] = trim($_POST['api_key']);
            }
        }
        if(isset($_POST['consumer_key']))
        {
            $consumer_key = trim($_POST['consumer_key']);
        }
        if(isset($_POST['consumer_secret']))
        {
            $consumer_secret = trim($_POST['consumer_secret']);
        }
        if(isset($_POST['access_token']))
        {
            $access_token = trim($_POST['access_token']);
        }
        if(isset($_POST['access_token_secret']))
        {
            $access_token_secret = trim($_POST['access_token_secret']);
        }
        if(isset($_POST['username']))
        {
            $username = trim($_POST['username']);
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
        if(isset($_POST['facebook_profile_url']))
        {
            $password = trim($_POST['facebook_profile_url']);
        }
        if(isset($_POST['message_format']))
        {
            $message_format = trim($_POST['message_format']);
        }
        
        $extra = json_encode($extra);
        $wpdb->escape_by_ref($extra);
        
        if($username)
        {
            $sql = "UPDATE {$table_accounts}
                SET username='{$username}',
                password='{$password}',
                consumer_key='{$consumer_key}',
                consumer_secret='{$consumer_secret}',
                access_token='{$access_token}',
                access_token_secret='{$access_token_secret}',
                message_format='{$message_format}',
                extra='{$extra}'";
            
            $sql .= " WHERE account_id={$account_id}";

            $wpdb->query($sql);
        }
        
        
        ?>
        <div class="updated"><p><strong>Account updated successfully.</strong></p></div>
        <?php
    }
    
    if(isset($_POST["delete_account_hidden"]))
    {
        $mbp_accounts_tab_selected = true;
        
        if(isset($_POST['account_id']))
        {
            $account_id = trim($_POST['account_id']);
            $wpdb->escape_by_ref($account_id);
        }
        
        $sql = "DELETE FROM {$table_accounts}
            WHERE account_id={$account_id}";
        
        $wpdb->query($sql);
        
        ?>
        <div class="updated"><p><strong>Account deleted successfully.</strong></p></div>
        <?php
    }
    
    // Facebook accounts authorization process
    
    $server_name = $_SERVER['SERVER_NAME'];
    $request_uri = $_SERVER['REQUEST_URI'];
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off')?'https':'http';
    $redirect_uri = $protocol.'://'.$server_name.$request_uri;
    $code = null;
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
                $sql="SELECT * FROM $table_accounts WHERE account_id={$auth_user_id}";
                $rows = $wpdb->get_results($sql);
                $row = $rows[0];
                $extra = json_decode($row->extra, true);

                if($code)
                {
                    $access_url = "https://graph.facebook.com/oauth/access_token?client_id={$row->consumer_key}&client_secret={$row->consumer_secret}&redirect_uri={$redirect_uri}&code={$code}";
                    $account_details = array();
                    $response = file_get_contents($access_url);
                    parse_str($response, $params);
                    $account_details['access_token'] = $params['access_token'];
                    $account_details['expires'] = time()+$params['expires'];


                    $user_url = "https://graph.facebook.com/me?fields=id,first_name,last_name&access_token={$params['access_token']}";
                    $response = file_get_contents($user_url);
                    $params1 = json_decode($response, true);
                    if(isset($params1['first_name']) && isset($params1['last_name']))
                    {
                        $account_details['user_id'] = $params1['id'];
                    }

                    $account_details = json_encode($account_details);
                    $wpdb->escape_by_ref($account_details);
                }

                $sql = "UPDATE {$table_accounts}
                    SET extra='{$account_details}'
                    WHERE account_id={$auth_user_id}";

                $wpdb->query($sql);
            }
            
            
        }
    }
    
    
    
    ?>
    
   
    
    <div class="wrap">
        <div id="icon-plugins" class="icon32"><br /></div>
        <h2><span class="microblogposter-name">MicroblogPoster</span> Settings</h2>
        
        <p>
            The idea behind <span class="microblogposter-name">MicroblogPoster</span> is to promote your wordpress blog
            and reach more people through social networks. <span class="microblogposter-name">MicroblogPoster</span> is 
            simply an intermediary between your blog and your own social network accounts. 
            You'll never see "posted by MicroblogPoster" in your updates, you'll see "posted by your own App name" 
            or simply "by API".
        </p>
        
        <div id="mbp-menu-wrapper">
            <ul id="mbp-menu">
                <li id="mbp-general-tab" class="mbp-tab-background mbp-tab-first">General Options</li><!--
             --><li id="mbp-accounts-tab" class="mbp-tab-background">Social Networks Accounts</li><!--
             --><li id="mbp-logs-tab" class="mbp-tab-background mbp-tab-last">Logs/History</li>
            </ul> 
        </div>
        
        <div id="mbp-general-section">
            <h3 id="general-header">General Section:</h3>
            <form name="options_form" method="post" action="">
                <table class="form-table">
                    <tr>
                        <td colspan="2">
                            <h3>Your Bitly Credentials: <span class="description">Help: Search for 'bitly api key'</span></h3>

                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left">Bitly API User:</td>
                        <td><input type="text" id="<?php echo $bitly_api_user_name;?>" name="<?php echo $bitly_api_user_name;?>" value="<?php echo $bitly_api_user_value;?>" size="35" /></td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left">Bitly API Key:</td>
                        <td><input type="text" id="<?php echo $bitly_api_key_name;?>" name="<?php echo $bitly_api_key_name;?>" value="<?php echo $bitly_api_key_value;?>" size="35" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="row-sep"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h3><span class="wp-blue-title">Posts :</span></h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="padding-left">
                            <h3>Default per NEW POST behavior (changeable on a per post basis):</h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left1">Don't cross-post automatically:</td>
                        <td><input type="checkbox" id="microblogposter_default_behavior" name="microblogposter_default_behavior" value="1" <?php if($default_behavior_value) echo 'checked="checked"';?> /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="padding-left">
                            <h3>Default per POST UPDATE behavior (changeable on a per post basis):</h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left1">Don't cross-post automatically:</td>
                        <td><input type="checkbox" id="microblogposter_default_behavior_update" name="microblogposter_default_behavior_update" value="1" <?php if($default_behavior_update_value) echo 'checked="checked"';?> />&nbsp;&nbsp;(This is most likely to be checked.)</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="row-sep"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h3><span class="wp-blue-title">Pages :</span></h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input">Enable <span class="microblogposter-name">MicroblogPoster</span> for pages:</td>
                        <td><input type="checkbox" id="microblogposter_page_mode" name="microblogposter_page_mode" value="1" <?php if($page_mode_value) echo 'checked="checked"';?> /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="padding-left">
                            <h3>Default per NEW PAGE behavior (changeable on a per page basis):</h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left1">Don't cross-post automatically:</td>
                        <td><input type="checkbox" id="microblogposter_default_pbehavior" name="microblogposter_default_pbehavior" value="1" <?php if($default_pbehavior_value) echo 'checked="checked"';?> /></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="padding-left">
                            <h3>Default per PAGE UPDATE behavior (changeable on a per page basis):</h3>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-input padding-left1">Don't cross-post automatically:</td>
                        <td><input type="checkbox" id="microblogposter_default_pbehavior_update" name="microblogposter_default_pbehavior_update" value="1" <?php if($default_pbehavior_update_value) echo 'checked="checked"';?> />&nbsp;&nbsp;(This is most likely to be checked.)</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="row-sep"></td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" name="update_options" class="update-options button" value="Update Options" />
                </p>
            </form>
        </div>
        
        <div id="mbp-social-networks-accounts">
        <h3 id="network-accounts-header">Social Network Accounts Section:</h3>
        
        <?php
        $sql="SELECT count(*) as count FROM $table_accounts";
        $rows = $wpdb->get_results($sql, ARRAY_A);
        if($rows[0]['count'] > 10)
        {
            ?>
            <div class="mbp-warning">
                <p>
                    <strong>Warning: </strong><br /> 
                    If your blog is hosted on a shared hosting please take a look at our FAQ :&nbsp;
                    <a href="http://wordpress.org/extend/plugins/microblog-poster/faq/" target="_blank">MicroblogPoster FAQ page</a><br />
                    Wordpress blogs on VPS, Cloud, Dedicated or Managed servers are not impacted.
                </p>
            </div>
            <?php
        }
        ?>
        
        <span class="new-account" >Add New Account</span>
            
        <?php 
        
        $update_accounts = array();
        ?>
        
        <div id="social-network-accounts">
        <div class="social-network-accounts-site">
            <img src="../wp-content/plugins/microblog-poster/images/twitter_icon.png" />
            <h4>Twitter Accounts</h4>
        </div>
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='twitter'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        
                        <h3 class="new-account-header"><span class="microblogposter-name">MicroblogPoster</span> Plugin</h3>
                        <div class="delete-wrapper">
                            Twitter Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="twitter-div" class="one-account">
                            <div class="input-div">
                                Username:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="username" name="username" value="<?php echo $row->username;?>"/>
                            </div>
                            <div class="input-div">
                                Message Format:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="message_format" name="message_format" value="<?php echo $row->message_format;?>"/>
                                <span class="description">Message that's actually posted.</span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post. {URL} = The blog post url. {SHORT_URL} = The blog post shortened url.</span>
                            </div>
                            <div class="input-div">
                                Consumer Key:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="<?php echo $row->consumer_key;?>" />
                                <span class="description">Your Twitter Application Consumer Key.</span>
                            </div>
                            <div class="input-div">
                                Consumer Secret:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="<?php echo $row->consumer_secret;?>" />
                                <span class="description">Your Twitter Application Consumer Secret.</span>
                            </div>
                            <div class="input-div">
                                Access Token:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="access_token" value="<?php echo $row->access_token;?>" />
                                <span class="description">Your Twitter Account Access Token</span>
                            </div>
                            <div class="input-div">
                                Access Token Secret:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="access_token_secret" value="<?php echo $row->access_token_secret;?>" />
                                <span class="description">Your Twitter Account Access Token Secret</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="twitter" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        Twitter Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del">Delete?</span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="twitter" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="del-account-fb button del-account<?php echo $row->account_id;?>" >Delete</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>">Edit</span>
                <span class="del-account del<?php echo $row->account_id;?>">Del</span>
            </div>
            
        <?php endforeach;?>
        
        <div class="social-network-accounts-site">
            <img src="../wp-content/plugins/microblog-poster/images/plurk_icon.png" />
            <h4>Plurk Accounts</h4>
        </div>
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='plurk'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <h3 class="new-account-header"><span class="microblogposter-name">MicroblogPoster</span> Plugin</h3>
                        <div class="delete-wrapper">
                            Plurk Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="plurk-div" class="one-account">
                            <div class="input-div">
                                Username:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="username" name="username" value="<?php echo $row->username;?>"/>
                            </div>
                            <div class="input-div">
                                Message Format:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="message_format" name="message_format" value="<?php echo $row->message_format;?>"/>
                                <span class="description">Message that's actually posted.</span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post. {URL} = The blog post url. {SHORT_URL} = The blog post shortened url.</span>
                            </div>
                            <div class="input-div">
                                Consumer Key:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="<?php echo $row->consumer_key;?>" />
                                <span class="description">Your Plurk Application Consumer Key.</span>
                            </div>
                            <div class="input-div">
                                Consumer Secret:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="<?php echo $row->consumer_secret;?>" />
                                <span class="description">Your Plurk Application Consumer Secret.</span>
                            </div>
                            <div class="input-div">
                                Access Token:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="access_token" value="<?php echo $row->access_token;?>" />
                                <span class="description">Your Plurk Account Access Token</span>
                            </div>
                            <div class="input-div">
                                Access Token Secret:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="access_token_secret" value="<?php echo $row->access_token_secret;?>" />
                                <span class="description">Your Plurk Account Access Token Secret</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="plurk" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        Plurk Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del">Delete?</span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="plurk" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="del-account-fb button del-account<?php echo $row->account_id;?>" >Delete</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>">Edit</span>
                <span class="del-account del<?php echo $row->account_id;?>">Del</span>
            </div>
            
        <?php endforeach;?>
        
        <div class="social-network-accounts-site">
            <img src="../wp-content/plugins/microblog-poster/images/identica_icon.png" />
            <h4>Identica Accounts</h4>
        </div>   
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='identica'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
            $is_raw = MicroblogPoster_SupportEnc::is_enc($row->extra);
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <h3 class="new-account-header"><span class="microblogposter-name">MicroblogPoster</span> Plugin</h3>
                        <div class="delete-wrapper">
                            Identica Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="identica-div" class="one-account">
                            <div class="input-div">
                                Identi.ca Username:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="username" value="<?php echo $row->username;?>" />
                            </div>
                            <div class="input-div">
                                Identi.ca Password:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="password" value="<?php echo ($is_raw)? $row->password : MicroblogPoster_SupportEnc::dec($row->password);?>" />
                            </div>
                            <div class="input-div">
                                Message Format:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="message_format" name="message_format" value="<?php echo $row->message_format;?>"/>
                                <span class="description">Message that's actually posted.</span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post. {URL} = The blog post url. {SHORT_URL} = The blog post shortened url.</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="identica" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        Identica Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del">Delete?</span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="identica" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="del-account-fb button del-account<?php echo $row->account_id;?>" >Delete</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>">Edit</span>
                <span class="del-account del<?php echo $row->account_id;?>">Del</span>
            </div>
        <?php endforeach;?>
        
        <div class="social-network-accounts-site">
            <img src="../wp-content/plugins/microblog-poster/images/friendfeed_icon.png" />
            <h4>FriendFeed Accounts</h4>
        </div>    
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='friendfeed'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
            $is_raw = MicroblogPoster_SupportEnc::is_enc($row->extra);
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <h3 class="new-account-header"><span class="microblogposter-name">MicroblogPoster</span> Plugin</h3>
                        <div class="delete-wrapper">
                            FriendFeed Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="friendfeed-div" class="one-account">
                            <div class="input-div">
                                FriendFeed Username:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="username" value="<?php echo $row->username;?>" />
                            </div>
                            <div class="input-div">
                                FriendFeed Remote Key:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="password" value="<?php echo ($is_raw)? $row->password : MicroblogPoster_SupportEnc::dec($row->password);?>" />
                            </div>
                            <div class="input-div">
                                Message Format:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="message_format" name="message_format" value="<?php echo $row->message_format;?>"/>
                                <span class="description">Message that's actually posted.</span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post.</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="friendfeed" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        FriendFeed Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del">Delete?</span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="friendfeed" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="del-account-fb button del-account<?php echo $row->account_id;?>" >Delete</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>">Edit</span>
                <span class="del-account del<?php echo $row->account_id;?>">Del</span>
            </div>
        <?php endforeach;?>
        
        <div class="social-network-accounts-site">
            <img src="../wp-content/plugins/microblog-poster/images/delicious_icon.png" />
            <h4>Delicious Accounts</h4>
        </div>  
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='delicious'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
            $is_raw = MicroblogPoster_SupportEnc::is_enc($row->extra);
            $extra = json_decode($row->extra, true);
            if(is_array($extra))
            {
                $include_tags = (isset($extra['include_tags']) && $extra['include_tags'] == 1)?true:false;
            }
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <h3 class="new-account-header"><span class="microblogposter-name">MicroblogPoster</span> Plugin</h3>
                        <div class="delete-wrapper">
                            Delicious Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="delicious-div" class="one-account">
                            <div class="input-div">
                                Delicious Username:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="username" value="<?php echo $row->username;?>" />
                            </div>
                            <div class="input-div">
                                Delicious Password:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="password" value="<?php echo ($is_raw)? $row->password : MicroblogPoster_SupportEnc::dec($row->password);?>" />
                            </div>
                            <div class="input-div">
                                Message Format:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="message_format" name="message_format" value="<?php echo $row->message_format;?>"/>
                                <span class="description">Message that's actually posted.</span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post.</span>
                            </div>
                            <div class="input-div">
                                Include tags:
                            </div>
                            <div class="input-div-large">
                                <input type="checkbox" id="include_tags" name="include_tags" value="1" <?php if ($include_tags) echo "checked";?>/>
                                <span class="description">Do you want to include tags in the bookmarks?</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="delicious" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        Delicious Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del">Delete?</span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="delicious" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="del-account-fb button del-account<?php echo $row->account_id;?>" >Delete</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>">Edit</span>
                <span class="del-account del<?php echo $row->account_id;?>">Del</span>
            </div>
        <?php endforeach;?>
        
        <div class="social-network-accounts-site">
            <img src="../wp-content/plugins/microblog-poster/images/facebook_icon.png" />
            <h4>Facebook Accounts</h4>
        </div>
        <?php
        $sql="SELECT * FROM $table_accounts WHERE type='facebook'";
        $rows = $wpdb->get_results($sql);
        foreach($rows as $row):
            $update_accounts[] = $row->account_id;
            $authorize_url = "http://www.facebook.com/dialog/oauth/?client_id={$row->consumer_key}&redirect_uri={$redirect_uri}&state=microblogposter_{$row->account_id}&scope=publish_actions";
            
            $fb_acc_extra = null;
            if($row->extra)
            {
                $fb_acc_extra = json_decode($row->extra, true);
                
            }
            
        ?>
            <div style="display:none">
                <div id="update_account<?php echo $row->account_id;?>">
                    <form id="update_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        
                        <h3 class="new-account-header"><span class="microblogposter-name">MicroblogPoster</span> Plugin</h3>
                        <div class="delete-wrapper">
                            Facebook Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="facebook-div" class="one-account">
                            <div class="input-div">
                                Username:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="username" name="username" value="<?php echo $row->username;?>"/>
                            </div>
                            <div class="input-div">
                                Facebook profile URL:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="facebook_profile_url" value="<?php echo $row->password;?>" />
                                <span class="description">Your Facebook profile URL.</span>
                            </div>
                            <div class="input-div">
                                Message Format:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="message_format" name="message_format" value="<?php echo $row->message_format;?>"/>
                                <span class="description">Message that's actually posted.</span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post. {URL} = The blog post url. {SHORT_URL} = The blog post shortened url.</span>
                            </div>
                            <div class="input-div">
                                Application ID/API Key:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_key" value="<?php echo $row->consumer_key;?>" />
                                <span class="description">Your Facebook Application ID/API Key.</span>
                            </div>
                            <div class="input-div">
                                Application Secret:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="consumer_secret" value="<?php echo $row->consumer_secret;?>" />
                                <span class="description">Your Facebook Application Secret.</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="facebook" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        Twitter Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del">Delete?</span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="facebook" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="del-account-fb button del-account<?php echo $row->account_id;?>" >Delete</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>">Edit</span>
                <span class="del-account del<?php echo $row->account_id;?>">Del</span>
                <?php if(isset($fb_acc_extra['access_token']) && $fb_acc_extra['access_token']):?>
                <div>Authorization is valid until <?php echo date('d-m-Y', $fb_acc_extra['expires']); ?></div>
                <div><a href="<?php echo $authorize_url; ?>" >Refresh authorization now</a></div>
                <?php else:?>
                <div><a href="<?php echo $authorize_url; ?>" >Authorize this facebook account</a></div>
                <?php endif;?>
            </div>
            
        <?php endforeach;?>
            
        <div class="social-network-accounts-site">
            <img src="../wp-content/plugins/microblog-poster/images/diigo_icon.png" />
            <h4>Diigo Accounts</h4>
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
                        <h3 class="new-account-header"><span class="microblogposter-name">MicroblogPoster</span> Plugin</h3>
                        <div class="delete-wrapper">
                            Diigo Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span>
                        </div>
                        <div id="diigo-div" class="one-account">
                            <div class="input-div">
                                Diigo Username:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="username" value="<?php echo $row->username;?>" />
                            </div>
                            <div class="input-div">
                                Diigo Password:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="password" value="<?php echo ($is_raw)? $row->password : MicroblogPoster_SupportEnc::dec($row->password);?>" />
                            </div>
                            <div class="input-div">
                                Diigo API Key:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="" name="api_key" value="<?php echo $api_key;?>" />
                            </div>
                            <div class="input-div">
                                Message Format:
                            </div>
                            <div class="input-div-large">
                                <input type="text" id="message_format" name="message_format" value="<?php echo $row->message_format;?>"/>
                                <span class="description">Message that's actually posted.</span>
                            </div>
                            <div class="input-div">

                            </div>
                            <div class="input-div-large">
                                <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post.</span>
                            </div>
                            <div class="input-div">
                                Include tags:
                            </div>
                            <div class="input-div-large">
                                <input type="checkbox" id="include_tags" name="include_tags" value="1" <?php if ($include_tags) echo "checked";?>/>
                                <span class="description">Do you want to include tags in the bookmarks?</span>
                            </div>
                        </div>

                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="diigo" />
                        <input type="hidden" name="update_account_hidden" value="1" />
                        <div class="button-holder">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="button-primary save-account<?php echo $row->account_id;?>" >Save</button>
                        </div>

                    </form>
                </div>
            </div>
            <div style="display:none">
                <div id="delete_account<?php echo $row->account_id;?>">
                    <form id="delete_account_form<?php echo $row->account_id;?>" method="post" action="" enctype="multipart/form-data" >
                        <div class="delete-wrapper">
                        Delicious Account: <span class="delete-wrapper-user"><?php echo $row->username;?></span><br />
                        <span class="delete-wrapper-del">Delete?</span>
                        </div>
                        <input type="hidden" name="account_id" value="<?php echo $row->account_id;?>" />
                        <input type="hidden" name="account_type" value="diigo" />
                        <input type="hidden" name="delete_account_hidden" value="1" />
                        <div class="button-holder-del">
                            <button type="button" class="button cancel-account" >Cancel</button>
                            <button type="button" class="del-account-fb button del-account<?php echo $row->account_id;?>" >Delete</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account-wrapper">
                <span class="account-username"><?php echo $row->username;?></span>
                <span class="edit-account edit<?php echo $row->account_id;?>">Edit</span>
                <span class="del-account del<?php echo $row->account_id;?>">Del</span>
            </div>
        <?php endforeach;?>
        </div>
        
        
        
        <div style="display:none">
            <div id="new_account">
                <form id="new_account_form" method="post" action="" enctype="multipart/form-data" >

                    <h3 class="new-account-header"><span class="microblogposter-name">MicroblogPoster</span> Plugin</h3>
                    <div id="account_type_wrapper">
                    <label for="account_type" class="label-account-type">Account type:</label>
                    <select id="account_type" name="account_type">
                        <option value="twitter">Twitter</option>
                        <option value="plurk">Plurk</option>
                        <option value="identica">Identi.ca</option>
                        <option value="friendfeed">FriendFeed</option>
                        <option value="delicious">Delicious</option>
                        <option value="facebook">Facebook</option>
                        <option value="diigo">Diigo</option>
                    </select> 
                    </div>


                    <div id="twitter-div" class="one-account">
                        <div class="help-div"><span class="description">Help: <a href="http://wordpress.org/extend/plugins/microblog-poster/installation/" target="_blank">MicroblogPoster installation page</a></span></div>
                        <div class="input-div">
                            Username:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" />
                        </div>
                        <div class="input-div">
                            Message Format:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="message_format" name="message_format" />
                            <span class="description">Message that's actually posted.</span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post. {URL} = The blog post url. {SHORT_URL} = The blog post shortened url.</span>
                        </div>
                        <div class="input-div">
                            Consumer Key:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_key" value="" />
                            <span class="description">Your Twitter Application Consumer Key.</span>
                        </div>
                        <div class="input-div">
                            Consumer Secret:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_secret" value="" />
                            <span class="description">Your Twitter Application Consumer Secret.</span>
                        </div>
                        <div class="input-div">
                            Access Token:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="access_token" value="" />
                            <span class="description">Your Twitter Account Access Token</span>
                        </div>
                        <div class="input-div">
                            Access Token Secret:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="access_token_secret" value="" />
                            <span class="description">Your Twitter Account Access Token Secret</span>
                        </div>
                    </div>
                    <div id="plurk-div" class="one-account">
                        <div class="help-div"><span class="description">Help: <a href="http://wordpress.org/extend/plugins/microblog-poster/installation/" target="_blank">MicroblogPoster installation page</a></span></div>
                        <div class="input-div">
                            Username:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                        </div>
                        <div class="input-div">
                            Message Format:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="message_format" name="message_format" />
                            <span class="description">Message that's actually posted.</span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post. {URL} = The blog post url. {SHORT_URL} = The blog post shortened url.</span>
                        </div>
                        <div class="input-div">
                            Consumer Key:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_key" value="" />
                            <span class="description">Your Plurk Application Consumer Key.</span>
                        </div>
                        <div class="input-div">
                            Consumer Secret:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_secret" value="" />
                            <span class="description">Your Plurk Application Consumer Secret.</span>
                        </div>
                        <div class="input-div">
                            Access Token:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="access_token" value="" />
                            <span class="description">Your Plurk Account Access Token</span>
                        </div>
                        <div class="input-div">
                            Access Token Secret:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="access_token_secret" value="" />
                            <span class="description">Your Plurk Account Access Token Secret</span>
                        </div>
                    </div>
                    <div id="identica-div" class="one-account">
                        <div class="input-div">
                            Identi.ca Username:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                        </div>
                        <div class="input-div">
                            Identi.ca Password:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="password" value="" />
                        </div>
                        <div class="input-div">
                            Message Format:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="message_format" name="message_format" />
                            <span class="description">Message that's actually posted.</span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post. {URL} = The blog post url. {SHORT_URL} = The blog post shortened url.</span>
                        </div>
                    </div>
                    <div id="friendfeed-div" class="one-account">
                        <div class="help-div"><span class="description">Help: <a href="http://wordpress.org/extend/plugins/microblog-poster/installation/" target="_blank">MicroblogPoster installation page</a></span></div>
                        <div class="input-div">
                            FriendFeed Username:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                        </div>
                        <div class="input-div">
                            FriendFeed Remote Key:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="password" value="" />
                            <span class="description">Your FriendFeed Remote Key not password.</span>
                        </div>
                        <div class="input-div">
                            Message Format:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="message_format" name="message_format" />
                            <span class="description">Message that's actually posted.</span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post.</span>
                        </div>
                    </div>
                    <div id="delicious-div" class="one-account">
                        <div class="input-div">
                            Delicious Username:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                        </div>
                        <div class="input-div">
                            Delicious Password:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="password" value="" />
                        </div>
                        <div class="input-div">
                            Message Format:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="message_format" name="message_format" />
                            <span class="description">Message that's actually posted.</span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post.</span>
                        </div>
                        <div class="input-div">
                            Include tags:
                        </div>
                        <div class="input-div-large">
                            <input type="checkbox" id="include_tags" name="include_tags" value="1"/>
                            <span class="description">Do you want to include tags in the bookmarks?</span>
                        </div>
                    </div>
                    <div id="facebook-div" class="one-account">
                        <div class="help-div"><span class="description">Help: <a href="http://wordpress.org/extend/plugins/microblog-poster/installation/" target="_blank">MicroblogPoster installation page</a></span></div>
                        <div class="input-div">
                            Username:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                            <span class="description">Easily identify it later, not used for posting.</span>
                        </div>
                        <div class="input-div">
                            Facebook profile URL:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="facebook_profile_url" value="" />
                            <span class="description">Your Facebook profile URL.</span>
                        </div>
                        <div class="input-div">
                            Message Format:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="message_format" name="message_format" />
                            <span class="description">Message that's actually posted.</span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post. {URL} = The blog post url. {SHORT_URL} = The blog post shortened url.</span>
                        </div>
                        <div class="input-div">
                            Application ID/API Key:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_key" value="" />
                            <span class="description">Your Facebook Application ID/API Key.</span>
                        </div>
                        <div class="input-div">
                            Application Secret:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="consumer_secret" value="" />
                            <span class="description">Your Facebook Application Secret.</span>
                        </div>
                    </div>
                    <div id="diigo-div" class="one-account">
                        <div class="help-div"><span class="description">Help: <a href="http://wordpress.org/extend/plugins/microblog-poster/installation/" target="_blank">MicroblogPoster installation page</a></span></div>
                        <div class="input-div">
                            Diigo Username:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="username" name="username" value="" />
                        </div>
                        <div class="input-div">
                            Diigo Password:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="password" value="" />
                        </div>
                        <div class="input-div">
                            Diigo API Key:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="" name="api_key" value="" />
                        </div>
                        <div class="input-div">
                            Message Format:
                        </div>
                        <div class="input-div-large">
                            <input type="text" id="message_format" name="message_format" />
                            <span class="description">Message that's actually posted.</span>
                        </div>
                        <div class="input-div">

                        </div>
                        <div class="input-div-large">
                            <span class="description-small">You can use shortcodes: {TITLE} = Title of the new blog post.</span>
                        </div>
                        <div class="input-div">
                            Include tags:
                        </div>
                        <div class="input-div-large">
                            <input type="checkbox" id="include_tags" name="include_tags" value="1"/>
                            <span class="description">Do you want to include tags in the bookmarks?</span>
                        </div>
                    </div>

                    <input type="hidden" name="new_account_hidden" value="1" />
                    <div class="button-holder">
                        <button type="button" class="button cancel-account" >Cancel</button>
                        <button type="button" class="button-primary save-account" >Save</button>
                    </div>

                </form>
            </div>
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
        .form-table td.row-sep
        {
            padding-bottom: 25px;
        }
        .button-holder
        {
            margin-top: 20px;
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
        .input-div-large
        {
            margin-bottom: 5px;
            display: inline-block;
            width: 480px;
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
            width: 275px;
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
        .button-holder
        {
            width: 120px;
            margin: 30px auto;
        }
        .button-holder-del
        {
            width: 130px;
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
            margin-top: 30px;
            margin-bottom: 20px;
            width: 275px;
            border-bottom: 3px solid #99E399;
        }
        #general-header
        {
            margin-top: 30px;
            width: 140px;
            border-bottom: 3px solid #99E399;
        }
        #logs-header
        {
            margin-top: 30px;
            width: 120px;
            border-bottom: 3px solid #99E399;
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
        #mbp-menu-wrapper
        {
            display: inline-block;
            vertical-align: bottom;
        }
        #mbp-menu
        {
            list-style: none outside none;
            margin: 25px 0px 10px 0px;
            
            
        }
        #mbp-menu li
        {
            display: inline;
            margin-right: 1px;
            color: #222222;
            padding: 3px 6px;
            font-size: 16px;
            border-top: 1px solid #222222;
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
        .mbp-tab-last
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
        .wp-blue-title
        {
            color: #21759B;
            font-weight: bold;
        }
    </style>

    
    
    
    <div id="mbp-logs-wrapper">
        
        <h3 id="logs-header">Logs Section:</h3>
        
        <table>
        <tr>
        <th class="logs-dt">Date time</th>
        <th class="logs-username">Username</th>
        <th class="logs-message">Log message</th>
        <th class="logs-post-id">Post ID</th>
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
        <td class="logs-username"><?php echo $row->username." "; ?><span class="logs-text-username">[<?php echo $row->account_type; ?>]</span></td>
        <td class="logs-message"><span class="<?php echo $color_class; ?>"><?php echo htmlentities($row->log_message); ?></span><?php if($row->action_result==1) echo " - ".htmlentities($row->update_message); ?></td>
        <td class="logs-post-id"><?php echo $row->post_id; ?></td>
        </tr>
    <?php endforeach;?>
        
        </table> 
    </div>
    
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
                    'width'		: 700,
                    'height'	: 400,
                    'scrolling'	: 'auto',
                    'titleShow'	: false,
                    'onComplete'	: function() {
                        $('div#fancybox-content #plurk-div,div#fancybox-content #identica-div,div#fancybox-content #friendfeed-div,div#fancybox-content #delicious-div,div#fancybox-content #facebook-div,div#fancybox-content #diigo-div').hide().find('input').attr('disabled','disabled');
                    }
                });
                
            });
            
            $(".cancel-account").live("click", function(){
                $.fancybox.close();
            });
            
            $(".save-account").live("click", function(){
                
                $('div#fancybox-content #new_account_form').submit();
                $.fancybox.close();
                
                /*
                var valid = 1;
                
                if(!$('div#fancybox-content #username').val())
                {
                    valid = 0;
                }
                
                if(valid == 1)
                {
                    $('div#fancybox-content #new_account_form').submit();
                    $.fancybox.close();
                }
                else
                {
                    alert('Please enter all required fields.');
                }
                */
                
            });
            
            
            
            $("#account_type").live("change", function(){
                var type = $(this).val();
                //console.log(type);
                $('div#fancybox-content #twitter-div,div#fancybox-content #plurk-div,div#fancybox-content #identica-div,div#fancybox-content #friendfeed-div,div#fancybox-content #delicious-div,div#fancybox-content #facebook-div,div#fancybox-content #diigo-div').hide().find('input').attr('disabled','disabled');
                $('div#fancybox-content #'+type+'-div').show().find('input').removeAttr('disabled');
            });
            
            <?php foreach($update_accounts as $account_id):?>
                $(".edit<?php echo $account_id;?>").live("click", function(){
                    $.fancybox({
                        'content'       : $('#update_account<?php echo $account_id;?>').html(),
                        'transitionIn'	: 'none',
                        'transitionOut'	: 'none',
                        'autoDimensions': false,
                        'width'		: 700,
                        'height'	: 400,
                        'scrolling'	: 'auto',
                        'titleShow'	: false
                    });
                });
                $(".save-account<?php echo $account_id;?>").live("click", function(){

                    $('div#fancybox-content #update_account_form<?php echo $account_id;?>').submit();
                    $.fancybox.close();
                    
                    /*
                    var valid = 1;

                    if(!$('div#fancybox-content #username').val())
                    {
                        valid = 0;
                    }

                    if(valid == 1)
                    {
                        $('div#fancybox-content #update_account_form<?php echo $account_id;?>').submit();
                        $.fancybox.close();
                    }
                    else
                    {
                        alert('Please enter all required fields.');
                    }
                    */
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
                $("#mbp-accounts-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            <?php else:?>
                $('#mbp-social-networks-accounts').hide();
                $('#mbp-logs-wrapper').hide();
                $("#mbp-general-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            <?php endif;?>
            
            
            $("#mbp-general-tab").live("click", function(){
                $('#mbp-social-networks-accounts').hide();
                $('#mbp-logs-wrapper').hide();
                $('#mbp-general-section').show();
                
                $("#mbp-accounts-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-logs-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-general-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            });
            $("#mbp-accounts-tab").live("click", function(){
                $('#mbp-logs-wrapper').hide();
                $('#mbp-general-section').hide();
                $('#mbp-social-networks-accounts').show();
                
                $("#mbp-logs-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-general-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-accounts-tab").addClass('mbp-selected-tab').removeClass('mbp-tab-background');
            });
            $("#mbp-logs-tab").live("click", function(){
                $('#mbp-social-networks-accounts').hide();
                $('#mbp-general-section').hide();
                $('#mbp-logs-wrapper').show();
                
                $("#mbp-accounts-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
                $("#mbp-general-tab").removeClass('mbp-selected-tab').addClass('mbp-tab-background');
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
                
        });
        
        

    </script>
    
    <?php
    
}
?>