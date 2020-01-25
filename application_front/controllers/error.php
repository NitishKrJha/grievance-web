<?php
class Error extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{	
		$data = '';
		$elements = array(); 
		$elements['header'] = 'layout/header';  
		$element_data['header'] = $data;
		$elements['main'] = 'errors/error_404';  
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';  
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_home'); 
		$this->layout->multiple_view($elements,$element_data);
	}
}
?>