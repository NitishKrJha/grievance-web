 
 <style>
 input[type="file"] {
    display: block;
    width: 150px;
    height: 150px;
    display: block;
}
 </style>
 
 <section class="main-container">
    <div class="container-fluid">
      <div class="row">
         <?php echo $this->load->view('layout/counselorLeftMenu') ?>
        <div class="col-md-7">
         
		  
          <div class="btm-section counselorSec ">
		  
		  
           <div class="row">
                  <div class="machMakingform" id="machMakingform">
                    <div class=" item" id="step1"><!--step one-->
                    <h2> Edit Profile </h2>
                      <form action="<?php echo base_url('counselor/do_addedit') ?>" method="post" id="appearanceForm" enctype="multipart/form-data">
                      <div class="row">
					  
					  <div class="col-md-12">
                          <div class="form-group">
                            <label for="comment"> Name </label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" value="<?php echo isset($memberData['name'])?$memberData['name']:'';?>">
                          </div>
                        </div>
					  
						<div class="col-md-12">
                          <div class="form-group">
                            <label for="usr">Profile Heading</label>
                            <input type="text" id="profile_heading" name="profile_heading" class="form-control" placeholder="Enter your name" value="<?php echo isset($memberData['profile_heading'])?$memberData['profile_heading']:'';?>">
                          </div>
                        </div>
					  
					  
                        <div class="col-md-12">
                            <div class="form-group"> <!--<span class="minChar">Min 200 chars</span>-->
                              <label for="comment">About Me</label>
                              <textarea class="form-control" rows="4" id="about_me" name="about_me" placeholder="Type here"><?php echo isset($memberData['about_me'])?$memberData['about_me']:''; ?></textarea>
                            </div>
                        </div>
						
						<div class="col-md-11">
                          <div class="form-group customfile">
                            <label for="usr"> Certificate </label>
                           <input class="form-control" type="file" name="certificate[]" <?php if($certificate){ echo ''; }else{ echo"required";}?> accept=".png,.jpeg,.jpg" value="<?php echo $certificate[0]['certificateDetails']?>"> 		  
						  </div>						 
                        </div>
					  <span class="clickAddMoreCertificate"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
					 
					<?php foreach($certificate as $certificateDetails){?>
			
						<img src="<?php echo $certificateDetails['certificate']; ?>"  height="50" width="100"><a href="<?php echo base_url('counselor/delete_certificate/'.$certificateDetails['id'].'/'.$id)?>" title="Delete" onclick="deleteblog()"><i class="fa fa-trash" aria-hidden="true"></i></a> &nbsp;
						
					<?php }?>
					 
					 
					 
						<div class="addMoreCertificate">

						</div>
					 
					 

					 </div>
						<!--<div class="row">                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr"> Profile pic </label>
                           <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" value="<?php echo isset($memberData['profile_heading'])?$memberData['profile_heading']:'';?>">
                          </div>
                        </div>
                       
                      </div>-->
					  
					  
                    </div>
                <div class="nextPrvsSec">
                	<!-- <a class="showTipsBtn pull-right" href="match-making-step2.html#step2" >Continue</a> -->
                <input type="submit" class="btn-cmn" value="Submit">
                </div>
                  </form>  
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
      </div>
    </div>
  </section>
  <div class="chat-window" style="display:none;">
    <div class="top-chat-section">
      <div class="leftSec"> <span><img src="" class="chatWithImg" alt=""></span> <strong class="chatWithName"></strong> </div>
      <div class="rightSec" id="closeBTNs"> <a href="javascript:void(0);" class="hideParent"><i class="fa fa-times" aria-hidden="true"></i></a> </div>
    </div>
    <div class="scrollbar-outer" id="chatboxcontentDataAccess">
      <ul class="inner-chat-section inner-content chatboxcontent">
              
              
      </ul>
    </div>
  <div class="typeYourMesg"> <!--<a href="#"><i class="material-icons">attach_file</i></a>-->
    
    <div id="addLBTN">
        
    </div>
    
  </div>
</div>
  <script>
	$(document).on('click','.clickAddMoreCertificate',function(){
    $(".addMoreCertificate").append($("#cerifdateData").html());
	});
	
	$(document).on('click','.removeMoreCertificate',function(){
    $(this).parent().remove();
	})
	
  </script>
  
  <script type="text/javascript" id="cerifdateData">
   <div class="col-md-11">
	  <div class="form-group customfile">
		<label for="usr"> Certificate </label>
	   <input class="form-control" type="file" name="certificate[]" <?php if($certificate){ echo ''; }else{ echo"required";}?> accept=".png,.jpeg,.jpg" value="<?php echo $certificate[0]['certificateDetails']?>"> 		  
	  </div>						 
	<span class="removeMoreCertificate"><i class="fa fa-minus-square" aria-hidden="true"></i></span>
	
	</div>
	
	
</script>