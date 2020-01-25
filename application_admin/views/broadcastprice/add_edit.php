<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>
		<form id="form1" class="form-horizontal" action="<?php echo $do_addedit_link;?>" method="post" enctype="multipart/form-data">
			<span class="section">Retailer</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Select Retailer <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <select id="retailer" name="retailer" class="form-control">
							<option>Choose Retailer</option>
							<?php foreach($retailer_list as $retailer){ ?>
								<option value="<?php echo $retailer['id'];?>"><?php echo $retailer['name'] ?></option>
							<?php  }?>
                          </select>
					   <?php echo form_error('name'); ?>
					</div><a class="add_more" href="javascript:void(0)"><i class="fa fa-plus"></i> Add More</a>
				</div>
				<div class="form-group more_rang_data">
					<div class="form-group text-center">
						<div class="col-md-3 text-center">Starting Range</div>
						<div class="col-md-3 text-center">End Range</div>
						<div class="col-md-3 text-center">Price</div>
					</div>
				</div>
				<div class="form-group" id="tool1">
					
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
<script>
window.currentVal = 0;
$(".add_more").on('click',function(){
	var tool_val = $("#tool_id").val();
	$(".more_rang_data").append($("#newEliments").html());
	$("#tool_id").val(tool_val);
});
$(document).on("click",".delelem",function(){
	$(this).parent().parent().remove();
});
$(document).ready(function(){
	$(".add_more").trigger('click');
});
$(document).on('click','#send',function(){
	
$("#retailer").css('border-color','');
$(".start_range").attr('style','');
$(".end_range").attr('style','');
$(".price_val").attr('style','');


if($("#retailer").val()=='Choose Retailer'){
	$("#retailer").css('border-color','#FF0004');
	return false;
}
//Create an array
var starting_range = $("input[name='starting_range[]']")
		  .map(function(){return $(this).val();}).get();
var ending_range = $("input[name='ending_range[]']")
		  .map(function(){return $(this).val();}).get();
var price = $("input[name='price[]']").map(function(){
		return $(this).val();}).get();
		
//Check if value is empty for start range		
$.each(starting_range,function(i, val ){
	if(val==''){
		$("input[name='starting_range[]']").eq(i).css('border-color','#FF0004');
		return false;
	}
});
//Check if value is empty for End range		
$.each(ending_range,function(i, val ){
	if(val==''){
		$("input[name='ending_range[]']").eq(i).css('border-color','#FF0004');
		return false;
	}
});
//Check if value is empty for Price		
$.each(price,function(i, val ){
	if(val==''){
		$("input[name='price[]']").eq(i).css('border-color','#FF0004');
		return false;
	}
});


if(starting_range[0]>0){
	for(var i=0; i<starting_range.length; i++){
		console.log("ending_range: "+ending_range[i]);
		console.log("starting_range: "+starting_range[i]);
		if(parseInt(ending_range[i]) < parseInt(starting_range[i])){
			$("input[name='ending_range[]']").eq(i).css('border-color','#FF0004');
			$("input[name='ending_range[]']").eq(i).val('');
			return false;
		}
		if(i>0 && i<starting_range.length){
			//alert(parseInt(ending_range[i-1])+1);
			//if(parseInt(starting_range[i]) < parseInt(ending_range[i-1])){
			if(parseInt(starting_range[i]) != parseInt(ending_range[i-1])+1 ){
				$("input[name='starting_range[]']").eq(i).css('border-color','#FF0004');
				$("input[name='starting_range[]']").eq(i).val('');
				return false;
			}
		}
	}
}else{
	alert('Starting range has to be more than 0.');
	return false;
}
});
function getkey(e)
{
  if (window.event)
  return window.event.keyCode;
  else if (e)
  return e.which;
  else
  return null;
}
function goodchars(e, goods)
{
  var key, keychar;
  key = getkey(e);
  if (key == null) return true;
  keychar = String.fromCharCode(key);
  keychar = keychar.toLowerCase();
  goods = goods.toLowerCase();
  if (goods.indexOf(keychar) != -1)
  return true;
  if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
  return true;
  return false;
}
</script>
<script type="html/text" id="newEliments">
<div class="form-group col-md-12 newelem">
	<div class="col-md-3"><input class="form-control start_range setrange" onkeypress="return goodchars(event,'1234567890');" name="starting_range[]" type="text"></div>
	<div class="col-md-3"><input class="form-control end_range setrange" onkeypress="return goodchars(event,'1234567890');" name="ending_range[]" type="text"></div>
	<div class="col-md-3"><input class="form-control price_val" onkeypress="return goodchars(event,'1234567890');" name="price[]" type="text"></div>
	<div class="col-md-3 text-left"><i class="fa fa-trash delelem"></i></div>
</div>
</script>