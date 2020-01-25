<?php
class Notification extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'notification';
		$this->load->model('ModelNotification');
		$this->load->model('ModelMember');
	}

	public function index()
	{
        $this->functions->checkUser($this->controller.'/',true);
        $memberId = $this->nsession->userdata('member_session_id');
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
		$param['memberId']=$memberId;
		$data['recordset'] 		= $this->ModelNotification->getList($config,$start,$param);
		
		//pr($data['recordset']);
		
		$data['startRecord'] 	= $start;
		
		$data['module']			= "Notification";
		
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_TIPS');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		$data['memberData']     = $this->ModelMember->getMemberData($memberId);
		$elements = array();
		$elements['header'] = 'layout/headerInner';
		$element_data['header'] = $data;
		$elements['main'] = 'notification/index';
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer_v_chat';
		$element_data['footer'] = $data;
        $elements['chat'] = 'layout/chat_page';
		$this->layout->setLayout('layout_inner');
		$this->layout->multiple_view($elements,$element_data);
    }
	
	
}
