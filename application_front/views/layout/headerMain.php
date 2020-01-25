<?php
$user_id =  get_user_id();
$ctrl = $this->uri->segment(1);
$action = $this->uri->segment(2);
if($this->nsession->userdata('member_session_membertype')==1){
    $profile_link = base_url('member/profile');
}else{
    //$profile_link = base_url('counselor/profile');
    $profile_link = base_url('counselor/dashboard');
}
?>
<div class="main-bg">
    <header class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-2 col-sm-2">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/logo.png" class="img-responsive" alt=""></a>
                    </div>
					 <?php if($this->nsession->userdata('member_session_membertype')==''){ ?>
                    <div class="loginbox pull-right visible-xs">
                        <a href="<?php echo base_url('login');?>" class="btn btn-login">Login</a>
                        <a href="<?php echo base_url('page/register');?>" class="btn btn-joinus">Join Free</a>
                    </div>
					
					 <?php } ?>
                </div>
                <div class="col-lg-9 col-md-10 col-sm-10">
                    <?php 
					 $user_id =  get_user_id();
					if($this->nsession->userdata('member_session_membertype')==''){ ?>
                        <div class="loginbox hidden-xs">
                            <a href="<?php echo base_url('login');?>" class="btn btn-login">Login</a>
                            <a href="<?php echo base_url('page/register');?>" class="btn btn-joinus">Join Free</a>
                        </div>
                   <?php }else{?>
				   
                        <div class="pull-right ">
						<?php if($memberData['member_type']== 1){ ?>
						  <a href="<?php echo base_url('member/membershipplan')?>" class="btn btn-login">Upgrade</a>
						<?php } ?> 
						   <div class="btn-group profile-menu">
                                <button type="button" class="btn btn-user dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> <i class="fa fa-angle-down" aria-hidden="true"></i> </button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo $profile_link;?>">Profile</a></li>
                                    <li><a href="<?php echo base_url('logout')?>">Logout</a></li>
                                </ul>
                            </div>
                        </div>
						
                    <?php } ?>
                    <div class="menu_sec">
                        <nav class="navbar navbar-default">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                                <a class="navbar-brand visible-xs" href="index.html">Menu</a>
                            </div>
                            <div class="collapse navbar-collapse nav-collapse">
                                <ul class="nav navbar-nav">
                                    <li <?php if($ctrl==''){?>class="active"<?php } ?>><a href="<?php echo base_url(); ?>"> Home </a></li>
                                    <li <?php if($ctrl=='about'){?>class="active"<?php } ?>><a href="<?php echo base_url('about');?>">About Us </a></li>
                                    <li <?php if($ctrl=='how-it-works'){?>class="active"<?php } ?>><a href="<?php echo base_url('how-it-works');?>">How it Works </a></li>
                                    <li <?php if($ctrl=='whats-new'){?>class="active"<?php } ?>><a href="<?php echo base_url('whats-new');?>">What’s New</a></li>

                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
