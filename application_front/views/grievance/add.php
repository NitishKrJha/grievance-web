<style>
    textarea {
        width: 100%;
        height: 150px;
        background: #fff;
    }
	.error{
		color: red !important;
	}
	.select-wrapper{
		background: #fff;
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
						<form class="col s12" name="addForm" id="addForm" method="post" enctype="multipart/form-data" action="<?php echo base_url('grievance/doAdd'); ?>">
							<div class="row">
								<div class="input-field col s12">
									<select name="department_id" class="form-control">
										<option value="">Select Department</option>
										<?php
										if(!empty($departments)){
											foreach($departments as $r=>$v){
												echo '<option value="'.$v['id'].'">'.$v['name'].'</option>';
											}
										}
										?>
									</select>
								</div>
								<label id="department_id-error" class="error col s12" for="department_id"></label>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input type="text" name="subject" >
									<label>Subject</label>
								</div>
								<label id="subject-error" class="error col s12" for="subject" ></label>
							</div>
							<div class="row">
								<div class="input-field col s12 m6">
									<input type="email" name="optional_email" >
									<label>Optional Email id</label>
								</div>
								<div class="input-field col s12 m6">
									<input type="text" name="optional_phone" >
									<label>Optional Phone</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
                                    <textarea  name="body"></textarea>
									<label for="pay-ca">Body</label>
								</div>
								<label id="body-error" class="error col s12" for="body" ></label>
							</div>
							
							<div class="row">
								<div class="input-field col s12">
									<div class="file-field">
										<div class="btn btn-primary btn-sm float-left" style="height: 44px !important;">
										<span>Choose file</span>
										<input type="file" name="file">
										</div>
										<div class="file-path-wrapper">
										<input class="file-path validate" type="text" placeholder="Upload your file">
										</div>
									</div>
								</div>
								<label id="file-error" class="error col s12" for="file" ></label>
							</div>
							<div class="row">
								<div class="col s12">
								<input type="submit" value="submit" class="btn full-btn" style="background: #ee4430 !important;"> 
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
            },
			department_id: {
				required: true
			},
			file: {
                required: true
            }
		},
        messages: {
            subject: "Please enter subject",
            body: "Please enter body"
        },
        submitHandler: function(form) {
			$('#load-txt').show();
			form.submit();
			// var data=$("form[name='addForm']").serialize();
            // do_add(data);
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