<?php
//pr($data);
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>
		<form id="form1" class="form-horizontal" action="<?php echo $do_addedit_link;?>" method="post" enctype="multipart/form-data">
			<span class="section">Owner/Managers</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">First Name <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="first_name" name="first_name" value="<?php echo $first_name;?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="last_name" name="last_name" value="<?php echo $last_name;?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required,custom[email]] form-control" type="text" id="email" name="email" value="<?php echo $email;?>" <?php if($action=='Edit'){?>readonly<?php } ?>>
					   <?php echo form_error('email'); ?>
					</div>
				</div>
        <?php if($oauth_uid==''){?>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Password <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="password" name="password" value="<?php echo $password_text;?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required,equals[password]] form-control" type="text" id="password_confirm" name="password_confirm" value="<?php echo $password_text;?>" />
					</div>
				</div>
        <?php } ?>
        <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Phone Number <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="phone_no" name="phone_no" value="<?php echo $phone_no;?>">
					</div>
				</div>
        <?php if($oauth_uid==''){?>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Profile Image <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="<?php if($action=='Add'){ ?>validate[required] <?php } ?>form-control" type="file" id="picture" name="picture"  onChange="check_file(this.value)">
					</div>
				</div>
      <?php } ?>
      <?php if($oauth_uid==''){?>
        <?php if($action=='Edit'){ ?>
        <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					  <img src="<?php echo file_upload_base_url();?>profile_pic/<?php echo $picture; ?>" style="height:100px;width:100px" />
					</div>
				</div>
      <?php } }?>
        <input class="form-control" type="hidden" name="old_pic" value="<?php echo $picture;  ?>"
				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-6 col-md-offset-3">
					  <a class="btn btn-primary" href="javascript:window.history.back();">Cancel</a>
					  <button class="btn btn-success" type="submit" id="send">Submit</button>
					</div>
				</div>
		</form>
	 </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#form1").validationEngine();
 $("#email").on('change',function(){
	$('#email').css('border-color','');
	var email = $(this).val();
	$.ajax({
		type:'POST',
		url:'<?php echo base_url('owner/emailExist')?>',
		data:{email:email},
		dataType:'JSON',
		success:function(result){
			if(result.error == 1)
			{
				alert('Email Already exist.');
				$('#email').val('');
				$('#email').css('border-color','#FF0004');
				return false;
			}
		}
	});
 });
});
function check_file(value,id){
	console.log(value+" "+id);
	var ext = value.split('.').pop().toLowerCase();
	if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
		alert('Invalid file type !');
		$("#picture").val('');
	}
}
</script>
