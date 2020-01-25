<?php
class ModelCounselor extends CI_Model {

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
	function checkEmail($email_id){
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where(array('email'=>$email_id));
        $result =  $this->db->get();
        return $result->result_array();
	}
	function checkUsername($data){
		$username = $data['username'];
		$email = $data['email'];
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where(array('username'=>$username));
		$this->db->where('email != ',$email);
        $result =  $this->db->get();
        return $result->result_array();
	}
	function memberReg($data){
		$this->db->insert('member',$data);
		return $insert_id = $this->db->insert_id();
	}
	function memberRegupdate($data){
		$this->db->update('member',$data,array('email'=>$data['email']));
		return true;
	}
	function updateAccount($member_id,$data){
		$this->db->where('id',$member_id);
		$this->db->update('member',$data);
		return true;
	}
	function checkOldPassword($member_id,$data){
		return $this->db->select('*')->where(array('id'=>$member_id,'password'=>md5($data['old_password'])))->get('member')->num_rows();
	}
	function updatePassword($data,$member_id){
		$updatePassword = array(
			'password'=>md5($data['cfm_new_password']),
      'password_text'=>$data['cfm_new_password']
		);
		$this->db->where('id',$member_id);
		$this->db->update('member',$updatePassword);
		return true;
	}
	function updateProfileImage($member_id,$data){
		$this->db->where('id',$member_id);
		$this->db->update('member',$data);
		return true;
	}
	function checkIfStep2Complate($memberId){
	    $this->db->select('profile_step');
	    $this->db->from('member');
	    $this->db->where('id',$memberId);
	    $rowSet = $this->db->get()->row_array();
	    if($rowSet['profile_step']==2){
	        return false;
        }else{
            return true;
        }
    }
    function doSaveProfileData($memberId,$data){
        $this->db->where('id',$memberId);
        $this->db->update('member',$data);
        return true;
    }
	
	function getMemberData($id){
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('id',$id);
        return $this->db->get()->row_array();
    }
	
	function getcertificateData($id){
        $this->db->select('*');
        $this->db->from('counselor_certificates');
        $this->db->where('member_id',$id);
        return $this->db->get()->result_array();
    }
	
	function delete_certificate($id){
		$this->db->where('id',$id);
		$this->db->delete('counselor_certificates');
		return true;	
	}
	
	function editContent($data,$id,$Imgdata)
	{
		$this->db->where('id', $id);
		$this->db->update('member', $data);
		return true;
	}
	
	function addcertificate($data)
	{		
		$this->db->insert_batch('counselor_certificates',$data);
		$result = $this->db->insert_id();
		return $result;
	}
	
	
	
	function getMemberMoreData($id){
        $this->db->select('member_more.*,body_type.type bodyType,hair_type.type hairType,eye_type.type eyeType,ethnicity.ethnicity ethnicityType,faith.faith_name faithType,language.name languageType,countries.name countriesType,states.name statesType,cities.name citiesType,education.name educationType');
        $this->db->from('member_more');
        $this->db->join('body_type','body_type.id=member_more.body_type');
        $this->db->join('hair_type','hair_type.id=member_more.hair');
        $this->db->join('eye_type','eye_type.id=member_more.eye');
        $this->db->join('ethnicity','ethnicity.id=member_more.ethnicity');
        $this->db->join('faith','faith.id=member_more.faith');
        $this->db->join('language','language.id=member_more.language');
        $this->db->join('countries','countries.id=member_more.country');
        $this->db->join('states','states.id=member_more.state');
        $this->db->join('cities','cities.id=member_more.city');
        $this->db->join('education','education.id=member_more.education');
        $this->db->where('member_id',$id);
        return $this->db->get()->row_array();
    }
	
	function booking_counselor($data){
		$this->db->insert('counselor_booking',$data);
		return $insert_id = $this->db->insert_id();
	}
	
	function getEventDate($member_id)
	{
		$this->db->select('*');
		 $this->db->from('member');
        //$this->db->from('counselor_booking');
		$this->db->join('counselor_booking','counselor_booking.member_id=member.id');
        $this->db->where('counselor_id',$member_id);
		
        $this->db->where('assign',1);
        return $this->db->get()->result_array();
	}
	function counselor_availability($member_id)
	{
		$this->db->select('*');
		$this->db->from('counselor_avalable');
        //$this->db->from('counselor_booking');
        $this->db->where('counselor_id',$member_id);
		$this->db->where('avalable_date >=	',date('Y-m-d'));
		$this->db->order_by('start_time','asc');
        $result =  $this->db->get()->result_array(); 
		return $result;
		
	}
	
	function date_check($counselor_id,$add_date,$start_time,$end_time){
		$start_time = date("H:i:s", strtotime($start_time) + 60);
		$end_time = date("H:i:s", strtotime($end_time));
		/* $this->db->select('*');
        $this->db->from('counselor_avalable');      
        $this->db->where('counselor_id',$counselor_id);
        $this->db->where('avalable_date',$add_date);
		$this->db->where("start_time  BETWEEN 	 '$start_time' AND '$end_time'");
		$this->db->or_where("end_time BETWEEN 	'$start_time' AND '$end_time'");
        return $this->db->get()->result_array(); */
		
		$sql ="SELECT * FROM (`counselor_avalable`) WHERE `counselor_id` = $counselor_id AND `avalable_date` = '$add_date' AND (`start_time` BETWEEN '$start_time' AND '$end_time' OR `end_time` BETWEEN '$start_time' AND '$end_time')";
		$result = $this->db->query($sql)->result_array();
		return $result;
	}
	
	function add_date($data){
		$this->db->insert('counselor_avalable',$data);
		return $insert_id = $this->db->insert_id();
	}

	function checkAddedOnSameDate($id,$date){
		return $this->db->select('id')->get_where('counselor_avalable',array('counselor_id'=>$id,'avalable_date'=>$date))->num_rows();
	}
	
	function getavalabedate($memberId){
		
		$this->db->select('*');
        $this->db->from('counselor_avalable');      
        $this->db->where('counselor_id',$memberId); 
		$this->db->order_by('id', 'DESC');
        return $this->db->get()->result_array();
	}

	function getbookedmember($memberId){
		$timezone=($this->nsession->userdata('member_tz'))?$this->nsession->userdata('member_tz'):'';
		$cd=date('Y-m-d H:i:s');
		if($timezone!=''){
			date_default_timezone_set($timezone);
			$cd=date('Y-m-d H:i:s');
		}
		$this->db->select('counselor_booking.*,member.name as member_name,member.email as member_email,member.phone_no');
        $this->db->from('counselor_booking');
        $this->db->join('member','member.id=counselor_booking.member_id','Right');    
        $this->db->where('counselor_id',$memberId);
        $this->db->where('assign',1);
       // $this->db->where('counselor_booking.booking_date >=',$cd);
		$this->db->order_by('booking_id', 'DESC');
        return $this->db->get()->result_array();
	}

	function getBookingDetails($id){
		$this->db->join('member b','b.id=counselor_booking.counselor_id','Left Outer');
		$this->db->join('member a','a.id=counselor_booking.member_id','Left Outer');
		$data=$this->db->select('a.name as member_name,a.email as member_email,b.name as counselor_name,b.email as counselor_email,counselor_booking.booking_id,counselor_booking.member_id,counselor_booking.counselor_id')->get_where('counselor_booking',array('counselor_booking.booking_id'=>$id))->row_array();
		return $data;
	}
	
	function delete_date($id){
		$this->db->where('id',$id);
		$this->db->delete('counselor_avalable');
		return true;	
	}
	
	function check_available($counselor_id,$avalable_date,$avalable_time)
	{
		
		$sql = "select * from counselor_avalable where counselor_id = $counselor_id and avalable_date= '$avalable_date' AND (start_time <='$avalable_time' AND end_time >='$avalable_time')";
		$result = $this->db->query($sql)->result_array();
		 //echo $this->db->last_query(); die();
		 return $result;
	}
}
