<?php
class Tips extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'tips';
		$this->load->model('ModelTips');
		$this->load->model('ModelMember');
	}

	function index()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$member_id = $this->nsession->userdata('member_session_id');
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

		$param['category_id'] 		= $this->input->request('category_id','');
		$param['sub_category_id'] 		= $this->input->request('sub_category_id','');
		
		 $data['memberData']     = $this->ModelMember->getMemberData($member_id);
		$data['recordset'] 		= $this->ModelTips->getList($config,$start,$param);
		$data['tipscategory'] = $this->functions->getTableData('tips_category',array('parent'=>0));
		$data['startRecord'] 	= $start;
		$data['module']			= "Tips Management";
		
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_TIPS');
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
        $elements['main'] = 'tips/tips';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_inner');
        $this->layout->multiple_view($elements,$element_data);

	}

	function getSubcategory()
	{
	   $catId = $this->input->post('category_id');			
	   echo json_encode($this->functions->getAllTable('tips_category','id,title','parent',$catId));
	}
	
	function viewdetails($id){
		//pr($_SERVER);
		$this->functions->checkUser($this->controller.'/',true);
		$tipId 		= base64_decode($this->uri->segment(3));
		$member_id 	= $this->nsession->userdata('member_session_id');
		if($tipId!=''){
			
			/*Check if Tips Remaing and have plan */

			$planData = $this->ModelTips->check_plan($member_id);
			
			if(count($planData)>0){
				$r=$this->ModelTips->reading_update($member_id);
				//$this->db->close();
				//echo "<script>alert(1);</script>";
			
					
					$rs = $this->ModelTips->getSingle($tipId);
					
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

							
					//$this->nsession->set_userdata('succmsg', "");
					//$this->nsession->set_userdata('errmsg', "");
					$data['memberData']     = $this->ModelMember->getMemberData($member_id);
					$elements = array();
					$elements['header'] = 'layout/headerInner';
					$element_data['header'] = $data;
					$elements['main'] = 'tips/tips_details';
					$element_data['main'] = $data;
					$elements['footer'] = 'layout/footer';
					$element_data['footer'] = $data;
					$this->layout->setLayout('layout_inner');
					$this->layout->multiple_view($elements,$element_data);
				
			}else{
				$this->nsession->set_userdata('errmsg','You need to buy membership to read paid tips.');
				redirect(base_url('tips'));
			}
		}else{
			$this->nsession->set_userdata('errmsg','You do not have access this page.');
			redirect();
		}
		
	}
	
	function freeviewdetails()
	{
		$this->functions->checkUser($this->controller.'/',true);
		$tipId 		= base64_decode($this->uri->segment(3));
		$member_id 	= $this->nsession->userdata('member_session_id');
		if($tipId!=''){
			
			/*Check if Tips Remaing and have plan */

			$planData = $this->ModelTips->check_plan($member_id);
			
			
					
					$rs = $this->ModelTips->getSingle($tipId);
					
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

							
					//$this->nsession->set_userdata('succmsg', "");
					//$this->nsession->set_userdata('errmsg', "");
					$data['memberData']     = $this->ModelMember->getMemberData($member_id);
					$elements = array();
					$elements['header'] = 'layout/headerInner';
					$element_data['header'] = $data;
					$elements['main'] = 'tips/tips_details';
					$element_data['main'] = $data;
					$elements['footer'] = 'layout/footer';
					$element_data['footer'] = $data;
					$this->layout->setLayout('layout_inner');
					$this->layout->multiple_view($elements,$element_data);
				
			
		}else{
			$this->nsession->set_userdata('errmsg','You do not have access this page.');
			redirect();
		}
	}

}
