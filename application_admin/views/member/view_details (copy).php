<?php
//pr($data);
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Personal Details</span>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Picture <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
    		<?php
			if($picture==''){ ?>
				<img src="https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg" alt="" class="img-responsive" style="width:100px;height:100px">
			<?php }else{
				if(isset($oauth_uid) && $oauth_uid==''){ ?>
					<img src="<?php echo $picture; ?>" alt="" class="img-responsive" style="width:100px;height:100px"/>
				<?php }else{?>
					<img src="<?php echo $picture; ?>" alt="" class="img-responsive" style="width:100px;height:100px"/>
				<?php } } ?>
			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Name<span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="name" name="name" value="<?php echo $name;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">About Me</label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="about_me" name="about_me" value="<?php echo $about_me;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Email <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="email" name="email" value="<?php echo $email;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6"> Phone Number <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="phone_number" name="phone_number" value="<?php echo $phone_no;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<?php
			$interested_in_d='';
            switch ($interested_in){
                case 1:
                    $interested_in_d="Male";
                    break;
                case 2:
                    $interested_in_d="Female";
                    break;
                case 3:
                    $interested_in_d="Both";
                    break;
            }
        ?>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Looking For <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="interested_in" name="interested_in" value="<?php echo $interested_in_d;?>" readonly>

			</div>
		</div>
		
		
		<div class="clearfix"></div><br/>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Children <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="have_kids" name="have_kids" value="<?php echo $have_kids;?>" readonly>

			</div>
		</div>
		
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6"> Interest <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <ul class="unstyled ">
                <?php                                
					if(!empty($member_interest)){
						foreach ($member_interest as $interestDetails){
							if($interestDetails['name']==''){ continue; }
                            ?>
                                <li>
                                    <strong> <?php echo $interestDetails['name']; ?></strong>
                                </li>
                            <?php 
                        }
                    }else{
                        echo 'This user did not added any interest';
                    } ?>
                </ul>

			</div>
		</div>
		<div class="clearfix"></div><br/>
	  </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Appearance Details</span>
		
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">About Me</label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="about_me" name="about_me" value="<?php echo $about_me;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Profile Heading <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="profile_heading" name="profile_heading" value="<?php echo $profile_heading;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6"> Height (feet & inches) <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="height" name="height" value="<?php echo $height."feet ".$height_inches." inches"; ?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Body Type<span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="bodyType" name="bodyType" value="<?php echo $bodyType;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Hair Type <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="hairType" name="hairType" value="<?php echo $hairType;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Eye <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="eyeType" name="eyeType" value="<?php echo isset($eyeType)?$eyeType:''; ?>" readonly>

			</div>
		</div>
		
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Age <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="age" name="age" value="<?php echo $age;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Country <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="countriesType" name="countriesType" value="<?php echo $countriesType;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">State<span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="statesType" name="statesType" value="<?php echo $statesType;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">City <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="citiesType" name="citiesType" value="<?php echo $citiesType;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Zip <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="zip" name="zip" value="<?php echo $zip;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Gender <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="zip" name="zip" value="<?php echo ($man_woman==1)?'Male':'Female';?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		
		
	  </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Lifestyle Details</span>
		
		
		<?php
			$smoking_d="";
            switch (isset($smoking)?$smoking:''){
                case 1:
                    $smoking_d="Non Smoker";
                    break;
                case 2:
                    $smoking_d="Light Smoker";
                    break;
                case 3:
                    $smoking_d="High Smoker";
                    break;
            }
        ?>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Drinking <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="smoking_d" name="smoking_d" value="<?php echo $smoking_d;?>" readonly>

			</div>
		</div>

		<div class="clearfix"></div><br/>
		<?php
			$drinking_d="";
            switch (isset($drinking)?$drinking:''){
                case 1:
                    $drinking_d="Non Smoker";
                    break;
                case 2:
                    $drinking_d="Light Smoker";
                    break;
                case 3:
                    $drinking_d="High Smoker";
                    break;
            }
        ?>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Drinking <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="drinking_d" name="drinking_d" value="<?php echo $drinking_d;?>" readonly>

			</div>
		</div>

		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Occupation <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="occupation" name="occupation" value="<?php echo $occupation;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Income <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="income" name="income" value="<?php echo isset($income)?$income:''; ?>" readonly>

			</div>
		</div>
		</div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Relationship Details</span>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Have kids <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="have_kids" name="have_kids" value="<?php echo $have_kids;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Want kids <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="want_kids" name="want_kids" value="<?php echo ($want_kids==1)?'Yes':'No';?>" readonly>

			</div>
		</div>
		
	  </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Background Details</span>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Ethnicity <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="ethnicityType" name="ethnicityType" value="<?php echo $ethnicityType;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Faith <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="faithType" name="faithType" value="<?php echo $faithType;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Language<span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="languageType" name="languageType" value="<?php echo $languageType;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Country <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="countriesType" name="countriesType" value="<?php echo $countriesType;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">State<span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="statesType" name="statesType" value="<?php echo $statesType;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">City <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="citiesType" name="citiesType" value="<?php echo $citiesType;?>" readonly>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Education <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <input class="validate[required] form-control" type="text" id="educationType" name="educationType" value="<?php echo $educationType;?>" readonly>

			</div>
		</div>
	  </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Activities/Exercise Details</span>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Indoor activities <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <?php echo $indoor_activities_data;?>

			</div>
		</div>
		<div class="clearfix"></div><br/>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Outdoor activities <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <?php echo $outdoor_activities_data;?>

			</div>
		</div>
		
	  </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Pets Details</span>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">His/Her like <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <?php echo $pet_data;?>

			</div>
		</div>
		
		
	  </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Zodiac Details</span>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Sign <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <?php echo $sign;?>

			</div>
		</div>
		
		
	  </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Politics Details</span>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">His/Her Views <span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <?php echo $politics_view;?>

			</div>
		</div>
		
		
	  </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
	  	<span class="section">Vacation Details</span>
		
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-6">Best Place<span class="required"></span></label>
			<div class="col-md-6 col-sm-6 col-xs-6">
			   <?php echo $vacation_place_data;?>

			</div>
		</div>
		
		
	  </div>
    </div>
  </div>

</div>
