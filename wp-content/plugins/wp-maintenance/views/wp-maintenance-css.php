<?php

defined( 'ABSPATH' ) or die( 'Not allowed' );

$messageUpdate = 0;
/* Update des paramètres */
if( isset($_POST['action']) && $_POST['action'] == 'update_css' && wp_verify_nonce($_POST['security-css'], 'valid-css') ) {

    update_option('wp_maintenance_style', stripslashes($_POST["wp_maintenance_style"]));
    $options_saved = true;

    $messageUpdate = 1;
}

/* Si on réinitialise les feuille de styles  */
if( isset($_POST['wpm_initcss']) && $_POST['wpm_initcss']==1) {
    update_option( 'wp_maintenance_style', wpm_print_style() );
    //$options_saved = true;
    echo '<div id="message" class="updated fade"><p><strong>'.__('The Style Sheet has been reset!', 'wp-maintenance').'</strong></p></div>';
}

?>
<style>
    .CodeMirror {
      border: 1px solid #eee;
      height: 750px;
    }
    
</style>
<div class="wrap">

    <!-- HEADER -->
    <?php echo wpm_get_header( $messageUpdate ) ?>
    <!-- END HEADER -->

    <div class="wp-maintenance-wrapper wp-maintenance-flex wp-maintenance-flex-top">
        
        <?php echo wpm_get_nav(); ?>
            
        <div class="wp-maintenance-tab-content wp-maintenance-tab-content-welcome" id="wp-maintenance-tab-content">
            
            <div class="wp-maintenance-tab-content-header"><i class="dashicons dashicons-media-code" style="margin-right: 10px;height:50px;width:50px;font-size:50px;padding: 8px 8px 14px 10px;border-radius: 5px;display: inline;float:left;"></i>  <h2 class="wp-maintenance-tc-title"><?php _e('CSS', 'wp-maintenance'); ?></h2></div>

            <div class="wp-maintenance-module-options-block" id="block-advanced_options" data-module="welcome">
                
                <form method="post" action="" id="valide_settings" name="valide_settings">
                    <input type="hidden" name="action" value="update_css" />
                    <?php wp_nonce_field('valid-css', 'security-css'); ?>

                    <!-- PIED DE PAGE  -->
                    <div class="wp-maintenance-settings-section-header"><h3 class="wp-maintenance-settings-section-title" id="module-import_export"><?php _e('Edit the CSS sheet of your maintenance page here.', 'wp-maintenance'); ?></h3></div>
                    <h3><?php _e('Click "Reset" and "Save" to retrieve the default style sheet.', 'wp-maintenance'); ?></h3>
                    <TEXTAREA NAME="wp_maintenance_style" id="wpmaintenancestyle" COLS=70 ROWS=24 style="height:350px;"><?php echo esc_textarea(stripslashes(trim(get_option('wp_maintenance_style')))); ?></TEXTAREA>
                    <?php //echo wpm_compress(get_option('wp_maintenance_style')); ?>
                    
                    <p class="wp-maintenance-fieldset-item ">
                        <label class="wp-maintenance-container"><span class="wp-maintenance-label-text"><?php _e('Yes, reset style sheet', 'wp-maintenance'); ?></span>
                            <input type="checkbox" name="wpm_initcss" value="1">
                            <span class="wp-maintenance-checkmark"></span>
                        </label>
                    </p>

                    <p class="submit"><button type="submit" name="footer_submit" id="footer_submit" class="wp-maintenance-button wp-maintenance-button-primary"><?php _e('Save', 'wp-maintenance'); ?></button></p>

                    <div class="wp-maintenance-settings-section-header"><h3 class="wp-maintenance-settings-section-title" id="module-import_export"><?php _e('Markers for colors', 'wp-maintenance'); ?></h3></div>
                    <div class="wp-maintenance-setting-row">
                        <label for="wp_maintenance_settings[color_text_bottom]" class="wp-maintenance-setting-row-title">#_COLORTXT</label> <?php _e('Use this code for text color', 'wp-maintenance'); ?>
                        <label for="wp_maintenance_settings[color_text_bottom]" class="wp-maintenance-setting-row-title">#_COLORBG</label> <?php _e('Use this code for background text color', 'wp-maintenance'); ?>
                        <label for="wp_maintenance_settings[color_text_bottom]" class="wp-maintenance-setting-row-title">#_COLORCPTBG</label> <?php _e('Use this code for background color countdown', 'wp-maintenance'); ?>
                        <label for="wp_maintenance_settings[color_text_bottom]" class="wp-maintenance-setting-row-title">#_DATESIZE</label> <?php _e('Use this code for size countdown', 'wp-maintenance'); ?>
                        <label for="wp_maintenance_settings[color_text_bottom]" class="wp-maintenance-setting-row-title">#_COLORCPT</label> <?php _e('Use this code for countdown color', 'wp-maintenance'); ?>
                    </div>
                    
                    <br />                
                    <a href="" onclick="AfficherCacher('divcss'); return false" ><?php _e('Need CSS code for MailPoet plugin?', 'wp-maintenance'); ?></a>
                    <div id="divcss" style="display:none;"><i><?php _e('Click for select all', 'wp-maintenance'); ?></i><br />
                        <textarea id="css-mailpoet" onclick="select()" rows="15" cols="50%">
.abs-req { display: none; }
.widget_wysija_cont .wysija-submit { }
.widget_wysija input { }
.wysija-submit-field { }
.wysija-submit-field:hover { }
.widget_wysija input:focus { }
.wysija-submit-field:active { }
.widget_wysija .wysija-submit, .widget_wysija .wysija-paragraph { }
.wysija-submit-field { }
                    </textarea>
                </div>
                <br />
                <a href="" onclick="AfficherCacher('divcss2'); return false" ><?php _e('Need CSS code for MailChimp plugin?', 'wp-maintenance'); ?></a>
                <div id="divcss2" style="display:none;"><i><?php _e('Click for select all', 'wp-maintenance'); ?></i><br />
                    <textarea id="css-mailchimp" onclick="select()" rows="15" cols="50%">
.mc4wp-form {  } /* the form element */
.mc4wp-form p { } /* form paragraphs */
.mc4wp-form label {  } /* labels */
.mc4wp-form input { } /* input fields */
.mc4wp-form input[type="checkbox"] {  } /* checkboxes */
.mc4wp-form input[type="submit"] { } /* submit button */
.mc4wp-form input[type="submit"]:hover { } 
.mc4wp-form input[type="submit"]:active { }
.mc4wp-alert {  } /* success & error messages */
.mc4wp-success {  } /* success message */
.mc4wp-error {  } /* error messages */
                    </textarea>
                </div>

                </form>

            </div>
        </div>

    </div>
    <script>
        var editor = CodeMirror.fromTextArea(document.getElementById("wpmaintenancestyle"), {
        lineNumbers: true,
        matchBrackets: true,
        textWrapping: true,
        lineWrapping: true,
        mode: "text/x-scss",
        theme:"material"
        });
    </script> 
    
    <?php echo wpm_footer(); ?>
    
</div>