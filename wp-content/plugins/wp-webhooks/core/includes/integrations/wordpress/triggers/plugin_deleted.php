<?php
if ( ! class_exists( 'WP_Webhooks_Integrations_wordpress_Triggers_plugin_deleted' ) ) :

	/**
	 * Load the plugin_deleted trigger
	 *
	 * @since 4.1.0
	 * @author Ironikus <info@ironikus.com>
	 */
	class WP_Webhooks_Integrations_wordpress_Triggers_plugin_deleted {

        public function is_active(){

            //Backwards compatibility for the "Manage Plugins" integration
            if( defined( 'WPWHPRO_MNGPL_PLUGIN_NAME' ) ){
                return false;
            }

            return true;
        }

        public function get_details(){

            $translation_ident = "trigger-plugin_deleted-description";

            $parameter = array(
				'plugin_slug' => array( 'short_description' => WPWHPRO()->helpers->translate( '(String) The slug of the plugin. You will find an example within the demo data.', $translation_ident ) ),
				'deleted_status' => array( 'short_description' => WPWHPRO()->helpers->translate( '(Bool) Returns true in case the plugin was successfully deleted. false if not.', $translation_ident ) ),
			);

			ob_start();
			$translation_ident = "trigger-plugin-deleted-description";

?>

<?php echo WPWHPRO()->helpers->translate( "This webhook trigger is used to send data, on the deletion of a plugin, to one or multiple given webhook URL's.", $translation_ident ); ?>
<br>
<?php echo WPWHPRO()->helpers->translate( "This description is uniquely made for the <strong>Send Data On Plugin Deletion</strong> (plugin_deleted) webhook trigger.", $translation_ident ); ?>
<br><br>
<h4><?php echo WPWHPRO()->helpers->translate( "How to use <strong>Send Data On Plugin Deletion</strong> (plugin_deleted)", $translation_ident ); ?></h4>
<ol>
    <li><?php echo WPWHPRO()->helpers->translate( "To get started, you need to add your recieving URL endpoint, that accepts webhook requests, from the third-party provider or service you want to use.", $translation_ident ); ?></li>
    <li><?php echo WPWHPRO()->helpers->translate( "Once you have this URL, please place it into the <strong>Webhook URL</strong> field above.", $translation_ident ); ?></li>
    <li><?php echo WPWHPRO()->helpers->translate( "For a better identification of the webhook URL, we recommend to also fill the <strong>Webhook Name</strong> field. This field will be used as the slug for your webhook URL. In case you leave it empty, we will automatically generate a random number as an identifier.", $translation_ident ); ?></li>
    <li><?php echo WPWHPRO()->helpers->translate( "After you added your <strong>Webhook URL</strong>, press the <strong>Add</strong> button to finish adding the entry.", $translation_ident ); ?></li>
    <li><?php echo WPWHPRO()->helpers->translate( "That's it! Now you are able to recieve data on the URL once the trigger fires.", $translation_ident ); ?></li>
    <li><?php echo WPWHPRO()->helpers->translate( "Next to the <strong>Webhook URL</strong>, you will find a settings item, which you can use to customize the payload/request.", $translation_ident ); ?></li>
</ol>
<br><br>

<h4><?php echo WPWHPRO()->helpers->translate( "When does this trigger fire?", $translation_ident ); ?></h4>
<br>
<?php echo WPWHPRO()->helpers->translate( "This trigger is registered on the <strong>deleted_plugin</strong> hook:", $translation_ident ); ?> 
<a title="wordpress.org" target="_blank" href="https://developer.wordpress.org/reference/hooks/deactivated_plugin/">https://developer.wordpress.org/reference/hooks/deactivated_plugin/</a>
<br>
<br>
<?php echo WPWHPRO()->helpers->translate( "Here is the call within our code we use to fire this trigger:", $translation_ident ); ?>
<pre>add_action( 'deleted_plugin', array( $this, 'ironikus_trigger_plugin_deleted' ), 10, 2 );</pre>
<br><br>
<h4><?php echo WPWHPRO()->helpers->translate( "Tipps", $translation_ident ); ?></h4>
<ol>
    <li><?php echo WPWHPRO()->helpers->translate( "In case you don't need a specified webhook URL at the moment, you can simply deactivate it by clicking the <strong>Deactivate</strong> link next to the <strong>Webhook URL</strong>. This results in the specified URL not being fired once the trigger fires.", $translation_ident ); ?></li>
    <li><?php echo WPWHPRO()->helpers->translate( "You can use the <strong>Send demo</strong> button to send a static request to your specified <strong>Webhook URL</strong>. Please note that the data sent within the request might differ from your live data.", $translation_ident ); ?></li>
    <li><?php echo WPWHPRO()->helpers->translate( "Within the <strong>Settings</strong> link next to your <strong>Webhook URL</strong>, you can use customize the functionality of the request. It contains certain default settings like changing the request type the data is sent in, or custom settings, depending on your trigger. An explanation for each setting is right next to it. (Please don't forget to save the settings once you changed them - the button is at the end of the popup.)", $translation_ident ); ?></li>
    <li><?php echo WPWHPRO()->helpers->translate( "You can also check the response you get from the demo webhook call. To check it, simply open the console of your browser and you will find an entry there, which gives you all the details about the response.", $translation_ident ); ?></li>
</ol>
<br><br>

<?php echo WPWHPRO()->helpers->translate( "In case you would like to learn more about our plugin, please check out our documentation at:", $translation_ident ); ?>
<br>
<a title="Go to wp-webhooks.com/docs" target="_blank" href="https://wp-webhooks.com/docs/article-categories/get-started/">https://wp-webhooks.com/docs/article-categories/get-started/</a>
<?php
			$description = ob_get_clean();

			$settings = array();

            return array(
                'trigger'           => 'plugin_deleted',
                'name'              => WPWHPRO()->helpers->translate( 'Plugin deleted', $translation_ident ),
                'parameter'         => $parameter,
                'settings'          => $settings,
                'returns_code'      => $this->get_demo( array() ),
                'short_description' => WPWHPRO()->helpers->translate( 'This webhook fires as soon as a plugin was deleted.', $translation_ident ),
                'description'       => $description,
                'callback'          => 'test_plugin_deleted',
                'integration'       => 'wordpress',
                'premium'           => true,
            );

        }

        /*
        * Register the demo post delete trigger callback
        *
        * @since 1.6.4
        */
        public function get_demo( $options = array() ) {

            $data = array(
				'plugin_slug' => 'plugin-folder/plugin-file.php',
				'deleted_status' => 'true',
			);

            return $data;
        }

    }

endif; // End if class_exists check.