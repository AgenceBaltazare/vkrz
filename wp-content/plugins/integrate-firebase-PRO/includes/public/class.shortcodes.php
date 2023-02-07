<?php
class Firebase_Shortcode {
  private static $initiated = false;

  public static function init() {
    if (!self::$initiated) {
      self::init_hooks();
    }
  }

  public static function init_hooks() {
    self::$initiated = true;

    // FirebaseUI
    add_shortcode('firebaseui_web', array('Firebase_Shortcode', 'firebase_ui_web_func'));

    // Login & Logout
    add_shortcode('firebase_auth', array('Firebase_Shortcode', 'firebase_auth_func'));
    add_shortcode('firebase_login', array('Firebase_Shortcode', 'firebase_login_func'));
    add_shortcode('firebase_logout', array('Firebase_Shortcode', 'firebase_logout_func'));
    add_shortcode('firebase_greetings', array('Firebase_Shortcode', 'firebase_greetings_func'));
    add_shortcode('firebase_error', array('Firebase_Shortcode', 'firebase_error_func'));

    // General data
    add_shortcode('firebase_show', array('Firebase_Shortcode', 'firebase_show_func'));
    add_shortcode('firebase_show_not_login', array('Firebase_Shortcode', 'firebase_show_not_login_func'));
    add_shortcode('firebase_show_with_claims', array('Firebase_Shortcode', 'firebase_show_with_claims_func'));

    // User Management
    add_shortcode('firebase_register', array('Firebase_Shortcode', 'firebase_register_func'));
    add_shortcode('firebase_forgot_password', array('Firebase_Shortcode', 'firebase_forgot_password_func'));

    // Realtime database
    add_shortcode('realtime', array('Firebase_Shortcode', 'realtime_func'));
    add_shortcode('realtime_col', array('Firebase_Shortcode', 'realtime_col_func'));
    add_shortcode('realtime_blocks', array('Firebase_Shortcode', 'realtime_blocks_func'));

    // Firestore database
    add_shortcode('firestore', array('Firebase_Shortcode', 'firestore_func'));
    add_shortcode('firestore_col', array('Firebase_Shortcode', 'firestore_col_func'));
    add_shortcode('firestore_blocks', array('Firebase_Shortcode', 'firestore_blocks_func'));
    add_shortcode('firestore_search', array('Firebase_Shortcode', 'firestore_search_func'));
  }

  /**
   * FirebaseUI for Web
   */

  public static function firebase_ui_web_func($atts) {
    $redirect = "";
    $send_email_confirmation = "";

    if (isset($atts['redirect'])) {
      $redirect = $atts['redirect'];
    }

    if (isset($atts['send_email_confirmation'])) {
      $send_email_confirmation = $atts['send_email_confirmation'];
    }

    return "<div
        id='firebaseui-auth-container'
        data-redirect='$redirect'
        data-send-email-confirmation='$send_email_confirmation'
        >
      </div>";
  }

  /**
   * Login & Logout
   */

  public static function firebase_auth_func($atts) {
    $redirect = '';
    $send_email_confirmation = '';
    $forgot_password_link = '';

    if (isset($atts['redirect'])) {
      $redirect = $atts['redirect'];
    }

    if (isset($atts['send_email_confirmation'])) {
      $send_email_confirmation = $atts['send_email_confirmation'];
    }

    if (isset($atts['forgot_password_link'])) {
      $forgot_password_link = $atts['forgot_password_link'];
    }


    return "<firebase-auth 
      redirect='$redirect' 
      emailConfirmation='$send_email_confirmation'  
      forgotPasswordLink='$forgot_password_link'
      ></firebase-auth>";
  }

  public static function firebase_login_func($atts) {
    $redirect = '';
    $send_email_confirmation = '';
    $forgot_password_link = '';
    $button_text = 'Login';

    if (isset($atts['redirect'])) {
      $redirect = $atts['redirect'];
    }

    if (isset($atts['send_email_confirmation'])) {
      $send_email_confirmation = $atts['send_email_confirmation'];
    }

    if (isset($atts['button_text'])) {
      $button_text = $atts['button_text'];
    }

    if (isset($atts['forgot_password_link'])) {
      $forgot_password_link = $atts['forgot_password_link'];
    }

    return "<firebase-login 
      redirect='$redirect' 
      emailConfirmation='$send_email_confirmation' 
      buttonText='$button_text' 
      forgotPasswordLink='$forgot_password_link'
    ></firebase-login>";
  }

  public static function firebase_logout_func($atts) {
    $redirect = '';
    $button_text = 'Sign Out';

    if (isset($atts['redirect'])) {
      $redirect = $atts['redirect'];
    }

    if (isset($atts['button_text'])) {
      $button_text = $atts['button_text'];
    }

    $logout_url = wp_logout_url($redirect);
    return "<button class='button' id='firebase-signout' data-logout='$logout_url' data-redirect='$redirect'>" . __($button_text, 'integrate-firebase-PRO') . "</button>";
  }

  public static function firebase_greetings_func() {
    return "<div id='firebase-user'></div>";
  }

  public static function firebase_error_func($atts) {
    $class_name = "";
    if (isset($atts['class'])) {
      $class_name = $atts['class'];
    }
    $html = "";
    $html .= "<div class='$class_name'>";
    $html .= "<div id='firebase-error' class='error'></div>";
    $html .= "</div>";
    return $html;
  }

  /**
   * General Data
   */

  /**
   * Show Data for Logged In User
   *
   * @param [type] $atts
   * @param [type] $content
   * @return string
   */
  public static function firebase_show_func($atts, $content) {

    if (!is_user_logged_in()) {
      return '';
    }

    $class_name = "";
    if (isset($atts['class'])) {
      $class_name = $atts['class'];
    }
    $html = "";
    $html .= "<div class='firebase-show $class_name'>";
    $html .= $content;
    $html .= "</div>";
    return $html;
  }

  /**
   * Show Data for Not logged In User
   *
   * @param [type] $atts
   * @param [type] $content
   * @return string
   */
  public static function firebase_show_not_login_func($atts, $content) {

    if (is_user_logged_in()) {
      return '';
    }

    $class_name = "";
    if (isset($atts['class'])) {
      $class_name = $atts['class'];
    }
    $html = "";
    $html .= "<div class='firebase-show-when-not-login $class_name'>";
    $html .= $content;
    $html .= "</div>";
    return $html;
  }

  /**
   * Show data for logged in user with claims
   *
   * @param [type] $atts
   * @param [type] $content
   * @return string
   */
  public static function firebase_show_with_claims_func($atts, $content) {
    $class_name = "";
    $claims = "";
    $message = "";
    if (isset($atts['class'])) {
      $class_name = $atts['class'];
    }
    if (isset($atts['claims'])) {
      $claims = $atts['claims'];
    }
    if (isset($atts['message'])) {
      $message = $atts['message'];
    }
    $html = "";
    $html .= "<div class='firebase-show-with-claims $class_name' data-message='$message' data-claims='$claims'>";
    $html .= $content;
    $html .= "</div>";
    return $html;
  }

  /**
   * User Management
   */

  public static function firebase_register_func($atts) {
    $extra_fields = '';
    $required_fields = '';
    $redirect = '';
    $send_email_confirmation = '';

    if (isset($atts['extra_fields'])) {
      $extra_fields = $atts['extra_fields'];
    }

    if (isset($atts['required_fields'])) {
      $required_fields = $atts['required_fields'];
    }

    if (isset($atts['redirect'])) {
      $redirect = $atts['redirect'];
    }

    if (isset($atts['send_email_confirmation'])) {
      $send_email_confirmation = $atts['send_email_confirmation'];
    }

    $html = "
      <noscript style='display: block'>
        <div style='color:red'>This page needs JavaScript activated to work.</div>
        <style>form#firebase-register-form { display:none; }</style>
      </noscript>
    ";

    $html .= "<form
      id='firebase-register-form'
      data-redirect='$redirect'
      data-send-email-confirmation='$send_email_confirmation'
      method='POST'
    >";

    if (strpos($extra_fields, 'firstName') !== false) {
      $firstNameRequired = strpos($required_fields, 'firstName') !== false ? 'required' : '';
      $html .= "<div>";
      $html .= "<label for='firstName'>" . __('First Name', 'integrate-firebase-PRO') . "</label>";
      $html .= "<input type='text' name='firstName' $firstNameRequired>";
      $html .= "</div>";
    }

    if (strpos($extra_fields, 'lastName') !== false) {
      $lastNameRequired = strpos($required_fields, 'lastName') !== false ? 'required' : '';
      $html .= "<div>";
      $html .= "<label for='lastName'>" . __('Last Name', 'integrate-firebase-PRO') . "</label>";
      $html .= "<input type='text' name='lastName' $lastNameRequired>";
      $html .= "</div>";
    }

    $html .= "<div>";
    $html .= "<label for='email'>" . __('E-mail', 'integrate-firebase-PRO') . "</label>";
    $html .= "<input type='email' name='email' required>";
    $html .= "</div>";

    if (strpos($extra_fields, 'phoneNumber') !== false) {
      $phoneNumberRequired = strpos($required_fields, 'phoneNumber') !== false ? 'required' : '';
      $html .= "<div>";
      $html .= "<label for='phoneNumber'>" . __('Phone Number', 'integrate-firebase-PRO') . "</label>";
      $html .= "<input type='text' name='phoneNumber' $phoneNumberRequired>";
      $html .= "</div>";
    }

    $html .= "<div>";
    $html .= "<label for='password'>" . __('Password', 'integrate-firebase-PRO') . "</label>";
    $html .= "<input type='password' name='password' required>";
    $html .= "</div>";

    $html .= "<div>";
    $html .= "<label for='confirmPassword'>" . __('Confirm Password', 'integrate-firebase-PRO') . "</label>";
    $html .= "<input type='password' name='confirmPassword' required>";
    $html .= "</div>";

    $html .= "<div>";
    $html .= "<button class='button' type='submit' id='firebase-register-form__submit'>" . __('Register', 'integrate-firebase-PRO') . "</button>";
    $html .= "</div>";


    $html .= "<br />";
    $html .= "<p id='firebase-register-form__error'></p>";

    $html .= "</form>";
    return $html;
  }

  public static function firebase_forgot_password_func($atts) {
    $button_text = 'Submit';

    if (isset($atts['button_text'])) {
      $button_text = $atts['button_text'];
    }

    return "<firebase-forgot-password buttonText=$button_text></firebase-forgot-password>";
  }

  /**
   * Realtime Collection
   */
  public static function realtime_col_func($atts) {
    $class_name = "";
    $collection_name = "";
    $display_fields = "";
    $display_type = "table";

    if (isset($atts['class'])) {
      $class_name = $atts['class'];
    }

    if (isset($atts['collection_name'])) {
      $collection_name = $atts['collection_name'];
    }

    if (isset($atts['display_fields'])) {
      $display_fields = $atts['display_fields'];
    }

    $html = "";
    $html .= "<div class='if-realtime-col $class_name' data-collection-name='$collection_name' data-display-fields='$display_fields' data-display-type='$display_type'>";
    $html .= "</div>";
    return $html;
  }

  /**
   * Realtime database
   */
  public static function realtime_func($atts) {
    $class_name = "";
    $collection_name = "";
    $document_name = "";
    $display_fields = "";
    $display_type = "";
    $images = "";

    if (isset($atts['class'])) {
      $class_name = $atts['class'];
    }

    if (isset($atts['collection_name'])) {
      $collection_name = $atts['collection_name'];
    }

    if (isset($atts['document_name'])) {
      $document_name = $atts['document_name'];
    }

    // Manually set document_name through query
    if (isset($_GET['docId'])) {
      $document_name = (string) $_GET['docId'];
    }

    if (isset($atts['display_fields'])) {
      $display_fields = $atts['display_fields'];
    }

    if (isset($atts['display_type'])) {
      $display_type = $atts['display_type'];
    }

    if (isset($atts['images'])) {
      $images = $atts['images'];
    }

    $html = "";
    $html .= "<div
      class='if-realtime-doc $class_name'
      data-collection-name='$collection_name'
      data-document-name='$document_name'
      data-display-fields='$display_fields'
      data-display-type='$display_type'
      data-images='$images'>";
    $html .= "</div>";
    return $html;
  }

  public static function realtime_blocks_func($atts) {
    $class_name = "";
    $collection_name = "";
    $images = "";
    $display_fields = "";
    $order_by = "";

    if (isset($atts['class'])) {
      $class_name = $atts['class'];
    }

    if (isset($atts['collection_name'])) {
      $collection_name = $atts['collection_name'];
    }

    if (isset($atts['images'])) {
      $images = $atts['images'];
    }

    if (isset($atts['display_fields'])) {
      $display_fields = $atts['display_fields'];
    }

    if (isset($atts['order_by'])) {
      $order_by = $atts['order_by'];
    }

    $html = "
          <div
            class='if-realtime-blocks $class_name'
            data-collection-name='$collection_name'
            data-images='$images'
            data-display-fields='$display_fields'
            data-order-by='$order_by'
          ></div>
    ";
    return $html;
  }

  /**
   * Realtime Collection
   */
  public static function firestore_col_func($atts) {
    $class_name = "";
    $collection_name = "";
    $display_fields = "";
    $display_type = "table";
    $order_by = "";
    $limit = "";
    // page navigation
    $child_page = "";
    $child_page_target_field = "";

    if (isset($atts['class'])) {
      $class_name = $atts['class'];
    }

    if (isset($atts['collection_name'])) {
      $collection_name = $atts['collection_name'];
    }

    if (isset($atts['display_fields'])) {
      $display_fields = $atts['display_fields'];
    }

    if (isset($atts['order_by'])) {
      $order_by = $atts['order_by'];
    }

    if (isset($atts['limit'])) {
      $limit = $atts['limit'];
    }

    if (isset($atts['child_page'])) {
      $child_page = $atts['child_page'];
    }

    if (isset($atts['child_page_target_field'])) {
      $child_page_target_field = $atts['child_page_target_field'];
    }

    $html = "
          <div
            class='if-firestore-col $class_name'
            data-collection-name='$collection_name'
            data-display-fields='$display_fields'
            data-display-type='$display_type'
            data-order-by='$order_by'
            data-limit='$limit'
            data-child-page='$child_page'
            data-child-page-target-field='$child_page_target_field'
          >
          </div>
        ";
    return $html;
  }

  /**
   * Firestore database
   */
  public static function firestore_func($atts) {
    $class_name = "";
    $collection_name = "";
    $document_name = "";
    $display_fields = "";
    $display_type = "";
    $images = "";

    if (isset($atts['class'])) {
      $class_name = $atts['class'];
    }

    if (isset($atts['collection_name'])) {
      $collection_name = $atts['collection_name'];
    }

    if (isset($atts['document_name'])) {
      $document_name = $atts['document_name'];
    }

    // Manually set document_name through query
    if (isset($_GET['docId'])) {
      $document_name = (string) $_GET['docId'];
    }

    if (isset($atts['display_fields'])) {
      $display_fields = $atts['display_fields'];
    }

    if (isset($atts['display_type'])) {
      $display_type = $atts['display_type'];
    }

    if (isset($atts['images'])) {
      $images = $atts['images'];
    }

    $html = "
          <div
            class='if-firestore-doc $class_name'
            data-collection-name='$collection_name'
            data-document-name='$document_name'
            data-display-fields='$display_fields'
            data-display-type='$display_type'
            data-images='$images'
          ></div>";
    return $html;
  }

  public static function firestore_blocks_func($atts) {
    $class_name = "";
    $collection_name = "";
    $images = "";
    $display_fields = "";
    $order_by = "";
    $limit = "";
    // page navigation
    $child_page = "";
    $child_page_target_field = "";

    if (isset($atts['class'])) {
      $class_name = $atts['class'];
    }

    if (isset($atts['collection_name'])) {
      $collection_name = $atts['collection_name'];
    }

    if (isset($atts['images'])) {
      $images = $atts['images'];
    }

    if (isset($atts['display_fields'])) {
      $display_fields = $atts['display_fields'];
    }

    if (isset($atts['order_by'])) {
      $order_by = $atts['order_by'];
    }

    if (isset($atts['limit'])) {
      $limit = $atts['limit'];
    }

    if (isset($atts['child_page'])) {
      $child_page = $atts['child_page'];
    }

    if (isset($atts['child_page_target_field'])) {
      $child_page_target_field = $atts['child_page_target_field'];
    }

    $html = "
          <div
            class='if-firestore-blocks $class_name'
            data-collection-name='$collection_name'
            data-images='$images'
            data-display-fields='$display_fields'
            data-order-by='$order_by'
            data-limit='$limit'
            data-child-page='$child_page'
            data-child-page-target-field='$child_page_target_field'
          >
          </div>
        ";
    return $html;
  }

  public static function firestore_search_func($atts) {
    $class_name = "";
    $collection_name = "";
    $search_fields = "";
    $search_operators = "";
    $search_conditions = "";
    $images = "";
    $display_fields = "";
    $display_type = "table";
    $order_by = "";
    $limit = "";

    if (isset($atts['class'])) {
      $class_name = $atts['class'];
    }

    if (isset($atts['collection_name'])) {
      $collection_name = $atts['collection_name'];
    }

    if (isset($atts['search_fields'])) {
      $search_fields = $atts['search_fields'];
    }

    if (isset($atts['search_operators'])) {
      $search_operators = $atts['search_operators'];
    }

    if (isset($atts['search_conditions'])) {
      $search_conditions = $atts['search_conditions'];
    }

    if (isset($atts['images'])) {
      $images = $atts['images'];
    }

    if (isset($atts['display_fields'])) {
      $display_fields = $atts['display_fields'];
    }

    if (isset($atts['display_type'])) {
      $display_type = $atts['display_type'];
    }

    if (isset($atts['order_by'])) {
      $order_by = $atts['order_by'];
    }

    if (isset($atts['limit'])) {
      $limit = $atts['limit'];
    }

    $html = "
          <div
            class='if-firestore-search $class_name'
            data-collection-name='$collection_name'
            data-search-fields='$search_fields'
            data-search-operators='$search_operators'
            data-search-conditions='$search_conditions'
            data-images='$images'
            data-display-fields='$display_fields'
            data-display-type='$display_type'
            data-order-by='$order_by'
            data-limit='$limit'
          ></div>
        ";
    return $html;
  }
}
