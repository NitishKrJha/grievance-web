<link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL; ?>css/owl.theme.default.min.css">
<link rel="stylesheet" href="<?php echo CSS_IMAGES_JS_BASE_URL;?>css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
 <section class="main-container">
    <div class="container-fluid">
      <div class="row">
          <?php $this->load->view('layout/member_left_menu')?>
        <div class="col-md-10">
          <div class="dashboardSec">
            <div class="row">
              <div class="col-md-12" >
                <div class="owl-carousel owl-theme" id="dashboardSecSlid">
				<?php 
					if(!empty($maches['result'])){ foreach($maches['result'] as $k=>$val){
					$city_name = get_where('cities',array('id'=>$val['city'])); 
					$state = get_where('states',array('id'=>$val['state']));
					if($val['maritial_status']==3)
					{
						$marital_status = "Divorced";
					}
					else if($val['maritial_status']==2)
					{
						$marital_status = "Married";
					}
					else{
						$marital_status = "Single";
					}
					//height
					$height = isset($val['member_details'][0]['height'])?(int)$val['member_details'][0]['height']:0;
					$height_inches = isset($val['member_details'][0]['height_inches'])?$val['member_details'][0]['height_inches']:0;
					$height_cm = $height." ft ".$height_inches." in";
					if((int)$height_inches > 0){
						$height_cm = $height." ft ";
					}
					//want kids
					if(isset($val['member_details'][0]['want_kids']) && $val['member_details'][0]['want_kids']==1 )
					{
						$want_kids = "Yes";
					}
					else{
						$want_kids = "No";
					}
					 //have kids
					 $have_kids = isset($val['member_details'][0]['have_kids'])?$val['member_details'][0]['have_kids']:'No';
					 //faith
					 $faith =  isset($val['member_details'][0]['faith'])&& ($val['member_details'][0]['faith']>0)?$val['member_details'][0]['faith']:'No Faith';
					 //smoking
					 if(isset($val['member_details'][0]['faith']) && $val['member_details'][0]['smoking']==1)
					 {
						 $smoking = "Non-Smoker";
					 }
					 else if(isset($val['member_details'][0]['faith']) && $val['member_details'][0]['smoking']==2)
					 {
						  $smoking = "Light-Smoker";
					 }
					 else if(isset($val['member_details'][0]['faith']) && $val['member_details'][0]['smoking']==3)
					 {
						  $smoking = "High-Smoker";
					 }
					 else{
						  $smoking = "Unknown";
					}
					//drinker
					if(isset($val['member_details'][0]['drinking']) && $val['member_details'][0]['drinking']==1)
					 {
						 $drinking = "Non-Drinker";
					 }
					 else if(isset($val['member_details'][0]['faith']) && $val['member_details'][0]['drinking']==2)
					 {
						  $drinking = "Light-Drinker";
					 }
					 else if(isset($val['member_details'][0]['faith']) && $val['member_details'][0]['drinking']==3)
					 {
						  $drinking = "High-Drinker";
					 }
					 else{
						  $drinking = "Unknown";
					}
					$favourite = $this->db->where('member_id',$user_id)->where('favorite_member_id',$val['member_id'])->get('my_favorite')->result_array();
					
					$pic = isset($val['picture'])?$val['picture']:css_images_js_base_url().'images/images.png'; 
				    if($pic==""){
				   	 $pic=css_images_js_base_url().'images/images.png';
				    }else{
				   	 $pic_thumb=$val['crop_profile_image'];
				   	if($pic_thumb!=''){
				   		$pic=$pic_thumb;
				   	}
				   }
				   $membership_expire_date = isset($val['membership_plan']['expiry_date'])?$val['membership_plan']['expiry_date']:'';
				?>
                  <div class=" item">
                    <div class="box"> 
						<div class="action_wrap">
                			<ul>
                				<?php	 if(!empty($favourite) && $favourite[0]['is_delete']==1){ ?>
								<li><a class="like" onclick="my_favaourite(<?=$val['member_id']?>,this)" href="javascript:void(0)"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>
								<?php } else { ?>
								<li><a class="like" onclick="my_favaourite(<?=$val['member_id']?>,this)" href="javascript:void(0)"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>
								<?php } ?>
								<li><a href="javascript:void(0);" id="openMessageForm" data-member="<?=$val['member_id']?>"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>
								<?php if(($membership_expire_date!='' && $membership_expire_date >= date('Y-m-d')) && ($exp_date!='' && $exp_date>=date('Y-m-d'))){?>
								<li><a href="javascript:void(0);" class="openVideoBox" identifier="<?=$val['member_id']?>"><i class="fa fa-video-camera" aria-hidden="true"></i> </a></li>
								<?php } ?>
								<li><a href="javascript:void(0);" identifier="<?=$val['member_id']?>" class="chatShowHidePre"><input type="hidden" value="<?php echo $val['name'];?>" class="h_name<?php echo $val['member_id'];?>" id="h_name<?php echo $val['member_id'];?>" /><input type="hidden" value="<?php echo $pic;?>" id="h_pic<?php echo $val['member_id'];?>" /><i class="fa fa-comment-o" aria-hidden="true"></i> </a></li>
                   			</ul>
            			</div>
						
                      <h3>Daily Match</h3>
                      <div class="row">
                      	<div class="col-md-6">
                      		<span class="prflNum clicktoviewimage" data-id="<?= $val['id'] ?>" style="cursor: pointer;"><i class="fa fa-eye"></i> <?=$val['total_pic']?> </span>
                      		<a href="<?= base_url('member/profile/'.base64_encode($val['id']))?>">
                      		<img class="mainPrfl-img mainPrfl-img1" src="<?= $val['picture'] ?>" alt="">
                      		</a>
                      	</div>
                      	<div class="col-md-6">
                      		<div class="details">
	                        <a href="<?= base_url('member/profile/'.base64_encode($val['id']))?>"><h2><a href="<?= base_url('member/profile/'.base64_encode($val['id']))?>"><?= $val['name']?></a></h2></a>
	                        <p><?= $val['age']?> • <?=isset($city_name[0]['name'])?$city_name[0]['name']:'N/A' ?><?= isset($state[0]['name'])?",".$state[0]['name']:'' ?></p>
	                        <ul>
	                        <li data-toggle="tooltip" title="Relationship">
	                          <!--<i class="fa fa-address-book" aria-hidden="true"></i>-->
	                          <img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/care.png" alt="Faith"> <?=$marital_status?>
	                          	
	                          </li>
	                          
	                      
	                         <li data-toggle="tooltip" title="Height">
	                          <!--<i class="fa fa-level-up" aria-hidden="true"></i> -->
	                          <img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/height.png" alt="Height"><?=$height_cm ?>
	                          </li>
	                          <li data-toggle="tooltip" title="Want Kids">
	                          	<!--<i class="fa fa-child" aria-hidden="true"></i>-->
	                           	<img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/smiling-baby.png" alt="Want Kids"><?= $want_kids ?>
	                           </li>
	                          <li data-toggle="tooltip" title="Have Kids">
	                          <!--<i class="fa fa-grav" aria-hidden="true"></i> -->
	                          <img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/kids-couple.png" alt="Have Kids"><?= $have_kids?>
	                          </li>
	                          <li data-toggle="tooltip" title="Faith">
	                          <!--<i class="fa fa-hand-paper-o" aria-hidden="true"></i>--> 
	                          <img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/care.png" alt="Faith"><?= $faith ?>
	                          </li>
	                          <li data-toggle="tooltip" title="Smoke">
	                         <!-- <i class="fa fa-fire" aria-hidden="true"></i> -->
	                          <img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/smoke.png" alt="Smoke"> <?=$smoking?></li>
	                          <li data-toggle="tooltip" title="Drink">
	                          <!--<i class="fa fa-glass" aria-hidden="true"></i> -->
	                          	<img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/drink.png" alt="Drink"><?=$drinking?>
	                          </li>
	                          <!--<li><img src="<?php //echo CSS_IMAGES_JS_BASE_URL;?>images/relation.png" alt="Relationship"><?=$marital_status?></li>
	                          <li><img src="<?php //echo CSS_IMAGES_JS_BASE_URL;?>images/height.png" alt="Height"><?=$height?>" (<?=$height_cm ?> cm)</li>
	                          <li><img src="<?php //echo CSS_IMAGES_JS_BASE_URL;?>images/kids.png" alt="Want Kids"><?= $want_kids ?></li>
	                          <li><img src="<?php //echo CSS_IMAGES_JS_BASE_URL;?>images/have-kids.png" alt="Have Kids"><?= $have_kids?></li>
	                          <li><img src="<?php //echo CSS_IMAGES_JS_BASE_URL;?>images/hand.png" alt="Faith"><?= $faith ?></li>
	                          <li><img src="<?php //echo CSS_IMAGES_JS_BASE_URL;?>images/cigar.png" alt="Smoke"> <?=$smoking?></li>
	                          <li><img src="<?php //echo CSS_IMAGES_JS_BASE_URL;?>images/drink.png" alt="Drink"><?=$drinking?></li>-->
	                        </ul>
	                      </div>
                      	</div>
                      </div>
                      
                      
                      <div class="clearfix"></div>
                      <p class="maintxtslid"><?=$val['about_me']?></p>
                    </div>
                  </div>
                 
				<?php } }else { ?>
				No Matches Found
				<?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div style="display: none;">
 	<ul class="gallery clearfix" id="p_photo">
 	</ul>
  </div>
  <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/vendor/owl.carousel.min.js"></script> 
  <script>
   function my_favaourite(member_id,obj)
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
 $(function(){
	 
  

$("#dashboardSecSlid").owlCarousel({
        autoplay: false,
        items : 1, 
		navText: true,
		dots: false, 
		loop:false,      
		nav : true,
		mouseDrag:true,
		lazyLoad : false,
		responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        900:{
            items:1
        },
        1000:{
            items:1
        }
    }
      });

$("#dailyMatcheSlid").owlCarousel({
        autoplay: false,
        items : 1, 
		navText: true,
		dots: false, 
		loop:false,      
		nav : true,
		mouseDrag:true,
		lazyLoad : false,
		responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        900:{
            items:1
        },
        1000:{
            items:1
        }
    }
      });
});

 $(document).on('click','.clicktoviewimage',function(){
  		var $this=$(this);
  		var id=$this.data('id');
  		if(id > 0){
  			$.ajax({
		      url : '<?php echo base_url("member/getMemberAllPhoto");?>',
		      type : 'POST',
		      data : {'member_id':id},
		      dataType : 'json',
		      success : function(response){
		      	if(response.error==0){
		      		$('#p_photo').html('');
		      		$.each((response.data),function(row,val){
		      			$('#p_photo').append('<a href="'+val.photo+'" rel="prettyPhoto[mixed]" title="image"><img class="img-responsive" src="'+val.photo+'" alt=""></a>')
		      		})
		      		prettyPhotoLoad();
		      	}else{
		      		messagealert('Error',response.msg,'error');
		      	}
		      }
		    })
  		}
  	})

  	function prettyPhotoLoad()
	{
	     // apply prettyPhoto plugin for video previews
	     $("a[rel^='prettyPhoto']").prettyPhoto();    
	     $('#p_photo').find('a').first().trigger('click');
	}
 	$(document).on('click','#openMessageForm',function(){
	    var to_member=$(this).data('member');
	    $('#to_member').val(to_member);
	    $('#myContactForm').modal('show');
	});

	$(function(){
	    $("#messageForm").validate({
	        rules: {
	            message:{
	                required: true
	            }
	        },
	        submitHandler: function(form) {
	          var data=$("form[name='messageForm']").serialize();
	          do_send_message(data);
	        }
	      });
	})


	function do_send_message(formData){
	    var url="<?php echo base_url('page/sendMessage/');?>";
	    $.ajax({
	      type:'POST',
	      url: url,
	      data:formData,
	      success:function(msg){ //alert(11);
	        window.location.reload();
	      },
	      error: function () {
	        messagealert('Error','Technical issue , Please try later','error');
	      }
	    });
	}
  </script>

  <div class="modal fade" id="myContactForm" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Send Message
                </h4>
            </div>
            <form class="form-horizontal" role="form" name="messageForm" id="messageForm" method="post" action="">
            <!-- Modal Body -->
            <div class="modal-body">
                
                
                      <div class="form-group">
                        <label class="col-sm-2 control-label"
                              for="inputPassword3" >Message</label>
                        <div class="col-sm-10">
                            <textarea name="message" id="message" class="form-control"></textarea>
                        </div>
                      </div>
                      <input type="hidden" name="to_member" id="to_member" value="">
                
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="submit" id="submit" class="btn btn-primary">
                    Send
                </button>
            </div>

            </form>

        </div>
    </div>
</div>