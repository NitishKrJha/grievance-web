<section class="main-container">
    <div class="container-fluid">
      <div class="row">
        <?php $this->load->view('layout/member_left_menu')?>
        <div class="col-md-10">
          <?php $this->load->view('layout/member_view')?>
          <div class="btm-section">
            <div class="machMakingSec">
                <div class="row">
                  <div class="machMakingform" id="machMakingform">
                    <div class=" item" id="step6"><!--Step Six-->
                     <h2>Pets</h2>
                        <form action="<?php echo base_url('member/savePetData') ?>" method="post" id="petForm">
                      <div class="row">
                       <div class="col-md-12 chkBx" >
                       		<h4 class="lableHeader"> You like</h4>
						<span class="checkboxSec" >
                            <ul class="unstyled ">
                                <?php
                                if($profileMoreData[0]['pet'] !=''){
                                    $pet_activitiesData = explode(',',$profileMoreData[0]['pet']);
                                }
                                if(count($petDatas)>0){
                                    foreach ($petDatas as $petData){ ?>
                                        <li>
                                        <input class="styled-checkbox" id="matchInExercise-<?php echo $petData['id']; ?>" type="checkbox" value="<?php echo $petData['id']; ?>" name="pet[]" <?php if(in_array($petData['id'],$pet_activitiesData)){ echo "checked"; } ?>>
                                        <label for="matchInExercise-<?php echo $petData['id']; ?>"><?php echo $petData['pet_name']; ?></label>
                                      </li>
                                    <?php  } } ?>
                              </ul>
                        </span>
                       </div>
                      </div>
                    </div><!--step Six End-->
                    <div class="nextPrvsSec">
                  <!-- <a class="showTipsBtn pull-right" href="match-making-step2.html#step2" >Continue</a> -->
                <input type="submit" class="btn-cmn" value="Submit">
                <input type="button" onclick="window.history.go(-1); return false;" class="btn-cmn" value="Back">
                </div>
                  </form>  
                     <!-- <div class="nextPrvsSec">
                        <a class="showTipsBtn pull-right" href="match-making-step7.html#step7">Continue</a>
                        <a class="pull-left" href="match-making-step5.html#step5"><i class="fa fa-angle-left"></i> Go Back</a>
                    </div> -->
     
                    
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
    $(document).ready(function(){
        $("#petForm").validate({
            // Specify validation rules
            rules: {
                "pet[]": {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    })
</script>