<style>
    textarea {
        width: 100%;
        height: 150px;
        background: #fff;
    }
	.error{
		color: red !important;
	}
</style>
<section>
		<div class="db">
			<!--LEFT SECTION-->
			<?php $this->load->view('layout/member_left_menu')?>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
					<h4>Change Password</h4>
					<div class="db-2-main-com db2-form-pay db2-form-com">
						<?php $this->load->view('errors/msg');?>
						<form class="col s12" name="changePasswordForm" id="changePasswordForm" method="post" action="<?php echo base_url('supervisor/dochangepassword'); ?>">
							<div class="input-field col s12">
								<label id="oldpassword-error" class="error" for="oldpassword" style="display:none;"></label>
								<label id="password-error" class="error" for="password" style="display:none;"></label>
								<label id="confirmpassword-error" class="error" for="confirmpassword" style="display:none;"></label>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input type="password" class="validate" id="oldpassword" name="oldpassword" >
									<label>Old Password</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input type="password" class="validate" id="password" name="password" >
									<label>New Password</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input type="password" class="validate" id="confirmpassword" name="confirmpassword" >
									<label>Confirm Password</label>
								</div>
							</div>
							
							<div class="row">
								<div class="input-field col s12">
									<input type="submit" value="submit" class="waves-effect waves-light full-btn"> 
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!--RIGHT SECTION-->
			
		</div>
	</section>

<script type="text/javascript">
$(document).ready(function(){ 
    $("#changePasswordForm").validate({
        // Specify validation rules
        rules: {
            oldpassword: {
                required: true
            },
			password: {
                required: true,
				minlength : 6
            },
            confirmpassword: {
                required: true,
				minlength : 6,
                equalTo : "#password"
            }
        },
        // Specify validation error messages
        messages: {
            oldpassword: "Please enter old password",
			password: "Please enter password",
            confirmpassword: "Please enter confirm password"
        },
        submitHandler: function(form) {
			$('#load-txt').show();
            var data=$("form[name='changePasswordForm']").serialize();
            do_add(data);
        }
    });
})


function do_add(formData){
	$.ajax({
          type:'POST',
          url:$( '#changePasswordForm' ).attr('action'),
          data:formData,
          success:function(msg){
            var response=$.parseJSON(msg);
            if(response.status==1){
                window.location.reload();
			}else{
            	messagealert('Error',response.msg,'error');
            }
          },
          error: function () {
            messagealert('Error','Technicle Issue, Please try after some time','error');
          }
    });
}
</script>