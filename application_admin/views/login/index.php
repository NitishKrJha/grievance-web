<div class="form-group">
  <!-- <img src="<?php echo base_url();?>public/images/logo.png" style="margin-left: -18px;"> -->
</div>
    <form action="<?php echo $do_login;?>" method="post" name="loginForm" ng-app="loginApp" ng-controller="loginCntrl" novalidate>
		<h1>Login </h1>
		<ul class="parsley-errors-list filled error" ><li class="parsley-required"><?php echo $errmsg;?></li></ul>
		
		<div class="form-group">
		  <input type="text" name="username" class="form-control" placeholder="Username" ng-model="username" required/>
		  <?php echo form_error('email'); ?>
		</div>
		
		<div class="form-group">
		  <input type="password" name="password" class="form-control" placeholder="Password" ng-model="password" ng-minlength="5"  required/>
		  <?php echo form_error('password'); ?>
		</div>

		<div class="form-group">
		  <button type="submit" class="btn btn-default submit" ng-disabled="loginForm.username.$invalid || loginForm.password.$invalid">Log in</button>
		  <!--<a class="reset_pass" href="#">Lost your password?</a>-->
		</div>
		
		<div class="clearfix"></div>
		<div class="separator">
		  <div class="clearfix"></div>
		  <br />
		  <div>
			<h1><? echo constant("GLOBAL_SITE_NAME");?></h1>
			 <p>©<?php echo date('Y');?> All Rights Reserved. <? echo constant("GLOBAL_SITE_NAME");?></p>
		  </div>
		</div>
  </form>
<script>
var app = angular.module('loginApp',[]);
app.controller('loginCntrl',function($scope){});
</script>