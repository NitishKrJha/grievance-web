<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
	  <?php //echo form_error('title'); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>
		<form id="form1" class="form-horizontal" action="<?php echo $do_addedit_link;?>" method="post" enctype="multipart/form-data">
			<span class="section">Broadcast Type File</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Summary File to Use <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="file_to_use" name="file_to_use" value="<?php echo $file_to_use_name;?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <textarea class="validate[required] form-control" type="text" id="desc" onkeyUp="checkSpecialChar('desc')" name="desc"><?php echo $desc;?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">UOM <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="uom" name="uom" value="<?php echo $uom;?>" onkeyUp="checkSpecialChar('uom')">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Price Per Unit <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required,custom[number]] form-control" type="text" id="price_per_unit" name="price_per_unit" value="<?php echo $price_per_unit;?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Minimum Order Amount <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required,custom[integer]] form-control" type="text" id="minium_order_amt" name="minium_order_amt" value="<?php echo $minimum_order_amt;?>" onkeyUp="checkSpecialChar('minium_order_amt')">
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