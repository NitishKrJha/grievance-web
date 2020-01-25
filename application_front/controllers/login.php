<?php
class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('Facebook.php');
		$this->load->model('ModelLogin');
		$this->controller = 'login';

	}

	function index()
	{
	    $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['main'] = 'login/index';
        $element_data['main'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
	}
	function do_login()
	{
		//echo"<pre>";print_r($_POST);exit;
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE)
		{
			// /echo '<pre>';print_r($_SERVER);exit;
			$data['email'] 			= $this->input->request('email','');
			$data['password'] 		= $this->input->request('password','');
			$data['member_type'] 	= $this->input->request('member_type','');
			$data['remember_me'] 	= $this->input->request('remember_me','');
			$cresult=$this->ModelLogin->authenticateUser($data);
			if($cresult==1)
			{
				
				$membertype = $this->nsession->userdata('member_session_membertype');
				
					if($membertype==1){
						$login_redirect = base_url("member/dashboard");
					}elseif($membertype==2){
						$login_redirect = base_url("counselor/dashboard");
					}
					$this->nsession->set_userdata('succmsg','You have logged in successfully...');
					redirect($login_redirect);
				}
			else if($cresult==2){
				redirect(base_url("page/suspended"));
			}	
			else
			{
				$this->nsession->set_userdata('errmsg','Invalid email ID or Password.');
					redirect(base_url('login'));
			}
	}
	}
    function forgotPassword()
    {
        $data['controller'] = $this->controller;

        $data['succmsg'] = "";
        $data['errmsg'] = "";

        $data['succmsg1']=$this->nsession->userdata('succmsg');
        $data['errmsg1'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['main'] = 'login/forgotPassword';
        $element_data['main'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }
	function do_forgetpwd(){
		$lang = $this->input->request('lang');
		if($this->input->post('email')){
			$email=$this->input->post('email');
			$check_email = $this->ModelLogin->checkEmail($email);
			//pr($check_email);
			if(count($check_email) <= 0){
				if($this->input->post('appcall')==1){
					$successMsg = $lang=='en'?"Please check your email Id":"請檢查您的電子郵件ID";
					$appdata=array('error'=>1,'message'=>$successMsg,'data'=>"");
					echo json_encode($appdata);
				}else{
					echo 'email_issue';
				}

			}else if($check_email[0]['oauth_provider']!=''){

				if($this->input->post('appcall')==1){
					$successMsg = $lang=='en'?"You have done social login.":"你做過社交登錄";
					$appdata=array('error'=>1,'message'=>$successMsg,'data'=>"");
					echo json_encode($appdata);
					return true;
				}else{
					echo 'social_login';
				}


			}else{
				$insertoken=$this->ModelLogin->inserttokenforpassword($email);
				$link=base_url()."login/password?email=".$email."&token=".base64_encode($insertoken);
				$to = $email;
				$subject="Forgot Password";
				$body1="<tr><td>Hi,</td></tr>
						<tr><td>Please click below link to create a new password.</td></tr>
						<tr><td><a href='".$link."'>Click here</a></td></tr>";
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
				$return_check = $this->functions->mail_template($to,$subject,$body);
				if($return_check){
					if($this->input->post('appcall')==1){
						$successMsg = $lang=='en'?"Please check your mail ID to reset your password.":"請檢查您的郵件ID以重置您的密碼";
						$appdata=array('error'=>0,'message'=>$successMsg,'data'=>"");
						echo json_encode($appdata);
						return true;
					}else{
						echo 'true';
					}
				}else{
					if($this->input->post('appcall')==1){
						$successMsg = $lang=='en'?"Some Mail problem occurred.Please try again.":"發生一些郵件問題。請再試一次";
						$appdata=array('error'=>0,'message'=>$successMsg,'data'=>"");
						echo json_encode($appdata);
						return true;
					}else{
						echo 'false';
					}
				}

			}
		}else{
			echo 'false';
		}
	}
	function password(){
		$data = '';
		if($this->input->get('token') && $this->input->get('email')){
        	$token=base64_decode($this->input->get('token'));
			$email=$this->input->get('email');
			$data['email']=$email;
			$data['ptoken']=$token;
			$checktoken=$this->ModelLogin->checktoken($token,$email);
			if($checktoken!=false){
				$data['token']='valid';
			}else{
				$this->nsession->set_userdata('errmsg','Try Again! Invalid details');
				redirect(base_url());
				return true;
			}
		}else{
			$data['token']='invalid';
			$this->nsession->set_userdata('errmsg','Try Again! Invalid details');
			redirect(base_url());
		}
		$data['controller'] = $this->controller;

		$data['succmsg'] = $this->nsession->userdata('succmsg');
		$data['errmsg'] = $this->nsession->userdata('errmsg');

		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$elements = array();
        $elements['main'] = 'login/password';
        $element_data['main'] = $data;
		$this->layout->setLayout('layout_home');
		$this->layout->multiple_view($elements,$element_data);
	}
	function password_change(){
		if($this->input->post('email') && $this->input->post('password') && $this->input->post('token')){
		$token=$this->input->post('token');
		$email=$this->input->post('email');
		$checktoken=$this->ModelLogin->checktoken($token,$email);
		if($checktoken!=false){
			$password=md5($this->input->post('password'));
			$result=$this->ModelLogin->change_password($password,$email);
			if($result!=false){
				$this->nsession->set_userdata('succmsg', 'Password has been changed');
				redirect(base_url());
			}else{
				$this->nsession->set_userdata('errmsg', 'Unable to change, Please try once again');
				redirect(base_url());
			}
		}else{
			$this->nsession->set_userdata('errmsg', 'Your token has been expired');
			redirect(base_url());
		}
		}else{
			$this->nsession->set_userdata('errmsg', 'Unable to change, Please try once again');
			redirect(base_url());
		}
	}
}
?>
