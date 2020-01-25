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
                    <div class=" item" id="step5"><!--Step Five-->
                     <h2>Activities/Exercise</h2>
                        <form action="<?php echo base_url('member/saveActivityData') ?>" method="post" id="activityForm">
                      <div class="row">
                       <div class="col-md-12" id="matchExercise">
                       		<h4 class="lableHeader"> Indoor activities</h4>
                            <span class="checkboxSec" >
                            <ul class="unstyled ">
                                <?php
                                if($profileMoreData[0]['indoor_activities'] !='' && $profileMoreData[0]['outdoor_activities']!=''){
                                    $indoor_activitiesData = explode(',',$profileMoreData[0]['indoor_activities']);
                                    $outdoor_activitiesData = explode(',',$profileMoreData[0]['outdoor_activities']);
                                }
                                if(count($indoorActivities)>0){
                                    foreach ($indoorActivities as $indoorActivitie){ ?>
                                        <li>
                                        <input class="styled-checkbox" id="matchInExercise-<?php echo $indoorActivitie['id']; ?>" type="checkbox" value="<?php echo $indoorActivitie['id']; ?>" name="indoor_activities[]" <?php if(in_array($indoorActivitie['id'],$indoor_activitiesData)){ echo "checked"; } ?>>
                                        <label for="matchInExercise-<?php echo $indoorActivitie['id']; ?>"><?php echo $indoorActivitie['activities']; ?></label>
                                      </li>
                                  <?php  } } ?>
                              </ul>
                            </span>
                            <h4 class="lableHeader"> Outdoor activities</h4>
                            <span class="checkboxSec" >
                                <ul class="unstyled ">
                                  <?php
                                  if(count($outdoorActivities)>0){
                                      foreach ($outdoorActivities as $outdoorActivitie){ ?>
                                          <li>
                                    <input class="styled-checkbox" id="matchOutExercise-<?php echo $outdoorActivitie['id']; ?>" type="checkbox" value="<?php echo $outdoorActivitie['id']; ?>" name="outdoor_activities[]" <?php if(in_array($outdoorActivitie['id'],$outdoor_activitiesData)){ echo "checked"; } ?>>
                                    <label for="matchOutExercise-<?php echo $outdoorActivitie['id']; ?>"><?php echo $outdoorActivitie['activities']; ?></label>
                                  </li>
                                      <?php  } } ?>
                                  </ul>
                            </span>
                       </div>
                      </div>
                    </div><!--step five End-->
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
        $("#activityForm").validate({
            // Specify validation rules
            rules: {
                have_kids: {
                    required: true
                },
                want_kids: {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    })
</script>