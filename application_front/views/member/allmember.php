      
        <section class="main-container">
            <div class="container-fluid">
                <div class="row">
                    <?php $this->load->view('layout/member_left_menu')?>
                    <div class="col-md-10">
                    
                    <div class="row searchCounselor">
                    	<div class="col-md-12 col-sm-12"><h3>Search Member</h3></div>
                        <div class="col-md-12 col-sm-6">
                        	 <div id="counselling-search-input">
                            <div class="input-group col-md-12">
                                <!--<input type="text" class="  search-query form-control" placeholder="Enter city or country or ZIP code" />-->
								
								<form action ="<?php echo base_url().'member/filter_member'?>" method="post" name="search_counselor">
								
								
								<div class="col-md-2">
									<select class="form-control" name="country_id" id="country_id">
									  <option value="">-Country-</option>
									  <?php foreach($allcountry as $countrydetail){?>
									   <option value="<?php echo $countrydetail['id'];?>" <?php if($countrydetail['id'] == $params['country_id']) echo 'selected';?> ><?php echo $countrydetail['name'];?></option>
									  <?php }?> 
								   </select>
								</div>
								<div class="col-md-2">
								<select class="form-control" name="state_id" id="state_id">
								  <option value="<?php echo $params['state_id'];?>">-State-</option>
    							</select>
								</div>
								
								<div class="col-md-2">
								<select class="form-control" name="city_id" id="city_id">
									<option value="">-City-</option>								
								</select>
								</div>
								
								<div class="col-md-2">
								<input type="text" name="zip" id="zip" class="form-control" placeholder="Enter your pin code" value="<?php if(isset($params['zip'])){echo $params['zip']; }?>">
								</div>
								
								<div class="col-md-2">
								<select name="loking_for" id="loking_for" class="form-control">
									<option value=""> Looking For </option>
									<option value="1" <?php if(isset($params['loking_for']) && $params['loking_for']=='1') echo 'selected';?>> Male </option>
									<option value="2" <?php if(isset($params['loking_for']) && $params['loking_for']=='2') echo 'selected';?>> Fenale </option>								
								</select>
								</div>
								
								<div class="col-md-2">
								<select name="age_from" id="age_from" class="form-control">								
								<option value=""> Age From </option>
								<?php 								
									for($i = 18; $i<=70; $i++){?>
									<option value="<?php echo $i;?>" <?php if(isset($params['age_from']) && $params['age_from']==$i) echo 'selected';?>> <?php echo $i;?></option>								
								<?php } ?>
								</select>
								</div>
								
								<div class="col-md-2">
									<select name="age_to" id="age_to" class="form-control">								
									<option value=""> Age TO </option>
									<?php 								
										for($j = 18; $j<=70; $j++){?>
										<option value="<?php echo $j;?>" <?php if(isset($params['age_to']) && $params['age_to']==$j) echo 'selected';?>> <?php echo $j;?></option>								
									<?php } ?>
									</select>
								</div>
								
								
								<div class="col-md-2">
									<select class="form-control" id="education" name="education">
										<option value="">Select Education</option>
										<option value="1" <?php if(isset($params['education']) && $params['education']=='1') echo 'selected';?>>High School</option>
										<option value="2" <?php if(isset($params['education']) && $params['education']=='2') echo 'selected';?>>College</option>
										<option value="3" <?php if(isset($params['education']) && $params['education']=='3') echo 'selected';?> >Associates Degree</option>
										<option value="4" <?php if(isset($params['education']) && $params['education']=='4') echo 'selected';?>>Bachelors Degree</option>
										<option value="5" <?php if(isset($params['education']) && $params['education']=='5') echo 'selected';?> >Graduate Degree</option>
										<option value="6" <?php if(isset($params['education']) && $params['education']=='6') echo 'selected';?>>PhD / Post Doctoral</option>
									</select>
								</div>
																
								<div class="col-md-2">
									<select class="form-control" id="language" name="language">
										<option value="">Select Language</option>
										<option value="2" <?php if(isset($params['language']) && $params['language']=='2') echo 'selected';?>>Bengali</option>
										<option value="3" <?php if(isset($params['language']) && $params['language']=='3') echo 'selected';?>>English</option>
										<option value="4" <?php if(isset($params['language']) && $params['language']=='4') echo 'selected';?>>Hindi</option>
									</select>
								</div>
								
								
								<div class="col-md-2">
									<select class="form-control valid" id="have_kids" name="have_kids" aria-required="true" aria-invalid="false">
									   <option value=""> Select Kid </option>
									   <option value="Prefer not to say" <?php if(isset($params['have_kids']) && $params['have_kids']=='Prefer not to say') echo 'selected';?>>Prefer not to say</option>
									   <option value="No kids" <?php if(isset($params['have_kids']) && $params['have_kids']=='No kids') echo 'selected';?>>No kids</option>
									   <option value="1" <?php if(isset($params['have_kids']) && $params['have_kids']=='1') echo 'selected';?>>1</option>
									   <option value="2" <?php if(isset($params['have_kids']) && $params['have_kids']=='2') echo 'selected';?>>2</option>
									   <option value="3" <?php if(isset($params['have_kids']) && $params['have_kids']=='3') echo 'selected';?>>3</option>
									   <option value="4" <?php if(isset($params['have_kids']) && $params['have_kids']=='4') echo 'selected';?>>4</option>
									   <option value="5" <?php if(isset($params['have_kids']) && $params['have_kids']=='5') echo 'selected';?>>5</option>
									   <option value="5+" <?php if(isset($params['have_kids']) && $params['have_kids']=='5+') echo 'selected';?>>5+</option>
									</select>
								</div>
								
								
								<div class="col-md-2">
									<select class="form-control" id="smoking" name="smoking">
									<option value="">Select Smoker</option>
									<option value="1" <?php if(isset($params['smoking']) && $params['smoking']=='1') echo 'selected';?>>Non-Smoker</option>
									<option value="2" <?php if(isset($params['smoking']) && $params['smoking']=='2') echo 'selected';?>>Light-Smoker</option>
									<option value="3" <?php if(isset($params['smoking']) && $params['smoking']=='3') echo 'selected';?>>Heavy-Smoker</option>
									</select>
								</div>
								
								<div class="col-md-2">
									<select class="form-control" id="drinking" name="drinking">
									<option value="">Select</option>
									<option value="1" <?php if(isset($params['drinking']) && $params['drinking']=='1') echo 'selected';?>>Non-Drinker</option>
									<option value="2" <?php if(isset($params['drinking']) && $params['drinking']=='2') echo 'selected';?>>Social-Drinker</option>
									<option value="3" <?php if(isset($params['drinking']) && $params['drinking']=='3') echo 'selected';?>>Heavy-Drinker</option>
									</select>
								</div>
								
								<div class="col-md-2">
									<input type="text" id="height" name="height" class="form-control" placeholder="Enter your height" value="<?php echo isset($params['height'])?$params['height']:'';?>">
								</div>
								
								
								<div class="col-md-2">
									<select class="form-control valid" id="body_type" name="body_type" aria-required="true" aria-invalid="false">
										  <option value="">Select Body Type</option>
										  <option value="1" <?php if(isset($params['body_type']) && $params['body_type']=='1') echo 'selected';?>>Slim</option>
										  <option value="2" <?php if(isset($params['body_type']) && $params['body_type']=='2') echo 'selected';?>>Athletic</option>
										  <option value="3" <?php if(isset($params['body_type']) && $params['body_type']=='3') echo 'selected';?>>Average</option>
										  <option value="4" <?php if(isset($params['body_type']) && $params['body_type']=='4') echo 'selected';?>>Curvy</option>
										  <option value="5" <?php if(isset($params['body_type']) && $params['body_type']=='5') echo 'selected';?>> A Few Extra Pounds</option>
										  <option value="6" <?php if(isset($params['body_type']) && $params['body_type']=='6') echo 'selected';?>> Full / Overweight</option>
									</select>
								</div>
								
								
								<div class="col-md-2">
									<select class="form-control valid" id="eye" name="eye" aria-required="true" aria-invalid="false">
										<option value="">Select Eye Type</option>
										<option value="2" <?php if(isset($params['eye']) && $params['eye']=='2') echo 'selected';?>>Deep Set Eyes</option>
										<option value="3" <?php if(isset($params['eye']) && $params['eye']=='3') echo 'selected';?>>Monolid</option>
										<option value="4" <?php if(isset($params['eye']) && $params['eye']=='4') echo 'selected';?>>Hooded Eyes</option>
										<option value="5" <?php if(isset($params['eye']) && $params['eye']=='5') echo 'selected';?>>Protruding Eyes</option>
										<option value="6" <?php if(isset($params['eye']) && $params['eye']=='6') echo 'selected';?>>Upturned Eyes</option>
										<option value="7" <?php if(isset($params['eye']) && $params['eye']=='7') echo 'selected';?>>Downturned Eyes</option>
										<option value="8" <?php if(isset($params['eye']) && $params['eye']=='8') echo 'selected';?>>Close Set Eyes</option>
										<option value="9" <?php if(isset($params['eye']) && $params['eye']=='9') echo 'selected';?>>Wide Set Eyes</option>
									</select>
								</div>
								
								<div class="col-md-2">
									<select class="form-control valid" id="hair" name="hair" aria-required="true" aria-invalid="false">
										<option value="">Select Hair Type</option>
										<option value="1" <?php if(isset($params['hair']) && $params['hair']=='1') echo 'selected';?>>Auburn</option>
										<option value="2" <?php if(isset($params['hair']) && $params['hair']=='2') echo 'selected';?>>Black</option>
										<option value="3" <?php if(isset($params['hair']) && $params['hair']=='3') echo 'selected';?>>Blonde</option>
										<option value="4" <?php if(isset($params['hair']) && $params['hair']=='4') echo 'selected';?>>Light Brown</option>
										<option value="5" <?php if(isset($params['hair']) && $params['hair']=='5') echo 'selected';?>>Dark Brown</option>
										<option value="6" <?php if(isset($params['hair']) && $params['hair']=='6') echo 'selected';?>>Grey</option>
										<option value="7" <?php if(isset($params['hair']) && $params['hair']=='7') echo 'selected';?>>Red</option>
										<option value="8" <?php if(isset($params['hair']) && $params['hair']=='8') echo 'selected';?>>White</option>
									</select>
								</div>
								
								
								<div class="col-md-2">
									<input type="submit" value="Search Counselor" class="showTipsBtn">
								</div>
								
                                <!--<span class="input-group-btn">
                                    <button class="btn btn-danger" type="button">
                                        <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>-->
                            </div>
                        </div>
                        </div>
                                                
					</form>	
                    </div>
                    
                       <div class="row counselling">
					   
							<?php 
								if(!empty($member)){
								foreach($member as $memberDetails){ 
							?>                       		
								<div class="col-md-3 col-sm-4">
									<div class="myMatch">
										 <figure>
										 
										 <?php if($memberDetails['picture']){?>
											<img src="<?php echo $memberDetails['picture']?>" alt="">
											<?php }else{?>
												<img src="<?php echo CSS_IMAGES_JS_BASE_URL;?>images/images.png" alt="">
											<?php } ?>
										 
										 </figure>
										 
										<?php $member_id = base64_encode($memberDetails['id']);
											$memberId = rtrim($member_id, '=');
										?>
										 <div class="textSec">
											<a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i> </a>
										 <a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i> </a>
										<p><a href="<?php echo base_url().'member/profile/'.$memberId?>"> <?php echo $memberDetails['name'].','.$memberDetails['age']?></a></p>
										 </div>	
									</div>
								</div>
							
						<?php } }else{ ?>
							<h2 class="no_data"> No data found </h2>
						<?php } ?>
                         
                       </div>
					   <?php echo $this->pagination->create_links();?>
                    </div>
                    
                
                </div>
            </div>

        </section>

 <script>
$(document).ready(function(){
	
	var state = '<?php echo $params['country_id'];?>';
	var city = '<?php echo $params['state_id'];?>';
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
      url : '<?php echo base_url("member/getCountryfilter");?>',
      type : 'POST',
      data : 'country_id='+$(this).val(),
	  
      dataType : 'json',
      success : function(data){
        var html = '';
        var preCource = '<?php echo $params['state_id'];?>';
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
      url : '<?php echo base_url("member/getCityfilter");?>',
      type : 'POST',
      data : 'state_id='+$(this).val(),
      dataType : 'json',
      success : function(data){
		  
		 //alert(data); 
        var html = '';
        var preCource = '<?php echo $params['city_id'];?>';
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
