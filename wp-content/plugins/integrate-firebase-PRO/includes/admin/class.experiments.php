<?php

/**
 * Add Experiments to Firebase Menu
 */

defined('ABSPATH') || exit;

class FirebaseExperimentsAdmin {
    private static $initiated = false;
    private static $firebase_experiments;


    public static function init() {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    public static function init_hooks() {
        self::$initiated = true;
        self::$firebase_experiments = get_option('firebase_experiments');

        add_action("admin_init", array("FirebaseExperimentsAdmin", "register_settings"));
        add_action('admin_menu', array('FirebaseExperimentsAdmin', 'add_firebase_experiments_menu'));
    }

    public static function add_firebase_experiments_menu() {
        if ((is_plugin_active('integrate-firebase-PRO/init.php')) && class_exists('Firebase')) {
            add_submenu_page(
                'firebase-setting', // string $parent_slug
                'Firebase Experiments', // string $page_title,
                'Experiments', // string $menu_title,
                'manage_options', // string $capability,
                'firebase-experiments', // string $menu_slug,
                array('FirebaseExperimentsAdmin', 'add_firebase_experiments_menu_html') // callable $function = ''
            );
        }
    }

    public static function register_settings() {
        // Experiments General
        register_setting(
            'firebase_experiments_group',
            'firebase_experiments',
            array('FirebaseExperimentsAdmin', 'sanitize')
        );

        add_settings_section(
            'firebase_experiments_section_id', // ID
            'Check the boxes to turn on experiments features.', // Title
            array("FirebaseExperimentsAdmin", 'print_section_info'), // Callback
            'exp_general' // Page
        );

        add_settings_field(
            'ifp_allow_updating_email', // ID
            __('Allow Updating Email from WordPress', 'integrate-firebase-PRO'), // Title
            array("FirebaseExperimentsAdmin", 'ifp_allow_updating_email_callback'), // Callback
            'exp_general', // Page
            'firebase_experiments_section_id' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public static function sanitize($input) {
        $new_input = array();

        if (isset($input['ifp_allow_updating_email'])) {
            $new_input['ifp_allow_updating_email'] = sanitize_text_field($input['ifp_allow_updating_email']);
        }

        return $new_input;
    }

    public static function print_section_info() {
        print "<p><strong>Note</strong>: Experiments will be removed after a few releases. Please follow <a href='https://firebase-wordpress-docs.readthedocs.io/en/latest/' target='_blank'>our newsletter</a> for updating.</p>";
    }

    public static function ifp_allow_updating_email_callback() {
        echo "<input type='checkbox' id='ifp_allow_updating_email' name='firebase_experiments[ifp_allow_updating_email]' value='1'";
        if (isset(self::$firebase_experiments['ifp_allow_updating_email']) && self::$firebase_experiments['ifp_allow_updating_email'] == '1') {
            echo ' checked';
        }
        echo '/>';
    }

    public static function add_firebase_experiments_menu_html() {
        // check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }

        // Errors & Messages
        echo "<div id='firebase-error' class='error notice notice-error is-dismissible'></div>";
        echo "<div id='firebase-message' class='message notice notice-success is-dismissible'></div>";
        echo "<div id='firebase-warning' class='message notice notice-warning is-dismissible'></div>";
        settings_errors();

        echo "<div class='wrap'>";
        echo "<h1>Firebase Experiments</h1>";
        echo "<p>Experiment features before final releases.</p>";

        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'exp_general';
        $general_class = $active_tab === 'exp_general' ? 'nav-tab-active' : '';

        echo "<h2 class='nav-tab-wrapper'>";
        echo "<a href='?page=firebase-experiments&tab=general' class='nav-tab $general_class'>" . __('General', 'ifp-experiments') . "</a>";
        echo "</h2>";

        // Form
        echo "<form method='post' action='options.php'>";
        if ($active_tab === 'exp_general') {
            settings_fields('firebase_experiments_group');
            do_settings_sections('exp_general');
            submit_button();
        }
        echo '</form>';
        echo '</div>';
    }
}
