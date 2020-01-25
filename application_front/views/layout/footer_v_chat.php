
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
		/*height: 502px;*/
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
<!--chat-window--> 
			
					  
<div id="videoChat111111" class="modal fade in" role="dialog" data-backdrop="static" data-keyboard="false">
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


<div id="videoChat" class="modal fade in" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
	<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">×</button> -->
        <h4 class="modal-title text-center">MMR Video Chat</h4>
      </div>
      <div class="modal-body">
			<div class="video_call_thumb">
				<img id="imgsrcforvid" src="https://www.mymissingrib.com//uploads//profile_pic/tmp/1532525804download_(6)_thumb.jpg" alt="" >
			</div>
			<div class="video_call_name">
				<h4></h4>
			</div>
      	<div class="video-popup-leftBx"><!-- Left Video Box-->
        	<div id="remote-media111">
            
            	<div class="video-popup-smallBx111 bxvid" id="local-media111"><!-- Left Video Box-->
				<!-- <i class="Phone is-animating"></i> -->
				<div class='phone'>
					<a href="#">
						<div class="quick-alo-ph-circle"></div>
						<div class="quick-alo-ph-circle-fill"></div>
						<div class="quick-alo-ph-img-circle"></div>
					</a>
					</div>
            	</div>
        	</div>
        </div>
	  </div>
      <div class="clearfix"></div>	
      <div class="modal-footer" style="text-align:center;">
			<button type="button" class="btn showTipsBtn btn-success acceptCall" id="acceptCall" style="display: none;">Accept</button>
			<button type="button" class="btn showTipsBtn btn-danger rejectCall" id="rejectCall">Reject</button>
      </div>
	</div>
  </div>
</div>					  
					  
<!-- Modal for image -->
<!-- Modal -->
                  <div class="modal fade modal-img" id="image_modal" role="dialog">
                    <div class="modal-dialog"> 
                      
                      <!-- Modal content-->
                      <div class="modal-content"> <img class="serchIcn" src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/NoImage.png" alt="">
                        <div class="modal-header">
                          <button type="button" class="close closedivtohid" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
						   <img src="https://www.mymissingrib.com//uploads/profile_pic/1532412342bg19.jpg" alt="avatar" id="modal_pop_image">
						  </div>
						</form>
                      </div>
                    </div>
                  </div>
       <!-- Modal -->
<!-- modal for image-->
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
<script src="//media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
<!--<script src="//media.twiliocdn.com/sdk/js/video/releases/2.0.0-beta1/twilio-video.min.js"></script>-->
<script src="//media.twiliocdn.com/sdk/js/video/releases/1.0.0/twilio-video.js"></script>
<!--<script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>-->
<script src="https://media.twiliocdn.com/sdk/js/conversations/v0.13/twilio-conversations.min.js"></script>
<script src="//media.twiliocdn.com/sdk/conversations/v0.7/js/releases/0.7.1.b1-7238b35/twilio-conversations-loader.min.js"></script>

<script src="<?php echo base_url();?>public/js/chat/index.js"></script>
<script src="<?php echo base_url();?>public/js/videochat/quickstart.js"></script>
<script>
	$(document).on('click',".openVideoBox",function(){
		var $this=$(this);
		var member_type="<?php echo ($this->nsession->userdata('member_session_membertype'))?$this->nsession->userdata('member_session_membertype'):0; ?>";
		if(member_type==1){
			var url="<?php echo base_url().'page/checkAvailTimeForVideoCall'; ?>"
			$.ajax({
	          type:'POST',
	          url: url,
	          data:{},
	          success:function(msg){ //alert(11);
	            var response=$.parseJSON(msg);
	            if(response.error==0){
	            	var imgUrl = $this.parent().parent().find('figure img').attr('src');
	            	$('#imgsrcforvid').attr('src',imgUrl);
	            	$('.video_call_name').html('<h4>'+$this.parent().find(".chatName").text()+'</h4>');
	            	$("#videoChat").modal('show');
					$('#videoChat').modal({backdrop: 'static', keyboard: false});
					
					//callUser('room_member_'+$this.attr('identifier'),imgUrl,$this.parent().find(".chatName").text());
					var from='';
					var to='';
					addfriendListFromVideo(firebaseparentid,$this.attr('identifier'),from,to);
					chatRequest($this.attr('identifier'),imgUrl,$this.parent().find(".chatName").text());
					play_rt();
					
	            }else{
	            	messagealert('Error',response.msg,'error');
	            	window.location.reload();
	            }
			  	//clearInterval(window.addTimerForVideo);
			  },
	          error: function () {
	            messagealert('Error','Technical issue , Please try later','error');
	            clearInterval(window.addTimerForVideo);
	            window.location.reload();
	          }
	        });
		}else{
			var imgUrl = $this.parent().parent().find('figure img').attr('src');
        	$('#imgsrcforvid').attr('src',imgUrl);
        	$('.video_call_name').html('<h4>'+$this.parent().find(".chatName").text()+'</h4>');
        	$("#videoChat").modal('show');
			$('#videoChat').modal({backdrop: 'static', keyboard: false});
			chatRequest($this.attr('identifier'),imgUrl,$this.parent().find(".chatName").text());
			play_rt();
			var from='';
			var to='';
			addfriendListFromVideo(firebaseparentid,$this.attr('identifier'),from,to);
		}
		
	})

	function addTimerForVideo(){
		var member_type="<?php echo ($this->nsession->userdata('member_session_membertype'))?$this->nsession->userdata('member_session_membertype'):0; ?>";
		if(member_type==1){
			console.log(1);
			var url="<?php echo base_url().'page/addTimerForVideo'; ?>"
			$.ajax({
	          type:'POST',
	          url: url,
	          data:{},
	          success:function(msg){ //alert(11);
	            var response=$.parseJSON(msg);
	            if(response.error==0){
	            	//messagealert('Success',response.msg,'success');
	            	var data=response.data;
	            	if(parseInt(data.time_available) <= 10){
	            		if(data.time_available > 0){
	            			var result = confirm("Do you want add more 100 minute becuase there are only "+data.time_available+" minute remaining");
							if (result) {
							   window.location.href="<?php echo base_url('member/add_more_time'); ?>";
							}
	            		}else{
	            			window.location.reload();
	            		}
	            		
	            	}
	            }else{
	            	messagealert('Error',response.msg,'error');
	            	clearInterval(window.addTimerForVideo);
	            	window.location.reload();
	            }
			  	//clearInterval(window.addTimerForVideo);
			  },
	          error: function () {
	            messagealert('Error','Technical issue , Please try later','error');
	            clearInterval(window.addTimerForVideo);
	            window.location.reload();
	          }
	        });
		}else{
			clearInterval(window.addTimerForVideo);
		}
		
	}

	function messagealert(title,text,type){
        new PNotify({
              title: title,
              text:  text,
              type:  type,
              styling: 'bootstrap3'
            });
    }
</script>
