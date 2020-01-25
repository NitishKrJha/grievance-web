<style>
.error{
    color:red;
}
</style>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <form id="form1" class="form-horizontal" action="<?php echo $do_addedit_link;?>" method="post" enctype="multipart/form-data">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>

			<span class="section">Supervisor</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">First Name<span class="required">*</span> </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control" type="text" id="first_name" name="first_name" value="<?php echo isset($first_name)?$first_name:'';?>">
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Middle Name </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control" type="text" id="middle_name" name="middle_name" value="<?php echo isset($middle_name)?$middle_name:'';?>">
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control" type="text" id="last_name" name="last_name" value="<?php echo isset($last_name)?$last_name:'';?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control" type="text" id="email" name="email" value="<?php echo isset($email)?$email:'';?>" <?php if($action=='Edit'){?>readonly<?php } ?>>
					   <?php echo form_error('email'); ?>
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control" type="text" id="phone" name="phone" value="<?php echo isset($phone)?$phone:'';?>" <?php if($action=='Edit'){?>readonly<?php } ?>>
					   <?php echo form_error('email'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">CRN <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control" type="text" id="crn" name="crn" value="<?php echo isset($crn)?$crn:'';?>" <?php if($action=='Edit'){?>readonly<?php } ?>>
					   <?php echo form_error('crn'); ?>
					</div>
				</div>
        	
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Department <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control" type="text" id="department" name="department" value="<?php echo isset($department)?$department:'';?>" <?php if($action=='Edit'){?>readonly<?php } ?>>
                        <?php echo form_error('department'); ?>
                    </div>
                </div>
			
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Joining <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control" type="date" id="doj" name="doj" value="<?php echo isset($doj)?$doj:'';?>" <?php if($action=='Edit'){?>readonly<?php } ?>>
                        <?php echo form_error('department'); ?>
                    </div>
                </div>
			
			
                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cardholder_name">Country<span class="required">*</span> </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" name="country_id" id="country_id">
                        <option value="">-Country-</option>
                        <?php foreach($allcountry as $countrydetail){?>
                        <option value="<?php echo $countrydetail['id'];?>" <?php if($countrydetail['id']==$country){ echo "selected";}?>><?php echo $countrydetail['name'];?></option>
                        <?php }?> 
                        </select>
                    </div>
                </div>
			
                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cardholder_name"> State<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control " name="state_id" id="state_id">
                        <option value="<?php echo $state;?>">-State-</option>
                                                                
                        </select>
                    </div>
                </div>
			
                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cardholder_name">City<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control " name="city_id" id="city_id">
                        <option value="<?php echo $city;?>">-City-</option>
                                                                
                        </select>
                    </div>
                </div>
			
                <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cardholder_name">Zip<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class=" form-control" type="text" id="zip" name="zip" value="<?php echo isset($zip)?$zip:'';?>">	
                        
                    </div>
                </div>
			
			
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Profile Image </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="validate[<?php if($picture){echo "";}else{ echo "";}?>] form-control" type="file" id="picture" name="picture" accept=".png,.jpeg,.jpg" >
                        
                        <?php if($picture){?>
                        <img src="<?php echo isset($picture)?$picture:''; ?>"  height="50" width="100"><br> 
                        <?php } ?>
                    </div>
                </div>
            
			    <input class="form-control" type="hidden" name="old_pic" value="<?php echo isset($picture)?$picture:'';?>"
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <a class="btn btn-primary" href="javascript:window.history.back();">Cancel</a>
                        <button class="btn btn-success" type="submit" id="send">Submit</button>
                    </div>
                </div>

	        </div>
        </form>
    </div>
  </div>
</div>
<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jquery.validate.min.js"></script>
<script type="text/javascript">
function check_file(value,id){
	console.log(value+" "+id);
	var ext = value.split('.').pop().toLowerCase();
	if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
		alert('Invalid file type !');
		$("#picture").val('');
	}
}
$(document).on('click','.clickAddMoreCertificate',function(){
    $(".addMoreCertificate").append($("#cerifdateData").html());
});
$(document).on('click','.removeMoreCertificate',function(){
    $(this).parent().parent().remove();
})
</script>

<script>
function deleteblog() {
	//alert(1);
    if (confirm("Are you sure want to delete?")) {
        //window.location.href=url;
    }
    return false;
}
</script>

<script>
$(document).ready(function(){
	
	 var state = '<?php echo $state;?>';
	 
	 if(state){
		 $('#country_id').trigger('change'); 
	 }
	 
	var city = '<?php echo $city;?>';
	
	if(city){		
		$('#state_id').trigger('change');
	}
	
	 
	
	 
});

 $("#country_id").change(function(){
	 
	//alert(1);
	 
    $.ajax({
      url : '<?php echo base_url("supervisor/getCountry");?>',
      type : 'POST',
      data : 'country_id='+$(this).val(),
      dataType : 'json',
      success : function(data){
        var html = '';
        var preCource = '<?php echo $state;?>';
        if(data!=''){
          $.each(data,function(index,value){
            var selected ='';
            if(preCource == value.id){ selected = 'selected'; }
            html = html+'<option value="'+value.id+'" '+selected+'>'+value.name+'</option>';
          }); 
        }else{
			 html = html+'<option value="" >-None-</option>';
		}
        $("#state_id").html(html);
      }
    })
  })
 
  $("#state_id").change(function(){
	 
    $.ajax({
      url : '<?php echo base_url("supervisor/getCity");?>',
      type : 'POST',
      data : 'state_id='+$(this).val(),
      dataType : 'json',
      success : function(data){
        var html = '';
        var preCource = '<?php echo $city;?>';
        if(data!=''){
          $.each(data,function(index,value){
            var selected ='';
            if(preCource == value.id){ selected = 'selected'; }
            html = html+'<option value="'+value.id+'" '+selected+'>'+value.name+'</option>';
          }); 
        }else{
			 html = html+'<option value="" >-None-</option>';
		}
        $("#city_id").html(html);
      }
    })
  })

  $(document).ready(function(){
  
  $("#form1").validate({
    
      // Specify validation rules
      rules: {
        first_name:{
            required: true
        },
        country_id:{
            required: true
        },
        state_id:{
            required: true
        },
        city_id:{
            required: true
        },
        zip:{
            required: true
        },
        department:{
            required: true
        },
        email:{
            required: true,
            email: true,
            remote: {
                  url: "<?php echo base_url('supervisor/emailExist/'.$id); ?>",
                  type: "post"
            }
        },
        crn:{
            required: true,
            remote: {
                  url: "<?php echo base_url('supervisor/crnExist/'.$id); ?>",
                  type: "post"
            }
        },
        phone:{
            required: true,
            remote: {
                  url: "<?php echo base_url('supervisor/phoneExist/'.$id); ?>",
                  type: "post"
            }
        }
      },
      messages: {
        email:{
          remote: "This email is already exist"
        },
        crn:{
          remote: "This CRN is already exist"
        },
        phone:{
          remote: "This phone is already exist"
        }
      },
      submitHandler: function(form) {
		
        form.submit();
      }
    });
});
</script>
<!-- <script type="text/javascript" id="cerifdateData">
    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-md-offset-3 col-xs-12">
        <input class="form-control" type="file" name="certificate[]" required accept=".png,.jpeg,.jpg">
        </div>
    <div>
    <span class="removeMoreCertificate"><i class="fa fa-minus-square" aria-hidden="true"></i></span>
    </div>
    </div>
</script> -->