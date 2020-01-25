<?php
class Counselor extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'counselor';
		$this->load->model('ModelCounselor');
		$this->load->model('ModelMember');
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

	function message(){
		$this->functions->checkUser($this->controller.'/',true);
        $member_id = $this->nsession->userdata('member_session_id');
        
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        
        $data['memberData']     = $this->ModelMember->getMemberData($member_id);
		
        $data['memberAllMessages']     = $this->ModelMember->getAllMemberMessage($member_id);
        //$data['memberAllMessages']=array();
        //pr($data['memberAllMessages']);
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'member/message';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
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
            $data['sugardaddy_or_sugarbaby']= $this->input->post('sugardaddy_or_sugarbaby');
            $data['interested_in']          = $this->input->post('interested_in');
			$data['password'] 			    = md5($this->input->post('password'));
			$data['created']			    = date('Y-m-d H:i:s');
			$data['profile_step']			= 1;
			$insert_id 					    = $this->ModelMember->memberReg($data);
			if($insert_id){
			    $step2Link      = base_url('member/step2/'.base64_encode($insert_id));
				$to 			= $data['email'];
				$subject		= "Registration";
				$body1			= "<tr><td>Hi,</td></tr>
									<tr><td>Thanks for opening an account on our platform.Please click on link to complete your profile <a href='".$step2Link."'>Click here</a> </td></tr>";
				$body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
                  <tbody style="color: #fff;">
                    <tr>
                      <td colspan="3" width="600" height="10" align="left" />
                    </tr>
                    <tr style="text-align:center;">
                      <td width="13" align="left"/>
                      <td width="13" align="left"/>
                    </tr>
                    '.$body1.'
                  </tbody>
                </table></td>';
				$this->functions->mail_template($to,$subject,$body);
                $this->nsession->set_userdata('succmsg','Thanks for opening an account on our platform.Please verify email to complete your account.');
                redirect(base_url());
			}else{
                $this->nsession->set_userdata('errmsg','Some server problem occur.Please try again');
                redirect(base_url());
			}
		}
	}

	function subscriber()
	{
		$this->functions->checkUser($this->controller.'/',true);		
		$country_id = $this->input->post('country_id');
		$state_id = $this->input->post('state_id');
		$city_id = $this->input->post('city_id');
		$zip = $this->input->post('zip');		
		//echo $country_id; die;		
		$memberId = $this->nsession->userdata('member_session_id');
		$config['base_url'] 			= base_url($this->controller."/subscriber/");

		$data['controller'] = $this->controller;
		$where='(friends_list.from_member='.$memberId.' OR friends_list.to_member='.$memberId.')';
		if(isset($post['country_id']) && $post['country_id']!='')
		{
		 $where.=' AND a.country='.$post['country'];
		}
		if(isset($post['state_id']) && $post['state_id']!='')
		{
		 $where.=' AND a.state='.$post['state_id'];
		}
		if((isset($post['age_from']) && $post['age_from']!='')&& $post['age_to']=='' )
		{	
		$where .=' AND age ='.$post['age_from'];
		}
		if((isset($post['age_from']) && $post['age_from']!='')&& (isset($post['age_to']) && $post['age_to']!='') )
		{	
		$where .=' AND age between '.$post['age_from'].' AND '.$post['age_to'];
		}
		$param='';
		$start=0;
		$data['memberData']     	= $this->ModelMember->getMemberData($memberId);
		//pr($data['memberData']); die();
		$data['subscriberList']		= $this->ModelMember->subscriberList($start,$where);
		$data['toType']='counselor';
		$data['allcountry']		= $this->ModelMember->getCountry();
		$data['startRecord'] 	= $start;
		$data['module']			= "Counselor";
		$data['search_string']	= $where;
		$this->pagination->initialize($config);

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'counselor/subscriber';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}

	public function ajaxSubscriberSearch($currPage)
    {
        $data = $_POST;
        $memberId = $this->nsession->userdata('member_session_id');
        $where = $data['search_string'];
        $matches = $this->ModelMember->subscriberList($currPage,$where);
        echo json_encode(array('result'=>$matches,'count'=>count($matches)));
    }

    function step2()
    {
        $memberId = base64_decode($this->uri->segment(3));
        if($memberId!=''){
            //if($this->ModelMember->checkIfStep2Complate($memberId)){
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
            redirect(base_url());
            return true;
        }
    }
    function dashboard()
    {
		$this->functions->checkUser($this->controller.'/',true);
		
        $data['controller'] = $this->controller;
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

		$member_id              = $this->nsession->userdata('member_session_id');
		
		$data['memberData']     = $this->ModelCounselor->getMemberData($member_id);
		$data['certificate']     = $this->ModelCounselor->getcertificateData($member_id);
		
		//pr($data['memberData']);
		
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'counselor/dashboard';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);

    }
	
	function editProfile()
    {
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

		$member_id              = $this->nsession->userdata('member_session_id');
		
		$data['memberData']     = $this->ModelCounselor->getMemberData($member_id);
		$data['certificate']     = $this->ModelCounselor->getcertificateData($member_id);
		
		//pr($data['certificate']);
		
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'counselor/editprofile';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);

    }
	
    function doMemberStep2(){
        $this->load->library('image_lib');
        $config['image_library']    = 'GD2';
        $memberId                   = $this->input->post('memberId');
        $data['username']           = $this->input->post('username');
        $data['profile_heading'] 	= $this->input->post('profile_heading');
        $data['dob']                = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day');
        $data['lifestyle'] 	        = $this->input->post('lifestyle');
        $data['about_me']            = $this->input->post('about_me');
        $data['describe_looking_for'] 	= $this->input->post('describe_looking_for');


        $memberImage             = $_FILES['file']['name'];
        $fileMemberImage         = time().$memberImage;
        $config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name']     = $fileMemberImage;
        $this->upload->initialize($config);
        if(!$this->upload->do_upload('file')) {
            $this->nsession->set_userdata('errmsg',$this->upload->display_errors());
            redirect(base_url('member/step2/'.base64_encode($memberId)));
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
        }else{
            redirect(base_url('member/step2/'.base64_encode($memberId)));
            return true;
        }
        if($this->ModelMember->doSaveProfileData($memberId,$data)){
            $this->nsession->set_userdata('succmsg','Account has been completed successfully.Please login to access your account.');
            redirect(base_url());
            return true;
        }else{
            $this->nsession->set_userdata('errmsg','Some server problem occur.Please try again.');
            redirect(base_url());
            return true;
        }
    }
	function update_account(){
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
			$error = array('error' => $message);
			$this->nsession->set_userdata('errmsg', 'Upload valid profile image.');
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
	function map_view($lat,$long){
		$this->load->view('member/map_view',$data);
	}
	
	function ChangeProfileImg(){
		
		//echo "hi"; die;
		
        $this->functions->checkUser($this->controller.'/',true);
        $member_id = $this->nsession->userdata('member_session_id');
        $profileImg                = $_FILES['profileImg']['name'];
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
            redirect(base_url('counselor/dashboard'));
            return true;
        }else {
            $upload_data = array('upload_data' => $this->upload->data());
        }
        if($upload_data['upload_data']['file_name']) {
            $data['picture'] = file_upload_base_url().'profile_pic/'.$upload_data['upload_data']['file_name'];
            $this->ModelCounselor->doSaveProfileData($member_id,$data);
            $this->nsession->set_userdata('profileImg',$data['picture']);
            $this->nsession->set_userdata('succmsg', 'Profile image updated successfully.');
            redirect(base_url('counselor/dashboard'));
            return true;
        }else{
            $this->nsession->set_userdata('errmsg', $this->upload->display_errors());
            redirect(base_url('counselor/dashboard'));
            return true;
        }
    }
	
	function delete_certificate($id,$member_id){
	
		//$this->functions->checkAdmin($this->controller.'/');
		$this->ModelCounselor->delete_certificate($id);
		$this->nsession->set_userdata('succmsg', 'Successfully Counselor deleted.');
		redirect(base_url($this->controller."/editProfile"));
	}
	
	function do_addedit()
	{
		//pr($_POST);
		
		$member_id = $this->nsession->userdata('member_session_id');
        $this->load->library('image_lib');
        $config['image_library']    = 'GD2';
		//pr($_FILES);
		
			$data['name'] 	  			= $this->input->post('name');
            $data['about_me']    		= $this->input->post('about_me');
            $data['profile_heading']    = $this->input->post('profile_heading');
			$data['modified'] 			= date('Y-m-d H:i:s');
	
		$this->ModelCounselor->editContent($data,$member_id,$Imgdata);
				
		if(count($_FILES["certificate"]["name"])>0)
        {
            $config["upload_path"] = file_upload_absolute_path().'counselor_certificate/';
            $config["allowed_types"] = 'gif|jpg|png';
            $this->upload->initialize($config);
            for($count = 0; $count<count($_FILES["certificate"]["name"]); $count++)
            {
                $_FILES["certificates"]["name"]      = time().$_FILES["certificate"]["name"][$count];
                $_FILES["certificates"]["type"]      = $_FILES["certificate"]["type"][$count];
                $_FILES["certificates"]["tmp_name"]  = $_FILES["certificate"]["tmp_name"][$count];
                $_FILES["certificates"]["error"]     = $_FILES["certificate"]["error"][$count];
                $_FILES["certificates"]["size"]      = $_FILES["certificate"]["size"][$count];
                if($this->upload->do_upload('certificates'))
                {
                    //$certificateData[] = $this->upload->data();
					$Imgdata1 = $this->upload->data();
					
                    $certificateData[$count]['certificate'] = file_upload_base_url().'counselor_certificate/'.$Imgdata1["file_name"];
                    $certificateData[$count]['member_id'] = $member_id;
                }
            }
			//pr($certificateData);
		
			if($certificateData)
			{
				$this->ModelCounselor->addcertificate($certificateData);
			}
        }
		
		$this->nsession->set_userdata('succmsg','Counselor updated successfully.');
		redirect(base_url($this->controller."/editProfile"));	
	}
	
	function profile($memberid=0)
    {		
		
		$this->functions->checkUser($this->controller.'/',true);
		$memberId = $this->nsession->userdata('member_session_id');
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
        }
		
		$data['memberData']     = $this->ModelCounselor->getMemberData($member_id); 
		$data['certificate']     = $this->ModelCounselor->getcertificateData($member_id);
        $data['paidMember']     = $this->ModelMember->getCheckpaid($memberId);
		$this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'counselor/profile';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);

    }
	
	function booking_counselor()
	{
		//error_reporting(E_ALL);
		$this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");
		
		$data['member_id']    = $this->nsession->userdata('member_session_id');
	    $data['counselor_id'] = $this->input->post('counselor_id'); 
		$data['booking_date'] =  date('Y-m-d H:i:s',strtotime($this->input->post('datetimepicker4')));
		$data['created_date'] =  date('Y-m-d',strtotime($this->input->post('datetimepicker4')));
		$data['timezone']=$this->input->post('timezone');
		$booking_date = date('Y-m-d',strtotime($this->input->post('datetimepicker4')));
		$booking_time = date('H:i:s',strtotime($this->input->post('datetimepicker4')));
		
		$booking_date_time=$booking_date." ".$booking_time;
		$data['booking_date'] =$booking_date_time;
		//echo $data['booking_date']."---".$data['booking_date']; die();
		// $check_avalable  = $this->ModelCounselor->check_available($data['counselor_id'],$booking_date, $booking_time);
		// if($check_avalable){}else{
		// 	$this->nsession->set_userdata('errmsg','Counselor is not avalable in this date .');
		// }
			
		// $booked_by_other  =$this->db->where('member_id !=',$data['member_id'])->where('counselor_id',$data['counselor_id'])->where('booking_date',$data['booking_date'])->where('assign',1)->get('counselor_booking')->result_array();
               			  
		 //   if(!empty($booked_by_other))
		 //   {
			//     $this->nsession->set_userdata('errmsg','Already booked by other member.');
		 //   }
		 //   else
		 //   {}
		 $result1  = $this->functions->getTableData('counselor_booking',array('member_id'=>$data['member_id'],'counselor_id'=>$data['counselor_id'],'booking_date'=>$data['booking_date'])); 
		 
		 if($result1){
			 $this->nsession->set_userdata('errmsg','You are already booked.');
		 }else{		  		  
			  $result = $this->ModelCounselor->booking_counselor($data);			  
			  if($result)
			  {
			  	$this->nsession->set_userdata('succmsg','Counselor Booking successful.');
			  }else{
			  	$this->nsession->set_userdata('errmsg','Please try once again');
			  }
		 }	
		   					   
		
			
		echo 456;	
		
	}

	function appointment(){
		/* */
		
		$data['controller'] = $this->controller;
		$member_id              = $this->nsession->userdata('member_session_id');
		$data['memberData']     = $this->ModelCounselor->getMemberData($member_id);
		$data['certificate']     = $this->ModelCounselor->getcertificateData($member_id);
        
		$get_eventDate = $this->ModelCounselor->getEventDate($member_id);
		//echo"<pre>";print_r($get_eventDate);
		$data['getEventDate'] =  $get_eventDate; 
		$data['counselor_available'] = $this->ModelCounselor->counselor_availability($member_id);
		//pr($data['counselor_available']);
		$this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerInner';
        $element_data['header'] = $data;
        $elements['main'] = 'counselor/appointment';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);
		
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
		$elements['main'] = 'counselor/changepassword';
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
			
			redirect('counselor/change_password');		
	}
	
	public function avalablity()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$data['controller'] = $this->controller;
		
		$memberId = $this->nsession->userdata('member_session_id');				
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$data['memberId'] = $member_id;
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		
		$data['avalabedate']     = $this->ModelCounselor->getavalabedate($memberId);
		//$data['myTimezone']    =$myTimezone;
		//pr($data['avalabedate']);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'counselor/avalablity';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}

	public function booked_member()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$data['controller'] = $this->controller;
		
		$memberId = $this->nsession->userdata('member_session_id');				
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$data['memberId'] = $member_id;
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		
		$data['avalabedate']     = $this->ModelCounselor->getbookedmember($memberId);
		//echo $this->db->last_query(); die();
		//$data['myTimezone']    =$myTimezone;
		//pr($data['avalabedate']);
		
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'counselor/booked_member';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
	}
	
	public function add_date()
	{
		
		//error_reporting(E_ALL);
		$start_time = strtotime($_POST['form_time']);
		$end_time = strtotime($_POST['end_time']);
		// if($start_time > $end_time)
		// {
		// 	 $this->nsession->set_userdata('errmsg','Start time must not greater than end time');
		// 	 return false;
		// }
	
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		$data['counselor_id'] = $this->nsession->userdata('member_session_id');
		$data['avalable_date'] =  date('Y-m-d',strtotime($this->input->post('datetimepicker4')));
		$data['start_time'] =  date("H:i", strtotime($this->input->post('form_time')));
		$data['end_time'] =  date("H:i", (strtotime($data['start_time']) + 60*60 ));
		$data['create_date'] =  date('Y-m-d');
		$data['fulldate']=$data['avalable_date']." ".$data['start_time'];
		$data['timezone']=($this->input->post('timezone'))?$this->input->post('timezone'):date_default_timezone_get();
		   
		$result1 = $this->ModelCounselor->date_check($data['counselor_id'],$data['avalable_date'], $data['start_time'],$data['end_time'] );
		if($result1)
		{
		  $this->nsession->set_userdata('errmsg','You have already added the time.');
		}else{		  		  
		  $check_count=$this->ModelCounselor->checkAddedOnSameDate($data['counselor_id'],$data['avalable_date']);
		  if($check_count>=8){
		  	$this->nsession->set_userdata('errmsg','You have reached today set available time limit');
			 echo "false";
		  }else{
		  	  $result = $this->ModelCounselor->add_date($data);			  
			  if($result)
			  {
			  	  echo json_encode($result);
				  $this->nsession->set_userdata('succmsg','Date Successfully Added.');
			  }else{
			  	$this->nsession->set_userdata('errmsg','Please try once again');
			  	echo "false";
			  }
		  }
		  
		}				
	}

	public function booking_delete($id='0'){
		$this->load->model('ModelCommon');
		$booking_detail=$this->ModelCounselor->getBookingDetails($id);
		$n_c_data=array();
		if(count($booking_detail) > 0){
			$n_c_data['member_id']=$booking_detail['member_id'];
			$n_c_data['site_url']='member/booking_notification';
			$n_c_data['contents']=$booking_detail['counselor_name']." has been canceled your appointment due to some busy schedule";
			$n_c_data['type']='booking';
			$n_c_data['created_date']=date('Y-m-d H:i:s');
			$this->ModelCommon->insertData('member_notification',$n_c_data);
			

			$to 			= $booking_detail['member_email'];
			$subject		= "Booking Cancelled";
			$body1			= "<tr><td> Hi,".$booking_detail['member_name']." </td></tr>
								<tr><td> ".($booking_detail['counselor_name']!='')?$booking_detail['counselor_name']:'counselor'." has been canceled your appointment due to the some busy schedule</td></tr>";
			$body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
	          <tbody style="color: #fff;">
	            <tr>
	              <td colspan="3" width="600" height="10" align="left" />
	            </tr>
	            <tr style="text-align:center;">
	              <td width="13" align="left"/>
	              <td width="13" align="left"/>
	            </tr>
	            '.$body1.'
	          </tbody>
	        </table></td>';					
			$this->functions->mail_template($to,$subject,$body);
			$to1 			= $booking_detail['counselor_email'];
			$subject1		= "Booking Cancelled";
			$body1			= "<tr><td> Hi,".$booking_detail['counselor_name']." </td></tr>
								<tr><td> You have successfully canceled ".$booking_detail['member_name']." appointment</td></tr>";
			$body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
	          <tbody style="color: #fff;">
	            <tr>
	              <td colspan="3" width="600" height="10" align="left" />
	            </tr>
	            <tr style="text-align:center;">
	              <td width="13" align="left"/>
	              <td width="13" align="left"/>
	            </tr>
	            '.$body1.'
	          </tbody>
	        </table></td>';					
			$this->functions->mail_template($to1,$subject1,$body1);
		}
		$this->db->delete('counselor_booking',array('booking_id'=>$id));
		$this->nsession->set_userdata('succmsg',' Successfully Deleted.');
		redirect('counselor/booked_member');
	}
	
	public function date_delete($id)
	{
				
		$membershipPlans  = $this->functions->getTableData('counselor_avalable',array('id'=>$id));
		
		$counselor_id = $membershipPlans[0]['counselor_id'];
		$avalable_date = $membershipPlans[0]['avalable_date'];
		
		$check_booking  = $this->functions->getTableData('counselor_booking',array('counselor_id'=>$counselor_id,'created_date'=>$avalable_date));
		
		if($check_booking)
		{
			 $this->nsession->set_userdata('errmsg','This date already assigned.');
			 redirect('counselor/avalablity');
		}
		else{
			 $this->ModelCounselor->delete_date($id);
			 
			 $this->nsession->set_userdata('succmsg',' Successfully Deleted.');
			 redirect('counselor/avalablity');
		}
		
	}
}
