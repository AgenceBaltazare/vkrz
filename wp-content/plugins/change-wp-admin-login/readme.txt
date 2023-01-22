=== Change wp-admin login ===
Tags:              change wp-login, rename wp-login, wp-admin, login, wp-login, wp-login.php, custom login url
Contributors:      nunosarmento
Requires at least: 4.4
Tested up to:      6.1
Stable tag:        1.1.2
License:           GPL-2.0+


== Description ==

*Change wp-admin login* is a light plugin that allows you easily and safely to change wp-admin to anything you want. It does not rename or change files in core. It simply intercepts page requests and works on any WordPress website. After you activate this plugin the wp-admin directory and wp-login.php page will become unavailable, so you should bookmark or remember the url. Disable this plugin brings your site back exactly to the state it was before.


== Support ==

**Like this plugin?** Please [Rate It](https://wordpress.org/support/plugin/change-wp-admin-login/reviews/?filter=5) or [Buy me a coffee](https://ko-fi.com/nunosarmento)

**Have a problem?** Please write a message in the [WordPress Support Forum](https://wordpress.org/support/plugin/change-wp-admin-login/)


== How to use the plugin ==

Go under Settings and then click on "Permalinks" and change your URL under "Change wp-admin login".

Step 1: Add new login URL

Step 2: Add redirect URL


== New Feature ==

Add redirect custom field:

When someone tries to access the wp-login.php page or the wp-admin directory while not logged in will be redirect to the page that you defined on the redirect custom field.

If you leave the redirect field empty the plugin will add a default redirect to the homepage.

== Credits ==

This plugin was forked/adapted/fixed/updated from this plugin https://wordpress.org/plugins/rename-wp-login/ - @ellatrix thank you for starting the base of my plugin.


== Installation ==

1. Go to Plugins › Add New.
2. Search for *Change wp-admin login*.
3. Download and activate it.
4. Go under Settings and then click on "Permalinks" and change your URL under "Change wp-admin login"
5. You can change this anytime, just go back to Settings › Permalinks › Change wp-admin login.

== Frequently Asked Questions ==

= I can't login? =
In case you forgot the login URL or for any other reason you can't login on the website you will need to delete the plugin via SFT/FTP or cPanel on your hosting.

Path for the plugin folder:
/wp-content/plugins/change-wp-admin-login

Advanced users:
Go to your MySQL database and look for the value of rwl_page in the options table

Advanced users (multisite):
Go to your MySQL database and look for rwl_page option will be in the sitemeta table or options table.

= Does it work with TranslatePress? =
You need to select the option NO "Use a subdirectory for the default language".

= Does it work with Polylang? =
Yes, it works but not tested with the URL option "The language is set from different domains".

= Does it work on WordPress Multisite with Subdirectories? =
Yes, it does work. You should setup the login URL in each website (Settings-->Permalinks)

= Does it work on WordPress Multisite with Subdomains? =
Yes, it does work. You should setup the login URL in each website (Settings-->Permalinks)

= Does it work with Buddyboss? =
No, Buddyboss has their own wp-admin redirect functions.

= Does it work with BuddyPress? =
No, BuddyPress has their own wp-admin redirect functions.

== Changelog ==

= 1.0.0 =
* Initial version.

= 1.0.1 =
* Add automatic redirect for when someone tries to access the wp-login.php page or the wp-admin directory while not logged in will be redirected to the website homepage.

= 1.0.2 =
* Add translations

= 1.0.3 =
* Add redirect custom field.
* When someone tries to access the wp-login.php page or the wp-admin directory while not logged in will be redirect to the page that you defined on the redirect custom field.

= 1.0.4 =
* Add redirect custom field.
* Better instructions in how to use the redirect field

= 1.0.5 =
* add site URL before the new redirect input field

= 1.0.6 =
* fix suppressed warning

= 1.0.7 =
* fix missing register_setting on the add_settings_field

= 1.0.8 =
* fix security issue

= 1.0.9 =
* fix security issue

= 1.1.0 =
* Update WordPress API settings

= 1.1.1 =
* Fix php8 warnings 

= 1.1.2 =
* More Fixes for php8 warnings 
