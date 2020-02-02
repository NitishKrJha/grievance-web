
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
            <form class="col s12" name="regForm" id="regForm" method="post" action="<?php echo base_url('page/doRegister'); ?>">
                <div class="row">
                    <label id="crn-error" class="error" for="crn" style="display:none;"></label>
                    <br/><label id="phone-error" class="error" for="phone" style="display:none;"></label>
                    <br/><label id="email-error" class="error" for="email" style="display:none;"></label>
                    <br/><label id="first_name-error" class="error" for="first_name" style="display:none;"></label>
                    <br/><label id="designation-error" class="error" for="designation" style="display:none;"></label>
                    <br/><label id="department-error" class="error" for="department" style="display:none;"></label>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" class="validate" name="crn">
                        <label>Enter CRN</label>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="input-field col s12 m4">
                        <input type="text" class="validate" name="first_name">
                        <label>First Name</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input type="text" class="validate" name="middle_name">
                        <label>Middle Name</label>
                    </div>
                    <div class="input-field col s12 m4">
                        <input type="text" class="validate" name="last_name">
                        <label>Last Name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <div>
                            <input type="email" class="validate" name="email">
                            <label>Email id</label>
                        </div>
                    </div>
                    <div class="input-field col s12 m6">
                        <input type="text" class="validate" name="phone">
                        <label>Phone</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" class="validate" name="designation">
                        <label>Designation</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" class="validate" name="department">
                        <label>Department</label>
                    </div>
                </div>
                <div id="otpDiv" style="display: none;">
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
                        <input type="submit" value="SUBMIT" class="waves-effect waves-light full-btn"> </div>
                </div>
            </form>
            <p>Are you a existing user ? <a href="<?php echo base_url('login'); ?>">Login</a>
            </p>
        </div>
    </div>
</section>

<script type="text/javascript">
$(document).ready(function(){ 
    window.otpVerify = 0;
    window.phone = '';
    $("#regForm").validate({
        // Specify validation rules
        rules: {
            email: {
                required: true,
                email: true
            },
            first_name: {
                required: true
            },
            phone: {
                required: true
            },
            crn: {
                required: true
            },
            designation: {
                required: true
            },
            department: {
                required: true
            }
        },
        // Specify validation error messages
        messages: {
            crn: "Please enter a valid CRN.",
            first_name: "Please enter a First Name.",
            email: "Please enter a valid email address.",
            phone: "Please enter a valid phone number.",
            department: "Please enter a department.",
            designation: "Please enter a designation.",
        },
        submitHandler: function(form) {
            $('#load-txt').show();
            if(window.otpVerify == 1){
                $('input[name="phone"]').val(window.phone);
                var data=$("form[name='regForm']").serialize();
                do_customer_reg(data);
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
        url:"<?php echo base_url('page/sendOtp/register'); ?>",
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
            $('#load-txt').hide();
            messagealert('Error','Technicle Issue, Please try after some time','error');
        }
    });
}

function do_customer_reg(formData){
	$.ajax({
          type:'POST',
          url:$( '#regForm' ).attr('action'),
          data:formData,
          success:function(msg){
            $('#load-txt').hide();
            var response=$.parseJSON(msg);
            if(response.status==1){
                window.location.href = "<?php echo base_url('grievance/index/0/1') ?>";
			}else{
            	$('#otpDiv').hide();
                messagealert('Error',response.msg,'error');
            }
          },
          error: function () {
            $('#load-txt').hide();
            $('#otpDiv').hide();
            messagealert('Error','Technicle Issue, Please try after some time','error');
          }
    });
}
</script>