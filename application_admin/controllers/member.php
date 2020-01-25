<?php
//error_reporting(E_ALL);
class Member extends CI_Controller {

	var $urlfix = "";

	function __construct()
	{
		parent::__construct();
		$this->controller = 'member';
		$this->load->model('ModelMember');
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

		$data['recordset'] 		= $this->ModelMember->getList($config,$start,$param);
		
		//pr($data['recordset']);
		
		$data['startRecord'] 	= $start;
		$data['module']			= "Member";
		$this->pagination->initialize($config);

		$data['params'] 			= $this->nsession->userdata('ADMIN_MEMBER');
		$data['reload_link']      	= base_url($this->controller."/index/");
		$data['search_link']        = base_url($this->controller."/index/0/1/");
		$data['add_link']         	= base_url($this->controller."/addedit/0/0/");
		$data['edit_link']        	= base_url($this->controller."/addedit/{{ID}}/0");
		$data['activated_link']    	= base_url($this->controller."/activate/{{ID}}/0");
		$data['inacttived_Link']    = base_url($this->controller."/inactive/{{ID}}/0");
		
		$data['addfuture_Link']    = base_url($this->controller."/addfuture/{{ID}}/0");
		$data['removefuture_Link']    = base_url($this->controller."/removefuture/{{ID}}/0");
		
		$data['showall_link']     	= base_url($this->controller."/index/0/1");
		$data['total_rows']					= $config['total_rows'];

		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
		$elements['menu'] = 'menu/index';
		$elements['topmenu'] = 'menu/topmenu';
		$elements['main'] = 'member/index';

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
			$rs = $this->ModelMember->getSingle($contentId);
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
		$elements['main'] = 'member/add_edit';
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
		$data['first_name'] 		= $this->input->post('first_name');
		$data['last_name'] 			= $this->input->post('last_name');
		$data['email'] 					= $this->input->post('email');
		$data['password'] 			= $this->input->post('password')==''?"":md5($this->input->post('password'));
		$data['password_text'] 	= $this->input->post('password')==''?"":$this->input->post('password');
		$data['phone_no'] 			= $this->input->post('phone_no');
		$old_pic								=	$this->input->post('old_pic');
		$data['member_type'] 		= 1;
		if($contentId==0){
			$data['created'] 				= date('Y-m-d H:i:s');
		}else{
			$data['modified'] 			= date('Y-m-d H:i:s');
		}

		$profile_pic = $_FILES['picture']['name'];
		if($profile_pic !=''){
			$new_profile_pic = time().$profile_pic;
			$config['upload_path'] 	 = file_upload_absolute_path().'profile_pic/';
			$config['allowed_types'] = '*';
			//$config['max_size']      = 20480;
			//$config['max_width']     = 300;
			//$config['max_height']    = 200;
			$config['file_name']     = $new_profile_pic;
			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if (!$this->upload->do_upload('picture')) {
			  $error = array('error' => $message);
			  $this->nsession->set_userdata('errmsg', 'Upload valid profile image.');
			  redirect(base_url($this->controller));
			}else {
			  $upload_data = array('upload_data' => $this->upload->data());
			}
			if($upload_data['upload_data']['file_name']) {
			  if($oauth_uid==''){
			    $data['picture'] = $upload_data['upload_data']['file_name'];
			  }else{
			    $data['picture'] = file_upload_base_url().'profile_pic/'.$upload_data['upload_data']['file_name'];
			  }
			}else{
			  $data['picture'] = "";
			}
		}else{
			$data['picture'] = $old_pic;
		}
	if($contentId==0){
		$this->ModelMember->addContent($data);
		$this->nsession->set_userdata('succmsg','member/Managers added successfully.');
		redirect(base_url($this->controller));
	}else{
		$this->ModelMember->editContent($data,$contentId);
		$this->nsession->set_userdata('succmsg','member/Managers updated successfully.');
		redirect(base_url($this->controller));
	}
	}

	function activate()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelMember->activate($id);
		 $result = $this->ModelMember->getsingle_empdata($id);
		 $email = $result->email;
		 $first_name = $result->name;

		 $to = $email;
		 $subject='MMR Account Activated';
		 $body='<tr><td>Hi,</td></tr>
		 		<tr><td>Name : '.$first_name.'</td></tr>
		 		<tr style="background:#fff;"><td>Your account has been activated successfully.</td></tr>';
		$return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully member Activated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	
	function addfuture()
	{
		
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelMember->add($id);
		 $result = $this->ModelMember->getsingle_empdata($id);
		 $email = $result->email;
		 $first_name = $result->name;

		 $to = $email;
		 $subject='MMR Account Activated';
		 $body='<tr><td>Hi,</td></tr>
		 		<tr><td>Name : '.$first_name.'</td></tr>
		 		<tr style="background:#fff;"><td>You are feture member successfully.</td></tr>';
		$return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully member future.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	
	
	function removefuture()
	{
		
		//echo "hi"; die;
		
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelMember->remove($id);
		 $result 		= $this->ModelMember->getsingle_empdata($id);
		 $email 			= $result->email;
		 $first_name = $result->name;

		 $to 				= $email;
		 $subject		='MMR Account deactivated';
		 $body='<tr><td>Hi,</td></tr>
		 		<tr><td>Name : '.$first_name.'</td></tr>
		 		<tr style="background:#fff;"><td>Your account has been deactivated.</td></tr>';
		 $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully member remove future.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	
	function inactive()
	{
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelMember->inactive($id);
		 $result 		= $this->ModelMember->getsingle_empdata($id);
		 $email 			= $result->email;
		 $first_name = $result->name;

		 $to 				= $email;
		 $subject		='MMR Account deactivated';
		 $body='<tr><td>Hi,</td></tr>
		 		<tr><td>Name : '.$first_name.'</td></tr>
		 		<tr style="background:#fff;"><td>Your account has been deactivated.</td></tr>';
		 $return_check = $this->functions->mail_template($to,$subject,$body);
		$this->nsession->set_userdata('succmsg', 'Successfully member Inactivated.');
		redirect(base_url($this->controller."/index/"));
		return true;
	}
	
	
	
	function viewdetails($id=''){
		if($id!=''){
			$data = $this->ModelMember->getMyProfileData($id);
			//pr($rs);
			//$row = $rs->fields;
			//pr($data);
			$data['succmsg'] = $this->nsession->userdata('succmsg');
			$data['errmsg'] = $this->nsession->userdata('errmsg');
			$this->nsession->set_userdata('succmsg', "");
			$this->nsession->set_userdata('errmsg', "");
			$elements = array();
			$elements['menu'] = 'menu/index';
			$elements['topmenu'] = 'menu/topmenu';
			$elements['main'] = 'member/view_details';
			$element_data['menu'] = $data;//array();
			$element_data['main'] = $data;
			$this->layout->setLayout('layout_main_view');
			$this->layout->multiple_view($elements,$element_data);
		}else{
			$this->nsession->set_userdata('errmsg', 'You have requested for invalid page');
			redirect(base_url($this->controller."/index/"));
		}

	}
	function emptymyphoto(){
		$response=array();
        $response['msg']="Invalid Request";
        $response['status']=1;
        if($this->input->post('id')){
            $id=$this->input->post('id');
            $tblname="member";
            $picData=$this->ModelMember->getSingleData('member',array('id'=>$id));
            $explodepic=explode("/uploads", $picData['picture']);
            $result=$this->ModelMember->updateData($tblname,array('picture'=>''),array('id'=>$id));
            if($result > 0){
                if(isset($explodepic[1])){
                    $imgpath=file_upload_absolute_path().$explodepic[1];
                    if(is_file($imgpath)){
                       unlink($imgpath);
                    }
                }
                $this->nsession->set_userdata('succmsg','Deleted Successfully');
                $response = array('status' => 1, 'msg' => 'Deleted Successfully');
                $to 			= $picData['email'];
				$subject		= ($this->input->post('subject'))?$this->input->post('subject'):"Profile Pic Deleted";
				$body			= "<tr><td>Hi ".$picData['name']."</td></tr>
									<tr><td> Your profile picture deleted</td></tr>";
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
            }else{
            	$this->nsession->set_userdata('errmsg','unable to delete, please try after some time');
                $response = array('status' => 0, 'message' => 'unable to delete, please try after some time');
            }
        }
        echo json_encode($response);
	}
	function delphoto(){
        $response=array();
        $response['msg']="Invalid Request";
        $response['status']=1;
        if($this->input->post('id') && $this->input->post('type')){
            $id=$this->input->post('id');
            $type=$this->input->post('type');
            if($type=="photo"){
                $tblname="member_photo";
                $picData=$this->ModelMember->getSingleData('member_photo',array('id'=>$id));
                $explodepic=explode("/uploads", $picData['photo']);
            }else{
                $tblname="member_video";
                $picData=$this->ModelMember->getSingleData('member_video',array('id'=>$id));
                $explodepic=explode("/uploads", $picData['video']);
            }
            $result=$this->ModelMember->delData($tblname,array('id'=>$id));
            if($result > 0){
                if(isset($explodepic[1])){
                    $imgpath=file_upload_absolute_path().$explodepic[1];
                    if(is_file($imgpath)){
                       unlink($imgpath);
                    }
                }
                $this->nsession->set_userdata('succmsg','Deleted Successfully');
                $response = array('status' => 1, 'msg' => 'Deleted Successfully');
                $picData=$this->ModelMember->getSingleData('member',array('id'=>$this->input->post('member_id')));
                $response = array('status' => 1, 'msg' => 'Deleted Successfully');
                $to 			= $picData['email'];
				$subject		= ($this->input->post('subject'))?$this->input->post('subject'):"Profile Pic Deleted";
				$body			= "<tr><td>Hi ".$picData['name']."</td></tr>
									<tr><td> Your profile picture deleted</td></tr>";
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
            }else{
            	$this->nsession->set_userdata('errmsg','unable to delete, please try after some time');
                $response = array('status' => 0, 'message' => 'unable to delete, please try after some time');
            }
        }
        echo json_encode($response);
    }
	function gallery($id=''){
		if($id!=''){
			$data = $this->ModelMember->getMyProfileData($id);
			//pr($rs);
			//$row = $rs->fields;
			//pr($data);
			$data['succmsg'] = $this->nsession->userdata('succmsg');
			$data['errmsg'] = $this->nsession->userdata('errmsg');
			$this->nsession->set_userdata('succmsg', "");
			$this->nsession->set_userdata('errmsg', "");
			$elements = array();
			$data['member_id']=$id;
			$elements['menu'] = 'menu/index';
			$elements['topmenu'] = 'menu/topmenu';
			$elements['main'] = 'member/gallery';
			$element_data['menu'] = $data;//array();
			$element_data['main'] = $data;
			$this->layout->setLayout('layout_main_view');
			$this->layout->multiple_view($elements,$element_data);
		}else{
			$this->nsession->set_userdata('errmsg', 'You have requested for invalid page');
			redirect(base_url($this->controller."/index/"));
		}

	}
	public function emailExist(){
		$email_id = $this->input->post('email');
		$return = $this->ModelMember->checkEmail($email_id);
		if(count($return)!=''){
			$error = 1;
		}else{
			$error = 0;
		}
		echo json_encode(array('error'=>$error));
	}
	public function emailExistForCouncellor(){
		$email_id = $this->input->post('email');
		$id = $this->input->post('counsilor_id');
		if($id =='')
		{
			$return = $this->ModelMember->checkEmail($email_id);
			if(count($return)!=''){
				$error = "false";
			}else{
				$error = "true";
			}
			echo $error;
		}
		else{
			echo "true";
		}
	}
	public function usernameExist(){
		$username = $this->input->post('username');
		$return = $this->ModelMember->checkUsername($username);
		if(count($return)>0){
			$error = 1;
		}else{
			$error = 0;
		}
		echo json_encode(array('error'=>$error));
	}
	public function do_delete(){
		$this->functions->checkAdmin($this->controller.'/');
		$id = $this->uri->segment(3, 0);
		$this->ModelMember->doDeleteMemeber($id);
		$result 		= $this->ModelMember->getsingle_empdata($id);
		$email 			= $result->email;
		$first_name = $result->name;

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
	
	function send_url($member_id){
		if($member_id){
			
				$member_details = $this->ModelMember->get_member_details($member_id);
			
				$created			    = date('Y-m-d H:i:s');
				
				$data['expire_date']			= date('Y-m-d H:i:s', strtotime($created. ' + 1 days'));
				
				$this->ModelMember->update_url($member_id,$data);
				
			    $step2Link      = front_base_url().'member/step2/'.base64_encode($member_id);
				
				
				$to 			= $member_details[0]['email'];
				$subject		= "Registration";
				$body			= "<tr><td>Hi,</td></tr>
									<tr><td>Thanks for opening an account on our platform.Please click on link to complete your profile <a href='".$step2Link."'>Click here</a> </td></tr>";
				$this->functions->mail_template($to,$subject,$body);
                $this->nsession->set_userdata('succmsg','Successfully send varified Url.');
                redirect(base_url($this->controller."/index/"));
			}else{
                $this->nsession->set_userdata('errmsg','Some server problem occur.Please try again');
                redirect(base_url($this->controller."/index/"));
			}
	}
	
	function delete($member_id)
	{
		$this->ModelMember->DeleteMemeber($member_id);
		 $this->nsession->set_userdata('succmsg','Member successfully deleted');
         redirect(base_url($this->controller."/index/"));
	}

}
?>
