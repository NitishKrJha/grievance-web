
<link href="<?php echo CSS_IMAGES_JS_BASE_URL;?>fullCalender/fullcalendar.css" rel="stylesheet">
        <section class="main-container">
            <div class="container-fluid">
                <div class="row">
                   <div class="row"><?php $this->load->view('layout/counselorLeftMenu')?>
                    <div class="col-md-10">
                       <div class="btm-section">
					   <!-- full calender-->
						 <div class="row">
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
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/vendor/jquery.min.js"></script>
    <!-- jquery-migrate js -->
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jquery-migrate-1.2.1.js"></script>
    <!-- calendar js -->
     <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>fullCalender/moment.min.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>fullCalender/fullcalendar.min.js"></script>
    <!-- bootstrap js -->
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/bootstrap.min.js"></script>
     <!-- scrollbar js -->
	<script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jquery.scrollbar.min.js"></script> 
    <!-- main js -->
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/jquery.slicknav.min.js"></script>
    <script src="<?php echo CSS_IMAGES_JS_BASE_URL;?>js/main.js"></script>
    
    
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
			 <?php if(count($getEventDate)>0){
			  foreach($getEventDate as $val){
				  if(date('Y-m-d',strtotime($val['booking_date'])) >= date('Y-m-d')){
				  $time = date('H:i:s',strtotime($val['booking_date']));
				  $date = date('Y-m-d',strtotime($val['booking_date'])).'T'.$time;
			  ?>
				{
					title: 'Booked By <?= $val['name']?>',
					start: '<?=$date?>'
				},
			 <?php } } } if(!empty($counselor_available)){ foreach($counselor_available as $vv){ $start_date =$vv['avalable_date'].'T'.$vv['start_time']; $end_time =  $vv['avalable_date'].'T'.$vv['end_time'];  ?>
			    {
					title: 'available time',
					start: '<?=$start_date?>',
					end: '<?=$end_time?>'
				},
			  <?php }} ?>
			]
		});
		
	});
    </script>
</body>

</html>