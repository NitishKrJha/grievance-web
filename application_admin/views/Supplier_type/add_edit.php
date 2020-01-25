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
			<span class="section">Supplier Type</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Number <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="supplier_number" name="supplier_number" value="<?php echo $supplier_number;?>">
					   <?php echo form_error('supplier_number'); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="supplier_desc" name="supplier_desc" value="<?php echo $supplier_desc;?>" >
					   <?php echo form_error('supplier_desc'); ?>
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
jQuery(document).ready(function(){
	jQuery("#form1").validationEngine();
});
</script>	