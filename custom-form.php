<?php 

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       WP Custom Forms
 * Plugin URI:        https://codecanyon.net/category/plugins
 * Description:       This plugin provide a custom form at frontend to accept user data.
 * Version:           1.0.0
 * Author:            Abhishek_Tiwari
 * Author URI:        https://codecanyon.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-custom-forms
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_CUSTOM_FORMS_VERSION', '1.0.0' );


/**
 * Function perform the functionality initially needed 
 * while activating the plugin.
 */
function wpcf_activate_wordpress_custom_form() {

	$page_slug = 'test-page-title';
	$new_page = array(
		'post_type'     => 'page',               // Post Type Slug eg: 'page', 'post'
		'post_title'    => 'Custom Form',    // Title of the Content
		'post_content'  => '[wpcf_custom_fields_details]',  // Content
		'post_status'   => 'publish',
		'post_name'     => $page_slug            // Post Status
	);
	 
	if ( ! get_page_by_path( $page_slug , OBJECT, 'page') ) { // Check If Page Not Exits
		$new_page_id = wp_insert_post( $new_page );
		update_option('custom_form_id',$new_page_id);
	}

}

/**
 * Fires when activating the Plugin.
 */
register_activation_hook( __FILE__, 'wpcf_activate_wordpress_custom_form' );


function wpcf_include_public_admin_hooks() {
	if( is_admin() ){
		/**
		 * public-facing site hooks.
		 */
		require plugin_dir_path( __FILE__ ) . 'includes/wpcf-class-admin-hook.php';
		$wpcf_admin_hooks = new Wpcf_admin_end_hooks();
	} 
		/**
		 * public-facing site hooks.
		 */
		require plugin_dir_path( __FILE__ ) . 'includes/wpcf-class-public-hook.php';
		$wpcf_public_hooks = new Wpcf_public_end_hooks();
	
}


//Plugin Constant
if ( !defined( 'WPCF_DIR' ) ) {
	define('WPCF_DIR', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WPCF_URL' ) ) {
	define('WPCF_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WPCF_BASEFILE_NAME' ) ) {
	define('WPCF_BASEFILE_NAME', plugin_basename(__FILE__) );
}
if ( !defined( 'WPCF_HOME' ) ) {
	define('WPCF_HOME', home_url() );
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
wpcf_include_public_admin_hooks();
?>