<?php 

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes hooks used across the
 * public-facing side of the site.
 *     
 * @since      1.0.0
 *
 */

/**
 * The core plugin hook class.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 */

class Wpcf_public_end_hooks {
    /**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $wpcf_plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $wpcf_plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $wpcf_version    The current version of the plugin.
	 */
	protected $wpcf_version;

    /**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WP_CUSTOM_FORMS_VERSION' ) ) {
			$this->wpcf_version = WP_CUSTOM_FORMS_VERSION;
		} else {
			$this->wpcf_version = '1.0.0';
		}
		$this->wpcf_plugin_name = 'wp-custom-forms';

		/**
		 * The class responsible for defining all actions that occur in the public area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/wpcf-class-public-main.php';
        $wpcf_public = new Wpcf_class_public_program( $this->wpcf_plugin_name , $this->wpcf_version );

		//public main style and script //
			add_action( 'wp_enqueue_scripts', array( $wpcf_public, 'wpcf_enqueue_styles' ), 10, 1 );
			add_action( 'wp_enqueue_scripts', array( $wpcf_public, 'wpcf_enqueue_scripts' ), 10, 1 );
			add_action( 'init', array( $wpcf_public , 'wpcf_success_payment' ), 10, 1 );



			// Ajax //
			add_action( 'wp_ajax_nopriv_wpcf_do_payment', array( $wpcf_public , 'wpcf_do_payment_callback' ), 10, 1);
			add_action( 'wp_ajax_wpcf_do_payment', array( $wpcf_public , 'wpcf_do_payment_callback' ), 10, 1 );

    }

		
}