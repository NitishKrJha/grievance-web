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
                                Login
                            </h2>
                            <form name="f1" id="reg_form" method="post" action="<?php echo base_url('login/do_login'); ?>">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label>Select Type</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label style="cursor: pointer;"><input type="radio" id="member_type" name="member_type" class="" value="1" checked>Member</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label style="cursor: pointer;"><input type="radio" id="member_type" name="member_type" class="" value="2">Counselor</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email / Username</label>
                                    <input type="text" id="email" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember_me"> Keep me sign in 
                                            </label>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-cmn">Login</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="forgot-wrap">
                            <div class="row">
                                <div class="col-md-6">
                                    <p> <a href="<?php echo base_url('forgot-password'); ?>">Forgot Password?</a></p>
                                </div>
                                <div class="col-md-6">
                                    <p> Don't have an account? <a href="<?php echo base_url("page/register")?>"> Join today</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="login_footer">
                        <p>By continuing you agree to MyMissingRib's <a href="<?php echo base_url('terms-conditions'); ?>">Terms</a> and <a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a>. Promoting illegal commercial activities (such as prostitution) is prohibited.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="login-footer text-center">
        <p>© 2018 All Rights Reserved. Designed by <a href="https://www.mymissingrib.com" rel="nofollow" target="_blank"> Mymissingrib </a></p>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#reg_form").validate({
            // Specify validation rules
            rules: {
                email: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            // Specify validation error messages
            messages: {
                password: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 6 characters long."
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>