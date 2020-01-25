<?php
//pr($data);
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <form id="form1" class="form-horizontal" action="<?php echo $do_addedit_link;?>" method="post" enctype="multipart/form-data">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>

			<span class="section">Counselor</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Name </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control" type="text" id="name" name="name" value="<?php echo isset($name)?$name:'';?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required,custom[email]] form-control" type="text" id="email" name="email" value="<?php echo isset($email)?$email:'';?>" <?php if($action=='Edit'){?>readonly<?php } ?>>
					   <?php echo form_error('email'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Username <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control" type="text" id="username" name="username" value="<?php echo isset($username)?$username:'';?>" <?php if($action=='Edit'){?>readonly<?php } ?>>
					   <?php echo form_error('email'); ?>
					</div>
				</div>
        	
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">About Me </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control" id="about_me" name="about_me" rows="5"><?php echo isset($about_me)?$about_me:'';?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Profile Heading </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control" type="text" id="profile_heading" name="profile_heading" value="<?php echo isset($profile_heading)?$profile_heading:'';?>">
                </div>
            </div>
			
			<div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12"> Age </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control" type="text" id="age" name="age" value="<?php echo isset($age)?$age:'';?>">
                </div>
            </div>
			
			
			<div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cardholder_name">Country </label>
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cardholder_name"> State</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<select class="form-control " name="state_id" id="state_id">
					  <option value="<?php echo $state;?>">-State-</option>
					  										 
					</select>
				</div>
			</div>
			
			<div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cardholder_name">City</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<select class="form-control " name="city_id" id="city_id">
					  <option value="<?php echo $city;?>">-City-</option>
					  										 
					</select>
				</div>
			</div>
			
			<div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cardholder_name">Zip</label>
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
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Certificates </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control" type="file" name="certificate[]" <?php if($certificate){ echo ''; }else{ echo"";}?> accept=".png,.jpeg,.jpg" value="<?php echo isset($certificate[0]['certificateDetails'])?$certificate[0]['certificateDetails']:'';?>"> 
                </div>
                <div>
                    <span class="clickAddMoreCertificate"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
                </div>
            </div>  
			<input type="hidden" id="counslr_id" value="<?= $id?>">
			
			
			<?php 
				if(!empty($certificate)){
				foreach($certificate as $certificateDetails){?>
			
			<img src="<?php echo $certificateDetails['certificate']; ?>"  height="50" width="100"><a href="<?php echo base_url('counselor/delete_certificate/'.$certificateDetails['id'].'/'.$id)?>" title="Delete" onclick="deleteblog()"><i class="fa fa-trash" aria-hidden="true"></i></a> &nbsp;
			
			<?php }
				}
			?>
			
			
            <div class="addMoreCertificate">

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
      url : '<?php echo base_url("counselor/getCountry");?>',
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
      url : '<?php echo base_url("counselor/getCity");?>',
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
        email:{
          required: true,
          email: true,
            remote: {
                  url: "<?php echo base_url('member/emailExistForCouncellor'); ?>",
                  type: "post",
				  data: {
                    'counsilor_id': function () { return $('#counslr_id').val(); }
                    
                }
            }
        }
      },
      messages: {
        email:{
          remote: "This email is already exist"
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