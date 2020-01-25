<?php
class ModelMember extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function getProfileData(){
    	$this->db->select('*');
    	$this->db->from('member');
    	$this->db->where('id',$this->nsession->userdata('member_session_id'));
    	return $this->db->get()->row_array();
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
	function checkUsername($username){
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where(array('username'=>$username));
        $result =  $this->db->get();
        return $result->result_array();
	}
	function memberReg($data){
		$this->db->insert('member',$data);
		return $insert_id = $this->db->insert_id();
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
    function doSaveAppearanceData($member_id,$memberData,$memberMoreData){
        $this->db->where('id',$member_id);
        $this->db->update('member',$memberData);

        $this->db->select('*');
        $this->db->from('member_more');
        $this->db->where('member_id',$member_id);
        $returnData = $this->db->get()->num_rows();
        if($returnData<=0){
			
            $memberMoreData['member_id'] = $member_id;
            $this->db->insert('member_more',$memberMoreData);
            return true;
        }else{
			//echo "hi"; die;
            $this->db->where('member_id',$member_id);
            $this->db->update('member_more',$memberMoreData);
            return true;
        }
    }
    function doSaveLifestyleData($member_id,$memberMoreData){
        $this->db->select('*');
        $this->db->from('member_more');
        $this->db->where('member_id',$member_id);
        $returnData = $this->db->get()->num_rows();
        if($returnData<=0){
            $memberMoreData['member_id'] = $member_id;
            $this->db->insert('member_more',$memberMoreData);
            return true;
        }else{
            $this->db->where('member_id',$member_id);
            $this->db->update('member_more',$memberMoreData);
            return true;
        }
    }

    function geMytbookedHistory($memberId){
    	$timezone=($this->nsession->userdata('member_tz'))?$this->nsession->userdata('member_tz'):'';
		$cd=date('Y-m-d H:i:s',strtotime($stop_date . ' -1 day'));
		if($timezone!=''){
			date_default_timezone_set($timezone);
			$cd=date('Y-m-d H:i:s',strtotime($stop_date . ' -1 day'));
		}
		$this->db->select('counselor_booking.*,member.name as member_name,member.email as member_email,member.phone_no');
        $this->db->from('counselor_booking');
        $this->db->join('member','member.id=counselor_booking.counselor_id','Right');    
        $this->db->where('member_id',$memberId);
        //$this->db->where('counselor_booking.booking_date >=',$cd);
		$this->db->order_by('booking_id', 'DESC');
        return $this->db->get()->result_array();
    }

    function counselor_availability($member_id)
	{
		$timezone=($this->nsession->userdata('member_tz'))?$this->nsession->userdata('member_tz'):'';
		$cd=date('Y-m-d H:i:s');
		if($timezone!=''){
			date_default_timezone_set($timezone);
			$cd=date('Y-m-d H:i:s');
		}
		$this->db->select('*,(SELECT COUNT(booking_id) FROM counselor_booking WHERE counselor_booking.counselor_id=counselor_avalable.counselor_id AND counselor_booking.booking_date=counselor_avalable.fulldate) as cnt',false);
		$this->db->from('counselor_avalable');
        //$this->db->from('counselor_booking');
        $this->db->where('counselor_avalable.counselor_id',$member_id);
		$this->db->where('counselor_avalable.fulldate >=',$cd);
		$this->db->order_by('counselor_avalable.start_time','asc');
        $result =  $this->db->get()->result_array(); 
        //echo $this->db->last_query(); die();
        return $result;
		
	}

	function getVideoCallList(&$config,&$start,&$param){
		// GET DATA FROM GET/POST  OR   SESSION ====================
		$Count = 0;
		$page = $this->uri->segment(3,0); // page
		$isSession = $this->uri->segment(4,0); // read data from SESSION or POST     (1 == POST , 0 = SESSION )

		$start = 0;

		$sortType 		= $param['sortType'];
		$sortField 		= $param['sortField'];
		$searchField 	= $param['searchField'];
		$searchString 	= $param['searchString'];
		$searchText 	= $param['searchText'];
		$searchFromDate	= $param['searchFromDate'];
		$searchToDate 	= $param['searchToDate'];
		$searchAlpha	= $param['searchAlpha'];
		$searchMode		= $param['searchMode'];
		$searchDisplay 	= $param['searchDisplay'];

		if($isSession == 0)
		{
			$sortType    	= $this->nsession->get_param('ADMIN_MEMBER','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_MEMBER','sortField','video_log_id');
			$searchField 	= $this->nsession->get_param('ADMIN_MEMBER','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_MEMBER','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_MEMBER','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_MEMBER','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_MEMBER','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_MEMBER','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_MEMBER','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_MEMBER','searchDisplay',20);
		}

		//========= SET SESSION DATA FOR SEARCH / PAGE / SORT Condition etc =====================
		$sessionDataArray = array();
		$sessionDataArray['sortType'] 		= $sortType;
		$sessionDataArray['sortField'] 		= $sortField;
		if($searchField!=''){
			$sessionDataArray['searchField'] 	= $searchField;
			$sessionDataArray['searchString'] 	= $searchString ;
		}
		$sessionDataArray['searchText'] 	= $searchText;
		$sessionDataArray['searchFromDate'] = $searchFromDate;
		$sessionDataArray['searchToDate'] 	= $searchToDate;
		$sessionDataArray['searchAlpha'] 	= $searchAlpha;
		$sessionDataArray['searchMode'] 	= $searchMode;
		$sessionDataArray['searchDisplay'] 	= $searchDisplay;

		
		
		
		$this->nsession->set_userdata('ADMIN_TIPS', $sessionDataArray);
		
		//==============================================================
		$this->db->select('COUNT(video_log_id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$member_id=$this->nsession->userdata('member_session_id');
		$this->db->where('from_member',$member_id);
		$this->db->select('member_video_call_history_log.*');

		$recordSet = $this->db->get('member_video_call_history_log');
		$config['total_rows'] = 0;
		$config['per_page'] = $searchDisplay;
		if ($recordSet)
		{
			$row = $recordSet->row();
			$config['total_rows'] = $row->TotalrecordCount;
		}
		else
		{
			return false;
		}

		if($page > 0 && $page < $config['total_rows'] )
			$start = $page;
			$this->db->select('member_video_call_history_log.*,a.name as from_name,b.name as to_name');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
		$this->db->join('member a','a.id = member_video_call_history_log.from_member','left');
		$this->db->join('member b','b.id = member_video_call_history_log.from_member','left');
		
		$this->db->order_by('member_video_call_history_log.video_log_id',$sortType);
		$this->db->limit($config['per_page'],$start);
		$this->db->where('member_video_call_history_log.from_member',$member_id);
		$recordSet = $this->db->get('member_video_call_history_log');
		//echo $this->db->last_query();
		$rs = false;

		if ($recordSet->num_rows() > 0)
        {
           	$rs = array();
			$isEscapeArr = array();
			foreach ($recordSet->result_array() as $row)
			{
				foreach($row as $key=>$val){
					if(!in_array($key,$isEscapeArr)){
						$recordSet->fields[$key] = outputEscapeString($val);
						}
					}
				$rs[] = $recordSet->fields;
			}
		}
		else
		{
			return false;
		}
		return $rs;
	}
	
    function getMemberData($id){
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('id',$id);
        return $this->db->get()->row_array();
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
	
	function getcounselor(){
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('member_type',2);
        return $this->db->get()->result_array();
    }
	
	
	function getcounselorList(&$config,&$start,&$param)
	{

		// GET DATA FROM GET/POST  OR   SESSION ====================
		$Count = 0;
		$page = $this->uri->segment(3,0); // page
		$isSession = $this->uri->segment(4,0); // read data from SESSION or POST     (1 == POST , 0 = SESSION )

		$start = 0;

		$sortType 		= $param['sortType'];
		$sortField 		= $param['sortField'];
		$searchField 	= $param['searchField'];
		$searchString 	= $param['searchString'];
		$searchText 	= $param['searchText'];
		$searchFromDate	= $param['searchFromDate'];
		$searchToDate 	= $param['searchToDate'];
		$searchAlpha	= $param['searchAlpha'];
		$searchMode		= $param['searchMode'];
		$searchDisplay 	= $param['searchDisplay'];

		if($isSession == 0)
		{
			$sortType    	= $this->nsession->get_param('ADMIN_MEMBER','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_MEMBER','sortField','member.id');
			$searchField 	= $this->nsession->get_param('ADMIN_MEMBER','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_MEMBER','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_MEMBER','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_MEMBER','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_MEMBER','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_MEMBER','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_MEMBER','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_MEMBER','searchDisplay',12);
		}

		//========= SET SESSION DATA FOR SEARCH / PAGE / SORT Condition etc =====================
		$sessionDataArray = array();
		$sessionDataArray['sortType'] 		= $sortType;
		$sessionDataArray['sortField'] 		= $sortField;
		if($searchField!=''){
			$sessionDataArray['searchField'] 	= $searchField;
			$sessionDataArray['searchString'] 	= $searchString ;
		}
		$sessionDataArray['searchText'] 	= $searchText;
		$sessionDataArray['searchFromDate'] = $searchFromDate;
		$sessionDataArray['searchToDate'] 	= $searchToDate;
		$sessionDataArray['searchAlpha'] 	= $searchAlpha;
		$sessionDataArray['searchMode'] 	= $searchMode;
		$sessionDataArray['searchDisplay'] 	= $searchDisplay;

		$this->nsession->set_userdata('ADMIN_MEMBER', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('member.*');
		$this->db->where('member.member_type','2');

		$recordSet = $this->db->get('member');
		$config['total_rows'] = 0;
		$config['per_page'] = $searchDisplay;
		if ($recordSet)
		{
			$row = $recordSet->row();
			$config['total_rows'] = $row->TotalrecordCount;
		}
		else
		{
			return false;
		}

		if($page > 0 && $page < $config['total_rows'] )
			$start = $page;
			$this->db->select('member.*');
			$this->db->where('member.member_type','2');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('member');
		//echo $this->db->last_query();
		$rs = false;

		if ($recordSet->num_rows() > 0)
        {
           	$rs = array();
			$isEscapeArr = array();
			foreach ($recordSet->result_array() as $row)
			{
				foreach($row as $key=>$val){
					if(!in_array($key,$isEscapeArr)){
						$recordSet->fields[$key] = outputEscapeString($val);
						}
					}
				$rs[] = $recordSet->fields;
			}
		}
		else
		{
			return false;
		}
		return $rs;
	}
	
	
	function getmemberList(&$config,&$start,&$param,&$memberId)
	{

		// GET DATA FROM GET/POST  OR   SESSION ====================
		$Count = 0;
		$page = $this->uri->segment(3,0); // page
		$isSession = $this->uri->segment(4,0); // read data from SESSION or POST     (1 == POST , 0 = SESSION )

		$start = 0;

		$sortType 		= $param['sortType'];
		$sortField 		= $param['sortField'];
		$searchField 	= $param['searchField'];
		$searchString 	= $param['searchString'];
		$searchText 	= $param['searchText'];
		$searchFromDate	= $param['searchFromDate'];
		$searchToDate 	= $param['searchToDate'];
		$searchAlpha	= $param['searchAlpha'];
		$searchMode		= $param['searchMode'];
		$searchDisplay 	= $param['searchDisplay'];

		if($isSession == 0)
		{
			$sortType    	= $this->nsession->get_param('ADMIN_MEMBER','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_MEMBER','sortField','member.id');
			$searchField 	= $this->nsession->get_param('ADMIN_MEMBER','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_MEMBER','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_MEMBER','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_MEMBER','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_MEMBER','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_MEMBER','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_MEMBER','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_MEMBER','searchDisplay',12);
		}

		//========= SET SESSION DATA FOR SEARCH / PAGE / SORT Condition etc =====================
		$sessionDataArray = array();
		$sessionDataArray['sortType'] 		= $sortType;
		$sessionDataArray['sortField'] 		= $sortField;
		if($searchField!=''){
			$sessionDataArray['searchField'] 	= $searchField;
			$sessionDataArray['searchString'] 	= $searchString ;
		}
		$sessionDataArray['searchText'] 	= $searchText;
		$sessionDataArray['searchFromDate'] = $searchFromDate;
		$sessionDataArray['searchToDate'] 	= $searchToDate;
		$sessionDataArray['searchAlpha'] 	= $searchAlpha;
		$sessionDataArray['searchMode'] 	= $searchMode;
		$sessionDataArray['searchDisplay'] 	= $searchDisplay;

		$this->nsession->set_userdata('ADMIN_MEMBER', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('member.*');
		$this->db->where('member.member_type','1');
		$this->db->where_not_in('member.id', $memberId);
		
		$recordSet = $this->db->get('member');
		$config['total_rows'] = 0;
		$config['per_page'] = $searchDisplay;
		if ($recordSet)
		{
			$row = $recordSet->row();
			$config['total_rows'] = $row->TotalrecordCount;
		}
		else
		{
			return false;
		}

		if($page > 0 && $page < $config['total_rows'] )
			$start = $page;
			$this->db->select('member.*');
			$this->db->where('member.member_type','1');
			$this->db->where_not_in('member.id', $memberId);
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('member');
		//echo $this->db->last_query();
		$rs = false;

		if ($recordSet->num_rows() > 0)
        {
           	$rs = array();
			$isEscapeArr = array();
			foreach ($recordSet->result_array() as $row)
			{
				foreach($row as $key=>$val){
					if(!in_array($key,$isEscapeArr)){
						$recordSet->fields[$key] = outputEscapeString($val);
						}
					}
				$rs[] = $recordSet->fields;
			}
		}
		else
		{
			return false;
		}
		return $rs;
	}

	function subscriberList($page,$param){
		$offset=(int)((int)$page * 20);
		$member_id=$this->nsession->userdata('member_session_id');
		$this->db->select('friends_list.*,a.picture as from_picture,b.picture as to_picture,a.name as from_name,b.name as to_name');
		$this->db->join('member a','a.id=friends_list.from_member','Left Join');
		$this->db->join('member b','b.id=friends_list.to_member','Left Join');
		//$this->db->where('');
		if($param!=''){
			$this->db->where($param);
		}
		$this->db->where('a.is_active','1');
		$this->db->where('b.is_active','1');
		$this->db->order_by('friends_list.friend_id','DESC');
		$this->db->limit(20,$offset);
		$recordSet = $this->db->get('friends_list');
		//echo $this->db->last_query(); die();
		if ($recordSet->num_rows() > 0)
        {
           	$rs = array();
			$isEscapeArr = array();
			foreach ($recordSet->result_array() as $row)
			{
				foreach($row as $key=>$val){
					$recordSet->fields[$key]=$val;
				}
				$rs[] = $recordSet->fields;
			}
		}
		else
		{
			return array();
		}
		return $rs;
	}
	
	
	
	function filter_counselor(&$config,&$start,&$param,&$country_id,&$state_id,&$city_id,&$zip)
	{
		//echo $country_id; die;
		
		// GET DATA FROM GET/POST  OR   SESSION ====================
		$Count = 0;
		$page = $this->uri->segment(3,0); // page
		$isSession = $this->uri->segment(4,0); // read data from SESSION or POST     (1 == POST , 0 = SESSION )

		$start = 0;

		$sortType 		= $param['sortType'];
		$sortField 		= $param['sortField'];
		$searchField 	= $param['searchField'];
		$searchString 	= $param['searchString'];
		$searchText 	= $param['searchText'];
		$searchFromDate	= $param['searchFromDate'];
		$searchToDate 	= $param['searchToDate'];
		$searchAlpha	= $param['searchAlpha'];
		$searchMode		= $param['searchMode'];
		$searchDisplay 	= $param['searchDisplay'];

		if($isSession == 0)
		{
			$sortType    	= $this->nsession->get_param('ADMIN_MEMBER','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_MEMBER','sortField','member.id');
			$searchField 	= $this->nsession->get_param('ADMIN_MEMBER','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_MEMBER','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_MEMBER','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_MEMBER','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_MEMBER','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_MEMBER','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_MEMBER','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_MEMBER','searchDisplay',12);
		}

		//========= SET SESSION DATA FOR SEARCH / PAGE / SORT Condition etc =====================
		$sessionDataArray = array();
		$sessionDataArray['sortType'] 		= $sortType;
		$sessionDataArray['sortField'] 		= $sortField;
		if($searchField!=''){
			$sessionDataArray['searchField'] 	= $searchField;
			$sessionDataArray['searchString'] 	= $searchString ;
		}
		$sessionDataArray['searchText'] 	= $searchText;
		$sessionDataArray['searchFromDate'] = $searchFromDate;
		$sessionDataArray['searchToDate'] 	= $searchToDate;
		$sessionDataArray['searchAlpha'] 	= $searchAlpha;
		$sessionDataArray['searchMode'] 	= $searchMode;
		$sessionDataArray['searchDisplay'] 	= $searchDisplay;

		$this->nsession->set_userdata('ADMIN_MEMBER', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('member.*');
		$this->db->where('member.member_type','2');
		$this->db->where('member.is_active','1');
		$recordSet = $this->db->get('member');
		$config['total_rows'] = 0;
		$config['per_page'] = $searchDisplay;
		if ($recordSet)
		{
			$row = $recordSet->row();
			$config['total_rows'] = $row->TotalrecordCount;
		}
		else
		{
			return false;
		}

		if($page > 0 && $page < $config['total_rows'] )
			$start = $page;
			$this->db->select('member.*');
			$this->db->where('member.member_type','2');
			
			if($country_id){
				$this->db->where('member.country',$country_id);
			}
			if($state_id){				
				$this->db->where('member.state',$state_id);
			} 
			if($city_id){
				$this->db->where('member.city',$city_id);
			}
			
			if($zip){
				$this->db->where('member.zip',$zip);
			} 
			
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
		$this->db->where('member.is_active','1');
		$this->db->order_by('member.id','DESC');
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('member');
		//echo $this->db->last_query();
		$rs = false;

		if ($recordSet->num_rows() > 0)
        {
           	$rs = array();
			$isEscapeArr = array();
			foreach ($recordSet->result_array() as $row)
			{
				//$dd=date('Y-m-d H:i:s',time() + 3600);
				$this->db->limit(1);
				$this->db->order_by('booking_date','ASC');
				$this->db->where('booking_date >= DATE_SUB(NOW(), INTERVAL 10 HOUR)');
				$this->db->join('member','member.id=counselor_booking.counselor_id','Left Outer');
				$check_booking=$this->db->select('counselor_booking.*,member.name as member_name,member.id as member_id,member.picture')->get_where('counselor_booking',array('member_id'=>$this->nsession->userdata('member_session_id'),'counselor_id'=>$row['id'],'assign'=>1))->row_array();
				$row['booking']=$check_booking;
				foreach($row as $key=>$val){
					$recordSet->fields[$key]=$val;
				}
				$rs[] = $recordSet->fields;
			}
		}
		else
		{
			return false;
		}
		return $rs;
	}
	
	//check expire_date
	public function checkExpireDate($memberId)
	{
		
		$result = $this->db->where('id',$memberId)->where('expire_date >',date('Y-m-d H:i:s'))->get('member')->result_array();
		return $result;
	}
	
	
	function filter_member(&$config,&$start,&$param,&$memberId)
	{
		//echo $country_id; die;
		
		// GET DATA FROM GET/POST  OR   SESSION ====================
		
		$Count = 0;
		$page = $this->uri->segment(3,0); // page
		$isSession = $this->uri->segment(4,0); // read data from SESSION or POST     (1 == POST , 0 = SESSION )

		$start = 0;

		$sortType 		= $param['sortType'];
		$sortField 		= $param['sortField'];
		$searchField 	= $param['searchField'];
		$searchString 	= $param['searchString'];
		$searchText 	= $param['searchText'];
		$searchFromDate	= $param['searchFromDate'];
		$searchToDate 	= $param['searchToDate'];
		$searchAlpha	= $param['searchAlpha'];
		$searchMode		= $param['searchMode'];
		$searchDisplay 	= $param['searchDisplay'];
		
		$country_id 	    = $param['country_id'];
        $state_id           = $param['state_id'];
        $city_id	    = $param['city_id'];
        $zip	    = $param['zip'];
        $loking_for	    = $param['loking_for'];
        $age_from	    = $param['age_from'];
        $age_to	    = $param['age_to'];
        $education	    = $param['education'];
        $language	    = $param['language'];
        $have_kids	    = $param['have_kids'];
        $smoking	    = $param['smoking'];
        $drinking	    = $param['drinking'];
        $height	    = $param['height'];
        $body_type	    = $param['body_type'];
        $eye	    = $param['eye'];
        $hair	    = $param['hair'];
		
		
		
		if($isSession == 0)
		{
			//echo "jbb"; die;
			
			$sortType    	= $this->nsession->get_param('ADMIN_MEMBER','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_MEMBER','sortField','member.id');
			$searchField 	= $this->nsession->get_param('ADMIN_MEMBER','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_MEMBER','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_MEMBER','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_MEMBER','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_MEMBER','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_MEMBER','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_MEMBER','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_MEMBER','searchDisplay',12);
			
			//$zip           = $this->nsession->get_param('ADMIN_MEMBER','zip','');
            
			
		}
		
		//echo $zip; die;

		//========= SET SESSION DATA FOR SEARCH / PAGE / SORT Condition etc =====================
		$sessionDataArray = array();
		$sessionDataArray['sortType'] 		= $sortType;
		$sessionDataArray['sortField'] 		= $sortField;
		if($searchField!=''){
			$sessionDataArray['searchField'] 	= $searchField;
			$sessionDataArray['searchString'] 	= $searchString ;
		}
		$sessionDataArray['searchText'] 	= $searchText;
		$sessionDataArray['searchFromDate'] = $searchFromDate;
		$sessionDataArray['searchToDate'] 	= $searchToDate;
		$sessionDataArray['searchAlpha'] 	= $searchAlpha;
		$sessionDataArray['searchMode'] 	= $searchMode;
		$sessionDataArray['searchDisplay'] 	= $searchDisplay;

		
		if($zip!=''){
            $sessionDataArray['zip'] 	        = $zip; 						
        }
		
        if($country_id!=''){
            $sessionDataArray['country_id']               = $country_id ;
        }
		
        if($state_id!=''){
            $sessionDataArray['state_id'] 	        = $state_id ;
        } 
		
		if($city_id!=''){
            $sessionDataArray['city_id'] 	        = $city_id ;
        }
		
		if($loking_for!=''){
            $sessionDataArray['loking_for'] 	        = $loking_for ;
        }
		
		if($age_from!=''){
            $sessionDataArray['age_from'] 	        = $age_from ;
        }
		
		if($age_to!=''){
            $sessionDataArray['age_to'] 	        = $age_to ;
        }
		
		if($education!=''){
            $sessionDataArray['education'] 	        = $education ;
		}
		
		if($language!=''){
            $sessionDataArray['language'] 	        = $language ;
		}
		
		if($have_kids!=''){
            $sessionDataArray['have_kids'] 	        = $have_kids ;
		}
		if($smoking!=''){
            $sessionDataArray['smoking'] 	        = $smoking ;
		}
		
		if($drinking!=''){
            $sessionDataArray['drinking'] 	        = $drinking ;
		}
		
		if($height!=''){
            $sessionDataArray['height'] 	        = $height ;
		}
		
		if($body_type!=''){
            $sessionDataArray['body_type'] 	        = $body_type ;
		}
		
		if($eye!=''){
            $sessionDataArray['eye'] 	        = $eye ;
		}
		
		if($hair!=''){
            $sessionDataArray['hair'] 	        = $hair ;
		}
		$this->nsession->set_userdata('ADMIN_MEMBER', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		/* if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		} */
		
		$this->db->select('member.*');
		
		$this->db->where('member.member_type','1');
		$this->db->where_not_in('member.id', $memberId);
		$recordSet = $this->db->get('member');
		$config['total_rows'] = 0;
		$config['per_page'] = $searchDisplay;
		if ($recordSet)
		{
			$row = $recordSet->row();
			$config['total_rows'] = $row->TotalrecordCount;
		}
		else
		{
			return false;
		}

		if($page > 0 && $page < $config['total_rows'] )
			$start = $page;
			$this->db->select('member.*,member_more.*');
			$this->db->where('member.member_type','1');
			
			$this->db->join('member_more','member_more.member_id = member.id','left');
			$this->db->where_not_in('member.id', $memberId);
			if($country_id){
				$this->db->where('member.country',$country_id);
			}
			if($state_id){				
				$this->db->where('member.state',$state_id);
			} 
			if($city_id){
				$this->db->where('member.city',$city_id);
			}
			
			if($zip){
				
				//echo "hi"; die;
				
				$this->db->where('member.zip',$zip);
			}
			
			if($loking_for){
				$this->db->where('member.man_woman',$loking_for);
			}
			
			if($age_from && $age_to){
				$this->db->where('age >=', $age_from);
				$this->db->where('age <=', $age_to);
			}
			
			
			if($education){
				$this->db->where('member_more.education',$education);
			}
			
			if($language){
				$this->db->where('member_more.language',$language);
			}
			
			if($have_kids){
				$this->db->where('member_more.have_kids',$have_kids);
			}
			
			if($smoking){
				$this->db->where('member_more.smoking',$smoking);
			}
			
			if($drinking){
				$this->db->where('member_more.drinking',$drinking);
			}
			
			if($height){
				$this->db->where('member_more.height',$height);
			}
			
			if($body_type){
				$this->db->where('member_more.body_type',$body_type);
			}
			
			if($eye){
				$this->db->where('member_more.eye',$eye);
			}
			
			if($hair){
				$this->db->where('member_more.hair',$hair);
			}
			/* if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			} */

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('member');
		//echo $this->db->last_query();
		$rs = false;

		if ($recordSet->num_rows() > 0)
        {
           	$rs = array();
			$isEscapeArr = array();
			foreach ($recordSet->result_array() as $row)
			{
				foreach($row as $key=>$val){
					if(!in_array($key,$isEscapeArr)){
						$recordSet->fields[$key] = outputEscapeString($val);
						}
					}
				$rs[] = $recordSet->fields;
			}
		}
		else
		{
			return false;
		}
		return $rs;
	}
	
	
	function filter_matchmember(&$config,&$start,&$param)
	{
		//echo $country_id; die;
		
		// GET DATA FROM GET/POST  OR   SESSION ====================
		
		$Count = 0;
		$page = $this->uri->segment(3,0); // page
		$isSession = $this->uri->segment(4,0); // read data from SESSION or POST     (1 == POST , 0 = SESSION )

		$start = 0;

		$sortType 		= $param['sortType'];
		$sortField 		= $param['sortField'];
		$searchField 	= $param['searchField'];
		$searchString 	= $param['searchString'];
		$searchText 	= $param['searchText'];
		$searchFromDate	= $param['searchFromDate'];
		$searchToDate 	= $param['searchToDate'];
		$searchAlpha	= $param['searchAlpha'];
		$searchMode		= $param['searchMode'];
		$searchDisplay 	= $param['searchDisplay'];
		
		$country_id 	    = $param['country_id'];
        $state_id           = $param['state_id'];
        $city_id	    = $param['city_id'];
        $zip	    = $param['zip'];
        $loking_for	    = $param['loking_for'];
        $age_from	    = $param['age_from'];
        $age_to	    = $param['age_to'];
        $education	    = $param['education'];
		
		
		
		if($isSession == 0)
		{
			//echo "jbb"; die;
			
			$sortType    	= $this->nsession->get_param('ADMIN_MEMBER','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_MEMBER','sortField','member.id');
			$searchField 	= $this->nsession->get_param('ADMIN_MEMBER','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_MEMBER','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_MEMBER','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_MEMBER','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_MEMBER','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_MEMBER','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_MEMBER','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_MEMBER','searchDisplay',12);
			
			//$zip           = $this->nsession->get_param('ADMIN_MEMBER','zip','');
            
			
		}
		
		//echo $zip; die;

		//========= SET SESSION DATA FOR SEARCH / PAGE / SORT Condition etc =====================
		$sessionDataArray = array();
		$sessionDataArray['sortType'] 		= $sortType;
		$sessionDataArray['sortField'] 		= $sortField;
		if($searchField!=''){
			$sessionDataArray['searchField'] 	= $searchField;
			$sessionDataArray['searchString'] 	= $searchString ;
		}
		$sessionDataArray['searchText'] 	= $searchText;
		$sessionDataArray['searchFromDate'] = $searchFromDate;
		$sessionDataArray['searchToDate'] 	= $searchToDate;
		$sessionDataArray['searchAlpha'] 	= $searchAlpha;
		$sessionDataArray['searchMode'] 	= $searchMode;
		$sessionDataArray['searchDisplay'] 	= $searchDisplay;

		
		if($zip!=''){
            $sessionDataArray['zip'] 	        = $zip; 						
        }
		
        if($country_id!=''){
            $sessionDataArray['country_id']               = $country_id ;
        }
		
        if($state_id!=''){
            $sessionDataArray['state_id'] 	        = $state_id ;
        } 
		
		if($city_id!=''){
            $sessionDataArray['city_id'] 	        = $city_id ;
        }
		
		if($loking_for!=''){
            $sessionDataArray['loking_for'] 	        = $loking_for ;
        }
		
		if($age_from!=''){
            $sessionDataArray['age_from'] 	        = $age_from ;
        }
		
		if($age_to!=''){
            $sessionDataArray['age_to'] 	        = $age_to ;
        }
		
		
		
		
		$this->nsession->set_userdata('ADMIN_MEMBER', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		/* if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		} */
		
		$this->db->select('member.*');
		$this->db->where('member.member_type','1');

		$recordSet = $this->db->get('member');
		$config['total_rows'] = 0;
		$config['per_page'] = $searchDisplay;
		if ($recordSet)
		{
			$row = $recordSet->row();
			$config['total_rows'] = $row->TotalrecordCount;
		}
		else
		{
			return false;
		}

		if($page > 0 && $page < $config['total_rows'] )
			$start = $page;
			$this->db->select('member.*');
			
			$this->db->where('member.member_type','1');
			
			if($country_id){
				$this->db->where('member.country',$country_id);
			}
			if($state_id){				
				$this->db->where('member.state',$state_id);
			} 
			if($city_id){
				$this->db->where('member.city',$city_id);
			}
			
			if($zip){
				
				//echo "hi"; die;
				
				$this->db->where('member.zip',$zip);
			}
			
			if($loking_for){
				$this->db->where('member.interested_in',$loking_for);
			}
			
			if($age_from && $age_to){
				$this->db->where('age >=', $age_from);
				$this->db->where('age <=', $age_to);
			}
			
			
			
			/* if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			} */

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('member');
		//echo $this->db->last_query();
		$rs = false;

		if ($recordSet->num_rows() > 0)
        {
           	$rs = array();
			$isEscapeArr = array();
			foreach ($recordSet->result_array() as $row)
			{
				foreach($row as $key=>$val){
					if(!in_array($key,$isEscapeArr)){
						$recordSet->fields[$key] = outputEscapeString($val);
						}
					}
				$rs[] = $recordSet->fields;
			}
		}
		else
		{
			return false;
		}
		return $rs;
	}
	function getCountry()
	{
		$this->db->select('*');
		$this->db->from('countries');		
		$data = $this->db->get();
		return $data->result_array();
	}
	function savePaymentData($memberPayDetails){
	    $this->db->insert('member_buyed_plan',$memberPayDetails);
	    return true;
    }
    function savePaymentDataMinute($memberPayDetails){
	    $this->db->insert('member_buyed_minute',$memberPayDetails);
	    return true;
    }
    function checkIfPaymentDone($member_id){
        $this->db->select('*');
        $this->db->from('member_buyed_plan');
        $this->db->where(array('member_id'=>$member_id,'is_active'=>1));
        return $this->db->get()->row_array();
    }
    function updateMembershipStatus($member_buyed_plan_id){
        $this->db->where('id',$member_buyed_plan_id);
        $this->db->update('member_buyed_plan',array('canceled_by'=>1,'is_active'=>0));
        return true;
    }
	//my matches 
	public function get_search_result($where,$start)
	{
		$memberId = $this->nsession->userdata('member_session_id');
		$limit=20;
		if($start > 0)
		{
			$start = $start*$limit;
		}
		$sql =" select * from member member  left join member_more more on member.id=more.member_id  where 1 and member_type=1  $where and member.id!=$memberId and (member.id not in( select to_member_id from  block_member where from_member_id=$memberId) and member.id not in( select from_member_id  from  block_member where to_member_id=$memberId)) order by member.id desc limit $start,$limit ";
		
		$result = $this->db->query($sql)->result_array(); 
		foreach($result as $k=>$val)
		{
			$result[$k]['membership_plan'] =  $this->db->where('member_id',$val['member_id'])->where('is_active',1)->get('member_buyed_plan')->result_array();
		}
		
		$query['result'] = $result;
		$query['count'] = count($query['result']);
		return $query;
		
		
		
		
		/* $query['result'] = $this->db->query($sql)->result_array();
		$query['count'] = count($query['result']);
		return $query; */
	}
    function checkPhoneNo($phonoNo){
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where(array('phone_no'=>$phonoNo));
        $result =  $this->db->get();
        return $result->result_array();
    }
	
	function insert_interest($data,$member_id){
		
		$this->db->where('member_id',$member_id);
		$this->db->delete('member_interest');
		
		$this->db->insert_batch('member_interest',$data);
		return $insert_id = $this->db->insert_id();
	}
	public function get_mymatches($memberId,$where,$start=0,$type='')
	{
		
		//$blockMember = $this->db->get_where('block_member',array('from_member_id'=>$memberId))->result_array();
		//pr($blockMember);
		
		$limit=20;
		if($start > 0)
		{
			$start = $start*$limit;
		}
	 	// $sql = "select distinct(member_interest.member_id),member.* from member_interest left join member_more on member_more.member_id=member_interest.member_id  inner join member on member_interest.member_id=member.id  
	 	// where interest_id in(select interest_id from member_interest 
	 	// where member_id=$memberId) 
	 	// $where and member_interest.member_id!= $memberId and (member_interest.member_id not in( select to_member_id from block_member where from_member_id = $memberId) and member_interest.member_id not in( select from_member_id  from block_member where to_member_id = $memberId))  order by member.id desc limit $start,$limit ";
	 	$sql = "select distinct(member.id),member.*,member.id as member_id from member LEFT JOIN member_more on member.id=member_more.member_id  
	 		where  member.is_active=1 $where and member.id!= $memberId and (member.id not in( select to_member_id from block_member where from_member_id = $memberId) and member.id not in( select from_member_id  from block_member where to_member_id = $memberId))  order by member.id asc limit $start,$limit ";
		$result = $this->db->query($sql)->result_array(); 
		//echo $this->db->last_query(); die();
		$nndata=array();
		if($type=='paid'){
			foreach($result as $k=>$val)
			{
				$membership_plan=array();
				$membership_plan =  $this->db->where('member_id',$val['member_id'])->where('is_active',1)->get('member_buyed_plan')->row_array();
				if(count($membership_plan) > 0){
					$nndata[$k]=$val;
					$nndata[$k]['membership_plan']=$membership_plan;
					$nndata[$k]['membership_plan_cnt']=count($membership_plan);
				}
			}
		}else{
			foreach($result as $k=>$val)
			{
				$membership_plan=array();
				$membership_plan =  $this->db->where('member_id',$val['member_id'])->where('is_active',1)->get('member_buyed_plan')->row_array();
				$nndata[$k]=$val;
				$nndata[$k]['membership_plan']=$membership_plan;
				$nndata[$k]['membership_plan_cnt']=count($membership_plan);
			}
		}
		
		
		$query['result'] = $nndata;
		$query['count'] = count($query['result']);
		return $query;
	}

	public function search_subscriber_data($member_id,$where,$start){
		$this->db->select('member_video_call_history_log.*,a.name as from_name,b.name as to_name');
		$this->db->join('member a','a.id=friends_list.from_member','Left Join');
		$this->db->join('member b','b.id=friends_list.to_member','Left Join');
		$this->db->limit(20,$start);
		$this->db->where('(friends_list.from_member='.$member_id.' OR friends_list.to_member='.$member_id.')');
		//$this->db->where('()');
		$this->db->where('a.is_active','1');
		$this->db->where('b.is_active','1');
		$recordSet = $this->db->get('friends_list');
	}

	public function get_favaourite($memberId,$where,$start)
	{
		$limit=20;
		if($start > 0)
		{
			$start = $start*$limit;
		}
		 $sql = "select member.*,member.id as member_id from my_favorite fav inner join member member on member.id=fav.favorite_member_id where fav.member_id= $memberId  and fav.is_delete=1 $where  order by member.id desc limit $start,$limit ";
    	$result = $this->db->query($sql)->result_array(); 
		
		foreach($result as $k=>$val)
		{
			$result[$k]['membership_plan'] =  $this->db->where('member_id',$val['member_id'])->where('is_active',1)->get('member_buyed_plan')->result_array();
		}
		
		$query['result'] = $result;
		$query['count'] = count($query['result']);
		
		return $query;
	}
	
	public function block_member($data)
	{
		$this->db->insert('block_member',$data);
		return $insert_id = $this->db->insert_id();
	}

	public function getMemberInfo($memberid){
		return $this->db->select('*')->where('id',$memberid)->get('member')->row_array();
	}
	
	public function getBlocklist($id)
	{
		$this->db->select('*');
		$this->db->from('member');
		$this->db->join('block_member','block_member.to_member_id = member.id','left');
		$this->db->where('block_member.from_member_id',$id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function unblock_member($id){
		$this->db->where('to_member_id',$id);
		$this->db->delete('block_member');
		return true;	
	}
	
	function getMemberInterest($id){
		
		$this->db->select('*');
		$this->db->from('member_interest');	
		$this->db->join('interest','interest.id = member_interest.interest_id','left');
		$this->db->where('member_id',$id);
		$result = $this->db->get();
		return $result->result_array();		
	}
	
	function getCheckpaid($id)
	{
		$this->db->select('*');
		$this->db->from('member_buyed_plan');	
		$this->db->where('member_id',$id);
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function valideOldPassword(&$data)
	{	
		$oldpassword = $data['oldpassword'];
		$id =  $this->nsession->userdata('member_session_id');

		$admin_pwd_sql = "SELECT count(*) as CNT FROM member WHERE id ='".$id."' and password ='".md5($oldpassword)."'";

		//echo $admin_pwd_sql; die();

		$recordSet = $this->db->query($admin_pwd_sql);

		$rs = false;		

		if($recordSet->num_rows() > 0)
		{
			$rs = array();
			$isEscapeArr = array();
			$row = $recordSet->row_array();

			if($row['CNT']>0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	function updateAdminPass($id,$data)
	{
		$new_admin_pwd	=	$data['new_admin_pwd'];
		$query = "update member set password = '".md5($new_admin_pwd)."' where id ='".$id."'";
		$rs = $this->db->query($query);
		if($this->db->affected_rows())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function deactiveaccount($id)
	{
		$member_details = $this->db->where('id',$id)->get('member')->result_array();
		$update_data['email'] = isset($member_details[0]['email'])?$member_details[0]['email'].'_del':'';
		$update_data['is_delete'] = 2;
		
		$this->db->where('id',$id)->update('member',$update_data);
	}
	
	function addmemberPhoto($data){
		
	/*	$id = $this->nsession->userdata('member_session_id');		
		$this->db->where('member_id',$id);
		$this->db->delete('member_photo');*/
		
		$this->db->insert_batch('member_photo',$data);
		$result = $this->db->insert_id();
		return $result;
		
	}
	
	function getMemberphoto($member_id){
		
		$this->db->select('*');
		$this->db->from('member_photo');	
		$this->db->where('member_id',$member_id);
		//$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function get_country(){
		
		$this->db->select('*');
		$this->db->from('countries');			
		$this->db->where_not_in('id',231);
		$result = $this->db->get();
		return $result->result_array();
		
	}
	
	function addmemberVideo($data){
		
		/* $id = $this->nsession->userdata('member_session_id');		
		$this->db->where('member_id',$id);
		$this->db->delete('member_photo'); */
		
		$this->db->insert_batch('member_video',$data);
		$result = $this->db->insert_id();
		return $result;
		
	}
	
	function getMembervideo($member_id)
	{
		$this->db->select('*');
		$this->db->from('member_video');	
		$this->db->where('member_id',$member_id);
		//$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function updatefutureMember($member_id,$data){
		$this->db->where('id',$member_id);
		$this->db->update('member',$data);
		return true;
	}

	function updateCurrentMemberData($member_id,$val){
		$data=$this->db->get_where('member_buyed_plan',array('member_id'=>$member_id,'is_active'=>1))->row_array();
		if(count($data) > 0){
            $id=$data['id'];
            $min_remain=$data['minute_remaning'];
            $mupdate=array();
            $mupdate['minute_remaning']=((int)$min_remain + (int)$val);
            $this->db->update('member_buyed_plan',$mupdate,array('id'=>$id));
            return true;
        }else{
            return false;
        }
	}

	function get_daily_maches($memberId,$start=0)
	{
		
		$limit=10;
		if($start > 0)
		{
			$start = $start*$limit;
		}
		 $sql = "select distinct(member_id),member.* from member_interest inner join member on member_interest.member_id=member.id  where interest_id in(select interest_id from member_interest where member_id=$memberId) $where and member_id!= $memberId and (member_id not in( select to_member_id from block_member where from_member_id = $memberId) and member_id not in( select from_member_id  from block_member where to_member_id = $memberId))  order by member.id desc limit $start,$limit ";
		 //echo $sql; die();
		$result = $this->db->query($sql)->result_array(); 
		$narray=array();
		foreach($result as $k=>$val)
		{
			$check=$this->db->select('id')->get_where('my_favorite',array('favorite_member_id'=>$val['member_id'],'member_id'=>$memberId))->num_rows();
			if($check <= 0){
				$narray[$k]=$val;
				$narray[$k]['total_pic']=$this->db->select('id')->get_where('member_photo',array('member_id'=>$val['member_id']))->num_rows();
				$narray[$k]['member_details'] =  $this->db->where('member_id',$val['member_id'])->get('member_more')->result_array();

				$membership_plan=array();
				$membership_plan =  $this->db->where('member_id',$val['member_id'])->where('is_active',1)->get('member_buyed_plan')->row_array();
				$narray[$k]['membership_plan']=$membership_plan;
				$narray[$k]['membership_plan_cnt']=count($membership_plan);

			}
			
		}
		
		$query['result'] = $narray;
		$query['count'] = count($query['result']);
		return $query;
	}
	function get_top_ten_contacts($memberId ,$where='')
	{
		
		 $sql = "select distinct(member_id),member.* from member_interest inner join member on member_interest.member_id=member.id  where interest_id in(select interest_id from member_interest where member_id=$memberId) $where and member_id!= $memberId and (member_id not in( select to_member_id from block_member where from_member_id = $memberId) and member_id not in( select from_member_id  from block_member where to_member_id = $memberId))  order by member.id desc limit 0,10";
		$result = $this->db->query($sql)->result_array(); 
		$query['result'] = $result;
		$query['count'] = count($query['result']);
		return $query;
	}

	function getAllMemberMessage($memberId){
		$memberId = $this->nsession->userdata('member_session_id');
		$query = $this->db->query("SELECT memb.*,mmsg.id as msg_id,mmsg.status,mmsg.subject,(SELECT message FROM member_message WHERE id=MAX(mmsg.id) ) as message,(SELECT created_date FROM member_message WHERE id=MAX(mmsg.id) ) as created_date,COUNT(mmsg.member_id) AS unreadMessage FROM member_message as mmsg JOIN member as memb on memb.id=mmsg.member_id where (mmsg.member_id=$memberId OR mmsg.to_member_id=$memberId) group by mmsg.member_id order by mmsg.id desc limit 0,50 ");
		// $query = $this->db->query("SELECT memb.*,mmsg.id as msg_id,mmsg.status,mmsg.subject,mmsg.message,mmsg.created_date,COUNT(mmsg.member_id) AS unreadMessage FROM (SELECT * FROM member_message order by created_date asc) as mmsg JOIN member as memb on memb.id=mmsg.member_id where (mmsg.member_id=$memberId OR mmsg.to_member_id=$memberId) AND memb.id!=$memberId group by mmsg.member_id limit 0,50 ");
		//echo $this->db->last_query(); die();
		return $query->result_array();
	}
}
