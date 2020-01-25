<?php
$global_contact_email = $this->functions->getGlobalInfo('global_contact_email');
?>
<div class="login-bg">
    <div class="main-box">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="login_box">
                        <div class="login-logo">
                            <a href="<?php echo base_url(); ?>"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/logo.png" alt="" class="img-responsive"></a>
                        </div>
                        <div class="login-box-body text-center">
                            <h2 class="login-box-msg">
                                Change Password
                            </h2>
	<form class="rd-mailform_contact error_class" method="post" novalidate="novalidate" action="<?php  echo base_url('login/password_change');?>" name="passwordForm">
      <div class="row">
         <center>
        <div class="col-sm-6">
          <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="New password" id="newpassword">
          </div>
        </div>
        </center>
        <center>
        <div class="col-sm-6">
          <div class="form-group">
            <input type="password" class="form-control" name="cpassword" placeholder="Confirm new password">
          </div>
        </div>
        </center>
       
		<input type="hidden" name="email" value="<?php echo $email ?>" />
		<input type="hidden" name="token" value="<?php echo $ptoken ?>" />
        
      </div>
      <button class="btn-send_contact btn-cmn" type="submit">Submit</button>
    </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="login-footer text-center">
        <p>© 2018 All Rights Reserved. Designed by <a href="https://www.mymissingrib.com" rel="nofollow" target="_blank"> Mymissingrib </a></p>
    </div>
</div>
<script>
$(function() {
  $("form[name='passwordForm']").validate({
    // Specify validation rules
    rules: {
      password: {
        required: true,
        minlength: 6
      },
      cpassword: {
			required: true,
			equalTo: "#newpassword",
			minlength: 6
		}
    },
    // Specify validation error messages
    messages: {
      password: {
        required: "Please provide a password.",
        minlength: "Your password must be at least 6 characters long."
      },
      cpassword: {
		required:"Please provide a confirm password.",
		equalTo:"Enter Confirm Password Same as Password",
		minlength: "Your password must be at least 6 characters long."
	  }
    },
    submitHandler: function(form) {
      form.submit();
    }
  });
});


</script>