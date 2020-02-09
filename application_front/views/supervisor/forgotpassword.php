<style>
    .error{
        color: red;
    }
</style>
<section>
    <div class="tr-register">
        <div class="tr-regi-form">
            <h4>Forgot Password</h4>
            <p>It's free and always will be.</p>
            <?php $this->load->view('errors/msg');?>
            <form class="col s12" name="fPasswordForm" id="fPasswordForm" method="post" action="<?php echo base_url('supervisor/doForgotPassword'); ?>">
                <div class="row">
                    <label id="email-error" class="error" for="email" style="display:none;"></label>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input type="email" class="validate" name="email">
                        <label>Email</label>
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
    $("#fPasswordForm").validate({
        // Specify validation rules
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        // Specify validation error messages
        messages: {
            email: "Please enter a valid email."
        },
        submitHandler: function(form) {
            $('#load-txt').show();
            var data=$("form[name='fPasswordForm']").serialize();
            do_customer_login(data);
        }
    });
})

function do_customer_login(formData){
	$.ajax({
          type:'POST',
          url:$( '#fPasswordForm' ).attr('action'),
          data:formData,
          success:function(msg){
            var response=$.parseJSON(msg);
            if(response.status==1){
                window.location.reload();
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