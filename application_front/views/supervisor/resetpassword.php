<style>
    .error{
        color: red;
    }
</style>
<section>
    <div class="tr-register">
        <div class="tr-regi-form">
            <h4>Change Password</h4>
            <p>It's free and always will be.</p>
            <form class="col s12" name="rPasswordForm" id="rPasswordForm" method="post" action="<?php echo base_url('supervisor/doResetPassword'); ?>">
                <div class="row">
                    <label id="crn-error" class="error" for="crn" style="display:none;"></label>
                    <br/><label id="password-error" class="error" for="password" style="display:none;"></label>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" class="validate" name="password" id="password">
                        <label>New Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="password" class="validate" name="confirmpassword" id="confirmpassword">
                        <label>Confirm Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="submit" value="submit" class="waves-effect waves-light btn-large full-btn"> </div>
                </div>
            </form>
            <p><a href="<?php echo base_url('supervisor/login'); ?>">Login</a>
            </p>
        </div>
    </div>
</section>

<script type="text/javascript">
$(document).ready(function(){ 
    $("#rPasswordForm").validate({
        // Specify validation rules
        rules: {
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
            password: "Please enter password",
            confirmpassword: "Please enter confirm password"
        },
        submitHandler: function(form) {
            $('#load-txt').show();
            var data=$("form[name='rPasswordForm']").serialize();
            do_reset_password(data);
        }
    });
})

function do_reset_password(formData){
	$.ajax({
          type:'POST',
          url:$( '#rPasswordForm' ).attr('action'),
          data:formData,
          success:function(msg){
            var response=$.parseJSON(msg);
            if(response.status==1){
                window.location.href = "<?php echo base_url('supervisor/login'); ?>";
			}else{
            	messagealert('Error',response.message,'error');
            }
            $('#load-txt').hide();
          },
          error: function () {
            $('#load-txt').hide();
            messagealert('Error','Technicle Issue, Please try after some time','error');
          }
    });
}
</script>