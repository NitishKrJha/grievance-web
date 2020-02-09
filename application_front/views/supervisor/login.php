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
            <form class="col s12" name="loginForm" id="loginForm" method="post" action="<?php echo base_url('supervisor/doLogin'); ?>">
                <div class="row">
                    <label id="crn-error" class="error" for="crn" style="display:none;"></label>
                    <br/><label id="password-error" class="error" for="password" style="display:none;"></label>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" class="validate" name="crn">
                        <label>CRN</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="password" class="validate" name="password">
                        <label>Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="submit" value="submit" class="waves-effect waves-light btn-large full-btn"> </div>
                </div>
            </form>
            <p><a href="<?php echo base_url('supervisor/forgotPassword'); ?>">Forgot Password</a>
            </p>
        </div>
    </div>
</section>

<script type="text/javascript">
$(document).ready(function(){ 
    $("#loginForm").validate({
        // Specify validation rules
        rules: {
            password: {
                required: true
            },
            crn: {
                required: true
            }
        },
        // Specify validation error messages
        messages: {
            password: "Please enter a valid password.",
            crn: "Enter a valid CRN"
        },
        submitHandler: function(form) {
            $('#load-txt').show();
            var data=$("form[name='loginForm']").serialize();
            do_customer_login(data);
        }
    });
})

function do_customer_login(formData){
	$.ajax({
          type:'POST',
          url:$( '#loginForm' ).attr('action'),
          data:formData,
          success:function(msg){
            var response=$.parseJSON(msg);
            if(response.status==1){
                window.location.href = "<?php echo base_url('supervisor/index/0/1'); ?>";
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