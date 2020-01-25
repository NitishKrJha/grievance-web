<?php
//error_reporting(E_ALL);
class Booking extends CI_Controller {

	var $urlfix = "";

	function __construct()
	{
		parent::__construct();
		$this->controller = 'booking';
		$this->load->model('ModelBooking');
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
		$param['sortField'] 		= $this->input->request('sortField','booking_id');
		$param['searchField'] 		= $this->input->request('searchField','');
		$param['searchString'] 		= $this->input->request('searchString','');
		$param['searchText'] 		= $this->input->request('searchText','');
		$param['searchFromDate'] 	= $this->input->request('searchFromDate','');
		$param['searchToDate'] 		= $this->input->request('searchToDate','');
		$param['searchDisplay'] 	= $this->input->request('searchDisplay','20');
		$param['searchAlpha'] 		= $this->input->request('txt_alpha','');
		$param['searchMode'] 		= $this->input->request('search_mode','STRING');

		$data['recordset'] 		= $this->ModelBooking->getList($config,$start,$param);
		
		//pr($data['recordset']);
		
		$data['startRecord'] 	= $start;
		
		$data['module']			= "Counselor Booking details";
		
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
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'booking/index';

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
		$data['tipscategory'] = $this->functions->getTableData('tips_category',array('parent'=>0));
		if($contentId > 0)
		{
			$data['adminpage_id'] = $contentId;
			$data['action'] = "Edit";
			//=================prepare DATA ==================
			$rs = $this->ModelTips->getSingle($contentId);
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
		$elements['main'] = 'tips/add_edit';
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
			$data['category_id'] 		= $this->input->post('category_id');
			$data['sub_category_id'] 	= $this->input->post('sub_category_id');
			$data['title'] 				= $this->input->post('title');
			$data['content'] 			= $this->input->post('content');
			$old_pic					= $this->input->post('old_pic');
			$data['paid_or_free'] 		= $this->input->post('paid_or_free');
			$data['created_date'] 		= date('Y-m-d H:i:s');
		}else{
			$data['category_id'] 		= $this->input->post('category_id');
			$data['sub_category_id'] 	= $this->input->post('sub_category_id');
			$data['title'] 				= $this->input->post('title');
			$data['content'] 			= $this->input->post('content');
			$old_pic					= $this->input->post('old_pic');
			$data['paid_or_free'] 		= $this->input->post('paid_or_free');
		}

		$profile_pic = $_FILES['icon']['name'];
		if($profile_pic !=''){
			$new_profile_pic = time().$profile_pic;
			$config['upload_path'] 	 = file_upload_absolute_path().'tips_image/';
			$config['allowed_types'] = '*';
			//$config['max_size']      = 20480;
			//$config['max_width']     = 300;
			//$config['max_height']    = 200;
			$config['file_name']     = $new_profile_pic;
			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('icon')) {
			  $this->nsession->set_userdata('errmsg', $this->upload->display_errors());
			  redirect(base_url($this->controller));
			}else {
			  $upload_data = array('upload_data' => $this->upload->data());
			}
			if($upload_data['upload_data']['file_name']) {
			  if($oauth_uid==''){
			    $data['icon'] = $upload_data['upload_data']['file_name'];
			  }else{
			    $data['icon'] = file_upload_base_url().'tips_image/'.$upload_data['upload_data']['file_name'];
			  }
			}else{
			  $data['icon'] = "";
			}
		}else{
			$data['icon'] = $old_pic;
		}
	if($contentId==0){
		$this->ModelTips->addContent($data);
		$this->nsession->set_userdata('succmsg','Tips added successfully.');
		redirect(base_url($this->controller));
	}else{
		$this->ModelTips->editContent($data,$contentId);
		$this->nsession->set_userdata('succmsg','tips/Managers updated successfully.');
		redirect(base_url($this->controller));
	}
	}

	function activate()
	{
			
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelBooking->activate($id);
	
		$result 		= $this->ModelBooking->getsingle_empdata($id);
		
				$to 			= $result[0]['member_email'];
				$subject		= "Booking Confirm";
				$body			= "<tr><td>Hi, Member</td></tr>
									<tr><td> Admin Assign to ".$result[0]['counselorName']." </td></tr>";
									
				$this->functions->mail_template($to,$subject,$body);
				
				$to1 			= $result[0]['counselorEmail'];
				$subject1		= "Booking Assign";
				$body1			= "<tr><td> Hi,Counselor </td></tr>
									<tr><td> ".$result[0]['name']." has been assigned to you.</td></tr>";
									
				$this->functions->mail_template($to1,$subject1,$body1);
				
		$this->nsession->set_userdata('succmsg', 'Successfully Assign.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}

	function givepermission(){
		$booking_id=($this->input->post('booking_id'))?$this->input->post('booking_id'):0;
		$booking_status=($this->input->post('booking_status'))?$this->input->post('booking_status'):0;
		if($booking_id > 0){
			$n_c_data=array();
			$n_m_data=array();
			if($booking_status==0){
				
				$this->ModelBooking->inactive($booking_id);
				$result 		= $this->ModelBooking->getsingle_empdata($booking_id);
				$n_c_data['member_id']=$result[0]['member_id'];
				$n_c_data['site_url']='member/booking_notification';
				$n_c_data['contents']=$result[0]['counselorName']." has been approved your appointment";
				$n_c_data['type']='booking';
				$n_c_data['created_date']=date('Y-m-d H:i:s');

				$n_m_data['member_id']=$result[0]['counselor_id'];
				$n_m_data['site_url']='counselor/booked_member';
				$n_m_data['contents']=$result[0]['memberName']." has been assigned to you";
				$n_m_data['type']='appointment';
				$n_m_data['created_date']=date('Y-m-d H:i:s');

				$to 			= $result[0]['member_email'];
				$subject		= ($this->input->post('subject'))?$this->input->post('subject'):"Booking Confirm";
				$body			= "<tr><td>Hi, Member</td></tr>
									<tr><td> Admin Assign to ".$result[0]['counselorName']." </td></tr>";
				if($this->input->post('message')){
					$body			= $this->input->post('message');
				}
				$body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
                  <tbody style="color: #fff;">
                    <tr>
                      <td colspan="3" width="600" height="10" align="left" />
                    </tr>
                    <tr style="text-align:center;">
                      <td width="13" align="left"/>
                      <td width="13" align="left"/>
                    </tr>
                    '.$body.'
                  </tbody>
                </table></td>';					
				$this->functions->mail_template($to,$subject,$body);
				$to1 			= $result[0]['counselorEmail'];
				$subject1		= ($this->input->post('c_subject'))?$this->input->post('c_subject'):"Booking Assign";
				$body1			= "<tr><td> Hi,Counselor </td></tr>
									<tr><td> ".$result[0]['memberName']." has been assigned to you.</td></tr>";
				if($this->input->post('c_message')){
					$body1			= $this->input->post('c_message');
				}
				$body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
                  <tbody style="color: #fff;">
                    <tr>
                      <td colspan="3" width="600" height="10" align="left" />
                    </tr>
                    <tr style="text-align:center;">
                      <td width="13" align="left"/>
                      <td width="13" align="left"/>
                    </tr>
                    '.$body1.'
                  </tbody>
                </table></td>';					
				$this->functions->mail_template($to1,$subject1,$body);
				$this->ModelBooking->insertData('member_notification',$n_m_data);
				$this->ModelBooking->insertData('member_notification',$n_c_data);
				$this->nsession->set_userdata('succmsg', 'Successfully Assign.');
				echo 'true';
			}else{
				$this->ModelBooking->activate($booking_id);
				$result 		= $this->ModelBooking->getsingle_empdata($booking_id);

				$n_c_data['member_id']=$result[0]['member_id'];
				$n_c_data['site_url']='member/booking_notification';
				$n_c_data['contents']="Your appointment has been cancelled due to the some reason";
				$n_c_data['type']='booking';
				$n_c_data['created_date']=date('Y-m-d H:i:s');

				$n_m_data['member_id']=$result[0]['counselor_id'];
				$n_m_data['site_url']='counselor/booked_member';
				$n_m_data['contents']="Your appointment has been cancelled due to the some reason";
				$n_m_data['type']='appointment';
				$n_m_data['created_date']=date('Y-m-d H:i:s');

				$to 			= $result[0]['member_email'];
				$subject		= ($this->input->post('subject'))?$this->input->post('subject'):"Booking Canceled";
				$body			= "<tr><td>Hi, Member</td></tr>
									<tr><td> Admin Assign to ".$result[0]['counselorName']." </td></tr>";
				if($this->input->post('message')){
					$body			= $this->input->post('message');
				}					
				$this->functions->mail_template($to,$subject,$body);
				
				$to1 			= $result[0]['counselorEmail'];
				$subject1		= ($this->input->post('c_subject'))?$this->input->post('c_subject'):"Booking Canceled";
				$body1			= "<tr><td> Hi,Counselor </td></tr>
									<tr><td> ".$result[0]['memberName']." has been assigned to you.</td></tr>";
				if($this->input->post('c_message')){
					$body1			= $this->input->post('c_message');
				}					
				$this->functions->mail_template($to1,$subject1,$body1);
				$this->nsession->set_userdata('succmsg', 'Successfully Canceled.');
				$this->ModelBooking->insertData('member_notification',$n_m_data);
				$this->ModelBooking->insertData('member_notification',$n_c_data);
				echo 'true';
			}
		}else{
			$this->nsession->set_userdata('errmsg', 'Unable to update , please try after some time');
			echo 'false';
		}
	}

	function inactive()
	{
		
		
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
				
		
		$this->ModelBooking->inactive($id);
		
		$result 		= $this->ModelBooking->getsingle_empdata($id);
		 
		//pr($result);
		 
				$to 			= $result[0]['member_email'];
				$subject		= "Booking Assign";
				$body			= "<tr><td>Hi, Member</td></tr>
									<tr><td> Admin Assign to ".$result[0]['counselorName']." </td></tr>";
									
				$this->functions->mail_template($to,$subject,$body);
				
				$to1 			= $result[0]['counselorEmail'];
				$subject1		= "Booking Assign";
				$body1			= "<tr><td> Hi,Counselor </td></tr>
									<tr><td> Admin Assign to ".$result[0]['name']." </td></tr>";
									
				$this->functions->mail_template($to1,$subject1,$body1);
				
		$this->nsession->set_userdata('succmsg', 'Successfully Assign.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	
	function viewdetails($id){
		if($id){
			$rs = $this->ModelTips->getSingle($id);
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
			$elements['main'] = 'tips/view_details';
			$element_data['menu'] = $data;//array();
			$element_data['main'] = $data;
			$this->layout->setLayout('layout_main_view');
			$this->layout->multiple_view($elements,$element_data);
		}

	}
	public function emailExist(){
		$email_id = $this->input->post('email');
		$return = $this->ModelTips->checkEmail($email_id);
		if(count($return)!=''){
			$error = 1;
		}else{
			$error = 0;
		}
		echo json_encode(array('error'=>$error));
	}
	public function do_delete(){
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelTips->doDeleteMemeber($id);
		$result 		= $this->ModelTips->getsingle_empdata($id);
		$email 			= $result->email;
		$first_name = $result->first_name;

		$to 				= $email;
		$subject		='KSC Account deleted';
		$body='<tr><td>Hi,</td></tr>
				<tr><td>Name : '.$first_name.'</td></tr>
				<tr style="background:#fff;"><td>Your account has been deleted from ksc rent.</td></tr>';
		$return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully account deleted.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	function delete($id){
		$this->functions->checkAdmin($this->controller.'/');
		$deleteTips = $this->ModelTips->detete($id);
		$this->nsession->set_userdata('succmsg', 'Successfully Tips deleted.');
		redirect(base_url($this->controller));
		return true;
	}
	
	function getSubcategory()
	{
	   $catId = $this->input->post('category_id');			
	   echo json_encode($this->functions->getAllTable('tips_category','id,title','parent',$catId));
	}

}
?>
