      
        <section class="main-container">
            <div class="container-fluid">
                <div class="row">
                    <?php if($memberData['member_type']== 1) {?>
					<?php $this->load->view('layout/member_left_menu')?>
				 
					<?php }else{ ?>
				  
					<?php $this->load->view('layout/counselorLeftMenu')?>
				  <?php } ?>
                    <div class="col-md-7">
                    
                    <div class="row searchCounselor">
                    	<div class="col-md-12 col-sm-12"><h3>Search Subscriber</h3></div>
                        <div class="col-md-12">
	                        <div id="counselling-search-input">
	                            <div class="row">
	                                <form action ="<?php echo base_url().'counselor/subscriber'?>" method="post" name="search_counselor">
																	
										<div class="col-md-2 col-sm-3">
											<select class="form-control" name="country_id" id="country_id">
											  <option value="">-Country-</option>
											  <?php foreach($allcountry as $countrydetail){?>
											   <option value="<?php echo $countrydetail['id'];?>"><?php echo $countrydetail['name'];?></option>
											  <?php }?> 
										   </select>
										</div>
										<div class="col-md-2 col-sm-3">
											<select class="form-control" name="state_id" id="state_id">
											  <option value="">-State-</option>
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
										
										<div class="col-md-2 col-sm-12">
											<input type="submit" value="Search Counselor" class="showTipsBtn">
										</div>
									</form>		
	                            </div>
	                        </div>
                        </div>
					</div>
                    
                       <div class="row counselling counselorTimer" id="search_div">
					   
						<?php 
						if(!empty($subscriberList)){
						  	
						  foreach($subscriberList as $row=>$val){
						  	$member_id=$this->nsession->userdata('member_session_id');
							if($val['from_member']==$member_id){
								$name=$val['to_name'];
								$picture=$val['to_picture'];
								$mem_id=$val['to_member'];
							}else{
								$name=$val['from_name'];
								$picture=$val['from_picture'];
								$mem_id=$val['from_member'];
							}
						   	$pic = isset($picture)?$picture:""; 

						    if($pic==''){
						   		$pic=css_images_js_base_url().'images/images.png';
						    }

						   $name= isset($name)&& $name!=''?$name:'Unknown';
						   $member_id = base64_encode($mem_id);
						   $memberId = rtrim($member_id, '=');
						
						   		 
							?>
                       		<div class="col-md-3 col-sm-4 matchMember" identifier="<?php echo $mem_id;?>">
                            	
								<div class="myMatch" identifier="<?php echo $mem_id;?>">
                                	<figure><img src="<?php echo $pic; ?>" alt=""></figure>
									<div class="textSec textsec--mod">
										<div style="display:<?php echo $display; ?>;" id="chat_id_<?php echo $mem_id;?>">
									 
											<a href="javascript:void(0);" class="btn--modify" identifier="<?php echo $mem_id;?>"><input type="hidden" value="<?php echo $name;?>" id="h_name<?php echo $mem_id;?>" /><input type="hidden" value="<?php echo $pic;?>" id="h_pic<?php echo $mem_id;?>"/><i class="fa fa-comment-o" aria-hidden="true"></i> </a>
											
										</div>	
									 
									
                       					<a class="prfilCls" href="<?php echo base_url('member/profile/'.$memberId) ?>" style="
											position:  relative;
											z-index: 2;
										"><p class="chatName"><?php echo $name; ?></p>
										</a>
									</div>	
								</div>
								
                            </div>
							<?php 
							} 
						}else{ ?>
						<h2 class="no_data"> No data found </h2>
						<?php } ?>
                         
                       </div>
					   <?php echo $this->pagination->create_links();?>
                    </div>
                    
                   
                    <?php $this->load->view('layout/memberMyContact');?>
		            <?php $this->load->view('layout/memberChatRequest');?>
                    
                
                </div>
            </div>

        </section>
				
 
<script>
	$("#country_id").change(function(){
	 //alert(1);
	$.ajax({
	  url : '<?php echo base_url("member/getCountry");?>',
	  type : 'POST',
	  data : 'country_id='+$(this).val(),
	  dataType : 'json',
	  success : function(data){
	    var html = '';
	    var preCource = '<?php //echo $state;?>';
	    if(data!=''){
			 html = html+'<option value="" >-None-</option>';
	      $.each(data,function(index,value){
	        var selected ='';
			
	        if(preCource == value.id){ selected = 'selected'; }
	        html = html+'<option value="'+value.id+'" '+selected+'>'+value.name+'</option>';
	      }); 
	    }else{
			 html = html+'<option value="" >-None-</option>';
		}
	    $("#state_id").html(html);
	  }
	})
	})
 
	$("#state_id").change(function(){
	 //alert(1);
	$.ajax({
	  url : '<?php echo base_url("member/getCity");?>',
	  type : 'POST',
	  data : 'state_id='+$(this).val(),
	  dataType : 'json',
	  success : function(data){
	    var html = '';
	    var preCource = '<?php //echo $city;?>';
	    if(data!=''){
			html = html+'<option value="" >-None-</option>';
	      $.each(data,function(index,value){
	        var selected ='';
	        
			if(preCource == value.id){ selected = 'selected'; }
			
	        html = html+'<option value="'+value.id+'" '+selected+'>'+value.name+'</option>';
	      }); 
	    }else{
			 html = html+'<option value="" >-None-</option>';
		}
	    $("#city_id").html(html);
	  }
	})
	})

	window.currPage1 = 1;
	var total_record1=1;
	$(window).scroll(function(){
		var search_string = "<?php echo $search_string; ?>";
		var memberid="<?php echo $this->nsession->userdata('member_session_id'); ?>";
		var currPage1 =1;
		var scrollHeight = $(document).height();
		var scrollPosition = $(window).height() + $(window).scrollTop();
		if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
			
		
		if(total_record1 > parseInt(0)){
			$.ajax({
				url : '<?= base_url('counselor/ajaxSubscriberSearch')?>/'+window.currPage1,
				data : {'search_string':search_string},
				dataType : 'json',
				type : 'post',
				beforeSend : function(){
				  // $('#loading').show();
				   
				},
				success : function(data){
					total_record1=data.count;
					
					//var prev_html = $('#search_div').html();
					
					if(data.count > 0)
					{
						for(i=0;i<data.result.length;i++)
						{
							var html='';
							if(data.result[i].from_member==memberid){
								var pic=data.result[i].to_picture;
								var name=data.result[i].to_name;
								var member_id = data.result[i].to_member;
							}else{
								var pic=data.result[i].from_picture;
								var name=data.result[i].from_name;
								var member_id = data.result[i].from_member;
							}
							if(pic =="" || pic == null)
							{
								var image = "<?php echo CSS_IMAGES_JS_BASE_URL ?>images/images.png";
							}
							else{
								var image = pic;
						    }
							
							if(name==''){
								name='unknow';
							}
							html +='<div class="col-md-3 col-sm-4 matchMember" identifier="'+member_id+'">';	
							html +='<div class="myMatch" identifier="'+member_id+'">';
                            html +='<figure><img src="'+image+'" alt=""></figure>';
							html +='<div class="textSec textsec--mod">';
							html +='<div id="chat_id_'+member_id+'">';
									 
							html +='<a href="javascript:void(0);" class="btn--modify" identifier="'+member_id+'"><input type="hidden" value="'+name+'" id="h_name'+member_id+'" /><input type="hidden" value="'+member_id+'" id="h_pic'+image+'"/><i class="fa fa-comment-o" aria-hidden="true"></i> </a>';
											
							html +='</div>';
									 
									
                       		html +='<a class="prfilCls" href="<?= base_url('member/profile/')?>'+btoa(member_id)+'" style="position:  relative;z-index: 2;">';
                       		html +='<p class="chatName">'+name+'</p>';
							html +='</a>';
							html +='</div>';	
							html +='</div>';
								

								
							$('#search_div').append(html);
						}
						//new_html = prev_html+html;
						
						listUsers();
					}							
			    }
				
			   
		   })
		    window.currPage1 = parseInt(window.currPage1)+parseInt(1);
		}
		}
	});
</script>