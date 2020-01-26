<style>
    .error{
        color: red;
    }
</style>
<section>
    <div class="tr-register">
        <div class="tr-regi-form">
            <h4>Sign In</h4>
            <p>It's free and always will be.</p>
            <form class="col s12" name="loginForm" id="loginForm" method="post" action="<?php echo base_url('page/doLogin'); ?>">
                <div class="row">
                    <label id="crn-error" class="error" for="crn" style="display:none;"></label>
                    <br/><label id="phone-error" class="error" for="phone" style="display:none;"></label>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" class="validate" name="phone">
                        <label>Phone Number</label>
                    </div>
                </div>
                <div id="otpDiv" style="display:none;">
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" class="validate" name="otp">
                            <label>Enter OTP</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="text-right"><a id="resendOtp" href="javascript:void(0)">Resend OTP</a></p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="submit" value="submit" class="waves-effect waves-light btn-large full-btn"> </div>
                </div>
            </form>
            <p>Are you a new user ? <a href="<?php echo base_url('register'); ?>">Register</a>
            </p>
        </div>
    </div>
</section>

<script type="text/javascript">
$(document).ready(function(){ 
    window.otpVerify = 0;
    window.phone = '';
    $("#loginForm").validate({
        // Specify validation rules
        rules: {
            phone: {
                required: true
            }
        },
        // Specify validation error messages
        messages: {
            phone: "Please enter a valid phone number."
        },
        submitHandler: function(form) {
            $('#load-txt').show();
            if(window.otpVerify == 1){
                $('input[name="phone"]').val(window.phone);
                var data=$("form[name='loginForm']").serialize();
                do_customer_login(data);
            }else{
                sendOtp();
            }
        }
    });
})

$(document).on('click','#resendOtp',function(){
    $('#load-txt').show();
    sebdOtp();
});

function sendOtp(){
    $.ajax({
        type:'POST',
        url:"<?php echo base_url('page/sendOtp/login'); ?>",
        data:{'phone':$('input[name="phone"]').val()},
        success:function(msg){
            var response=$.parseJSON(msg);
            if(response.error==0){
                window.phone=$('input[name="phone"]').val();
                window.otpVerify=1;
                $('input[name="phone"]').attr('readonly', true);
                messagealert('Success','OTP Send Successfully','success');
                $('#load-txt').hide();
                $('#otpDiv').show();
            }else{
                $('#load-txt').hide();
                messagealert('Error',response.msg,'error');
            }
        },
        error: function () {
            $('#otpDiv').hide();
            messagealert('Error','Technicle Issue, Please try after some time','error');
        }
    });
}

function do_customer_login(formData){
	$.ajax({
          type:'POST',
          url:$( '#loginForm' ).attr('action'),
          data:formData,
          success:function(msg){
            var response=$.parseJSON(msg);
            if(response.status==1){
                window.location.href = "<?php echo base_url('contact-us'); ?>";
			}else{
            	$('#otpDiv').hide();
                messagealert('Error',response.msg,'error');
            }
          },
          error: function () {
            $('#otpDiv').hide();
            messagealert('Error','Technicle Issue, Please try after some time','error');
          }
    });
}
</script>