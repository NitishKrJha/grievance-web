<?php 
$ctrl = $this->uri->segment(1);
$action = $this->uri->segment(2);
$para1 = ($this->uri->segment(3))?$this->uri->segment(3):'';
if($this->nsession->userdata('member_session_membertype')==1){
    $profile_link = base_url('member/profile');
}else{
    $profile_link = base_url('counselor/dashboard');
}
$actionArr = array('appearance','lifestyle','relationship','background','activities','pet','zodiac','politics','vacation','upload_image');
?>
<div class="col-md-2">
    <div class="dashboard-nav">
        <div class="dashboard-list">
		 
            <ul id="left_menu">
            <li class="<?php if($ctrl=="member" && $action=="dashboard"){echo "active";}?>"><a href="<?= base_url('member/dashboard')?>"> Dashboard</a></li>
                <li class="dropdown-nav <?php if(in_array($action,$actionArr)) { echo "active"; }?>">
                <a data-toggle="collapse" data-target="#matchMkng" href="javascript:void(0);">My Account </a>
                <ul id="matchMkng" class="collapse <?php if(in_array($action,$actionArr)) { echo "in"; }?>">
                    	<li class="<?php if($ctrl=="member" && $action=="appearance"){echo "active";}?>"><a href="<?php echo base_url("member/appearance")?>">Appearance</a></li>
                        <li class="<?php if($ctrl=="member" && $action=="lifestyle"){echo "active";}?>"><a href="<?php echo base_url("member/lifestyle")?>">Lifestyle</a></li>
                        <li class="<?php if($ctrl=="member" && $action=="relationship"){echo "active";}?>"><a href="<?php echo base_url("member/relationship")?>">Relationship</a></li>
                        <li class="<?php if($ctrl=="member" && $action=="background"){echo "active";}?>"><a href="<?php echo base_url("member/background")?>">Background</a></li>
                        <li class="<?php if($ctrl=="member" && $action=="activities"){echo "active";}?>"><a href="<?php echo base_url("member/activities")?>">Activities/Exercise</a></li>
                        <li class="<?php if($ctrl=="member" && $action=="pet"){echo "active";}?>"><a href="<?php echo base_url("member/pet")?>">Pets</a></li>
                        <li class="<?php if($ctrl=="member" && $action=="zodiac"){echo "active";}?>"><a href="<?php echo base_url("member/zodiac")?>">Zodiac </a></li>
                        <li class="<?php if($ctrl=="member" && $action=="politics"){echo "active";}?>"><a href="<?php echo base_url("member/politics")?>">Politics</a></li>
                        <li class="<?php if($ctrl=="member" && $action=="vacation"){echo "active";}?>"><a href="<?php echo base_url("member/vacation")?>">Vacation</a></li>
                        
                        <li class="<?php if($ctrl=="member" && $action=="upload_image"){echo "active";}?>"><a href="<?php echo base_url('member/upload_image') ?>">Upload</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#interests"> Interest</a></li>
                        
                    </ul>
                </li>
                <li class="<?php if($ctrl=="member" && $action=="profile"){echo "active";}?>"><a href="<?php echo $profile_link;?>"> Profile</a></li>                
                <li class="<?php 
					$data = $ctrl=="member" && $action=="counselor";
					$data1 = $ctrl=="counselor" && $action=="profile";
					if($data || $data1)
					{echo "active";}?>">
				<a href="<?php echo base_url('member/counselor') ?>"> Counseling</a></li>
                <!--<li ><a href="#"> Chat/Message</a></li>-->
                <li class="<?php if($ctrl=="member" && $action=="membershipplan"){echo "active";}?>"><a href="<?php echo base_url('member/membershipplan') ?>"> Membership </a></li>
                <!--<li><a href="#"> My Contact</a></li>-->
                <!--<li class="<?php if($ctrl=="member" && $action=="search"){echo "active";}?>"><a href="<?php echo base_url('member/search') ?>"> Search</a></li>-->
                
                <li class="<?php $data1 = $ctrl=="tips" && $action==""; $data = $ctrl=="tips" && $action=="viewdetails"; if($data1 || $data){echo "active";}?>"><a href="<?php echo base_url('tips/index/0/1') ?>"> Tips </a></li>
                <li><a href="<?= base_url('member/favourite')?>"> Hearted</a></li>
                <li class="<?php if($ctrl=="member" && $action=="mymatch" && $para1==""){echo "active";}?>"><a href="<?php echo base_url('member/mymatch') ?>"> My Matches</a></li>
                <li class="<?php if($ctrl=="member" && $action=="mymatch" && $para1=="paid"){echo "active";}?>"><a href="<?php echo base_url('member/mymatch/paid') ?>"> paid Member</a></li>
				<li class="<?php if($ctrl=="member" && $action=="dailyMatches"){echo "active";}?>"><a href="<?php echo base_url('member/dailyMatches') ?>"> Daily Matches</a></li>
				<li class="<?php if($ctrl=="member" && $action=="block_member_list"){echo "active";}?>"><a href="<?php echo base_url('member/block_member_list') ?>">Block Member </a></li>
				
				<!--<li class="<?php if($ctrl=="member" && $action=="upload_image"){echo "active";}?>"><a href="<?php echo base_url('member/upload_image') ?>">Upload Image </a></li>-->
			    <li class="<?php if($ctrl=="member" && $action=="booking_notification"){echo "active";}?>"><a href="<?php echo base_url('member/booking_notification') ?>">My Booking </a></li>
				<li class="<?php if($ctrl=="notification" && $action=="index"){echo "active";}?>"><a href="<?php echo base_url('notification/index/0/1') ?>">All Notification </a></li>
				<li class="<?php if($ctrl=="member" && $action=="change_password"){echo "active";}?>"><a href="<?php echo base_url('member/change_password') ?>"> Change Password </a></li>
				
				<li class="<?php if($ctrl=="member" && $action=="accountdeactive"){echo "active";}?>"><a href="<?php echo base_url('member/accountdeactive') ?>"> Deactive Account </a></li>
				
                <li><a href="<?php echo base_url('logout') ?>"> Logout</a></li>
            </ul>
        </div>
    </div>
</div>