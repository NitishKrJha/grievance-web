
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
<?php /*
<!-- jquery latest version --> 
<script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendor/js/vendor/jquery.min.js"></script> 
<!-- jquery-migrate js --> 
<script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendor/js/jquery-migrate-1.2.1.js"></script> 
<!-- bootstrap js --> 
<script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendor/js/bootstrap.min.js"></script> 
<!-- scrollbar js --> 
<script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendor/js/jquery.scrollbar.min.js"></script> 
<!-- main js --> 
<script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendor/js/jquery.slicknav.min.js"></script> 
<script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendor/js/owl.carousel.min.js"></script> 
<script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>vendor/js/main.js"></script>
<?php */ ?>
<script>
	window.host = '<?php echo base_url();?>';
	window.loginas = '<?php echo 'member_'.$this->nsession->userdata("member_session_id");?>';
</script>
<script src="https://media.twiliocdn.com/sdk/js/chat/releases/1.2.1/twilio-chat.js"></script>
<script src="//media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
<script src="//media.twiliocdn.com/sdk/js/video/releases/1.0.0/twilio-video.js"></script>
<script src="https://media.twiliocdn.com/sdk/js/conversations/v0.13/twilio-conversations.min.js"></script>
<script src="//media.twiliocdn.com/sdk/conversations/v0.7/js/releases/0.7.1.b1-7238b35/twilio-conversations-loader.min.js"></script>
<!-- <script type="text/javascript" src="https://requirejs.org/docs/release/2.2.0/minified/require.js"></script> -->
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
		var $this=$(this);
		var member_type="<?php echo ($this->nsession->userdata('member_session_membertype'))?$this->nsession->userdata('member_session_membertype'):0; ?>";
		if(member_type==1){
			console.log(12);
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
					chatRequest($this.attr('identifier'),imgUrl,$this.parent().find(".chatName").text());
					play_rt();
					var from='';
					var to='';
					addfriendListFromVideo(firebaseparentid,$this.attr('identifier'),from,to);
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
