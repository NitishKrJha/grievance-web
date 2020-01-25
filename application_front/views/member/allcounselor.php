      
        <section class="main-container">
            <div class="container-fluid">
                <div class="row">
                    <?php $this->load->view('layout/member_left_menu')?>
                    <div class="col-md-7">
                    
                    <div class="row searchCounselor">
                    	<div class="col-md-12 col-sm-12"><h3>Search Counselor</h3></div>
                        <div class="col-md-12">
	                        <div id="counselling-search-input">
	                            <div class="row">
	                                <form action ="<?php echo base_url().'member/counselor'?>" method="post" name="search_counselor">
																	
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
											<select class="form-control" name="city_id" id="city_id">
												<option value="">-City-</option>								
											</select>
										</div>
										
										<div class="col-md-2 col-sm-3">
											<input type="text" name="zip" id="zip" class="form-control" placeholder="Search by Zip Code">
										</div>
										
										<div class="col-md-2 col-sm-12">
											<input type="submit" value="Search Counselor" class="showTipsBtn">
										</div>
									</form>		
	                            </div>
	                        </div>
                        </div>
					</div>
                    
                       <div class="row counselling counselorTimer">
					   
						<?php 
						if(!empty($counselor)){
						  foreach($counselor as $counselorDetails){
								
						   	$pic = isset($counselorDetails['picture'])?$counselorDetails['picture']:""; 

						    if($pic==''){
						   		$pic=css_images_js_base_url().'images/images.png';
						    }else{
						    	$pic_thumb=$counselorDetails['crop_profile_image'];
							   	if($pic_thumb!=''){
							   		$pic=$pic_thumb;
							   	}
						    }

						   $name= isset($counselorDetails['name'])&& $counselorDetails['name']!=''?$counselorDetails['name']:'Unknown';
						   $age = isset($counselorDetails['age'])&& $counselorDetails['age']>0?$counselorDetails['age']:'';
						   $member_id = base64_encode($counselorDetails['id']);
						   $memberId = rtrim($member_id, '=');
						
						   // $counselor_booking = get_where_limit('counselor_booking',array('counselor_id'=>$counselorDetails['id'],'member_id'=>$memberData['id'],'assign'=>1),1,'booking_id');
						   $display="none";
						   $counselor_booking = $counselorDetails['booking'];
						   if(count($counselor_booking) > 0){
						   	$actual_date=$this->functions->converToTz($counselor_booking['booking_date'],date_default_timezone_get(),$counselor_booking['timezone']);
						   	//echo $actual_date; die();

						   	$time1 = date('Y-m-d H:i:s',strtotime($actual_date));
							$time2 = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s')));
							//echo $time1."--".$time2; die();
							//echo date('Y-m-d H:i:s',time() + 3600)."---".$time1; die();
							if(date('Y-m-d H:i:s',time()) >=$time1){
								$display="block";
							}
						   }		 
							?>
                       		<div class="col-md-3 col-sm-4 matchMember" identifier="<?php echo $counselorDetails['id'];?>">
                            	
									<?php $member_id = base64_encode($counselorDetails['id']);
										$memberId = rtrim($member_id, '=');
									?>
									
								<div class="myMatch" identifier="<?php echo $counselorDetails['id'];?>">
                                	<figure><img src="<?php echo $pic; ?>" alt=""></figure>
									<div class="textSec textsec--mod">
										<?php
										   if($counselor_booking['picture']==""){
											   	$pic=css_images_js_base_url().'images/images.png';
										   }else{
										   	 $pic=$counselor_booking['picture'];
										   }
										?>
									 	<div style="display:<?php echo $display; ?>;" id="chat_id_<?php echo $counselorDetails['id'];?>">
									 
											<!-- <a href="javascript:void(0);" class="openChatBox" identifier="<?php echo $counselorDetails['id'];?>" style="width: 50px !important; margin:4px !important;">
												<i class="fa fa-comment-o" aria-hidden="true"></i> 
											</a> --> 
											<a href="javascript:void(0);" class="openVideoBox btn--modify" identifier="<?php echo $counselorDetails['id'];?>"><i class="fa fa-video-camera" aria-hidden="true"></i> </a>

											<a href="javascript:void(0);" class="btn--modify" identifier="<?php echo $counselor_booking['member_id'];?>"><input type="hidden" value="<?php echo $counselor_booking['member_name'];?>" id="h_name<?php echo $counselor_booking['member_id'];?>" /><input type="hidden" value="<?php echo $pic;?>" id="h_pic<?php echo $counselor_booking['member_id'];?>"/><i class="fa fa-comment-o" aria-hidden="true"></i> </a>
											<!-- <p> <a href="<?= base_url('member/profile/').$memberId; ?>" class="chatName"><?=$name ?> <?= $age!=''?','.$age:'' ?> </a></p> -->
										</div>	
									 
									
                       					<a class="prfilCls" href="<?php echo base_url('counselor/profile/'.$memberId) ?>" style="
											position:  relative;
											z-index: 2;
										"><p class="chatName"><?php echo $counselorDetails['name'].','.$counselorDetails['age']?></p>
										</a>
										
									
										<?php if($paidMember){?>
	                                    	<!-- <a class="bookNwBtn" href="#" onclick="book_counciler_popup(<?= $counselorDetails['id'] ?>,<?= $user_id?>)"> <i class="fa fa-calendar" aria-hidden="true"></i> Book Now</a> -->

	                                    	<a class="bookNwBtn" href="<?php echo base_url('member/book/councellor/'.base64_encode($counselorDetails['id'])); ?>"><i class="fa fa-calendar" aria-hidden="true"></i> Book Now</a>
										
										<?php } ?>
									
                                    </div>	
									<?php 
							 		$todayDate = date('H:i:s');
							 		$todayDate1 = date('Y-m-d');
							 		$nowTime = date('Y-m-d H:i:s');
									//echo $counselor_booking;
									if(!empty($counselor_booking)){
										$bookDate=$counselor_booking;
										$booking_date = $bookDate['booking_date'];
									 	$booking_date1 = date('Y-m-d',strtotime($actual_date));
									 	$time = date('H:i:s',strtotime($actual_date));
									 
									 	$nowToday = date('Y-m-d H:i:s',strtotime($actual_date));
									 	//echo $bookDate['counselor_id']; die();
									 	if($bookDate['counselor_id'] == $counselorDetails['id']){
										   //echo $nowTime." = ".$nowToday;  die();
									 		if($nowTime <= $nowToday && $bookDate['counselor_id'] == $counselorDetails['id'] ){
										
												$start_time = date('M d,Y H:i:s',strtotime($actual_date)); ?>	
									
											<input type="hidden" value="<?php echo isset($start_time)?$start_time:'';?>" name="current_time[]" id="current_time" identifier="<?php echo $counselorDetails['id'];?>">		
											<?php 	
									  		}	
										}									
										
									} 
									?>
									 <div id="demo2" identifier="<?php echo $counselorDetails['id'];?>"> </div>
									 <div id="demo3" identifier="<?php echo $counselorDetails['id'];?>"> </div>
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
				  <!-- Modal -->
                    <div class="modal fade" id="booknowpop" role="dialog">
						<div class="modal-dialog"> 
						  
						  <!-- Modal content-->
						  <div class="modal-content"> <img class="serchIcn" src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/NoImage.pngg" alt="">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title">Book A Counselor</h4>
							</div>
							<div class="modal-body">
							 <form class="subscribe-frm" name="counselor_booking" a method="post" id="counselor_booking">
							
							  <ul>
								<li>
								  <input type="text" class="form-control customFormcontrol" name="datetimepicker4" id ="datetimepicker4" placeholder="Choose start date and time">
								  <span class="custmIcn"> <i class="fa fa-calendar" aria-hidden="true"></i> </span> </li> 
							      <!-- <li>
								  <input type="text" class="form-control customFormcontrol" placeholder="Choose start date and time">
								  <span class="custmIcn"> <i class="fa fa-calendar" aria-hidden="true"></i> </span> </li>-->
							  </ul>
							  
							  <input type="hidden" value="<?php echo $memberData['id'];?>" name="counselor_id" id="counselor_id">
							  
							  <input type="submit" class="showTipsBtn" value="Book Now"> </div>
							</form>
						  </div>
						</div>
                  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>    
	  <!-- Modal -->
 <script>
function book_counciler_popup(councilor_id)
{
	 $('#counselor_id').val(councilor_id);
	 $('#booknowpop').modal('toggle');
}

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
  

  $(function () {
  $('#datetimepicker4').datetimepicker({   format : 'YYYY-MM-DD HH:mm' ,minDate:new Date()});
 	
  	$('#datetimepicker4').datetimepicker().on('dp.change', function(e){
	  if( !e.oldDate || !e.date.isSame(e.oldDate, 'day')){
	    $(this).data('DateTimePicker').hide();
	  }
	});	
  
  
  
});
// book counciler
$(function() {

  $("#counselor_booking").validate({
    rules: {
        datetimepicker4: {
  		  required: true
  	  }
    },
    submitHandler: function(form) {
      var data=$("form[name='counselor_booking']").serialize();
      do_subscribe(data,'Subscribe');
    }
  });
});


function do_subscribe(formData,type){
       
         var url="<?php echo base_url('counselor/booking_counselor/');?>";
       
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
</script>

<script>
// Set the date we're counting down to
   
$(document).ready(function(){
	
	var x = setInterval(function() {
	//var countDownDate = new Date("Jun 28,2018 18:53:19").getTime();
    $('input[name="current_time[]"]').each(function(){
		//alert(this.value);
		var countDownDate = new Date(this.value).getTime();
	    // Get todays date and time
	    var now = new Date().getTime();
		//alert(now);
		// Find the distance between now an the count down date
	    //var distance = countDownDate - now;
	    var distance = countDownDate - now;
	    //alert(countDownDate+" & "+now);
		// Time calculations for days, hours, minutes and seconds
	    var days = Math.floor(distance / (1000 * 60 * 60 * 12));
	    var hours = Math.floor((distance % (1000 * 60 * 60 * 12)) / (1000 * 60 * 60));
	    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    	//alert(days);
		// Output the result in an element with id="demo"
		//document.getElementById("demo2").innerHTML = days + " Day  " + hours + " Houre "
   		// + minutes + " Munite " + seconds + " Seconds ";
		//$(this).next().html(days + " Day  " + hours + " Houre "  + minutes + " minutes " + seconds + " Seconds ");
		$(this).next().html(days + " Day  " + hours + " Houre "  + minutes + " minutes " + seconds + " Seconds ");
    
   		// var link = document.getElementById("link").value;
	if (distance < 0) {
        clearInterval(x);
        //document.getElementById("demo3").innerHTML = "<a href='"+link+"' class='btn'> Click </a>";
	    //window.location.reload();
	    var id=$(this).attr('identifier');
	   	document.getElementById("chat_id_"+id).style.display = "block";
		//document.getElementById("chat_id").next().style.display = "block";
		// alert($(this).attr('identifier'));
		$(this).next().style.display = "block";
    }
	
   });
}, 1000);
        // Do your magic here

// Update the count down every 1 second

    //var countDownDate = new Date("Jun 28,2018 18:53:19").getTime(); 
	
	

});


/* window.addEventListener("load", function () {
    animation();
    setTimeout(otherOperation, 5000);
}, false);

function animation() {}
function otherOperation() {} */
</script>	
<!-- <div id="chatAppend"></div> -->