
<div class="wpcf-main-admin-panel-wrapper">
    <!-- heading section  -->
    <div class="wpcf-main-heading">
        <span class="wpcf-heading-text"><?php esc_html_e( 'Custom Form', 'wp-custom-forms' ); ?></span>
    </div>
    <div class="wpcf-content-wrapper">
      <div class="wpcf-content">
        <form enctype="multipart/form-data" action="options.php" method="post">
          <?php

            settings_fields( 'wpcf_payment_settings');
            $wpcf_payment_opt = get_option( 'wpcf_payment_settings_opt' );
            $wpcf_payment_type = isset( $wpcf_payment_opt['payment_type'] ) ? $wpcf_payment_opt['payment_type'] : ""
          
          ?>
          <div class="wpcf-paypal-details">

            <div class="wpcf-pay-inputs"> 
              <label for="wpcf-payment-receive-email" class="wpcf-label"><?php esc_html_e( 'Payment Receive Email', 'wp-custom-forms' ); ?></label>
              <input type="text" class="wpcf-payment-receive-email wpcf-input " value="<?php echo isset( $wpcf_payment_opt[ 'receiving_email' ] ) ? $wpcf_payment_opt[ 'receiving_email' ] : ""; ?>" name="wpcf_payment_settings_opt[receiving_email]">
            </div>

            <div class="wpcf-pay-inputs"> 
              <label class="wpcf-label" for="wpcf-sandbox-payment"><?php esc_html_e( 'Payment Type', 'wp-custom-forms' ); ?></label>
              <input type="radio" class="wpcf-sandbox-payment wpcf-input" name="wpcf_payment_settings_opt[payment_type]" value="sandbox" <?php checked(  $wpcf_payment_type, 'sandbox') ?> > 
              <span class="wpcf-radio-text"><?php esc_html_e( 'Sandbox', 'wp-custom-forms' ); ?></span>

              <input type="radio" class="wpcf-sandbox-payment wpcf-input" name="wpcf_payment_settings_opt[payment_type]" value="live" <?php checked(  $wpcf_payment_type, 'live') ?> >
              <span class="wpcf-radio-text"><?php esc_html_e( 'Live', 'wp-custom-forms' ); ?></span>
            </div>
            
            <div class="wpcf-pay-inputs"> 
              <label class="wpcf-label" for="wpcf-amount-paid"><?php esc_html_e( 'Amount to be paid', 'wp-custom-forms' ); ?></label>
              <input type="number" class="wpcf-amount-paid wpcf-input" name="wpcf_payment_settings_opt[amount_paid]" value="<?php echo isset( $wpcf_payment_opt[ 'amount_paid' ] ) ? $wpcf_payment_opt[ 'amount_paid' ] : ""; ?>"> 
            </div>

          </div>
          <input type="submit" >
        </form>
      </div>
    </div>
    <div>
      <p><b><?php esc_html_e( 'Details of user who made the payment', 'wp-custom-forms' ); ?></b></p>
    </div>
    <div class="wpcf-show-user_data">
      <table>
        <tr>
          <th><?php esc_html_e( 'ID', 'wp-custom-forms' ); ?> </th>
          <th><?php esc_html_e( 'Name', 'wp-custom-forms' ); ?> </th>
          <th><?php esc_html_e( 'Email', 'wp-custom-forms' ); ?> </th>
        </tr>
      <?php 
    
         $available_drivers = get_users(
            array(
                'meta_query' => array(
                    array(
                        'key' => 'payment_paid',
                        'value' => 1,
                        'compare' => '=='
                    )
                )
            )
           );

           if( ! empty( $available_drivers ) )
           {
              foreach( $available_drivers as $key => $user_data)
              {
                ?>
                  <tr>
                    <td><?php echo esc_attr( $user_data->ID ) ?> </td>
                    <td><?php echo esc_attr( $user_data->user_nicename ) ?> </td>
                    <td><?php echo esc_attr( $user_data->user_email ) ?> </td>

                  </tr>
                <?php 
              }
           }
      ?>
      <table>

    </div>
</div>

