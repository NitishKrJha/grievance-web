
<link href="<?php echo CSS_IMAGES_JS_BASE_URL;?>/css/jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jcrop/jquery.Jcrop.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jcrop/script.js" type="text/javascript" charset="utf-8"></script>
<div class="top-section">

    <?php
     $mmid=($this->nsession->userdata('member_session_id'))?$this->nsession->userdata('member_session_id'):0;
     $exp_date='';
     if($mmid > 0){
        $membership_paln = get_where('member_buyed_plan',array('member_id'=>$mmid,'is_active'=>1));
        $my_memberData     = $this->ModelMember->getMemberData($mmid);
        $exp_date = isset($membership_paln[0]['expiry_date'])?$membership_paln[0]['expiry_date']:'';
     }
     $memberData  = $this->ModelMember->getMemberData($memberId); ?>
    <?php if($memberData['cover_image']==''){ ?>
        <div class="dashboard-header" style="background-image: url(<?php echo CSS_IMAGES_JS_BASE_URL; ?>images/dashboard-header.jpg);">
   <?php }else{ ?>
        <div class="dashboard-header" style="background-image: url(<?php echo $memberData['cover_image']; ?>);">
    <?php } ?>
        <?php if($profileView==0){ ?>
            <div class="pull-right visible-xs">
                <p class="cover-txt"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal"><span style="color:red">Change Cover Image</span></a></p>
            </div>
        <?php } ?>
        <div class="profile-info">
            <div class="profile-photo" id="member_profile">
                <?php if($memberData['picture']==''){
                    $pic=CSS_IMAGES_JS_BASE_URL."images/noImage.png";
                 ?>
                    <img src="<?php echo CSS_IMAGES_JS_BASE_URL ?>images/noImage.png" alt="avatar">
                <?php }else{
                    $pic=$memberData['picture'];
                 ?>
                    <img src="<?php echo $memberData['picture'];?>" alt="avatar">
                <?php } ?>
                <?php if($profileView==0){ ?>
                    <span class="edit-icon" id="profileImgUpload" data-toggle="tooltip" title="Change Profile Image"><i class="fa fa-camera" aria-hidden="true"></i></span>
                <?php } ?>
            </div>
            <div class="profile-des">
                <h5><?php echo $memberData['name']?> <?php if($memberData['online_status'] == 1){ ?> <span class="online-status active"></span> <?php } else { ?> <span class="online-status"></span> <?php } ?></h5>
                <p><?php echo $memberData['profile_heading']!=''?$memberData['profile_heading']:'';?></p>
            </div>
        </div>
        
        <div class="profile-status">
            <?php if($profileView==0){ ?>
            <p class="hidden-xs"><a href="javascript:void(0)" id="coverImgUpload">Change Cover Image</a></p>
            <?php } ?>
            <div class="action_wrap">
                <ul>
                   <li><a href="<?php echo base_url('login'); ?>"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li> 
            
                  <li><a href="<?php echo base_url('login'); ?>"><i class="fa fa-ban" aria-hidden="true" data-toggle="tooltip" title="Block"></i></a></li>
                  <li><a href="<?php echo base_url('login'); ?>"><i class="fa fa-video-camera" aria-hidden="true"></i> </a></li>
                       
                  <li><a href="<?php echo base_url('login'); ?>"><i class="fa fa-comment-o" aria-hidden="true"></i> </a></li>
                </ul>
            </div>
        </div>
        
    </div>
</div>
<form id="coverImgForm" action="<?php echo base_url('member/ChangeCoverImg'); ?>" method="post" enctype="multipart/form-data">
    <input type="file" id="imgCoverUpload" name="coverImg" accept="image/*"/>
    <input type="submit" name="Upload" style="display: none" />
</form>
<form id="profileImgForm" action="<?php echo base_url('member/ChangeProfileImg'); ?>" method="post" enctype="multipart/form-data">
    <input type="file" id="imgProfileUpload" name="profileImg" accept="image/*" />
    <input type="submit" name="Upload" style="display: none" />
</form>


<div class="modal fade" id="myContactForm" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Send Message
                </h4>
            </div>
            <form class="form-horizontal" role="form" name="messageForm" id="messageForm" method="post" action="">
            <!-- Modal Body -->
            <div class="modal-body">
                
                
              <div class="form-group">
                <label class="col-sm-2 control-label"
                      for="inputPassword3" >Message</label>
                <div class="col-sm-10">
                    <textarea name="message" id="message" class="form-control"></textarea>
                </div>
              </div>
              <input type="hidden" name="to_member" id="to_member" value="">
                
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                </button>
                <button type="submit" id="submit" class="btn btn-primary">
                    Send
                </button>
            </div>

            </form>

        </div>
    </div>
</div>

<!-- The Modal -->
  <div class="modal" id="profileImageChangeModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Upload Profile Image</h4>
          <button type="button" class="close" onclick="window.location.reload();">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
           <form id="upload_form" enctype="multipart/form-data" method="post" action="<?= base_url('member/ChangeProfileImgWithResizeCrop')?>" onsubmit="return checkForm()">
                    <!-- hidden crop params -->
                    <input type="hidden" id="x1" name="x1" />
                    <input type="hidden" id="y1" name="y1" />
                    <input type="hidden" id="x2" name="x2" />
                    <input type="hidden" id="y2" name="y2" />

                    <!--<h2>Step1: Please select image file</h2>-->
                    <div class="loadFile">
                    	<div class="btn btn-small download-upload">
                        <span><i class="fa fa-upload" aria-hidden="true"></i> File</span>
                            <input style="display:block;" type="file" name="image_file" id="image_file" onchange="fileSelectHandler()" accept="image/*" />
                        </div>
                    </div>

                    <div class="error"></div>

                    <div class="step2">
                        <!--<h2>Step2: Please select a crop region</h2>-->
                        <div id="preview_data"><img id="preview" /></div>
                        

                        <div class="info">
                            <input type="hidden" id="filesize" name="filesize" />
                             <input type="hidden" id="filetype" name="filetype" />
                             <input type="hidden" id="filedim" name="filedim" />
                             <input type="hidden" id="w" name="w" />
                             <input type="hidden" id="h" name="h" />
                        </div>

                        <div class="uploadOtr"><input type="submit" value="Upload" class="uploadBtn" /></div>
                    </div>
                </form>
        </div>
    
        
      </div>
    </div>
  </div>

<script>
//image hover 

 
$( '#member_profile1111111' ).mouseenter(

  function() {
  	var img_path = $('#member_profile').children().attr('src');
  	$('#modal_pop_image').attr('src',img_path);
  	$('.modal-img').css('z-index','20');	
  	$('#member_profile').css('z-index','1051');
      $('#image_modal').modal({
          show: true
      })  

	
  }
  
);
$( '#member_profile' ).mouseleave(

  function() {
	  //$('#member_profile').css('z-index','0');
	  //$('#image_modal').modal('hide');
    //$(".close").click();
  }
  
);
//image hover
    function my_favaourite(member_id)
	{
		$.ajax({
			
			url:'<?= base_url('member/my_favaourite')?>',
			method:'POST',
			data:{'member_id':member_id},
			type:'json',
			success:function(data){
				window.location.reload();
			}
			
		})
	}
	
    $("#imgCoverUpload").change(function() {
        var val = $(this).val();
        switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
            case 'gif': case 'jpg': case 'png': case 'jpeg':
            $("#coverImgForm")[0].submit();
            break;
            default:
                $(this).val('');
                alert("Please Upload Valid Image.");
                break;
        }
    });
    $('#coverImgUpload').click(function(){ $('#imgCoverUpload').trigger('click'); });
    
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
    $('#profileImgUpload').click(function(){ 
	    //$('#imgProfileUpload').trigger('click'); 
      $('#preview').remove();
    $('#preview_data').html('<img id="preview">');
    $('#x1').val('');
    $('#y1').val('');
    $('#x2').val('');
    $('#y2').val('');
    $('#w').val('');
    $('#h').val('');
    $('.error').html('');
		$('#profileImageChangeModal').modal({
								   show: true,
								   backdrop: false
								});
	});
    
    $(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});
	
	
$(document).on('click','.makeCanceled',function(){
	var $this=$(this);
	var id=$this.data('id');
	//alert(id);
	if(id==''){
		return false;
	}
	var url='<?php echo base_url(); ?>member/blockmember/'+id;
	
	if(window.confirm("Are you sure to block this member ?"))
	{
		  //window.location.href = url;
		  window.location.href = url;
		 //window.location.reload();
		 //alert(1);
	} 
 });
	//video popup
function show_modal_video(obj)
{
	$('#my_video').css('z-index','99999999!important');
	
	src = $(obj).children().attr('src');
	$('#pop_video').attr("src",src);
	$('.video_div').load();
	$('#pop_video_modal').modal({
       show: true,
        backdrop: false
    })  
   
}


</script>