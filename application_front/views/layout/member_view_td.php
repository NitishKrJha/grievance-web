<div class="top-section">
    <?php $memberData  = $this->ModelMember->getMemberData($memberId); ?>
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
                <?php
                    $piccs=($memberData['crop_profile_image']!='')?$memberData['crop_profile_image']:$memberData['picture'];
                ?>
                <?php if($piccs==''){ ?>
                    <img src="<?php echo CSS_IMAGES_JS_BASE_URL ?>images/noImage.png" alt="avatar">
                <?php }else{ ?>
                    <img src="<?php echo $piccs;?>" alt="avatar">
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
                   <?php   if($profileView == 1){  if(isset($my_favrite['is_delete']) && $my_favrite['is_delete']== 1){ ?>
				  
				 <li onclick="my_favaourite(<?= $memberId ?>)"> <a href="javascript:void(0);"><i class="fa fa-heart" aria-hidden="true"></i></a></li>
				  
				  <li><a href="javascript:void(0);" class="makeCanceled" data-id="<?php echo $memberId;?>"><i class="fa fa-ban" aria-hidden="true" data-toggle="tooltip" title="Block"></i></a></li>
				  
					<?php } else { ?>
					
					  <li onclick="my_favaourite(<?= $memberId ?>)"><a href="javascript:void(0);"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li> 
					  
					   <li><a href="javascript:void(0);" class="makeCanceled" data-id="<?php echo $memberId;?>"><i class="fa fa-ban" aria-hidden="true" data-toggle="tooltip" title="Block"></i></a></li>
					  
				   <?php } }?>
                   <?php if($profileView==1){ ?>
                    <li><a href="javascript:void(0);" id="openMessageForm"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>
                    <?php } ?>
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
                        <label  class="col-sm-2 control-label"
                                  for="inputEmail3">Subject</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" 
                            id="subject" name="subject" placeholder="Enter Subject"/>
                        </div>
                      </div>
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
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
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


<div id="profile_pic_modal" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h3>Change Profile Picture</h3>
</div>
<div class="modal-body">
<form id="cropimage" method="post" enctype="multipart/form-data" action="<?php echo base_url().'member/save_img'; ?>">
<strong>Upload Image:</strong> <br><br>
<input type="file" name="profile_pic" id="profile_pic" style="display: block!important;" />
<input type="hidden" name="hdn_profile_id" id="hdn_profile_id" value="<?php echo $this->nsession->userdata('member_session_id'); ?>" />
<input type="hidden" name="hdn_x1_axis" id="hdn_x1_axis" value="" />
<input type="hidden" name="hdn_y1_axis" id="hdn_y1_axis" value="" />
<input type="hidden" name="hdn_x2_axis" value="" id="hdn_x2_axis" />
<input type="hidden" name="hdn_y2_axis" value="" id="hdn_y2_axis" />
<input type="hidden" name="hdn_thumb_width" id="hdn_thumb_width" value="" />
<input type="hidden" name="hdn_thumb_height" id="hdn_thumb_height" value="" />
<input type="hidden" name="action" value="" id="action" />
<input type="hidden" name="image_name" value="" id="image_name" />
<div id='preview_profile_pic'></div>
<div id="thumbs" style="padding:5px; width:600p"></div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" id="save_crop" class="btn btn-primary">Crop & Save</button>
</div>
</div>
</div>
</div>



<script>
//image hover 
$( '#member_profile11111111111111111111' ).mouseenter(

  function() {
	var img_path = $('#member_profile').children().attr('src');
	$('#modal_pop_image').attr('src',img_path);
	$('.modal-img').css('z-index','20');	
	$('#member_profile').css('z-index','1051');
    $('#image_modal').modal({
        show: true,
        backdrop: false
    })  

	
  }
  
);
$( '#member_profile1111111111111111111' ).mouseleave(

  function() {
	  $('#member_profile').css('z-index','');
	  $(".close").click();
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
     $('#profile_pic_modal').modal({show:true});
     //$('#imgProfileUpload').trigger('click'); 
    });

    $('#profile_pic').on('change', function() {
        $("#preview_profile_pic").html('');
        $("#preview_profile_pic").html('Uploading....');
        $("#cropimage").ajaxForm({
            target: '#preview_profile_pic',
            success: function() {
            $('img#photo').imgAreaSelect({
                aspectRatio: '1:1',
                onSelectEnd: getSizes,
            });
            $('#image_name').val($('#photo').attr('file_name'));
            }
        }).submit();
    });

    $('#save_crop').on('click', function(e){
    e.preventDefault();
    params = {
    targetUrl: '<?php echo base_url('member/saveProfilePic/save'); ?>',
    action: 'save',
    x_axis: $('#hdn_x1_axis').val(),
    y_axis : $('#hdn_y1_axis').val(),
    x2_axis: $('#hdn_x2_axis').val(),
    y2_axis : $('#hdn_y2_axis').val(),
    thumb_width : $('#hdn_thumb_width').val(),
    thumb_height:$('#hdn_thumb_height').val()
    };
    saveCropImage(params);
    });
    function getSizes(img, obj){
        var x_axis = obj.x1;
        var x2_axis = obj.x2;
        var y_axis = obj.y1;
        var y2_axis = obj.y2;
        var thumb_width = obj.width;
        var thumb_height = obj.height;
        if(thumb_width > 0) {
            jQuery('#hdn-x1-axis').val(x_axis);
            jQuery('#hdn-y1-axis').val(y_axis);
            jQuery('#hdn-x2-axis').val(x2_axis);
            jQuery('#hdn-y2-axis').val(y2_axis);
            jQuery('#hdn-thumb-width').val(thumb_width);
            jQuery('#hdn-thumb-height').val(thumb_height);
        } else {
            alert("Please select portion..!");
        }
    }
    function saveCropImage(params) {
    $.ajax({
    url: params['targetUrl'],
    cache: false,
    dataType: "html",
    data: {
    action: params['action'],
    id: $('#hdn_profile_id').val(),
    t: 'ajax',
    w1:params['thumb_width'],
    x1:params['x_axis'],
    h1:params['thumb_height'],
    y1:params['y_axis'],
    x2:params['x2_axis'],
    y2:params['y2_axis'],
    image_name :$('#image_name').val()
    },
    type: 'Post',
    success: function (response) {
    $('#profile_pic_modal').modal('hide');
    $(".imgareaselect_border1,.imgareaselect_border2,.imgareaselect_border3,.imgareaselect_border4,.imgareaselect_border2,.imgareaselect_outer").css('display', 'none');
    $('#member_profile').find('img').attr('src', response);
    //$("#profile_picture").attr('src', response);
    $("#preview_profile_pic").html('');
    $("#profile_pic").val();
    },
    error: function (xhr, ajaxOptions, thrownError) {
    alert('status Code:' + xhr.status + 'Error Message :' + thrownError);
    }
    });
    }
    
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