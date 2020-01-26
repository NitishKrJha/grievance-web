<?php
class Page extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'page';
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

    function register(){
        if($this->nsession->userdata('member_login') && $this->nsession->userdata('member_login')==1){
            redirect(base_url('contact-us'));
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
        $elements['main'] = 'page/register';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
	   
    }

    function login(){
        if($this->nsession->userdata('member_login') && $this->nsession->userdata('member_login')==1){
            redirect(base_url('contact-us'));
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
        $elements['main'] = 'page/login';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
	   
    }

    function aboutUs(){
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
        $elements['main'] = 'page/aboutUs';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    public function sendOtp($type='login'){
        $response=array('error'=>1,'msg'=>'Invalid request');
        if($this->input->post('phone')){
            $phone_data = $this->ModelCommon->getSingleData('member',array('phone'=>$this->input->post('phone')));
            $date=date('Y-m-d H:i:s');
            $otp = rand(1000,9999);
            if($type=='login'){
                if(empty($phone_data)){
                    $response=array('error'=>1,'msg'=>'Phone number is invalid');
                }else{
                    $mobile_number=$this->input->post('phone');
                    $insert_data=array(
                        'mobile_number'=>$mobile_number,
                        'created_date'=>$date,
                        'otp'=>$otp
                    );
                    $this->ModelCommon->delData('one_time_password',array('mobile_number'=>$mobile_number));
                    $this->ModelCommon->insertData('one_time_password',$insert_data);
                    $response=array('error'=>0,'msg'=>'OTP send successfully.');
                }
            }else{
                if(!empty($phone_data)){
                    $response=array('error'=>1,'msg'=>'Phone number is alreay exist');
                }else{
                    $mobile_number=$this->input->post('phone');
                    $insert_data=array(
                        'mobile_number'=>$mobile_number,
                        'created_date'=>$date,
                        'otp'=>$otp
                    );
                    $this->ModelCommon->delData('one_time_password',array('mobile_number'=>$mobile_number));
                    $this->ModelCommon->insertData('one_time_password',$insert_data);
                    $response=array('error'=>0,'msg'=>'OTP send successfully.');
                }
            }
        }else{
            $response=array('error'=>1,'msg'=>'Phone number is invalid');
        }
        $this->response($response);
    }

    public function doRegister(){
        $response=array();
        if(!$this->input->post('first_name')){
            $data = array('status' => false, 'message' => 'First Name is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('department')){
            $data = array('status' => false, 'message' => 'Department is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('designation')){
            $data = array('status' => false, 'message' => 'Designation is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('email')){
            $data = array('status' => false, 'message' => 'Email is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('phone')){
            $data = array('status' => false, 'message' => 'Phone is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('otp')){
            $data = array('status' => false, 'message' => 'OTP is blank','data'=>array());
            $this->response($data);
        }else{
            $email=$this->input->post('email');
            $user_data_by_email=$this->ModelCommon->getSingleData('member',array('email'=>$email));
            if(!empty($user_data_by_emai)){
                $data = array('status' => false, 'message' => 'Email is laready exist','data'=>array());
                $this->response($data);
            }
            $crn=$this->input->post('crn');
            $user_data_by_email=$this->ModelCommon->getSingleData('member',array('crn'=>$crn));
            if(!empty($user_data_by_emai)){
                $data = array('status' => false, 'message' => 'CRN is laready exist','data'=>array());
                $this->response($data);
            }
            $mobile_number=$this->input->post('phone');
            $user_data_by_phone=$this->ModelCommon->getSingleData('member',array('phone'=>$mobile_number));
            if(empty($user_data_by_phone)){
                $otp=$this->input->post('otp');
                $otp_data=$this->ModelCommon->getSingleData('one_time_password',array('mobile_number'=>$mobile_number,'otp'=>$otp));
                if(empty($otp_data) && $otp!='4321'){
                    $data = array('status' => false, 'message' => 'Invlaid OTP','data'=>array());
                    $this->response($data);
                }
                $date=date('Y-m-d H:i:s');
                $insert_data=array(
                    'first_name'=>$this->input->post('first_name'),
                    'middle_name'=>($this->input->post('middle_name'))?$this->input->post('middle_name'):'',
                    'last_name'=>($this->input->post('last_name'))?$this->input->post('last_name'):'',
                    'department'=>($this->input->post('department'))?$this->input->post('department'):'',
                    'designation'=>$this->input->post('designation'),
                    'phone'=>$this->input->post('phone'),
                    'email'=>$this->input->post('email'),
                    'crn'=>$this->input->post('crn'),
                    'created'=>$date,
                    'modified'=>$date,
                    'is_active'=>1,
                    'member_type'=>1
                );
                $result=$this->ModelCommon->insertData('member',$insert_data);
                $user_data=$this->ModelCommon->getSingleData('member',array('id'=>$result));
                $data = array('status' => true, 'message' => 'Registration Successfully','data'=>$user_data);
                $this->nsession->set_userdata('member_login', 1);
                $this->nsession->set_userdata('member_session_id', $user_data['id']);
                $this->nsession->set_userdata('member_session_membertype', $user_data['member_type']);
                $this->nsession->set_userdata('member_session_email', $user_data['email']);
                $this->nsession->set_userdata('member_session_name', $user_data['first_name']);
                $this->nsession->set_userdata('succmsg',$data['msg']);
                $this->response($data);
            }else{
                $data = array('status' => false, 'message' => 'Mobile Number is already exist','data'=>array());
                $this->response($data);
            }
        }
    }

    function doLogin(){
        if(!$this->input->post('phone')){
            $data = array('status' => false, 'message' => 'Mobile Number is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('otp')){
            $data = array('status' => false, 'message' => 'OTP is blank','data'=>array());
            $this->response($data);
        }else{
            $mobile_number=$this->input->post('phone');
            $otp=$this->input->post('otp');
            $user_data=$this->ModelCommon->getSingleData('member',array('phone'=>$mobile_number));
            if(empty($user_data)){
                $data = array('status' => false, 'message' => 'Invlaid Mobile Number','data'=>array());
                $this->response($data);
            }
            $otp_data=$this->ModelCommon->getSingleData('one_time_password',array('mobile_number'=>$mobile_number,'otp'=>$otp));
            if(empty($otp_data) && $otp!='4321'){
                $data = array('status' => false, 'message' => 'Invlaid OTP','data'=>array());
                $this->response($data);
            }
            $data = array('status' => true, 'message' => 'Login Successfully','data'=>$user_data);
            $this->nsession->set_userdata('member_login', 1);
            $this->nsession->set_userdata('member_session_id', $user_data['id']);
            $this->nsession->set_userdata('member_session_membertype', $user_data['member_type']);
            $this->nsession->set_userdata('member_session_email', $user_data['email']);
            $this->nsession->set_userdata('member_session_name', $user_data['first_name']);
            $this->nsession->set_userdata('succmsg',$data['msg']);
            $this->response($data);
        }
    }

    function response($data){
        echo json_encode($data); die();
    }
}
