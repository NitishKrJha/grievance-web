
<link href="<?php echo CSS_IMAGES_JS_BASE_URL;?>fullCalender/fullcalendar.css" rel="stylesheet">
        <section class="main-container">
            <div class="container-fluid">
                <div class="row">
                   <div class="row"><?php $this->load->view('layout/member_left_menu')?>
                    <div class="col-md-10">
                       <div class="btm-section">
					   <!-- full calender-->
						 <div class="row">
						 	<?php /* $timezoneList=$this->functions->getTimeZoneList(); ?>
                      		<h1><select class="form-control customFormcontrol" id="selectTimeZone">
                      			<option value="">Select TimeZone</option>
                      			<?php
                      				if(count($timezoneList) > 0){
                      					foreach ($timezoneList as $key => $value) {
                      						$selected='';
                      						if($timezone==$key){
                      							$selected='selected="selected"';
                      						}
	                          				echo '<option value="'.base64_encode($key).'" '.$selected.'>'.$value.'</option>';
	                          			}
                      				}
                      			?>
                      		</select></h1> <?php */ ?>
							<div id="calendar"></div>
						  </div>
						  <!-- full calender -->
							<div id="fullCalModal" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
											<h4 id="modalTitle" class="modal-title"></h4>
										</div>
										<div id="modalBody" class="modal-body"></div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
						</div>
                    
                    </div>
                    
					
                </div>
            </div>

        </section>

    </div>

    <!-- jquery latest version -->
    <!-- jquery-migrate js -->
    <!-- calendar js -->
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>fullCalender/fullcalendar.min.js"></script>
    <!-- bootstrap js -->
     <!-- scrollbar js -->
    <!-- main js -->
    
    
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: '<?= date('Y-m-d')?>',
			defaultView: 'month',
			editable: false,

			events: [
			 <?php  if(!empty($counselor_available)){ foreach($counselor_available as $vv){ 
			 	$start_date=$this->functions->converToTz($vv['avalable_date'].'T'.$vv['start_time'],$vv['timezone'],$timezone);
			 	$end_time=$this->functions->converToTz($vv['avalable_date'].'T'.$vv['end_time'],$vv['timezone'],$timezone);
			 	$timezones=$vv['timezone'];
			 	$cnt=$vv['cnt'];
			 	// $start_date =$vv['avalable_date'].'T'.$vv['start_time']; $end_time =  $vv['avalable_date'].'T'.$vv['end_time']; $timezone=$vv['timezone'];  ?>
			    {
					title: 'Available',
					start: '<?=$start_date?>',
					end: '<?=$end_time?>',
					color  : '<?php echo ($cnt > 0)?"gray":"#378006"; ?>'
				},
			  <?php }} ?>
			],
			dayClick: function(date, jsEvent, view) {

		    	//alert('Clicked on: ' + date.format());
				//alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
				//alert('Current view: ' + view.name);

			    

			},
		  	eventClick: function(calEvent, jsEvent, view) {
		  		if(calEvent.color=="gray"){
		  			messagealert('Error','This is already booked','error');
		  		}else{
		  			$('#datetimepicker4').val(calEvent.start.format("MM/DD/YYYY h:mm A"));
			    	$('#booknowpop').modal('show');
		  		}
		  		
		  	}
		});

        $("#counselor_booking").validate({
		    rules: {
		        datetimepicker4: {
		  		  required: true
		  	    },
		  	    timezone: {
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
              	//$('#booknowpop').modal('toggle');
              	window.location.reload();
            }else{
      				window.location.reload();
      			}
          },
          error: function () {
            messagealert('Error','Technical issue , Please try later','error');
          }
        });
    }
	
	$(function () {
	  $('#datetimepicker4').datetimepicker();
	});

	$(document).on('change','#selectTimeZone',function(){
		var $this=$(this);
		var val=$this.val();
		if(val!=''){
			var url="<?php echo base_url('member/book/councellor/'.base64_encode($id)); ?>/"+val;
			window.location.href=url;
		}
	});
    </script>
</body>
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
                  <input type="text" class="form-control customFormcontrol" name="datetimepicker4" id ="datetimepicker4" placeholder="Choose start date and time" readonly="readonly">
                  <span class="custmIcn"> <i class="fa fa-calendar" aria-hidden="true"></i> </span> 
                </li> 
              </ul>
                <input type="hidden" name="timezone" value="<?php echo $timezone; ?>">
                <input type="hidden" value="<?php echo $id;?>" name="counselor_id" id="counselor_id">
                <input type="submit" class="showTipsBtn" value="Book Now"> 
            </form>    
          </div>
        </div>
      </div>
    </div>
<!-- Modal -->
</html>