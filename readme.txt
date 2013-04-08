=== Microblog Poster ===
Contributors: cybperic
Tags: microblogging, bookmarking, bookmark, auto post, cross-post, cross post, auto submit, social, social networks, twitter, delicious.com, plurk, friendfeed, identi.ca, automatic, links, backlinks
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 1.2.2

Automatically publishes your new blog content to Social Networks. Updates your microblogs and bookmarking profiles.

== Description ==

**Automatically updates your microblogs and bookmarking profiles** with 'blogpost title + shortened backlink' of your new blogpost.
PHP 5 required.

You only have to configure your social network accounts. **Multiple Accounts per site supported.**

**Currently supported microblogging/bookmarking sites**

* twitter.com
* plurk.com
* identi.ca
* delicious.com - Auto submits bookmark of your blogpost to your account.
* friendfeed.com

== Screenshots ==

1. MicroblogPoster Options page. Settings -> MicroblogPoster

== Changelog ==

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
* The plugin is ready, it'll automatically cross-posts whenever you publish a new blog post.


**twitter.com accounts**

Basically your twitter username/password won't suffice in order to post automatic updates, twitter api requires some more steps described below.
No worries, it's rather a simple procedure.


    1. In order to post updates through the twitter API you'll need first to create your own twitter App
    here: https://dev.twitter.com/apps
    
    2. Once you've created your app you have to change its access level to be Read and Write. 
    Browse to Settings tab and check the Access level to be Read and Write, save your new settings.

    3. Once this is done go back to the details tab, at the bottom you'd have a button 'Create my access token',
    please do it.

    4. This is it, on the details tab you have all you need, i.e. consumer key/secret, access token 
    and access token secret.

    5. If you don't see immediately the access token at the bottom browse away and come back to the details tab, 
    it should be there.


**plurk.com accounts**

It's most likely the same as for twitter, you'll need some more effort in order to post updates through their api.

    1. Please go at this url http://www.plurk.com/PlurkApp/ and click on 'Create a new Plurk app'.
    For App Type, choose 'Third-party web site integration'. For App website you can put http://localhost

    2. Once you're back on 'My Plurk Apps' page, click on edit button and get your *App Key and App Secret*.

    3. Not finished yet, you need the second pair of credentials. On 'My Plurk Apps' page this time click on
    'test console' button.

    4. First click on 'Get Request Token', some processing is done. After that click on 'Open Authorization URL',
    you'll be redirected to a new page and you'll have to grant the permission in order to get
    your verification code.

    5. Finally go back to the previous page and generate your *token key and token secret* by clicking on
    'Get Access Token' and by providing the verification code.

    6. Now you can copy your token key and token secret. Coupled with the App key and App secret you got
    previously you can configure your plurk.com account on MicroblogPoster plugin.


== Upgrade Notice ==

Deactivate/Activate MicroblogPoster plugin.

== Frequently Asked Questions ==

= The PHP cURL extension is required? =

Yes, otherwise the plugin simply won't function at all.



