
<style>
	#local-media.video-popup-smallBx video{
		height:100px;
	}
	#local-media.video-popup-smallBx{
		top: 200px;
		right: 0;
	}
	#remote-media video{
		width:100%;
	}
	div#remote-media{
		position: relative;
		/*bottom: 20%;
    right: 0; */
	}
	#local-media.video-popup-smallBx video {
    height: 100px;
    width: 136px;
	}
</style>

<?php
$global_facebook = $this->functions->getGlobalInfo('global_facebook_url');
$global_twitter = $this->functions->getGlobalInfo('global_twitter_url');
$global_youtube_url = $this->functions->getGlobalInfo('global_youtube_url');
$global_linkedin_url = $this->functions->getGlobalInfo('global_linkdin_url');
$global_instagram_url = $this->functions->getGlobalInfo('global_instagram_url');
?>
<!-- Modal -->
					  <div class="modal fade" id="searchpopup" role="dialog">
						<div class="modal-dialog">
						
						  <!-- Modal content-->
						  <div class="modal-content">
						  <img class="serchIcn" src="images/search-mach-icn.png" alt="">
							<div class="modal-header">
							
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title">Search for Your Matches</h4>
							</div>
							<div class="modal-body">
							<form action="<?=base_url('member/search')?>" method="post">
                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                      
                                                        <div class="form-group col-md-6">
                                                          
                                                          <select class="form-control" id="gender" name="gender">
                                                            <option value=''>Man Looking for a Woman</option>
                                                            <option value="1">Male</option>
                                                            <option value="2">Female</option>
                                                          </select>
                                                          </div>
                                                    
												<div class="form-inline text-center  col-md-6">
													<div class="form-group">
													  <label for="">Ages</label>
													  <select class="form-control" name="from_age">
													  <option value="">select</option>
													   <?php for($i=18;$i<71;$i++){?>
														<option value="<?= $i ?>"><?= $i ?></option>
														<?php }  ?>
													  </select>
													  <label class="to" for="">to</label>
													  <select class="form-control" name="to_age">
													  <option value="">select</option>
														<?php for($i=18;$i<71;$i++){?>
														<option value="<?= $i ?>"><?= $i ?></option>
														<?php }  ?>
													  </select>
													  </div>
										         </div>
                                                    </div>
                                    
                                    
                                    <div class="col-md-6 col-sm-6">
                                    
                                    	
                                    </div>
                                     <div class="col-md-12 col-sm-12">
									 <!-- country-->
									   <div class="form-group col-md-6">
                                          
                                          <select class="form-control" id="" name="country">
                                            <option value="">Country</option>
                                            <?php 
											$country = get_where('countries');
											foreach($country as $k=>$val){ ?>
											<option value="<?=$val['id']?>"><?=$val['name']?></option>
											<?php } ?>
                                          </select>
                                          </div>
										  <div class="form-group col-md-6">
                                          <input type="number" class="form-control" placeholder="pincode" name="pincode" min=0>
                                          
                                          </div>
									 </div>
									  
									 <!-- pincode -->
									 <div class="col-md-12 col-sm-12">
									 <div class="form-group col-md-6">
                                          <select class="form-control" id="language" name="language">
										   <?php $language = get_where('language',array('is_active'=>1));?>
											<option value="">Select Language</option>
											<?php foreach($language as $val){ ?>
											<option value="<?= $val['id']?>"><?= $val['name']?></option>
											<?php } ?>
										 </select>
                                       </div>
									   
										<div class="form-group col-md-6">
										   <select class="form-control" id="education" name="education">
										   <?php $education = get_where('education',array('is_active'=>1));?>
												<option value="">Select Education</option>
												<?php foreach($education as $val){ ?>
												<option value="<?= $val['id']?>" ><?= $val['name']?></option>
												
												<?php } ?>
											</select>
                                        </div>
									 </div>
									
									 <!-- kids section-->
									  <div class="col-md-12 col-sm-12">
									   <div class="form-group col-md-6">
                                          <select class="form-control valid" id="have_kids" name="have_kids" aria-required="true" aria-invalid="false">
											   <option value=""> Select Kid </option>
											   <option value="Prefer not to say" <?php if(isset($params['have_kids']) && $params['have_kids']=='Prefer not to say') echo 'selected';?>>Prefer not to say</option>
											   <option value="No kids" <?php if(isset($params['have_kids']) && $params['have_kids']=='No kids') echo 'selected';?>>No kids</option>
											   <option value="1" <?php if(isset($params['have_kids']) && $params['have_kids']=='1') echo 'selected';?>>1</option>
											   <option value="2" <?php if(isset($params['have_kids']) && $params['have_kids']=='2') echo 'selected';?>>2</option>
											   <option value="3" <?php if(isset($params['have_kids']) && $params['have_kids']=='3') echo 'selected';?>>3</option>
											   <option value="4" <?php if(isset($params['have_kids']) && $params['have_kids']=='4') echo 'selected';?>>4</option>
											   <option value="5" <?php if(isset($params['have_kids']) && $params['have_kids']=='5') echo 'selected';?>>5</option>
											   <option value="5+" <?php if(isset($params['have_kids']) && $params['have_kids']=='5+') echo 'selected';?>>5+</option>
										  </select>
                                       </div>
									    <div class="form-group col-md-6">
											<select class="form-control" id="smoking" name="smoking">
											<option value="">Select Smoker</option>
											<option value="1" <?php if(isset($params['smoking']) && $params['smoking']=='1') echo 'selected';?>> Non-Smoker </option>
											<option value="2" <?php if(isset($params['smoking']) && $params['smoking']=='2') echo 'selected';?>> Light-Smoker </option>
											<option value="3" <?php if(isset($params['smoking']) && $params['smoking']=='3') echo 'selected';?>> Heavy-Smoker </option>
											</select>
										</div>
									 </div>
									 
									 <!-- drink -->
									 <div class="col-md-12 col-sm-12">
									  <div class="form-group col-md-6">
										<select class="form-control" id="drinking" name="drinking">
										<option value="">Select Drinker</option>
										<option value="1" <?php if(isset($params['drinking']) && $params['drinking']=='1') echo 'selected';?>>Non-Drinker</option>
										<option value="2" <?php if(isset($params['drinking']) && $params['drinking']=='2') echo 'selected';?>>Social-Drinker</option>
										<option value="3" <?php if(isset($params['drinking']) && $params['drinking']=='3') echo 'selected';?>>Heavy-Drinker</option>
										</select>
									 </div>
									 <div class="form-group col-md-6">
                                          <input type="text" class="form-control" placeholder="height" name="height">
                                          
                                        </div>
									 </div>
									 <!-- body style-->
									 <div class="col-md-12 col-sm-12">
									  <div class="form-group col-md-6">
										<select class="form-control valid" id="body_type" name="body_type" aria-required="true" aria-invalid="false">
										<?php $body_type = get_where('body_type',array('is_active'=>1));?>
											  <option value="">Select Body Type</option>
											  <?php foreach($body_type as $val){ ?>
											  <option value="<?= $val['id']?>" ><?= $val['type']?></option>
											 <?php } ?> 
										</select>
									</div>
									 <div class="form-group col-md-6">
                                          <select class="form-control valid" id="eye" name="eye" aria-required="true" aria-invalid="false">
										  <?php $eye_type = get_where('eye_type',array('is_active'=>1));?>
											<option value="">Select Eye Type</option>
											<?php foreach($eye_type as $val){?>
											<option value="<?=$val['id']?>" ><?= $val['type'] ?></option>
											<?php } ?>
										 </select>
                                          
                                      </div>
									 </div>
									 <div class="col-md-12 col-sm-12">
										  <div class="form-group col-md-6">
											 <select class="form-control valid" id="hair" name="hair" aria-required="true" aria-invalid="false">
												<?php $hair_type = get_where('hair_type',array('is_active'=>1)); ?>
												<option value=""> Select Hair Type </option>
												<?php foreach($hair_type as $val){ ?>
												<option value="<?=$val['id']?>" ><?=$val['type']?></option>
												<?php } ?>
											</select>
										</div>
									 </div>
									 <!-- -->
                                    <div class="col-md-12 col-sm-12">
                                    	         
                                     	<!--<span class="checkboxSec">
                                        	<ul class="unstyled ">
                                              <li>
                                                <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
                                                <label for="styled-checkbox-1">Online</label>
                                              </li>
                                              <li>
                                                <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="value1">
                                                <label for="styled-checkbox-2">Available for Video Chat</label>
                                              </li>
                                              </ul>
                                        </span>-->
                                        <div class="col-md-12 text-left advanceSearch">
                                        	<!-- <span><a href="#">Advance Search</a></span> -->
                                        	<button type="submit" class="showTipsBtn">Show Matches</button>
											
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    
                                </div>
								</form>
							</div>
						   
						  </div>
						  
						</div>
					  </div>
					  
					  
						<div class="chat-window" style="display:none;">
            <div class="top-chat-section">
              <div class="leftSec"> <span><img src="" class="chatWithImg" alt=""></span> <strong class="chatWithName"></strong> </div>
              <div class="rightSec"> <a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a> <a href="javascript:void(0);" class="hideParent"><i class="fa fa-times" aria-hidden="true"></i></a> </div>
            </div>
            <div class="scrollbar-outer">
            <ul class="inner-chat-section inner-content">
              <li> <span class="image"> <img src="images/chat-w1.jpg" class="" alt=""> </span> <span class="time">12:38</span>
                <div class="text left"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore </div>
              </li>
              <li class="rightChrt"> <span class="image"> <img src="images/chat-w2.jpg" class="" alt=""> </span> <span class="time">12:42</span>
                <div class="text left"> Lorem ipsum dolor sit amet, </div>
              </li>
              <li> <span class="image"> <img src="images/chat-w1.jpg" class="" alt=""> </span> <span class="time">12:46</span>
                <div class="text left"> Lorem ipsum dolor sit amet </div>
              </li>
              <li class="rightChrt"> <span class="image"> <img src="images/chat-w2.jpg" class="" alt=""> </span> <span class="time">12:42</span>
                <div class="text left"> Lorem ipsum dolor sit amet, </div>
              </li>
              <li> <span class="image"> <img src="images/chat-w1.jpg" class="" alt=""> </span> <span class="time">12:46</span>
                <div class="text left"> Lorem ipsum dolor sit amet </div>
              </li>
              <li class="rightChrt"> <span class="image"> <img src="images/chat-w2.jpg" class="" alt=""> </span> <span class="time">12:42</span>
                <div class="text left"> Lorem ipsum dolor sit amet, </div>
              </li>
              <li> <span class="image"> <img src="images/chat-w1.jpg" class="" alt=""> </span> <span class="time">12:46</span>
                <div class="text left"> Lorem ipsum dolor sit amet </div>
              </li>
              <li class="rightChrt"> <span class="image"> <img src="images/chat-w2.jpg" class="" alt=""> </span> <span class="time">12:42</span>
                <div class="text left"> Lorem ipsum dolor sit amet, </div>
              </li>
            </ul>
            </div>
            <div class="typeYourMesg"> <!--<a href="#"><i class="material-icons">attach_file</i></a>-->
							<input type="text" class="form-control messageToSend" placeholder="Type your message..." >
							<div style="display:none;" useridentifier="" class="useridentifier"></div>
              <a href="#"><i class="fa fa-smile-o" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-paper-plane" aria-hidden="true"></i></a> </div>
          </div>
          <!--chat-window--> 
			
					  
					<div id="videoChat" class="modal fade in" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Video Chat</h4>
      </div>
      <div class="modal-body">
      
        <div class="video-popup-leftBx"><!-- Left Video Box-->
        	
						<div id="remote-media">
            
            <div class="video-popup-smallBx" id="local-media"><!-- Left Video Box-->
            </div>
        </div>
        
        
        
			</div>
												</div>
      <div class="clearfix"></div>	
      <div class="modal-footer" style="text-align:center;">
				<button type="button" class="btn showTipsBtn btn-success acceptCall" id="acceptCall">Accept</button>
				<button type="button" class="btn showTipsBtn btn-danger rejectCall" id="rejectCall">Reject</button>
      </div>
												</div>
  </div>
</div>				  
					  
					  <!-- Modal -->
<footer class="footer_main">
    <div class="container">
        <ul class="share_wrap">
            <li><a target="_blank" href="<?php echo $global_facebook; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a target="_blank" href="<?php echo $global_twitter; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a target="_blank" href="<?php echo $global_youtube_url; ?>"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
            <li><a target="_blank" href="<?php echo $global_linkedin_url; ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
            <li><a target="_blank" href="<?php echo $global_instagram_url; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
        </ul>
        <ul class="f-nav">
            <li><a href="<?php echo base_url('about');?>">About</a></li>
            <li><a href="<?php echo base_url('terms-conditions');?>">Terms & Conditions </a></li>
            <li><a href="<?php echo base_url('privacy-policy');?>">Privacy Policy</a></li>
            <li><a href="<?php echo base_url('dating-securely');?>">Dating Securely</a></li>
            <li><a href="<?php echo base_url('dating-disclaimer');?>">Dating Disclaimer</a></li>
            <li><a href="<?php echo base_url('page/contact_us');?>"> Contact Us</a></li>
            <li><a href="<?php echo base_url('help-center');?>"> Help Center</a></li>
        </ul>
        <p class="copyright">&copy; <?php echo date('Y'); ?> All Rights Reserved. <a href="https://www.mymissingrib.com" rel="nofollow" target="_blank"> Mymissingrib </a></p>
    </div>
</footer>
<script>
	window.host = '<?php echo base_url();?>';
	window.loginas = '<?php echo 'member_'.$this->nsession->userdata("member_session_id");?>';
</script>
<script src="https://media.twiliocdn.com/sdk/js/chat/releases/1.2.1/twilio-chat.js"></script>
<script src="//media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
<script src="//media.twiliocdn.com/sdk/js/video/releases/1.0.0/twilio-video.js"></script>
<script src="https://media.twiliocdn.com/sdk/js/conversations/v0.13/twilio-conversations.min.js"></script>
<script src="//media.twiliocdn.com/sdk/conversations/v0.7/js/releases/0.7.1.b1-7238b35/twilio-conversations-loader.min.js"></script>
<script type="text/javascript" src="https://requirejs.org/docs/release/2.2.0/minified/require.js"></script>
<script src="<?php echo base_url();?>public/js/chat/index.js"></script>
<script src="<?php echo base_url();?>public/js/videochat/quickstart.js"></script>
<script>
	$(function(){
		$(".chat-window").css({'display':'none'});
	})
	$(document).on('click',".hideParent",function(){
		$(this).parent().parent().parent().hide();
	})
	$(document).on('click',".openChatBox",function(){
		//alert($(this).parent().parent().find("figure img").attr('src'));
		$(".chatWithName").html($(this).parent().find(".chatName").text());
		$(".chatWithImg").attr('src',$(this).parent().parent().find("figure img").attr('src'));
		$(".chat-window").show();
		$(".useridentifier").attr('useridentifier',$(this).attr('identifier'));		
		$(".useridentifier").addClass('chatwindowfor_'+$(this).attr('identifier'));
		var userid = '<?php echo $this->nsession->userdata("member_session_id");?>';
		if(userid > $(this).attr('identifier')){
			var roomName = userid+'_'+$(this).attr('identifier');
		}else{
			var roomName = $(this).attr('identifier')+'_'+userid;
		}
		window.me = 'member_<?php echo $this->nsession->userdata("member_session_id");?>';
		$(".inner-chat-section").html('<li style="margin-bottom: 20px; position:absolute;width: 120px;height: 156px;left: 0;right: 0;margin: auto;top: 0;bottom: 0;"><img style="width: 126px;" src="<?php echo base_url();?>public/images/loading.gif"></li>').addClass('inner-chat-section'+roomName);
		functionCall(roomName,'member_<?php echo $this->nsession->userdata("member_session_id");?>');
	})

	$(document).on('click',".openVideoBox",function(){
		$("#videoChat").modal('show');
		var imgUrl = $(this).parent().parent().find('figure img').attr('src');
		callUser('room_member_'+$(this).attr('identifier'),imgUrl,$(this).parent().find(".chatName").text());
	})
</script>
