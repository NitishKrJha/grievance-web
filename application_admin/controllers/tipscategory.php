<?php
//error_reporting(E_ALL);
class Tipscategory extends CI_Controller {

	var $urlfix = "";
	
	function __construct()
	{
		parent::__construct();
		$this->controller = 'tipscategory';
		$this->load->model('ModelTipscategory');
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
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','100');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');

		$data['recordset'] 		= $this->ModelTipscategory->getList($config,$start,$param);
		$data['startRecord'] 	= $start;
		
		$this->pagination->initialize($config);
		
		$data['params'] 			= $this->nsession->userdata('ADMIN_SERVICES');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['delete_link']      	= base_url($this->controller."/delete/{{ID}}/0");
        $data['activatedHomeCategoryLink']     = base_url($this->controller."/activatedHomeCategoryLink/{{ID}}/0");
        $data['inacttivedHomeCategoryLink']    = base_url($this->controller."/inacttivedHomeCategoryLink/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']			= $config['total_rows'];
		
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		$data['module'] = 'Tips Categories';
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		
		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'tipscategory/index';
		$element_data['menu'] = $data;
		$element_data['main'] = $data;
		
		$this->layout->setLayout('layout_main_view'); 
		$this->layout->multiple_view($elements,$element_data);
	
	}
	
	function setParent($lv = 0, $set = '')
	{
		$parents = $this->ModelTipscategory->getParent($lv);
		$parent = '<select id="parent" name="parent" class="form-control">';
		if(count($parents) > 0) {
			foreach($parents as $parentSingle){
				if($set == $parentSingle['id'])
					$selected = " selected";
				else
					$selected = "";	
				$parent .= '<option value="'.$parentSingle['id'].'"'.$selected.'>'.$parentSingle['title'].'</option>';
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
		
		$data['level_nos']			= $this->ModelTipscategory->nosLevel();
		
		if($contentId > 0)
		{
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelTipscategory->getSingle($contentId);
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
		}else{
			$data['action'] 	= "Add";
			$data['id']			= 0;
			
			$data['level'] 			= $this->input->request('level');
			$data['parent'] 		= $this->input->request('parent');
			$data['title'] 		= $this->input->request('title');
		}
		
		$data['succmsg'] = $this->nsession->userdata('succmsg');
		$data['errmsg'] = $this->nsession->userdata('errmsg');
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		
		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'tipscategory/add_edit';
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
					$returnCheck = $this->functions->checkContentAlreadyExist('tips_category','title',trim($this->input->request('title')),'edit',$contentId);
					if($returnCheck==false){
						$this->nsession->set_userdata('errmsg', 'Tips Category Title Alreday Exist.');
						redirect(base_url($this->controller."/index/"));
						return true;
					}
				}else{
					$returnCheck = $this->functions->checkContentAlreadyExist('tips_category','title',trim($this->input->request('title')),'add',0);
					if($returnCheck==false){
						$this->nsession->set_userdata('errmsg', 'Tips Category Title Alreday Exist.');
						redirect(base_url($this->controller."/index/"));
						return true;
					}
				} 
			}
		}
		$data['level'] 			= $this->input->request('level');
		$data['parent'] 		= $this->input->request('parent');
		$data['title'] 		= $this->input->request('title');
		if($contentId > 0)   //edit
		{
			$data['modified'] = date('Y-m-d H:i:s');
		}else{
			$data['created'] = date('Y-m-d H:i:s');
		}
		if($contentId > 0)   //edit
		{
			$affected_row = $this->ModelTipscategory->editContent($contentId,$data);
			$this->nsession->set_userdata('succmsg', 'Successfully Tips Category Edited.');
			redirect(base_url($this->controller."/index/"));
			return true;
		}
		else    //add
		{	
			$insert_id = $this->ModelTipscategory->addContent($data);
			if($insert_id)
			{
				$this->nsession->set_userdata('succmsg', 'Successfully Tips Category Added.');
				redirect(base_url($this->controller."/index/"));
				return true;
			}
		}	
	}
	
	function delete()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);		
		if($this->ModelTipscategory->delete($id)){
            $this->nsession->set_userdata('succmsg', 'Successfully Tips Category Deleted.');
        }else{
            $this->nsession->set_userdata('errmsg', 'Already tips has been added using this category! Sorry you are not allowed to delete');
        }
		redirect(base_url($this->controller."/index/"));
		return true;
	}
    function deletesubcat()
    {
        $this->functions->checkAdmin($this->controller.'/');
        $parentId = $this->uri->segment(3, 0);
        $childId = $this->uri->segment(4, 0);
        if($this->ModelTipscategory->deleteSubcat($childId)){
            $this->nsession->set_userdata('succmsg', 'Successfully Tips Sub-Category Deleted.');
        }else{
            $this->nsession->set_userdata('errmsg', 'Already tip has been added using this category! Sorry you are not allowed to delete');
        }
        redirect(base_url($this->controller."/subcategory/".$parentId));
        return true;
    }
	function subcategory(){

        $this->functions->checkAdmin($this->controller.'/');
        $config['base_url'] 			= base_url($this->controller."/subcategory/");

        $config['uri_segment']  		= 4;
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
        $param['searchDisplay'] 	= $this->input->request('searchDisplay','100');
        $param['searchAlpha'] 		= $this->input->request('txt_alpha','');
        $param['searchMode'] 		= $this->input->request('search_mode','STRING');
        $param['parentId'] 		    = $this->uri->segment(3);


        $data['recordset'] 		= $this->ModelTipscategory->getSubCategoryList($config,$start,$param);
        $data['startRecord'] 	= $start;

        $this->pagination->initialize($config);

        $data['params'] 			= $this->nsession->userdata('ADMIN_SUBCATGORY');
        $data['reload_link']      	= base_url($this->controller."/subcategory/".$param['parentId']);
        $data['search_link']        = base_url($this->controller."/subcategory/".$param['parentId']."/0/1/");
        $data['add_link']         	= base_url($this->controller."/addedit/0/0/");
        $data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
        $data['delete_link']      	= base_url($this->controller."/deletesubcat/{{ID}}/0");
        $data['showall_link']     	= base_url($this->controller."/subcategory/".$param['parentId']."/0/1");
        $data['total_rows']			= $config['total_rows'];

        $data['succmsg'] 	= $this->nsession->userdata('succmsg');
        $data['errmsg'] 	= $this->nsession->userdata('errmsg');
        $data['module'] = 'Tips SubCategories';
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['menu'] = 'menu/index';
        $elements['topmenu'] = 'menu/topmenu';
        $elements['main'] = 'tipscategory/subcategory';
        $element_data['menu'] = $data;
        $element_data['main'] = $data;

        $this->layout->setLayout('layout_main_view');
        $this->layout->multiple_view($elements,$element_data);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */

?>