 <section class="main-container">
    <div class="container-fluid">
      <div class="row">
         <?php echo $this->load->view('layout/counselorLeftMenu') ?>
        <div class="col-md-7">
          <div class="top-section top-section-counselor">
            <div class="dashboard-header" style="background-image: url(<?php echo CSS_IMAGES_JS_BASE_URL;?>images/dashboard-header2.jpg);">
              <div class="profile-info">
			  
			  <?php //foreach($memberData as $details)
			   //pr($details);
			   $pic=$memberData['picture'];
         if($memberData['picture']==''){
          $pic=css_images_js_base_url().'images/images.png';
         }
			  ?>
			  <?php //echo $memberData; die;?>
			  
                <div class="profile-photo"> <img src="<?php echo $pic;?>" alt="avatar"> </a> </div>
                <div class="profile-des">
                  <h5> <?php echo $memberData['name'];?> <span class="online-status active"></span></h5>
                  <p> <?php echo $memberData['profile_heading'];?> </p>
                </div>
              </div>
              <div class="profile-status">
			  
			  
                <div class="action_wrap"> <!--<a class="bookNwBtnMain" data-toggle="modal" data-target="#booknow" href="#"> <i class="fa fa-calendar" aria-hidden="true"></i> Book Now </a>-->
				
                  <!-- Modal -->
                  <div class="modal fade" id="booknow" role="dialog">
                    <div class="modal-dialog"> 
                      
                      <!-- Modal content-->
                      <div class="modal-content"> <img class="serchIcn" src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/NoImage.pngg" alt="">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Book A Counselor</h4>
                        </div>
                        <div class="modal-body">
                          <ul>
                            <li>
                              <input type="text" class="form-control customFormcontrol" placeholder="Choose start date and time">
                              <span class="custmIcn"> <i class="fa fa-calendar" aria-hidden="true"></i> </span> </li>
                            <li>
                              <input type="text" class="form-control customFormcontrol" placeholder="Choose start date and time">
                              <span class="custmIcn"> <i class="fa fa-calendar" aria-hidden="true"></i> </span> </li>
                          </ul>
                          <a class="showTipsBtn" href="#">Book Now</a> </div>
                      </div>
                    </div>
                  </div>
                  <!-- Modal -->
                 <!-- <ul>
                    <li><a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i></a></li>
                    <li><a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i></a></li>
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
                          <div class="col-md-6 col-xs-6 col-sm-4 " ><img class="img-responsive certificate-img" src="<?php echo $certificateImage['certificate']; ?>" alt=""></div>				  
        				<?php } ?>
				  
                </div>
              </div>
            </div>
          </div>
        </div>
		
		
        <div class="col-md-3 col-sm-6 rightSideBar">
    
      <?php echo $this->load->view('layout/counselorMyContact')?>   
      <?php //echo $this->load->view('layout/counselorChatRequest')?>
            
        </div>
        <div class="col-md-3 col-sm-6">
    
      <?php echo $this->load->view('layout/counselorChatRequest')?>
      
        </div>
		
		
        <div class="col-md-3 col-sm-6">
          
        </div>
      </div>
    </div>
  </section>

  <script>
      $('.certificate-img').hover(

		  function() {
			var img_path = $(this).attr('src');
			 $('.modal-img').css('z-index','1');	
	        $('.certificate-img').parent().css('z-index','20');
			$('#modal_pop_image').attr('src',img_path);
			
			$('#image_modal').modal({
				show: true,
				backdrop: false 
			})   

			//alert(1);
		  }
		  
		);
		// $( '.certificate-img' ).mouseleave(

		//   function() {
		// 	  $(".close").click();
		//   }
		  
		// );
  </script>
  <div id="chatAppend"></div>