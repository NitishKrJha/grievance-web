<?php
	if($this->nsession->userdata('member_session_email')){
		$vv=$this->functions->checkPaidOrNot($this->nsession->userdata('member_session_id'));
		if($this->nsession->userdata('member_session_membertype')==2){
			$vv=1;
		}
		?>
		<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/chat.js"></script>
		<script src="https://www.gstatic.com/firebasejs/4.3.0/firebase.js"></script>
        <script src='https://cdn.firebase.com/js/client/2.4.0/firebase.js'></script>
		<script type="text/javascript">
			var page="<?php echo isset($pagedata)?$pagedata:''; ?>"
		    var firebaseemail = '<?php echo $this->nsession->userdata('member_session_email'); ?>',firebasepassword = '123456',firebaseuser_name='<?php echo $this->nsession->userdata('member_session_name'); ?>',firebaseproPic = '<?php echo $this->nsession->userdata("profileImg"); ?>',firebaseparentid='<?php echo $this->nsession->userdata('member_session_id'); ?>',firebaseuserId='<?php echo $this->nsession->userdata('member_session_id'); ?>',chatAccess='<?php echo $vv; ?>';
		</script>
		<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/firebaseConf.js"></script>
		<!-- <link rel="stylesheet" href="https://crmrunner.com/crm/public/assets/css/chat.css"> -->
		<?php
	}
?>

<script type="text/html" id="chatWindowData">
	<div class="chat-window chatbox" id="chatbox_#id#" data-id="#identifier#" data-friends="0">
	    <div class="top-chat-section">
	      <div class="leftSec"> <span><img src="#imgsrc#" class="chatWithImg" alt=""></span> <strong class="chatWithName">#chatWithName#</strong> </div>
	      <div class="rightSec" id="closeBTNs">#closeBTNs# </div>
	    </div>
	    <div class="scrollbar-outer" id="chatboxcontentDataAccess">
	    	#chatboxcontentDataAccess#
	    </div>
		<div class="typeYourMesg"> <!--<a href="#"><i class="material-icons">attach_file</i></a>-->
			
			<div id="addLBTN" class="lead emoji-picker-container">
				#addLBTN#
			</div>
			
		</div>
	</div>
</script>

<script type="text/javascript" src="<?php echo css_images_js_base_url(); ?>js/config.js"></script>
<script type="text/javascript" src="<?php echo css_images_js_base_url(); ?>js/util.js"></script>
<script src="<?php echo css_images_js_base_url(); ?>js/jquery.emojiarea.js"></script>
<script src="<?php echo css_images_js_base_url(); ?>js/emoji-picker.js"></script>
<script>
  $(function() {
  	// Initializes and creates emoji set from sprite sheet
    window.emojiPicker = new EmojiPicker({
      emojiable_selector: '[data-emojiable=true]',
      assetsPath: '<?php echo css_images_js_base_url(); ?>img/',
      popupButtonClasses: 'fa fa-smile-o'
    });
    // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
    // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
    // It can be called as many times as necessary; previously converted input fields will not be converted again
    window.emojiPicker.discover();
  });
</script>
<div id="chatAppend"></div>