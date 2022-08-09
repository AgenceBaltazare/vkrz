# Changelog

All notable changes to this project will be documented in this file.

> **Tags:**
>
> - :boom: [Breaking Change]
> - :eyeglasses: [Spec Compliancy]
> - :rocket: [New Feature]
> - :bug: [Bug Fix]
> - :memo: [Documentation]
> - :nail_care: [Polish]

## [ 3.15.0 ] - 2022-08-06

#### - :nail_care: [Polish]

- improve multisite authentication process
- support draft status
- support dynamic firestore subcollection form

## [ 3.14.1 ] - 2022-07-19

#### - :bug: [Bug Fix]

- fix user update params

## [ 3.14.0 ] - 2022-07-19

#### - :nail_care: [Polish]

- Add support for email with + character
- Add product validation

## [ 3.13.0 ] - 2022-06-1

#### - :nail_care: [Polish]

- improve send email verification
- add warning for no javascript site

## [ 3.12.2 ] - 2022-05-28

#### - :nail_care: [Polish]

- improve logging for authentication

## [ 3.12.1 ] - 2022-05-21

#### - :nail_care: [Polish]

- add action for extensions initialization

## [ 3.12.0 ] - 2022-05-15

#### - :nail_care: [Polish]

- improve admin security
- improve authentication styling

## [ 3.11.0 ] - 2022-05-07

#### - :rocket: [New Feature]

- add support for Wordfence 2FA
- add support for JetEngine Custom Post Types

## [ 3.10.0 ] - 2022-04-30

#### - :rocket: [New Feature]

- support image type in Custom Fields when syncing to firebase
- enable debug mode for login
- humanize username

## [ 3.9.1 ] - 2022-04-11

#### - :bug: [Bug Fix]

- fix update profile issue

## [ 3.9.0 ] - 2022-04-09

#### - :rocket: [New Feature]

- sync avatar from WordPress to firebase
- improve authentication flow

## [ 3.8.0 ] - 2022-04-02

### - :nail_care: [Polish]

- add support for firebase cloud functions
- add guide for missing product key

## [ 3.7.0 ] - 2022-03-19

#### - :rocket: [New Feature]

- improve Apple social login
- improve user name after signing in
- add timestamp when syncing to firebase

## [ 3.6.2 ] - 2022-03-13

### - :nail_care: [Polish]

- update translation text for authentication

## [ 3.6.1 ] - 2022-03-12

#### - :rocket: [New Feature]

- add support for separate forgot password (social login)

## [ 3.6.0 ] - 2022-03-12

#### - :rocket: [New Feature]

- add support for separate forgot password page
- add verify token hook

## [ 3.5.3 ] - 2022-03-02

### - :nail_care: [Polish]

- support HTML for custom error message

### - :bug: [Bug Fix]

- fix custom register form

## [ 3.5.2 ] - 2022-02-26

### - :nail_care: [Polish]

- enforce email for Facebook login
- style social login
- improve user metadata update in WordPress
- show custom error message for forgot my password

## [ 3.5.1 ] - 2022-02-21

### - :nail_care: [Polish]

- update custom fields when syncing to Firebase
- support Discourse SSO authentication

## [ 3.5.0 ] - 2022-01-20

#### - :rocket: [New Feature]

- add new authentication UI

## [ 3.4.0 ] - 2022-02-14

### - :nail_care: [Polish]

- increase request timeout
- update update_user_meta method

## [ 3.3.1 ] - 2022-02-07

### - :nail_care: [Polish]

- update stylings

## [ 3.3.0 ] - 2022-02-07

#### - :rocket: [New Feature]

- Lazy load main scripts in order to improve performance
- Enforce product key when using the plugin

## [ 3.2.0 ] - 2022-02-04

#### - :rocket: [New Feature]

- Add forgot password component

#### - :nail_care: [Polish]

- retrieve email for Google Provider

#### - :bug: [Bug Fix]

- fix retrieve user after registration error

## [ 3.1.0 ] - 2022-01-22

#### - :rocket: [New Feature]

- enable messenger id on the frontend

## [ 3.0.0 ] - 2022-01-15

#### - :rocket: [New Feature]

- override redirect url from query params
- upgrade firebase to v9
- upgrade firebaseui_web to v6
- lazy load scripts

## [ 2.23.0 ] - 2022-01-08

#### - :rocket: [New Feature]

- add filter hook for editing custom messages
- update error messages for register flow

## [ 2.22.0 ] - 2022-01-01

#### - :rocket: [New Feature]

- add error message to login form

## [ 2.21.0 ] - 2021-12-25

#### - :rocket: [New Feature]

- Add support for Firebase Cloud Messaging

## [ 2.20.2 ] - 2021-12-06

#### - :nail_care: [Polish]

- save phone number to database after registering via login form

## [ 2.20.1 ] - 2021-12-02

#### - :nail_care: [Polish]

- ease phone number validation when registering

## [ 2.20.0 ] - 2021-11-20

#### - :rocket: [New Feature]

- add firebase uid to WordPress user data

## [ 2.19.1 ] - 2021-11-05

#### - :bug: [Bug Fix]

- show default WooCommerce login when Firebase Auth is disabled

## [ 2.19.0 ] - 2021-10-31

#### - :nail_care: [Polish]

- Check for null value before saving to firebase
- Deprecate user register API

## [ 2.18.0 ] - 2021-09-26

#### - :rocket: [New Feature]

- Allow to extend post object when saving to firebase

## [ 2.17.0 ] - 2021-09-19

#### - :rocket: [New Feature]

- Allow to extend user object when saving to firebase

## [ 2.16.0 ] - 2021-08-30

#### - :rocket: [New Feature]

- Added id key when saving data to firebase

## [ 2.15.2 ] - 2021-08-29

#### - :nail_care: [Polish]

- Check for users configuration before saving to firebase

## [ 2.15.1 ] - 2021-08-02

#### - :nail_care: [Polish]

- Hide custom registration form after logging in
- Fixed custom registration login password

## [ 2.15.0 ] - 2021-08-01

#### - :rocket: [New Feature]

- Added custom registration form (Contact 7)
- Added confirmation email to Login form
- Supported putting id outside for contact 7 form

## [ 2.14.0 ] - 2021-07-09

#### - :rocket: [New Feature]

- Improved send email verification flow for firebaseUI Web

#### - :nail_care: [Polish]

- Updated firebase version to v8.7.1

## [ 2.13.0 ] - 2021-06-20

#### - :rocket: [New Feature]

- Added get data filter hooks

#### - :nail_care: [Polish]

- Keep version of firebase at v8.6.1

## [ 2.12.0 ] - 2021-05-29

#### - :rocket: [New Feature]

- Added support for not default Realtime Database URL
- Updated styles for error components

## [ 2.11.0 ] - 2021-05-22

#### - :rocket: [New Feature]

- Deleted category on firebase when deleting in WordPress
- Enabled Microsoft login

#### - :nail_care: [Polish]

- Removed product key warning

## [ 2.10.0 ] - 2021-05-15

#### - :rocket: [New Feature]

- Added support for syncing Category to Firebase

#### - :nail_care: [Polish]

- updated firebase version to 8.6.1

## [ 2.9.0 ] - 2021-05-01

#### - :rocket: [New Feature]

- Added product key settings for auto update

## [ 2.8.0 ] - 2021-04-10

#### - :rocket: [New Feature]

- Hided single signon after log in
- Exposed custom text for Sign out button

#### - :nail_care: [Polish]

- Removed warnning for not supported post types

## [ 2.7.2 ] - 2021-04-02

#### - :nail_care: [Polish]

- Change basedomain name on Settings tab

## [ 2.7.1 ] - 2021-03-30

#### - :bug: [Bug Fix]

- Fixed form upload with empty file

## [ 2.7.0 ] - 2021-03-27

#### - :rocket: [New Feature]

- Added support for multifiles uploader to cloud storage

#### - :bug: [Bug Fix]

- Fixed sendEmailVerification error (firebaseUI Web)

## [ 2.6.0 ] - 2021-03-20

#### - :rocket: [New Feature]

- Enabled email verification for FirebaseUI Web

#### - :nail_care: [Polish]

- Improve login check

## [ 2.5.0 ] - 2021-03-06

#### - :rocket: [New Feature]

- Added support for jwt token login
- Added updatedAt when updating data to Firebase

#### :bug: [Bug Fix]

- Fixed createdAt when updating data to Firebase

## [ 2.4.0 ] - 2021-02-20

#### - :rocket: [New Feature]

- Added delete database hooks
- Removed delete post to firebase database

#### - :nail_care: [Polish]

- Increased security checkin time for autologin
- Improved login logic handler
- Updated firebase scripts version

## [ 2.3.1 ] - 2021-01-24

#### - :nail_care: [Polish]

- Only run security check when cloud functions is deployed

## [ 2.3.0 ] - 2021-01-23

#### - :rocket: [New Feature]

- Allowed getting full URL when uploading file to Firebase Storage

#### - :boom: [Breaking Change]

- Improved autologin security to WordPress

## [ 2.2.0 ] - 2021-01-16

#### - :nail_care: [Polish]

- Improved Login / Logout Styling

## [ 2.1.0 ] - 2021-01-09

#### - :rocket: [New Feature]

- Added support for display data type Boolean & Number
- Added id to the display fields (firestore)
- Deprecated formAction when saving / updating data
- Data will be upsert to firebase

#### - :nail_care: [Polish]

- Hide logout link when login with Firebase is disabled
- Improved error mesages & security

## [ 2.0.0 ] - 2021-01-02

#### - :rocket: [New Feature]

- Updated synced user function when logging to WordPress is disabled
- Added createdAt field when saving data to firebase
- Added integer type when saving data to firebase
- Hided login & register page when login with Wordpress is enabled

#### - :nail_care: [Polish]

- Updated firebase script to v8.2.1

## [ 1.26.0 ] - 2020-12-19

#### - :rocket: [New Feature]

- Improved logged in session between WordPress & Firebase

## [ 1.25.0 ] - 2020-12-13

#### - :rocket: [New Feature]

- Added custom redirect to firebaseui web

## [ 1.24.0 ] - 2020-11-28

#### - :nail_care: [Polish]

- Used update rather than create for syncing data to firebase

## [ 1.23.0 ] - 2020-11-21

#### - :rocket: [New Feature]

- Converted timestamp to date format (firestore)
- Improved security for auto login

## [ 1.22.0 ] - 2020-11-14

#### - :rocket: [New Feature]

- Allowed getting firestore value from deep level object key

#### - :nail_care: [Polish]

- Updated firebase scripts to v8.0.2
- Updated firebaseui web scripts to v4.7.1

## [ 1.21.0 ] - 2020-11-08

#### - :rocket: [New Feature]

- Added Filter Hook to Import Users to Firebase
- Added createdAt & SignedOn to the exported users in WP dashboard

## [ 1.20.0 ] - 01-11-2020

#### - :nail_care: [Polish]

- Updated firebase scripts to v8.0.0

#### - :bug: [Bug Fix]

- Check for firebase functions before syncing WordPress users

## [ 1.19.0 ] - 18-10-2020

#### - :nail_care: [Polish]

- Updated firebaseUI Web to 4.7.0

#### - :bug: [Bug Fix]

- Fixed Beaver Builder conflict

## [ 1.18.0 ] - 12-10-2020

#### - :rocket: [New Feature]

- Added Filter Hook to Save Data to Firebase

## [ 1.17.0 ] - 11-10-2020

#### - :rocket: [New Feature]

- Added loading state after logging in

## [ 1.16.0 ] - 27-09-2020

#### - :rocket: [New Feature]

- Use phone number as display name for phone authentication
- Added User to Firestore (No WordPress User flow)

#### - :nail_care: [Polish]

- Updated check version condition

## [ 1.15.0 ] - 20-09-2020

#### - :rocket: [New Feature]

- Added not-in & not equal (!=) to filter Firestore
- Added limit when getting Firestore data
- Added dynamic link when displaying firestore data

#### - :nail_care: [Polish]

- Updated firebase scripts to 7.21.0

## [ 1.14.0 ] - 30-08-2020

#### - :rocket: [New Feature]

- Updated display name if it exists in Firebase
- Ability to sync Users to Firestore / Realtime Database

## [ 1.13.0 ] - 22-08-2020

#### - :rocket: [New Feature]

- Added Created On and Signed In to the Users table
- Added UPDATE option for Contact Form 7 (Firestore)

#### - :nail_care: [Polish]

- Added check for new version in WordPress dashboard
- Added guide URL under Auth tab

## [ 1.12.0 ] - 13-08-2020

#### - :bug: [Bug Fix]

- Fixed Firebase Account does't save
- Fixed "missing the required permission_callback argument" (WordPress 5.5)
- Fixed user cannot register to WordPress using [firebase_login] shortcode

## [ 1.11.1 ] - 04-08-2020

#### - :bug: [Bug Fix]

- Fixed redirect after logging out

## [ 1.11.0 ] - 03-08-2020

#### - :rocket: [New Feature]

- Added redirect after logging out
- Added send confirmation email in [firebase_register] shortcode

#### - :nail_care: [Polish]

- Reorganized scripts for W3 Cache performance

## [ 1.10.0 ] - 01-08-2020

#### - :rocket: [New Feature]

- Added authentication support for multisite

#### - :nail_care: [Polish]

- Updated firebaseui web to v4.6.1
- Improved performance by putting scripts in body

## [ 1.9.0 ] - 25-07-2020

#### - :rocket: [New Feature]

- Added Firebase Analytics script
- Added author info when syncing post data to Firebase
- Updated firebase scripts to v7.17.1

## [ 1.8.0 ] - 20-07-2020

#### - :rocket: [New Feature]

- Added support for file upload (Contact 7 Form)
- Updated Firestore instead of reset document when creating

#### - :bug: [Bug Fix]

- Fixed error when initialize Storage Bucket

## [ 1.7.0 ] - 19-07-2020

#### - :rocket: [New Feature]

- Added support for Storage bucket
- Support WooCommerce Authentication

## [ 1.6.0 ] - 12-07-2020

#### - :rocket: [New Feature]

- Added support for custom fields when syncing post types
- Supported orderby when displaying firestore data
- Supported orderby when displaying realtime data (orderByChild)

#### - :nail_care: [Polish]

- Updated FirebaseUI Web version to v4.5.2
- Updated development packages

## [ 1.5.0 ] - 05-07-2020

#### - :rocket: [New Feature]

- Support newline when display from textarea
- Collection name is generated from post_type plural label

#### - :bug: [Bug Fix]

- Fixed sending error in Contact Form 7 v5.2

## [ 1.4.0 ] - 28-06-2020

#### - :bug: [Bug Fix]

- Edited the broken docs link

#### - :rocket: [New Feature]

- Allow phone user to login to WordPress
- Improved security for logging to WordPress
- WordPress username is default to Firebase UID

## [ 1.3.1 ] - 21-06-2020

#### - :bug: [Bug Fix]

- Fixed PHP Notices

## [ 1.3.0 ] - 21-06-2020

#### - :rocket: [New Feature]

- Added one-tap signup feature (Google)
- Added popup for social login
- Allowed login via email link

## [ 1.2.0 ] - 15-06-2020

#### - :rocket: [New Feature]

- Added dynamic User UID when searching for Firestore data
- Added taxanomies when saving data to Firebase

## [ 1.1.0 ] - 06-06-2020

#### - :boom: [Breaking Change]

- Optimized scripts loaded for Firestore / Realtime

#### - :bug: [Bug Fix]

- Sanitized string before displaying on the frontend

#### - :rocket: [New Feature]

- Retrieved data dynamically with firebase uid as document id
- Added search shortcode for Firestore
- Added options to deploy cloud functions to different regions

#### - :nail_care: [Polish]

- Updated FirebaseUI Web version to v4.5.1
- Updated Firebase scripts to v7.15.0

## [ 1.0.0 ] - 30-05-2020

- Autofill firebase UID to input form
- Added account management shortcode
- Added phone number authentication
- Added language support for FirebaseUI Web
- Localization the plugin

## [ 0.20.0 ] - 24-05-2020

- Added wp logout link to Logout button
- Allowed to change log in text button
- Added reset password link to login form
- Display fields must be filled for display items for realtime/firstore
- Allowed multi realtime/firestore shortcodes on one page
- Dynamic show firestore/realtime data through query params

## [ 0.19.0 ] - 17-05-2020

- Separated registration & Login form
- Allow login to WordPress through social media platforms
- Added images support for Realtime / Firestore Document
- Fixed access array offset notice error

## [ 0.18.0 ] - 09-05-2020

- Showed deep level object when searching for database
- Added ability to download Users table
- Redirect to defined page after login
- Enable login through apple
- Added map type when saving data to firebase
- Added display types for realtime / firestore document
- Displayed data from firestore / realtime as blocks

## [ 0.17.0 ] - 27-04-2020

- Applied security rules when saving data to firebase
- Only sync public post to firebase

## [ 0.16.0 ] - 26-04-2020

- Added BuddyPress extension

## [ 0.15.0 ] - 18-04-2020

- Added Maps extension

## [ 0.14.0 ] - 12-04-2020

- Removed custom claims when empty
- Added shortcodes for displaying realtime & firestore collection

## [ 0.13.0 ] - 11-04-2020

- Added table structure for Users tab
- Make email uneditable for search purpose
- Functions (0.11.0): increased get users limit (> 1000 users)

## [ 0.12.0 ] - 08-04-2020

- Added filter feature for Users #29

## [ 0.11.1 ] - 07-04-2020

- Showed warning if base domain is not set
- Check for undefined in order to pass error check
- Updated options for plugin deletion

## [ 0.11.0 ] - 02-04-2020

- Used wait for element rather than setTimeOut
- Added logout event to all logout links
- Added post thumbnail and author name to Firebase Sync
- Updated Firebase script from 7.9.3 to 7.13.1

## [ 0.10.0 ] - 01-04-2020

- Added date type for saving data to Firebase
- Increase time wait for error in form submit to Firebase

## [ 0.9.1 ] - 29-03-2020

- Fixed ArrayType when saving data to Realtime/Firestore
- Fixed WP post type is null when sync data to Firebase

## [ 0.9.0 ] - 28-03-2020

- Fixed save data to realtime / firestore token error
- Added document id option when saving data
- Added trigger for syncing post and page to Firebase

## [ 0.8.0 ] - 24-03-2020

- Logout of everything when clicking signout buttons
- Added warning before deleting a Firebase user
- Added user role (Customer) for WooCommerce sites
- Prevent user to change password when login through firebase is active
- User password will be dominated by Firebase procedure

## [ 0.7.0 ] - 13-03-2020

- Styled add new user button
- Created and log in Firebase Users to WordPress
- Redirect login page feature
- Added Rest API for creating new Users (Subscriber)
- Updated FirebaseUI Web to 4.5.0
- Bring Firebase Menu to the front
- Prevent normal user to see dashboard token when they log in
- Updated about page
- Removed sourcemap on production
- Show realtime & firestore data based on security rules

## [ 0.6.0 ] - 01-03-2020

- Update firebase scripts from 7.8.2 to 7.9.3
- Added send cloud message to a topic feature

## [ 0.5.8 ] - 20-02-2020

- Breaking change for getting database: you need to update wordpress firebase functions to 0.5.8.
- Added create data for Realtime database & firestore with Contact Form 7
- Added warning for missing [firebaseui_web] globally
- Moved environment variables to one source

## [ 0.5.7 ] - 16-02-2020

- Updated firebase scripts to v7.8.2
- Hide greetings when signing out

## [ 0.5.6 ] - 18-01-2020

- Display data with claims

## [ 0.5.5 ] - 21-12-2019

- Breaking changes
- Deprecated authention process and replaced with firebasui-web

## [ 0.5.4 ] - 01-12-2019

- Updated packages
- Moved error and message to the top of dashboard
- Add CRUD to manage Firebase User from Dashboard

## [ 0.5.3 ] - 22-09-2019

- Added user register form to frontend #4
- Show firestore database after login #10
- Added delete user from dashboard #11
- Search document from firestore or realtime
- Update firebase version

## [ 0.5.2 ] - 30-03-2019

- Show realtime database after login

## [ 0.5.1 ] - 11-08-2018

- Hide login form after logging in

## [ 0.5.0 ] - 04-08-2018

- Add shortcode to display when not login
- Add error handling shortcode

## [ 0.4.0 ] - 17-07-2018

- Added Firestore database support in Dashboard

## [ 0.3.2 ] - 17-07-2018

- Fixed firebase-show shortcode

## [ 0.3.1 ] - 17-07-2018

- Fixed getting credentials

## [ 0.3.0 ] - 02-07-2018

- Added about information
- Added Real Time database support in Dashboard

## [ 0.2.0 ] - 25-5-2018

- Added firebase scripts and styles to header
- Implement login and logout features

## [ 0.1.0 ]

- Started the project and add an authentication method
