<?php
//error_reporting(E_ALL);
class Adcategory extends CI_Controller {

	var $urlfix = "";
	
	function __construct()
	{
		parent::__construct();
		$this->controller = 'adcategory';
		$this->load->model('ModelAdcategory');
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

		$data['recordset'] 		= $this->ModelAdcategory->getList($config,$start,$param);
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
	
	function setParent($lv = 0, $set = '')
	{
		$parents = $this->ModelAdcategory->getParent($lv);
		$parent = '<select id="parent" name="parent" class="form-control">';
		if(count($parents) > 0) {
			foreach($parents as $parentSingle){
				if($set == $parentSingle['id'])
					$selected = " selected";
				else
					$selected = "";	
				$parent .= '<option value="'.$parentSingle['id'].'"'.$selected.'>'.$parentSingle['title_en'].'</option>';
			}
		} else {
			$parent .= '<option value="0">-- None --</option>';
		}
		$parent .= '</select>';
		echo $parent;
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
		
		$data['level_nos']			= $this->ModelAdcategory->nosLevel();
		
		if($contentId > 0)
		{
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelAdcategory->getSingle($contentId);
			$row = $rs->fields;
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
			if($data['is_paid']==1){
				$data['planData'] = $this->ModelAdcategory->getCategoryPlan($data['id']);
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
		$elements['main'] = 'adcategory/add_edit';
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
		$level = $this->input->request('level');
		if($contentId=='')   //add
		{
			if($level==0){
				if($contentId>0)   //edit
				{
					$returnCheck = $this->functions->checkContentAlreadyExist('ad_category','title_en',trim($this->input->request('title_en')),'edit',$contentId);
					if($returnCheck==false){
						$this->nsession->set_userdata('errmsg', 'Category Title Alreday Exist.');
						redirect(base_url($this->controller."/index/"));
						return true;
					}
				}else{
					$returnCheck = $this->functions->checkContentAlreadyExist('ad_category','title_en',trim($this->input->request('title_en')),'add',0);
					if($returnCheck==false){
						$this->nsession->set_userdata('errmsg', 'Category Title Alreday Exist.');
						redirect(base_url($this->controller."/index/"));
						return true;
					}
				} 
			}
		}
		
		
		$data['level'] 			= $this->input->request('level');
		$data['parent'] 		= $this->input->request('parent');
		$data['title_en'] 		= $this->input->request('title_en');
		$data['title_ch'] 		= $this->input->request('title_ch');
		if($contentId > 0)   //edit
		{
			$data['modified'] = date('Y-m-d H:i:s');
		}else{
			$data['created'] = date('Y-m-d H:i:s');
		}
		
		
		if($contentId > 0)   //edit
		{
			$affected_row = $this->ModelAdcategory->editContent($contentId,$data);
			$this->nsession->set_userdata('succmsg', 'Successfully Category Edited.');
			redirect(base_url($this->controller."/index/"));
			return true;
		}
		else    //add
		{	
			$insert_id = $this->ModelAdcategory->addContent($data);
			if($insert_id)
			{
				$this->nsession->set_userdata('succmsg', 'Successfully Category Added.');
				redirect(base_url($this->controller."/index/"));
				return true;
			}
		}	
	}
	
	function delete()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);		
		$this->ModelAdcategory->delete($id);		
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
				$this->ModelAdcategory->delete($id);
		}		
		$this->nsession->set_userdata('succmsg', 'Successfully Service Deleted.');
		redirect(base_url($this->controller."/"));
		return true;
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */

?>