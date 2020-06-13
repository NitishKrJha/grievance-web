
<style>
    .error{
        color: red !important;
        font-size: 14px !important;
    }
</style>



<section>
		<div class="db">
			
			<!--CENTER SECTION-->
			<div class="db-2" style="width:100% !important;">
				<div class="db-2-com db-2-main">
					<h4>Employee Registration Form</h4>
					<div class="db-2-main-com db2-form-pay db2-form-com">
                        <form class="col s12" name="regForm" id="regForm" method="post" action="<?php echo base_url('page/doEmployeeRegister'); ?>" enctype="multipart/form-data">
                        <?php $this->load->view('errors/msg');?>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" class="validate" name="crn">
                                <label>CRN *</label>
                            </div>
                            <label id="crn-error" class="error col s12" for="crn" style="display:none;"></label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" class="validate" name="full_name">
                                <label>Full Name *</label>
                            </div>
                            <label id="full_name-error" class="error col s12" for="full_name" style="display:none;"></label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <div>
                                    <input type="text" class="validate" name="father_name">
                                    <label>Father’s Name *</label>
                                </div>
                            </div>
                            <label id="father_name-error" class="error col s12" for="father_name" style="display:none;"></label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" class="validate" name="designation">
                                <label>Designation</label>
                            </div>
                            <label id="designation-error" class="error col s12" for="designation" style="display:none;"></label>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" class="validate" name="mobile_no">
                                <label>Mobile No *</label>
                            </div>
                            <label id="mobile_no-error" class="error  col s12" for="mobile_no" style="display:none;"></label>
                            
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" class="validate" name="telephone_no">
                                <label>T / No (if any)</label>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" class="validate" name="bu_no">
                                <label>B.U. No *</label>
                            </div>
                            <label id="bu_no-error" class="error  col s12" for="bu_no" style="display:none;"></label>
                            
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m2">
                                <input type="text" class="validate" name="sads" value="Date of Joing *" style="border-width:0px !important, border:none; !important" readonly>
                                <label>Date of Joining *</label>
                                
                            </div>
                            <div class="input-field col s12 m10">
                                <input type="date" class="validate" name="date_of_joining">
                                <label></label>
                            </div>
                            <label id="date_of_joining-error" class="error  col s12" for="date_of_joining" style="display:none;"></label>
                            
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m2">
                                <input type="text" class="validate" name="sads" value="Date of Joing *" style="border-width:0px !important, border:none; !important" readonly>
                                <label>Date of Eligibility *</label>
                                
                            </div>
                            <div class="input-field col s12 m10">
                                <input type="date" class="validate" name="date_of_eligibility">
                                <label></label>
                            </div>
                            <label id="date_of_eligibility-error" class="error  col s12" for="date_of_eligibility" style="display:none;"></label>
                            
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" class="validate" name="street_detail">
                                <label>Mention Street No & Qrs No of existing quarters</label>
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="input-field col s12">
                                <select name="quarter_type_id" class="form-control">
                                    <option value="">Type of Quarter *</option>
                                    <?php
                                    if(!empty($quarter_type_list)){
                                        foreach($quarter_type_list as $r=>$v){
                                            echo '<option value="'.$v['id'].'">'.$v['name'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <label id="quarter_type_id-error" class="error col s12" for="quarter_type_id" style="display:none;"></label>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <select name="applied_for_st_sc" class="form-control">
                                    <option value="">Whether applier for SC / ST quarters</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <select name="applied_for_fresh_changeover" class="form-control">
                                    <option value="">Whether applied for Fresh / Changeover</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12" style="height: 35px !important;">
                                <div class="file-field">
                                    <div class="btn btn-primary btn-sm float-left" style="height: 35px !important;">
                                    <span>Choose file</span>
                                    <input type="file" name="file" accept="image/*, .docx,.pdf">
                                    </div>
                                    <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Upload your file" style="height: 35px !important;">
                                    </div>
                                </div>
                            </div>
                            <label class="success col s12">File Allowed: jpeg,pdf,doc,docx,png</label>
                            <label id="file-error" class="error col s12" for="file" ></label>
                        </div>  

                        <div class="row">
                            <div class="input-field col s12">
                            <i class="fa fa-check" aria-hidden="true"></i>  I hereby declare that the above mentioned information given by me is true to the best of my knowledge and if it is found false, disciplinary action will be taken against me.
                            </div>
                        </div>
							<div class="row">
								<div class="input-field col s12">
									<input type="submit" value="SUBMIT" class="waves-effect waves-light full-btn"> </div>
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
    $("#regForm").validate({
        // Specify validation rules
        rules: {
            full_name: {
                required: true
            },
            father_name: {
                required: true
            },
            mobile_no: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            crn: {
                required: true,
                minlength: 12
            },
            bu_no: {
                required: true
            },
            date_of_joining: {
                required: true
            },
            date_of_eligibility: {
                required: true
            },
            file: {
                required: true
            }
        },
        // Specify validation error messages
        messages: {
            crn: {
                required: "Please enter a valid CRN.",
                minlength: "CRN minimum 12 character long"
            },
            mobile_no: {
                required: "Please enter a valid phone number.",
                minlength: "Please enter a valid 10 digit phone number."
            },
            full_name: "Please enter a Full Name.",
        },
        submitHandler: function(form) {
            $('#load-txt').show();
            //var data=$("form[name='regForm']").serialize();
            var data = new FormData($("form[name='regForm']")[0]);
            do_customer_reg(data);
        }
    });
})

function do_customer_reg(formData){
	$.ajax({
          type:'POST',
          url:$( '#regForm' ).attr('action'),
          data:formData,
          processData: false,
          contentType: false,
          success:function(msg){
            $('#load-txt').hide();
            var response=$.parseJSON(msg);
            if(response.status==1){
                messagealert('Success',response.message,'success');
			}else{
            	messagealert('Error',response.message,'error');
            }
          },
          error: function () {
            $('#load-txt').hide();
            messagealert('Error','Technicle Issue, Please try after some time','error');
          }
    });
}
</script>