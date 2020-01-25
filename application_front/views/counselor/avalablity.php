<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
<section class="main-container">
    <div class="container-fluid">
      <div class="row">
        <?php $this->load->view('layout/counselorLeftMenu')?>
        <div class="col-md-10">
          <?php //$this->load->view('layout/member_view')?>
          <div class="btm-section">
            <div class="machMakingSec" >
                <div class="row">
                  <div class="machMakingform" id="machMakingform">
                    <div class=" item" id="step2"><!--step Two-->
                     <h2> Availability Date   <!--<a href="" class="btn-cmn"> Add </a>-->
					 
					 <a class="btn-cmn" data-toggle="modal" data-target="#booknowpop" href="#" data-backdrop="static" data-keyboard="false"> <i class="fa fa-calendar" aria-hidden="true"></i> Add </a>
					 
					 </h2>
                     <!-- <form action="<?php echo base_url('member/dochangepassword') ?>" method="post" id="changePasswordForm">-->
                      
					  <div class="row">
                       
					   <table>
							  <tr>
								<th>Available Date</th>
								<th>Available Time (24 Hr Format)</th>
								<th>Create Date</th>
								<th>Time Zone</th>
								<th>Action</th>
							  </tr>
							  
							  <?php 
							  
								if($avalabedate){
									foreach($avalabedate as $details){
								  ?>
							  <tr>
								<td><?php echo date('d M y',strtotime($details['avalable_date']));?></td>
								<td><?php echo $details['start_time']." - ".$details['end_time'];?></td>
								<td><?php echo date('d M y',strtotime($details['create_date']));?></td>
								<td><?php echo $details['timezone']; ?></td>
								<td> <a onclick="return confirm('Are you sure.You want to delete?')" href="<?php echo base_url('counselor/date_delete/'.$details['id']) ?>" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
							  </tr>
							
								<?php }
								}else{ ?>
								
									No Data Found.
									
								<?php } ?>
							
						</table>
					   
					   
                      </div>
                    </div><!--step Two End-->
                    <div class="nextPrvsSec">
                  <!-- <a class="showTipsBtn pull-right" href="match-making-step2.html#step2" >Continue</a> -->
               <!-- <input type="submit" class="btn-cmn" value="Submit">-->
                </div>
                  </form>
                  </div>
                </div>
            </div>
          </div>
        </div>
		
		<!-- Modal -->
                  <div class="modal fade" id="booknowpop" role="dialog">
                    <div class="modal-dialog"> 
                      
                      <!-- Modal content-->
                      <div class="modal-content"> <img class="serchIcn" src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/NoImage.pngg" alt="">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Add Date</h4>
                        </div>
                        <div class="modal-body">
						 <form class="subscribe-frm" name="counselor_booking" a method="post" id="counselor_booking">
						
                          <ul>
                            <li>
                              <input type="text" class="form-control customFormcontrol" name="datetimepicker4" id ="datetimepicker4" placeholder="Choose start date ">
                              <span class="custmIcn"> <i class="fa fa-calendar" aria-hidden="true"></i> </span>
                            </li> 
                          </ul>

                          <ul>
                          	<li style="display: none;">
                          		<?php $timezone=$this->functions->getTimeZoneList(); ?>
                          		<select class="form-control customFormcontrol" name="timezone11">
                          			<option value="">Select Your Time Zone</option>
                          			<?php
                          				if(count($timezone) > 0){
                          					foreach ($timezone as $key => $value) {
		                          				echo '<option value="'.$key.'">'.$value.'</option>';
		                          			}
                          				}
                          			?>
                          		</select>
                          	</li>
                          </ul>
						  <input type="hidden" name="timezone" value="<?php echo $myTimezone; ?>">
						  	<!-- start time-->
						  	<ul>
                            	<li>
                              		<input type="text" class="form-control customFormcontrol" name="form_time" id ="form_time" placeholder="Choose time">
                            	</li>
                          	</ul>
						    <!-- end time-->
							<!-- <ul>
	                            <li>
	                              <input type="text" class="form-control customFormcontrol" name="end_time" id ="end_time" placeholder="Choose end  time">
	                            </li>
                          	</ul> -->
						  	
						  	<input type="hidden" value="<?php echo $memberData['id'];?>" name="counselor_id" id="counselor_id">
						  	<input type="submit" class="showTipsBtn" value=" Submit "> </div>
						</form>
                      </div>
                    </div>
                  </div>
       <!-- Modal -->
		
		
		
		
            <?php //echo $this->load->view('layout/memberMyContact'); ?>
          <?php //echo $this->load->view('layout/memberChatRequest'); ?>
      </div>
    </div>
  </section>
  
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script> 
<script>
  $(function() {
  	var tz=Intl.DateTimeFormat().resolvedOptions().timeZone;
  	$('input[name="timezone"]').val(tz);
  $("#counselor_booking").validate({
      rules: {
        datetimepicker4: {
  		  required: true
  	  },
	   form_time: {
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
       
		var url="<?php echo base_url('counselor/add_date/');?>";
	  
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
	
	$(function () {
	  $('#datetimepicker4').datetimepicker({format: 'MM/DD/YYYY',minDate: new Date()});
	  $('#form_time').datetimepicker({format: 'hh:mm a'});
	  $('#end_time').datetimepicker({format: 'hh:mm a'});
	  
	});
 
</script>