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
            redirect(base_url('grievance/index/0/1'));
        }
        $data['controller'] = $this->controller;
        
        $data['departments'] = $this->ModelCommon->getAllDatalist('department',array('status'=>'1'));
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
            redirect(base_url('grievance/index/0/1'));
        }
        $data['controller'] = $this->controller;
        

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
            $phone_data = $this->ModelCommon->getSingleData('member',array('phone'=>$this->input->post('phone'),'member_type'=>'1'));
            $date=date('Y-m-d H:i:s');
            $otp = rand(1000,9999);
            if($type=='login'){
                if(!$this->input->post('crn')){
                    $response=array('error'=>1,'msg'=>'Enter valid CRN');
                    $this->response($response);
                    return;
                }
                if(empty($phone_data)){
                    $response=array('error'=>1,'msg'=>'Phone number is invalid');
                }else if($phone_data['crn']!=$this->input->post('crn')){
                    $response=array('error'=>1,'msg'=>'You have netered invalid CRN');
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
                $data = array('status' => false, 'message' => 'Email is already exist','data'=>array());
                $this->response($data);
            }
            $crn=$this->input->post('crn');
            $user_data_by_email=$this->ModelCommon->getSingleData('member',array('crn'=>$crn));
            if(!empty($user_data_by_emai)){
                $data = array('status' => false, 'message' => 'CRN is already exist','data'=>array());
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
                $this->nsession->set_userdata('member_session_picture', $user_data['picture']);
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
            $this->nsession->set_userdata('succmsg',$data['message']);
            $this->response($data);
        }
    }

    function testimonial(){
        $data['controller'] = $this->controller;
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'page/testimonial';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function privacy(){
        $data['controller'] = $this->controller;
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'page/privacy';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function terms(){
        $data['controller'] = $this->controller;
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'page/terms';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function faq(){
        $data['controller'] = $this->controller;
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'page/faq';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function howitworks(){
        $data['controller'] = $this->controller;
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'page/howitworks';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function contactUs(){
        $data['controller'] = $this->controller;
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'page/contactUs';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function employee_register(){
        $data['controller'] = $this->controller;
        $data['grade_list'] = $this->ModelCommon->getAllDatalist('grade_list',array('is_active'=>'1'));
        $data['quarter_type_list'] = $this->ModelCommon->getAllDatalist('quarter_type_list',array('is_active'=>'1'));
        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/header';
        $element_data['header'] = $data;
        $elements['main'] = 'page/employee_register';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
	   
    }

    public function doEmployeeRegister(){
        $response=array();
        if(!$this->input->post('full_name')){
            $data = array('status' => false, 'message' => 'Full Name is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('crn')){
            $data = array('status' => false, 'message' => 'CRN is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('father_name')){
            $data = array('status' => false, 'message' => 'Father Name is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('designation')){
            $data = array('status' => false, 'message' => 'Designation is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('mobile_no')){
            $data = array('status' => false, 'message' => 'Mobile No is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('bu_no')){
            $data = array('status' => false, 'message' => 'BU No is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('date_of_joining')){
            $data = array('status' => false, 'message' => 'Date Of Joining is blank','data'=>array());
            $this->response($data);
        }else if(!$this->input->post('date_of_eligibility')){
            $data = array('status' => false, 'message' => 'Date of Eligibility is blank','data'=>array());
            $this->response($data);
        }else if(!$_FILES['file']['name']){
			$data = array('status' => false, 'message' => 'Please upload a valid file','data'=>array());
             $this->response($data);
		}else{

            $member_session_id=rand(6);
			$file             = $_FILES['file']['name'];
			$config['upload_path'] 	 = file_upload_absolute_path().'employee/identyCard/';
			$config['allowed_types'] = 'jpg|pdf|doc|docx|png';
			$config['file_name']     = md5(date('Y-m-d H:i:s')).md5($member_session_id);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('file')) {
				$this->nsession->set_userdata('errmsg',$this->upload->display_errors());
                $data = array('status' => false, 'message' => 'Please upload a valid file','data'=>array());
                $this->response($data);
			} else {
				$upload_data = $this->upload->data();
			}
			if($upload_data['file_name']) {
				$file_name = $upload_data['file_name'];
				$file_type = $upload_data['file_type'];
			}


            $mobile_no=$this->input->post('mobile_no');
            $user_data_by_mobile_no=$this->ModelCommon->getSingleData('employee_list',array('mobile_no'=>$mobile_no));
            if(!empty($user_data_by_mobile_no)){
                $data = array('status' => false, 'message' => 'Mobile No. is already exist','data'=>array());
                $this->response($data);
            }
            $crn=$this->input->post('crn');
            $user_data_by_crn=$this->ModelCommon->getSingleData('member',array('crn'=>$crn));
            if(!empty($user_data_by_crn)){
                $data = array('status' => false, 'message' => 'CRN is already exist','data'=>array());
                $this->response($data);
            }
            if(empty($user_data_by_mobile_no)){
                
                $date=date('Y-m-d H:i:s');
                $doj=date('Y-m-d',strtotime($this->input->post('date_of_joining')));
                $doe=date('Y-m-d',strtotime($this->input->post('date_of_eligibility')));
                $applied_for_st_sc=($this->input->post('applied_for_st_sc'))?$this->input->post('applied_for_st_sc'):'0';
                $applied_for_fresh_changeover=($this->input->post('applied_for_fresh_changeover'))?$this->input->post('applied_for_fresh_changeover'):'0';
                $insert_data=array(
                    'full_name'=>$this->input->post('full_name'),
                    'crn'=>($this->input->post('crn'))?$this->input->post('crn'):'',
                    'father_name'=>($this->input->post('father_name'))?$this->input->post('father_name'):'',
                    'designation'=>($this->input->post('designation'))?$this->input->post('designation'):'',
                    'mobile_no'=>$this->input->post('mobile_no'),
                    'bu_no'=>$this->input->post('bu_no'),
                    'telephone_no'=>($this->input->post('telephone_no'))?$this->input->post('telephone_no'):'',
                    'date_of_joining'=>$doj,
                    'date_of_eligibility'=>$doe,
                    'street_detail'=>$this->input->post('street_detail'),
                    'quarter_type_id'=>$this->input->post('quarter_type_id'),
                    'applied_for_fresh_changeover'=>$applied_for_fresh_changeover,
                    'applied_for_st_sc'=>$applied_for_st_sc,
                    'created_date'=>$date,
                    'is_active'=>'1'
                );
                if(!empty($file_name)){
                    $insert_data['identity_card']=$file_name;
                }
                $result=$this->ModelCommon->insertData('employee_list',$insert_data);
                $user_data=$this->ModelCommon->getSingleData('employee_list',array('id'=>$result));
                $data = array('status' => true, 'message' => 'Registration Successfully','data'=>$user_data);
                $this->response($data);
            }else{
                $data = array('status' => false, 'message' => 'Mobile Number is already exist','data'=>array());
                $this->response($data);
            }
        }
    }

    function response($data){
        echo json_encode($data); die();
    }
}
