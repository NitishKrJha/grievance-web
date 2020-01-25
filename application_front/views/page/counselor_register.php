<div class="main-box">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="login_box">

                        <div class="create_account">
                            <h3 class="titleaccount">Complete your Account</h3>
                            
                          <form action="<?php echo base_url(); ?>page/complete_registration" name="reg_form_1" id="reg_form_1" method="post">
                          <div class="form-group">
                            <label for="email">Email address:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" readonly="readonly">
                          </div>
                          <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="reg_password" name="password">
                          </div>
                          <div class="form-group">
                            <label for="pwd">Confirm Password:</label>
                            <input type="password" class="form-control" id="reg_c_password" name="confirm_password">
                          </div>
                          <div class="form-group">
                            <label for="text">Full Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                          </div>
                          <div class="form-group">
                            <label for="text">User Name:</label>
                            <input type="text" class="form-control" id="username" name="username">
                          </div>
                        
                          <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                            
                            
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
	 <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
    $(document).ready(function(){
        $.validator.addMethod("customemail",
            function(value, element) {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            },
            "Sorry, I've enabled very strict email validation"
        );
        $("#reg_form_1").validate({
            // Specify validation rules
            rules: {
                password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    minlength: 6,
                    equalTo: "#reg_password"
                },
                name:{
                    required: true
                },
                username:{
                    required: true,
                    remote: {
                          url: "<?php echo base_url('page/usernameExistForCouncellor'); ?>",
                          type: "post",
						    data: {
							'email': function () { return $('input[name="email"]').val(); }
							 
						    }
						  
                    }
                }
            },
            // Specify validation error messages
            messages: {
                password: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 6 characters long."
                },
                confirm_password:{
                    required: "Please provide confirm password.",
                    equalTo:"Confirm password and password has to same."
                },
                username:{
                    required: "Please provide username.",
                    remote: "This username is already exist"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
