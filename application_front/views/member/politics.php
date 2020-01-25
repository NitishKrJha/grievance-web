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
                    <div class=" item" id="step8"><!--step 8-->
                    <h2>Politics </h2>
                        <form action="<?php echo base_url('member/savePoliticsData') ?>" method="post" id="politicsForm">
                      <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="comment">Your Views</label>
                              <textarea class="form-control" rows="4" id="politics_view" name="politics_view" placeholder="Type here"><?php echo $profileMoreData[0]['politics_view']; ?></textarea>
                            </div>
                        </div>
                      </div>
                    </div><!--step 8 end-->
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
        $("#politicsForm").validate({
            // Specify validation rules
            rules: {
                "politics_view": {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    })
</script>