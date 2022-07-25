# Integrate Firebase PRO WordPress Plugin

Contributors: dalenguyen

Tags: firebase, wordpress

Requires at least: 4.0.0

Tested up to: 5.6

Stable tag: 2.5.0

Requires PHP: 5.2.4

Integrate Firebase PRO is a plugin that helps to Integrate Firebase features to WordPress

## Description

The Integrate Firebase PRO Plugin will help a Firebase user to login to your WordPress interface - not to WordPress dashboard - from Firebase authentication. You can show user info display data that is only available to your Firebase users.

### Links

- [Project page](https://techcater.com/)

## Installation

If installing the plugin from wordpress.org:

1. Upload the entire `/integrate-firebase-PRO` directory to the `/wp-content/plugins/` directory.
2. Activate Integrate Firebase PRO Plugin through the 'Plugins' menu in WordPress.
3. Profit.

## Frequently Asked Questions

### What can I do with this Integrate Firebase PRO plugin?

Since version 0.9.0, a user can Integrate Firebase PRO authentication to WordPress. That means you can:

- log in, log out and show data only to logged in users.
- Get Realtime & Firestore database in Dashboard
- Add and edit Users in Dashboard
- Send cloud message to a topic
- Save data to Realtime & Firestore from WP frontend

### How can I put a shortcode in a widget or WordPress editor? =

The example in this guide only shows you how to put in a PHP file. If you want to put the shortcode inside a widget or editor. You can simply do this:

```
// Page or Post
[firebaseui_web][/firebaseui_web]

// php files
echo do_shortcode("[firebaseui_web][/firebaseui_web]");
```

### How can I add Authentication feature to WordPress

```
[firebaseui_web][/firebaseui_web]
```

### How can I show user info after login?

You can add a shortcode to show user's info

```
[firebase_greetings][/firebase_greetings]
```

### How can I show firebase error?

You can show error message when there are error from firebase

```
[firebase_error class='your-class-name'][/firebase_error]"
```

### How can I show data for a not logged in user?

You can put your data as an HTML code inside a shortcode

```
[firebase_show_not_login class='your-class-name']YOUR HTML CODE[/firebase_show_not_login]
```

### How can I hide or show data for a logged in user?

You can put your data as an HTML code inside a shortcode

```
[firebase_show class='your-class-name']YOUR HTML CODE[/firebase_show]
```

### How can I show realtime database for a logged in user?

You can put your data as an HTML code inside a shortcode. Realtime data will be shown as a table with an id #if-realtime.

```
[realtime class='your-class-name' collection_name='string' document_name='string']
```

### How can I log out?

This is a shortcode for log out button.

```
[firebase_logout][/firebase_logout]
```

## Screenshots

1. After activating the plugin, you need enter Firebase credentials under Setting > Firebase.

![Firebase Settings](/assets/screenshot-1.png)

2. Please enter collection names in order to show the data from Real Time Database

![Database Settings](/assets/screenshot-2.png)

3. Please edit the read rules in order to view data from Firestore

![Firestore Settings](/assets/screenshot-3.png)

## [Changelog](/CHANGELOG.md)

## Upgrade Notice

Please use [github issues](https://github.com/dalenguyen/integrate-firebase-PRO/issues) when submitting your logs. Please do not post to the forums.
