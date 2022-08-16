<?php
if (!defined('ABSPATH')) {
    die();
}
?>
<?php
$cron_job_key = PMXE_Plugin::getInstance()->getOption('cron_job_key');
$urlToExport = site_url() . '/wp-load.php?security_token=' . substr(md5($cron_job_key . $update_previous->id), 0, 16) . '&export_id=' . $update_previous->id . '&action=get_data';
$uploads = wp_upload_dir();

$bundle_path = wp_all_export_get_absolute_path($update_previous->options['bundlepath']);

if (!empty($bundle_path)) {
    $bundle_url = site_url() . '/wp-load.php?security_token=' . substr(md5($cron_job_key . $update_previous->id), 0, 16) . '&export_id=' . $update_previous->id . '&action=get_bundle&t=zip';
}

$isImportAllowedSpecification = new \Wpae\App\Specification\IsImportAllowed();

$cpt = $update_previous->options['cpt'];
if (is_array($cpt)) {
    $cpt = $cpt[0];
}

$is_rapid_addon_export = true;

if (strpos($cpt, 'custom_') !== 0) {
    $is_rapid_addon_export = false;
}

if (current_user_can(PMXE_Plugin::$capabilities)) {
    ?>
    <div id="export_finished" style="padding-top: 10px;">
        <?php
        if ($isGoogleFeed) {
            ?>
            <h3><?php esc_html_e('WP All Export successfully exported your data!', 'wp_all_export_plugin'); ?></h3>
        <?php
        $cronJobKey = PMXE_Plugin::getInstance()->getOption('cron_job_key');
        include_once('google_merchants_success.php');
        } else {
        ?>

            <h2 style="color:#425f9a; font-size:24px; margin-bottom: 36px;">What's next?</h2>

            <script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery('.success-tabs .tab').click(function () {
                        jQuery('.success-tabs .tab').removeClass('selected');
                        jQuery(this).addClass('selected');
                        var rel = jQuery(this).attr('rel');
                        jQuery('.tab-content').removeClass('selected');
                        jQuery('.tab-content-container').find('#' + rel).addClass('selected');
                    });
                });
            </script>
            <ul class="success-tabs">
                <li rel="tab1-content"
                    class="tab selected">
                        <?php esc_html_e("Download", 'wp_all_export_plugin'); ?>
                </li>
                <?php
                if (current_user_can(PMXE_Plugin::$capabilities) && !$update_previous->options['enable_real_time_exports']) {
                    ?>
                    <li rel="tab2-content" class="tab"><?php esc_html_e("Scheduling", 'wp_all_export_plugin'); ?></li>
                    <?php
                }
                ?>
                <li rel="tab3-content" class="tab"><?php esc_html_e("External Apps", 'wp_all_export_plugin'); ?></li>
                <?php if ($isImportAllowedSpecification->isSatisfied($update_previous) && !$update_previous->options['enable_real_time_exports']): ?>
                    <li rel="tab4-content"
                        class="tab"><?php esc_html_e("Export, Edit, Import", 'wp_all_export_plugin'); ?></li>
                <?php endif; ?>
                <?php if ($update_previous->options['enable_real_time_exports']): ?>
                    <li rel="tab5-content"
                        class="tab"><?php esc_html_e("What's Next", 'wp_all_export_plugin'); ?></li>
                <?php endif; ?>
            </ul>
        <hr style="margin-top:0;"/>
            <div class="tab-content-container">
                <div class="tab-content selected normal-tab" id="tab1-content">
                    <h3 style="margin-top: 30px; margin-bottom: 30px;"><?php esc_html_e("Click to Download", 'wp_all_export_plugin'); ?></h3>
                    <div class="input">
                        <button class="button button-primary button-hero wpallexport-large-button download_data"
                                rel="<?php echo esc_url_raw(add_query_arg(array('page' => 'pmxe-admin-manage', 'action' => 'download', 'id' => $update_previous->id, '_wpnonce' => wp_create_nonce('_wpnonce-download_feed')), $this->baseUrl)); ?>"><?php echo strtoupper(wp_all_export_get_export_format($update_previous->options)); ?></button>
                        <?php if (!empty($update_previous->options['split_large_exports'])): ?>
                            <button class="button button-primary button-hero wpallexport-large-button download_data"
                                    rel="<?php echo esc_url_raw(add_query_arg(array('page' => 'pmxe-admin-manage', 'id' => $update_previous->id, 'action' => 'split_bundle', '_wpnonce' => wp_create_nonce('_wpnonce-download_split_bundle')), $this->baseUrl)); ?>"><?php printf(__('Split %ss', 'wp_all_export_plugin'), strtoupper(wp_all_export_get_export_format($update_previous->options))); ?></button>
                        <?php endif; ?>
                        <?php if (PMXE_Export_Record::is_bundle_supported($update_previous->options)): ?>
                            <button class="button button-primary button-hero wpallexport-large-button download_data"
                                    rel="<?php echo esc_url_raw(add_query_arg(array('page' => 'pmxe-admin-manage', 'id' => $update_previous->id, 'action' => 'bundle', '_wpnonce' => wp_create_nonce('_wpnonce-download_bundle')), $this->baseUrl)); ?>"><?php esc_html_e('Bundle', 'wp_all_export_plugin'); ?></button>
                        <?php endif; ?>
                    </div>

                    <?php if (PMXE_Export_Record::is_bundle_supported($update_previous->options)): ?>
                        <div id="download-details">
                            <p style="margin-top:30px;">
                                <?php esc_html_e("The bundle contains your exported data and a settings file for WP All Import.", 'wp_all_export_plugin'); ?>
                                <br/>
                                <?php esc_html_e("Upload the Bundle to WP All Import on another site to quickly import this data.", 'wp_all_export_plugin'); ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <div style="margin-top:30px;">
                        <h3 style="margin-bottom: 0; margin-top: -10px;"><?php echo esc_html_e("Secure URL", 'wp_all_export_plugin'); ?></h3>


                        <div id="wpae-secure-url-container">

                            <button class="button button-hero" id="wpae-generate-token" data-id="<?php echo $update_previous->id; ?>">
                                <img style="display: none;" src="<?php echo esc_attr(PMXE_ROOT_URL); ?>/static/img/preloader.gif"/>

                                <?php if ($update_previous->options['security_token']) {
                                    ?>
                                    <span>Remove URL</span>

                                <?php } else { ?>
                                    <span>Generate</span>
                                <?php } ?>

                            </button>

                            <input placeholder="Click generate to generate a secure URL" type="text" id="wpae-secure-url" style=""
                            value="<?php
                            if($update_previous->options['security_token']) {
                                $urlToExport = site_url() . '/wp-load.php?security_key=' . $update_previous->options['security_token'] . '&export_id=' . $export_id . '&action=get_data';
                                echo esc_attr($urlToExport);
                            }
                            ?>"
                            />
                        </div>

                        <p style="margin-top: 0;">
                            <?php esc_html_e("This URL will always provide the export file from this export, even if the file name changes.", 'wp_all_export_plugin'); ?>
                        </p>
                        <?php if($update_previous->options['enable_real_time_exports']) {?>
                        <p>
                            Each time a new post is created, the export will run and a new CSV file is created. The secure URL will point to that CSV file.

                        </p>
                            <p style="margin-bottom: 10px; font-size: 12px; line-height: 22px;">This export will run every time a new <strong><?php echo esc_html($cpt_name); ?></strong>
                                is added that meets the filter requirements you've configured.
                                Connect with Zapier to send this data to other services and apps, or
                                use the WP All Export API to create a custom solution.</p>
                        <?php } ?>
                    </div>
                </div>
                <div class="tab-content scheduling" id="tab2-content">
                    <div class="wrap" style="text-align: left; padding-top: 10px;">

                        <?php
                        if (current_user_can(PMXE_Plugin::$capabilities)) {
                            $export = $update_previous;
                            require __DIR__ . '/../../../src/Scheduling/views/SchedulingUI.php';
                        } ?>

                    </div>
                </div>
                <div class="tab-content normal-tab" id="tab3-content">
                    <p>
                        <?php esc_html_e("Automatically send your data to over 500 apps with Zapier.", 'wp_all_export_plugin'); ?>
                        <br/>
                        <a href="https://zapier.com/zapbook/wp-all-export-pro/"
                           target="_blank"><?php esc_html_e("Click here to read more about WP All Export's Zapier Integration.", 'wp_all_export_plugin'); ?></a>
                    </p>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/6tBacBmiHsQ" frameborder="0"
                            allowfullscreen></iframe>
                </div>
                <?php if ($isImportAllowedSpecification->isSatisfied($update_previous)): ?>

                    <div class="tab-content normal-tab" id="tab4-content">
                    <?php if (!$is_rapid_addon_export) { ?>
                        <p>
                            <?php esc_html_e("After you've downloaded your data, edit it however you like.", 'wp_all_export_plugin'); ?>
                            <br/>
                            <?php esc_html_e("Then, click below to import the data with WP All Import without having to set anything up.", 'wp_all_export_plugin'); ?>
                        </p>
                        <p>
                            <button class="button button-primary button-hero wpallexport-large-button download_data"
                                    rel="<?php echo esc_url_raw(add_query_arg(array('page' => 'pmxe-admin-manage', 'action' => 'download', 'id' => $update_previous->id, '_wpnonce' => wp_create_nonce('_wpnonce-download_feed')), $this->baseUrl)); ?>"><?php esc_html_e('Download', 'wp_all_export_plugin'); ?><?php echo esc_html(strtoupper(wp_all_export_get_export_format($update_previous->options))); ?></button>

                            <button class="button button-primary button-hero wpallexport-large-button download_data"
                                    rel="<?php echo esc_url_raw(add_query_arg(array('page' => 'pmxi-admin-import', 'id' => $update_previous->options['import_id'], 'deligate' => 'wpallexport'), remove_query_arg('page', $this->baseUrl))); ?>"><?php esc_html_e('Import with WP All Import', 'wp_all_export_plugin'); ?></button>
                        </p>
                        <p>
                            <?php esc_html_e("You can also start the import by clicking 'Import with WP All Import' on the Manage Exports page.", 'wp_all_export_plugin'); ?>
                        </p>

                        </div>
                        <?php
                    }
                endif; ?>

                <?php if ($update_previous->options['enable_real_time_exports']): ?>

                    <div class="tab-content normal-tab" id="tab5-content">
                    <?php if (!$is_rapid_addon_export) { ?>
                        <p>
                            <?php esc_html_e("After you've downloaded your data, edit it however you like.", 'wp_all_export_plugin'); ?>
                            <br/>
                            <?php esc_html_e("Then, click below to import the data with WP All Import without having to set anything up.", 'wp_all_export_plugin'); ?>
                        </p>
                        <p>
                            <button class="button button-primary button-hero wpallexport-large-button download_data"
                                    rel="<?php echo esc_url_raw(add_query_arg(array('page' => 'pmxe-admin-manage', 'action' => 'download', 'id' => $update_previous->id, '_wpnonce' => wp_create_nonce('_wpnonce-download_feed')), $this->baseUrl)); ?>"><?php esc_html_e('Download', 'wp_all_export_plugin'); ?><?php echo esc_html(strtoupper(wp_all_export_get_export_format($update_previous->options))); ?></button>

                            <button class="button button-primary button-hero wpallexport-large-button download_data"
                                    rel="<?php echo esc_url_raw(add_query_arg(array('page' => 'pmxi-admin-import', 'id' => $update_previous->options['import_id'], 'deligate' => 'wpallexport'), remove_query_arg('page', $this->baseUrl))); ?>"><?php esc_html_e('Import with WP All Import', 'wp_all_export_plugin'); ?></button>
                        </p>
                        <p>
                            <?php esc_html_e("You can also start the import by clicking 'Import with WP All Import' on the Manage Exports page.", 'wp_all_export_plugin'); ?>
                        </p>

                        </div>
                        <?php
                    }
                endif; ?>
            </div>
        <hr>
            <?php
        }
        ?>
    </div>
    <?php
} else {
    ?>
    <div id="export_finished">
        <p>
            <?php if (XmlExportEngine::$exportOptions['export_to'] == XmlExportEngine::EXPORT_TYPE_XML && XmlExportEngine::$exportOptions['xml_template_type'] == XmlExportEngine::EXPORT_TYPE_GOOLE_MERCHANTS) { ?>
                <button class="button button-primary button-hero wpallexport-large-button download_data"
                        rel="<?php echo esc_url_raw(add_query_arg(array('page' => 'pmxe-admin-manage', 'action' => 'download', 'id' => $update_previous->id, '_wpnonce' => wp_create_nonce('_wpnonce-download_feed')), $this->baseUrl)); ?>"><?php esc_html_e('Download', 'wp_all_export_plugin'); ?>
                    TXT
                </button>

            <?php } else { ?>
                <button class="button button-primary button-hero wpallexport-large-button download_data"
                        rel="<?php echo esc_url_raw(add_query_arg(array('action' => 'download', 'id' => $update_previous->id, '_wpnonce' => wp_create_nonce('_wpnonce-download_feed')), $this->baseUrl)); ?>"><?php esc_html_e('Download', 'wp_all_export_plugin'); ?><?php echo esc_html(strtoupper(wp_all_export_get_export_format($update_previous->options))); ?></button>

            <?php } ?>
        </p>

    </div>
    <?php
}
?>
