<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 */
class Wpcf_class_admin_program {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $wpcf_plugin_name    The ID of this plugin.
     */
    private $wpcf_plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $wpcf_version    The current version of this plugin.
     */
    private $wpcf_version;

    /**
     * The onject variable of common class under include.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $wpcf_commin_ui    common class object holding variable.
     */
    private $wpcf_commin_ui;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $wpcf_plugin_name       The name of this plugin.
     * @param      string    $wpcf_version    The version of this plugin.
     */
    public function __construct( $wpcf_plugin_name, $wpcf_version ) {

        $this->wpcf_plugin_name = $wpcf_plugin_name;
        $this->wpcf_version = $wpcf_version;

    }

    /**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
    public function wpcf_enqueue_styles() {

        // main admin style //
        wp_enqueue_style( $this->wpcf_plugin_name ,plugin_dir_url( __FILE__ ) . 'css/wpcf-admin-main.css', array(), $this->wpcf_version, 'all' );

        //fontawsm css
        wp_enqueue_style( 'wpcf-fontawsm', "https://pro.fontawesome.com/releases/v5.10.0/css/all.css" );
    }

    /**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function wpcf_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 */

		wp_enqueue_script( $this->wpcf_plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpcf-admin-main.js', array( 'jquery' ), $this->wpcf_version, false );

	}


    /**
	 * Create menu page in admin area.
	 *
	 * @since    1.0.0
	 */
    public function create_admin_menu_callback()
    {
        // creating plugin main menu // 
		add_menu_page( 
			esc_html__( 'Custom Form', 'wp-custom-forms' ),
			esc_html__( 'Custom Form', 'wp-custom-forms' ),
			'manage_options',
			'wp-custom-form',
			array( $this, 'wpcf_admin_panel_html' ),
            "",
			20
		);
    }

    /**
	 * Retrieve html for admin end.
	 *
	 * @since   1.0.0
	 */
	public function wpcf_admin_panel_html() {
		// retrieve plugin menu page html //
    	include_once WPCF_DIR. 'admin/partials/wp-custom-form-admin-display.php';

    }

    /**
	 * Function to register setting.
	 *
	 * @since   1.0.0
	 */
    function wpcf_settings_init()
	{
		global $wpdb;
		register_setting( 'wpcf_payment_settings', 'wpcf_payment_settings_opt' );
    }

}