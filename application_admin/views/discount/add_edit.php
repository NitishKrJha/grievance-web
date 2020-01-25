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
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Qty Volume <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required,custom[integer]] form-control" type="text" id="qty" name="qty" value="<?php echo $qty;?>" onkeyUp="checkSpecialChar('qty')">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Discount percentage(%) <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required,custom[number]] form-control" type="text" id="discount_percentage" name="discount_percentage" value="<?php echo $discount_percentage;?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Discount Start date <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="discount_start_date" name="discount_start_date" value="<?php echo date('d-m-Y',strtotime($discount_start_date));?>" onkeyUp="checkSpecialChar('minium_order_amt')">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Discount End date <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="discount_end_date" name="discount_end_date" value="<?php echo date('d-m-Y',strtotime($discount_end_date));?>" onkeyUp="checkSpecialChar('minium_order_amt')">
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
	$("#discount_start_date").datepicker({
		dateFormat: 'dd-mm-yy',
		minDate: 0,
	  onSelect: function(date) {
		$("#discount_end_date").datepicker('option', 'minDate', date);
	  }
	});
	$("#discount_end_date").datepicker({
		dateFormat: 'dd-mm-yy',
		minDate: new Date(<?php echo date('Y',strtotime($discount_start_date)) ?>, <?php echo date('m',strtotime($discount_start_date)) ?> - 1,<?php echo date('d',strtotime($discount_start_date)) ?>)
	});
});
</script>	