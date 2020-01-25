<link href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/fullcalendar.css" rel="stylesheet" type="text/css"/>
 <section class="main-container">
    <div class="container-fluid">
      <div class="row">
	  
	 <?php //echo $memberData['member_type']; ?>
	  
	 <?php if($this->nsession->userdata('member_session_membertype')==1) {?>
		<?php $this->load->view('layout/member_left_menu')?>
	 
		<?php }else{ ?>
	  
		<?php $this->load->view('layout/counselorLeftMenu')?>
	  <?php } ?>
	       <?php //foreach($memberData as $details)
         //pr($details);
         $pic=$memberData['picture'];
         if($memberData['picture']==''){
          $pic=css_images_js_base_url().'images/images.png';
         }
        ?>
        <div class="col-md-10">
          <div class="top-section top-section-counselor">
            <div class="dashboard-header" style="background-image: url(<?php echo CSS_IMAGES_JS_BASE_URL;?>images/dashboard-header2.jpg);">
              <div class="profile-info">
			  
			  <?php //foreach($memberData as $details)
			   //pr($details);
			   
			  ?>
			  <?php //echo $memberData; die;?>
			  
                <div class="profile-photo" id="counselor_photo"> <img src="<?php echo $pic;?>" alt="avatar"> </a> </div>
                <div class="profile-des">
                  <h5> <?php echo $memberData['name'];?> <?php if($memberData['online_status']==1){ ?> <span class="online-status active"></span><?php } else { ?><span class="online-status"></span><?php } ?></h5>
                  <p> <?php echo $memberData['profile_heading'];?> </p>
                </div>
              </div>
              <div class="profile-status">
			  
                <div class="action_wrap">
        				<?php if($paidMember){ ?>
                <a class="bookNwBtnMain" href="<?php echo base_url('member/book/councellor/'.base64_encode($memberData['id'])); ?>"><i class="fa fa-calendar" aria-hidden="true"></i> Book Now</a>
                  <?php }?>
				
                 
                  <!--<ul>
                    <li><a href="javascript:void(0);" class="openChatBox" identifier="<?php echo $memberData['id'];?>">
						<i class="fa fa-comment-o" aria-hidden="true"></i> 
						</a> </li>
						
						
                    <li><a href="javascript:void(0);" class="openVideoBox" identifier="<?php echo $memberData['id'];?>"><i class="fa fa-video-camera" aria-hidden="true"></i> </a></li>
                  </ul>-->
				  
                </div>
              </div>
            </div>
          </div>
          <div class="btm-section counselorSec ">
            <div class="row">
              <div class="col-md-8">
                <h3 class="des-title cnslrPd"> About Me</h3>
                <p><?php echo $memberData['about_me'];?></p>
                <br>
              </div>
              <div class="col-md-4"> <span class="brd"></span>
                <h3 class="des-title">Certificates</h3>
                <div class="row certificates">
				<?php foreach($certificate as $certificateImage){?>
                  <div class="col-md-6 col-xs-6 col-sm-4 counselor_cerificate" ><img class="img-responsive" src="<?php echo $certificateImage['certificate']; ?>" alt=""></div>				  
				<?php } ?>
				  
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 rightSideBar">
       
          <?php //echo $this->load->view('layout/counselorMyContact')?>
          
		  <?php //echo $this->load->view('layout/counselorChatRequest')?>
		 
        </div>
        <div class="col-md-3 col-sm-6">
          
        </div>
      </div>
    </div>
  </section>

  
   <!-- Modal -->
    <div class="modal fade" id="booknowpop" role="dialog">
      <div class="modal-dialog"> 
        
        <!-- Modal content-->
        <div class="modal-content"> <img class="serchIcn" src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/NoImage.pngg" alt="">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Book A Counselor</h4>
          </div>
          <div class="modal-body">
            <form class="subscribe-frm" name="counselor_booking" a method="post" id="counselor_booking">
              <ul>
                <li>
                  <input type="text" class="form-control customFormcontrol" name="datetimepicker4" id ="datetimepicker4" placeholder="Choose start date and time">
                  <span class="custmIcn"> <i class="fa fa-calendar" aria-hidden="true"></i> </span> 
                </li> 
              </ul>
                <input type="hidden" value="<?php echo $memberData['id'];?>" name="counselor_id" id="counselor_id">
                <input type="submit" class="showTipsBtn" value="Book Now"> 
            </form>    
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
				  
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script> 				  
<script type="text/javascript">
$(function() {

  //image hover section
  
  $('#counselor_photo').mouseenter(
		  function() {
			var img_path = $('#counselor_photo').children().attr('src');
			
			$('#modal_pop_image').attr('src',img_path);
				$('.modal-img').css('z-index','20');	
				$('#counselor_photo').css('z-index','1051');
				$('#image_modal').modal({
					show: true,
					backdrop: false
				})  			
		  });
 // mouse levae		  
	$('#counselor_photo').mouseleave(
  function() {
	  $('#counselor_photo').css('z-index','');
	  $(".close").click();
  });	

// certifate section
 $('.counselor_cerificate').mouseenter(
		  function() {
			var img_path = $(this).children().attr('src');
			
			$('#modal_pop_image').attr('src',img_path);
				$('.modal-img').css('z-index','20');	
				$('.counselor_cerificate').css('z-index','1051');
				$('#image_modal').modal({
					show: true,
					backdrop: false
				})  			
		  });
	// mouse levae		  
		$('.counselor_cerificate').mouseleave(
	  function() {
		  $('.counselor_cerificate').css('z-index','');
		  $(".close").click();
	  });	
  
  //image hover section


  $("#counselor_booking").validate({
    rules: {
        datetimepicker4: {
  		  required: true
  	  }
    },
    submitHandler: function(form) {
      var data=$("form[name='counselor_booking']").serialize();
      do_subscribe(data,'Subscribe');
    }
  });
});


function do_subscribe(formData,type){
       
         var url="<?php echo base_url('counselor/booking_counselor/');?>";
       
		// var btnname='make'+type+'Register';
	   
        $.ajax({
          type:'POST',
          url: url,
          data:formData,
        
          success:function(msg){ //alert(11);
           
            var response=$.parseJSON(msg);
		
            if(response){ 
              
             $('#booknowpop').modal('toggle');
            
              /*messagealert('Success','We have sent a verification email to your mail id, please check your email to active account.','success');*/
			  window.location.reload();
            }else{
				 //$('#booknowpop').modal('toggle');
                //messagealert('Error','You are already booked','error');
				window.location.reload();
			}
          },
          error: function () {
            
            messagealert('Error','Technical issue , Please try later','error');
          }
        });
      }
	
$(function () {
  $('#datetimepicker4').datetimepicker();
});
</script>