<?php
class Testimonial extends CI_Controller {

	var $urlfix = "";
	
	function __construct()
	{
		parent::__construct();
		$this->controller = 'testimonial';
		$this->load->model('ModelTestimonial');
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
		$data['module'] = 'Testimonal';
		
		$param['sortType'] 			= $this->input->request('sortType','DESC');
		$param['sortField'] 		= $this->input->request('sortField','testimonial_id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','20');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');

		$data['recordset'] 		= $this->ModelTestimonial->getList($config,$start,$param);
		
		$data['startRecord'] 	= $start;
		
		$this->pagination->initialize($config);
		
		$data['params'] 			= $this->nsession->userdata('ADMIN_FAQ');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']     = base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		$data['delete_link']      	= base_url($this->controller."/delete/{{ID}}/0");
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']			= $config['total_rows'];
		
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		
		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'testimonial/index';
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
			$rs = $this->ModelTestimonial->getSingle($contentId );
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
			
			$data['question'] 		= $this->input->request('question');
			$data['answer'] 		= $this->input->request('answer');
		}
		
		$data['succmsg'] = $this->nsession->userdata('succmsg');
		$data['errmsg'] = $this->nsession->userdata('errmsg');
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
		
		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'testimonial/add_edit';
		$element_data['main'] = $data;
		
		$this->layout->setLayout('layout_main_view'); 
		$this->layout->multiple_view($elements,$element_data);
		
	}
	
	function do_addedit()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$contentId = $this->uri->segment(3, 0); 
		$page = $this->uri->segment(4, 0); 
		
		//$question		= $this->input->request('question');
		
		//$this->form_validation->set_rules('question', 'Help Center Question', 'trim|required|xss_clean');
		
		//$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		/* if($this->form_validation->run() == TRUE)
		{ */
		
		
					$data['description'] 		= $this->input->request('description');
					$data['fullname'] 		= $this->input->request('fullname');
					$data['address'] 		= $this->input->request('address');
					$old_pic				= $this->input->request('old_pic');
					
				$profile_pic = $_FILES['image']['name'];
				if($profile_pic !=''){
					$new_profile_pic = time().$profile_pic;
					$config['upload_path'] 	 = file_upload_absolute_path().'testimonial/';
					$config['allowed_types'] = '*';
					//$config['max_size']      = 20480;
					//$config['max_width']     = 300;
					//$config['max_height']    = 200;
					$config['file_name']     = $new_profile_pic;
					$this->load->library('upload', $config);

					$this->upload->initialize($config);
					if (!$this->upload->do_upload('image')) {
					  $this->nsession->set_userdata('errmsg', $this->upload->display_errors());
					  redirect(base_url($this->controller));
					}else {
					  $upload_data = array('upload_data' => $this->upload->data());
					}
					if($upload_data['upload_data']['file_name']) {
					  if($oauth_uid==''){
						$data['image'] = $upload_data['upload_data']['file_name'];
					  }else{
						$data['image'] = file_upload_base_url().'tips_image/'.$upload_data['upload_data']['file_name'];
					  }
					}else{
					  $data['image'] = "";
					}
				}else{
					$data['image'] = $old_pic;
				}
		
		
			
					
				
				if($contentId > 0)   //edit
				{
					$affected_row = $this->ModelTestimonial->editContent($contentId,$data);
					$this->nsession->set_userdata('succmsg', 'Successfully Testimonial content Edited.');
					redirect(base_url($this->controller."/index/"));
					return true;
				}
				else    //add
				{	
					$insert_id = $this->ModelTestimonial->addContent($data);					
					if($insert_id)
					{
						$this->nsession->set_userdata('succmsg', 'Successfully Testimonial content Added.');
						redirect(base_url($this->controller."/index/"));
						return true;
					}
				}
		
			
			
		/*}*/
		/* else
		{
			$this->addedit($contentId,$page);
		}	 */
	}
	
	function delete()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);		
		$this->ModelTestimonial->delete($id);		
		$this->nsession->set_userdata('succmsg', 'Successfully Help Center content Deleted.');

		redirect(base_url($this->controller."/index/"));
		return true;
	}
	
	function inactive()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);		
		$this->ModelTestimonial->inactive($id);		
		$this->nsession->set_userdata('succmsg', 'Successfully Help Center content Inactivated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	function activate()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);		
		$this->ModelTestimonial->activate($id);		
		$this->nsession->set_userdata('succmsg', 'Successfully Help Center content Inactivated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */

?>