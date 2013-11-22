=== Microblog Poster ===
Contributors: cybperic
Tags: microblogging, bookmarking, bookmarks, auto posts, auto publish, social signals, cross-post, cross post, auto submit, auto update, social networks, social media, twitter, facebook, linkedin, tumblr, delicious, diigo, plurk, friendfeed, automatic, automation, links, backlinks, auto updates status, social media auto publish, social network auto publish, share to twitter, share to facebook
Requires at least: 3.0
Tested up to: 3.7.1
Stable tag: 1.3.5

Automatically publishes your new blog content to Social Networks. Auto-updates Twitter, Facebook, Linkedin, Tumblr, Diigo, Delicious..

== Description ==

**Auto updates your social media accounts/profiles** on each new blog post with a formatted message with backlink.
You only have to configure your social network accounts. **Multiple Accounts per social site supported.**
Possibility to nicely format the update message per account, **shortcodes supported**.

**Logs are generated** on new blog post for each configured social network account.
Easily follow the automated sharing process from **MicroblogPoster**'s logs section and debug your configuration if needed.

**Filter posts** to be published based on excluded categories. (General section settings)

**Currently supported social media sites**

* twitter.com - Auto tweet backlink of new blogpost.
* facebook.com - Auto publish to profile wall.
* plurk.com - Auto post new plurk.
* delicious.com - Auto submit bookmark of your blogpost to your account.
* friendfeed.com - Auto update your status.
* diigo.com - Auto submit bookmark of your new blogpost.
* linkedin.com - Auto publish to profile wall
* tumblr.com - Auto publish to your blog.

Please visit **MicroblogPoster**'s [website](http://efficientscripts.com/microblogposter "MicroblogPoster's website").


The idea behind **MicroblogPoster** is to promote your wordpress blog and reach more people through social networks like Facebook, Twitter, LinkedIn, Tumblr.. 
There's a general agreement in the SEO community that social signals strengthen your blog's page rank and authority.
**MicroblogPoster** is simply an intermediary between your blog and your own social network accounts. You'll never
see "posted by MicroblogPoster" in your updates, you'll see "posted by your own App name" or simply "by API".

Additional features are available with the [Pro Add-on](http://efficientscripts.com/microblogposterpro "MicroblogPoster's Pro Add-on Page").


**MicroblogPoster** in few words:

- Auto publish your new blog content
- Sends out social signals and auto share to social media accounts
- Social signals and backlinks auto generator
- Cross post to facebook , twitter and more
- Auto publish to facebook , tumblr
- Auto share to twitter , facebook , linkedin

== Screenshots ==

1. MicroblogPoster Options page, General Section.

2. MicroblogPoster Options page, Social Network Accounts.

3. MicroblogPoster Options page, Logs Section.

== Changelog ==

= 1.3.5 (06-11-2013) =
- Added support for tumblr.
- Improved design of plugin's settings page.

= 1.3.4 (27-09-2013) =
- Fixed internal error 500 that was occurring for some PHP/web server configurations, related to the use of method_exists function.
- Added 'Settings' link on plugins page.

= 1.3.3 (15-09-2013) =
- Adapted the free version of the plugin to work together with the new pro add-on. Additional features available with the pro add-on.

= 1.3.2 (31-07-2013) =
- Fixed critical error about a PHP warning produced by variable not being an array. Later that produces header already sent error.

= 1.3.1 (20-07-2013) =
- Added currently recommended way of authentication with bit.ly (oauth).
- MicroblogPoster's control checkbox moved from right side to center.
- Dropped support for identi.ca because of the complete change of their API.
- Added possibility to choose plurk qualifier.
- In general section exclude posts from checked categories cross-posting automatically.

= 1.3.0 (01-07-2013) =
- linkedin.com is now supported.
- facebook posting improvements (text only or share a link).
- Added possibility to post featured image (facebook and linkedin cross posting).
- Logging failed authorizations to help debugging.

= 1.2.7 (28-06-2013) =
- linkedin.com is now supported.
- facebook posting improvements (text only or share a link).
- Added possibility to post featured image (facebook and linkedin cross posting).
- Logging failed authorizations to help debugging.

= 1.2.61 (12-06-2013) =
- Urgent twitter api fix

= 1.2.6 (02-06-2013) =
- diigo.com is now supported
- Added possibility to cross-post on new page creation.
- General options layout improvements + added options for page cross posting.

= 1.2.5 (12-05-2013) =
- Logs are now generated for each new blog post per social account.
- Tabified the plugin settings page, added logs section.
- Added option for default post update behavior.
- Facebook account authorization process improved.
- Fixed several small bugs.

= 1.2.4 (28-04-2013) =
- Possibility to format the message that's posted, shortcodes support.
- For HTTP Auth sites, passwords are stored encrypted in db.
- New option for delicious site, choose if tags included.
- Bug fix, double escaping.

= 1.2.3 (16-04-2013) =
- facebook.com is now supported.
- 'default per post behavior' option added.
- added images for each supported site.

= 1.2.2 =
- Multiple Accounts per site supported.
- More user friendly plugin settings interface.

= 1.2.1 =
- Added microblogging site friendfeed.com

= 1.2 =
- Added bookmarking site delicious.com

= 1.1 =
- Added microblogging site identi.ca

= 1.0 =
- First version of Plugin Released.

== Installation ==

* Upload the contents of the microblogposter folder to your /wp-content/plugins/ folder.
* Activate the Plugin through the 'Plugins' menu in WordPress
* Settings->MicroblogPoster, Configure your social network accounts.
* The plugin is ready, it will automatically cross posts whenever you publish a new blog post.


**twitter.com accounts** [Help with screenshots](http://efficientscripts.com/help/microblogposter/twitterhelp "Twitter help with screenshots.")

Basically your Twitter username and password won't suffice in order to post automatic updates, Twitter Api requires some more steps described below.
No worries, it's rather a simple procedure.


    1. In order to post updates through the Twitter Api you'll need first
    to create your own Twitter App here: https://dev.twitter.com/apps
    
    2. Once you have created your twitter App you have to change its access level
    to be Read and Write. 
    Browse to settings tab and check the Access Level to be read and write,
    save your new settings.

    3. Once this is done go back to the Details tab, at the bottom you 
    should have a button 'Create my access token', please do it.

    4. This is it, on the details tab you have all what you need, 
    i.e. consumer key / secret, Access token and Access token secret.

    5. If you don't see immediately the access token at the bottom, 
    please refresh the details tab page.


**plurk.com accounts** [Help with screenshots](http://efficientscripts.com/help/microblogposter/plurkhelp "Plurk help with screenshots.")

It's most likely the same as for twitter, you will need some more effort in order to post updates through their Api.


    1. Please go at this Url http://www.plurk.com/PlurkApp/ 
    and click on 'Create a New Plurk App'.
    For App Type, choose 'Third-party web site integration'. 
    For App website you can put http://localhost

    2. Once you're back on 'My Plurk Apps' page, click the edit button 
    and get your *App Key and App Secret*.

    3. Not finished yet, You need the second pair of credentials. 
    On 'My Plurk apps' page this time click on 'test console' button.

    4. First click on 'Get Request Token', then some processing is done. 
    After that click on 'Open Authorization Url', you'll be redirected 
    to a new page and you will have to grant the permission in order to get
    your verification code.

    5. Finally return to the previous page and generate your 
    *Token key and Token secret* by clicking on
    'Get Access Token' and by providing the verification code.

    6. Now you can copy your token key and token secret. 
    Coupled with the App key and App secret you've got previously 
    you can configure your plurk account in the Social Accounts section.


**facebook.com accounts** [Help with screenshots](http://efficientscripts.com/help/microblogposter/facebookhelp "Facebook help with screenshots.")

Please note that only real personal Facebook accounts have permissions to create an App.
Business accounts can't manage Facebook Apps.

    1. Please go at this url https://developers.facebook.com/apps 
    and click on 'Create New App'.
    Note: If you can't click on 'Create New App', You need first 
    to 'Register as a developer'.
    Then the creation of new App will be available.

    2. Fill in your 'App Name' and click continue.

    3. Enter the required captcha challenge.

    4. Once on the basic settings of your new App, 
    for the field 'App Domains' enter your Blog domain name 
    (example: mydomain.com)
    In the field 'Website with Facebook login' enter your blog url.
    (example: http://mydomain.com)
    Sandbox mode should be disabled.
    Save changes.

    5. Copy your 'App ID' and 'App Secret' and configure your Facebook account
    in MicroblogPoster's Social accounts section.

    6. Follow the link provided by MicroblogPoster to authorize your App 
    posting on your behalf.


**friendfeed.com accounts** [Help with screenshots](http://efficientscripts.com/help/microblogposter/friendfeedhelp "FriendFeed help with screenshots.")


Instead of the password the Friendfeed API requires the remote key to let you post with it.

    1. You can find your remote key associated with your account at this Url:
    https://friendfeed.com/account/api (You need to be logged in).


**diigo.com accounts** [Help with screenshots](http://efficientscripts.com/help/microblogposter/diigohelp "Diigo help with screenshots.")

In addition to your username and password you'll need to create your own Diigo App and generate an Api key.

    1. Please go at this url: https://www.diigo.com/api_keys/new/
    and generate your Diigo Api key. (You need to be logged in)


**linkedin.com accounts** [Help with screenshots](http://efficientscripts.com/help/microblogposter/linkedinhelp "Linkedin help with screenshots.")


    1. Please go at this url https://www.linkedin.com/secure/developer
    and click on 'Add New Application'.

    2. Fill in the required informations.
    For 'Live Status', select Live.
    Leave everything else by default.
    Click the button 'Add application'.

    3. Copy 'Api Key' and 'Secret Key', click 'Done'.

    4. Configure your Linkedin Account in the Social Accounts Section.

    5. Follow the link provided by MicroblogPoster to authorize your App 
    posting on your behalf.

**tumblr.com accounts** [Help with screenshots](http://efficientscripts.com/help/microblogposter/tumblrhelp "Tumblr help with screenshots.")

Basically your Tumblr username and password won't suffice in order to post automatic updates, Tumblr API requires some more steps described below.
No worries, it's rather a simple procedure.


    1. In order to post updates through the Tumblr Api you'll need first
    to create your own Tumblr App here: http://www.tumblr.com/oauth/apps
    
    2. Once you have created your Tumblr App copy your 'OAuth Consumer Key'.

    3. Also click on 'Show secret key' and copy your 'Secret key'.

    4. This is it, you can now configure your account in the Social Accounts Section.


== Upgrade Notice ==

Deactivate/Activate MicroblogPoster plugin.

== Frequently Asked Questions ==

= My blog is hosted on shared hosting, can I use MicroblogPoster? =

Warning about inherent php script execution time limitation that some Hosting Providers apply on shared accounts (max_execution_time PHP setting). 
Since *MicroblogPoster* needs time to update all your social accounts when publishing a new blog post, this limit might be reached and script execution stopped.
In order to avoid it, please limit the number of social accounts based on your environment script execution time limit.

= The PHP cURL extension is required? =

Yes, otherwise the plugin simply won't function at all.



