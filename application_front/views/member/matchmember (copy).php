

<section class="main-container">
   <div class="container-fluid">
	  <div class="row">
		<div class="col-md-12 myMatchSection">
		  <div class="row">
		   <?php $this->load->view('layout/member_left_menu')?>
		   <!-- search section -->
		    <div class="col-md-7">
			<div class="row searchCounselor">
                    	<div class="col-md-12 col-sm-12"><h3>Match Member</h3></div>
                        <div class="col-md-12 col-sm-12">
                        	 <div id="counselling-search-input">
                            <div class="input-group">
                                <!--<input type="text" class="  search-query form-control" placeholder="Enter city or country or ZIP code" />-->
								
						<form action ="<?php echo base_url().'member/mymatch'?>" method="post" name="search_counselor">
								
								<div class="row">
								<div class="col-md-2 col-sm-3">
									<select class="form-control" name="country" id="country_id">
									  <option value="">-Country-</option>
									   <option value=""> Any Country </option>
									  <option value="231"> United States </option>
									  <?php foreach($country as $countrydetail){?>
									   <option value="<?php echo $countrydetail['id'];?>" <?php if($countrydetail['id'] == $params['country_id']) echo 'selected';?> ><?php echo $countrydetail['name'];?></option>
									  <?php }?> 
								   </select>
								</div>
								
								
								<div class="col-md-2 col-sm-3">
								<select name="loking_for" id="loking_for" class="form-control" name="looking_for">
									<option value=""> Looking For </option>
									<option value="1" <?php if(isset($params['loking_for']) && $params['loking_for']=='1') echo 'selected';?>> Male </option>
									<option value="2" <?php if(isset($params['loking_for']) && $params['loking_for']=='2') echo 'selected';?>> Female </option>	
									
								</select>
								</div>
								
								<div class="col-md-2 col-sm-3">
								<select name="age_from" id="age_from" class="form-control" name="age_from">								
								<option value=""> Age From </option>
								<?php 								
									for($i = 18; $i<=100; $i++){?>
									<option value="<?php echo $i;?>" <?php if(isset($params['age_from']) && $params['age_from']==$i) echo 'selected';?>> <?php echo $i;?></option>								
								<?php } ?>
								</select>
								</div>
								
								<div class="col-md-2 col-sm-3">
								<select name="age_to" id="age_to" class="form-control" name="age_to">								
								<option value=""> Age TO </option>
								<?php 								
									for($j = 18; $j<=100; $j++){?>
									<option value="<?php echo $j;?>" <?php if(isset($params['age_to']) && $params['age_to']==$j) echo 'selected';?>> <?php echo $j;?></option>								
								<?php } ?>
								</select>
								</div>
								
								<div class="col-md-2">
									<input type="submit" value="Search Matches" class="showTipsBtn">
								</div>

								</div>
                            </div>
                        </div>
                        </div>
                                                
					</form>	
					<input type="hidden" id="search" value="<?=$search_string?>">
					<!-- <div class="col-md-2">
						<a href="javascript:void(0)" class="openmodalvid btn showTipsBtn">Open Vid</a>
					</div> -->
            </div>
			
		   <!-- search section-->
		   <div id="search_div">
		   <?php if(!empty($member['result'])){ foreach($member['result'] as $mbr){ 
		   $pic = isset($mbr['picture'])?$mbr['picture']:css_images_js_base_url().'images/images.png'; 
		   if($pic==""){
		   	$pic=css_images_js_base_url().'images/images.png';
		   }else{
		   	$pic_thumb=$mbr['crop_profile_image'];
		   	if($pic_thumb!=''){
		   		$pic=$pic_thumb;
		   	}
		   }
		   $name= isset($mbr['name'])&& $mbr['name']!=''?$mbr['name']:'Unknown';
		   $age = isset($mbr['age'])&& $mbr['age']>0?$mbr['age']:'';
		   $member_id = base64_encode($mbr['id']);
		   $memberId = rtrim($member_id, '=');
		   $membership_expire_date = isset($mbr['membership_plan'][0]['expiry_date'])?$mbr['membership_plan'][0]['expiry_date']:'';		   
		   ?>
		  
			<input type="hidden" id="is_member" value="<?=$exp_date?>"> 
			<div class="col-md-4 col-sm-4 matchMember">
			<div class="myMatch"> 
			<figure><img src="<?= $pic?>" alt=""></figure>
			
			<!--<a href="ab.php"> Block </a>-->
			
			<div class="textSec">
			<?php ?>
			
			<?php if(($membership_expire_date!='' && $membership_expire_date >= date('Y-m-d')) && ($exp_date!='' && $exp_date>=date('Y-m-d'))){?>
			<!-- <a href="javascript:void(0);" class="openChatBox" identifier="<?php echo $mbr['member_id'];?>"><i class="fa fa-comment-o" aria-hidden="true"></i> </a> -->  
			<a href="javascript:void(0);" class="openVideoBox" identifier="<?php echo $mbr['member_id'];?>"><i class="fa fa-video-camera" aria-hidden="true"></i> </a>
			<?php  } ?>	
			
			<a href="javascript:void(0);" identifier="<?php echo $mbr['member_id'];?>" class="chatShowHidePre"><input type="hidden" value="<?php echo $mbr['name'];?>" class="h_name<?php echo $mbr['member_id'];?>" id="h_name<?php echo $mbr['member_id'];?>" /><input type="hidden" value="<?php echo $pic;?>" id="h_pic<?php echo $mbr['member_id'];?>" /><i class="fa fa-comment-o" aria-hidden="true"></i> </a>
			<p> <a href="<?= base_url('member/profile/').$memberId; ?>" class="chatName"><?=$name ?> <?= $age!=''?','.$age:'' ?></a>	
				
			</p>
			
		
			<!--<a href="javascript:void(0);" class="makeCanceled" data-id="<?php echo $mbr['member_id'];?>"><i class="fa fa-ban" aria-hidden="true" ></i></a>-->
	
			
			</div>
			</div>
			</div>

		   <?php } } else { ?>
		  <h2 class="no_data"> No data found </h2>
		   <?php } ?>
		   </div>
		   </div>
		   
		    <?php $this->load->view('layout/memberMyContact');?>
		    <?php $this->load->view('layout/memberChatRequest');?>
		   
		  </div>
		</div>
		
		
		</div>
    </div>

</section>	
<script>
		window.currPage1 = 1;
		total_record1=1;
		$(window).scroll(function(){
			var search_string = $('#search').val();
			var currPage1 =1;
			var scrollHeight = $(document).height();
			var scrollPosition = $(window).height() + $(window).scrollTop();
			if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
				
			
			if(total_record1 > parseInt(0)){
				$.ajax({
					url : '<?= base_url('member/ajaxMatchSearch')?>/'+window.currPage1,
					data : {'search_string':search_string},
					dataType : 'json',
					type : 'post',
					beforeSend : function(){
					  // $('#loading').show();
					   
					},
					success : function(data){
						total_record1=data.count;
						var html ='';
						var prev_html = $('#search_div').html();
						
						if(data.result.length > 0)
						{
							for(i=0;i<data.result.length;i++)
							{
								if(data.result[i].picture =="" || data.result[i].picture == null)
								{
									var image = "<?php echo CSS_IMAGES_JS_BASE_URL ?>images/images.png";
								}
								else{
									var image = data.result[i].picture;
							    }
								
								//name 
								var name = data.result[i].name;
								var age = data.result[i].age;
								var text = '';
								if( name !='' && age > 0  )
								{
									var text = name +','+age ;
								}
								else if(name !='' && age == 0 )
								{
									var text = name;
								}
								else{
									text = '';
								}
									var html =html+'<div class="col-md-4 col-sm-4 matchMember"><div class="myMatch"> <figure><img src="'+image+'" alt=""></figure><div class="textSec"><a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i> </a> <a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i> </a><p><a href="<?= base_url('member/profile/')?>'+btoa(data.result[i].id)+'">'+text+'</a></p></div></div></div>';
							  
							}
							new_html = prev_html+html;
							
							$('#search_div').html(new_html);
							
						}							
				    }
					
				   
			   })
			    window.currPage1 = parseInt(window.currPage1)+parseInt(1);
			}
			}
		});
</script>

<script>

 $(document).on('click','.openmodalvid',function(){
 	$('#videoChatMod').modal('show');
 })

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

/*  function ChangeStatus(url)
 {
	if(window.confirm("Are you sure to block this member ?"))
	{
		  window.location.href = url;
		 //window.location.reload();
	}
 } */
</script>


<!-- <div id="chatbox_2011111" class="chatbox" style="bottom: 0px; right: 20px; display: none;">
	<div class="chatboxhead">
		<div class="chatboxtitle">
			<a href="javascript:void(0)" style="text-decoration:none;color: #fff;" onclick="javascript:toggleChatBoxGrowth('20')">deb</a>
		</div>
		<div class="chatboxoptions">
			<a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth('20')"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
			<a href="javascript:void(0)" onclick="javascript:closeChatBox('20')"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
		</div>
		<br clear="all">
	</div>
	<div class="chatboxcontent">
		<div class="chatboxmessage msgMe">
			<span class="chatboxmessagecontent">hi</span>
		</div>
		<div class="chatboxmessage msgMe">
			<span class="chatboxmessagecontent">kii</span>
		</div>
	</div>
	<div class="chatboxinput">
		<div class="image-upload">
			<label for="file-input"><i class="fa fa-paperclip attachItem" aria-hidden="true"></i></label>
			<input class="chatFileUpload" chatid="20" type="file">
		</div>
		<textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,'20');" style="height: 44px;"></textarea>
		<a href="javascript: void(0);" onclick="javascript:return sendChat(event,this,'20');" style="font-size: 19px;position: absolute;top: 26px;right: 9px;"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
	</div>
</div> -->
<?php /* ?>
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
		
		<div id="addLBTN" class="lead emoji-picker-container">
			 	
		</div>
		
	</div>
</div>


<div class="chat-window chatbox" style="" id="chatbox_cs4qKMhq8phIiJ9j2CAjDTZ4cql2">
    <div class="top-chat-section">
      <div class="leftSec"> <span><img src="https://www.mymissingrib.com//uploads/profile_pic/15331289651533129292010.jpg" class="chatWithImg" alt=""></span> <strong class="chatWithName">Bahubali</strong> </div>
      <div class="rightSec" id="closeBTNs"><a href="javascript:void(0);" class="hideParent" onclick="javascript:return closeChatBox('cs4qKMhq8phIiJ9j2CAjDTZ4cql2');"><i class="fa fa-times" aria-hidden="true"></i></a></div>
    </div>
    <div class="scrollbar-outer" id="chatboxcontentDataAccess">
    	<img src="https://www.mymissingrib.com/public/images/blur-image.jpg">
    </div>
	<div class="typeYourMesg"> <!--<a href="#"><i class="material-icons">attach_file</i></a>-->
		
		<div id="addLBTN" class="lead emoji-picker-container"><input type="text" data-emojiable="true" class="form-control messageToSend chatboxtextarea" placeholder="Type your message..." onkeydown="javascript:return checkChatBoxInputKey(event,this,'cs4qKMhq8phIiJ9j2CAjDTZ4cql2');"><div style="display:none;" useridentifier="" class="useridentifier"></div><a href="javascript:void(0);" onclick="javascript:return sendChat(event,this,'cs4qKMhq8phIiJ9j2CAjDTZ4cql2');"><i class="fa fa-paper-plane" aria-hidden="true"></i></a></div>
		
	</div>
</div>
<?php */ ?>




