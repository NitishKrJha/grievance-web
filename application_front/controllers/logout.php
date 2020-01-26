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
		$this->nsession->destroy();
		redirect(base_url());
	}
	

}

?>