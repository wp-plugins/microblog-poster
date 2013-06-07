=== Microblog Poster ===
Contributors: cybperic
Tags: microblogging, bookmarking, bookmarks, auto post, auto publish, cross-post, cross post, auto submit, auto update, social, social networks, social media, twitter, facebook, delicious, diigo, plurk, friendfeed, identica, automatic, automation, links, backlinks, shortcodes, auto update status, update status, social media auto publish, social network auto publish, social media publishing, post to twitter, publish to facebook, social signals
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 1.2.6

Automatically publishes your new blog content to Social Networks. Auto-updates Twitter, Facebook, Plurk, Diigo, Delicious..

== Description ==

**Auto updates your social media accounts/profiles** on each new blog post with a formatted message with backlink.
You only have to configure your social network accounts. **Multiple Accounts per social site supported.**
Possibility to nicely format the update message per account, **shortcodes supported**.

**Logs are generated** on new blog post for each configured social network account.
Easily follow the automated sharing process from **MicroblogPoster**'s logs section and debug your configuration if needed.

**Currently supported social media sites**

* twitter.com - Auto tweets backlink of new blogpost.
* facebook.com - Auto updates your status with backlink.
* plurk.com - Auto posts new plurk.
* identi.ca - Auto publishes new message.
* delicious.com - Auto submits bookmark of your blogpost to your account.
* friendfeed.com - Auto updates your status.
* diigo.com - Auto submits bookmark of your new blogpost.

Please visit **MicroblogPoster**'s [website](http://efficientscripts.com/microblogposter "MicroblogPoster's website").


Plugin's main features:

- Auto publish your new blog content
- Sends out social signals and auto share to social media accounts

The idea behind **MicroblogPoster** is to promote your wordpress blog and reach more people through social networks.
There's general agreement in the SEO community that social signals strengthen your blog's page rank and authority.
**MicroblogPoster** is simply an intermediary between your blog and your own social network accounts. You'll never
see "posted by MicroblogPoster" in your updates, you'll see "posted by your own App name" or simply "by API".

== Screenshots ==

1. MicroblogPoster Options page, General section.

2. MicroblogPoster Options page, Social Network Accounts.

3. MicroblogPoster Options page, Logs section.

== Changelog ==

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
* Activate the plugin through the 'Plugins' menu in WordPress
* Settings->MicroblogPoster, Configure your social network accounts.
* The plugin is ready, it will automatically cross posts whenever you publish a new blog post.


**twitter.com accounts** [Help with screenshots](http://efficientscripts.com/help/microblogposter/twitterhelp "Twitter help with screenshots.")

Basically your twitter username and password won't suffice in order to post automatic updates, twitter api requires some more steps described below.
No worries, it's rather a simple procedure.


    1. In order to post updates through the twitter API you'll need first
    to create your own twitter App here: https://dev.twitter.com/apps
    
    2. Once you've created your twitter app you have to change its access level
    to be Read and Write. 
    Browse to Settings tab and check the Access level to be Read and Write,
    save your new settings.

    3. Once this is done go back to the details tab, at the bottom you 
    should have a button 'Create my access token', please do it.

    4. This is it, on the details tab you have all what you need, 
    i.e. consumer key/secret, access token and access token secret.

    5. If you don't see immediately the access token at the bottom, 
    please refresh the details tab page.


**plurk.com accounts** [Help with screenshots](http://efficientscripts.com/help/microblogposter/plurkhelp "Plurk help with screenshots.")

It's most likely the same as for twitter, you'll need some more effort in order to post updates through their api.


    1. Please go at this url http://www.plurk.com/PlurkApp/ 
    and click on 'Create a new Plurk app'.
    For App Type, choose 'Third-party web site integration'. 
    For App website you can put http://localhost

    2. Once you're back on 'My Plurk Apps' page, click the edit button 
    and get your *App Key and App Secret*.

    3. Not finished yet, you need the second pair of credentials. 
    On 'My Plurk Apps' page this time click on 'test console' button.

    4. First click on 'Get Request Token', some processing is done. 
    After that click on 'Open Authorization URL', you'll be redirected 
    to a new page and you'll have to grant the permission in order to get
    your verification code.

    5. Finally return to the previous page and generate your 
    *token key and token secret* by clicking on
    'Get Access Token' and by providing the verification code.

    6. Now you can copy your token key and token secret. 
    Coupled with the App key and App secret you've got previously 
    you can configure your plurk account on MicroblogPoster plugin.


**facebook.com accounts** [Help with screenshots](http://efficientscripts.com/help/microblogposter/facebookhelp "Facebook help with screenshots.")

Please note that only real personal facebook accounts have permissions to create an App.
Business accounts can't manage facebook Apps.

    1. Please go at this url https://developers.facebook.com/apps 
    and click on 'Create New App'.
    Note: If you can't click on 'Create New App', you need first 
    to 'Register as a Developer'.
    Then the creation of new app will be available.

    2. Fill in your 'App name' and click continue.

    3. Enter the required captcha challenge.

    4. Once on the basic settings of your new app, 
    for the field 'App Domains' enter your blog domain name 
    (example: mydomain.com)
    In the field 'Website with facebook login' enter your blog url.
    (example: http://mydomain.com)
    Sandbox mode should be disabled.
    Save changes.

    5. Copy your 'App ID' and 'App Secret' and configure your facebook account
    on MicroblogPoster plugin.

    6. Follow the link provided by MicroblogPoster to authorize your App 
    posting on your behalf.


**friendfeed.com accounts** [Help with screenshots](http://efficientscripts.com/help/microblogposter/friendfeedhelp "FriendFeed help with screenshots.")


Instead of the password the friendfeed API requires the remote key to let you post with it.

    1. You can find your remote key associated with your account at this url:
    https://friendfeed.com/account/api (you need to be logged in).


**diigo.com accounts**

In addition to your username/password you'll need to create your own diigo app and generate an Api key.

    1. Please go at this url: https://www.diigo.com/api_keys/new/
    and generate your diigo Api Key (you need to be logged in).


== Upgrade Notice ==

Deactivate/Activate MicroblogPoster plugin.

== Frequently Asked Questions ==

= My blog is hosted on shared hosting, can I use MicroblogPoster? =

Warning about inherent php script execution time limitation that some Hosting Providers apply on shared accounts (max_execution_time PHP setting). 
Since *MicroblogPoster* needs time to update all your social accounts when publishing a new blog post this limit might be reached and script execution stopped.
In order to avoid it, please limit the number of social accounts based on your environment script execution time limit.

= The PHP cURL extension is required? =

Yes, otherwise the plugin simply won't function at all.



