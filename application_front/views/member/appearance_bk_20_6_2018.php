<section class="main-container">
    <div class="container-fluid">
      <div class="row">
        <?php $this->load->view('layout/member_left_menu')?>
        <div class="col-md-7">
          <?php $this->load->view('layout/member_view')?>
          <div class="btm-section">
            <div class="machMakingSec">
               
			   <div class="row">
                  <div class="machMakingform" id="machMakingform">
                    <div class=" item" id="step1"><!--step one-->
                    <h2>Appearance</h2>
                      <form action="<?php echo base_url('member/saveAppearanceData') ?>" method="post" id="appearanceForm">
                      <div class="row">
                        <div class="col-md-12">
                            <div class="form-group"> <!--<span class="minChar">Min 200 chars</span>-->
                              <label for="comment">About Me</label>
                              <textarea class="form-control" rows="4" id="about_me" name="about_me" placeholder="Type here"><?php echo $profileData['about_me']; ?></textarea>
                            </div>
                        </div>
                      </div>
                      <div class="row">
					  
						<div class="col-md-6">
                          <div class="form-group">
                            <label for="comment"> Name </label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" value="<?php echo $profileData['name']; ?>">
                          </div>
                        </div>
					  
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="comment">Height </label>
                            <input type="text" id="height" name="height" class="form-control" placeholder="Enter your height" value="<?php echo $profileMoreData[0]['height']; ?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Body type</label>
                            <select class="form-control" id="body_type" name="body_type">
                                <option value="">Select Body Type</option>
                                <?php if(count($bodyTypes)>0){
                                    foreach ($bodyTypes as $bodyType){ ?>
                                        <option value="<?php echo $bodyType['id']; ?>" <?php if($profileMoreData[0]['body_type']==$bodyType['id']){ echo 'selected'; } ?>><?php echo $bodyType['type']; ?></option>
                                  <?php } } ?>
                              </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Hair</label>
                            <select class="form-control" id="hair" name="hair">
                                <option value="">Select Hair Type</option>
                                <?php if(count($hairTypes)>0){
                                    foreach ($hairTypes as $hairType){ ?>
                                        <option value="<?php echo $hairType['id']; ?>" <?php if($profileMoreData[0]['hair']==$hairType['id']){ echo 'selected'; } ?>><?php echo $hairType['type']; ?></option>
                                    <?php } } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="usr">Eye</label>
                            <select class="form-control" id="eye" name="eye">
                                <option value="">Select Eye Type</option>
                                <?php if(count($eyeTypes)>0){
                                    foreach ($eyeTypes as $eyeType){ ?>
                                        <option value="<?php echo $eyeType['id']; ?>" <?php if($profileMoreData[0]['eye']==$eyeType['id']){ echo 'selected'; } ?>><?php echo $eyeType['type']; ?></option>
                                    <?php } } ?>
                            </select>
                          </div>
                        </div>
						
						
						<div class="col-md-6">
                          <div class="form-group">
                            <label for="usr"> Age </label>
                            <input type="text" id="age" name="age" class="form-control" placeholder="Enter your Age" value="<?php echo isset($profileData['age'])?$profileData['age']:''; ?>">
                          </div>
                        </div>
						
						
						<div class="col-md-6">
                          <div class="form-group">
                            <label for="usr"> Country </label>
                            <select class="form-control" name="country_id" id="country_id">
							  <option value="">-Country-</option>
							  <?php foreach($allcountry as $countrydetail){?>
							   <option value="<?php echo $countrydetail['id'];?>" <?php if($countrydetail['id'] == $profileData['country']){ echo "selected";} ?>><?php echo $countrydetail['name'];?></option>
							  <?php }?> 
							</select>
                          </div>
                        </div>
						
						
						<div class="col-md-6">
                          <div class="form-group">
                            <label for="usr"> State </label>
                            <select class="form-control" name="state_id" id="state_id">
								  <option value="<?php echo $profileData['state']?>">-State-</option>
    						</select>
                          </div>
                        </div>
						
						
						<div class="col-md-6">
                          <div class="form-group">
                            <label for="usr"> City </label>
                            <select class="form-control" name="city_id" id="city_id">
									<option value="">-City-</option>								
							</select>
                          </div>
                        </div>
						
						
						<div class="col-md-6">
                          <div class="form-group">
                            <label for="usr"> Zip </label>
                             <input type="text" id="zip" name="zip" class="form-control" placeholder="Enter your Zip" value="<?php echo isset($profileData['zip'])?$profileData['zip']:'';?>">
                          </div>
                        </div>
						
						
                      </div>
                    </div>
                <div class="nextPrvsSec">
                	<!-- <a class="showTipsBtn pull-right" href="match-making-step2.html#step2" >Continue</a> -->
                <input type="submit" class="btn-cmn" value="Submit">
                </div>
                  </form>  
                  </div>
                </div>
				
				
            </div>
          </div>
        </div>
          <?php echo $this->load->view('layout/memberMyContact'); ?>
          <?php echo $this->load->view('layout/memberChatRequest'); ?>
      </div>
    </div>
  </section>
<script>
$(document).ready(function(){
    $("#appearanceForm").validate({
        // Specify validation rules
        rules: {
            about_me: {
                required: true
            },
            height: {
                required: true
            },
            body_type: {
                required: true
            },
            hair: {
                required: true
            },
            eye: {
                required: true
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
})
</script>


<script>
$(document).ready(function(){
	
	var state = '<?php echo $profileData['state']?>';
	var city = '<?php echo $profileData['city']?>';
	 if(state){
		$('#country_id').trigger('change');
	 }
	 
	 if(city){
		$('#state_id').trigger('change');
	 }
	  
		 
});

 $("#country_id").change(function(){
	//alert(1);
    $.ajax({
      url : '<?php echo base_url("member/getCountry");?>',
      type : 'POST',
      data : 'country_id='+$(this).val(),
      dataType : 'json',
      success : function(data){
        var html = '';
        var preCource = '<?php echo $profileData['state']?>';
        if(data!=''){
			 html = html+'<option value="" >-None-</option>';
          $.each(data,function(index,value){
            var selected ='';
			
            if(preCource == value.id){ selected = 'selected'; }
            html = html+'<option value="'+value.id+'" '+selected+'>'+value.name+'</option>';
          }); 
        }else{
			 html = html+'<option value="" >-None-</option>';
		}
        $("#state_id").html(html);
      }
    })
  })
 
  $("#state_id").change(function(){
	 //alert(1);
    $.ajax({
      url : '<?php echo base_url("member/getCity");?>',
      type : 'POST',
      data : 'state_id='+$(this).val(),
      dataType : 'json',
      success : function(data){
        var html = '';
        var preCource = '<?php echo $profileData['city']?>';
        if(data!=''){
			html = html+'<option value="" >-None-</option>';
          $.each(data,function(index,value){
            var selected ='';
            
			if(preCource == value.id){ selected = 'selected'; }
			
            html = html+'<option value="'+value.id+'" '+selected+'>'+value.name+'</option>';
          }); 
        }else{
			 html = html+'<option value="" >-None-</option>';
		}
        $("#city_id").html(html);
      }
    })
  })
</script>