<?php

defined( 'ABSPATH' ) or die( 'Not allowed' );

$messageUpdate = 0;
/* Update des paramètres */
if( isset($_POST['action']) && $_POST['action'] == 'update_countdown' && wp_verify_nonce($_POST['security-countdown'], 'valid-countdown') ) {

    if( empty($_POST["wpmcountdown"]["active_cpt"]) ) { $_POST["wpmcountdown"]["active_cpt"] = 0; }
    if( empty($_POST["wpmcountdown"]["active_cpt_s"]) ) { $_POST["wpmcountdown"]["active_cpt_s"] = 0; }
    if( empty($_POST["wpmcountdown"]["disable"]) ) { $_POST["wpmcountdown"]["disable"] = 0; }

    $updateSetting = wpm_update_settings( $_POST["wpmcountdown"], 'wp_maintenance_settings_countdown');
    if( $updateSetting == true ) { $messageUpdate = 1; }
}

// Récupère les paramètres sauvegardés
if(get_option('wp_maintenance_settings_countdown')) { extract(get_option('wp_maintenance_settings_countdown')); }
$paramsCountdown = get_option('wp_maintenance_settings_countdown');
?>

<div class="wrap">
    
    <!-- HEADER -->
    <h2 class="headerpage"><?php _e('WP Maintenance - Settings', 'wp-maintenance'); ?> <sup>v.<?php _e(WPM_VERSION); ?></sup></h2>
    <?php if( isset($message) && $message == 1 ) { ?>
        <div id="message" class="updated fade"><p><strong><?php _e('Options saved.', 'wp-maintenance'); ?></strong></p></div>
    <?php } ?>
    <!-- END HEADER -->

    <div class="wp-maintenance-wrapper">

        <?php echo wpm_get_nav2(); ?>
        
        <div class="wp-maintenance-tab-content wp-maintenance-tab-content-welcome" id="wp-maintenance-tab-content">

            <form method="post" action="" id="valide_settings" name="valide_settings">
                <input type="hidden" name="action" value="update_countdown" />
                <?php wp_nonce_field('valid-countdown', 'security-countdown'); ?>

                <!-- ACTIVER COMPTEUR -->
                <div class="wp-maintenance-module-options-block">

                    <div class="wp-maintenance-settings-section-header"><h3 class="wp-maintenance-settings-section-title" id="module-import_export"><?php _e('Enable a countdown', 'wp-maintenance'); ?></h3></div>
                    <p>
                        <label class="wp-maintenance-container"><span class="wp-maintenance-label-text"><?php _e('Yes, enable a countdown', 'wp-maintenance'); ?></span>
                            <input type="checkbox" name="wpmcountdown[active_cpt]" value="1" <?php if( isset($paramsCountdown['active_cpt']) && $paramsCountdown['active_cpt']==1) { echo ' checked'; } ?>>
                            <span class="wp-maintenance-checkmark"></span>
                        </label>
                    </p>
                    <p class="submit"><button type="submit" name="footer_submit" id="footer_submit" class="wp-maintenance-button wp-maintenance-button-primary"><?php _e('Save', 'wp-maintenance'); ?></button></p>
                </div>
                
                <div class="wp-maintenance-module-options-block">
                    <div class="wp-maintenance-settings-section-header">
                        <h3 class="wp-maintenance-settings-section-title" id="module-import_export"><?php _e('Date/time Launch', 'wp-maintenance'); ?></h3>
                    </div>

                    <h3><?php _e('Select the launch date/time', 'wp-maintenance'); ?></h3>

                    <div class="wp-maintenance-setting-row">
                        <?php 

                            // Old version compte à rebours
                            if ( empty($paramsCountdown['cptdate']) ) {
                                $paramsCountdown['cptdate'] = date('d').'/'.date('m').'/'.date('Y');
                            }

                            if( isset($paramsCountdown['cptdate']) && !empty($paramsCountdown['cptdate']) ) { 
                                $startDate = $paramsCountdown['cptdate']; 
                            }
                            if( isset($paramsCountdown['cpttime']) && !empty($paramsCountdown['cpttime']) ) { 
                                $startHour = $paramsCountdown['cpttime'];
                            }
                            if( (isset($paramsCountdown['active_cpt']) && $paramsCountdown['active_cpt']==0) || empty($paramsCountdown['active_cpt']) ) {
                                $startDate = date_i18n( date("Y").'/'.date("m").'/'.date("d") );
                                $timeFormats = array_unique( apply_filters( 'time_formats', array( 'H:i' ) ) );
                                foreach ( $timeFormats as $format ) {
                                    $startHour = date_i18n( $format );
                                }
                                $newMin = explode(':', $startHour);
                                //$startHour = $newMin[0].':'.ceil($newMin[1]/5)*5;
                            }                                
                        ?>
                        <img src="<?php echo plugins_url('../images/schedule_clock.png', __FILE__ ); ?>" class="datepicker" width="48" height="48" style="vertical-align: middle;margin-right:5px;">&nbsp;<input id="cptdate" class="datepicker" name="wpmcountdown[cptdate]" type="text" autofocuss data-value="<?php echo esc_html($startDate); ?>"> <?php _e('at', 'wp-maintenance'); ?> <input id="cpttime" class="timepicker" type="time" name="wpmcountdown[cpttime]" value="<?php echo esc_html($startHour); ?>" size="6" autofocuss>                                
                        <div id="wpmdatecontainer"></div>
                    </div>
                    <p class="submit"><button type="submit" name="footer_submit" id="footer_submit" class="wp-maintenance-button wp-maintenance-button-primary"><?php _e('Save', 'wp-maintenance'); ?></button></p>
                </div>
                <div class="wp-maintenance-module-options-block">

                    <div class="wp-maintenance-settings-section-header">
                        <h3 class="wp-maintenance-settings-section-title" id="module-import_export"><?php _e('Others Settings', 'wp-maintenance'); ?></h3>
                    </div>

                    <h3><?php _e('Enable seconds ?', 'wp-maintenance'); ?></h3>

                    <p>
                        <label class="wp-maintenance-container"><span class="wp-maintenance-label-text"><?php _e('Yes, enable seconds', 'wp-maintenance'); ?></span>
                            <input type="checkbox" name="wpmcountdown[active_cpt_s]" value="1" <?php if( isset($paramsCountdown['active_cpt_s']) && $paramsCountdown['active_cpt_s']==1) { echo ' checked'; } ?>>
                            <span class="wp-maintenance-checkmark"></span>
                        </label>
                    </p>
                    <h3><?php _e('Disable maintenance mode at the end of the countdown?', 'wp-maintenance'); ?></h3>
                    <p>
                        <label class="wp-maintenance-container"><span class="wp-maintenance-label-text"><?php _e('Yes, disable maintenance mode at the end of countdown', 'wp-maintenance'); ?></span>
                            <input type="checkbox" name="wpmcountdown[disable]" value="1" <?php if( isset($paramsCountdown['disable']) && $paramsCountdown['disable']==1) { echo ' checked'; } ?>>
                            <span class="wp-maintenance-checkmark"></span>
                        </label>
                    </p>
                    <h3><?php _e('End message after end countdown', 'wp-maintenance'); ?></h3>           
                    <?php 
                        $settingsCountdown =   array(
                            'wpautop' => true, // use wpautop?
                            'media_buttons' => false, // show insert/upload button(s)
                            'textarea_name' => 'wpmcountdown[message_cpt_fin]', // set the textarea name to something different, square brackets [] can be used here
                            'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
                            'tabindex' => '',
                            'editor_css' => '', //  extra styles for both visual and HTML editors buttons, 
                            'editor_class' => 'message_cpt_fin', // add extra class(es) to the editor textarea
                            'teeny' => true, // output the minimal editor config used in Press This
                            'dfw' => false, // replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
                            'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
                            'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
                        );
                    $textCpt_fin =  '';
                    if( isset($paramsCountdown['message_cpt_fin']) && $paramsCountdown['message_cpt_fin']!='' ) { $textCpt_fin = esc_textarea(stripslashes($paramsCountdown['message_cpt_fin'])); } else { $textCpt_fin = ' '; }
                    ?>
                    <?php wp_editor( nl2br($textCpt_fin), 'message_cpt_fin', $settingsCountdown ); ?>

                    <p class="submit"><button type="submit" name="footer_submit" id="footer_submit" class="wp-maintenance-button wp-maintenance-button-primary"><?php _e('Save', 'wp-maintenance'); ?></button></p>

                </div>
            </form>
        </div>

    </div>

    <?php echo wpm_footer(); ?>
    
</div>
<script type="text/javascript">                                    

    jQuery(document).ready(function() {

        var $input = jQuery( '.datepicker' ).pickadate({
            formatSubmit: 'yyyy/mm/dd',
            container: '#wpmdatecontainer',
            closeOnSelect: true,
            closeOnClear: false,
            firstDay: 1,
            min: new Date(<?php echo date('Y').','.(date('m')-1).','.date('d'); ?>),
            monthsFull: [ '<?php _e('January', 'wp-maintenance'); ?>', '<?php _e('February', 'wp-maintenance'); ?>', '<?php _e('March', 'wp-maintenance'); ?>', '<?php _e('April', 'wp-maintenance'); ?>', '<?php _e('May', 'wp-maintenance'); ?>', '<?php _e('June', 'wp-maintenance'); ?>', '<?php _e('July', 'wp-maintenance'); ?>', '<?php _e('August', 'wp-maintenance'); ?>', '<?php _e('September', 'wp-maintenance'); ?>', '<?php _e('October', 'wp-maintenance'); ?>', '<?php _e('November', 'wp-maintenance'); ?>', '<?php _e('December', 'wp-maintenance'); ?>' ],
            monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec' ],
            weekdaysShort: [ '<?php _e('Sunday', 'wp-maintenance'); ?>', '<?php _e('Monday', 'wp-maintenance'); ?>', '<?php _e('Tuesday', 'wp-maintenance'); ?>', '<?php _e('Wednesday', 'wp-maintenance'); ?>', '<?php _e('Thurday', 'wp-maintenance'); ?>', '<?php _e('Friday', 'wp-maintenance'); ?>', '<?php _e('Saturday', 'wp-maintenance'); ?>' ],
            today: "<?php _e('Today', 'wp-maintenance'); ?>",
            clear: '<?php _e('Delete', 'wp-maintenance'); ?>',
            close: '<?php _e('Close', 'wp-maintenance'); ?>',

            // Accessibility labels
            labelMonthNext: '<?php _e('Next month', 'wp-maintenance'); ?>',
            labelMonthPrev: '<?php _e('Previous month', 'wp-maintenance'); ?>',
            labelMonthSelect: '<?php _e('Select a month', 'wp-maintenance'); ?>',
            labelYearSelect: '<?php _e('Select a year', 'wp-maintenance'); ?>',

            selectMonths: true,
            selectYears: true,


        })

        var picker = $input.pickadate('picker')


        var $input = jQuery( '.timepicker' ).pickatime({
            //container: '#wpmtimecontainer',
            clear: '<?php _e('Close', 'wp-maintenance'); ?>',
            interval: 5,
            editable: undefined,
            format: 'HH:i', // retour ce format dans le input
            formatSubmit: 'HH:i', // return ce format en post
            formatLabel: '<b>HH</b>:i', // Affichage

        })
        var picker = $input.pickatime('picker')

    });

</script>