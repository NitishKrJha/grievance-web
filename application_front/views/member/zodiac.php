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
                  <div class=" item" id="step7"><!--step 7-->
                    <h2>Zodiac </h2>
                      <form action="<?php echo base_url('member/saveZodiacData') ?>" method="post" id="zodicForm">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="usr">Sign </label>
                            <select class="form-control" id="sign" name="sign">
                              <option value="">Select Sign</option>
                              <option value="Aquarius" <?php if($profileMoreData[0]['sign']=='Aquarius'){ echo 'selected'; } ?>>Aquarius</option>
                              <option value="Pisces" <?php if($profileMoreData[0]['sign']=="Pisces"){ echo 'selected'; } ?>>Pisces</option>
                              <option value="Aries" <?php if($profileMoreData[0]['sign']=="Aries"){ echo 'selected'; } ?>>Aries</option>
                              <option value="Taurus" <?php if($profileMoreData[0]['sign']=="Taurus"){ echo 'selected'; } ?>>Taurus</option>
                              <option value="Gemini" <?php if($profileMoreData[0]['sign']=="Gemini"){ echo 'selected'; } ?>>Gemini</option>
                              <option value="Cancer" <?php if($profileMoreData[0]['sign']=="Cancer"){ echo 'selected'; } ?>>Cancer</option>
                              <option value="leo" <?php if($profileMoreData[0]['sign']=="leo"){ echo 'selected'; } ?>>leo</option>
                              <option value="Virgo" <?php if($profileMoreData[0]['sign']=="Virgo"){ echo 'selected'; } ?>>Virgo</option>
                              <option value="Libra" <?php if($profileMoreData[0]['sign']=="Libra"){ echo 'selected'; } ?>>Libra</option>
                              <option value="Scorpio" <?php if($profileMoreData[0]['sign']=="Scorpio"){ echo 'selected'; } ?>>Scorpio</option>
                              <option value="Sagittarius" <?php if($profileMoreData[0]['sign']=="Sagittarius"){ echo 'selected'; } ?>>Sagittarius</option>
                              <option value="Capricorn" <?php if($profileMoreData[0]['sign']=="Capricorn"){ echo 'selected'; } ?>>Capricorn</option>
                              <option value="Unknown" <?php if($profileMoreData[0]['sign']=="Unknown"){ echo 'selected'; } ?>>Unknown</option>
                            </select>
                          </div>
                        </div>
                      </div>
                  </div>
                  <!--step 7 end-->
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
        $("#zodicForm").validate({
            // Specify validation rules
            rules: {
                "sign": {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    })
</script>