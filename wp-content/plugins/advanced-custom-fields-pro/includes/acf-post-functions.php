<?php 

/**
 * acf_get_post_templates
 *
 * Returns an array of post_type => templates data.
 *
 * @date	29/8/17
 * @since	5.6.2
 *
 * @param	void
 * @return	array
 */
function acf_get_post_templates() {
	
	// Defaults.
	$post_templates = array(
		'page'	=> array( 'default' )
	);
	
	// Loop over post types and append their templates.
	if( function_exists('get_page_templates') ) {
		$post_types = acf_get_post_types();
		foreach( $post_types as $post_type ) {
			$templates = get_page_templates( null, $post_type );
			if( $templates ) {
				$post_templates[ $post_type ] = $templates;
			}
		}
	}
	
	// Return.
	return $post_templates;
}