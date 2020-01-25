<?php
class Member extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'member';
		$this->load->model('ModelMember');
		$this->load->model('ModelCommon');
        $this->config->load('paypal_config');	
		//error_reporting(E_All);
	}

	public function index()
	{
        redirect(base_url());
    }
	
	public function emailExist(){
		$email_id = $this->input->post('email');
		$return = $this->ModelMember->checkEmail($email_id);
		if(count($return)>0){
			$error = 1;
		}else{
			$error = 0;
		}
		echo json_encode(array('error'=>$error));
	}
    public function checkUsername(){
        $username = $this->input->post('username');
        $return = $this->ModelMember->checkUsername($username);
        if(count($return)>0){
            $error = 1;
        }else{
            $error = 0;
        }
        echo json_encode(array('error'=>$error));
    }
	function doMemberReg(){
		$return = $this->ModelMember->checkEmail($this->input->request('email'));
		if(count($return)>0){
            $this->nsession->set_userdata('errmsg','Email already exits.');
            redirect(base_url());
		}else{
			$data['member_type']		    = 1;
			$data['email'] 				    = $this->input->post('email');
			$data['man_woman']              = $this->input->post('man_woman');
            $data['maritial_status']        = $this->input->post('maritial_status');
            $data['interested_in']          = $this->input->post('interested_in');
			$data['password'] 			    = md5($this->input->post('password'));
			$data['created']			    = date('Y-m-d H:i:s');
			$data['profile_step']			= 1;
			
			$data['expire_date']			= date('Y-m-d H:i:s', strtotime($data['created']. ' + 1 days'));
			
			$insert_id 					    = $this->ModelMember->memberReg($data);
			if($insert_id){
			    $step2Link      = base_url('member/step2/'.base64_encode($insert_id));
				$to 			= $data['email'];
				$subject		= "Registration";
				$body			= "<tr><td>Hi,</td></tr>
									<tr><td>Thanks for opening an account on our platform.Please click on link to complete your profile <a href='".$step2Link."'>Click here</a> </td></tr>";
				$this->functions->mail_template($to,$subject,$body);
                $this->nsession->set_userdata('succmsg','Thanks for opening an account on our platform.Please verify email to complete your account.');
                redirect(base_url());
			}else{
                $this->nsession->set_userdata('errmsg','Some server problem occur.Please try again');
                redirect(base_url());
			}
		}
	}
    function ChangeCoverImg(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id = $this->nsession->userdata('member_session_id');
        $coverImg                = $_FILES['coverImg']['name'];
        $new_coverImg            = time().$coverImg;
        $config['upload_path'] 	 = file_upload_absolute_path().'cover_image/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 5120;
        //$config['max_width']     = 300;
        //$config['max_height']    = 200;
        $config['file_name']     = $new_coverImg;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('coverImg')) {
            $this->nsession->set_userdata('errmsg', $this->upload->display_errors());
            redirect(base_url('member/profile'));
            return true;
        }else {
            $upload_data = array('upload_data' => $this->upload->data());
        }
        if($upload_data['upload_data']['file_name']) {
            $data['cover_image'] = file_upload_base_url().'cover_image/'.$upload_data['upload_data']['file_name'];
            $this->ModelMember->doSaveProfileData($member_id,$data);
            $this->nsession->set_userdata('coverImg',$data['cover_image']);
            $this->nsession->set_userdata('succmsg', 'Cover image updated successfully.');
            redirect(base_url('member/profile'));
            return true;
        }else{
            $this->nsession->set_userdata('errmsg', $this->upload->display_errors());
            redirect(base_url('member/profile'));
            return true;
        }
    }
    function ChangeProfileImg(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id = $this->nsession->userdata('member_session_id');
       


	 /*   $profileImg                = $_FILES['profileImg']['name'];
        $new_profileImg            = time().$profileImg;
        $config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 5120;
        //$config['max_width']     = 300;
        //$config['max_height']    = 200;
        $config['file_name']     = $new_profileImg;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload('profileImg')) {
            $this->nsession->set_userdata('errmsg', $this->upload->display_errors());
            redirect(base_url('member/profile'));
            return true;
        }else {
            $upload_data = array('upload_data' => $this->upload->data());
        } */
		
		$this->load->library('image_lib');
        $config['image_library']    = 'GD2';
		
		$memberImage             = $_FILES['profileImg']['name'];
        $fileMemberImage         = time().$memberImage;
        $config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name']     = $fileMemberImage;
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('profileImg')) {
            $this->nsession->set_userdata('errmsg',$this->upload->display_errors());
            //redirect(base_url('member/step2/'.base64_encode($memberId)));
            return true;
        } else {
            $upload_data = array('upload_data' => $this->upload->data());
            $dataSet = $this->upload->data();
            $Imgdata = $this->upload->data();
            $source_path = file_upload_absolute_path() . 'profile_pic/' . $dataSet["file_name"];
            $target_path = file_upload_absolute_path() . '/profile_pic/tmp/' . $dataSet["file_name"];
            $configer = array(
                'image_library' => 'gd2',
                'source_image' => $source_path,
                'new_image' => $target_path,
                'maintain_ratio' => TRUE,
                'create_thumb' => TRUE,
                'width' => 223,
                'height' => 247
            );
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
            $this->image_lib->clear();
            $Imgdata['thamble_image'] = $dataSet['file_name'];			
        }
		
		
        if($upload_data['upload_data']['file_name']) {
			$implodeData = explode('.',$upload_data['upload_data']['file_name']);
			$thumbImgNme = $implodeData[0].'_thumb.'.$implodeData[1];
            $data['picture'] = file_upload_base_url().'profile_pic/'.$upload_data['upload_data']['file_name'];
            $data['crop_profile_image'] = file_upload_base_url().'/profile_pic/tmp/'.$thumbImgNme;
            $this->ModelMember->doSaveProfileData($member_id,$data);
            $this->nsession->set_userdata('profileImg',$data['picture']);
            $this->nsession->set_userdata('succmsg', 'Profile image updated successfully.');
            redirect(base_url('member/profile'));
            return true;
        }else{
            $this->nsession->set_userdata('errmsg', $this->upload->display_errors());
            redirect(base_url('member/profile'));
            return true;
        }
    }
   function step2()
	{
		$memberId = base64_decode($this->uri->segment(3));		
		$checkdate = $this->ModelMember->checkExpireDate($memberId);		
		if($checkdate){		
			if($memberId!=''){
				if($this->ModelMember->checkIfStep2Complate($memberId)){
					$data['controller'] = $this->controller;

					$data['succmsg'] = $this->nsession->userdata('succmsg');
					$data['errmsg'] = $this->nsession->userdata('errmsg');

					$this->nsession->set_userdata('succmsg', "");
					$this->nsession->set_userdata('errmsg', "");

					$elements = array();
					$elements['main'] = 'member/step2';
					$element_data['main'] = $data;
					$this->layout->setLayout('layout_home');
					$this->layout->multiple_view($elements,$element_data);
				}else{
					$this->nsession->set_userdata('errmsg','Please login to access your account.');
					redirect(base_url());
				}
			}else{
				redirect(base_url());
				return true;
			}
		}else{           
		   $this->nsession->set_userdata('errmsg','Your link has been expire Please connect MMR admin.');
			 redirect(base_url());
		 }			
	}
	
    function profile($memberid=0)
    {
		$this->functions->checkUser($this->controller.'/',true);
		$base_64 = $memberid . str_repeat('=', strlen($memberid) % 4);
		$member_id = base64_decode($base_64);
		
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        if($member_id==0){
            $member_id              = $this->nsession->userdata('member_session_id');
            $data['profileView']    = 0;
            $data['memberId'] = $member_id;
        }else{
            $member_id = $member_id;
            $data['profileView'] = 1;
            $data['memberId'] = $member_id;
			$data['my_favrite'] = $this->ModelCommon->getSingleData('my_favorite',array('member_id'=>$this->nsession->userdata('member_session_id'),'favorite_member_id'=>$member_id));
			
        }

        $data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['memberMoreData'] = $this->ModelMember->getMemberMoreData($member_id);

		$data['memberInterest']     = $this->ModelMember->getMemberInterest($member_id);
		$data['memberPhoto']     = $this->ModelMember->getMemberphoto($member_id);
		$data['membervideo']     = $this->ModelMember->getMembervideo($member_id);
		
		//pr($data['membervideo']);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/profile';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);

    }
	
    function appearance(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileData'] = $this->ModelMember->getProfileData();
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		
		//pr($data['profileMoreData']);
		
        $data['bodyTypes'] = $this->functions->getTableData('body_type',array('is_active'=>1));
        $data['hairTypes'] = $this->functions->getTableData('hair_type',array('is_active'=>1));
        $data['eyeTypes'] = $this->functions->getTableData('eye_type',array('is_active'=>1));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        // pr($data['profileData']);
		$data['allcountry']		= $this->ModelMember->getCountry();
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/appearance';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveAppearanceData(){
		
        $this->functions->checkUser($this->controller.'/',true);
        $member_id          = $this->nsession->userdata('member_session_id');
        $memberData['name']   = $this->input->post('name');
        $memberData['about_me']   = $this->input->post('about_me');
        $memberMoreData['height']     = $this->input->post('height');
        $memberMoreData['body_type']  = $this->input->post('body_type');
        $memberMoreData['hair']       = $this->input->post('hair');
        $memberMoreData['eye']        = $this->input->post('eye');
        $memberData['profile_heading']        = $this->input->post('profile_heading');
		
        $memberData['country']        = $this->input->post('country_id');
        $memberData['state']       	  = $this->input->post('state_id');
        $memberData['city']        	  = $this->input->post('city_id');
        $memberData['zip']       	  = $this->input->post('zip');
        $memberData['age']       	  = $this->input->post('age');
		$memberData['man_woman']        = $this->input->post('interest');
		
        $this->ModelMember->doSaveAppearanceData($member_id,$memberData,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Appearance data updated successfully.');
        redirect(base_url('member/appearance'));
    }
    function lifestyle(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));

		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        // pr($data['profileData']);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/lifestyle';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveLifestyleData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                      = $this->nsession->userdata('member_session_id');
        $memberMoreData['smoking']      = $this->input->post('smoking');
        $memberMoreData['drinking']     = $this->input->post('drinking');
        $memberMoreData['occupation']   = $this->input->post('occupation');
        $memberMoreData['income']       = $this->input->post('income');
		
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Lifestyle data updated successfully.');
        redirect(base_url('member/lifestyle'));
    }
    function relationship(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/relationship';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveRelationshipData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                      = $this->nsession->userdata('member_session_id');
        $memberMoreData['have_kids']      = $this->input->post('have_kids');
        $memberMoreData['want_kids']     = $this->input->post('want_kids');
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Relationship data updated successfully.');
        redirect(base_url('member/relationship'));
    }
    function background(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));

		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['ethnicityTypes'] = $this->functions->getTableData('ethnicity',array('is_active'=>1));
        $data['faithTypes']     = $this->functions->getTableData('faith',array('is_active'=>1));
        $data['languageTypes']  = $this->functions->getTableData('language',array('is_active'=>1));
        $data['countriesTypes'] = $this->functions->getTableData('countries',array());
        $data['educationTypes'] = $this->functions->getTableData('education',array('is_active'=>1));

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/background';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveBackgroundData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                      = $this->nsession->userdata('member_session_id');
        $memberMoreData['ethnicity']    = $this->input->post('ethnicity');
        $memberMoreData['faith']        = $this->input->post('faith');
        $memberMoreData['language']     = $this->input->post('language');
        $memberMoreData['country']      = $this->input->post('country');
        $memberMoreData['state']        = $this->input->post('state');
        $memberMoreData['city']         = $this->input->post('city');
        $memberMoreData['education']    = $this->input->post('education');
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Background data updated successfully.');
        redirect(base_url('member/background'));
    }
    function activities(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['indoorActivities'] = $this->functions->getTableData('indoor_activities',array('is_active'=>1));
        $data['outdoorActivities']= $this->functions->getTableData('outdoor_activities',array('is_active'=>1));


        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/activities';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveActivityData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                              = $this->nsession->userdata('member_session_id');
        $memberMoreData['indoor_activities']    = implode(',',$this->input->post('indoor_activities'));
        $memberMoreData['outdoor_activities']   = implode(',',$this->input->post('outdoor_activities'));
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Activities/Exercise data updated successfully.');
        redirect(base_url('member/activities'));
    }
    function pet(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
		
		
        $data['petDatas'] = $this->functions->getTableData('pet',array('is_active'=>1));

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/pet';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function savePetData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                              = $this->nsession->userdata('member_session_id');
        $memberMoreData['pet']    = implode(',',$this->input->post('pet'));
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Pet You data updated successfully.');
        redirect(base_url('member/pet'));
    }
    function zodiac(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/zodiac';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveZodiacData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                 = $this->nsession->userdata('member_session_id');
        $memberMoreData['sign']    = $this->input->post('sign');
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Zodiac data updated successfully.');
        redirect(base_url('member/zodiac'));
    }
    function politics(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/politics';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function savePoliticsData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                          = $this->nsession->userdata('member_session_id');
        $memberMoreData['politics_view']    = $this->input->post('politics_view');
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Updated successfully.');
        redirect(base_url('member/politics'));
    }
    function vacation(){
        $this->functions->checkUser($this->controller.'/',true);
    	$data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $member_id              = $this->nsession->userdata('member_session_id');
        $data['profileView']    = 0;
        $data['memberId'] = $member_id;
        $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['vacationPlaceDatas'] = $this->functions->getTableData('vacation_place',array('is_active'=>1));

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
        
    	$elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/vacation';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function saveVacationData(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id                          = $this->nsession->userdata('member_session_id');
        $memberMoreData['vacation_place']    = implode(',',$this->input->post('vacation_place'));
        $this->ModelMember->doSaveLifestyleData($member_id,$memberMoreData);
        $this->nsession->set_userdata('succmsg','Vacation data updated successfully.');
        redirect(base_url('member/vacation'));
    }
    function counselorDashboard()
    {
        $this->functions->checkUser($this->controller.'/',true);
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['main'] = 'member/counselorDashboard';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);

    }
    function doMemberStep2(){
        $this->load->library('image_lib');
        $config['image_library']    = 'GD2';
        $appcall                    = $this->input->post('appcall');
        $memberId                   = $this->input->post('memberId');
        $data['username']           = $this->input->post('username');
        $data['profile_heading'] 	= $this->input->post('profile_heading');
        $data['dob']                = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day');
        $data['lifestyle'] 	        = $this->input->post('lifestyle');
        $data['about_me']            = $this->input->post('about_me');
        $data['describe_looking_for'] 	= $this->input->post('describe_looking_for');
        $data['profile_step']            = 2;
        $data['success_step']            = 1;

        $memberImage             = $_FILES['file']['name'];
        $fileMemberImage         = time().$memberImage;
        $config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name']     = $fileMemberImage;
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('file')) {
            if($appcall==1){
                $resdata = array('status' => false, 'message' =>$this->upload->display_errors(),'data'=>array());
            }else{
                $this->nsession->set_userdata('errmsg',$this->upload->display_errors());
                redirect(base_url('member/step2/'.base64_encode($memberId)));
                return true;
            }
        } else {
            $upload_data = array('upload_data' => $this->upload->data());
            $dataSet = $this->upload->data();
            $Imgdata = $this->upload->data();
            $source_path = file_upload_absolute_path() . 'profile_pic/' . $dataSet["file_name"];
            $target_path = file_upload_absolute_path() . '/profile_pic/tmp/' . $dataSet["file_name"];
            $configer = array(
                'image_library' => 'gd2',
                'source_image' => $source_path,
                'new_image' => $target_path,
                'maintain_ratio' => TRUE,
                'create_thumb' => TRUE,
                'width' => 280,
                'height' => 280
            );
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
            $this->image_lib->clear();
            $Imgdata['thamble_image'] = $dataSet['file_name'];
        }
        if($upload_data['upload_data']['file_name']) {
            $data['picture'] = file_upload_base_url().'profile_pic/'.$upload_data['upload_data']['file_name'];
			$implodeData = explode('.',$upload_data['upload_data']['file_name']);
			$thumbImgNme = $implodeData[0].'_thumb.'.$implodeData[1];
			$data['crop_profile_image'] = file_upload_base_url().'/profile_pic/tmp/'.$thumbImgNme;
        }else{
            if($appcall==1){
                $resdata = array('status' => false, 'message' => 'File not uploaded.Try Again','data'=>array());
            }else{
                redirect(base_url('member/step2/'.base64_encode($memberId)));
                return true;
            }
        }
        if($this->ModelMember->doSaveProfileData($memberId,$data)){
            if($appcall==1){
                $resdata = array('status' => false, 'message' =>'Account has been completed successfully.Please login to access your account.','data'=>array());
            }else{
                $this->nsession->set_userdata('succmsg','Account has been completed successfully.Please login to access your account.');
                redirect(base_url('login'));
                return true;
            }

        }else{
            if($appcall==1){
                $resdata = array('status' => false, 'message' =>'Some server problem occur.Please try again.','data'=>array());
            }else{
                $this->nsession->set_userdata('errmsg','Some server problem occur.Please try again.');
                redirect(base_url('member/step2/'.base64_encode($memberId)));
                return true;
            }
        }
        if($appcall==1){
            echo json_encode($resdata);
        }
    }
	function update_account(){
        $this->functions->checkUser($this->controller.'/',true);
		$member_id 			= $this->nsession->userdata('member_session_id');
		$membertype 		= $this->nsession->userdata('member_session_membertype');
		$data['first_name'] = $this->input->post('first_name');
		$data['last_name'] 	= $this->input->post('last_name');
		$data['phone_no'] 	= $this->input->post('phone_no');
		$data['modified'] 	= date('Y-m-d H:i:s');
		$this->ModelMember->updateAccount($member_id,$data);
		if($membertype==1){
			$this->nsession->set_userdata('succmsg','Account has been updated successfully.');
			redirect(base_url('owner'));
			return true;
		}else{
			$this->nsession->set_userdata('succmsg','Account has been updated successfully.');
			redirect(base_url('renter'));
			return true;
		}
	}
	function update_password(){
        $this->functions->checkUser($this->controller.'/',true);
		$member_id 								= $this->nsession->userdata('member_session_id');
		$membertype 							= $this->nsession->userdata('member_session_membertype');
		$data['old_password'] 		= $this->input->post('old_password');
		$data['new_password'] 		= $this->input->post('new_password');
		$data['cfm_new_password'] = $this->input->post('cfm_new_password');
		$checkPassword = $this->ModelMember->checkOldPassword($member_id,$data);
		if($checkPassword==0){ //Invalid old password
			$this->nsession->set_userdata('errmsg', 'Invalid old password.');
			if($membertype==1){
				redirect(base_url('owner'));
				return true;
			}else{
				redirect(base_url('renter'));
				return true;
			}
		}else{ //Valid old password
		$retunCheck = $this->ModelMember->updatePassword($data,$member_id);
			if($retunCheck){
				$this->nsession->set_userdata('succmsg', 'Password updated successfully.');
				if($membertype==1){
					redirect(base_url('owner'));
					return true;
				}else{
					redirect(base_url('renter'));
					return true;
				}
			}
		}
	}
	function chang_profile_pic(){
        $this->functions->checkUser($this->controller.'/',true);
		$member_id = $this->nsession->userdata('member_session_id');
		$membertype = $this->nsession->userdata('member_session_membertype');

		$oauth_uid = $this->functions->getNameTable('member','oauth_uid','id',$member_id);

		$profile_pic = $_FILES['profile_pic']['name'];
		$new_profile_pic = time().$profile_pic;
		$config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
		$config['allowed_types'] = '*';
		//$config['max_size']      = 20480;
		//$config['max_width']     = 300;
		//$config['max_height']    = 200;
		$config['file_name']     = $new_profile_pic;
		//$this->load->library('upload', $config);

		$this->upload->initialize($config);
		if (!$this->upload->do_upload('profile_pic')) {
			$this->nsession->set_userdata('errmsg', $this->upload->display_errors());
			if($membertype==1){
				redirect(base_url('owner'));
				return true;
			}else{
				redirect(base_url('renter'));
				return true;
			}
		}else {
			$upload_data = array('upload_data' => $this->upload->data());
		}
		if($upload_data['upload_data']['file_name']) {
			if($oauth_uid==''){
				$data['picture'] = $upload_data['upload_data']['file_name'];
			}else{
				$data['picture'] = file_upload_base_url().'profile_pic/'.$upload_data['upload_data']['file_name'];
			}
		}else{
			$data['picture'] = "";
		}
		$this->ModelMember->updateProfileImage($member_id,$data);
		$this->nsession->set_userdata('succmsg', 'Profile image updated successfully.');
		if($membertype==1){
			redirect(base_url('owner'));
			return true;
		}else{
			redirect(base_url('renter'));
			return true;
		}
	}
    function membershipplan(){
        $this->functions->checkUser($this->controller.'/',true);

        $data['controller'] = $this->controller;

        $data['succmsg']    = $this->nsession->userdata('succmsg');
        $data['errmsg']     = $this->nsession->userdata('errmsg');

        $member_id = $this->nsession->userdata('member_session_id');

        $checkIfPaymentDone = $this->ModelMember->checkIfPaymentDone($member_id);
        $data['membershipPlans']  = $this->functions->getTableData('membership_plan',array('is_active'=>1));
        if(count($checkIfPaymentDone)==0){
            $data['isPremiumMemmber'] = 0;
        }else{
            $data['planDetails'] = $checkIfPaymentDone;
            $data['isPremiumMemmber'] = 1;
        }

		$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/membershipplan';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
    }
    function membershipPlanPayment(){

        $this->functions->checkUser($this->controller.'/',true);

        $memberId = $this->nsession->userdata('member_session_id');

        $planId = base64_decode($this->uri->segment(3));

        $getPlanDetails = $this->functions->getTableData('membership_plan',array('plan_id'=>$planId));

        $data['memberInfo'] = $this->functions->getTableData('member',array('id'=>$memberId));


        if($getPlanDetails[0]['plan_id']!=''){
            $data['controller'] = $this->controller;

            $data['getPlanDetails'] = $getPlanDetails;

            $data['succmsg'] = $this->nsession->userdata('succmsg');
            $data['errmsg'] = $this->nsession->userdata('errmsg');

            $this->nsession->set_userdata('succmsg', "");
            $this->nsession->set_userdata('errmsg', "");

            $elements = array();
            $elements['header'] = 'layout/headerInner';
            $element_data['header'] = $data;
            $elements['main'] = 'member/membershipPlanPayment';
            $element_data['main'] = $data;
            $elements['footer'] = 'layout/footer';
            $element_data['footer'] = $data;
            $this->layout->setLayout('layout_inner');
            $this->layout->multiple_view($elements,$element_data);
        }else{
            redirect(base_url('member/profile'));
        }
    }
    function doMembershipPayment(){

        $memberId = $this->nsession->userdata('member_session_id');
        $name       = $this->input->post('name');
        $email_id   = $this->input->post('email_id');
        $anyone_visable   = $this->input->post('anyone_visable');

        $planId = $this->input->post('planId');
		
		

        $getPlanDetails = $this->functions->getTableData('membership_plan',array('plan_id'=>$planId));

        switch($getPlanDetails[0]['plantype']){
            case '3 Months':
                        $payAmt = $getPlanDetails[0]['price'];
                        $billingCycle = 3;
                            break;
            case '6 Months':
                        $payAmt = $getPlanDetails[0]['price'];
                        $billingCycle = 6;
                            break;
            case '12 Months':
                        $payAmt = $getPlanDetails[0]['price'];
                        $billingCycle = 12;
                            break;
        }
		
		

        $ccNbr          = $this->input->post('ccNbr');
        $cvv            = $this->input->post('cvv');
        $expiryMonth    = $this->input->post('expiryMonth');
        $expiryYear     = $this->input->post('expiryYear');
        $nameOnCard     = explode(' ',$this->input->post('nameOnCard'));

        $cardtype           = "unknown";
        $mastercardregex    = "/^5[1-5]/";
        $visacardregex      = "/^4/";
        $amexcardregex      = "/^3[47]/";
        if(preg_match($mastercardregex, $ccNbr))
        {
            $cardtype = 'mastercard';
        }
        else if (preg_match($visacardregex, $ccNbr))
        {
            $cardtype = "visa";
        }
        else if (preg_match($amexcardregex, $ccNbr))
        {
            $cardtype = "amex";
        }

        if(count($nameOnCard)==1){
            $first_name 	= $nameOnCard[0];

        }else if(count($nameOnCard) ==2){

            $first_name 	= $nameOnCard[0];
            $last_name 		= $nameOnCard[1];

        }else if(count($nameOnCard) == 3){

            $first_name 	= $nameOnCard[0];
            $middle_name 	= $nameOnCard[1];
            $last_name 		= $nameOnCard[2];
        }

        $DaysTimestamp = strtotime('now');
        $Mo = date('m', $DaysTimestamp);
        $Day = date('d', $DaysTimestamp);
        $Year = date('Y', $DaysTimestamp);
        $StartDateGMT = $Year . '-' . $Mo . '-' . $Day . 'T00:00:00\Z';
        $request_params = array
        (
            'METHOD' => 'CreateRecurringPaymentsProfile',
            'USER' => $this->config->item('api_username'),
            'PWD' => $this->config->item('api_password'),
            'SIGNATURE' => $this->config->item('api_signature'),
            'VERSION' => $this->config->item('api_version'),
            'PAYMENTACTION' => 'Sale',
            'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
            'CREDITCARDTYPE' => $cardtype,
            'ACCT' => $ccNbr,
            'EXPDATE' => $expiryMonth.$expiryYear,
            'CVV2' => $cvv,
            'FIRSTNAME' => $first_name,
            'MIDDLENAME' => $middle_name?$middle_name:'',
            'LASTNAME' => $last_name?$last_name:'',
            //'STREET' => $location,
            //'CITY' => 'Largo',
            //'STATE' => 'FL',
            //'COUNTRYCODE' => 'US',
            //'ZIP' => '33770',
            //'PHONENUMBER'=>$phone_no,
            'EMAIL'=>$email_id,
            'AMT' => $payAmt,
            'CURRENCYCODE' => 'USD',
            'DESC' => 'My Missing Rib Membership Payment',
            'BILLINGPERIOD' => 'Month',
            'BILLINGFREQUENCY' => '1',
            'TOTALBILLINGCYCLES'=>$billingCycle,
            'PROFILESTARTDATE' => $StartDateGMT,
            'MAXFAILEDPAYMENTS' => '3'
        );
        $nvp_string = '';
        foreach($request_params as $var=>$val)
        {
            $nvp_string .= '&'.$var.'='.urlencode($val);
        }
        // Send NVP string to PayPal and store response
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_URL, $this->config->item('api_endpoint'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

        $result = curl_exec($curl);
        curl_close($curl);

        // Parse the API response
        $result_array = $this->NVPToArray($result);
        //pr($result_array);
        if(count($result_array)>0 && $result_array['ACK']=='Success'){
            $memberPayDetails['member_id']                  = $memberId;
            $memberPayDetails['name']                       = $name;
            $memberPayDetails['email']                      = $email_id;
            $memberPayDetails['plan_id']                    = $planId;
            $memberPayDetails['amount']                     = $payAmt;
            $memberPayDetails['txn_id']                     = $result_array['PROFILEID'];
            $memberPayDetails['date_payment']               = date('Y-m-d');
            $memberPayDetails['is_active']                  = 1;
            $memberPayDetails['minute_remaning']            = $getPlanDetails[0]['minute'];
            $memberPayDetails['tips_reads_remaning']        = $getPlanDetails[0]['tips_reads'];
            $memberPayDetails['messaging_remaining']        = $getPlanDetails[0]['messaging'];
            $memberPayDetails['membership_plan_data']       = json_encode($getPlanDetails[0]);
            $memberPayDetails['expiry_date']                = date('Y-m-d',strtotime("+".$billingCycle.' Months'));
           
			$datafuture['future_member']				    = $anyone_visable;
			
		    $this->ModelMember->savePaymentData($memberPayDetails);
		    $this->ModelMember->updatefutureMember($memberId,$datafuture);
			
			
			$to 			= $email_id;			
			$subject		= "Successfully Subscribe";
			$body			= "<tr><td>Hi, Member</td></tr>
								<tr><td> you have successfully subscribed for ".$billingCycle." months plans. You now have access to ".base_url()." and your plan will expire on ".$memberPayDetails['expiry_date']." </td></tr>";
								
			$this->functions->mail_template($to,$subject,$body);
			
            $error = 0;
            $message = 'Payment Done successfully';
            $this->nsession->set_userdata('succmsg', $message);
        }else{
            $error = 1;
            $message = $result_array['L_LONGMESSAGE0']!=''?$result_array['L_LONGMESSAGE0']:'Payment failed.Please try again';
        }
        echo json_encode(array('error'=>$error,'message'=>$message));
    }
	function cancelMembershipPlan(){
        $this->functions->checkUser($this->controller.'/',true);
        $member_id      = $this->nsession->userdata('member_session_id');
        $paymentData    = $this->ModelMember->checkIfPaymentDone($member_id);
        $request_params = array
        (
            'METHOD'    => 'ManageRecurringPaymentsProfileStatus',
            'USER' => $this->config->item('api_username'),
            'PWD' => $this->config->item('api_password'),
            'SIGNATURE' => $this->config->item('api_signature'),
            'VERSION' => $this->config->item('api_version'),
            'PROFILEID' => $paymentData['txn_id'],
            'ACTION'    => 'Cancel',
            'NOTE'      => 'My Missing Rib Member cancel payment'
        );
        $nvp_string = '';
        foreach($request_params as $var=>$val)
        {
            $nvp_string .= '&'.$var.'='.urlencode($val);
        }
        // Send NVP string to PayPal and store response
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_URL, $this->config->item('api_endpoint'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

        $result = curl_exec($curl);
        curl_close($curl);
        $result_array = $this->NVPToArray($result);
        if(count($result_array)>0 && $result_array['ACK']=='Success'){
            $this->ModelMember->updateMembershipStatus($paymentData['id']);
            $this->nsession->set_userdata('succmsg', 'Successfully subscription plan has been canceled.');
        }else{
            $this->nsession->set_userdata('errmsg', $result_array['L_LONGMESSAGE0']);
        }
        redirect(base_url('member/membershipplan'));
        return true;
    }
	/* function counselor1()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$data['succmsg'] = $this->nsession->userdata('succmsg');
		$data['errmsg'] = $this->nsession->userdata('errmsg');

		
		//$data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['counselor'] = $this->ModelMember->getcounselor();
		
		//pr($data['counselor']);
		
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/allcounselor';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	} */
	
	function counselor1()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/counselor/");

		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";

		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;

		$data['controller'] = $this->controller;

		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','12');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');

		$data['counselor']		= $this->ModelMember->getcounselorList($config,$start,$param);
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_counselor');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
	    $data['user_id'] = $memberId ;
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/allcounselor';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);

	}
	
	function counselor()
	{
		$this->functions->checkUser($this->controller.'/',true);		
		$country_id = $this->input->post('country_id');
		$state_id = $this->input->post('state_id');
		$city_id = $this->input->post('city_id');
		$zip = $this->input->post('zip');		
		//echo $country_id; die;		
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/counselor/");

		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";

		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;

		$data['controller'] = $this->controller;

		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','12');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		$data['counselor']		= $this->ModelMember->filter_counselor($config,$start,$param,$country_id,$state_id,$city_id,$zip);
		
		$data['paidMember']     = $this->ModelMember->getCheckpaid($memberId);
		
		//pr($data['paidMember']);
		
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_counselor');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/allcounselor';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	function getCountry()
	{
	   $catId = $this->input->post('country_id');		
	   echo json_encode($this->functions->getAllTable('states','id,name','country_id',$catId));
	}
	
	function getCity()
	{
	   $catId= $this->input->post('state_id');
	   echo json_encode($this->functions->getAllTable('cities','id,name','state_id',$catId));
	}
	
	
	function search_old()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/search/");

		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";

		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;

		$data['controller'] = $this->controller;

		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','12');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');

		$data['member']		= $this->ModelMember->getmemberList($config,$start,$param,$memberId);
		
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_counselor');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/allmember';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	function filter_member()
	{
		$this->functions->checkUser($this->controller.'/',true);		
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/search/");
		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";
		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;
		$data['controller'] = $this->controller;
		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','12');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');
		
		$param['country_id'] 		    = $this->input->request('country_id','');
        $param['state_id'] 	    = $this->input->request('state_id','');
        $param['city_id'] 	= $this->input->request('city_id','');
        $param['zip'] 	= $this->input->request('zip','');
        $param['loking_for'] 	= $this->input->request('loking_for','');
        $param['age_from'] 	= $this->input->request('age_from','');
        $param['age_to'] 	= $this->input->request('age_to','');
		
        $param['education'] 	= $this->input->request('education','');
        $param['language'] 	= $this->input->request('language','');
        $param['have_kids'] 	= $this->input->request('have_kids','');
        $param['smoking'] 	= $this->input->request('smoking','');
        $param['drinking'] 	= $this->input->request('drinking','');
        $param['height'] 	= $this->input->request('height','');
        $param['body_type'] 	= $this->input->request('body_type','');
        $param['eye'] 	= $this->input->request('eye','');
        $param['hair'] 	= $this->input->request('hair','');
		
		//echo $param['education']; die;
				
		$data['member']		= $this->ModelMember->filter_member($config,$start,$param,$memberId);
		
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$this->pagination->initialize($config);
		
		$data['params'] 			= $this->nsession->userdata('ADMIN_MEMBER');
		
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/allmember';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	function getCountryfilter()
	{
	   $catId = $this->input->post('country_id');			
	   echo json_encode($this->functions->getAllTable('states','id,name','country_id',$catId));
	}
	
	function getCityfilter()
	{
	   $catId= $this->input->post('state_id');
	   echo json_encode($this->functions->getAllTable('cities','id,name','state_id',$catId));
	}
	
	
	
	function mymatch_bk()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/mymatch/");

		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";

		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;

		$data['controller'] = $this->controller;

		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','12');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');

		$data['member']		= $this->ModelMember->getmemberList($config,$start,$param,$memberId);
		
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_counselor');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/matchmember';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	function filter_mymatch()
	{
		$this->functions->checkUser($this->controller.'/',true);		
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/filter_mymatch/");
		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";
		$this->pagination->setAdminPaginationStyle($config);
		$start = 0;
		$data['controller'] = $this->controller;
		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','12');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');
		
		$param['country_id'] 		    = $this->input->request('country_id','');
        $param['state_id'] 	    = $this->input->request('state_id','');
        $param['city_id'] 	= $this->input->request('city_id','');
        $param['zip'] 	= $this->input->request('zip','');
        $param['loking_for'] 	= $this->input->request('loking_for','');
        $param['age_from'] 	= $this->input->request('age_from','');
        $param['age_to'] 	= $this->input->request('age_to','');
				
		$data['member']		= $this->ModelMember->filter_matchmember($config,$start,$param);
		
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$this->pagination->initialize($config);
		
		$data['params'] 			= $this->nsession->userdata('ADMIN_MEMBER');
		
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/matchmember';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
    function NVPToArray($NVPString)
    {
        $proArray = array();
        while(strlen($NVPString))
        {
            // name
            $keypos= strpos($NVPString,'=');
            $keyval = substr($NVPString,0,$keypos);
            // value
            $valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
            $valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
            // decoding the respose
            $proArray[$keyval] = urldecode($valval);
            $NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
        }
        return $proArray;
    }
	function search()
	{
		$this->functions->checkUser($this->controller.'/',true);
		
		$search = $_POST;
		$memberId = $this->nsession->userdata('member_session_id');
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$membership_paln = get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1));
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//user details
		
		$where =' ';
		if(isset($search['gender']) && $search['gender']!='')
		{	
			$where .='and man_woman='.$search['gender'];
		}
		if((isset($search['from_age']) && $search['from_age']!='')&& $search['to_age']=='')
		{	
			$where .='and age ='.$search['from_age'];
		}
		if((isset($search['from_age']) && $search['from_age']!='')&& (isset($search['to_age']) && $search['to_age']!='') )
		{	
			$where .=' and age between '.$search['from_age'].' and '.$search['to_age'];
		}
		if(isset($search['country']) && $search['country']!='')
		{
			$where .=' and member.country ='.$search['country'];
		}
		if(isset($search['height']) && $search['height']!='')
		{
			$where .=' and height ="'.$search['height'].'"';
		}
		if(isset($search['language']) && $search['language']!='')
		{
			$where .=' and language ='.$search['language'];
		}
		if(isset($search['education']) && $search['education']!='')
		{
			$where .=' and education ='.$search['education'];
		}
		if(isset($search['have_kids']) && $search['have_kids']!='')
		{
			$where .=' and have_kids ="'.$search['have_kids'].'"';
		}
		if(isset($search['smoking']) && $search['smoking']!='')
		{
			$where .=' and smoking ='.$search['smoking'];
		}
		if(isset($search['drinking']) && $search['drinking']!='')
		{
			$where .=' and drinking ='.$search['drinking'];
		}
		if(isset($search['body_type']) && $search['body_type']!='')
		{
			$where .=' and body_type ='.$search['body_type'];
		}
		if(isset($search['eye']) && $search['eye']!='')
		{
			$where .=' and eye ='.$search['eye'];
		}
		if(isset($search['hair']) && $search['hair']!='')
		{
			$where .=' and hair ='.$search['hair'];
		}
		if(isset($search['pincode']) && $search['pincode']!='')
		{
			$where .=' and zip ='.$search['pincode'];
		}
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		$matches = $this->ModelMember->get_search_result($where,0);
		$data['exp_date'] = isset($membership_paln[0]['expiry_date'])?$membership_paln[0]['expiry_date']:'';
		$data['match_list'] = $matches['result'];
		$data['search_string'] = $where;
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/search';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function ajaxMemberSearch($currPage)
	{
		$data = $_POST;
		$matches = $this->ModelMember->get_search_result($data['search_string'],$currPage);
		echo json_encode($matches);
	}
	
	function interest()
	{
		//pr($_POST);
		
		//$this->nsession->set_userdata('succmsg', "");
       // $this->nsession->set_userdata('errmsg', "");
		
		  $member_id              = $this->nsession->userdata('member_session_id');	      
		  $data1['interest_id'] = $this->input->post('interest_chk'); 
		  
		//pr($interest_id);
		  
			$data=array();
		
             for($j = 0; $j < count($data1['interest_id']); $j++){
				 
				 $data[$j]['interest_id'] = $data1['interest_id'][$j];
				 $data[$j]['member_id'] = $member_id;
			 }
			
				$result = $this->ModelMember->insert_interest($data,$member_id);
		 if($result)
			  {
				  $this->nsession->set_userdata('succmsg','Your interest successfully Added.');
			  }
	}
	// my match section
	function mymatch()
	{
		
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$membership_paln = $this->db->get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1))->result_array();

        //pr($membership_paln);
		
		$post = $_POST;
		//echo"<pre>";print_r($post);
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//search section
		$where='';
		 if(isset($post['country']) && $post['country']!='')
		 {
			 $where.=' and member.country='.$post['country'];
		 }
		 if(isset($post['loking_for']) && $post['loking_for']!='')
		 {
			 $where.=' and member.man_woman='.$post['loking_for'];
		 }
		 if((isset($post['age_from']) && $post['age_from']!='')&& $post['age_to']=='' )
		{	
			$where .=' and age ='.$post['age_from'];
		}
		if((isset($post['age_from']) && $post['age_from']!='')&& (isset($post['age_to']) && $post['age_to']!='') )
		{	
			$where .=' and age between '.$post['age_from'].' and '.$post['age_to'];
		}
		//echo $where;exit;
		//echo"<pre>";print_r($post);exit;
		//$data['country'] = get_where('countries');
		$data['country'] = $this->ModelMember->get_country();
				
		$data['search_string'] = $where;
		
		$data['member'] = $this->ModelMember->get_mymatches($memberId,$where,0);
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		$data['exp_date'] = isset($membership_paln[0]['expiry_date'])?$membership_paln[0]['expiry_date']:'';
		//pr($data['memship_plan']);
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/matchmember';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer_v_chat';
		$element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	public function ajaxMatchSearch($currPage)
	{
		$data = $_POST;
		$memberId = $this->nsession->userdata('member_session_id');
		$where = $data['search_string'];
		$matches = $this->ModelMember->get_mymatches($memberId,$where,$currPage);
		echo json_encode($matches);
	}
	public function my_favaourite()
	{
		 $favourite_member_id = $this->input->post('member_id');
		 $memberId = $this->nsession->userdata('member_session_id');
		 $insert_data['member_id'] = $memberId;
		 $insert_data['favorite_member_id'] = $favourite_member_id;
		 $insert_data['is_delete'] = 1;
		 $already_fav = $this->ModelCommon->getSingleData('my_favorite',array('member_id'=>$memberId,'favorite_member_id'=>$favourite_member_id));
		 if(empty($already_fav))
		 {
		   $this->ModelCommon->insertData('my_favorite',$insert_data);
		 }
		 else
		 {
			  if($already_fav['is_delete'] == 1)
			  {
				  $update_data['is_delete'] = 0;
			  }
			  else{
				  $update_data['is_delete'] =1;
			  }
			  $this->ModelCommon->updateData('my_favorite',$update_data,array('member_id'=>$memberId,'favorite_member_id'=>$favourite_member_id));
		 }
		 echo json_encode("success");
	}
	// my match section
	function favourite($param='')
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$membership_paln = get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1));
		$post = $_POST;
		//echo"<pre>";print_r($post);
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//search section
		 $where='';
		 if(isset($post['country']) && $post['country']!='')
		 {
			 $where.=' and member.country='.$post['country'];
		 }
		 if(isset($post['loking_for']) && $post['loking_for']!='')
		 {
			 $where.=' and member.man_woman='.$post['loking_for'];
		 }
		 if((isset($post['age_from']) && $post['age_from']!='')&& $post['age_to']=='' )
		{	
			$where .=' and age ='.$post['age_from'];
		}
		if((isset($post['age_from']) && $post['age_from']!='')&& (isset($post['age_to']) && $post['age_to']!='') )
		{	
			$where .=' and age between '.$post['age_from'].' and '.$post['age_to'];
		}
		
		$data['country'] = get_where('countries');
		$data['search_string'] = $where;
		$data['member'] = $this->ModelMember->get_favaourite($memberId,$where,0);
		$data['search_string'] = $where;
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		$data['param'] =$param;
		$data['exp_date'] = isset($membership_paln[0]['expiry_date'])?$membership_paln[0]['expiry_date']:'';
		
		//pr($data['member']);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/my_favorite';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	public function ajaxfavriteSearch($currPage)
	{
		$data = $_POST;
		$where = $data['search_string'];
		$memberId = $this->nsession->userdata('member_session_id');
		$matches = $this->ModelMember->get_favaourite($memberId,$where,$currPage);
		echo json_encode($matches);
	}
	
	public function blockmember($id)
	{
		$memberId = $this->nsession->userdata('member_session_id');
		$data['from_member_id']= $memberId;
		$data['to_member_id']= $id;
		$data['created_date']=date('Y-m-d');
		$this->ModelMember->block_member($data);
		$this->nsession->set_userdata('succmsg','Member Successfully Blocked.');
		redirect('member/mymatch');
	}

	public function getMemberDetails($member_id,$room=''){
		$userid = explode('_',$member_id);
		$userid = $userid[1];
		$userDetails = $this->ModelMember->getMemberInfo($userid);

		echo json_encode($userDetails);
		return true;
	}
	
	public function block_member_list(){
		
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		//$membership_paln = get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1));
		
		$post = $_POST;
		//echo"<pre>";print_r($post);
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//search section
		
		
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		$data['blockData']     = $this->ModelMember->getBlocklist($memberId);
		
		//pr($data['blockData']);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/blocklist';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function unblockmember($id){
		
		$this->ModelMember->unblock_member($id);		
		$this->nsession->set_userdata('succmsg','Member Successfully unblocked.');
		redirect('member/block_member_list');
	}
	
	public function change_password()
	{		
		$this->functions->checkUser($this->controller.'/',true);
		$data['controller'] = $this->controller;
		
		$memberId = $this->nsession->userdata('member_session_id');				
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$data['memberId'] = $member_id;
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		 $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/changepassword';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function dochangepassword()
	{
		$this->functions->checkUser($this->controller.'/',true);
			$memberId = $this->nsession->userdata('member_session_id');
			$data['oldpassword'] = $this->input->request('oldpassword');
			$isTrue = $this->ModelMember->valideOldPassword($data);
			
			if($isTrue)
			{
				$data['new_admin_pwd'] = $this->input->request('newpassword');
				$this->ModelMember->updateAdminPass($memberId,$data);
				$this->nsession->set_userdata('succmsg',"Password Updated");
			}
			else
			{
				$this->nsession->set_userdata('errmsg',"Invalid Old Password ...");
			}
			
			redirect('member/change_password');		
	}
	
	public function accountdeactive(){
		
		$this->functions->checkUser($this->controller.'/',true);
		$data['controller'] = $this->controller;
		
		$memberId = $this->nsession->userdata('member_session_id');				
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$data['memberId'] = $member_id;
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		 $data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/accountdeactive';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function do_deactiveaccount($id='')
	{
		$memberId = $this->nsession->userdata('member_session_id');
		$data['memberData']     = $this->ModelMember->deactiveaccount($memberId);		
		$this->nsession->set_userdata('succmsg',"Your account Successfully deactive");		
		redirect('logout');
	}
	
	public function upload_image()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$data['controller'] = $this->controller;
		
		$memberId = $this->nsession->userdata('member_session_id');				
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$data['memberId'] = $member_id;
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		$data['profileMoreData'] = $this->functions->getTableData('member_more',array('member_id'=>$this->nsession->userdata('member_session_id')));
		$data['allimg']=$this->ModelCommon->getAllDatalist('member_photo',array('member_id'=>$memberId));
        $data['allvid']=$this->ModelCommon->getAllDatalist('member_video',array('member_id'=>$memberId));
        //pr($data['allvid']);
        $data['memberData']     = $this->ModelMember->getMemberData($memberId);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/upload_image';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function do_upload_photo(){
		
		$member_id = $this->nsession->userdata('member_session_id');
        $this->load->library('image_lib');
        $config['image_library']    = 'GD2';
		
		
		
		if(count($_FILES["files"]["name"])>0)
        {
			
			
            $config["upload_path"] = file_upload_absolute_path().'member_photo/';
            $config["allowed_types"] = 'gif|jpg|png';
            $this->upload->initialize($config);
            for($count = 0; $count<count($_FILES["files"]["name"]); $count++)
            {
				
                $_FILES["img"]["name"]      = time().$_FILES["files"]["name"][$count];
                $_FILES["img"]["type"]      = $_FILES["files"]["type"][$count];
                $_FILES["img"]["tmp_name"]  = $_FILES["files"]["tmp_name"][$count];
                $_FILES["img"]["error"]     = $_FILES["files"]["error"][$count];
                $_FILES["img"]["size"]      = $_FILES["files"]["size"][$count];
                if($this->upload->do_upload('img'))
                {
					
                    //$certificateData[] = $this->upload->data();
					$Imgdata1 = $this->upload->data();
					
                    $certificateData[$count]['photo'] = file_upload_base_url().'member_photo/'.$Imgdata1["file_name"];
                    $certificateData[$count]['member_id'] = $member_id;
                }
            }
			
			//pr($certificateData);
		
			 if($certificateData)
			{
				$this->ModelMember->addmemberPhoto($certificateData);
			} 
        }
		
		$this->nsession->set_userdata('succmsg','Image Uploaded successfully.');
		redirect(base_url($this->controller."/upload_image"));	
	}
	
	
	public function do_upload_video(){
		
		$member_id = $this->nsession->userdata('member_session_id');
        $this->load->library('image_lib');
        $config['image_library']    = 'GD2';
		
		
		
		if(count($_FILES["videos"]["name"])>0)
        {
			
			
            $config["upload_path"] = file_upload_absolute_path().'member_video/';
            $config["allowed_types"] = '*';
            $this->upload->initialize($config);
            for($count = 0; $count<count($_FILES["videos"]["name"]); $count++)
            {
				
                $_FILES["img"]["name"]      = time().$_FILES["videos"]["name"][$count];
                $_FILES["img"]["type"]      = $_FILES["videos"]["type"][$count];
                $_FILES["img"]["tmp_name"]  = $_FILES["videos"]["tmp_name"][$count];
                $_FILES["img"]["error"]     = $_FILES["videos"]["error"][$count];
                $_FILES["img"]["size"]      = $_FILES["videos"]["size"][$count];
                if($this->upload->do_upload('img'))
                {
					
                    //$certificateData[] = $this->upload->data();
					$Imgdata1 = $this->upload->data();
					
                    $certificateData[$count]['video'] = file_upload_base_url().'member_video/'.$Imgdata1["file_name"];
                    $certificateData[$count]['member_id'] = $member_id;
                }
            }
			
			//pr($certificateData);
		
			 if($certificateData)
			{
				$this->ModelMember->addmemberVideo($certificateData);
			} 
        }
		
		$this->nsession->set_userdata('succmsg','video uploaded successfully.');
		redirect(base_url($this->controller."/upload_image"));	
	}
	
	function future_profile($memberid=0)
    {
		//$this->functions->checkUser($this->controller.'/',true);
		$base_64 = $memberid . str_repeat('=', strlen($memberid) % 4);
		$member_id = base64_decode($base_64);
		
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        if($member_id==0){
            $member_id              = $this->nsession->userdata('member_session_id');
            $data['profileView']    = 0;
            $data['memberId'] = $member_id;
        }else{
            $member_id = $member_id;
            $data['profileView'] = 1;
            $data['memberId'] = $member_id;
			$data['my_favrite'] = $this->ModelCommon->getSingleData('my_favorite',array('member_id'=>$this->nsession->userdata('member_session_id'),'favorite_member_id'=>$member_id));
			
        }

        $data['memberData']     = $this->ModelMember->getMemberData($member_id);
        $data['memberMoreData'] = $this->ModelMember->getMemberMoreData($member_id);

		$data['memberInterest']     = $this->ModelMember->getMemberInterest($member_id);
		$data['memberPhoto']     = $this->ModelMember->getMemberphoto($member_id);
		$data['memberPhoto']     = $this->ModelMember->getMemberphoto($member_id);
		
		//pr($data['cmsContent']);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/profile';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);

    }

    function delphoto(){
        $response=array();
        $response['msg']="Invalid Request";
        $response['status']=1;
        if($this->input->post('id') && $this->input->post('type')){
            $id=$this->input->post('id');
            $member_id=$this->nsession->userdata('member_session_id');
            $type=$this->input->post('type');
            if($type=="photo"){
                $tblname="member_photo";
                $picData=$this->ModelCommon->getSingleData('member_photo',array('id'=>$id,'member_id'=>$member_id));
                $explodepic=explode("/uploads", $picData['photo']);
            }else{
                $tblname="member_video";
                $picData=$this->ModelCommon->getSingleData('member_video',array('id'=>$id,'member_id'=>$member_id));
                $explodepic=explode("/uploads", $picData['video']);
            }
            $result=$this->ModelCommon->delData($tblname,array('id'=>$id));
            if($result > 0){
                if(isset($explodepic[1])){
                    $imgpath=file_upload_absolute_path().$explodepic[1];
                    if(is_file($imgpath)){
                       unlink($imgpath);
                    }
                }
                $response = array('status' => 1, 'msg' => 'Deleted Successfully');
            }else{
                $response = array('status' => 0, 'message' => 'unable to delete, please try after some time');
            }
        }
        echo json_encode($response);
    }
	function dailyMatches()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$membership_paln = get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1));
		
		$post = $_POST;
		//echo"<pre>";print_r($post);
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//search section
		$data['maches'] = $this->ModelMember->get_daily_maches($memberId);
		$data['user_id'] =  $memberId;
		//echo"<pre>";print_r($data['maches']);exit;
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/dailyMatches';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer1';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	function dashboard()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
		$membership_paln = get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1));
		
		$post = $_POST;
		//echo"<pre>";print_r($post);
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		//search section
		$data['maches'] = $this->ModelMember->get_daily_maches($memberId);
		$data['user_id'] =  $memberId;
		//echo"<pre>";print_r($data['maches']);exit;
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'member/dashboard';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer1';
        
		$element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
}
