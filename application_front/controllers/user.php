<?php
class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'user';
        $this->load->model('ModelPage');
        $this->load->model('ModelCommon');
	}
	
	public function index()
	{
        // echo $this->nsession->userdata('member_session_id');exit;
		$data['controller'] = $this->controller;
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
       
        $elements = array();
		$elements['header'] = 'layout/header';
		$element_data['header'] = $data;
		$elements['main'] = 'page/index';  
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';  
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_home'); 
		$this->layout->multiple_view($elements,$element_data);
    }

    function myprofile(){
        if(!$this->nsession->userdata('member_login') && !$this->nsession->userdata('member_login')==1){
            redirect(base_url('login'));
        }
        $data['controller'] = $this->controller;
        
        $data['myDtl']=$this->ModelCommon->getMyProfile($memberId);
        if(empty($data['myDtl'])){
            redirect(base_url('login'));
        }
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'user/myprofile';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function editproifle(){
        if(!$this->nsession->userdata('member_login') && !$this->nsession->userdata('member_login')==1){
            redirect(base_url('login'));
        }
        $data['controller'] = $this->controller;
        $data['myDtl']=$this->ModelCommon->getMyProfile($memberId);
        if(empty($data['myDtl'])){
            redirect(base_url('login'));
        }

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'user/editProfile';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function doEditProfile(){
        $memberId = $this->nsession->userdata('member_session_id');
        $ndata=array();
        if($this->input->post('first_name')){
            $ndata['first_name']=$this->input->post('first_name');
        }
        if($this->input->post('middle_name')){
            $ndata['middle_name']=$this->input->post('middle_name');
        }
        if($this->input->post('last_name')){
            $ndata['last_name']=$this->input->post('last_name');
        }

        if($_FILES['file']['name'])
        {
            $this->load->library('image_lib');
			//pr($_FILES);
			$memberImage             = $_FILES['file']['name'];
			$fileMemberImage         = time().$memberImage;
			$config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
			$config['allowed_types'] = '*';
			$config['file_name']     = $fileMemberImage;
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('file')) {
                echo $this->upload->display_errors(); die();
				$this->nsession->set_userdata('errmsg',$this->upload->display_errors());
				redirect(base_url('user/editprofile/'));
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
				$implodeData = explode('.',$upload_data['upload_data']['file_name']);
				$thumbImgNme = $implodeData[0].'_thumb.'.$implodeData[1];
				$ndata['picture'] = 'profile_pic/'.$upload_data['upload_data']['file_name'];
				$ndata['crop_profile_image'] = 'profile_pic/tmp/'.$thumbImgNme;
            }
            
            

        }
        //print_r($ndata); die();
        if(count($ndata) > 0){
            $this->ModelCommon->updateData('member',$ndata,array('id'=>$memberId));
            $user_data=$this->ModelCommon->getSingleData('member',array('id'=>$memberId));
            $this->nsession->set_userdata('member_session_email', $user_data['email']);
            $this->nsession->set_userdata('member_session_name', $user_data['first_name']);
            $this->nsession->set_userdata('member_session_picture', $user_data['crop_profile_image']);
        }

        redirect(base_url('user/editprofile/'));
    }

}
