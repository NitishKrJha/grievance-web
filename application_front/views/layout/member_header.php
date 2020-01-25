<?php
if($this->nsession->userdata('member_session_lang') == "ch") {
	$this->lang->load('static_data', 'chinese');
} else {
	$this->lang->load('static_data', 'english');
	$this->nsession->set_userdata('member_session_lang', 'en');
}
$membertype = $this->nsession->userdata('member_session_membertype');
?>
<div class="inner-logo-block dash-board-start">
  <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
      <div class="row">
        <div class="col-xs-2 col-sm-2 col-md-2">
          <div class="inner-logo"> <a href="<?php echo base_url(); ?>"> <img src="<?php echo CSS_IMAGES_JS_BASE_URL();?>images/inner-logo.png" alt=""> </a> </div>
        </div>
        <div class="col-xs-10 col-sm-10 col-md-3 fright">
          <div class="profile-name">
            <ul>
              <li> <span> <a href="<?php echo $membertype=='1'?base_url('owner'):base_url('renter'); ?>"><img src="<?php echo CSS_IMAGES_JS_BASE_URL();?>images/profile-icon.jpg" alt=""> <?php echo $this->nsession->userdata('member_session_name');?></a></span> </li>
             <?php if($membertype==1){ ?> <li> <a href="<?php echo base_url('adpost') ?>"> <?php echo $this->lang->line('post_rental_ads'); ?> </a> </li><?php } ?>
            </ul>
          </div>
        </div>
		<?php if($membertype==2){ ?>
        <!--<div class="col-xs-12 col-sm-12 col-md-7">
          <div class="dashboard-search-header">
            <div class="dsh-one">
              <div class="select-box">
                <select>
                  <option> Denver </option>
                </select>
              </div>
            </div>
            <div class="dsh-two">
              <div class="select-box">
                <select>
                  <option> All Categories </option>
                </select>
              </div>
            </div>
            <div class="dsh-three">
              <div class="select-box">
                <select>
                  <option> Search in Denver </option>
                </select>
              </div>
            </div>
            <div class="dsh-four">
              <button> <i class="fa fa-search" aria-hidden="true"></i> </button>
            </div>
          </div>
        </div>-->
		<?php } ?>
      </div>
    </div>
  </nav>
</div>