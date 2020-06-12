<?php
 //error_reporting(E_ALL);
class Quarter extends CI_Controller {

	var $urlfix = "";

	function __construct()
	{
		parent::__construct();
		$this->controller = 'quarter';
		$this->load->model('ModelQuarter');
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

		$data['recordset'] 		= $this->ModelQuarter->getList($config,$start,$param);
		$data['startRecord'] 	= $start;
		$data['module']			= "Quarter";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_quarter');
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
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'quarter/index';

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
		$data['do_addedit_link']	= base_url($this->controller."/do_addedit/".$id."/".$page."/");
		$data['back_link']			= base_url($this->controller."/index/");
		$data['id']=$id;
		$data['quarter_type_list'] = $this->ModelQuarter->get_quarter_type_list_data();
		$data['caste_type_list'] = $this->ModelQuarter->get_caste_type_list_data();
		if($contentId > 0)
		{
			$data['id']	= $id;
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelQuarter->getSingle($contentId);
			
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
		$elements['main'] = 'quarter/add_edit';
		$element_data['menu'] = $data;//array();
		$element_data['main'] = $data;
		$this->layout->setLayout('layout_main_view');
		$this->layout->multiple_view($elements,$element_data);

	}

	function do_addedit()
	{
		
        $this->load->library('image_lib');
        $config['image_library']    = 'GD2';
		//pr($_FILES);
		$this->functions->checkAdmin($this->controller.'/');
		$contentId = $this->uri->segment(3, 0);
		$page = $this->uri->segment(4, 0);
		$data['quarter_no'] 	     = ($this->input->post('quarter_no'))?$this->input->post('quarter_no'):'';
		$data['quarter_type_list_id'] 	     = ($this->input->post('quarter_type'))?$this->input->post('quarter_type'):'';
		$data['caste_type_list_id'] 	     = ($this->input->post('caste_type'))?$this->input->post('caste_type'):'';
		$data['full_address'] 	     = ($this->input->post('full_address'))?$this->input->post('full_address'):'';
		$data['is_active'] 	     = ($this->input->post('is_active'))?$this->input->post('is_active'):'0';
		
		if($contentId==0){
			$data['created_date']     = date('Y-m-d H:i:s');
			$data['created_by']   = $this->nsession->userdata('admin_session_id');
		}else{
			$data['modified_date']     = date('Y-m-d H:i:s');
			$data['modified_by']   = $this->nsession->userdata('admin_session_id');
		}
		
		if($contentId==0){
			$result = $this->ModelQuarter->addContent($data);
			$this->nsession->set_userdata('succmsg','Quarter added successfully.');
			redirect(base_url($this->controller));
		}else{
			$this->ModelQuarter->editContent($data,$contentId);
			$this->nsession->set_userdata('succmsg','Quarter updated successfully.');
			redirect(base_url($this->controller));
		}
	}

	function activate()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelQuarter->activate($id);
		$this->nsession->set_userdata('succmsg', 'Successfully Quarter Activated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	function inactive()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelQuarter->inactive($id);
		$this->nsession->set_userdata('succmsg', 'Successfully Quarter Inactivated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	function viewdetails($id){
		if($id){
			$rs = $this->ModelQuarter->getSingle($id);
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
			$data['succmsg'] = $this->nsession->userdata('succmsg');
			$data['errmsg'] = $this->nsession->userdata('errmsg');
			$this->nsession->set_userdata('succmsg', "");
			$this->nsession->set_userdata('errmsg', "");
			$elements = array();
			$elements['menu'] = 'menu/index';
			$elements['topmenu'] = 'menu/topmenu';
			$elements['main'] = 'quarter/view_details';
			$element_data['menu'] = $data;//array();
			$element_data['main'] = $data;
			$this->layout->setLayout('layout_main_view');
			$this->layout->multiple_view($elements,$element_data);
		}

	}
	public function quarterNoExist($id=0){
		$quarter_no = $this->input->post('quarter_no');
		$return = $this->ModelQuarter->quarterNoExist($quarter_no,$id);
		if(count($return)!=''){
			$error = "false";
		}else{
			$error = "true";
		}
		echo $error;
	}
	function delete($id){
		$this->functions->checkAdmin($this->controller.'/');
		$this->ModelQuarter->delete($id);
		$this->nsession->set_userdata('succmsg', 'Successfully quarter deleted.');
		redirect(base_url($this->controller."/index/"));
	}

}
?>
