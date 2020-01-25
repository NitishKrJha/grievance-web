<?php
//error_reporting(E_ALL);
class Activities extends CI_Controller {

	var $urlfix = "";

	function __construct()
	{
		parent::__construct();
		$this->controller = 'activities';
		$this->load->model('ModelActivities');
	}

	function indoor()
	{
		$this->functions->checkAdmin($this->controller.'/',true);

		$config['base_url'] 			= base_url($this->controller."/indoor/");

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

		$data['recordset'] 		= $this->ModelActivities->getindoorList($config,$start,$param);
		$data['startRecord'] 	= $start;
		$data['module']			= "Indoor Activity Management";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_INDOOR');
		$data['reload_link']      	= base_url($this->controller."/indoor/");
		$data['search_link']        = base_url($this->controller."/indoor/0/1/");
		$data['add_link']         	= base_url($this->controller."/indooraddedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/indooraddedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/indooractivate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/indoorinactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/indoor/0/1");
		$data['total_rows']		    = $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'activities/indoor';

		$element_data['menu'] = $data;
		$element_data['main'] = $data;

		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);

	}

	//==========Initialize $data for Add =======================

	function indooraddedit($id = 0)
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
		$data['do_addedit_link']	= base_url($this->controller."/do_indoor_addedit/".$contentId."/".$page."/");
		$data['back_link']			= base_url($this->controller."/indoor/");

		if($contentId > 0)
		{
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelActivities->getindoorSingle($contentId);
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
		$elements['main'] = 'activities/indoor_add_edit';
		$element_data['menu'] = $data;//array();
		$element_data['main'] = $data;
		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);
	}

	function do_indoor_addedit()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$contentId = $this->uri->segment(3, 0);
		$page = $this->uri->segment(4, 0);
		
		if($contentId==0){
			$data['activities'] 	     = $this->input->post('activities');
			$data['is_active']   = 1;
		}else{
			$data['activities'] 	     = $this->input->post('activities');
		}

		
	if($contentId==0){
		$this->ModelActivities->addindoorContent($data);
		$this->nsession->set_userdata('succmsg','Indoor Activity added successfully.');
		redirect(base_url($this->controller."/indoor/"));
	}else{
		$this->ModelActivities->editindoorContent($data,$contentId);
		$this->nsession->set_userdata('succmsg','Indoor Activity updated successfully.');
		redirect(base_url($this->controller."/indoor/"));
	}
	}

	function indooractivate()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelActivities->indooractivate($id);
		// $result = $this->ModelActivities->getsingle_empdata($id);
		// $email = $result->email;
		// $first_name = $result->first_name;

		// $to = $email;
		// $subject='KSC Account Activated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been activated successfully.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Indoor Activity Activated.');
		redirect(base_url($this->controller."/indoor/"));
		return true;
	}
	function indoorinactive()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelActivities->indoorinactive($id);
		// $result 		= $this->ModelActivities->getsingle_empdata($id);
		// $email 			= $result->email;
		// $first_name = $result->first_name;

		// $to 				= $email;
		// $subject		='KSC Account deactivated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been deactivated.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Indoor Activity Inactivated.');
		redirect(base_url($this->controller."/indoor/"));
		return true;
	}
	function indoor_delete($id){
		$checkIfApply = $this->ModelActivities->checkIfIndoorApply($id);
		if($checkIfApply>0){
		$this->nsession->set_userdata('errmsg', 'This Indoor Activity is already applied.');
		redirect(base_url($this->controller."/indoor/"));
		}else{
		$this->functions->checkAdmin($this->controller.'/');
		$this->ModelActivities->indoordelete($id);
		$this->nsession->set_userdata('succmsg', 'Successfully Indoor Activity deleted.');
		redirect(base_url($this->controller."/indoor/"));
		}
	}
	function outdoor()
	{
		$this->functions->checkAdmin($this->controller.'/',true);

		$config['base_url'] 			= base_url($this->controller."/outdoor/");

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

		$data['recordset'] 		= $this->ModelActivities->getoutdoorList($config,$start,$param);
		$data['startRecord'] 	= $start;
		$data['module']			= "Outdoor Activity Management";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_OUTDOOR');
		$data['reload_link']      	= base_url($this->controller."/outdoor/");
		$data['search_link']        = base_url($this->controller."/outdoor/0/1/");
		$data['add_link']         	= base_url($this->controller."/outdooraddedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/outdooraddedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/outdooractivate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/outdoorinactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/outdoor/0/1");
		$data['total_rows']		    = $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'activities/outdoor';

		$element_data['menu'] = $data;
		$element_data['main'] = $data;

		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);

	}

	//==========Initialize $data for Add =======================

	function outdooraddedit($id = 0)
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
		$data['do_addedit_link']	= base_url($this->controller."/do_outdoor_addedit/".$contentId."/".$page."/");
		$data['back_link']			= base_url($this->controller."/outdoor/");

		if($contentId > 0)
		{
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelActivities->getoutdoorSingle($contentId);
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
		$elements['main'] = 'activities/outdoor_add_edit';
		$element_data['menu'] = $data;//array();
		$element_data['main'] = $data;
		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);
	}

	function do_outdoor_addedit()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$contentId = $this->uri->segment(3, 0);
		$page = $this->uri->segment(4, 0);
		
		if($contentId==0){
			$data['activities'] 	     = $this->input->post('activities');
			$data['is_active']   = 1;
		}else{
			$data['activities'] 	     = $this->input->post('activities');
		}

		
	if($contentId==0){
		$this->ModelActivities->addoutdoorContent($data);
		$this->nsession->set_userdata('succmsg','Outdoor Activity added successfully.');
		redirect(base_url($this->controller."/outdoor/"));
	}else{
		$this->ModelActivities->editoutdoorContent($data,$contentId);
		$this->nsession->set_userdata('succmsg','Outdoor Activity updated successfully.');
		redirect(base_url($this->controller."/outdoor/"));
	}
	}

	function outdooractivate()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelActivities->outdooractivate($id);
		// $result = $this->ModelActivities->getsingle_empdata($id);
		// $email = $result->email;
		// $first_name = $result->first_name;

		// $to = $email;
		// $subject='KSC Account Activated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been activated successfully.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Outdoor Activity Activated.');
		redirect(base_url($this->controller."/outdoor/"));
		return true;
	}
	function outdoorinactive()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelActivities->outdoorinactive($id);
		// $result 		= $this->ModelActivities->getsingle_empdata($id);
		// $email 			= $result->email;
		// $first_name = $result->first_name;

		// $to 				= $email;
		// $subject		='KSC Account deactivated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been deactivated.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Outdoor Activity Inactivated.');
		redirect(base_url($this->controller."/outdoor/"));
		return true;
	}
	function outdoor_delete($id){
		$checkIfApply = $this->ModelActivities->checkIfOutdoorApply($id);
		if($checkIfApply>0){
		$this->nsession->set_userdata('errmsg', 'This Outdoor Activity is already applied.');
		redirect(base_url($this->controller."/index/"));
		}else{
		$this->functions->checkAdmin($this->controller.'/');
		$this->ModelActivities->outdoordelete($id);
		$this->nsession->set_userdata('succmsg', 'Successfully Outdoor Activity deleted.');
		redirect(base_url($this->controller."/outdoor/"));
		}
	}
	
}
?>
