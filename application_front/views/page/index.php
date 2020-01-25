<div class="top-wrap">
    <div class="container">
        <div class="row">
            <?php if($this->nsession->userdata('member_session_id')==""){?>
            <div class="col-md-5 col-sm-6 pull-right">
                <div class="create_account">
                    <a class="backBtn back_type_selection" href="javascript:void(0);" id="bck-btn" style="display: none;"><i class="fa fa-chevron-circle-left"></i></a>
                    <h3 class="titleaccount">Create your Account</h3>
                    <p>Signing up for Seeking, Counseling and getting Tips is fast and free.</p>

                    <div class="stepwizard">
                        <ul class="stepwizard-row">
                            <li class="stepwizard-step">
                                <div class="stepspace"><span class="step-circle spanStep2 current">1</span></div>
                                <p class="bold">Step</p>
                            </li>
                            <li class="stepwizard-step">
                                <div class="stepspace"><span class="step-circle spanStep2">2</span></div>
                                <p class="bold">Step</p>
                            </li>
                            <li class="stepwizard-step">
                                <div class="stepspace"><span class="step-circle spanStep3">3</span></div>
                                <p class="bold">Step</p>
                            </li>
                            <li class="stepwizard-step">
                                <div class="stepspace"><span class="step-circle spanStep4">4</span></div>
                                <p class="bold">Step</p>
                            </li>
                        </ul>
                    </div>
                    <div class="selectiontab ">
                        <form class="form-inline" id="reg_form" method="post" action="<?php echo base_url('member/doMemberReg'); ?>">
                            <div id="iamDiv" class="hideAll" data-span="spanStep2">
                                <div class="form-group">
                                    <label for="exampleInputName2">I'm a</label>
                                </div>
                                <button type="button" data-manwoman="1" data-currentdiv="iamDiv" data-nextdiv="whosDiv" data-nextspanclass="spanStep2" class="btn btn-cmn type_selection">Man</button>
                                <button type="button" data-manwoman="2" data-currentdiv="iamDiv" data-nextdiv="whosDiv" data-nextspanclass="spanStep2" class="btn btn-cmn type_selection">Woman</button>
                            </div>
                            <div id="whosDiv" class="hideAll" data-span="spanStep2" style="display: none">
                                <div class="form-group">
                                    <label for="exampleInputName2">Marital Status</label>
                                </div>
                                <button type="button" data-maritial_status="1" data-currentdiv="whosDiv" data-nextspanclass="spanStep3" data-nextdiv="interestedDiv" class="btn btn-cmn type_selection">Single</button>
                                <button type="button" data-maritial_status="2" data-currentdiv="whosDiv" data-nextspanclass="spanStep3" data-nextdiv="interestedDiv" class="btn btn-cmn type_selection">Separated</button>
                                <button type="button" data-maritial_status="3" data-currentdiv="whosDiv" data-nextspanclass="spanStep3" data-nextdiv="interestedDiv" class="btn btn-cmn type_selection">Divorced</button>
                            </div>
                            <div id="interestedDiv" class="hideAll" data-span="spanStep3" style="display: none">
                                <div class="form-group">
                                    <label for="exampleInputName2">Interested in</label>
                                </div>
                                <button type="button" data-interested_in="2" data-currentdiv="interestedDiv" data-nextdiv="emailDiv" data-nextspanclass="spanStep4"  class="btn btn-cmn type_selection">Female</button>
                                <button type="button" data-interested_in="1" data-currentdiv="interestedDiv" data-nextdiv="emailDiv" data-nextspanclass="spanStep4"  class="btn btn-cmn type_selection">Male</button>
                                <button type="button" data-interested_in="3" data-currentdiv="interestedDiv" data-nextdiv="emailDiv" data-nextspanclass="spanStep4"  class="btn btn-cmn type_selection">Both</button>
                            </div>
                            <input type="hidden" name="man_woman" id="man_woman"/>
                            <input type="hidden" name="maritial_status" id="maritial_status"/>
                            <input type="hidden" name="interested_in" id="interested_in"/>
                            <div id="emailDiv" class="hideAll" data-span="spanStep4" style="display: none">
                                <div class="col-md-12">
                                    <div class="form-group col-md-5">
                                        <label for="exampleInputName2">Email:</label>
                                    </div>
									
									<!--<div class="col-md-6">
                                      <input type="text" name="interested_in" id="interested_in" class="form-control">
                                    </div>-->
									
                                    <div class="col-md-6">
                                        <input type="email" id="emailId" name="email" class="form-control" placeholder="Email ID" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-5">
                                        <label for="exampleInputName2">Password:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-5">
                                        <label for="exampleInputName2">Confirm Password:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" name="password_confirm" class="form-control"  placeholder="Confirm Password">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-5">
                                        <label for="exampleInputName2">Captcha:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <span id="captImg"><?php echo $captchaImg; ?> </span>
                                        <a href="javascript:void(0);" class="refreshCaptcha" ><img src="<?php echo base_url().'public/images/refresh.png'; ?>"/></a>
                                        <input type="text" class="form-control captcha_clss" id="captcha_code" name="captcha_code" placeholder="Captcha">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p>By continuing you agree to MyMissingRib's <a target="_blank" href="<?php echo base_url('terms-conditions'); ?>">Terms</a> and <a href="<?php echo base_url('privacy-policy'); ?>" target="_blank">Privacy Policy</a>.</p>
                                </div>
                                <button type="submit" class="btn-cmn" value="Submit">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col-md-6 col-sm-6">
                <div class="welcometxt">
                   <?php echo html_entity_decode($cmsContentt['content']); ?>
                </div>
            </div>

        </div>
    </div>
</div>

</div>
<input type="hidden" id="parentid" value="">
<input type="hidden" id="parentspan" value="">
<!-- match list -->
<section class="testi_wrap">
    <div class="container">

                <div id="profile-carousel" class="owl-carousel owl-theme mar-top">

                <?php 
                    if($testimonial){
                    $i=0;   
                    foreach($futuremember as $rows=>$vals){
                        $pic=css_images_js_base_url().'images/images.png';
                         if($vals['picture']!=''){
                          $pic=$vals['picture'];
                         }
                        ?>
                        <div class="item <?php if($i==0){ echo 'active';}?>">
                        <div class="profile-box profile__box--mod">
                        <!-- <div class="profile-thumb" style="background-image: url(<?php echo $pic;?>);"></div> -->
                                
                                <div class="profile-details" onclick="window.location.href='<?= base_url('member/profile/'.base64_encode($vals['id']))?>'">
                                <div class="profile-thumb-round" style="background-image: url(<?php echo $pic;?>);"></div>
                                <a href="<?= base_url('member/profile/'.base64_encode($vals['id']))?>">
                                <div class="profile-title"><?php echo isset($vals['member_name'])?$vals['member_name']:'';?>, <?php echo isset($vals['age'])?$vals['age']:'';?></div>
                                <span class="status"> <?php if($vals['maritial_status'] == 1){?>
                                         Single
                                        <?php } else if($vals['maritial_status'] ==2){?>
                                         Married
                                        <?php } else{?>
                                         Divorced
                                        <?php } ?></span>
                                        <p class="profile-address"><?php echo $vals['country_name'];?>, <?php echo $vals['state_name'];?></p>
                                       
                                     
                                    </div>
                                    </a>
                               
                            </div>
                        </div>
                
            <?php 
            $i++;
            } 
                    
                } ?>





                  

        
    </div>
</section>

<!-- Info Wrap -->
<section class="info-bg mt-0">
    <div class="container">
        <div class="row">
            <?php echo html_entity_decode($cmsContent['content']); ?>
        </div>
    </div>
</section>

<!-- Testimonials wrap -->
<section class="testi_wrap">
    <div class="container">
        <h2 class="testi-title">Testimonials</h2>
        <!-- <div class="carousel slide" data-ride="carousel" id="quote-carousel"> -->
            <!-- Bottom Carousel Indicators -->
            <!-- <ol class="carousel-indicators">
               
			   <?php 
					if($testimonial){
					$j=0;	
					foreach($testimonial as $testimonialDetails){						
				?>
			   
				   <li data-target="#quote-carousel" data-slide-to="<?php echo $j;?>" class="<?php if($j==0){ echo 'active';}?>"><img class="img-responsive " src="<?php echo file_upload_base_url();?>testimonial/<?php echo $testimonialDetails['image']?>" alt="">
				   </li>
				<?php
					$j++;
					} 
				} ?>
            </ol> -->
            <!-- Carousel Slides / Quotes -->
            <!-- <div class="carousel-inner text-center">
               <?php 
					if($testimonial){
					$i=0;	
					foreach($testimonial as $testimonialDetails){?>
                <div class="item <?php if($i==0){ echo 'active';}?>">
                    <blockquote>
                        <div class="row">
                            <div class="col-sm-4">

                                <p class="quote_txt"> <?php echo isset($testimonialDetails['description'])?$testimonialDetails['description']:'';?></p>
                                <p class="quote_author"><?php echo isset($testimonialDetails['fullname'])?$testimonialDetails['fullname']:'';?><br><?php echo isset($testimonialDetails['address'])?$testimonialDetails['address']:'';?></p>
                            </div>
                        </div>
                    </blockquote>
                </div>
                
			<?php 
			$i++;
			} 
					
				} ?>
			   
				
            </div> -->
            <!-- Carousel Buttons Next/Prev -->
            <!-- <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
            <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-angle-right" aria-hidden="true"></i></a> -->
        <!-- </div> -->
        <div id="testi-carousel" class="owl-carousel owl-theme mar-top">
        <?php 
					if($testimonial){
					
					foreach($testimonial as $testimonialDetails){?>
                <div class="item">
                <div class="testiBlock">
                               <p>
                               <!-- <?php echo isset($testimonialDetails['description'])?$testimonialDetails['description']:'';?> -->
                               Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                               </p>
                               <hr>
                               <div class="testiImg">
                                   <img src="<?php echo file_upload_base_url();?>testimonial/<?php echo $testimonialDetails['image']?>" alt="">
                               </div>
                               <h3><?php echo isset($testimonialDetails['fullname'])?$testimonialDetails['fullname']:'';?><br><?php echo isset($testimonialDetails['address'])?$testimonialDetails['address']:'';?></h3>
                              
                           </div>
                   
                </div>
                
			<?php 
			
			} 
					
				} ?>
               
        </div>
    </div>
</section>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
  <!--<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/vendor/main.js"></script>-->
	<script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL; ?>js/vendor/pnotify/dist/pnotify.nonblock.js"></script>
<script>
    $(".type_selection").on('click',function(){
        var nextdiv         = $(this).data('nextdiv');
        var currentdiv      = $(this).data('currentdiv');
        var nextspanclass   = $(this).data('nextspanclass');
        var parentid=$(this).parent().attr('id');
        $('#parentid').val(parentid);
        $('#parentspan').val($(this).parent().attr('data-span'));

        $("."+nextspanclass).addClass('current');
        $("#"+currentdiv).hide();
        $("#"+nextdiv).show();

		var interested_in ='';
		var maritial_status ='';
		var manwoman ='';
		
        switch (currentdiv){
            case 'iamDiv':
                $(".back_type_selection").show();
                var manwoman                   = $(this).data('manwoman');
                $("#man_woman").val(manwoman);
                break;
            case 'whosDiv':
                $(".back_type_selection").show();
                var maritial_status    = $(this).data('maritial_status');
                $("#maritial_status").val(maritial_status);
                break;
            case 'interestedDiv':
                $(".back_type_selection").show();
                var interested_in              = $(this).data('interested_in');
                $("#interested_in").val(interested_in);				
				//alert(interested_in);				
                break;
        }
    });

    $(".back_type_selection").on('click',function(){
        var parentid=$('#parentid').val();
        var parentspan=$('#parentspan').val();
        console.log(parentid+" : "+parentspan);
        $('.hideAll').hide();
        $('#'+parentid).show();
        $('.'+parentspan).addClass('current');
        switch (parentid){
            case 'iamDiv':
                $(".back_type_selection").hide();
                $('#parentid').val("iamDiv");
                $('#parentspan').val("spanStep2");
                break;
            case 'whosDiv':
                $(".back_type_selection").show();
                $('#parentid').val("iamDiv");
                $('#parentspan').val("spanStep2");
                break;
            case 'interestedDiv':
                $(".back_type_selection").show();
                $('#parentid').val("whosDiv");
                $('#parentspan').val("spanStep3");
                break;
        }
    });

    $(document).ready(function(){
        $.validator.addMethod("customemail",
            function(value, element) {
                return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
            },
            "Sorry, I've enabled very strict email validation"
        );
        $("#reg_form").validate({
            // Specify validation rules
            rules: {
                email: {
                    required: true,
                    email: true,
                    customemail:true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirm: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },
                captcha_code:{
                    required: true
                }
            },
            // Specify validation error messages
            messages: {
                email: "Please enter a valid email address.",
                password: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 6 characters long."
                },
                password_confirm:{
                    required: "Please provide confirm password.",
                    equalTo:"Confirm password and password has to same."
                },
                captcha_code:{
                    required: "Please provide captcha code.",
                }
            },
            submitHandler: function(form) {
                var captcha_code = $("#captcha_code").val();
                var emailID     = $("#emailId").val();
                $.ajax({
                    type:'POST',
                    url:'<?php echo base_url('page/isValidCaptcha')?>',
                    dataType:'Json',
                    data:{captcha_code:captcha_code},
                    success:function(data){
                        console.log(data);
                        if(data.error==1){
                            alert('Enter Valid Captcha Code.!');
                            return false;
                        }else{
                            $.ajax({
                                type:'POST',
                                url:'<?php echo base_url('member/emailExist')?>',
                                dataType:'Json',
                                data:{email:emailID},
                                success:function(data){
                                    //console.log(data);
                                    if(data.error==1){
                                        alert('Email address already exist.');
                                        return false;
                                    }else{
                                        form.submit();
                                    }
                                }
                            });
                        }
                    }
                });
            }
        });
    });
    $('.refreshCaptcha').on('click', function(){
        $.get('<?php echo base_url().'page/refresh'; ?>', function(data){
            $('#captImg').html(data);
        });
    });
</script>