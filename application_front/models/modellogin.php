<?php
class ModelLogin extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function authenticateUser($data)
    {
		$this->email   		= $data['email'];
		$this->password 	=  $data['password'];
		$this->member_type 	=  $data['member_type'];
		
		$login = false;
		$this->nsession->set_userdata('mem_user_pwd',$this->password);
		$this->db->select('member.*');
		$this->db->where('member.password',md5($this->password));
		$this->db->where('member.member_type',$this->member_type);
   	    //$this->db->where('member.is_active',1);
		$this->db->where('member.is_delete',0);
   	    $this->db->where('member.success_step',1);
		$this->db->where("(member.email='".$this->email."' OR member.username='".$this->email."')");
        //$this->db->where('member.email',$this->email);
        //$this->db->or_where('member.username',$this->email);
		$rs = $this->db->get('member');
	 	//echo $this->db->last_query();
	
	
		if ($rs->num_rows() >0 )
		{
			$row = $rs->row();
			$login = true;
		}

		if($login == true){
			//set cookie
			if($row->is_active==1){
				if(isset($data['remember_me']) && $data['remember_me']=="on")
				{
					//cookie user
					$expire_time = 86400*36500;
					 $cookie_user= array(
						  'name'   => 'mmr_user_id',
						  'value'  => $row->id,
						   'expire' => $expire_time,
					  );
					 $this->input->set_cookie($cookie_user);
					 
				}
				//set session
				//set online status
				$update_status['online_status']=1;
				$this->db->where('id',$row->id)->update('member',$update_status);
				$pic=$row->picture;
				if($pic==""){
				   	$pic=css_images_js_base_url().'images/images.png';
				   }
				$this->nsession->set_userdata('member_session_id', $row->id);
				$this->nsession->set_userdata('member_session_membertype', $row->member_type);
				$this->nsession->set_userdata('member_session_email', $row->email);
				$this->nsession->set_userdata('member_session_name', $row->name);
	            $this->nsession->set_userdata('profileImg',$pic);
	            $this->nsession->set_userdata('coverImg',$row->cover_image!=''?$row->cover_image:'');
				return true;
			}else{
				return 2;
			}
			
		}else{
			return false;
		}
    }
	public function checkUser($data = array()){
		//pr($data);
		$this->db->select('*');
		$this->db->from('member');
		//$this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid'],'email'=>$data['email']));
    $this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid'],'email'=>$data['email'],'member_type'=>$data['member_type']));
    $prevQuery = $this->db->get();
		$prevCheck = $prevQuery->num_rows();
		//echo $prevCheck;exit;

		if($prevCheck<=0){
			$data['created'] = date("Y-m-d H:i:s");
			$data['modified'] = date("Y-m-d H:i:s");
			$insert = $this->db->insert('member',$data);
			$userID = $this->db->insert_id();

			//$this->db->update('member',array('is_active'=>1),array('id'=>$userID)); //Update Account is active status

			$this->nsession->set_userdata('member_session_id', $userID);
			$this->nsession->set_userdata('member_session_membertype', $data['member_type']);
			$this->nsession->set_userdata('member_session_email', $data['email']);
			$this->nsession->set_userdata('member_session_name', $data['first_name']);
		}else{
			$getId = $this->db->select('id')->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid'],'email'=>$data['email'],'member_type'=>$data['member_type'],'is_active'=>1,'is_delete'=>0))->get('member')->row_array();
      if(count($getId)==1){
        $userID = $getId['id'];
  			//$this->db->update('member',array('is_active'=>1),array('id'=>$userID)); //Update Account is active status
  			$this->nsession->set_userdata('member_session_id', $userID);
  			$this->nsession->set_userdata('member_session_membertype', $data['member_type']);
  			$this->nsession->set_userdata('member_session_email', $data['email']);
  			$this->nsession->set_userdata('member_session_name', $data['first_name']);
      }else{
        return $userID?$userID:FALSE;
      }

		}
		return $userID?$userID:FALSE;
    }
	function checkEmail($email_id){
		$sql = "SELECT * FROM member WHERE email='".$email_id."'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	function crypto_rand_secure($min, $max)
	{
	    $range = $max - $min;
	    if ($range < 1) return $min; // not so random...
	    $log = ceil(log($range, 2));
	    $bytes = (int) ($log / 8) + 1; // length in bytes
	    $bits = (int) $log + 1; // length in bits
	    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
	    do {
	        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
	        $rnd = $rnd & $filter; // discard irrelevant bits
	    } while ($rnd > $range);
	    return $min + $rnd;
	}

	function getToken($length)
	{
	    $token = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet.= "0123456789";
	    $max = strlen($codeAlphabet); // edited

	    for ($i=0; $i < $length; $i++) {
	        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
	    }

	    return $token;
	}

	function checktoken($token,$email){
		$result=$this->db->get_where('member',array('forgetpass'=>$token,'email'=>$email))->row();
		//echo $this->db->last_query(); die();
		if(count($result) > 0){
			return true;
		}else{
			return false;
		}
	}

	function inserttokenforpassword($email){
		$token=$this->getToken(20);
		$this->db->update('member',array('forgetpass'=>$token),array('email'=>$email));
		return $token;

	}
	function change_password($password,$email){
		$this->db->update('member',array('password'=>$password,'forgetpass'=>'','success_step'=>1),array('email'=>$email));
		return true;
	}
}
?>
