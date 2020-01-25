<section class="main-container">
    <div class="container-fluid">
      <div class="row">
        <?php $this->load->view('layout/member_left_menu')?>
        <div class="col-md-10">
          <?php //$this->load->view('layout/member_view')?>
          <div class="btm-section">
            <div class="machMakingSec" >
                <div class="row">
                  <div class="machMakingform" id="machMakingform">
                    <div class=" item" id="step2"><!--step Two-->
                     <h2> Change Password </h2>
                      <form action="<?php echo base_url('member/dochangepassword') ?>" method="post" id="changePasswordForm">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr"> Old Password </label>
                           <input type="password" id="oldpassword" name="oldpassword" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr"> New Password </label>
                            <input type="password" id="newpassword" name="newpassword" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr"> Confirm Password </label>
                            <input type="password" id="confirmpassword" name="confirmpassword" class="form-control">
                          </div>
                        </div>
                       
                      </div>
                    </div><!--step Two End-->
                    <div class="nextPrvsSec">
                  <!-- <a class="showTipsBtn pull-right" href="match-making-step2.html#step2" >Continue</a> -->
                <input type="submit" class="btn-cmn" value="Submit">
                </div>
                  </form>
                  </div>
                </div>
            </div>
          </div>
        </div>
            <?php //echo $this->load->view('layout/memberMyContact'); ?>
          <?php //echo $this->load->view('layout/memberChatRequest'); ?>
      </div>
    </div>
  </section>
<script>
    $(document).ready(function(){
        $("#changePasswordForm").validate({
            // Specify validation rules
            rules: {
          oldpassword:{
            required:true
          },    
				  newpassword : {
					   required: true,
                    minlength : 6
                },
                confirmpassword : {
					required: true,
                    minlength : 6,
                    equalTo : "#newpassword"
                }			         
            },
			
			 messages: {
				  oldpassword: "Please enter old password.",
          newpassword: "Please enter new password.",
				  confirmpassword: "Enter your confirm password."				  
				},
            submitHandler: function(form) {
                form.submit();
            }
        });
    })
</script>