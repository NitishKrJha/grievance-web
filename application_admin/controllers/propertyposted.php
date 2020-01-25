<?php
//error_reporting(E_ALL);
class Propertyposted extends CI_Controller {

	var $urlfix = "";

	function __construct()
	{
		parent::__construct();
		$this->controller = 'propertyposted';
		$this->load->model('ModelPropertyPosted');
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

		$data['recordset'] 		= $this->ModelPropertyPosted->getList($config,$start,$param);
		$data['startRecord'] 	= $start;

		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_POSTEDADS');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']			= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'propertyposted/index';

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
			$rs = $this->ModelPropertyPosted->getSingle($contentId);
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
		$elements['main'] = 'owner/add_edit';
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
			$this->form_validation->set_rules('name', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('confpass', 'Re-Password', 'trim|required|matches[password]|xss_clean');
			$this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
		}else{
			$this->form_validation->set_rules('name', 'Username', 'trim|required|xss_clean');
		}

		$this->form_validation->set_error_delimiters('<ul class="parsley-errors-list filled error text-left" ><li class="parsley-required">', '</li></ul>');
		if($this->form_validation->run() == TRUE)
		{
			if($contentId==0){
				$data['name'] 		= $this->input->post('name');
				$data['username'] 	= $this->input->post('email');
				$data['password'] 	= md5($this->input->post('confpass'));
				$data['address'] 	= $this->input->post('address');
				$data['type'] 		= 1;
				$data['status'] 	= 1;
				$data['addedon'] 	= date('Y-m-d');
			}else{
				$data['name'] 		= $this->input->post('name');
				$data['address1'] 	= $this->input->post('address1');
				$data['address2'] 	= $this->input->post('address2');
				$data['zip_code'] 	= $this->input->post('zip_code');
				$data['state'] 		= $this->input->post('state');
				$data['city'] 		= $this->input->post('city');
				$data['supplier_type'] = $this->input->post('supplier_type');
			}
			if($contentId==0){
				$this->ModelPropertyPosted->addContent($data);
				$this->nsession->set_userdata('succmsg','Supplier added successfully.');
				redirect(base_url($this->controller));
			}else{
				$this->ModelPropertyPosted->editContent($data,$contentId);
				$this->nsession->set_userdata('succmsg','Supplier edited successfully.');
				redirect(base_url($this->controller));
			}

		}else{
			$this->addedit($contentId);
		}
	}

	function activate()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelPropertyPosted->activate($id);
		$emp_id = $this->ModelPropertyPosted->getMemberIdFromProperty($id);
		$result = $this->ModelPropertyPosted->getsingle_empdata($emp_id['member_id']);
		$email = $result->email;
		$first_name = $result->first_name;

		$to = $email;
		$subject='KSC Account Activated';
		$body='<tr><td>Hi,</td></tr>
				<tr><td>Name : '.$first_name.'</td></tr>
				<tr style="background:#fff;"><td>Your property has been activated successfully.</td></tr>';
		$return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully property Activated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	function inactive()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelPropertyPosted->inactive($id);
		$emp_id = $this->ModelPropertyPosted->getMemberIdFromProperty($id);
		$result = $this->ModelPropertyPosted->getsingle_empdata($emp_id['member_id']);
		$email = $result->email;
		$first_name = $result->first_name;

		$to = $email;
		$subject='KSC Account Activated';
		$body='<tr><td>Hi,</td></tr>
				<tr><td>Name : '.$first_name.'</td></tr>
				<tr style="background:#fff;"><td>Your property has been deactivated successfully.</td></tr>';
		$return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully property Inactivated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	function viewdetails($id,$parentId,$childId){
		if($id){
			$data['resultData'] = $this->ModelPropertyPosted->getSingle($id);

			/* Get Dynamic Form for title */
			if($childId==null){
				$resultSet = $this->mongo_db->where(array('parent' =>$parentId))->get('dynamic_form');
				$dynamic_form = html_entity_decode($resultSet[0]['json_form_data']);
				$dynamic_form = ltrim($dynamic_form, '"');
				$dynamic_form = rtrim($dynamic_form, '"');
				$dynamic_form = $dynamic_form;
			}else{
				$resultSet = $this->mongo_db->where(array('parent' =>$parentId,'child' =>$childId))->get('dynamic_form');
				$dynamic_form = html_entity_decode($resultSet[0]['json_form_data']);
				$dynamic_form = ltrim($dynamic_form, '"');
				$dynamic_form = rtrim($dynamic_form, '"');
				$dynamic_form = $dynamic_form;
			}
			$data['dynamic_form'] = json_decode($dynamic_form);


			$data['succmsg'] = $this->nsession->userdata('succmsg');
			$data['errmsg'] = $this->nsession->userdata('errmsg');
			$this->nsession->set_userdata('succmsg', "");
			$this->nsession->set_userdata('errmsg', "");
			$elements = array();
			$elements['menu'] = 'menu/index';
			$elements['topmenu'] = 'menu/topmenu';
			$elements['main'] = 'postedads/view_details';
			$element_data['menu'] = $data;//array();
			$element_data['main'] = $data;
			$this->layout->setLayout('layout_main_view');
			$this->layout->multiple_view($elements,$element_data);
		}
	}
	function do_delete()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelPropertyPosted->doDeleteProperty($id);
		$emp_id = $this->ModelPropertyPosted->getMemberIdFromProperty($id);
		$result = $this->ModelPropertyPosted->getsingle_empdata($emp_id['member_id']);
		$email = $result->email;
		$first_name = $result->first_name;

		$to = $email;
		$subject='KSC Property Deleted';
		$body='<tr><td>Hi,</td></tr>
				<tr><td>Name : '.$first_name.'</td></tr>
				<tr style="background:#fff;"><td>Your property has been deleted from KSC Rent.</td></tr>';
		$return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully property Inactivated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}

}
?>
