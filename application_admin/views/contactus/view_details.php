<?php 
//pr($data);
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>
		<form id="form1" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
			<span class="section">Contact Details</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-6">Name</label>
				      <div class="col-md-3 col-sm-3 col-xs-12 control-label">
					    <?php echo isset($name)?$name:'';?>						   
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-6"> Email </label>
					 <div class="col-md-3 col-sm-3 col-xs-12 control-label">
					  <?php echo isset($email)?$email:'';?> 
					   
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-6"> Phone No </label>
					 <div class="col-md-3 col-sm-3 col-xs-12 control-label">
					  <?php echo isset($ph)?$ph:'';?> 
					   
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-6"> Query Details </label>
					<div class="col-md-3 col-sm-3 col-xs-12 control-label">
					  <?php echo isset($query)?$query:'';?> 					   
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-6">Post  Date </label>
					<div class="col-md-3 col-sm-3 col-xs-12 control-label">
					  <?php echo date('m-d-Y',strtotime($created_date)); ?> 
					   
					</div>
				</div>
				
				
				
				
				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-6 col-md-offset-3">
					  <a class="btn btn-primary" href="javascript:window.history.back();">Back</a>
					  <!--<button class="btn btn-success" type="submit" id="send">Submit</button>-->
					</div>
				</div>
		</form>   
	 </div>
    </div>
  </div>
</div>