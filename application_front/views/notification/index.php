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
        <?php
          if($this->nsession->userdata('member_session_membertype')==1){
           $this->load->view('layout/member_left_menu');
          }else{
           $this->load->view('layout/counselorLeftMenu');
          }
        ?>
        <div class="col-md-10">
          <?php //$this->load->view('layout/member_view')?>
          <div class="btm-section">
            <div class="machMakingSec" >
                <div class="row">
                  <div class="machMakingform" id="machMakingform">
                    <div class=" item" id="step2"><!--step Two-->
                     <h2> All Notification</h2>
                     
                      
          					  <div class="row">
                        <table>
          							  <tr>
          								<th>Sl</th>
          								<th>Text</th>
          								<th>DateTime</th>
                          </tr>
          							  
          							  <?php 
          							  
          								if(!empty($recordset) && count($recordset) > 0){
          									$i=1;
                            foreach($recordset as $row=>$val){
                              $url=base_url($val['site_url']);
          								    ?>
            							    <tr class="<?php echo $i%2==0?'even':'odd'; ?> pointer">
                                <td class=" "><?php echo $i+$startRecord; ?></td>
                                <td><a style="cursor: pointer;" href="<?php echo $url; ?>"><?php echo $val['contents']; ?></a></td>
                                <td><?php echo date('Y m d H:i:s',strtotime($val['created_date'])); ?></td>
                              </tr>
            								<?php }
            								}else{ ?>
          								
          									<tr><td colspan="3">No Notification</td></tr>
          									
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
 