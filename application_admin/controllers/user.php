<?php
class User extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelLogin');
	    $this->load->library('Ajax_pagination');
		$this->controller = 'user';
	}

	function index()
	{
		$this->functions->checkAdmin($this->controller.'/',true);
		
		$config['base_url'] 			= base_url($this->controller."/index/");
		$config['uri_segment']  		= 3;
		$config['num_links'] 			= 10;
		$config['page_query_string'] 	= false;
		$config['extra_params'] 		= "";
		$config['extra_params'] 		= "";

		$this->ajax_pagination->setAdminPaginationStyle($config);
		$start = 0;

		$this->ajax_pagination->initialize($config);
		$data['controller'] = $this->controller;
		$data['section']=$this->functions->createBreadcamp('Dashboard');
		$data['userCount'] = $this->ModelLogin->getTotalMember();
		$data['supervisorCount'] = $this->ModelLogin->getTotalcounselor();
		$data['succmsg'] = $this->nsession->userdata('succmsg');
		$data['errmsg'] = $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'user/home';
		
		$element_data['menu'] = $data;
		$element_data['main'] = $data;

		$this->layout->setLayout('layout_main_view'); 
		$this->layout->multiple_view($elements,$element_data);
	}

	function changeemail()
	{
		$this->functions->checkAdmin($this->controller.'/changeemail/');
		
		$id = $this->nsession->userdata('admin_session_id');		
		$email = $this->ModelLogin->getEmail($id);		
		$data['email'] = $email;
		$data['succmsg'] = $this->nsession->userdata('succmsg');
		$data['errmsg'] = $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['main'] = 'user/changeemail';

		$element_data['main'] = $data;

		$this->layout->setLayout('layout_main_view'); 
		$this->layout->multiple_view($elements,$element_data);
	}

	function do_changeemail()
	{
		$this->functions->checkAdmin($this->controller.'/changeemail/');
		
		$this->form_validation->set_rules('new_email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$id = $this->nsession->userdata('admin_session_id');

		if($this->form_validation->run() == TRUE)
		{
			$data['email_address'] = $this->input->request('new_email','');
			$this->ModelLogin->updateAdminEmail($id,$data);
			$this->nsession->set_userdata('succmsg',"Email Updated");
			redirect(base_url($this->controller."/changeemail/"));
			return true;
		}else{
			$this->nsession->set_userdata('errmsg',"Email Not Updated");
			redirect(base_url($this->controller."/changeemail/"));
			return true;
		}
	}

	function changepass()
	{
		$this->functions->checkAdmin($this->controller.'/changepass/',true);
		
		$data['section']=$this->functions->createBreadcamp('Change Password',$this->controller,'Dashboard');
		$data['controller']=$this->controller;

		$data['msg'] = "";
		$id = $this->nsession->userdata('admin_session_id');

		$data['succmsg'] = $this->nsession->userdata('succmsg');
		$data['errmsg'] = $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		
		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'user/changepass';
		
		$element_data['menu'] = $data;
		$element_data['main'] = $data;

		$this->layout->setLayout('layout_main_view'); 
		$this->layout->multiple_view($elements,$element_data);
	}

	function changeprofile()
	{
		$this->functions->checkAdmin($this->controller.'/changeprofile/',true);

		$data['msg'] = "";
		$id = $this->nsession->userdata('admin_session_id');
		$rs = $this->ModelLogin->getProfileData($id);

		if(is_array($rs))
		{
			foreach($rs[0] as $key =>$val)
			{
				$data[$key] = $val;
			}
		}

		$data['succmsg'] = $this->nsession->userdata('succmsg');
		$data['errmsg'] = $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['main'] = 'user/changeprofile';

		$element_data['main'] = $data;

		$this->layout->setLayout('layout_main_view'); 
		$this->layout->multiple_view($elements,$element_data);
	}

	function do_changeprofile()
	{
		$this->functions->checkAdmin($this->controller.'/changeprofile/',true);

		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email_address', 'Email','trim|required|valid_email|xss_clean');		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$id = $this->nsession->userdata('admin_session_id');
		$data['msg'] = "";
		$rs = $this->ModelLogin->getProfileData($id);

		if(is_array($rs))
		{
			foreach($rs[0] as $key =>$val)
			{
				$data[$key] = $val;
			}
		}

		if($this->form_validation->run() == TRUE)
		{
			$data['full_name']	= $this->input->request('full_name','');
			$data['email_address'] = $this->input->request('email_address','');

			$this->ModelLogin->profileUpdate($id,$data);
			$rs = $this->ModelLogin->getProfileData($id);

			if(is_array($rs))
			{
				foreach($rs[0] as $key =>$val)
				{
					$data[$key] = $val;
				}
			}

			$this->nsession->set_userdata('succmsg',"Profile Updated Successfully");
			redirect(base_url($this->controller."/changeprofile/"));
			return true;
		}
		else
		{
			$this->changeprofile(); 
			return true;
		}
	}

	function do_changepass()
	{

		$this->functions->checkAdmin($this->controller.'/changepass/',true);

		$this->form_validation->set_rules('old_admin_pwd', 'Old Password', 'trim|required|min_length[5]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('new_admin_pwd', 'New Password', 'trim|required|min_length[5]|max_length[20]|matches[conf_new_admin_pwd]|xss_clean');
		$this->form_validation->set_rules('conf_new_admin_pwd', 'Comfirm New Password','trim|required|min_length[5]|max_length[20]|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$id = $this->nsession->userdata('admin_session_id');
		$data['msg'] = "";

		if($this->form_validation->run() == TRUE)
		{
			$data['oldpassword'] = $this->input->request('old_admin_pwd');
			$isTrue = $this->ModelLogin->valideOldPassword($data);
	
			if($isTrue)
			{
				$data['new_admin_pwd'] = $this->input->request('new_admin_pwd');
				$this->ModelLogin->updateAdminPass($id,$data);
				$this->nsession->set_userdata('succmsg',"Password Updated");
			}
			else
			{
				$this->nsession->set_userdata('errmsg',"Invalid Old Password ...");
			}			

			redirect(base_url($this->controller."/changepass/"));
			return true;
		}
		else
		{
			$this->changepass(); 
			return true;
		}
	}	
}
