<div class="nav_menu">
<nav>
  <div class="nav toggle">
    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
  </div>
  <ul class="nav navbar-nav navbar-right">
    <li class="">
      <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <span class=" fa fa-angle-down"></span>
      </a>
      <ul class="dropdown-menu dropdown-usermenu pull-right">
        <li><a href="<?php echo base_url('user/changepass/');?>"><i class="fa fa-key pull-right"></i>Change Password</a></li>
		<!--<li><a href="<?php echo base_url('setting/');?>"><i class="fa fa-cog pull-right"></i>  Settings</a></li>-->
		 <li><a href="<?php echo base_url('logout/');?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
      </ul>
    </li>
    <li></li>
    <li class="">
    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Welcome to <?php echo constant("GLOBAL_SITE_NAME");?></a>
    </li>
  </ul>
</nav>
</div>