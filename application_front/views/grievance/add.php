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
					<h4>Add Grievance</h4>
					<div class="db-2-main-com db2-form-pay db2-form-com">
						<form class="col s12" name="addForm" id="addForm" method="post" action="<?php echo base_url('grievance/doAdd'); ?>">
							<div class="input-field col s12">
								<label id="subject-error" class="error" for="subject" style="display:none;"></label>
								<label id="optional_phone-error" class="error" for="optional_phone" style="display:none;"></label>
								<label id="optional_email-error" class="error" for="optional_email" style="display:none;"></label>
								<label id="body-error" class="body" for="body" style="display:none;"></label>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input type="text" class="validate" name="subject" >
									<label>Subject</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12 m6">
									<input type="email" class="validate" name="optional_email" >
									<label>Optional Email id</label>
								</div>
								<div class="input-field col s12 m6">
									<input type="text" class="validate" name="optional_phone" >
									<label>Optional Phone</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
                                    <textarea  name="body" class="validate"></textarea>
									<label for="pay-ca">Body</label>
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
    $("#addForm").validate({
        // Specify validation rules
        rules: {
            subject: {
                required: true
            },
            body: {
                required: true
            }
        },
        // Specify validation error messages
        messages: {
            subject: "Please enter subject",
            body: "Please enter body"
        },
        submitHandler: function(form) {
			$('#load-txt').show();
            var data=$("form[name='addForm']").serialize();
            do_add(data);
        }
    });
})


function do_add(formData){
	$.ajax({
          type:'POST',
          url:$( '#addForm' ).attr('action'),
          data:formData,
          success:function(msg){
            var response=$.parseJSON(msg);
            if(response.status==1){
                window.location.href = "<?php echo base_url('grievance/index'); ?>";
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