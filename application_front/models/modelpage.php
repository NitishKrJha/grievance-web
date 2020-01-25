<?php
class ModelPage extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	function getContent($page_name,$lang){
		if($lang=='en'){
			$this->db->select('content_en');
		}else{
			$this->db->select('content_ch');
		}
		$this->db->from('contents');
		$this->db->where_in('page_name', $page_name);
		
		$query = $this->db->get();
		return $query->result_array();
	}
    function getAllFAQs(){
        return $this->db->select('*')->where('is_active','1')->get('faq')->result_array();
    }
	function checkEmail($email_id){		
		$sql = "SELECT * FROM member WHERE email='".$email_id."'";
		$result = $this->db->query($sql);		
		return $result->result_array();	
	}		
	function crypto_rand_secure($min, $max)	{	    
		$range = $max - $min;	    
		if ($range < 1) return $min; 	   
		$log = ceil(log($range, 2));	    
		$bytes = (int) ($log / 8) + 1; 	
		$bits = (int) $log + 1; 	    
		$filter = (int) (1 << $bits) - 1; 	   
		do {	        
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));	      
			$rnd = $rnd & $filter; 	    
		}
		while ($rnd > $range);	   
		return $min + $rnd;	
	}	
	function getToken($length)	{	   
		$token = "";	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";	
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";	   
		$codeAlphabet.= "0123456789";	
		$max = strlen($codeAlphabet);	   
		for ($i=0; $i < $length; $i++) {	
			$token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];	 
		}	    
		return $token;	
	}	
	function checktoken($token,$email){		
	$result=$this->db->get_where('member',array('forgetpass'=>$token,'email'=>$email))->row();		
		if(count($result) > 0){			
			return true;		
		}else{			
			return false;	
		}	
	}	
	function inserttokenforpassword($email){		
		$token=$this->getToken(20);		
		$this->db->where('email',$email);
		$this->db->update('member',array('forgetpass'=>$token));		
		return $token;	
	}	
	function change_password($password,$email){		
		$this->db->update('member',array('password'=>$password,'forgetpass'=>''),array('email'=>$email));	
		return true;	
	}
	
	function getTestimonial(){
		
		$this->db->select('*');
		$this->db->from('testimonial');
		$this->db->where('is_active',1);
		$result = $this->db->get();		
		return $result->result_array();
	}
	
	function do_contact($data)
	{
		$this->db->insert('contact_us',$data);
		return true;
	}
	
	function getfuturemember()
	{
		$memberId = $this->nsession->userdata('member_session_id');
		$this->db->select('member.*,countries.name as country_name,states.name as state_name,member.name as member_name,member.id as member_id');
		$this->db->from('member');
		//$this->db->join('member_buyed_plan','member_buyed_plan.member_id = member.id','left');		
		$this->db->join('countries','countries.id = member.country','left');		
		$this->db->join('states','states.id = member.state','left');		
		//$this->db->where('member_buyed_plan.is_active',1);
		$this->db->where('member.future_member',2);
		//$this->db->where_not_in('member.id',$memberId);
		$this->db->limit(4);
		$result = $this->db->get();		
		return $result->result_array();
	}

	function updateVideoChatLog($data){
		$this->db->order_by('video_log_id','DESC');
		$getLastData=$this->db->select('*')->limit(1)->get_where('member_video_call_history_log',array('from_member'=>$data['from_member']))->result_array();
		if(isset($getLastData[0]['video_log_id'])){
			$ndata=array();
			if($data['status']==1){
				$ndata['start_datetime']=date('Y-m-d H:i:s');
			}else if($data['status']==2){
				$end_datetime=date('Y-m-d H:i:s');
				$start_datetime=$getLastData[0]['start_datetime'];
				$ndata['total_time']= abs(strtotime($end_datetime) - strtotime($start_datetime));
				$ndata['end_datetime']=date('Y-m-d H:i:s');
			}else{

			}
			$ndata['status']=$data['status'];
			$this->db->update('member_video_call_history_log',$ndata,array('video_log_id'=>$getLastData[0]['video_log_id']));
		}
		return true;
	}

	function endVideoChatLog($from_member){
		$this->db->order_by('video_log_id','DESC');
		$this->db->where('(from_member='.$from_member.' OR to_member='.$from_member.')');
		$getLastData=$this->db->select('*')->limit(1)->get_where('member_video_call_history_log',array('status !='=>2))->result_array();
		if(isset($getLastData[0]['video_log_id'])){
			$ndata=array();
			$end_datetime=date('Y-m-d H:i:s');
			$start_datetime=$getLastData[0]['start_datetime'];
			$ndata['total_time']= abs(strtotime($end_datetime) - strtotime($start_datetime));
			$ndata['end_datetime']=date('Y-m-d H:i:s');
			$ndata['status']=2;
			$this->db->update('member_video_call_history_log',$ndata,array('video_log_id'=>$getLastData[0]['video_log_id']));
		}
		return true;
	}

	function updateTimeVideoChatLog($from_member){

		$this->db->order_by('video_log_id','DESC');
		$this->db->where('(from_member='.$from_member.' OR to_member='.$from_member.')');
		$getLastData=$this->db->select('*')->limit(1)->get_where('member_video_call_history_log',array('status !='=>2))->result_array();
		//pr($getLastData);
		if(isset($getLastData[0]['video_log_id'])){
			$ndata=array();
			$end_datetime=date('Y-m-d H:i:s');
			$start_datetime=$getLastData[0]['start_datetime'];
			$ndata['total_time']= abs(strtotime($end_datetime) - strtotime($start_datetime));
			$ndata['end_datetime']=date('Y-m-d H:i:s');
			$this->db->update('member_video_call_history_log',$ndata,array('video_log_id'=>$getLastData[0]['video_log_id']));
		}
		return true;
	}

	function getMyNotificationList($member_id){
		return $this->db->select('*')->get_where('member_notification',array('member_id'=>$member_id,'status'=>0))->result_array();
	}

	function setNotificationRead($member_id,$id){
		return $this->db->update('member_notification',array('status'=>1),array('member_id'=>$member_id,'id'=>$id));
	}
	
}