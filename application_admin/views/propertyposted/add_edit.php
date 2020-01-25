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
			<span class="section">Supplier</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Supplier Name <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="name" name="name" value="<?php echo $name;?>">
					   <?php echo form_error('name'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="email" name="email" value="<?php echo $username;?>" <?php if($action=='Edit'){?>readonly<?php } ?>>
					   <?php echo form_error('email'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Address1 <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <textarea class="validate[required] form-control" id="address1" name="address1"><?php echo $address1;?></textarea>
					   <?php echo form_error('email'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Address2 <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <textarea class="form-control" id="address2" name="address2"><?php echo $address2;?></textarea>
					   <?php echo form_error('email'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Zip Code <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="zip_code" name="zip_code" value="<?php echo $zip_code;?>">
					   <?php echo form_error('email'); ?>
					</div>
				</div>
				<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12"> State <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<select class="form-control validate[required]" name="state" id="state">
							<option value="">Contact State</option>
							<?php foreach($states as $state){?>
								<option value="<?php echo $state['id']; ?>" <?php if($state_id==$state['id']){ ?>selected<?php } ?>><?php echo $state['name'];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">City <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input class="form-control validate[required]" type="text" id="city" name="city" value="<?php echo $city;?>">
					</div>
				</div>
				<div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12">Supplier Type <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<select class="form-control validate[required]" name="supplier_type" id="supplier_type">
							<option value="">Supplier Type</option>
							<?php foreach($supplier_types as $supplier_type){?>
								<option value="<?php echo $supplier_type['id']; ?>" <?php if($supplier_type_id==$supplier_type['id']){ ?>selected<?php } ?>><?php echo $supplier_type['supplier_number'];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
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
	
	var country_id = "<?php echo $country_id; ?>";
	var state_id = "<?php echo $state_id;?>"
	var city_id	="<?php echo $city_id;?>";
 $("#email").on('change',function(){
	$('#email').css('border-color','');
	var email = $(this).val();
	$.ajax({
		type:'POST',
		url:'<?php echo base_url('retailer/emailExist')?>',
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
$("#state").on('change',function(){
	var state_id = $(this).val();
	$.ajax({
		type:'POST',
		url:'<?php echo base_url('supplier/getCity')?>',
		data:{state_id:state_id},
		success:function(data){
			if(data!='No data'){
				$("#city").html(data);
			}else{
				$("#city").html('');
				alert('No City Found.');
			}
		}
	});
 });
</script>	