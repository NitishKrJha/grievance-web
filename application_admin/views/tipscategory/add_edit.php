<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>
		<form id="form1" name="form1" class="form-horizontal" action="<?php echo $do_addedit_link;?>" method="post" enctype="multipart/form-data">
			<span class="section">Tips Category</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Level <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12"> 
						<select class="form-control validate[required]" name="level" id="level">
							<?php for($lno = 0; $lno < $level_nos; $lno++){ ?>
								<option value="<?php echo $lno; ?>"<?php if($lno == $level){ ?> selected<?php } ?>><?php echo $lno; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Parent <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12" id="service_parent">
						<select id="parent" name="parent" class="form-control">
                        	<option value="0">-- None --</option>
                        </select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Title <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control validate[required]" type="text" id="title" name="title" value="<?php echo $title;?>">
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
});
$("#level").on('change',function(){
	var lv = $(this).val();
	console.log(lv);
	if(lv==1){
		$(".is_paid_div").hide();
		$(".add_more").hide();
		$(".more_rang_data").empty();
	}else{
		$(".is_paid_div").show();
		$(".add_more").show();
		$(".add_more").trigger('click');
	}
	$.ajax({
		url: "<?php echo base_url($this->controller."/setParent/"); ?>"+lv, 
		success: function(result){
		$("#service_parent").html(result);
	}});
});
<?php if($action=='Edit'){?>
$.ajax({
	url: "<?php echo base_url($this->controller."/setParent/"); ?>"+<?php echo $level; ?>+"/"+<?php echo $parent; ?>, 
	success: function(result){
		$("#service_parent").html(result);
	}
});
<?php } ?>
</script>