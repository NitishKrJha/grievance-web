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
                     <h2> Deactive Account </h2>
                      <!--<form action="<?php echo base_url('member/dochangepassword') ?>" method="post" id="changePasswordForm">-->
                      <div class="row">
                                              
                      </div>
                    </div><!--step Two End-->
                    <div class="nextPrvsSec">
                  <!-- <a class="showTipsBtn pull-right" href="match-making-step2.html#step2" >Continue</a> -->
                <input type="submit" class="btn-cmn deactiveaccount" value="Account Deactive">
                </div>
                  <!--</form>-->
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


<script>
 $(document).on('click','.deactiveaccount',function(){
	
	//alert(1);
	 
	var $this=$(this);
	var id=$this.data('idto');
	//alert(id);
	if(id==''){
		return false;
	}
	var url='<?php echo base_url(); ?>member/do_deactiveaccount/'+id;
	
	if(window.confirm("Are you sure to deactive your account ?"))
	{
		  //window.location.href = url;
		  window.location.href = url;
		 //window.location.reload();
		 //alert(1);
	} 
}); 

/*  function ChangeStatus(url)
 {
	if(window.confirm("Are you sure to block this member ?"))
	{
		  window.location.href = url;
		 //window.location.reload();
	}
 } */
</script>