 <section class="main-container">
            <div class="container-fluid">
                <div class="row">
                    
                    <div class="col-md-12 myMatchSection">
                       <div class="row" id="search_div">
                       		<?php 
							if(!empty($match_list)){ 
								foreach($match_list as $k=>$val){ 
								 $pic = isset($val['picture'])?$val['picture']:CSS_IMAGES_JS_BASE_URL.'images/images.png'; 
								$name= isset($val['name'])&& $val['name']!=''?$val['name']:'Unknown';
								$age = isset($val['age'])&& $val['age']>0?$val['age']:'';
								$image = isset($val['crop_profile_image'])&& $val['crop_profile_image']!=''?$val['crop_profile_image']: CSS_IMAGES_JS_BASE_URL.'images/NoImage.png';
								$memberId = base64_encode($val['member_id']);
								$memberId = rtrim($memberId, '=');								
								$membership_expire_date = isset($val['membership_plan'][0]['expiry_date'])?$val['membership_plan'][0]['expiry_date']:'';
								?>
							
							<input type="hidden" id="is_member" value="<?=$exp_date?>"> 
							<div class="col-md-3 col-sm-4 matchMember">
                            <div class="myMatch"> 
								<figure><img src="<?= $pic?>" alt=""></figure>
								
								<!--<a href="ab.php"> Block </a>-->
								
								<div class="textSec">
								
										
										<?php if(($membership_expire_date!='' && $membership_expire_date >= date('Y-m-d')) && ($exp_date!='' && $exp_date>=date('Y-m-d'))){?>
										<a href="javascript:void(0);" class="openChatBox" identifier="<?php echo $mbr['member_id'];?>">
										<i class="fa fa-comment-o" aria-hidden="true"></i> 
										</a> 
										<a href="javascript:void(0);" class="openVideoBox" identifier="<?php echo $mbr['member_id'];?>"><i class="fa fa-video-camera" aria-hidden="true"></i> </a>
										<?php } ?>		
										<p> <a href="<?= base_url('member/profile/').$memberId; ?>" class="chatName"><?=$name ?> <?= $age!=''?','.$age:'' ?>
										</a>
											
										</p>
										
									
										<!--<a href="javascript:void(0);" class="makeCanceled" data-id="<?php echo $val['member_id'];?>"><i class="fa fa-ban" aria-hidden="true" ></i></a>-->
						
								
								</div>
							</div>
                        </div>
                            <?php } 
							} else {?>
                            <div class="col-md-9 col-md-offset-1">

                                    <p class="noResult" >No Result found <img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/no-result.png" alt=""></p>
                             </div>
                            <?php } ?>
							
                       </div>
					   <input type="hidden" id="search_string" value="<?=$search_string?>">
                    </div>
                    
                    <!--<div class="col-md-3 col-sm-6">
                    	<div class="contactSec rightcontactSec">
                        	<div class="header-title">My Contacts </div>
                            <ul>
                            	<li>
                                	<span class="userIcn img-circle"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/chat-icn1.jpg" alt=""> <span class="onlineActv"></span></span>
                                    <span class="textSec"><h3>Jennifer</h3> <p>How are you :)</p></span>
                                    <span class="count">1</span>
                                </li>
                                
                                <li>
                                	<span class="userIcn img-circle"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/chat-icn2.jpg" alt=""> <span class="offline"></span></span>
                                    <span class="textSec"><h3>Nataliya</h3> <p>Feeling Awesome...</p></span>
                                    
                                </li>
                                
                                <li>
                                	<span class="userIcn img-circle"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/chat-icn3.jpg" alt=""></span>
                                    <span class="textSec"><h3>Angela</h3> <p>Whatsupppp</p></span>
                                    <span class="count">3</span>
                                </li>
                                
                                <li>
                                	<span class="userIcn img-circle"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/chat-icn1.jpg" alt=""></span>
                                    <span class="textSec"><h3>Nataliya</h3> <p>Feeling Awesome...</p></span>
                                    
                                </li>
                                
                                 <li>
                                	<span class="userIcn img-circle"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/chat-icn2.jpg" alt=""></span>
                                    <span class="textSec"><h3>Angela</h3> <p>Whatsupppp</p></span>
                                    <span class="count">3</span>
                                </li>
                                
                            </ul>
                            
                             <div id="custom-search-input">
                            <div class="input-group col-md-12">
                                <input type="text" class="  search-query form-control" placeholder="Search Contact" />
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="button">
                                        <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                        
                        </div>
                       
                    </div> --> 
                    <!--<div class="col-md-3 col-sm-6">
                            <div class="contactSec chatRequests">
                                <div class="header-title">Chat Requests </div>
                                <ul>
                                    <li>
                                        <span class="userIcn img-circle"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/chat-icn1.jpg" alt=""> <span class="onlineActv"></span></span>
                                        <span class="textSec"><h3>Jennifer</h3> <p>How are you :)</p></span>
                                        <span class="count"><a href="#">Reply</a></span>
                                    </li>
                                    
                                    <li>
                                        <span class="userIcn img-circle"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/chat-icn2.jpg" alt=""> <span class="offline"></span></span>
                                        <span class="textSec"><h3>Nataliya</h3> <p>Feeling Awesome...</p></span>
                                        
                                    </li>
                                    
                                    <li>
                                        <span class="userIcn img-circle"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/chat-icn3.jpg" alt=""></span>
                                        <span class="textSec"><h3>Angela</h3> <p>Whatsupppp....</p></span>
                                        <span class="count"><a href="#">Reply</a></span>
                                    </li>
                                    <li>
                                        <span class="userIcn img-circle"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/chat-icn1.jpg" alt=""> <span class="onlineActv"></span></span>
                                        <span class="textSec"><h3>Nataliya</h3> <p>Feeling Awesome...</p></span>
                                        
                                    </li>
                                    
                                    <li>
                                        <span class="userIcn img-circle"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/chat-icn2.jpg" alt=""> <span class="offline"></span></span>
                                        <span class="textSec"><h3>Jennifer</h3> <p>How are you :)</p></span>
                                        <span class="count"><a href="#">Reply</a></span>
                                    </li>
                                    
                                    <li>
                                        <span class="userIcn img-circle"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/chat-icn3.jpg" alt=""></span>
                                        <span class="textSec"><h3>Angela</h3> <p>How are you :)</p></span>
                                       
                                    </li>
                                    
                                </ul>
    
                            </div>
                        </div>-->
                </div>
            </div>
        </section>
		<script>
		window.currPage1 = 1;
		total_record1=1;
		$(window).scroll(function(){
			var search_string = $('#search_string').val();
			var currPage1 =1;
			var scrollHeight = $(document).height();
			var scrollPosition = $(window).height() + $(window).scrollTop();
			if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
				
			
			if(total_record1 > parseInt(0)){
				$.ajax({
					url : '<?= base_url('member/ajaxMemberSearch')?>/'+window.currPage1,
					data : {'search_string':search_string},
					dataType : 'json',
					type : 'post',
					beforeSend : function(){
					  // $('#loading').show();
					   
					},
					success : function(data){
						total_record1=data.count;
						var exp_date = $('#is_member').val();
						var html ='';
						var prev_html = $('#search_div').html();
						
						if(data.result.length > 0)
						{
							for(i=0;i<data.result.length;i++)
							{
								if(data.result[i].crop_profile_image =="" || data.result[i].crop_profile_image == null)
								{
									var image = "<?php echo CSS_IMAGES_JS_BASE_URL ?>images/NoImage.png";
								}
								else{
									var image = data.result[i].crop_profile_image;
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
									var html =html+'<div class="col-md-3 col-sm-4 matchMember"><div class="myMatch"> <figure><img src="'+image+'" alt=""></figure><div class="textSec">';
									if((expiry_date!='' && expiry_date >= '<?= date(Y-m-d)?>') && (exp_date!='' && exp_date >= '<?= date('Y-m-d')?>')){
									 html = html+'<a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i> </a> <a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i> </a>';
									}
									 html = html+'<p><a href="<?= base_url('member/profile/')?>'+btoa(data.result[i].id)+'">'+text+'</a></p></div></div></div>';
							  
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