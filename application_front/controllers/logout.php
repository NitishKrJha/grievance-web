<?php
class Logout extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('Facebook.php');
		$this->controller = 'logout';
	}

	function index()
	{
		//set online status
		$update_status['online_status']=0;
		$this->db->where('id',$this->nsession->userdata('member_session_id'))->update('member',$update_status);
		$this->facebook->destroy_session();	
		$this->nsession->destroy();
		delete_cookie('mmr_user_id');
		redirect(base_url());
	}
	

}

?>