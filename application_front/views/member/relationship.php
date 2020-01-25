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
                    <div class=" item" id="step3"><!--step Three-->
                     <h2>Relationship</h2>
                        <form action="<?php echo base_url('member/saveRelationshipData') ?>" method="post" id="relationshipForm">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Have kids </label>
                            <select class="form-control" id="have_kids" name="have_kids">
                               <option value="">Select</option>
                               <option value="Prefer not to say" <?php if($profileMoreData[0]['have_kids']=='Prefer not to say'){ echo 'selected'; } ?>>Prefer not to say</option>
                               <option value="No kids" <?php if($profileMoreData[0]['have_kids']=='No kids'){ echo 'selected'; } ?>>No kids</option>
                               <option value="1" <?php if($profileMoreData[0]['have_kids']==1){ echo 'selected'; } ?>>1</option>
                               <option value="2" <?php if($profileMoreData[0]['have_kids']==2){ echo 'selected'; } ?>>2</option>
                               <option value="3" <?php if($profileMoreData[0]['have_kids']==3){ echo 'selected'; } ?>>3</option>
                               <option value="4" <?php if($profileMoreData[0]['have_kids']==4){ echo 'selected'; } ?>>4</option>
                               <option value="5" <?php if($profileMoreData[0]['have_kids']==5){ echo 'selected'; } ?>>5</option>
                               <option value="5+" <?php if($profileMoreData[0]['have_kids']=='5+'){ echo 'selected'; } ?>>5+</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Want kids</label>
                            <select class="form-control" id="want_kids" name="want_kids">
                                <option value="">Select</option>
                                <option value="1" <?php if($profileMoreData[0]['want_kids']==1){ echo 'selected'; } ?>>Yes</option>
                                <option value="2" <?php if($profileMoreData[0]['want_kids']==2){ echo 'selected'; } ?>>No</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div><!--Step three End-->
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
          $("#relationshipForm").validate({
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