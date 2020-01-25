<section class="main-container">
   <div class="container-fluid">
	  <div class="row">
		<div class="col-md-12 myMatchSection">
		  <div class="row">
		   <?php $this->load->view('layout/member_left_menu')?>
		   <!-- search section -->
		    <div class="col-md-7">
				<div class="row searchCounselor">
	                <div class="col-md-12 col-sm-12"><h3>Favorite</h3></div>
	                <div class="col-md-12">
	                    <div id="counselling-search-input">
	                        <div class="row">
	                            <form action ="<?php echo base_url().'member/favourite'?>" method="post" name="search_counselor">
									<div class="col-md-2 col-sm-3">
										<select class="form-control" name="country" id="country_id">
										  <option value="">-Country-</option>
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
										<option value=""> Age To </option>
										<?php 								
											for($j = 18; $j<=100; $j++){?>
											<option value="<?php echo $j;?>" <?php if(isset($params['age_to']) && $params['age_to']==$j) echo 'selected';?>> <?php echo $j;?></option>								
										<?php } ?>
										</select>
									</div>
									<div class="col-md-2">
										<input type="submit" value="Search Matches" class="showTipsBtn">
									</div>
								</form>	
	                        </div>
	                    </div>
	                </div>
	            	<input type="hidden" id="search" value="<?=$search_string?>">
	            </div>
			
				<!-- search section-->
				<div id="search_div">
				<?php if(!empty($member['result'])){ foreach($member['result'] as $mbr){ 
				$pic = isset($mbr['picture'])?$mbr['picture']:CSS_IMAGES_JS_BASE_URL.'images/images.png'; 
				$name= isset($mbr['name'])&& $mbr['name']!=''?$mbr['name']:'Unknown';
				$age = isset($mbr['age'])&& $mbr['age']>0?$mbr['age']:'';
				$member_id = base64_encode($mbr['id']);
				$memberId = rtrim($member_id, '=');

				$membership_expire_date = isset($mbr['membership_plan'][0]['expiry_date'])?$mbr['membership_plan'][0]['expiry_date']:'';

				//echo $membership_expire_date; die;

				?>

				<input type="hidden" id="is_member" value="<?=$exp_date?>"> 
				<div class="col-md-3 col-sm-4 matchMember">
				<div class="myMatch"> 
				<figure><img src="<?= $pic?>" alt=""></figure>

				<div class="textSec"><!--<a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i> </a>-->

					<?php if(($membership_expire_date!='' && $membership_expire_date >= date('Y-m-d')) && ($exp_date!='' && $exp_date>=date('Y-m-d'))){?>
					
					
					<!--<a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i> </a>-->
					
					<a href="javascript:void(0);" class="openVideoBox" identifier="<?php echo $mbr['member_id'];?>"><i class="fa fa-video-camera" aria-hidden="true"></i> </a>
					
					<?php } ?>
					<a href="javascript:void(0);" identifier="<?php echo $mbr['member_id'];?>"><input type="hidden" value="<?php echo $mbr['name'];?>" id="h_name<?php echo $mbr['member_id'];?>" /><input type="hidden" value="<?php echo $pic;?>" id="h_pic<?php echo $mbr['member_id'];?>" /><i class="fa fa-comment-o" aria-hidden="true"></i> </a>
					<a href="javascript:void(0);" onclick="my_favaourite(<?php echo $mbr['member_id'];?>)"><i class="fa fa-heart" aria-hidden="true"></i></a>
					<p> <a href="<?= base_url('member/profile/').$memberId; ?>" class="chatName"><?=$name ?> <?= $age!=''?','.$age:'' ?>
					</a>
					
					</p>
					
				</div>
				</div>
				</div>

				<?php } } else { ?>
				<h2 class="no_data"> No data found </h2>
				<?php } ?>
				</div>
		   </div>
		   <?php echo $this->load->view('layout/memberMyContact'); ?>
           <?php echo $this->load->view('layout/memberChatRequest'); ?>
		  </div>
		</div>
		<input type="hidden" id="param" value="<?=$param?>">
		
		</div>
    </div>

</section>
<script>
		/* window.currPage1 = 1;
		total_record1=1;
		$(window).scroll(function(){
			var search_string = $('#search').val();
			var currPage1 =1;
			var scrollHeight = $(document).height();
			var scrollPosition = $(window).height() + $(window).scrollTop();
			if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
				
			
			if(total_record1 > parseInt(0)){
				
				$.ajax({
					url : '<?= base_url('member/ajaxfavriteSearch')?>/'+window.currPage1,
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
									var html =html+'<div class="col-md-3 col-sm-4 matchMember"><div class="myMatch"> <figure><img src="'+image+'" alt=""></figure><div class="textSec"><a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i> </a> <a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i> </a><p><a href="<?= base_url('member/profile/')?>'+btoa(data.result[i].id)+'">'+text+'</a></p></div></div></div>';
							  
							}
							new_html = prev_html+html;
							
							$('#search_div').html(new_html);
							
						}							
				    }
					
				   
			   })
			    window.currPage1 = parseInt(window.currPage1)+parseInt(1);
			}
			}
		}); */
</script>

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
						var exp_date = $('#is_member').val();
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
								var expiry_date = '';
								if(data.result[i].membership_plan.length > 0)
								{
									expiry_date = data.result[i].membership_plan[0]['expiry_date'];
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
		
		$( document ).ready(function() {
         var parm = $('#param').val();
		 if(parm == 1)
		 {
			 $('#interests').modal({
				show: true,
				backdrop: false
			})  
		 }
		 
		});

		function my_favaourite(member_id)
		{
			$.ajax({
				
				url:'<?= base_url('member/my_favaourite')?>',
				method:'POST',
				data:{'member_id':member_id},
				type:'json',
				success:function(data){
					window.location.reload();
				}
				
			})
		}
</script>

