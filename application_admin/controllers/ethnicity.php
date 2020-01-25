<?php
//error_reporting(E_ALL);
class Ethnicity extends CI_Controller {

	var $urlfix = "";

	function __construct()
	{
		parent::__construct();
		$this->controller = 'ethnicity';
		$this->load->model('ModelEthnicity');
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
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','20');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');

		$data['recordset'] 		= $this->ModelEthnicity->getList($config,$start,$param);
		$data['startRecord'] 	= $start;
		$data['module']			= "Ethnicity Management";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_Ethnicity');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']		    = $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'ethnicity/index';

		$element_data['menu'] = $data;
		$element_data['main'] = $data;

		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);

	}

	//==========Initialize $data for Add =======================

	function addedit($id = 0)
	{
		$this->functions->checkAdmin($this->controller.'/');
		//if add or edit
		$startRecord  	= 0;
		$contentId 		= $this->uri->segment(3, 0);
		$page 			= $this->uri->segment(4, 0);

		if($page > 0)
			$startRecord = $page;

		$page = $startRecord;

		$data['controller'] 		= $this->controller;
		$data['action'] 			= "Add";
		$data['params']['page'] 	= $page;
		$data['do_addedit_link']	= base_url($this->controller."/do_addedit/".$contentId."/".$page."/");
		$data['back_link']			= base_url($this->controller."/index/");

		if($contentId > 0)
		{
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelEthnicity->getSingle($contentId);
			//pr($rs);
			//$row = $rs->fields;
			if(is_array($rs))
			{
				foreach($rs as $key => $val)
				{
					if(!is_numeric($key))
					{
						$data[$key] = $val;
					}
				}
			}
		}else{
			$data['action'] 	= "Add";
			$data['id']			= 0;
		}
		$data['succmsg'] = $this->nsession->userdata('succmsg');
		$data['errmsg'] = $this->nsession->userdata('errmsg');
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'ethnicity/add_edit';
		$element_data['menu'] = $data;//array();
		$element_data['main'] = $data;
		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);
	}

	function do_addedit()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$contentId = $this->uri->segment(3, 0);
		$page = $this->uri->segment(4, 0);
		
		if($contentId==0){
			$data['ethnicity'] 	     = $this->input->post('ethnicity');
			$data['is_active']   = 1;
		}else{
			$data['ethnicity'] 	     = $this->input->post('ethnicity');
		}

		
	if($contentId==0){
		$this->ModelEthnicity->addContent($data);
		$this->nsession->set_userdata('succmsg','Ethnicity added successfully.');
		redirect(base_url($this->controller."/index/"));
	}else{
		$this->ModelEthnicity->editContent($data,$contentId);
		$this->nsession->set_userdata('succmsg','Ethnicity updated successfully.');
		redirect(base_url($this->controller."/index/"));
	}
	}

	function activate()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelEthnicity->activate($id);
		// $result = $this->ModelEthnicity->getsingle_empdata($id);
		// $email = $result->email;
		// $first_name = $result->first_name;

		// $to = $email;
		// $subject='KSC Account Activated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been activated successfully.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Ethnicity Activated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	function inactive()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelEthnicity->inactive($id);
		// $result 		= $this->ModelEthnicity->getsingle_empdata($id);
		// $email 			= $result->email;
		// $first_name = $result->first_name;

		// $to 				= $email;
		// $subject		='KSC Account deactivated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been deactivated.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Ethnicity Inactivated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	function delete($id){
		$checkIfApply = $this->ModelEthnicity->checkIfApply($id);
		if($checkIfApply>0){
		$this->nsession->set_userdata('errmsg', 'This Ethnicity type is already applied.');
		redirect(base_url($this->controller."/index/"));
		}else{
		$this->functions->checkAdmin($this->controller.'/');
		$this->ModelEthnicity->delete($id);
		$this->nsession->set_userdata('succmsg', 'Successfully Ethnicity deleted.');
		redirect(base_url($this->controller."/index/"));
		}
	}
}
?>
