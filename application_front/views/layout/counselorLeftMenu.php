<?php
$ctrl       = $this->uri->segment(1);
$action     = $this->uri->segment(2);
 $pic=$memberData['picture'];
 if($memberData['picture']==''){
  $pic=css_images_js_base_url().'images/images.png';
 }
?>
<div class="col-md-2">
    <div class="profile-info  counselor-profile-info">
        <div class="profile-photo" id="cn_profile_photo" data-toggle="modal">
            <img src="<?php echo $pic;?>" alt="avatar">
            <span class="edit-icon"  id="profileImgUpload"><i class="fa fa-camera" aria-hidden="true"> </i></span>
        </div>
        <div class="profile-des">
            <h5> <?php echo $memberData['name'];?> <span class="online-status active"></span></h5>
            <p><?php echo $memberData['profile_heading'];?>
            </p>
        </div>
        <div class="action_wrap">
            <button type="button" class="btn editPrfl " data-toggle="modal" data-target="#searchpopupjbb">
                <a href="<?php echo base_url('counselor/editProfile') ?>"><i class="fa fa-pencil" aria-hidden="true"></i>Edit profile</a></button>
        </div>
    </div>
    <div class="dashboard-nav">
        <div class="dashboard-list">
            <ul id="left_menu">
                <li class="<?php if($ctrl=='counselor' && $action=='dashboard') {  echo "active"; }?>"><a href="<?php echo base_url('counselor/dashboard') ?>"> About Me</a></li>
                <!--<li ><a href="<?php echo base_url('counselor/dashboard') ?>"> Counselling Request</a></li>-->
               
               <!-- <li><a href="<?php echo base_url('counselor/dashboard') ?>">Upcoming Conferences</a></li>-->
               <!-- <li><a href="<?php echo base_url('counselor/dashboard') ?>">Past Conferences</a></li>-->
                <li><a href="<?php echo base_url('counselor/appointment') ?>">Calendar for Appointment</a></li>
				
                <li><a class="<?php if($ctrl=='counselor' && $action=='avalablity') {  echo "active"; }?>" href="<?php echo base_url('counselor/avalablity') ?>">Set Avalablity</a></li>
                <li><a class="<?php if($ctrl=='counselor' && $action=='avalablity') {  echo "active"; }?>" href="<?php echo base_url('counselor/subscriber') ?>">My Contact</a></li>
				<li><a class="<?php if($ctrl=='counselor' && $action=='booked_member') {  echo "active"; }?>" href="<?php echo base_url('counselor/booked_member'); ?>">Booking Notification</a></li>
                <li class="<?php if($ctrl=="notification" && $action=="index"){echo "active";}?>"><a href="<?php echo base_url('notification/index/0/1') ?>">All Notification </a></li>
				<li class="<?php if($ctrl=="member" && $action=="change_password"){echo "active";}?>"><a href="<?php echo base_url('counselor/change_password') ?>"> Change Password </a></li>
				
                <li><a href="<?php echo base_url('logout') ?>"> Logout</a></li>
            </ul>
        </div>
    </div>
</div>

<form id="profileImgForm" action="<?php echo base_url('counselor/ChangeProfileImg'); ?>" method="post" enctype="multipart/form-data">
    <input type="file" id="imgProfileUpload" name="profileImg" style="display: none"/>
    <input type="submit" name="Upload" style="display: none" />
</form>
<script>

$("#imgProfileUpload").change(function() {
        var val = $(this).val();
        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
            case 'gif': case 'jpg': case 'png': case 'jpeg':
            $("#profileImgForm")[0].submit();
            break;
            default:
                $(this).val('');
                alert("Please Upload Valid Image.");
                break;
        }
    });
$('#profileImgUpload').click(function(){ $('#imgProfileUpload').trigger('click'); });

$( '#cn_profile_photo' ).mouseenter(

  function() {
	var img_path = $('#cn_profile_photo').children().attr('src');
	$('#modal_pop_image').attr('src',img_path);
	$('.modal-img').css('z-index','20');	
	$('#cn_profile_photo').css('z-index','50');
    $('#image_modal').modal({
        show: true,
        backdrop: false
    })  

	
  }
  
);
$( '#cn_profile_photo' ).mouseleave(

  function() {
	  $(".close").click();
  }
  
);

</script>