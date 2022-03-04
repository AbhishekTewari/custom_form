(function( $ ) {
	'use strict';


    $( document ).ready( function() {
  
      $(document).on( 'click', '#wpcf-submit-button', function(event) {
        event.preventDefault();
        this.form.reportValidity(); // to enable the validation 

        var user_f_name = $(".wpcf-first-name").val();
        var user_l_name = $(".wpcf-last-name").val();
        var user_address = $(".wpcf-street-address").val();
        var user_add_optional = $(".wpcf-street-address-optional").val();
        var user_city = $(".wpcf-form-city").val();
        var user_pin = $(".wpcf-pin-code").val();
        var user_email = $(".wpcf-email-address").val();
        var user_phone = $(".wpcf-phone-number").val();
        var user_amount = $(".wpcf-amount").val();

       if( user_f_name != "" && user_l_name != "" && user_address != "" && user_city != "" && user_pin != "" && user_phone != "" && user_amount != "" && user_email != "") 
       {
          var email_valid = wpcf_email_validation( user_email );
          if( ! email_valid )
          {
            $(document).find('.wpcf-email-error').fadeIn();
          }
          else {
            $(document).find('.wpcf-email-error').fadeOut();
            var data = {
              action: 'wpcf_do_payment',
              wpcf_security_check: wpcf_global_params.wpcf_nonce,
              user_f_name : user_f_name,
              user_l_name : user_l_name,
              user_address : user_address,
              user_add_optional : user_add_optional,
              user_city : user_city,
              user_pin : user_pin,
              user_email : user_email,
              user_phone : user_phone,
              user_amount : user_amount,
              };
            $.ajax({
                url: wpcf_global_params.wpcf_ajaxurl,
                type: "post",
                data: data,
                dataType: 'json',
                success: function (response) {
                  if( response.wpcf_status )
                  {
                    window.location.href = response.redirect;
                  }
                  else {
                    alert(response.wpcf_message);
                  }

                }
            });
          }
        }
      });



    });


})( jQuery );

function wpcf_email_validation( user_email )
{
    var wpcf_email_regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if( ! wpcf_email_regex.test( user_email ) ) 
    {
        return false;
    } else {
        return true;
    }
}