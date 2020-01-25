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
			<span class="section">Interest Addedit</span>
				
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Name <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="name" name="name" value="<?php echo isset($name)?$name:'';?>">
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
 
 
var sub_category_id = '<?php echo $sub_category_id;?>';	
	 if(sub_category_id){
		$('#category_id').trigger('change');
	 } 
 
});
function check_file(value,id){
	console.log(value+" "+id);
	var ext = value.split('.').pop().toLowerCase();
	if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
		alert('Invalid file type !');
		$("#picture").val('');
	}
}

	

 $("#category_id").change(function(){
	 //alert(1);
    $.ajax({
      url : '<?php echo base_url("tips/getSubcategory");?>',
      type : 'POST',
      data : 'category_id='+$(this).val(),
      dataType : 'json',
      success : function(data){
		  
		 //alert(data); 
        var html = '';
        var preCource = '<?php echo $sub_category_id;?>';
        if(data!=''){
			html = html+'<option value="" >-None-</option>';
          $.each(data,function(index,value){
            var selected ='';
            
			if(preCource == value.id){ selected = 'selected'; }
			
            html = html+'<option value="'+value.id+'" '+selected+'>'+value.title+'</option>';
          }); 
        }else{
			 html = html+'<option value="" >-None-</option>';
		}
        $("#sub_category_id").html(html);
      }
    })
  })
</script>
