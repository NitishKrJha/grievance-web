<?php
class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'user';
        $this->load->model('ModelPage');
        $this->load->model('ModelCommon');
	}
	
	public function index()
	{
        // echo $this->nsession->userdata('member_session_id');exit;
		$data['controller'] = $this->controller;
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");
       
        $elements = array();
		$elements['header'] = 'layout/header';
		$element_data['header'] = $data;
		$elements['main'] = 'page/index';  
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';  
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_home'); 
		$this->layout->multiple_view($elements,$element_data);
    }

    function myproifle(){
        if(!$this->nsession->userdata('member_login') && !$this->nsession->userdata('member_login')==1){
            redirect(base_url('login'));
        }
        $data['controller'] = $this->controller;
        // Send captcha image to view
        $data['captchaImg'] = $captcha['image'];

        /* Captcha End */

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'user/myprofile';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function editproifle(){
        if(!$this->nsession->userdata('member_login') && !$this->nsession->userdata('member_login')==1){
            redirect(base_url('login'));
        }
        $data['controller'] = $this->controller;
        // Send captcha image to view
        $data['captchaImg'] = $captcha['image'];

        /* Captcha End */

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'user/editProfile';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

}
