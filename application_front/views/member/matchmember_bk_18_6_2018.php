      
        <section class="main-container">
            <div class="container-fluid">
                <div class="row">
                    <?php $this->load->view('layout/member_left_menu')?>
                    <div class="col-md-10">
                    
                    <div class="row searchCounselor">
                    	<div class="col-md-12 col-sm-12"><h3>Match Member</h3></div>
                        <div class="col-md-12 col-sm-6">
                        	 <div id="counselling-search-input">
                            <div class="input-group col-md-12">
                                <!--<input type="text" class="  search-query form-control" placeholder="Enter city or country or ZIP code" />-->
								
								<form action ="<?php echo base_url().'member/filter_mymatch'?>" method="post" name="search_counselor">
								
								
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
								<select name="loking_for" id="loking_for" class="form-control">
									<option value=""> Looking For </option>
									<option value="1" <?php if(isset($params['loking_for']) && $params['loking_for']=='1') echo 'selected';?>> Male </option>
									<option value="2" <?php if(isset($params['loking_for']) && $params['loking_for']=='2') echo 'selected';?>> Fenale </option>	
									<option value="3" <?php if(isset($params['loking_for']) && $params['loking_for']=='3') echo 'selected';?>> Both </option>	
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
									<input type="submit" value="Search Counselor" class="showTipsBtn">
								</div>
								
                               
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
										 <div class="textSec">
											<a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i> </a>
										 <a href="#"><i class="fa fa-video-camera" aria-hidden="true"></i> </a>
										 <p><?php echo $memberDetails['name'].','.$memberDetails['age']?></p>
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
