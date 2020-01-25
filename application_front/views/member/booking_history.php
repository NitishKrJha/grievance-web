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
        <?php $this->load->view('layout/member_left_menu')?>
        <div class="col-md-10">
          <?php //$this->load->view('layout/member_view')?>
          <div class="btm-section">
            <div class="machMakingSec" >
                <div class="row">
                  <div class="machMakingform" id="machMakingform">
                    <div class=" item" id="step2"><!--step Two-->
                     <h2> Booking List   <!--<a href="" class="btn-cmn"> Add </a>--></h2>
                     <!-- <form action="<?php echo base_url('member/dochangepassword') ?>" method="post" id="changePasswordForm">-->
                      
          					  <div class="row">
                        <table>
          							  <tr>
          								<th>Counselor Name</th>
          								<th>Booking Date & Time</th>
          								<th>Status</th>
                          </tr>
          							  
          							  <?php 
          							  
          								if($avalabedate){
          									foreach($avalabedate as $details){
          								  ?>
          							  <tr>
          								<td><a href="<?php echo base_url('counselor/profile/'.base64_encode($details['counselor_id'])); ?>" target="_blank"><?php echo ($details['member_name']!='')?$details['member_name']:'NA';?></a></td>
          								<td><?php echo date('d M y',strtotime($details['booking_date']));?></td>
          								<td>
                              <?php
                                if($details['assign']==1){
                                  echo 'Assigned';
                                  ?>
                                  <button type="button" class="btn btn-cmn cancelBooking" data-id="<?php echo $details['booking_id']; ?>" data-loading-text="Loading...">Cancel</button>
                                  <?php
                                }else{
                                  echo 'Waiting for admin approval';
                                }

                              ?>        
                          </td>
          							  </tr>
          							
          								<?php }
          								}else{ ?>
          								
          									<tr><td colspan="3">No Booking Request</td></tr>
          									
          								<?php } ?>
          							</table>
          					  </div>
                    </div><!--step Two End-->
                    <div class="nextPrvsSec">
                    <!-- <a class="showTipsBtn pull-right" href="match-making-step2.html#step2" >Continue</a> -->
                    <!-- <input type="submit" class="btn-cmn" value="Submit">-->
                    </div>
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
  
<script>
  $(document).on('click','.cancelBooking',function(){
    var $this=$(this);
    var id=$this.data('id');
    if(confirm("Do yoy want to cancel this appointment")){
      $this.button('loading');
      $.ajax({
        url : '<?php echo base_url("member/booking_cancel");?>',
        type : 'POST',
        data : {'id':id},
        dataType : 'json',
        success : function(msg){
          window.location.reload();
        }
      })
    }
  })
</script>