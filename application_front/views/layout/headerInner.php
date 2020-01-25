<?php
$user_id =  get_user_id();
$ctrl = $this->uri->segment(1);
$action = $this->uri->segment(2);
if($this->nsession->userdata('member_session_membertype')==1){
    $profile_link = base_url('member/profile');
}else{
    $profile_link = base_url('counselor/dashboard');
}
?>

<header class="main-header">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-2 col-sm-2">
        <div class="logo"> <a href="<?php echo base_url(); ?>"><img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/dashboard-logo.png" class="img-responsive" alt=""></a> </div>
      </div>
      <div class="col-lg-9 col-md-10 col-sm-10">
        <div class="navbar-custom-menu hidden-xs">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
            
            <?php if($memberData['member_type']== 1) {?>
            <li class="search-menu" > <a href="#" data-toggle="modal" data-target="#searchpopup" > <i class="fa fa-search" ></i> <span class="nav-text"> Search </span> </a> </li>
            <?php } ?>
            <?php if($memberData['member_type']== 1) {?>
            
            <!-- <li class="messages-menu"> <a href="#"> <i class="fa fa-comments"></i> <span class="nav-text">Messages</span> </a> </li>-->
            
            <?php } ?>
            <li class="interest-menu">
              <?php if($memberData['member_type']== 1) {?>
              <a href="<?php echo base_url('member/favourite'); ?>"> <i class="fa fa-heart"></i> <span class="nav-text">Hearted</span> </a>
              <?php } ?>
            </li>
            <?php if($memberData['member_type']== 1 || $memberData['member_type']== 2) {?>
            
                <?php
                if($this->nsession->userdata('member_session_membertype')==1){
                  ?>
                  <li class="messages-menu">
                    <a href="<?php echo base_url('member/message'); ?>">
                    <span class="count" id="message-chat-not-cnt">0</span>
                        <i class="fa fa-envelope-o"></i>
                        <span class="nav-text">Messages</span>
                    </a>
                  </li>
                  <?php
                }else if($this->nsession->userdata('member_session_membertype')==2){
                  ?>
                  <li class="messages-menu">
                    <a href="<?php echo base_url('counselor/message'); ?>">
                    <span class="count" id="message-chat-not-cnt">0</span>
                        <i class="fa fa-envelope-o"></i>
                        <span class="nav-text">Messages</span>
                    </a>
                  </li>
                  <?php
                }else {

                }
                ?>
                
            <?php } ?>
           <?php if($this->nsession->userdata('member_session_id')) {?>
            <li class="messages-menu dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="count" id="chat-not-cnt" >0</span>
                    <i class="fa fa fa-comments"></i>
                    <span class="nav-text">Notification</span>
                </a>
                <ul class="dropdown-menu dropdown-content" id="chat-notification-list">
               </ul>
            </li>
            <?php } ?>
            <!-- <li class="messages-menudropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li> -->
          
          </ul>
        </div>
        <div class="pull-right ">
          <!-- <div class="notificationWrap"> <span class="notification dropdown-toggle" data-toggle="dropdown"><span class="count" id="chat-not-cnt">0</span><i class="fa fa-comments" aria-hidden="true"></i></span>
            <ul class="dropdown-menu dropdown-content" id="chat-notification-list">
            




            </ul>
          </div> -->
          <?php   if($memberData['member_type']== 1) {?>
          <a href="<?php echo base_url('member/membershipplan')?>" class="btn btn-login">Upgrade</a>
          <?php } ?>
          <div class="btn-group profile-menu">
            <button type="button" class="btn btn-user dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user" aria-hidden="true"></i> <i class="fa fa-angle-down" aria-hidden="true"></i> </button>
            <ul class="dropdown-menu">
              <li><a href="<?php echo $profile_link;?>">Profile</a></li>
              <li><a href="<?php echo base_url('logout')?>">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal interests -->
  <div class="modal fade" id="interests" role="dialog">
    <div class="modal-dialog"> 
      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Interests</h4>
        </div>
        <div class="modal-body">
        <ul>
        <?php

											$member_interest = get_interest_member();
											
											//pr($member_interest);	
											$interest_arr=array();
											if(!empty($member_interest))
											{
												foreach($member_interest as $interestval)
												{
													$interest_arr[]=$interestval['interest_id'];
												}
											}
												
											$allinterest=get_interest();										 
											foreach ($allinterest as $details){?>
        <li class="interest_li <?php echo (in_array($details['id'],$interest_arr))?"checked_interest":"";?>" >
        <form class="subscribe-frm" name="counselor_booking1" a method="post" id="counselor_booking1">
          <input type="hidden" value="<?php echo $this->nsession->userdata('member_session_id');?>" name="member_id">
          <input type="checkbox" class="interest_chk" style="display:none;" value="<?php echo $details['id']; ?>" name="interest_chk[]" <?php echo (in_array($details['id'],$interest_arr))?"checked":"";?>>
          <?php echo $details['name']; ?>
          </li>
          <?php } ?>
          </ul>
          <input type="submit" class="showTipsBtn" value="Save">
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Modal --> 
</header>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> 
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> 
<!--<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/vendor/main.js"></script>--> 


<div class="modal fade" id="searchpopup" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <img class="serchIcn" src="<?php echo css_images_js_base_url(); ?>images/search-mach-icn.png" alt="">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Search for Your Matches</h4>
        </div>
        <div class="alert alert-danger fade in" id="alertDanger" style="display: none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <span></span>
        </div>
        <div class="modal-body">
            <form action="<?=base_url('member/search')?>" method="post" id="seacrhFormForMember">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group col-md-6">
                          <select class="form-control searchGroup" id="gender" name="gender">
                            <option value=''>Man Looking for a Woman</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                          </select>
                        </div>
                    
                        <div class="form-inline text-center  col-md-6">
                            <div class="form-group">
                              <label for="">Ages</label>
                              <select class="form-control searchGroup" name="from_age">
                                <option value="">select</option>
                                <?php for($i=18;$i<=100;$i++){?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                                <?php }  ?>
                              </select>
                              <label class="to" for="">to</label>
                              <select class="form-control searchGroup" name="to_age">
                                <option value="">select</option>
                                <?php for($i=18;$i<=100;$i++){?>
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
                          <select class="form-control searchGroup" id="" name="country">
                            <option value="">Country</option>
                            <?php 
                            $country = get_where('countries');
                            foreach($country as $k=>$val){ ?>
                            <option value="<?=$val['id']?>"><?=$val['name']?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <input type="number" class="form-control searchGroup" placeholder="Zipcode" name="pincode" min=0>
                        </div>
                    </div>
                  
                    <!-- pincode -->
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group col-md-6">
                          <select class="form-control searchGroup" id="language" name="language">
                           <?php $language = get_where('language',array('is_active'=>1));?>
                            <option value="">Select Language</option>
                            <?php foreach($language as $val){ ?>
                            <option value="<?= $val['id']?>"><?= $val['name']?></option>
                            <?php } ?>
                         </select>
                       </div>
                       
                        <div class="form-group col-md-6">
                           <select class="form-control searchGroup" id="education" name="education">
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
                          <select class="form-control valid searchGroup" id="have_kids" name="have_kids" aria-required="true" aria-invalid="false">
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
                            <select class="form-control searchGroup" id="smoking" name="smoking">
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
                            <select class="form-control searchGroup" id="drinking" name="drinking">
                                <option value="">Select Drinker</option>
                                <option value="1" <?php if(isset($params['drinking']) && $params['drinking']=='1') echo 'selected';?>>Non-Drinker</option>
                                <option value="2" <?php if(isset($params['drinking']) && $params['drinking']=='2') echo 'selected';?>>Social-Drinker</option>
                                <option value="3" <?php if(isset($params['drinking']) && $params['drinking']=='3') echo 'selected';?>>Heavy-Drinker</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                          <select class="form-control valid searchGroup" id="body_type" name="body_type" aria-required="true" aria-invalid="false">
                          <?php $body_type = get_where('body_type',array('is_active'=>1));?>
                                <option value="">Select Body Type</option>
                                <?php foreach($body_type as $val){ ?>
                                <option value="<?= $val['id']?>" ><?= $val['type']?></option>
                               <?php } ?> 
                          </select>
                        </div>
                    </div>
                     <!-- body style-->
                    <div class="col-md-12 col-sm-12">
                      <div class="form-group col-md-6">
                        <input type="text" class="form-control searchGroup" placeholder="height (ft)" name="height">
                      </div>
                      <div class="form-group col-md-6">
                          <input type="text" class="form-control searchGroup" placeholder="height (inches)" name="height_inches">
                          
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                          <div class="form-group col-md-6">
                              <select class="form-control valid searchGroup" id="eye" name="eye" aria-required="true" aria-invalid="false">
                              <?php $eye_type = get_where('eye_type',array('is_active'=>1));?>
                                <option value="">Select Eye Type</option>
                                <?php foreach($eye_type as $val){?>
                                <option value="<?=$val['id']?>" ><?= $val['type'] ?></option>
                                <?php } ?>
                             </select>
                              
                          </div>
                          <div class="form-group col-md-6">
                             <select class="form-control valid searchGroup" id="hair" name="hair" aria-required="true" aria-invalid="false">
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
<script>
$(document).ready(function(){
	$(".interest_li").click(function(){
		var interest_li=$(this).val();
		//alert($(this).find(".interest_chk").prop("checked"));
		if($(this).find(".interest_chk").prop("checked") == true)
		{
			$(this).find(".interest_chk").attr("checked",false);
			$(this).removeClass("checked_interest");
			
		}
		else
		{
			$(this).find(".interest_chk").attr("checked",true);
			$(this).addClass("checked_interest");
		}
		
	})
	
})
</script> 
<script type="text/javascript">
$(function() {

  $("#counselor_booking1").validate({
	 
    rules: {
        interest_chk: {
  		  required: true
  	  }
    },
    submitHandler: function(form) {
      var data=$("form[name='counselor_booking1']").serialize();
      do_subscribe1(data,'Subscribe');
    }
  });
});


function do_subscribe1(formData,type){
       
         var url="<?php echo base_url('member/interest/');?>";
       
		// var btnname='make'+type+'Register';
	   
        $.ajax({
          type:'POST',
          url: url,
          data:formData,
        
          success:function(msg){ //alert(11);
           
            var response=$.parseJSON(msg);
		
            if(response){ 
              
             $('#booknowpop').modal('toggle');
            
              /*messagealert('Success','We have sent a verification email to your mail id, please check your email to active account.','success');*/
			  window.location.reload();
            }else{
				 //$('#booknowpop').modal('toggle');
                //messagealert('Error','You are already booked','error');
				window.location.reload();
			}
          },
          error: function () {
            
            messagealert('Error','Technical issue , Please try later','error');
          }
        });
      }

      function changeMessageCount(){
        $.ajax({
          type:'POST',
          url: "<?php echo base_url('page/countMessage'); ?>",
          data:{},
          success:function(msg){
            console.log(msg);
            $('#message-chat-not-cnt').html(msg);
          }
        });
      }

      $(function(){
        saveTimeZone();
        changeMessageCount();
      })

      $(function(){
        $("#seacrhFormForMember").validate({
        rules: {
            gender:{
                require_from_group: [1, ".searchGroup"]
            },
            to_age:{
                require_from_group: [1, ".searchGroup"]
            },
            country:{
                require_from_group: [1, ".searchGroup"]
            },
            pincode:{
                require_from_group: [1, ".searchGroup"]
            },
            language:{
                require_from_group: [1, ".searchGroup"]
            },
            education:{
                require_from_group: [1, ".searchGroup"]
            },
            have_kids:{
                require_from_group: [1, ".searchGroup"]
            },
            smoking:{
                require_from_group: [1, ".searchGroup"]
            },
            drinking:{
                require_from_group: [1, ".searchGroup"]
            },
            height:{
                require_from_group: [1, ".searchGroup"]
            },
            height_inches:{
                require_from_group: [1, ".searchGroup"]
            },
            body_type:{
                require_from_group: [1, ".searchGroup"]
            },
            eye:{
                require_from_group: [1, ".searchGroup"]
            },
            hair:{
                require_from_group: [1, ".searchGroup"]
            }
        },
        submitHandler: function(form) {
          form.submit();
        }
      });
    })

      function saveTimeZone(){
        var tz=Intl.DateTimeFormat().resolvedOptions().timeZone;
        $.ajax({
          type:'POST',
          url: "<?php echo base_url('page/saveTimeZone'); ?>",
          data:{'tz':tz},
          success:function(msg){
          }
        });
      }
	</script> 
