<?php

/**
 * The public-specific functionality of the plugin.
 *
 * @since      1.0.0
 */

/**
 * The public-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-specific stylesheet and JavaScript.
 *
 */
class Wpcf_class_public_program {

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
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $wpcf_plugin_name       The name of this plugin.
     * @param      string    $wpcf_version    The version of this plugin.
     */
    public function __construct( $wpcf_plugin_name, $wpcf_version ) {

        $this->wpcf_plugin_name = $wpcf_plugin_name;
        $this->wpcf_version = $wpcf_version;

        // shortcode to display the for in frontend // 
        add_shortcode( 'wpcf_custom_fields_details', array( $this, 'wpcf_adding_form_html_callback' ) );

    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function wpcf_enqueue_styles() {

        // main css class //
        wp_enqueue_style( $this->wpcf_plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpcf-public-css.css', array(), $this->wpcf_version, 'all' );
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
		wp_enqueue_script( $this->wpcf_plugin_name, plugin_dir_url( __FILE__ ) .'js/wpcf-public-main.js', array( 'jquery' ), $this->wpcf_version, false );

        $wpcf_ajax_nonce 		= wp_create_nonce( "wpcf-ajax-security-string" );

		$wpcf_translation_array = array(
										'wpcf_ajaxurl' 		=> esc_url(admin_url( 'admin-ajax.php' )),
										'wpcf_nonce' 		=> $wpcf_ajax_nonce );
		wp_localize_script( $this->wpcf_plugin_name, 'wpcf_global_params', $wpcf_translation_array );
        wp_enqueue_script( $this->wpcf_plugin_name );

    }

    /**
	 * Retrieving HTML for shortcode.
	 *
	 * @since    1.0.0
	 */
    public function wpcf_adding_form_html_callback()
    {
        ob_start();
		    include_once WPCF_DIR. 'public/partials/wpcf-custom-form-html.php';
        return ob_get_clean();
    }

    /**
	 * payment callback.
	 *
	 * @since    1.0.0
	 */
    public function wpcf_do_payment_callback() {
        $check_ajax = check_ajax_referer( 'wpcf-ajax-security-string', 'wpcf_security_check' );
		
        if( $check_ajax )
        {
            $user_f_name = isset( $_POST[ 'user_f_name' ] ) ? sanitize_text_field( $_POST[ 'user_f_name' ] ) : "";
            $user_l_name = isset( $_POST[ 'user_l_name' ] ) ? sanitize_text_field( $_POST[ 'user_l_name' ] ) : "";
            $user_address = isset( $_POST[ 'user_address' ] ) ? sanitize_text_field( $_POST[ 'user_address' ] ) : "";
            $user_add_optional = isset( $_POST[ 'user_add_optional' ] ) ? sanitize_text_field( $_POST[ 'user_add_optional' ] ) : "";
            $user_city = isset( $_POST[ 'user_city' ] ) ? sanitize_text_field( $_POST[ 'user_city' ] ) : "";
            $user_pin = isset( $_POST[ 'user_pin' ] ) ? sanitize_text_field( $_POST[ 'user_pin' ] ) : "";
            $user_email = isset( $_POST[ 'user_email' ] ) ? sanitize_text_field( $_POST[ 'user_email' ] ) : "";
            $user_phone = isset( $_POST[ 'user_phone' ] ) ? sanitize_text_field( $_POST[ 'user_phone' ] ) : "";
            $user_amount = isset( $_POST[ 'user_amount' ] ) ? sanitize_text_field( $_POST[ 'user_amount' ] ) : "";

            $wpcf_payment_opt = get_option( 'wpcf_payment_settings_opt' );
            if( ! empty( $wpcf_payment_opt ) )
            {
                if( $wpcf_payment_opt['receiving_email'] != "" &&  $wpcf_payment_opt['payment_type'] != ""  && ( $wpcf_payment_opt['amount_paid'] != "" && $wpcf_payment_opt['amount_paid'] > 0 )  )
                {   

                    $wpcf_get_wp_user = get_user_by( 'email', $user_email );

			        $wpcf_wp_user_id = '';

                    // making new user if not exist //
                    if( ! $wpcf_get_wp_user  )
                    {
                        $wpcf_password = wp_generate_password( 12, true );
                        $wpcf_userdata = array( 'user_email' => $user_email,
                                        'display_name' => $user_f_name,
                                        'first_name' => $user_f_name,
                                        'last_name' => $user_l_name,
                                        'user_pass' => $wpcf_password,
                                        'user_login' => $user_email );

                        $response = wp_insert_user( $wpcf_userdata );

                        if( is_wp_error($response) ){
                            $wpcf_error_msg = $response->get_error_message();
                            echo json_encode( array( 'wpcf_status' => 0, 'wpcf_message' => $wpcf_error_msg ) );
                        }
                        else{
                            $wpcf_wp_user_id = $response;
                            wp_new_user_notification( $response, '', 'both' );
                        }
                    }
                    else{
                        $wpcf_wp_user_id = $wpcf_get_wp_user->ID;
                    }

                    $link = $this->paypal_payment_callback( $wpcf_payment_opt['receiving_email'], $wpcf_payment_opt['payment_type'], $user_email, $user_phone, $user_f_name, $user_l_name ,$user_amount, $wpcf_wp_user_id); 
                    
                    echo json_encode( array( 'wpcf_status' => true, 'redirect'=> $link) );
                }
                else {
					echo json_encode( array( 'wpcf_status' => false, 'wpcf_message' => esc_html__( "Paypal set incorrectly", 'wp-custom-forms' )) );
                }
            }
            else {
                echo json_encode( array( 'wpcf_status' => false, 'wpcf_message' => esc_html__( "Paypal set incorrectly", 'wp-custom-forms' )) );
            }
        }
        wp_die();
    }

    // paypal payment callback //

    public function paypal_payment_callback( $receiving_email, $wpcf_paypal_type, $user_email, $user_phone, $user_f_name, $user_l_name, $user_amount, $wpcf_wp_user_id ) {
    
        $wpcf_request_url = ( $wpcf_paypal_type == 'sandbox' ) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr?' : 'https://www.paypal.com/cgi-bin/webscr?';
        
        $custom_form_page = get_option('custom_form_id',true);
        $wpcf_redirect_link = isset( $custom_form_page ) ? esc_url( get_permalink( $custom_form_page ) ): esc_url(home_url());
    
        $wpcf_client_mail = $user_email;
    
        $wpcf_url = $wpcf_redirect_link;      
            
        $wpcf_cancel_url = add_query_arg(
            array(
            'cancel_payment' => 'true',
            'user_id' => $wpcf_wp_user_id,
            '_wpcfnonce' => wp_create_nonce( 'wpcf-cancel_payment' ),
            ),
            $wpcf_url
            );
                         
        $wpcf_return_url = add_query_arg(
        array(
        'success' => 'true',
        'user_id' => $wpcf_wp_user_id,
        '_wpcfnonce' => wp_create_nonce( 'wpcf-success_payment' ),
        ),
        $wpcf_url
        );
        
        $wpcf_notify_url = add_query_arg(
        array(
        'success' => 'false',
        'user_id' => $wpcf_wp_user_id,
        '_wpcfnotify' => 'true',
        ),
        $wpcf_url
        );
        
 
        $wpcf_currency = get_woocommerce_currency();
            
  
    
    $wpcf_query_array = array(
        'cmd' => '_xclick',
        'business' => $receiving_email,
        'currency_code' => isset($wpcf_currency)? $wpcf_currency : 'USD',
        'return' => $wpcf_return_url,
        'cancel_return' => $wpcf_cancel_url,
        'notify_url' => $wpcf_notify_url,
        'first_name' =>  $user_l_name,
        'last_name' =>  $user_l_name,
        'email' => $user_email,
        'night_phone_a' => $user_phone,
        'custom' => wp_json_encode(
        array(
        'user_id' => $wpcf_wp_user_id
        )
        ),
        'amount' => $user_amount
        
        );
        
        return $wpcf_request_url . http_build_query( $wpcf_query_array, '', '&' );
        
    }

    // run when payment is done //

    public function wpcf_success_payment()
    {
        if( isset( $_GET[ 'success' ] ) &&  $_GET[ 'success' ] == true &&  (isset( $_GET[ 'user_id' ] ) &&  $_GET[ 'user_id' ] ) )
        {
            $user_id = $_GET[ 'user_id' ];
            update_user_meta( $user_id, 'payment_paid',1 );
        }
    }

}