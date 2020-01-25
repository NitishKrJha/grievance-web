<section class="main-container">
    <div class="container-fluid">
      <div class="row">
        <?php $this->load->view('layout/member_left_menu')?>
        <div class="col-md-10">
          <div class="top-section">
          <?php $this->load->view('layout/member_view')?>
          </div>
          <div class="btm-section">
            <div class="machMakingSec">
                <div class="row">
                  <div class="machMakingform" id="machMakingform">
                     <div class="item" id="step4"><!--Step Four-->
                     <h2>Background</h2>
                         <form action="<?php echo base_url('member/saveBackgroundData') ?>" method="post" id="backgroudForm">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Ethnicity </label>
                            <select class="form-control" id="ethnicity" name="ethnicity">
                                <option value="">Select Ethnicity</option>
                                <?php if(count($ethnicityTypes)>0){
                                    foreach ($ethnicityTypes as $ethnicityType){ ?>
                                        <option value="<?php echo $ethnicityType['id']; ?>" <?php if($profileMoreData[0]['ethnicity']==$ethnicityType['id']){ echo 'selected'; } ?>><?php echo $ethnicityType['ethnicity']; ?></option>
                                    <?php } } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Faith</label>
                           <select class="form-control" id="faith" name="faith">
                                <option value="">Select Faith</option>
                               <?php if(count($faithTypes)>0){
                                   foreach ($faithTypes as $faithType){ ?>
                                       <option value="<?php echo $faithType['id']; ?>" <?php if($profileMoreData[0]['faith']==$faithType['id']){ echo 'selected'; } ?>><?php echo $faithType['faith_name']; ?></option>
                                   <?php } } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Language</label>
                            <select class="form-control" id="language" name="language">
                                <option value="">Select Language</option>
                                <?php if(count($languageTypes)>0){
                                    foreach ($languageTypes as $languageType){ ?>
                                        <option value="<?php echo $languageType['id']; ?>" <?php if($profileMoreData[0]['language']==$languageType['id']){ echo 'selected'; } ?>><?php echo $languageType['name']; ?></option>
                                    <?php } } ?>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Country</label>
                            <select class="form-control" id="country" name="country">
                                <option value="">Select Country</option>
                                <?php if(count($countriesTypes)>0){
                                    foreach ($countriesTypes as $countriesType){ ?>
                                        <option value="<?php echo $countriesType['id']; ?>" <?php if($profileMoreData[0]['country']==$countriesType['id']){ echo 'selected'; } ?>><?php echo $countriesType['name']; ?></option>
                                    <?php } } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">State</label>
                            <select class="form-control" id="state" name="state">
                                <option value="">Select State</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">City</label>
                            <select class="form-control" id="city" name="city">
                                <option value="">Select City</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Education</label>
                            <select class="form-control" id="education" name="education">
                                <option value="">Select Education</option>
                                <?php if(count($educationTypes)>0){
                                    foreach ($educationTypes as $educationType){ ?>
                                        <option value="<?php echo $educationType['id']; ?>" <?php if($profileMoreData[0]['education']==$educationType['id']){ echo 'selected'; } ?>><?php echo $educationType['name']; ?></option>
                                    <?php } } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div><!--step Four End-->
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
        var countryId = "<?php echo $profileMoreData[0]['country'] ?>";
        var stateId = "<?php echo $profileMoreData[0]['state'] ?>";
        var cityId = "<?php echo $profileMoreData[0]['city'] ?>";
        if(stateId !=''){
            $.ajax({
                url:"<?php echo base_url("page/geStateData") ?>",
                type:"POST",
                data:{country_id:countryId,state_id:stateId},
                success:function (responce) {
                    if(responce!="No data"){
                        $("#state").html(responce)
                    }
                }
            });
        }
        if(cityId!=''){
            $.ajax({
                url:"<?php echo base_url("page/geCityData") ?>",
                type:"POST",
                data:{state_id:stateId,city_id:cityId},
                success:function (responce) {
                    if(responce!="No data"){
                        $("#city").html(responce)
                    }
                }
            });
        }




        $("#backgroudForm").validate({
            // Specify validation rules
            rules: {
                ethnicity: {
                    required: true
                },
                faith: {
                    required: true
                },
                language: {
                    required: true
                },
                country: {
                    required: true
                },
                state: {
                    required: true
                },
                city: {
                    required: true
                },
                education: {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
    $(document).on('change',"#country",function () {
        var country_id = $(this).val();
        $.ajax({
            url:"<?php echo base_url("page/geStateData") ?>",
            type:"POST",
            data:{country_id:country_id},
            success:function (responce) {
                if(responce!="No data"){
                    $("#state").html(responce)
                }
            }
        });
    });
    $(document).on('change',"#state",function () {
        var state_id = $(this).val();
        $.ajax({
            url:"<?php echo base_url("page/geCityData") ?>",
            type:"POST",
            data:{state_id:state_id},
            success:function (responce) {
                if(responce!="No data"){
                    $("#city").html(responce)
                }
            }
        });
    });
</script>