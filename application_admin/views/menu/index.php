<?php
$controller = $this->uri->segment(1);
$action = $this->uri->segment(2);
?>
<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="<?php echo base_url();?>" class="site_title"><img style="height: 23px;" src="<?php echo CSS_IMAGES_JS_BASE_URL.'images/logo.png'; ?>"><span> <?php echo constant("GLOBAL_SITE_NAME");?></span></a>
    </div>
    <div class="clearfix"></div>
    
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <ul class="nav side-menu">
            <li <?php if($controller=='users' && $action=='index') {?>class="active" <?php } ?>>
              <a href="<?php echo base_url('users/index/0/1');?>"><i class="fa fa-user" aria-hidden="true"></i> Users</a>
            </li>
		    <li <?php if($controller=='supervisor' && $action=='index') {?>class="active" <?php } ?>>
              <a href="<?php echo base_url('supervisor/index/0/1');?>"><i class="fa fa-user" aria-hidden="true"></i> Supervisor</a>
            </li>
			
            <li>
                <a><i class="fa fa-file-o" aria-hidden="true"></i> CMS <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url('content/pages/whatsNew');?>">Whats New</a></li>
                    <li><a href="<?php echo base_url('content/pages/termsConditions');?>">Terms & Conditions</a></li>
                    <li><a href="<?php echo base_url('content/pages/privacyPolicy');?>">Privacy Policy</a></li>
                </ul>
            </li>
            <li <?php if($controller=='setting' && $action=='global_setting') {?>class="active" <?php } ?>>
                <a href="<?php echo base_url('setting/index/0/1');?>"><i class="fa fa-cog" aria-hidden="true"></i> Global Setting</a>
            </li>
            <li <?php if($controller=='faq') {?>class="active" <?php } ?>>
                <a href="<?php echo base_url('faq/index/0/1');?>"><i class="fa fa-cog" aria-hidden="true"></i> Help Center</a>
            </li>
            </li>
			
            <!-- <li <?php if($controller=='tipscategory') {?>class="active" <?php } ?>>
              <a href="<?php echo base_url('tipscategory/index/0/1');?>"><i class="fa fa-cog" aria-hidden="true"></i> Tips Category</a>
            </li> -->
			
            <!-- <li <?php if($controller=='tips' && $action=='index') {?>class="active" <?php } ?>>
                <a href="<?php echo base_url('tips/index/0/1');?>"><i class="fa fa-cog" aria-hidden="true"></i> Tips</a>
            </li> -->
			<?php /* ?>
            <li>
                <a><i class="fa fa-connectdevelop" aria-hidden="true"></i>Appearance<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url('appearance/body');?>">Body Type</a></li>
                    <li><a href="<?php echo base_url('appearance/hair');?>">Hair Type</a></li>
                    <li><a href="<?php echo base_url('appearance/eye');?>">Eye Type</a></li>
                </ul>
            </li>
            <li <?php if($controller=='ethnicity') {?>class="active" <?php } ?>>
                <a href="<?php echo base_url('ethnicity/index/0/1');?>"><i class="fa fa-cog" aria-hidden="true"></i> Ethnicity</a>
            </li>
            <li <?php if($controller=='faith') {?>class="active" <?php } ?>>
                <a href="<?php echo base_url('faith/index/0/1');?>"><i class="fa fa-child" aria-hidden="true"></i> Faith</a>
            </li>
            <li <?php if($controller=='language') {?>class="active" <?php } ?>>
                <a href="<?php echo base_url('language/index/0/1');?>"><i class="fa fa-book" aria-hidden="true"></i> Language</a>
            </li>
            <li <?php if($controller=='education') {?>class="active" <?php } ?>>
                <a href="<?php echo base_url('education');?>"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Education</a>
            </li>
             <li>
                <a><i class="fa fa-play" aria-hidden="true"></i>Activities<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo base_url('activities/indoor');?>">Indoor Activities</a></li>
                    <li><a href="<?php echo base_url('activities/outdoor');?>">Outdoor Activities</a></li>
                </ul>
            </li>
            <li <?php if($controller=='pet') {?>class="active" <?php } ?>>
                <a href="<?php echo base_url('pet/index/0/1');?>"><i class="fa fa-paw" aria-hidden="true"></i> Pet</a>
            </li>
            <li <?php if($controller=='vacation') {?>class="active" <?php } ?>>
                <a href="<?php echo base_url('vacation/index/0/1');?>"><i class="fa fa-map-marker" aria-hidden="true"></i> Vacation</a>
            </li>
            <?php */ ?>
        </ul>
      </div>
    </div>
  </div>
</div>
