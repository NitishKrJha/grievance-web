<script src="http://formbuilder.online/assets/js/form-builder.min.js"></script>
<style>
.form-actions{
	display: none !important;
}
.loader-overlay{
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0.6);
	position: absolute;
	left:0;
	right:0;
	top:0;
	bottom: 0;
	margin: auto;
	z-index: 999;
}
.loader-image {
    width: 60px;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    margin: auto;
    overflow: hidden;
    height: 60px;
}
.loader-image
svg path,
svg rect{
  fill: #02CAFF;
}
</style>

<div class="loader-overlay" style="display:none">
	<div class="loader-image">
		<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			 width="40px" height="40px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
			<path fill="#000" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
				<animateTransform attributeType="xml"
				  attributeName="transform"
				  type="rotate"
				  from="0 25 25"
				  to="360 25 25"
				  dur="0.6s"
				  repeatCount="indefinite"/>
			</path>
		  </svg>
	</div>
</div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>
		<form id="form1" class="form-horizontal" action="<?php echo $do_addedit_link;?>" method="post" enctype="multipart/form-data">
			<span class="section">Dynamic Form</span>
				<div class="form-group">
					<label class="control-label col-md-2 col-sm-2 col-xs-12"> Category <span class="required">*</span></label>
					<div class="col-md-7 col-sm-7 col-xs-12"> 
						<select class="form-control validate[required]" name="parent" id="parent">
							<option value="">Select Category</option>
							<?php foreach($adParent as $parent){ ?>
								<option value="<?php echo $parent['id'] ?>"><?php echo $parent['title_en'] ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group" id="sub_cat_div">
					<label class="control-label col-md-2 col-sm-2 col-xs-12"> Sub Category <span class="required">*</span></label>
					<div class="col-md-7 col-sm-7 col-xs-12"> 
						<select class="form-control validate[required]" name="child" id="child">
							<option value="">Select Sub Category</option>
						</select>
					</div>
				</div>
				<input type="hidden" id="json_form_data" name="json_form_data" value="" />
				<div class="setDataWrap">
				 <!--<button id="getXML" type="button">Get XML Data</button>-->
				  <button id="getJSON" type="button" style="display:none">Get JSON Data</button>
				  <!--<button id="getJS" type="button">Get JS Data</button>-->
				</div>
				<div id="build-wrap"></div>
				
				  <button id="setData" type="button" class="set_data" style="display:none">Set Data</button>
				  <button id="clear-all-fields" type="button" class="clear_data" style="display:none">Clear Fields</button>
				
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
jQuery(document).ready(function($) {
	jQuery("#form1").validationEngine();
	 fbEditor = document.getElementById('build-wrap'); //Global Variable
	 formBuilder = $(fbEditor).formBuilder();		  //Global Variable	
	$("#send").on('click',function(){
		console.log(formBuilder.actions.getData('json'));
		$("#json_form_data").val(formBuilder.actions.getData('json'));
		return true;
	});
});
$("#parent").on('change',function(){
	$("#child").html('<option value="">Select Sub Category</option>');
	document.getElementById('clear-all-fields').onclick = function() {
		formBuilder.actions.clearFields();
	};
	$(".clear_data").trigger('click');
	var parent = $(this).val();
	$("#sub_cat_div").css('display','block');
	console.log(parent);
	$.ajax({
		url:"<?php echo base_url('dynamicform/getChild');?>",
		data:{parent:parent},
		type:"POST",
		dataType:'Json',
		beforeSend:function(){
			$(".loader-overlay").show();
		},
		success:function(data){
			console.log(data)
			if(data.is_child=='0'){
				$("#sub_cat_div").css('display','none');
				var formData = data.dynamic_form;
				document.getElementById('setData').addEventListener('click', function() {
					formBuilder.actions.setData(formData);
				});
				$(".set_data").trigger('click');
			}else{
				$("#child").html(data.html);
			}
		},
		complete:function(){
			$(".loader-overlay").hide();
		}
	})
});
$("#child").on('change',function(){
	document.getElementById('clear-all-fields').onclick = function() {
		formBuilder.actions.clearFields();
	};
	$(".clear_data").trigger('click');
	var parent = $("#parent").val();
	var child = $(this).val();
	console.log(parent+" "+child);
	$.ajax({
		url:"<?php echo base_url('dynamicform/getChildForm');?>",
		data:{parent:parent,child:child},
		type:"POST",
		dataType:'Json',
		beforeSend:function(){
			$(".loader-overlay").show();
		},
		success:function(data){
			console.log(data)
			if(data.have_form=='1'){
				var formData = data.dynamic_form;
				document.getElementById('setData').addEventListener('click', function() {
					formBuilder.actions.setData(formData);
				});
				$(".set_data").trigger('click');
			}
		},
		complete:function(){
			$(".loader-overlay").hide();
		}
	})
});
</script>