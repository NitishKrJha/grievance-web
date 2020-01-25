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
			<span class="section">Owner Details</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">First Name <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="first_name" name="first_name" value="<?php echo $first_name;?>" readonly>

					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Last Name <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="last_name" name="last_name" value="<?php echo $last_name;?>" readonly>

					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="email" name="email" value="<?php echo $email;?>" readonly>

					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Picture <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
            <?php
							if($picture==''){ ?>
								<img src="https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg" alt="" class="img-responsive" style="width:100px;height:100px">
							<?php }else{
								if($oauth_uid==''){ ?>
									<img src="<?php echo file_upload_base_url();?>profile_pic/<?php echo $picture; ?>" alt="" class="img-responsive" style="width:100px;height:100px"/>
								<?php }else{?>
									<img src="<?php echo $picture; ?>" alt="" class="img-responsive" style="width:100px;height:100px"/>
								<?php } } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Phone Number <span class="required">*</span></label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <input class="validate[required] form-control" type="text" id="phone_number" name="phone_number" value="<?php echo $phone_no;?>" readonly>

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
