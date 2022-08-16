<?php
if (!defined('ABSPATH')) {
    die();
}
?>
<div class="wpallexport-collapsed wpallexport-section">
    <div class="wpallexport-content-section" style="margin-top:10px;">
        <div class="wpallexport-collapsed-header" style="padding-left: 25px;">
            <h3><?php esc_html_e('Advanced Options', 'wp_all_export_plugin'); ?></h3>
        </div>
        <div class="wpallexport-collapsed-content" style="padding: 0;">
            <div class="wpallexport-collapsed-content-inner">
                <table class="form-table" style="max-width:none;">
                    <tr>
                        <td colspan="3">
                            <div class="wpallexport-no-realtime-options" <?php if ($post['enable_real_time_exports']) { ?> style="display: none;"<?php } ?> >
                                <div class="input" style="margin:5px 0px;">
                                    <label for="records_per_request"><?php esc_html_e('In each iteration, process', 'wp_all_export_plugin'); ?>
                                        <input type="text" name="records_per_iteration" class="wp_all_export_sub_input"
                                               style="width: 40px;"
                                               value="<?php echo esc_attr($post['records_per_iteration']) ?>"/> <?php esc_html_e('records', 'wp_all_export_plugin'); ?>
                                    </label>
                                    <span>
                                    <a href="#help" class="wpallexport-help" style="position: relative; top: -2px;"
                                       title="<?php esc_html_e('WP All Export must be able to process this many records in less than your server\'s timeout settings. If your export fails before completion, to troubleshoot you should lower this number.', 'wp_all_export_plugin'); ?>">?</a>
							    </span>
                                </div>
                                <div class="input" style="margin:5px 0px;">
                                    <input type="hidden" name="export_only_new_stuff" value="0"/>
                                    <input type="checkbox" id="export_only_new_stuff" name="export_only_new_stuff"
                                           value="1" <?php echo $post['export_only_new_stuff'] ? 'checked="checked"' : '' ?> />
                                    <label for="export_only_new_stuff"><?php printf(esc_html__('Only export %s once', 'wp_all_export_plugin'), empty($post['cpt']) ? esc_html__('records', 'wp_all_export_plugin') : wp_all_export_get_cpt_name($post['cpt'], 2, $post)); ?></label>
                                    <span>
                                    <a href="#help" class="wpallexport-help" style="position: relative; top: 0;"
                                       title="<?php esc_html_e('If re-run, this export will only include records that have not been previously exported.', 'wp_all_export_plugin'); ?>">?</a>
							    </span>
                                </div>
                                <div class="input" style="margin:5px 0px;">
                                    <input type="hidden" name="export_only_modified_stuff" value="0"/>
                                    <input type="checkbox"
                                        <?php if (in_array('users', $post['cpt']) || in_array('taxonomies', $post['cpt']) || in_array('shop_customer', $post['cpt']) || ($post['export_type'] === 'advanced' && $post['wp_query_selector'] === 'wp_user_query')) { ?> disabled="disabled" <?php } ?>
                                           id="export_only_modified_stuff" name="export_only_modified_stuff"
                                           value="1" <?php echo $post['export_only_modified_stuff'] ? 'checked="checked"' : '' ?> />
                                    <label for="export_only_modified_stuff"><?php printf(__('Only export %s that have been modified since last export', 'wp_all_export_plugin'), empty($post['cpt']) ? esc_html__('records', 'wp_all_export_plugin') : esc_html__(wp_all_export_get_cpt_name($post['cpt'], 2, $post))); ?></label>
                                    <span>
                                    <a href="#help" class="wpallexport-help" style="position: relative; top: -2px;"
                                        <?php
                                        if (in_array('users', $post['cpt']) || ($post['export_type'] === 'advanced' && $post['wp_query_selector'] === 'wp_user_query')) { ?>
                                            title="<?php esc_html_e('This feature it not available for user exports.', 'wp_all_export_plugin'); ?>"
                                        <?php } else if (in_array('taxonomies', $post['cpt'])) { ?>
                                            title="<?php esc_html_e('This feature it not available for taxonomies exports.', 'wp_all_export_plugin'); ?>"
                                        <?php } else if (in_array('shop_customer', $post['cpt'])) { ?>
                                            title="<?php esc_html_e('This feature it not available for customer exports.', 'wp_all_export_plugin'); ?>"
                                        <?php } else { ?>
                                            title="<?php esc_html_e('If re-run, this export will only include records that have been modified since last export run.', 'wp_all_export_plugin'); ?>"
                                        <?php } ?>
                                    >?</a>
                                </span>
                                </div>
                            </div>

                            <?php if (in_array('shop_customer', $post['cpt'])) { ?>
                                <div class="input" style="margin:5px 0px;">
                                    <input type="hidden" name="export_only_customers_that_made_purchases"
                                           value="0"/>
                                    <input type="checkbox" id="export_only_customers_that_made_purchases"
                                           name="export_only_customers_that_made_purchases"
                                           value="1" <?php echo $post['export_only_customers_that_made_purchases'] ? 'checked="checked"' : '' ?> />
                                    <label for="export_only_customers_that_made_purchases"><?php esc_html_e('Only export customers who have made a purchase', 'wp_all_export_plugin'); ?></label>
                                    <span>
                                            <a href="#help" class="wpallexport-help" style="position: relative; top: 0;"
                                               title="<?php esc_html_e('If enabled, only customers who have actually made purchases will be exported.', 'wp_all_export_plugin'); ?>">?</a>
                                        </span>
                                </div>
                            <?php } ?>

                            <div class="input" style="margin:5px 0px;">
                                <input type="hidden" name="include_bom" value="0"/>
                                <input type="checkbox" id="include_bom" name="include_bom"
                                       value="1" <?php echo $post['include_bom'] ? 'checked="checked"' : '' ?> />
                                <label for="include_bom"><?php esc_html_e('Include BOM in export file', 'wp_all_export_plugin') ?></label>
                                <span>
                                    <a href="#help" class="wpallexport-help" style="position: relative; top: 0;"
                                       title="<?php esc_html_e('The BOM will help some programs like Microsoft Excel read your export file if it includes non-English characters.', 'wp_all_export_plugin'); ?>">?</a>
                                </span>
                            </div>
                            <div class="wpallexport-no-realtime-options" <?php if ($post['enable_real_time_exports']) { ?> style="display: none;"<?php } ?>>
                                <div class="input" style="margin:5px 0px;">
                                    <input type="hidden" name="creata_a_new_export_file" value="0"/>
                                    <input type="checkbox" id="creata_a_new_export_file" name="creata_a_new_export_file"
                                           value="1" <?php echo $post['creata_a_new_export_file'] ? 'checked="checked"' : '' ?> />
                                    <label for="creata_a_new_export_file"><?php esc_html_e('Create a new file each time export is run', 'wp_all_export_plugin') ?></label>
                                    <span>
                                    <a href="#help" class="wpallexport-help" style="position: relative; top: 0;"
                                       title="<?php esc_html_e('If disabled, the export file will be overwritten every time this export run.', 'wp_all_export_plugin'); ?>">?</a>
							        </span>
                                </div>

                                <div class="input" style="margin:5px 0px;">
                                    <input type="hidden" name="do_not_generate_file_on_new_records" value="0"/>
                                    <input type="checkbox" id="do_not_generate_file_on_new_records"
                                           name="do_not_generate_file_on_new_records"
                                           value="1" <?php echo $post['do_not_generate_file_on_new_records'] ? 'checked="checked"' : '' ?> />
                                    <label for="do_not_generate_file_on_new_records"><?php esc_html_e('Do not generate an export file if there are no records to export', 'wp_all_export_plugin') ?></label>
                                    <span>
                                    <a href="#help" class="wpallexport-help" style="position: relative; top: 0;"
                                       title="<?php esc_html_e('If there are no records, an empty export file won\'t be generated.', 'wp_all_export_plugin'); ?>">?</a>
							        </span>
                                </div>

                                <?php if ($post['export_to'] == 'csv') { ?>
                                    <div class="input" style="margin:5px 0px;">
                                        <input type="hidden" name="split_large_exports" value="0"/>
                                        <input type="checkbox" id="split_large_exports" name="split_large_exports"
                                               class="switcher"
                                               value="1" <?php echo $post['split_large_exports'] ? 'checked="checked"' : '' ?> />
                                        <label for="split_large_exports"><?php esc_html_e('Split large exports into multiple files', 'wp_all_export_plugin') ?></label>
                                        <span class="switcher-target-split_large_exports pl17"
                                              style="display:block; clear: both; width: 100%;">
									<div class="input pl17" style="margin:5px 0px;">							
										<label for="records_per_request"><?php esc_html_e('Limit export to', 'wp_all_export_plugin'); ?></label> <input
                                                type="text" name="split_large_exports_count"
                                                class="wp_all_export_sub_input" style="width: 50px;"
                                                value="<?php echo esc_attr($post['split_large_exports_count']) ?>"/> <?php esc_html_e('records per file', 'wp_all_export_plugin'); ?>
									</div>																				
								</span>
                                    </div>
                                    <?php
                                }
                                ?>

                                <?php
                                if (current_user_can(PMXE_Plugin::$capabilities)) {
                                    ?>
                                    <div class="input" style="margin:5px 0px;">
                                        <input type="hidden" name="allow_client_mode" value="0"/>
                                        <input type="checkbox" id="allow_client_mode" name="allow_client_mode"
                                               value="1" <?php echo $post['allow_client_mode'] ? 'checked="checked"' : '' ?> />
                                        <label for="allow_client_mode"><?php esc_html_e('Allow non-admins to run this export in Client Mode', 'wp_all_export_plugin') ?></label>
                                        <span>
                                    <a href="#help" class="wpallexport-help" style="position: relative; top: 0;"
                                       title="<?php esc_html_e('When enabled, users with access to Client Mode will be able to run this export and download the export file. Go to All Export > Settings to give users access to Client Mode'); ?>">?</a>
							    </span>
                                    </div>
                                <?php } ?>
                            </div>

                            <br>
                            <hr>

                            <?php
                            if (current_user_can(PMXE_Plugin::$capabilities)) {
                                ?>
                                <p style="text-align:right;">
                                <div class="input">
                                    <label for="save_import_as"
                                           style="width: 103px;"><?php esc_html_e('Export Name:', 'wp_all_export_plugin'); ?></label>
                                    <input type="text" name="friendly_name"
                                           title="<?php esc_html_e('Save Export Name...', 'pmxi_plugin') ?>"
                                           style="vertical-align:middle; background:#fff !important; width: 350px;"
                                           value="<?php echo wp_all_export_clear_xss($post['friendly_name'] ? esc_attr($post['friendly_name']) : esc_attr($this->getFriendlyName($post))) ?>"/>
                                </div>
                                </p>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>	