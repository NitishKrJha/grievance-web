<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Update Password</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <br>
        <ul class="parsley-errors-list filled error text-center" ><li class="parsley-required"><?php echo $errmsg; ?></li></ul>
			<form id="form1" class="form-horizontal form-label-left" action="<?php echo base_url();?>user/do_changepass/" method="post" >
				<div class="form-group">
					<label for="last-name" class="control-label col-md-2 col-sm-3 col-xs-12">Old Password <span class="required">*</span></label>
					<div class="col-sm-9">    
						<input type="password" placeholder="Old Password" autocomplete="off" name="old_admin_pwd" id="old_admin_pwd" class="validate[required,minsize[5],maxSize[20]] form-control">
						<?php echo form_error('old_admin_pwd'); ?>
					</div>
				</div>    
				<div class="form-group">
					 <label for="last-name" class="control-label col-md-2 col-sm-3 col-xs-12">New Password <span class="required">*</span></label>
					<div class="col-sm-9">
						<input type="password" placeholder="New Password" autocomplete="off" name="new_admin_pwd" id="new_admin_pwd" class="validate[required,minsize[5],maxSize[20]] form-control">
						<?php echo form_error('new_admin_pwd'); ?>
					 </div>   
				</div>
				<div class="form-group">
					<label for="last-name" class="control-label col-md-2 col-sm-3 col-xs-12">Confirm Password<span class="required">*</span></label>
					<div class="col-sm-9">
						<input type="password" placeholder="Confirm Password" autocomplete="off" name="conf_new_admin_pwd" id="conf_new_admin_pwd" class="validate[required,equals[new_admin_pwd]] form-control">
						<?php echo form_error('conf_new_admin_pwd'); ?>
					</div>
				</div>                                        
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-9">
						<button class="btn btn-shadow btn-success" type="submit">Change Password</button>
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
</script>