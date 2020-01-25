<?php 
//pr($resultData);
//pr($dynamic_form);
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  <?php //echo validation_errors(); ?>
      <ul class="parsley-errors-list filled error text-left" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>
		<form id="form1" class="form-horizontal" action="<?php echo $do_addedit_link;?>" method="post" enctype="multipart/form-data">
			<span class="section">Posted Ads Details</span>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Ad Title :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="x_content">
							<p><?php echo $resultData[0]['ads_title'];?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Ad Description :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="x_content">
							<p><?php echo $resultData[0]['ads_desc'];?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Ad Price :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="x_content">
						<?php if($resultData[0]['rent_price']['daily']!=''){ ?>
							<p>Daily <i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>$ <?php echo $resultData[0]['rent_price']['daily']; ?> </span></p>
							
						<?php }if($resultData[0]['rent_price']['weekly']!=''){ ?>
						
							
							<p>Weekly <i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>$ <?php echo $resultData[0]['rent_price']['weekly']; ?> </span></p>
							
						<?php }if($resultData[0]['rent_price']['weekend']!=''){ ?>
						
							
							<p>Weekend <i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>$ <?php echo $resultData[0]['rent_price']['weekend']; ?> </span></p>
							
						<?php }if($resultData[0]['rent_price']['monthly']!=''){ ?>
						
							
							<p>Monthly <i class="fa fa-angle-double-right" aria-hidden="true"></i> <span>$ <?php echo $resultData[0]['rent_price']['monthly']; ?> </span></p>
							
						<?php } ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Accept Payment :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="x_content">
							<p><?php echo implode('-',$resultData[0]['accept_payment']);?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Ad Images :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="x_content">
							<img src="<?php echo $resultData[0]['ads_pic1'];?>" style="width: 100px;height: 100px;" />
							<?php if($resultData[0]['ads_pic2']!=''){ ?>
								<img src="<?php echo $resultData[0]['ads_pic2'];?>" style="width: 100px;height: 100px;" />
							<?php } ?>
							<?php if($resultData[0]['ads_pic3']!=''){ ?>
								<img src="<?php echo $resultData[0]['ads_pic3'];?>" style="width: 100px;height: 100px;" />
							<?php } ?>
							<?php if($resultData[0]['ads_pic4']!=''){ ?>
								<img src="<?php echo $resultData[0]['ads_pic4'];?>" style="width: 100px;height: 100px;" />
							<?php } ?>
						</div>
					</div>
				</div>
			
			
			
			
			
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Owner Name :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="x_content">
							<p><?php echo $resultData[0]['owner_name'];?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Owner Mobile :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <div class="x_content">
							<p><?php echo $resultData[0]['owner_mobile'];?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Owner Email :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <div class="x_content">
							<p><?php echo $resultData[0]['owner_email'];?></p>
						</div>
					</div>
				</div>
				<!--<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Country :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <div class="x_content">
							<p><?php echo $resultData[0]['country'];?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">State :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <div class="x_content">
							<p><?php echo $resultData[0]['state'];?></p>
						</div>
					</div>
				</div>-->
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">City :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <div class="x_content">
							<p><?php echo $resultData[0]['city'];?></p>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Locality :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <div class="x_content">
							<p><?php echo $resultData[0]['locality'];?></p>
						</div>
					</div>
				</div>
				<!--<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Zip Code :</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
					   <div class="x_content">
							<p><?php echo $resultData[0]['zip_code'];?></p>
						</div>
					</div>
				</div>-->
				<?php $resultKey = array_keys($resultData[0]);?>
				<?php foreach($dynamic_form as $dform){ 
					if($dform->type!='header'){ ?>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $dform->label; ?></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
						   <div class="x_content">
						   <?php if(in_array($dform->name,$resultKey)){ ?>
							   <?php if($dform->type=='file'){ ?>
									<img src="<?php echo $resultData[0][$dform->name]; ?>" style="width: 100px;height: 100px;" />
							   <?php }else{ ?>
									<p><?php echo $resultData[0][$dform->name]; ?></p>
						   <?php } } ?>	
							</div>
						</div>
					</div>
				<?php } } ?>
				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-6 col-md-offset-3">
					  <a class="btn btn-primary" href="javascript:window.history.back();">Back</a>
					</div>
				</div>
		</form>   
	 </div>
    </div>
  </div>
</div>