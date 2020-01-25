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
                     <h2> Video Call List   <!--<a href="" class="btn-cmn"> Add </a>--></h2>
                     <!-- <form action="<?php echo base_url('member/dochangepassword') ?>" method="post" id="changePasswordForm">-->
                      
          				<div class="row">
                            <table>
          							<tr>
          								<th>Name</th>
          								<th>Total Time</th>
          								<th>Start DateTime</th>
          								<th>Status</th>
                          			</tr>
          							  
          							  <?php 
          							  
      								if(!empty($recordset)){
      									foreach($recordset as $details){
      								  ?>
          							  <tr>
          								<td><?php echo ($details['from_name']!='')?$details['from_name']:'unknown'; ?></td>
          								<td><?php echo $details['total_time']." minutes"; ?></td>
          								<td><?php echo date('d-M-y H:i:s',strtotime($details['created_date']));?></td>
          								<td>
          									<?php if($details['status']==0){
          										echo 'Not response By user';
          									}else if($details['status']==1){
          										echo 'On Progress';
          									}else{
          										echo 'Completed';
          										} ?>
          								</td>
          							  </tr>
          							
          								<?php }
          								}else{ ?>
          								
          									<tr><td colspan="4">No Call Record</td></tr>
          									
          								<?php } ?>
          							</table>
          							<?php echo $this->pagination->create_links();?>
          					  </div>
                    </div><!--step Two End-->
                    
                  </div>
                </div>
            </div>
          </div>
        </div>
		
		   
		
		
		
		
            <?php //echo $this->load->view('layout/memberMyContact'); ?>
          <?php //echo $this->load->view('layout/memberChatRequest'); ?>
      </div>
    </div>
  </section>