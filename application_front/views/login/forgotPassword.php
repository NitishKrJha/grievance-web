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
                                Forgot your password?
                            </h2>
                            <?php
                                if($succmsg1!=''){
                                    ?>
                                    <div class="alert alert-success">
                                      <?php echo $succmsg1; ?>
                                    </div>
                                    <?php
                                }
                            ?>
                            <?php
                                if($errmsg1!=''){
                                    ?>
                                    <div class="alert alert-danger">
                                      <?php echo $errmsg1; ?>
                                    </div>
                                    <?php
                                }
                            ?>
                            <form name="f1" method="post" action="<?php echo base_url("page/do_forgetpwd")?>">
                                <div class="form-group">
                                    <span>Enter the email address that you registered with and we’ll send you instructions on how to reset your password.</span>
                                    <input type="email" class="form-control" name="email" id="email" required="required">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-cmn" onclick="window.location.href='<?php echo base_url(); ?>login'">Return</button>
                                        <button type="submit" class="btn btn-cmn">Continue</button>
                                    </div>

                                </div>
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