<?php
//error_reporting(E_ALL);
class DynamicForm extends CI_Controller {

	var $urlfix = "";
	
	function __construct()
	{
		parent::__construct();
		$this->controller = 'dynamicform';
		$this->load->model('ModelDynamicform');
	}
	
	function index()
	{
		$this->functions->checkAdmin($this->controller.'/');
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

		$data['recordset'] 		= $this->ModelDynamicform->getList($config,$start,$param);
		$data['startRecord'] 	= $start;
		
		$this->pagination->initialize($config);
		
		$data['params'] 			= $this->nsession->userdata('ADMIN_SERVICES');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['delete_link']      	= base_url($this->controller."/delete/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']			= $config['total_rows'];
		
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$data['module'] = 'Ad Categories';
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		
		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'adcategory/index';
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
		
		$data['adParent']			= $this->ModelDynamicform->getAdParent();
		
		if($contentId > 0)
		{
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelDynamicform->getSingle($contentId);
			//$row = $rs->fields;
			if(is_array($rs[0]))
			{
				foreach($rs[0] as $key => $val)
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
			
			$data['level'] 			= $this->input->request('level');
			$data['parent'] 		= $this->input->request('parent');
			$data['title_en'] 		= $this->input->request('title_en');
			$data['title_fr'] 		= $this->input->request('title_fr');
			$data['icon'] 			= $this->input->request('icon');
		}
		
		$data['succmsg'] = $this->nsession->userdata('succmsg');
		$data['errmsg'] = $this->nsession->userdata('errmsg');
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		
		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'dynamicform/add_edit';
		$element_data['main'] = $data;
		$element_data['main'] = $data;
		
		$this->layout->setLayout('layout_main_view'); 
		$this->layout->multiple_view($elements,$element_data);
		
	}
	
	function do_addedit()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$contentId = $this->uri->segment(3, 0); 
		$page = $this->uri->segment(4, 0); 
		
		$data['parent'] 				= $this->input->request('parent');
		$data['child'] 					= $this->input->request('child');
		$data['json_form_data'] 		= json_encode($this->input->request('json_form_data'));
		
		//pr($data);
		$checkData = $this->mongo_db->where(array('parent' => $data['parent']))->get('dynamic_form');
		if(count($checkData) > 0){
			$updateData = array('parent'=>$data['parent'],'child'=>$data['child'],'json_form_data'=>$data['json_form_data']);
			$this->mongo_db->where(array('parent'=>$data['parent']))->set($updateData)->update('dynamic_form',$data);
			
			$this->nsession->set_userdata('succmsg', 'Successfully Form Edited.');
			redirect(base_url($this->controller."/addedit/0/0/"));
			return true;
		}else{
			$this->mongo_db->insert('dynamic_form',$data);
			
			$this->nsession->set_userdata('succmsg', 'Successfully Form Edited.');
			redirect(base_url($this->controller."/addedit/0/0/"));
			return true;
		}
	
		/* if($contentId > 0)   //edit
		{
			$affected_row = $this->ModelDynamicform->editContent($contentId,$data);
			$this->nsession->set_userdata('succmsg', 'Successfully Category Edited.');
			redirect(base_url($this->controller."/index/"));
			return true;
		}
		else    //add
		{	
			$insert_id = $this->ModelDynamicform->addContent($data);
			if($insert_id)
			{
				$this->nsession->set_userdata('succmsg', 'Successfully Category Added.');
				redirect(base_url($this->controller."/index/"));
				return true;
			}
		} */	
	}
	
	function delete()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);		
		$this->ModelDynamicform->delete($id);		
		$this->nsession->set_userdata('succmsg', 'Successfully Service Deleted.');

		redirect(base_url($this->controller."/index/"));
		return true;
	}
	
	function deleteall()
	{
		$this->functions->checkAdmin($this->controller.'/');		
		$id_str = $this->input->request('check_ids',0);
		$id_arr = explode("^",$id_str);
		foreach($id_arr as $id){	
			if($id<>'' && $id<>0)		
				$this->ModelDynamicform->delete($id);
		}		
		$this->nsession->set_userdata('succmsg', 'Successfully Service Deleted.');
		redirect(base_url($this->controller."/"));
		return true;
	}
	function getChild(){
		
		$parent = $this->input->request('parent');
		$resultSet = $this->mongo_db->where(array('parent' => $parent))->get('dynamic_form');
		
		$dynamic_form = html_entity_decode($resultSet[0]['json_form_data']);
		$dynamic_form = ltrim($dynamic_form, '"');
		$dynamic_form = rtrim($dynamic_form, '"');
			
		$childDatas = $this->ModelDynamicform->getChildData($parent);
		if(count($childDatas)>0){
			$html .= "<option value=''>Select Sub Category</option>";
			foreach($childDatas as $childData){
				$html .= "<option value='".$childData['id']."'>".$childData['title_en']."</option>";
			}
			$is_child=1;
			$dynamic_form='';
		}else{
			$dynamic_form = $dynamic_form;
			$is_child=0;
		}
		echo json_encode(array('is_child'=>$is_child,'dynamic_form'=>$dynamic_form,'html'=>$html));
	}
	function getChildForm(){
		
		$parent = $this->input->request('parent');
		$child = $this->input->request('child');
		$resultSet = $this->mongo_db->where(array('parent' => $parent,'child' => $child))->get('dynamic_form');
		if(count($resultSet)>0){
			$dynamic_form = html_entity_decode($resultSet[0]['json_form_data']);
			$dynamic_form = ltrim($dynamic_form, '"');
			$dynamic_form = rtrim($dynamic_form, '"');
			$dynamic_form = $dynamic_form;
			$have_form = 1;
		}else{
			$dynamic_form='';
			$have_form = 0;
		}
		echo json_encode(array('dynamic_form'=>$dynamic_form,'have_form'=>$have_form));
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */

?>