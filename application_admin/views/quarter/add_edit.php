<style>
.error{
    color:red;
}
</style>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <form id="form1" class="form-horizontal" action="<?php echo $do_addedit_link;?>" method="post" enctype="multipart/form-data">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>

			<span class="section">Supervisor</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">First Quarter No<span class="required">*</span> </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control" type="text" id="quarter_no" name="quarter_no" value="<?php echo isset($quarter_no)?$quarter_no:'';?>">
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Quarter Type </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control" type="text" id="quarter_type" name="quarter_type" value="<?php echo isset($quarter_type)?$quarter_type:'';?>">
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Full Address</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="form-control" type="text" id="full_address" name="full_address" value="<?php echo isset($full_address)?$full_address:'';?>">
					</div>
				</div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <a class="btn btn-primary" href="javascript:window.history.back();">Cancel</a>
                        <button class="btn btn-success" type="submit" id="send">Submit</button>
                    </div>
                </div>

	        </div>
        </form>
    </div>
  </div>
</div>
<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jquery.validate.min.js"></script>
<script>


  $(document).ready(function(){
  
  $("#form1").validate({
    
      // Specify validation rules
      rules: {
        quarter_no:{
            required: true,
            remote: {
                  url: "<?php echo base_url('quarter/quarterNoExist/'.$id); ?>",
                  type: "post"
            }
        },
        quarter_type:{
            required: true
        },
        full_address:{
            required: true
        }
      },
      messages: {
        quarter_no:{
          remote: "This Quarter No. is already exist"
        }
      },
      submitHandler: function(form) {
		
        form.submit();
      }
    });
});
</script>