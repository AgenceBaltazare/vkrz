<?php

/**
 * Frontend messages
 *
 * Returns an array of languages.
 *
 */

defined('ABSPATH') || exit;

return array(
  "auth" => array(
    "email" => esc_html__('E-mail', 'integrate-firebase-PRO'),
    "password" => esc_html__('Password', 'integrate-firebase-PRO'),
    "emailAddress" => esc_html__('Email Address', 'integrate-firebase-PRO'),
    "enterEmailAddress" => esc_html__('Enter email address', 'integrate-firebase-PRO'),
    "signInToYourAccount" => esc_html__('Sign in to your account', 'integrate-firebase-PRO'),
    "resetPassword" => esc_html__('Reset Password', 'integrate-firebase-PRO'),
    "dontHaveAnAccount" => esc_html__("Don’t have an account?", 'integrate-firebase-PRO'),
    "forgotPassword" => esc_html__('Forgot password', 'integrate-firebase-PRO'),
    "emailPasswordMissing" => esc_html__('Your email or password is missing!', 'integrate-firebase-PRO'),
    "enterMissingData" => esc_html__('Please enter missing data!', 'integrate-firebase-PRO'),
    "confirmPassword" => esc_html__('Confirm password is not the same!', 'integrate-firebase-PRO'),
    "invalidPhoneNumber" => esc_html__('Phone number is invalid', 'integrate-firebase-PRO'),
    "invalidForm" => esc_html__('Form is not valid', 'integrate-firebase-PRO'),
    "signUp" => esc_html__('Sign up', 'integrate-firebase-PRO'),
    "createYourAccount" => esc_html__('Create your account', 'integrate-firebase-PRO'),
    "alreadyHaveAnAccount" => esc_html__('Already have an account?', 'integrate-firebase-PRO'),
    "signUpWith" => esc_html__('Sign up with', 'integrate-firebase-PRO'),
    "signIn" => esc_html__('Sign in', 'integrate-firebase-PRO'),
    "signInWith" => esc_html__('Sign in with', 'integrate-firebase-PRO'),
    "emailNeededForReset" => esc_html__('Enter your email in order to reset the password.', 'integrate-firebase-PRO'),
    "checkInboxForReset" => esc_html__('Please check your inbox in order to reset your password.', 'integrate-firebase-PRO'),
    "resendVerificationEmail" => esc_html__('Your email address is not verified. Would you like to resend verification email?', 'integrate-firebase-PRO'),
    // https://www.gstatic.com/firebasejs/8.7.1/firebase-auth.js
    "auth/user-not-found" => esc_html__('There is no user record corresponding to this identifier. The user may have been deleted.', 'integrate-firebase-PRO'),
    "auth/wrong-password" => esc_html__('The password is invalid or the user does not have a password.', 'integrate-firebase-PRO'),
    "auth/invalid-email" => esc_html__('The email address is badly formatted.', 'integrate-firebase-PRO'),
    "auth/email-already-in-use" => esc_html__('The email address is already in use by another account.', 'integrate-firebase-PRO'),
  ),
  "database" => array(
    "invalidDbType" => esc_html__("’dbType’ must be ’firestore’ or ’realtime’. Please check your form!", 'integrate-firebase-PRO'),
    "invalidCollectionOrDocument" => esc_html__("Please check your collection and document name in the shortcode!", 'integrate-firebase-PRO'),
    "emptyCollectionOrDocument" => esc_html__("Collection and document name cannot be empty!", 'integrate-firebase-PRO'),
    "invalidCollectionOrDisplayFields" => esc_html__("Please check your collection name and display fields in the shortcode!'", 'integrate-firebase-PRO'),
  ),
  "firebase" => array(
    "firebaseSettingsMissing" => esc_html__("Please enter your Firebase settings!", 'integrate-firebase-PRO'),
  ),
  "woocommerce" => array(
    "loginText" => esc_html__('Please login to check your account.', 'integrate-firebase-PRO'),
  ),
  "utils" => array(
    "greetings" => esc_html__("Greetings", 'integrate-firebase-PRO'),
    "invalidForm" => esc_html__("Form data is invalid", 'integrate-firebase-PRO'),
    "missingData" => esc_html__("Please enter missing data!", 'integrate-firebase-PRO'),
    "confirmPassword" => esc_html__("Confirm password is not the same!", 'integrate-firebase-PRO'),
    "userCreatedSuccessfully" => esc_html__("User is created successfully!", 'integrate-firebase-PRO'),
  ),
);
