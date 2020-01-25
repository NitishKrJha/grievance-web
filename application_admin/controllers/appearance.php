<?php
//error_reporting(E_ALL);
class Appearance extends CI_Controller {

	var $urlfix = "";

	function __construct()
	{
		parent::__construct();
		$this->controller = 'appearance';
		$this->load->model('ModelAppearance');
	}

	function body()
	{
		$this->functions->checkAdmin($this->controller.'/',true);

		$config['base_url'] 			= base_url($this->controller."/body/");

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

		$data['recordset'] 		= $this->ModelAppearance->getbodyList($config,$start,$param);
		$data['startRecord'] 	= $start;
		$data['module']			= "Body Appearance Management";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_BODY');
		$data['reload_link']      	= base_url($this->controller."/body/");
		$data['search_link']        = base_url($this->controller."/body/0/1/");
		$data['add_link']         	= base_url($this->controller."/bodyaddedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/bodyaddedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/bodyactivate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/bodyinactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/body/0/1");
		$data['total_rows']		    = $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'appearance/body';

		$element_data['menu'] = $data;
		$element_data['main'] = $data;

		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);

	}

	//==========Initialize $data for Add =======================

	function bodyaddedit($id = 0)
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
		$data['do_addedit_link']	= base_url($this->controller."/do_body_addedit/".$contentId."/".$page."/");
		$data['back_link']			= base_url($this->controller."/body/");

		if($contentId > 0)
		{
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelAppearance->getbodySingle($contentId);
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
		$elements['main'] = 'appearance/body_add_edit';
		$element_data['menu'] = $data;//array();
		$element_data['main'] = $data;
		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);
	}

	function do_body_addedit()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$contentId = $this->uri->segment(3, 0);
		$page = $this->uri->segment(4, 0);
		
		if($contentId==0){
			$data['type'] 	     = $this->input->post('type');
			$data['is_active']   = 1;
		}else{
			$data['type'] 	     = $this->input->post('type');
		}

		
	if($contentId==0){
		$this->ModelAppearance->addbodyContent($data);
		$this->nsession->set_userdata('succmsg','Body Type added successfully.');
		redirect(base_url($this->controller."/body/"));
	}else{
		$this->ModelAppearance->editbodyContent($data,$contentId);
		$this->nsession->set_userdata('succmsg','Body Type updated successfully.');
		redirect(base_url($this->controller."/body/"));
	}
	}

	function bodyactivate()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelAppearance->bodyactivate($id);
		// $result = $this->ModelAppearance->getsingle_empdata($id);
		// $email = $result->email;
		// $first_name = $result->first_name;

		// $to = $email;
		// $subject='KSC Account Activated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been activated successfully.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Body Type Activated.');
		redirect(base_url($this->controller."/body/"));
		return true;
	}
	function bodyinactive()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelAppearance->bodyinactive($id);
		// $result 		= $this->ModelAppearance->getsingle_empdata($id);
		// $email 			= $result->email;
		// $first_name = $result->first_name;

		// $to 				= $email;
		// $subject		='KSC Account deactivated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been deactivated.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Body Type Inactivated.');
		redirect(base_url($this->controller."/body/"));
		return true;
	}
	function body_delete($id){
		$checkIfApply = $this->ModelAppearance->checkIfBodyApply($id);
		if($checkIfApply>0){
		$this->nsession->set_userdata('errmsg', 'This Body type is already applied.');
		redirect(base_url($this->controller."/body/"));
		}else{
		$this->functions->checkAdmin($this->controller.'/');
		$this->ModelAppearance->bodydelete($id);
		$this->nsession->set_userdata('succmsg', 'Successfully Body Type deleted.');
		redirect(base_url($this->controller."/body/"));
		}
	}
	function hair()
	{
		$this->functions->checkAdmin($this->controller.'/',true);

		$config['base_url'] 			= base_url($this->controller."/hair/");

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

		$data['recordset'] 		= $this->ModelAppearance->gethairList($config,$start,$param);
		$data['startRecord'] 	= $start;
		$data['module']			= "Hair Appearance Management";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_HAIR');
		$data['reload_link']      	= base_url($this->controller."/hair/");
		$data['search_link']        = base_url($this->controller."/hair/0/1/");
		$data['add_link']         	= base_url($this->controller."/hairaddedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/hairaddedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/hairactivate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/hairinactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/hair/0/1");
		$data['total_rows']		    = $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'appearance/hair';

		$element_data['menu'] = $data;
		$element_data['main'] = $data;

		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);

	}

	//==========Initialize $data for Add =======================

	function hairaddedit($id = 0)
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
		$data['do_addedit_link']	= base_url($this->controller."/do_hair_addedit/".$contentId."/".$page."/");
		$data['back_link']			= base_url($this->controller."/hair/");

		if($contentId > 0)
		{
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelAppearance->gethairSingle($contentId);
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
		$elements['main'] = 'appearance/hair_add_edit';
		$element_data['menu'] = $data;//array();
		$element_data['main'] = $data;
		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);
	}

	function do_hair_addedit()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$contentId = $this->uri->segment(3, 0);
		$page = $this->uri->segment(4, 0);
		
		if($contentId==0){
			$data['type'] 	     = $this->input->post('type');
			$data['is_active']   = 1;
		}else{
			$data['type'] 	     = $this->input->post('type');
		}

		
	if($contentId==0){
		$this->ModelAppearance->addhairContent($data);
		$this->nsession->set_userdata('succmsg','Hair Type added successfully.');
		redirect(base_url($this->controller."/hair/"));
	}else{
		$this->ModelAppearance->edithairContent($data,$contentId);
		$this->nsession->set_userdata('succmsg','Hair Type updated successfully.');
		redirect(base_url($this->controller."/hair/"));
	}
	}

	function hairactivate()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelAppearance->hairactivate($id);
		// $result = $this->ModelAppearance->getsingle_empdata($id);
		// $email = $result->email;
		// $first_name = $result->first_name;

		// $to = $email;
		// $subject='KSC Account Activated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been activated successfully.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Hair Type Activated.');
		redirect(base_url($this->controller."/hair/"));
		return true;
	}
	function hairinactive()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelAppearance->hairinactive($id);
		// $result 		= $this->ModelAppearance->getsingle_empdata($id);
		// $email 			= $result->email;
		// $first_name = $result->first_name;

		// $to 				= $email;
		// $subject		='KSC Account deactivated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been deactivated.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Hair Type Inactivated.');
		redirect(base_url($this->controller."/hair/"));
		return true;
	}
	function hair_delete($id){
		$checkIfApply = $this->ModelAppearance->checkIfHairApply($id);
		if($checkIfApply>0){
		$this->nsession->set_userdata('errmsg', 'This Hair type is already applied.');
		redirect(base_url($this->controller."/hair/"));
		}else{
		$this->functions->checkAdmin($this->controller.'/');
		$this->ModelAppearance->hairdelete($id);
		$this->nsession->set_userdata('succmsg', 'Successfully Hair Type deleted.');
		redirect(base_url($this->controller."/hair/"));
		}
	}
	function eye()
	{
		$this->functions->checkAdmin($this->controller.'/',true);

		$config['base_url'] 			= base_url($this->controller."/eye/");

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

		$data['recordset'] 		= $this->ModelAppearance->geteyeList($config,$start,$param);
		$data['startRecord'] 	= $start;
		$data['module']			= "Eye Appearance Management";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_EYE');
		$data['reload_link']      	= base_url($this->controller."/eye/");
		$data['search_link']        = base_url($this->controller."/eye/0/1/");
		$data['add_link']         	= base_url($this->controller."/eyeaddedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/eyeaddedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/eyeactivate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/eyeinactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/eye/0/1");
		$data['total_rows']		    = $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'appearance/eye';

		$element_data['menu'] = $data;
		$element_data['main'] = $data;

		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);

	}

	//==========Initialize $data for Add =======================

	function eyeaddedit($id = 0)
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
		$data['do_addedit_link']	= base_url($this->controller."/do_eye_addedit/".$contentId."/".$page."/");
		$data['back_link']			= base_url($this->controller."/eye/");

		if($contentId > 0)
		{
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelAppearance->geteyeSingle($contentId);
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
		$elements['main'] = 'appearance/eye_add_edit';
		$element_data['menu'] = $data;//array();
		$element_data['main'] = $data;
		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);
	}

	function do_eye_addedit()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$contentId = $this->uri->segment(3, 0);
		$page = $this->uri->segment(4, 0);
		
		if($contentId==0){
			$data['type'] 	     = $this->input->post('type');
			$data['is_active']   = 1;
		}else{
			$data['type'] 	     = $this->input->post('type');
		}

		
	if($contentId==0){
		$this->ModelAppearance->addeyeContent($data);
		$this->nsession->set_userdata('succmsg','Eye Type added successfully.');
		redirect(base_url($this->controller."/eye/"));
	}else{
		$this->ModelAppearance->editeyeContent($data,$contentId);
		$this->nsession->set_userdata('succmsg','Eye Type updated successfully.');
		redirect(base_url($this->controller."/eye/"));
	}
	}

	function eyeactivate()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelAppearance->eyeactivate($id);
		// $result = $this->ModelAppearance->getsingle_empdata($id);
		// $email = $result->email;
		// $first_name = $result->first_name;

		// $to = $email;
		// $subject='KSC Account Activated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been activated successfully.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Eye Type Activated.');
		redirect(base_url($this->controller."/eye/"));
		return true;
	}
	function eyeinactive()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelAppearance->eyeinactive($id);
		// $result 		= $this->ModelAppearance->getsingle_empdata($id);
		// $email 			= $result->email;
		// $first_name = $result->first_name;

		// $to 				= $email;
		// $subject		='KSC Account deactivated';
		// $body='<tr><td>Hi,</td></tr>
		// 		<tr><td>Name : '.$first_name.'</td></tr>
		// 		<tr style="background:#fff;"><td>Your account has been deactivated.</td></tr>';
		// $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully Eye Type Inactivated.');
		redirect(base_url($this->controller."/eye/"));
		return true;
	}
	function eye_delete($id){
		$checkIfApply = $this->ModelAppearance->checkIfEyeApply($id);
		if($checkIfApply>0){
		$this->nsession->set_userdata('errmsg', 'This Eye type is already applied.');
		redirect(base_url($this->controller."/eye/"));
		}else{
		$this->functions->checkAdmin($this->controller.'/');
		$this->ModelAppearance->eyedelete($id);
		$this->nsession->set_userdata('succmsg', 'Successfully Eye Type deleted.');
		redirect(base_url($this->controller."/eye/"));
		}
	}
}
?>
