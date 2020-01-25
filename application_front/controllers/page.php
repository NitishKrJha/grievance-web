<?php
class Page extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'page';
		$this->load->model('ModelPage');
        $this->load->model('ModelCounselor');
	}
	
	public function index()
	{
        // echo $this->nsession->userdata('member_session_id');exit;
		$data['controller'] = $this->controller;
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		$data['cmsContent'] = $this->functions->getCMSContent('homePage');
		$data['testimonial'] = $this->ModelPage->getTestimonial();
		$data['futuremember'] = $this->ModelPage->getfuturemember();
		$data['cmsContentt'] = $this->functions->getCMSContent('homecontent');
		//pr($data['futuremember']);

        /* Captach Start */
        // Captcha configuration
        $config = array(
            'img_path' => './captcha/',
            'img_url' => base_url() . 'captcha/',
            'font_path' => base_url() . 'system/fonts/texb.ttf',
            'img_width' => 150,
            'img_height' => 40
        );
        $captcha = create_captcha($config);

        // Unset previous captcha and store new captcha word
        $this->nsession->unset_userdata('captchaCode');
        $this->nsession->set_userdata('captchaCode', $captcha['word']);
        // Send captcha image to view
        $data['captchaImg'] = $captcha['image'];

        /* Captcha End */
        $elements = array();
		$elements['header'] = 'layout/headerMain';
		$element_data['header'] = $data;
		$elements['main'] = 'page/index';  
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';  
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_home'); 
		$this->layout->multiple_view($elements,$element_data);
    }

    function sendMessage(){
        $this->load->model('ModelCommon');
        if($this->nsession->userdata('member_session_id')){
            $member_id=$this->nsession->userdata('member_session_id');
            $ndata=array();
            $ndata['member_id']=$member_id;
            $ndata['to_member_id']=$this->input->post('to_member');
            $ndata['subject']='';
            $ndata['message']=$this->input->post('message');
            $ndata['created_date']=date('Y-m-d H:i:s');
            $ndata['modified_date']=date('Y-m-d H:i:s');
            $ndata['status']=0;
            $this->ModelCommon->insertData('member_message',$ndata);

            // $from_email=$this->db->select('email,name')->get_where('member',array('id'=>$member_id))->row_array();

            // $to_email=$this->db->select('email,name')->get_where('member',array('id'=>$ndata['to_member_id']))->row_array();

            // $to                 = $to_email['email'];
            // $subject            =$ndata['subject'];
            // $body1='<tr><td>Hi '.$to_email['name'].',</td></tr>
            //         <tr style="background:#fff;"><td>'.$ndata['message'].'</td></tr>';
            // $body='<td width="531" align="left"><table width="531" cellspacing="0" cellpadding="0" border="0" bgcolor="#083e62" align="center" style="margin: 0 auto; width: 531px;">
            //       <tbody style="color: #fff;">
            //         <tr>
            //           <td colspan="3" width="600" height="10" align="left" />
            //         </tr>
            //         <tr style="text-align:center;">
            //           <td width="13" align="left"/>
            //           <td width="13" align="left"/>
            //         </tr>
            //         '.$body1.'
            //       </tbody>
            //     </table></td>';        
            // $this->functions->mail_template($to,$subject,$body,$from_email['email']);
            $this->nsession->set_userdata('succmsg','Message Send Successfully');
            echo 'true';
        }else{
            $this->nsession->set_userdata('errmsg','You does not have access this facility');
            echo 'false';
        }
    }

    function getMessageData(){
        $this->load->model('ModelCommon');
        $response=array('error'=>1,'msg'=>'No Data Found','data'=>array());
        if($this->nsession->userdata('member_session_id') && $this->input->post('to_member_id')){
            $member_id=$this->nsession->userdata('member_session_id');
            $to_member_id=$this->input->post('to_member_id');
            $data=$this->ModelCommon->getAllMessagelist($member_id,$to_member_id);
            $this->db->update('member_message',array('status'=>1),array('to_member_id'=>$member_id,'member_id'=>$to_member_id));
            //echo $this->db->last_query();
            if(count($data) > 0){
                $response['error']=0;
                $response['data']=$data;
                $response['msg']='Data Available';
            }
        }
        echo json_encode($response);
    }

    function setFlag(){
        $this->load->model('ModelCommon');
        $response=array();
        $response['status']=0;
        $response['msg']="Invalid Request";
        if(!$this->input->post('user_id')){
            $response['msg']='user_id is missing';
        }else if(!$this->input->post('message')){
            $response['msg']='message is missing';
        }else{
            $ndata=array();
            $ndata['member_id']=$this->input->post('user_id');
            $ndata['created_by']=$this->nsession->userdata('member_session_id');
            $ndata['message']=$this->input->post('message');
            $check=$this->ModelCommon->getSingleData('member_flag',array('member_id'=>$ndata['member_id'],'created_by'=>$ndata['created_by']));
            if(count($check) > 0){
                $this->ModelCommon->updateData('member_flag',$ndata,array('flag_id'=>$check['flag_id']));
            }else{
                $ndata['created_date']=date('Y-m-d H:i:s');
                $this->ModelCommon->insertData('member_flag',$ndata);
            }
            $response['status']=1;
            $response['msg']="We have send your message to admin successfully";
        }
        echo json_encode($response);
    }

    function replyMessage(){
        $this->load->model('ModelCommon');
        if($this->nsession->userdata('member_session_id')){
            $member_id=$this->nsession->userdata('member_session_id');
            $ndata=array();
            $to_member_id=$this->input->post('to_member');
            $id=$this->input->post('msg_id');
            $ndata['reply_message']=$this->input->post('reply_message');
            $ndata['modified_date']=date('Y-m-d H:i:s');
            $ndata['status']=1;
            $this->ModelCommon->updateData('member_message',$ndata,array('id'=>$id));

            $from_email=$this->db->select('email,name')->get_where('member',array('id'=>$member_id))->row_array();

            $to_email=$this->db->select('email,name')->get_where('member',array('id'=>$ndata['to_member_id']))->row_array();

            $to                 = $to_email['email'];
            $subject            =$ndata['subject'];
            $body1='<tr><td>Hi '.$to_email['name'].',</td></tr>
                    <tr style="background:#fff;"><td>'.$ndata['reply_message'].'</td></tr>';
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
            $this->functions->mail_template($to,$subject,$body,$from_email['email']);
            $this->nsession->set_userdata('succmsg','Message Send Successfully');
            echo 'true';
        }else{
            $this->nsession->set_userdata('errmsg','You does not have access this facility');
            echo 'false';
        }
    }

    function register(){

	   if($this->nsession->userdata('member_session_id')!='')
	   {
		   $profile_details = get_where('member',array('id'=>$this->nsession->userdata('member_session_id')));
		  
		   if($profile_details[0]['member_type'] == 1)
		   {
		    redirect(base_url('member/profile'));
		   }
		   else{
			   redirect(base_url('counselor/dashboard'));
		   }
	   }
	   else{
        $data['controller'] = $this->controller;

        /* Captach Start */
        // Captcha configuration
        $config = array(
            'img_path' => './captcha/',
            'img_url' => base_url() . 'captcha/',
            'font_path' => base_url() . 'system/fonts/texb.ttf',
            'img_width' => 150,
            'img_height' => 40
        );
        $captcha = create_captcha($config);

        // Unset previous captcha and store new captcha word
        $this->nsession->unset_userdata('captchaCode');
        $this->nsession->set_userdata('captchaCode', $captcha['word']);
        // Send captcha image to view
        $data['captchaImg'] = $captcha['image'];

        /* Captcha End */

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        $elements['main'] = 'page/register';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
	   }
    }

    function thanks($email=''){
       $data['email']=($email!='')?base64_decode($email):'';
       if($this->nsession->userdata('member_session_id')!='')
       {
           $profile_details = get_where('member',array('id'=>$this->nsession->userdata('member_session_id')));
          
           if($profile_details[0]['member_type'] == 1)
           {
            redirect(base_url('member/profile'));
           }
           else{
               redirect(base_url('counselor/dashboard'));
           }
       }
       else{
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        if($data['email']!=''){
            $elements['main'] = 'page/step_1_success';
        }else{
            $elements['main'] = 'page/thank_you_page';
        }
        
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
       }
    }

    function suspended($email=''){
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        $elements['main'] = 'member/suspended';
        
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function counselor($email){
        $email=base64_decode($email);
        $check=$this->ModelCounselor->checkEmail($email);
        if(count($check) <= 0){
            $this->nsession->set_userdata('errmsg','this email id is not available');
            redirect(base_url());
        }
        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');
        $data['email']=$email;
        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        $elements['main'] = 'page/counselor_register';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }

    function usernameExistForCouncellor(){
		$data = $_POST;
        $check=$this->ModelCounselor->checkUsername($data);
		//echo "<pre>";print_r($check); echo $this->db->last_query();
        if(count($check) > 0){
            echo "false";
        }else{
            echo "true";
        }
    }

    function complete_registration(){
        if($this->input->post('email')){
            $ndata=array();
            $ndata['email']=$this->input->post('email');
            $ndata['password']=md5($this->input->post('password'));
            $ndata['name']=$this->input->post('name');
            $ndata['username']=$this->input->post('username');
            $ndata['member_type']=2;
            $ndata['is_active']=1;
            $ndata['success_step']=1;
            $result=$this->ModelCounselor->memberRegupdate($ndata);
            if($result > 0){
                $to                 = $ndata['email'];
                $subject            ='MMR Counselor Registration';
                $body1='<tr><td>Hi '.$ndata['name'].',</td></tr>
                        <tr style="background:#fff;"><td>Thank you for completing registration </td></tr>
                        <tr><td>Now you can access to login by clicking on bellow anchor</td></tr>
                        <tr><td><a href="'.front_base_url().'page/counselor/'.base64_encode($to).'">Click Here</a></td></tr>';
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
                $this->functions->mail_template($to,$subject,$body);
                $this->nsession->set_userdata('succmsg','Registration Completed');
                redirect("login");
            }else{
               $this->nsession->set_userdata('errmsg','Unable to register please try once again');
                redirect(base_url()."page/counselor/".base64_encode($this->input->post('email'))); 
            }
        }else{
            $this->nsession->set_userdata('errmsg','You have requested for invalid page');
            redirect(base_url());
        }
    }

    function about(){

        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $data['cmsContent'] = $this->functions->getCMSContent('aboutUs');

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        $elements['main'] = 'page/about';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }
    function termsConditions(){

        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $data['cmsContent'] = $this->functions->getCMSContent('termsConditions');

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        $elements['main'] = 'page/termsConditions';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }
    function privacyPolicy(){

        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

       $data['cmsContent'] = $this->functions->getCMSContent('privacyPolicy');

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        $elements['main'] = 'page/privacyPolicy';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }
    function datingSecurely(){

        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $data['cmsContent'] = $this->functions->getCMSContent('datingSecurely');

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        $elements['main'] = 'page/datingSecurely';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }
    function datingDisclaimer(){

        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $data['cmsContent'] = $this->functions->getCMSContent('datingDisclaimer');

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        $elements['main'] = 'page/datingDisclaimer';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }
    function helpCenter(){

        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $data['faqDatas'] = $this->ModelPage->getAllFAQs();

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        $elements['main'] = 'page/helpCenter';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }
    function howItWorks(){

        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $data['cmsContent'] = $this->functions->getCMSContent('howItWorks');

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        $elements['main'] = 'page/howItWorks';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }
    function whatsNew(){

        $data['controller'] = $this->controller;

        $data['succmsg'] = $this->nsession->userdata('succmsg');
        $data['errmsg'] = $this->nsession->userdata('errmsg');

        $this->nsession->set_userdata('succmsg', "");
        $this->nsession->set_userdata('errmsg', "");

        $data['cmsContent'] = $this->functions->getCMSContent('whatsNew');

        $elements = array();
        $elements['header'] = 'layout/headerMain';
        $element_data['header'] = $data;
        $elements['main'] = 'page/whatsNew';
        $element_data['main'] = $data;
        $elements['footer'] = 'layout/footer';
        $element_data['footer'] = $data;
        $this->layout->setLayout('layout_home');
        $this->layout->multiple_view($elements,$element_data);
    }
	
  	
	function do_forgetpwd(){
	// echo $this->input->request('email');exit;
		if($this->input->request('email')){
			$email=$this->input->request('email');
			$check_email = $this->ModelPage->checkEmail($email);
			if(count($check_email)>0){
				$insertoken=$this->ModelPage->inserttokenforpassword($email);
				$link=base_url()."login/password?email=".$email."&token=".base64_encode($insertoken);
				$to = $email;
				$subject="Forgot Password";
				$body1="<tr><td>Hi ".$check_email[0]['username'].",</td></tr>
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
					$this->nsession->set_userdata('succmsg','Please check your mail ID to reset your password');
                    redirect(base_url('forgot-password'));
				}else{
                    $this->nsession->set_userdata('errmsg','Please try again later');
                    redirect(base_url('forgot-password'));
                }
			}else {
				$this->nsession->set_userdata('errmsg','Please check your email id.');
                redirect(base_url('forgot-password'));
			}
		}else{
			$this->nsession->set_userdata('errmsg','Email id is missing.');
            redirect(base_url('forgot-password'));
		}
	}
    public function refresh(){
        // Captcha configuration
        $config = array(
            'img_path'      => 'captcha/',
            'img_url'       => base_url().'captcha/',
            'img_width'     => 150,
            'img_height'    => 40,
            'word_length'   => 5
        );
        $captcha = create_captcha($config);

        // Unset previous captcha and store new captcha word
        $this->nsession->unset_userdata('captchaCode');
        $this->nsession->set_userdata('captchaCode',$captcha['word']);
        // Display captcha image
        echo $captcha['image'];
    }
    function isValidCaptcha(){
        $inputCaptcha = $this->input->post('captcha_code');
        $sessCaptcha = $this->nsession->userdata('captchaCode');
        if(strtolower($inputCaptcha) === strtolower($sessCaptcha)){
            $error = 0;
        }else{
            $error = 1;
        }
        echo json_encode(array('error'=>$error));
    }
    function geStateData(){
        $country_id = $this->input->post('country_id');
        $state_id = $this->input->post('state_id');
        $stateData = $this->functions->getState($country_id);
        if(count($stateData)!=''){
            echo "<option value=''>Select State</option>";
            foreach($stateData as $state){
                if($state_id == $state['id']){
                    echo "<option value='".$state['id']."' selected>".$state['name']."</option>";
                }else{
                    echo "<option value='".$state['id']."'>".$state['name']."</option>";
                }

            }
        }else{
            echo 'No data';
        }
    }
    function geCityData(){
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $cityData = $this->functions->getCity($state_id);
        if(count($cityData)!=''){
            echo "<option value=''>Select City</option>";
            foreach($cityData as $city){
                if($city_id == $city['id']){
                    echo "<option value='".$city['id']."' selected>".$city['name']."</option>";
                }else{
                    echo "<option value='".$city['id']."'>".$city['name']."</option>";
                }
            }
        }else{
            echo 'No data';
        }
    }
	
	public function contact_us()
	{
        // echo $this->nsession->userdata('member_session_id');exit;
		$data['controller'] = $this->controller;
		$data['succmsg'] 	= $this->nsession->userdata('succmsg');
		$data['errmsg'] 	= $this->nsession->userdata('errmsg');
		
		$this->nsession->set_userdata('succmsg', "");
		$this->nsession->set_userdata('errmsg', "");

		//$data['cmsContent'] = $this->functions->getCMSContent('homePage');
		//$data['testimonial'] = $this->ModelPage->getTestimonial();
        $prepAddr=$this->functions->getGlobalInfo('global_address');
        $url='https://maps.google.com/maps/api/geocode/json?address='.urlencode($prepAddr).'&sensor=false&key=AIzaSyBcTzVAS3dm4ydHvmlK6rx6qNr0aozSX88';
        $geocode=$this->functions->httpGet($url);
    
        $output= json_decode($geocode);
        $data['latitude'] = $output->results[0]->geometry->location->lat;
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        //$json = json_decode($json);
        //pr($data);
		$elements = array();
		$elements['header'] = 'layout/headerMain';
		$element_data['header'] = $data;
		$elements['main'] = 'page/contactus';  
		$element_data['main'] = $data;
		$elements['footer'] = 'layout/footer';  
		$element_data['footer'] = $data;
		$this->layout->setLayout('layout_home'); 
		$this->layout->multiple_view($elements,$element_data);
    }
	
	
	
	
	public function do_contact()
	{
		$data=array();
		$data['name'] = $this->input->post('name');
		$data['ph'] =$this->input->post('phone');
		$data['email'] = $this->input->post('email');
		$data['query'] = $this->input->post('query');
		$data['created_date'] = date('Y-m-d');
		$result=$this->ModelPage->do_contact($data);		
		  if($result)
		  {
			  $this->nsession->set_userdata('succmsg','Your query successfully submitted.');
		  }
		
		$to = $this->functions->getGlobalInfo('global_contact_email');
		$subject = 'Contact Mail';
		$body1 = '<tr><td>Dear Admin,</td></tr>
					<tr><td>Customer Name : '.$data['name'].'</td></tr>
					<tr style="background:#fff;"><td>Customer Email :'.$data['email'].'</td></tr>
					<tr style="background:#fff;"><td>Customer Phone :'.$data['ph'].'</td></tr>
					<tr style="background:#fff;"><td>Message :'.$data['query'].'</td></tr>';
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
		if($this->functions->mail_template($to,$subject,$body)){
			//$this->nsession->set_flashdata('successresult', 'Successfully contact mail sent.');		
		}else{
			//$this->nsession->set_flashdata('errorresult','Unable to send conatct mail.! Try again.');
		}
		  echo json_encode($result);
    }

    function testmail(){

       $data=$this->functions->mail_template("vapdeveloper@gmail.com","Test","Hi");
       pr($data);
       die(); 
       echo 456; 
       //SMTP & mail configuration
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://mail.mymissingrib.com',
            'smtp_port' => 465,
            'smtp_user' => 'admin@mymissingrib.com',
            'smtp_pass' => '123456',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->load->library('email');
        // $config = Array(
        //     'protocol' => 'smtp',
        //     'smtp_host' => 'ssl://smtp.googlemail.com',
        //     'smtp_port' => 465,
        //     'smtp_user' => '',
        //     'smtp_pass' => '',
        //     'mailtype'  => 'html', 
        //     'charset'   => 'iso-8859-1'
        // );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
    

        //Email content
        $htmlContent = '<h1>Sending email via SMTP server</h1>';
        $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';
        
        $this->email->to('vapdeveloper@gmail.com');
        $this->email->from('admin@mymissingrib.com','MyWebsite');
        $this->email->subject('How to send email via SMTP server in CodeIgniter');
        $this->email->message($htmlContent);

        //Send email
        $this->email->send();
        echo $this->email->print_debugger();
    }

    function addTimerForVideo(){
        $response=array('error'=>1,'msg'=>'Invalid Access');
        $member_type=($this->nsession->userdata('member_session_membertype'))?$this->nsession->userdata('member_session_membertype'):0;
        $member_id=$this->nsession->userdata('member_session_id');
        if($member_type==1 && $member_id){
            $data=$this->db->get_where('member_buyed_plan',array('member_id'=>$member_id,'is_active'=>1))->row_array();
            if(count($data) > 0){
                $id=$data['id'];
                $min_remain=$data['minute_remaning'];
                if((int)$min_remain > 0){
                    $check=$this->db->select('*')->get_where('member_video_call_history',array('member_id'=>$member_id))->row_array();
                    if(count($check) > 0){
                        $ndata=array();
                        $ndata['member_id']=$member_id;
                        $ndata['time_available']=((int)$min_remain - 1);
                        $ndata['time_taken']=((int)$check['time_taken'] + 1);
                        $ndata['modified_date']=date('Y-m-d H:i:s');
                        $this->db->update('member_video_call_history',$ndata,array('member_id'=>$member_id));
                    }else{
                        $ndata=array();
                        $ndata['member_id']=$member_id;
                        $ndata['time_available']=((int)$min_remain);
                        $ndata['time_taken']=1;
                        $ndata['created_date']=date('Y-m-d H:i:s');
                        $ndata['modified_date']=date('Y-m-d H:i:s');
                        $this->db->insert('member_video_call_history',$ndata);
                    }
                    $mupdate=array();
                    $mupdate['minute_remaning']=$ndata['time_available'];
                    $this->db->update('member_buyed_plan',$mupdate,array('id'=>$id));
                    $response=array('error'=>0,'msg'=>'Your available time is under progressing','data'=>$ndata);
                }else{
                    $response=array('error'=>1,'msg'=>'Your available time has been reached');
                }
                
            }
        }
        echo json_encode($response);
    }

    function saveTimeZone(){
        $tz=($this->input->post('tz'))?$this->input->post('tz'):'US/Eastern';
        $this->nsession->set_userdata('member_tz',$tz);
        echo 'success';
    }

    function checkAvailTimeForVideoCall(){
        $response=array('error'=>1,'msg'=>'Invalid Access');
        $member_type=($this->nsession->userdata('member_session_membertype'))?$this->nsession->userdata('member_session_membertype'):0;
        $member_id=$this->nsession->userdata('member_session_id');
        if($member_type==1 && $member_id){
            $data=$this->db->get_where('member_buyed_plan',array('member_id'=>$member_id,'is_active'=>1))->row_array();
            if(count($data) > 0){
                $id=$data['id'];
                $min_remain=$data['minute_remaning'];
                if((int)$min_remain > 0){
                    $response=array('error'=>0,'msg'=>'Yes Now you can access');
                }else{
                    $response['msg']='You do not have suffiecient balance to video call';
                    $this->nsession->set_userdata('errmsg',$response['msg']);
                }
            }else{
                $response['msg']='You do not have any membership plan';
                $this->nsession->set_userdata('errmsg',$response['msg']);
            }
        }
        echo json_encode($response);
    }

    function countMessage(){
        $cnt=0;
        if($this->nsession->userdata('member_session_id')){
            $member_id=$this->nsession->userdata('member_session_id');
            $cnt=$this->db->select('id')->get_where('member_message',array('status'=>0,'to_member_id'=>$member_id))->num_rows();
        }
        echo $cnt;
    }

    function image_change(){
        $data=$this->db->select('*')->get_where('member',array('picture !='=>''))->result_array();
        //echo $this->db->last_query();
        //pr($data);
        if(count($data) > 0){
            foreach ($data as $key => $value) {
                $ndata=array();
                $picture=$value['picture'];
                $ndata['picture']=str_replace('http://vtdesignz.co/dev/ci/mmr', 'https://www.mymissingrib.com', $picture);
                $crop_profile_image=$value['crop_profile_image'];
                $ndata['crop_profile_image']=str_replace('http://vtdesignz.co/dev/ci/mmr', 'https://www.mymissingrib.com', $crop_profile_image);

                $this->db->update('member',$ndata,array('id'=>$value['id']));
                echo $this->db->last_query()."<br/>";
            }
        }
    }

    function loginCheck(){
        if($this->nsession->userdata('member_session_id')){
            $UserID=$this->nsession->userdata('member_session_id');
            $recordSet = $this->db->select('id')->get_where('member',array('id'=>$UserID,'is_active'=>1))->num_rows();
           
            if($recordSet > 0){
                echo 'true';
            }else{
                echo 'false';
            }
        }else{
            echo 'true';
        }
        
    }

    function make_friend(){
        $this->load->model('ModelCommon');
        if(!$this->input->post('from_member')){
            $response=array('status'=>0,'msg'=>'You did not pass from_member');
        }else if(!$this->input->post('to_member')){
            $response=array('status'=>0,'msg'=>'You did not pass to_member');
        }else{
            $from_member=$this->input->post('from_member');
            $to_member=$this->input->post('to_member');
            $fid=$this->input->post('fid');
            $tid=$this->input->post('tid');
            $ndata=array();
            $ndata['from_member']=$from_member;
            $ndata['to_member']=$to_member;
            $ndata['from_chat_id']=$fid;
            $ndata['to_chat_id']=$tid;
            $check_exist=$this->ModelCommon->checkFriendOrNot($ndata);
            if($check_exist <= 0){
                $ndata['created_date']=date('Y-m-d');
                $result=$this->ModelCommon->insertData('friends_list',$ndata);
                if($result > 0){
                    $response=array('status'=>1,'msg'=>'Added Successfully');
                }else{
                    $response=array('status'=>0,'msg'=>'Unable to add , please try after some time');
                }
            }else{
                $response=array('status'=>1,'msg'=>'Already Added');
            }
        }
        echo json_encode($response);
    }

    function getFirendList(){
        $this->load->model('ModelCommon');
        $response=array('status'=>0,'data'=>array(),'cnt'=>0);
        $id=($this->nsession->userdata('member_session_id'))?$this->nsession->userdata('member_session_id'):4;
        if($id > 0){
            $num=($this->input->post('num'))?$this->input->post('num'):0;
            $data=$this->ModelCommon->getMyFriendList($id,$num);
            $response=array('status'=>1,'data'=>$data,'cnt'=>count($data));
        }
        echo json_encode($response);
    }

    function doLogOfVideoChat(){
        $response=array('status'=>0,'msg'=>'You are not authenticate user');
        if(!$this->input->post('from_member')){
            $response=array('status'=>0,'msg'=>'You did not pass from member');
        }else if(!$this->input->post('to_member')){
            $response=array('status'=>0,'msg'=>'You did not pass to member');
        }else{
            $this->load->model('ModelCommon');
            $type=($this->input->post('type'))?$this->input->post('type'):'update';
            $ndata=array();
            $ndata['from_member']=$this->input->post('from_member');
            $ndata['to_member']=$this->input->post('to_member');
            $ndata['created_date']=date('Y-m-d H:i:s');
            $ndata['from_room']='room_member_'.$ndata['from_member'];
            $ndata['to_room']='room_member_'.$ndata['to_member'];
            $ndata['status']=($this->input->post('status'))?$this->input->post('status'):0;
            if($type=='insert'){
                $this->ModelCommon->insertData("member_video_call_history_log",$ndata);
            }else{
                $this->ModelPage->updateVideoChatLog($ndata);
            }
            $response=array('status'=>1,'msg'=>'Track Added');
        }
        echo json_encode($response);
    }

    function doEndLogOfVideoChat(){
        $response=array('status'=>0,'msg'=>'You are not authenticate user');
        if(!$this->input->post('from_member')){
            $response=array('status'=>0,'msg'=>'You did not pass from member');
        }else{
            $this->load->model('ModelCommon');
            $from_member=$this->input->post('from_member');

            $this->ModelPage->endVideoChatLog($from_member);
            $response=array('status'=>1,'msg'=>'Track Added');
        }
        echo json_encode($response);
    }

    function doUpdateTimeLogOfVideoChat(){
        $response=array('status'=>0,'msg'=>'You are not authenticate user');
        if(!$this->input->post('from_member')){
            $response=array('status'=>0,'msg'=>'You did not pass from member');
        }else{
            $from_member=$this->input->post('from_member');

            $this->ModelPage->updateTimeVideoChatLog($from_member);
            $response=array('status'=>1,'msg'=>'Track Added');
        }
        echo json_encode($response);
    }

    function showNotificationList(){
        $response=array('error'=>1,'data'=>array(),'message'=>'Invalid Request','total'=>0);
        if($this->nsession->userdata('member_session_id')){
            $member_id=$this->nsession->userdata('member_session_id');
            $list=$this->ModelPage->getMyNotificationList($member_id);
            if(!empty($list) && count($list) > 0){
                $response=array('error'=>0,'data'=>$list,'message'=>'Available','total'=>count($list));
            }
        }
        echo json_encode($response);
    }

    function readNotification(){
        $respons=array('error'=>1,'message'=>'Invalid Request');
        if($this->nsession->userdata('member_session_id') && $this->input->post('id')){
            $id=$this->input->post('id');
            $member_id=$this->nsession->userdata('member_session_id');
            $result=$this->ModelPage->setNotificationRead($member_id,$id);
            if($result > 0){
                $response=array('error'=>0,'message'=>'Available');
            }
        }
        echo json_encode($response);
    }
}
