<!-- Form HTML -->
<?php 
  $wpcf_payment_opt = get_option( 'wpcf_payment_settings_opt' );
  $wpcf_amount = isset( $wpcf_payment_opt[ 'amount_paid' ] ) ? $wpcf_payment_opt[ 'amount_paid' ] : 0;

  if( isset( $_GET[ 'success' ] ) &&  $_GET[ 'success' ] == true )
  {
?>

<div class="wpcf-success-paid">
  <span><?php esc_html_e( 'SuccessFully Paid', 'wp-custom-forms' ); ?></span>
</div>
<?php }?>

<form>
  <div class="wpcf-form-main-wrapper">
    <div class="wpcf-form-content">

      <!-- first name and last name     -->
      <div class="wpcf-input-field wpcf-flex"> 
        <div class="wpcf-input-sub-fields">
          <label for="wpcf-first-name" class="wpcf-label"> 
            <?php esc_html_e( 'First name ', 'wp-custom-forms' ); ?>
            <span class="wpcf-required-star">..*</span>
          </label>
          <input type="text" class="wpcf-first-name wpcf-input" required />
        </div>
        <div class="wpcf-input-sub-fields">
          <label for="wpcf-last-name" class="wpcf-label">
            <?php esc_html_e( 'Last name ', 'wp-custom-forms' ); ?>
            <span class="wpcf-required-star">..*</span>
          </label>
          <input type="text" class="wpcf-last-name wpcf-input" required/>
        </div>
      </div>

      <!-- Street address  -->
      <div class="wpcf-input-field"> 
          <label for="wpcf-street-address" class="wpcf-label">
            <?php esc_html_e( 'Street Address ', 'wp-custom-forms' ); ?>
            <span class="wpcf-required-star">..*</span>
          </label>
          <input type="text" class="wpcf-street-address wpcf-input" placeholder="<?php esc_html_e( 'House number and street name', 'wp-custom-forms' ); ?>" required/>
      </div>

      <!-- Street address optional  -->
      <div class="wpcf-input-field"> 
          <input type="text" class="wpcf-street-address-optional wpcf-input" placeholder="<?php esc_html_e( 'Apartment, suite, unit, etc.(optional)', 'wp-custom-forms' ); ?>" />
      </div>

      <!-- city and pincode     -->
      <div class="wpcf-input-field wpcf-flex"> 
        <div class="wpcf-input-sub-fields">
          <label for="wpcf-form-city" class="wpcf-label"> 
            <?php esc_html_e( 'City', 'wp-custom-forms' ); ?>
            <span class="wpcf-required-star">..*</span>
          </label>
          <input type="text" class="wpcf-form-city wpcf-input" required />
        </div>
        <div class="wpcf-input-sub-fields">
          <label for="wpcf-pin-code" class="wpcf-label">
            <?php esc_html_e( 'Pin code ', 'wp-custom-forms' ); ?>
            <span class="wpcf-required-star">..*</span>
          </label>
          <input type="number" class="wpcf-pin-code wpcf-input" required />
        </div>
      </div>

      <!-- Email Address  -->
        <div class="wpcf-input-field"> 
          <label for="wpcf-email-address" class="wpcf-label">
            <?php esc_html_e( 'Email Address', 'wp-custom-forms' ); ?>
            <span class="wpcf-required-star">..*</span>
          </label>
          <input type="email" class="wpcf-email-address wpcf-input" required />
          <span class="wpcf-required-star wpcf-email-error"><?php esc_html_e( 'Enter valid email address', 'wp-custom-forms' ); ?></span>
        </div>

      <!-- phone number  -->
      <div class="wpcf-input-field"> 
          <label for="wpcf-phone-number" class="wpcf-label">
            <?php esc_html_e( 'Phone', 'wp-custom-forms' ); ?>
            <span class="wpcf-required-star">..*</span>
          </label>
          <input type="number" class="wpcf-phone-number wpcf-input" required />
      </div>

      <!-- Amount to be paid  -->
      <div class="wpcf-input-field"> 
        <label for="wpcf-amount" class="wpcf-label">
          <?php esc_html_e( 'Amount', 'wp-custom-forms' ); ?>
          <span class="wpcf-required-star">..*</span>
        </label>
        <input type="number" class="wpcf-amount wpcf-input" value="<?php echo esc_attr( $wpcf_amount ); ?>" disabled />
      </div>

      <!-- Submit button  -->
      <input type="submit" class="wpcf-submit-form" id="wpcf-submit-button" name="wpcf-submit-form" value="<?php esc_html_e( 'Submit', 'wp-custom-forms' ); ?>" >

    </div>  
  </div>
</form>