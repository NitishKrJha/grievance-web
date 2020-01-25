<section class="main-container">
    <div class="container-fluid">
      <div class="row">
        <?php $this->load->view('layout/member_left_menu')?>
        <div class="col-md-10">
          <?php $this->load->view('layout/member_view')?>
          <div class="btm-section">
            <div class="machMakingSec" >
                <div class="row">
                  <div class="machMakingform" id="machMakingform">
                    <div class=" item" id="step2"><!--step Two-->
                     <h2>Lifestyle</h2>
                      <form action="<?php echo base_url('member/saveLifestyleData') ?>" method="post" id="lifestyleForm">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Smoking </label>
                            <select class="form-control" id="smoking" name="smoking">
                                <option value="">Select</option>
                                <option value="1" <?php if($profileMoreData[0]['smoking']==1){ echo 'selected'; } ?>>Non-Smoker</option>
                                <option value="2" <?php if($profileMoreData[0]['smoking']==2){ echo 'selected'; } ?>>Light-Smoker</option>
                                <option value="3" <?php if($profileMoreData[0]['smoking']==3){ echo 'selected'; } ?>>Heavy-Smoker</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Drinking</label>
                            <select class="form-control" id="drinking" name="drinking">
                                <option value="">Select</option>
                                <option value="1" <?php if($profileMoreData[0]['drinking']==1){ echo 'selected'; } ?>>Non-Drinker</option>
                                <option value="2" <?php if($profileMoreData[0]['drinking']==2){ echo 'selected'; } ?>>Social-Drinker</option>
                                <option value="3" <?php if($profileMoreData[0]['drinking']==3){ echo 'selected'; } ?>>Heavy-Drinker</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Occupation</label>
                            <input type="text" id="occupation" name="occupation" class="form-control" value="<?php echo $profileMoreData[0]['occupation']; ?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Income(Annual)</label>
                            <input type="text" id="income" name="income" class="form-control" value="<?php echo $profileMoreData[0]['income']; ?>">
                          </div>
                        </div>
                      </div>
                    </div><!--step Two End-->
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
        $("#lifestyleForm").validate({
            // Specify validation rules
            rules: {
                smoking: {
                    required: true
                },
                drinking: {
                    required: true
                },
                occupation: {
                    required: true
                },
                income: {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    })
</script>