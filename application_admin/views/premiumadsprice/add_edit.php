<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>
			<form id="form1" name="form1" class="form-horizontal" method="post" action="<?php echo $do_addedit_link;?>" enctype="multipart/form-data" onsubmit="return validate_data()">
            	<span class="section">Premium Ads Price</span>
				
               <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Title(EN) <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control validate[required]" type="text" id="title_en" name="title_en" value="<?php echo $title_en;?>" readonly>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Price<span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control validate[required]" type="text" id="price" name="price" value="<?php echo $price;?>" onkeypress="return isNumberKey(event)">
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
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}
</script>