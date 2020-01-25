<script type="text/javascript">
	jQuery(document).ready(function(){
    	jQuery("#form1").validationEngine();
   });
</script>
<style>
	.editor-frame iframe{ width: 100% !important;}
</style>
<!--main content start-->
<section id="main-content">
	<section class="wrapper site-min-height">
        <!-- page start-->
        <div class="col-md-8 col-md-offset-2">
        	<div class="border-head">
                <h3>
                    Employee
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Details of Employee
                    </small>
                </h3>
            </div>
            <div class="tab-content">
                <form id="form1" class="form-horizontal" action="<?php echo $do_addedit_link;?>" method="post" enctype="multipart/form-data">
                    <div id="tab1" class="tab-pane active">
						<div class="form-group">
                            <label class="col-md-3">Company Name:</label>
                            <div class="col-md-9">
                               <?php echo $company_name; ?>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3">Title(Position):</label>
                            <div class="col-md-9">
                               <?php echo $position; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Email Address:</label>
                            <div class="col-md-9">
                               <?php echo $email_id; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Display Name:</label>
                            <div class="col-md-9">
                               <?php echo $display_name.' '.$last_name; ?>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3">Date of Birth:</label>
                            <div class="col-md-9">
                               <?php echo date('m-d-Y',strtotime($dob)); ?>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3">Reference:</label>
                            <div class="col-md-9">
                               <?php echo $member_ref?$member_ref:'N/A'; ?>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3">I Agree to Pay Income Taxes:</label>
                            <div class="col-md-9">
                               <?php switch($pay_income_tax){
									case 1:
										echo 'Yes';
										break;
									case 2:
										echo 'No';
										break;
									default:
										echo 'I Dont Know How It Work';
										break;	
								   
							   } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">From where did you hear about us:</label>
                            <div class="col-md-9">
                               <?php echo $where_heard; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Employee type:</label>
                            <div class="col-md-9">
                            	<?php if($subscription[0]['duration']) { ?>
                                <?php echo $user_type.' ('.$subscription[0]['duration'].')'; ?>
                                <?php } else { ?>
                                <?php echo $user_type; ?>
                                <?php } ?>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3">Paypal Email:</label>
                            <div class="col-md-9">
                            	<?php echo $emp_paypal_email?$emp_paypal_email:'N/A'; ?>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3">Bank Name:</label>
                            <div class="col-md-9">
                            	<?php echo $bank_name?$bank_name:'N/A'; ?>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3">Bank IFSC Code:</label>
                            <div class="col-md-9">
                            	<?php echo $bank_ifsc_code?$bank_ifsc_code:'N/A'; ?>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3">Bank Account Name:</label>
                            <div class="col-md-9">
                            	<?php echo $bank_account_name?$bank_account_name:'N/A'; ?>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3">Bank Account Number:</label>
                            <div class="col-md-9">
                            	<?php echo $bank_account_number?$bank_account_number:'N/A'; ?>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3">Bank Cheque Image:</label>
                            <div class="col-md-9">
                            	 <div class="custom-upload">
									<?php if(!empty($bank_cheque_img)){ ?>
                                    <a href="<?php echo $bank_cheque_img; ?>" target="_blank"><span id="identity_card1" class="btn btn-upload"><i class="fa fa-picture-o" aria-hidden="true"></i></span></a>
									<?php }else{ ?>
										N/A
									<?php } ?>
								</div>
                            </div>
                        </div>
                    </div>
                    <div id="tab2" class="tab-pane">
					<?php if(!empty($insurance_doc)){ ?>
                        <div class="form-group">
                            <label class="col-md-3">Liability insurance:</label>
                            <div class="col-md-9">
                                <a href="<?php echo $insurance_doc; ?>" target="_blank"><span id="liability_insurance" class="btn btn-upload"><i class="fa fa-file-text-o" aria-hidden="true"></i></span></a>
                            </div>
                        </div>
					<?php } ?>
                        <div class="form-group">
                            <label class="col-md-3">Identity card 1:</label>
                            <div class="col-md-9">
                                <div class="custom-upload">
                                    <a href="<?php echo $identity[0]['document']; ?>" target="_blank"><span id="identity_card1" class="btn btn-upload"><i class="fa fa-id-card" aria-hidden="true"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3"></i>Identity card 2:</label>
                            <div class="col-md-9">
                                <div class="custom-upload">
                                    <a href="<?php echo $identity[1]['document']; ?>" target="_blank"><span id="identity_card1" class="btn btn-upload"><i class="fa fa-id-card" aria-hidden="true"></i></span></a>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-md-3">Phone number:</label>
                            <div class="col-md-9">
                               <?php echo $phone_no; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Address:</label>
                            <div class="col-md-9">
                                <textarea class="form-control validate[required]" placeholder="Numbers/Street/Province/Apartment" id="address" name="address"><?php echo $street; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">City:</label>
                            <div class="col-md-9">
                                <input class="form-control validate[required]" type="text" id="city" name="city" value="<?php echo $city; ?>">
                            </div>
                        </div>
                        
						<?php if(!empty($criminal_doc)){ ?>
                        <div class="form-group">
                            <label class="col-md-3">Criminal record:</label>
                            <div class="col-md-9">
                                <div class="custom-upload">
                                    <a href="<?php echo $criminal_doc; ?>" target="_blank"><span id="criminal_record" class="btn btn-upload"><i class="fa fa-file-text" aria-hidden="true"></i></span></a>
                                </div>
                            </div>
                        </div>
						<?php } ?>
                        <div class="form-group">
                            <label class="col-md-3">References (any two):</label>
                            <?php $i = 1; foreach($reference as $ref) { ?>
                            <div class="col-md-4">
                                <div class="refr-one">
                                    <p>Reference <?php echo $i; ?></p>
                                    <input class="form-control validate[required]" type="text" placeholder="Name" id="reference_name<?php echo $i; ?>" name="reference_name[]" value="<?php echo $ref['reference_name']; ?>">
                                    <input class="form-control validate[required]" type="tel" placeholder="Phone no." id="reference_phone<?php echo $i; ?>" name="reference_phone[]" value="<?php echo $ref['reference_phone']; ?>">
                                    <input class="form-control validate[required]" type="email" placeholder="Email Id" id="reference_email<?php echo $i; ?>" name="reference_email[]" value="<?php echo $ref['reference_email_id']; ?>">
                                </div>
                            </div>
                            <?php $i++; } ?>
                        </div>
						<?php if(!empty($profile_video)){ ?>
                        <div class="form-group">
                            <label class="col-md-3">Video:</label>
                            <div class="col-md-9">
                                <div class="custom-upload">
                                    <a href="<?php echo $profile_video; ?>" target="_blank"><span id="prof_video" class="btn btn-upload"><i class="fa fa-video-camera" aria-hidden="true"></i></span></a>
                                </div>
                            </div>
                        </div>
						<?php } ?>
                        <div class="form-group">
                            <label class="col-md-3">Profile picture:</label>
                            <div class="col-md-9">
                                <div class="custom-upload">
                                    <a href="<?php echo $profile_picture; ?>" target="_blank"><span id="prof_picture" class="btn btn-upload"><i class="fa fa-picture-o" aria-hidden="true"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Have you any physical limitation? :</label>
                            <div class="col-md-2">
                                <label class="radio-inline">
                                    <input type="radio" value="No" name="physical_limit" onClick="physical_limit_type('No');" <?php if($physical_limitation == ""){ ?> checked<?php } ?>> No
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radio-inline">
                                    <input type="radio" value="Yes" name="physical_limit" onClick="physical_limit_type('Yes');" <?php if($physical_limitation != ""){ ?> checked<?php } ?>> Yes
                                </label>
                            </div>
                            <div class="col-md-5" id="physical_limit_desc_div" style="<?php if($physical_limitation == ""){ ?>display:none;<?php }else{ ?>display:block;<?php } ?>">
                                <input class="form-control" type="text" placeholder="Describe your physical limitation" name="physical_limit_desc" value="<?php echo $physical_limitation; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Have you any allergy? :</label>
                            <div class="col-md-2">
                                <label class="radio-inline">
                                    <input type="radio" value="No" name="allergy" onClick="allergy_type('No');" <?php if($intolerace_allergy == ""){ ?> checked<?php } ?>> No
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radio-inline">
                                    <input type="radio" value="Yes" name="allergy" onClick="allergy_type('Yes');" <?php if($intolerace_allergy != ""){ ?> checked<?php } ?>> Yes
                                </label>
                            </div>
                            <div class="col-md-5" id="allergy_desc_div" style="<?php if($intolerace_allergy == ""){ ?>display:none;<?php }else{ ?>display:block;<?php } ?>">
                                <input class="form-control" type="text" placeholder="Describe your allergy" name="allergy_desc" value="<?php echo $intolerace_allergy; ?>">
                            </div>
                        </div>
                    </div>   
                    <div id="tab3" class="tab-pane">
                        <div class="form-group">
                            <label class="col-md-3">Upload CV:</label>
                            <div class="col-md-9">
                                <div class="custom-upload">
                                    <a href="<?php echo $cv; ?>" target="_blank"><span id="upload_cv" class="btn btn-upload"><i class="fa fa-file-text-o" aria-hidden="true"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Qualification:</label>
                            <div class="col-md-9 input_fields_wrap">
                                <?php
								$qua = '';
								$sep = '';
								foreach($qualification as $q)
								{
                                	$qua = $qua.$sep.$q;
									$sep = ',&nbsp;';
                                } 
								echo $qua;
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Work field:</label>
                            <div class="col-md-9">
                                <select id="multii" disabled>
                                <?php foreach($services as $service){ ?>
                                    <option value="<?php echo $service['id']; ?>" <?php if(in_array($service['id'], $work_field)){ ?> selected<?php } ?>><?php echo $service['title_en']; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Work experience:</label>
                            <div class="col-md-9">
                                <select class="form-control" name="work_exp">
                                    <option <?php if($work_exp == "Below 1 Year"){ ?> selected<?php } ?>>Below 1 Year</option>
                                    <option <?php if($work_exp == "1 Year"){ ?> selected<?php } ?>>1 Year</option>
                                    <option <?php if($work_exp == "2 Years"){ ?> selected<?php } ?>>2 Years</option>
                                    <option <?php if($work_exp == "3 Years"){ ?> selected<?php } ?>>3 Years</option>
                                    <option <?php if($work_exp == "4 Years"){ ?> selected<?php } ?>>4 Years</option>
                                    <option <?php if($work_exp == "5 Years"){ ?> selected<?php } ?>>5 Years</option>
                                    <option <?php if($work_exp == "Above 5 Years"){ ?> selected<?php } ?>>Above 5 Years</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Choose trades(max 3):</label>
                            <?php $i = 1; foreach($trade as $trd){ ?>
                            <div class="col-md-3">
                                <div class="refr-one">
                                    <p>Trade <?php echo $i; ?></p>
                                    <input class="form-control validate[required]" type="text" placeholder="Name" id="trade_name<?php echo $i; ?>" name="trade_name[]" value="<?php echo $trd['trade_person_name']; ?>">
                                    <!--<input class="form-control" type="tel" placeholder="Phone no." id="trade_phone<?php echo $i; ?>" name="trade_phone[]" value="<?php echo $trd['trade_person_phone']; ?>">
                                    <input class="form-control" type="email" placeholder="Email Id" id="trade_email<?php echo $i; ?>" name="trade_email[]" value="<?php echo $trd['trade_person_email_id']; ?>">-->
                                </div>
                            </div>
                            <?php $i++; } ?>
                        </div>
                        <div class="form-group transport">
                            <label class="col-md-3">Travel by:</label>
                            <div class="col-md-2">
                                <label class="radio-inline">
                                    <input type="radio" value="Foot" name="travel_by" <?php if($travels_by == "Foot"){ ?> checked<?php }?>><i class="fa fa-male"></i>
                                    <br>On foot
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radio-inline">
                                    <input type="radio" value="Bike" name="travel_by" <?php if($travels_by == "Bike"){ ?> checked<?php }?>><i class="fa fa-bicycle"></i>
                                    <br>Bicycle
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radio-inline">
                                    <input type="radio" value="Motor Bike" name="travel_by" <?php if($travels_by == "Motor Bike"){ ?> checked<?php }?>><i class="fa fa-motorcycle"></i>
                                    <br>Motorbike
                                </label>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-inline">
                                    <input type="radio" value="Car" name="travel_by" <?php if($travels_by == "Car"){ ?> checked<?php }?>><i class="fa fa-car"></i>
                                    <br>Car
                                </label>
                            </div>
                            <div class="col-md-2">
                                <label class="radio-inline">
                                    <input type="radio" value="Bus" name="travel_by" <?php if($travels_by == "Bus"){ ?> checked<?php }?>><i class="fa fa-bus"></i>
                                    <br>Bus
                                </label>
                            </div>
                        </div>
                    </div>
                    <div id="tab4" class="tab-pane col-md-3">
                        &nbsp;
                    </div>
                    <div id="tab4" class="tab-pane col-md-9">
                        <button class="btn btn-shadow btn-success" type="submit">Submit</button>
                        &nbsp;&nbsp;
                        <button class="btn btn-shadow btn-success" type="button" onclick="location.href='<?php echo $back_link?>'">Cancel</button>
                    </div> 
                </form>   
            </div>
		</div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<script type="text/javascript">
var classes = {
    2 : 'orange',
    4 : 'blue',
    5 : 'orange'
};
$('#multi').picker({search : true,coloring: classes});
function physical_limit_type(val)
{
	if(val == 'Yes')
		$('#physical_limit_desc_div').show();
	if(val == 'No')	
		$('#physical_limit_desc_div').hide();
}
function allergy_type(val)
{
	if(val == 'Yes')
		$('#allergy_desc_div').show();
	if(val == 'No')	
		$('#allergy_desc_div').hide();
}
</script>