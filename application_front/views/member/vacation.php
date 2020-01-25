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
                    <div class=" item" id="step9"><!--Step 9-->
                     <h2>Vacation</h2>
                        <form action="<?php echo base_url('member/saveVacationData') ?>" method="post" id="vacationForm">
                      <div class="row">
                       <div class="col-md-12 chkBx" >
                       		<h4 class="lableHeader"> Best Place </h4>
                            <span class="checkboxSec" >
                                 <ul class="unstyled ">
                                    <?php
                                    if($profileMoreData[0]['vacation_place'] !=''){
                                        $vacationData = explode(',',$profileMoreData[0]['vacation_place']);
                                    }
                                    if(count($vacationPlaceDatas)>0){
                                        foreach ($vacationPlaceDatas as $vacationPlaceData){ ?>
                                            <li>
                                            <input class="styled-checkbox" id="matchInExercise-<?php echo $vacationPlaceData['id']; ?>" type="checkbox" value="<?php echo $vacationPlaceData['id']; ?>" name="vacation_place[]" <?php if(in_array($vacationPlaceData['id'],$vacationData)){ echo "checked"; } ?>>
                                            <label for="matchInExercise-<?php echo $vacationPlaceData['id']; ?>"><?php echo $vacationPlaceData['name']; ?></label>
                                          </li>
                                        <?php  } } ?>
                                  </ul>
                            </span>
                       </div>
                      </div>
                    </div><!--step 9 End-->
                    <div class="nextPrvsSec">
                  <!-- <a class="showTipsBtn pull-right" href="match-making-step2.html#step2" >Continue</a> -->
                <input type="submit" class="btn-cmn" value="Submit">
                <input type="button" onclick="window.history.go(-1); return false;" class="btn-cmn" value="Back">
                </div>
                  </form>
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
        $("#vacationForm").validate({
            // Specify validation rules
            rules: {
                "vacation_place[]": {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    })
</script>