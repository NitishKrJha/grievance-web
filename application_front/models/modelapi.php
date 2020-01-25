<?php

class ModelApi extends CI_Model{



    function __construct()
    {
        parent::__construct();
    }

    function authenticateUser($data)
    {
        $this->email   		= $data->email;
        $this->password 	=  $data->password;
        $this->member_type 	=  $data->member_type;
        $this->db->select('*,countries.id as country_id,countries.name as country_name,states.id as state_id, states.name as state_name,cities.id as city_id,cities.name as city_name,body_type.id as body_type_id,body_type.type as body_type_name,hair_type.id as hair_type_id,hair_type.type as hair_type_name,eye_type.id as eye_type_id,eye_type.type as eye_type_name,ethnicity.id as ethnicity_id,ethnicity.ethnicity as ethnicity_name,faith.id as faith_id,faith.faith_name as faithName,language.id as language_id,language.name as language_name,education.id as education_id,education.name as education_name,member.id as member_id,member.name as member_name,member.man_woman as man_woman');
		
        $this->db->from('member');
        $this->db->join('member_more','member_more.member_id = member.id','left');
        $this->db->join('countries','countries.id = member.country','left');
        $this->db->join('states','states.id = member.state','left');
        $this->db->join('cities','cities.id = member.city','left');
        $this->db->join('body_type','body_type.id = member_more.body_type','left'); 
        $this->db->join('hair_type','hair_type.id = member_more.hair','left'); 
        $this->db->join('eye_type','eye_type.id = member_more.eye','left'); 
        $this->db->join('ethnicity','ethnicity.id = member_more.ethnicity','left'); 
        $this->db->join('faith','faith.id = member_more.faith','left'); 
        $this->db->join('language','language.id = member_more.language','left'); 
        $this->db->join('education','education.id = member_more.education','left'); 
        $this->db->join('indoor_activities','indoor_activities.id = member_more.indoor_activities','left'); 
        $this->db->join('outdoor_activities','outdoor_activities.id = member_more.outdoor_activities','left'); 
        $this->db->join('vacation_place','vacation_place.id = member_more.vacation_place','left'); 
        $this->db->where('member.password',md5($this->password));
        $this->db->where('member.member_type',$this->member_type);
        $this->db->where('member.is_active',1);
        $this->db->where('member.email',$this->email);
        $this->db->or_where('member.username',$this->email);
        $rs = $this->db->get('');
		$login='';
        if ($rs->num_rows() >0 )
        {
            $row = $rs->row();
            $login = true;
        }
        if($login == true){

            return array('member_id'=>$row->member_id,'member_type'=>$row->member_type,'email'=>$row->email,'member_name'=>$row->member_name,'success_step'=>$row->success_step,'otp_varification'=>$row->otp_varification,'created'=>$row->created,'profile_heading'=>$row->profile_heading,'picture'=>$row->picture,'cover_image'=>$row->cover_image,'username'=>$row->username,'age'=>$row->age,'country_id'=>$row->country_id,'country_name'=>$row->country_name,'state_id'=>$row->state_id,'state_name'=>$row->state_name,'city_id'=>$row->city_id,'city_name'=>$row->city_name,'zip'=>$row->zip,'lifestyle'=>$row->lifestyle,'describe_looking_for'=>$row->describe_looking_for,'created'=>$row->created,'profile_step'=>$row->profile_step,'height'=>$row->height,'body_type_id'=>$row->body_type_id,'body_type_name'=>$row->body_type_name,'hair_type_id'=>$row->hair_type_id,'hair_type_name'=>$row->hair_type_name,'eye_type_id'=>$row->eye_type_id,'eye_type_name'=>$row->eye_type_name,'smoking'=>$row->smoking,'smoking_type'=>array('Non Smoker'=>1,'Light Smoker'=>2,'High Smoker'=>3),'drinking'=>$row->drinking,'drinking_type'=>array('Non-Drinker'=>1,'Social-Drinker'=>2,'Heavy-Drinker'=>3),'occupation'=>$row->occupation,'income'=>$row->income,'have_kids'=>$row->have_kids,'want_kids'=>$row->want_kids,'ethnicity_id'=>$row->ethnicity_id,'ethnicity_name'=>$row->ethnicity_name,'faith_id'=>$row->faith_id,'faithName'=>$row->faithName,'language_id'=>$row->language_id,'language_name'=>$row->language_name,'education_id'=>$row->education_id,'education_name'=>$row->education_name,'pet'=>$row->pet,'sign'=>$row->sign,'politics_view'=>$row->politics_view,'about_me'=>$row->about_me,'indoor_activities'=>$row->indoor_activities,'outdoor_activities'=>$row->outdoor_activities,'vacation_place'=>$row->vacation_place,'man_woman'=>$row->man_woman,'gender_type'=>array('male'=>1,'female'=>2),);
        }else{

            return array();
        }
    }

    function authenticateCounselor($email,$password){
    	$data=$this->db->select('*')->get_where('member',array('email'=>$email,'password'=>md5($password),'member_type'=>2,'is_active'=>1))->row_array();
    	if(count($data) > 0){
    		$data['member_id']=$data['id'];
    		$data['available_date']=$this->db->select('avalable_date')->get_where('counselor_avalable',array('counselor_id'=>$data['id']))->result_array();
    		$this->db->join('member','member.id=counselor_booking.member_id','Left outer');
    		$data['Booked']=$this->db->select('counselor_booking.booking_date,counselor_booking.member_id,member.name,member.phone_no,member.email')->get_where('counselor_booking',array('counselor_booking.counselor_id'=>$data['id']))->result_array();
    		$data['certificate']=$this->db->select('certificate,id')->get_where('counselor_certificates',array('member_id'=>$data['id']))->result_array();
    	}
    	return $data;
    }

    function getCounselorData($counselor_id){
    	$data=$this->db->select('*')->get_where('member',array('id'=>$counselor_id,'member_type'=>2))->row_array();
    	if(count($data) > 0){
    		$data['member_id']=$data['id'];
    		$available_date=$this->db->select('*')->get_where('counselor_avalable',array('counselor_id'=>$data['id']))->result_array();
    		$this->db->join('member','member.id=counselor_booking.member_id','Left outer');
			foreach($available_date as $k=>$val)
			{
				$available_date[$k]['start_time'] = date('h:i:s a',strtotime($val['start_time']));
				$available_date[$k]['end_time'] = date('h:i:s a',strtotime($val['end_time']));
			}
			$data['available_date'] = $available_date;
    		$data['Booked']=$this->db->select('counselor_booking.booking_date,counselor_booking.member_id,member.name,member.phone_no,member.email')->get_where('counselor_booking',array('counselor_booking.counselor_id'=>$data['id']))->result_array();
    		$data['certificate']=$this->db->select('certificate,id')->get_where('counselor_certificates',array('member_id'=>$data['id']))->result_array();
    	}
    	return $data;
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

	public function updateData($tbl_name,$data,$where){
        $result=$this->db->update($tbl_name,$data,$where);
        if($result > 0){
            return true;
        }else{
            return false;
        }
    }

    function insertData($tbl_name,$data){
		$result=$this->db->insert($tbl_name,$data);
		return $this->db->insert_id();
	}

    function delData($tbl_name,$where){
		return $this->db->delete($tbl_name,$where);
	}

	function getSingleData($tbl_name,$where){
		return $this->db->get_where($tbl_name,$where)->row_array();
	}

	function getMultipleData($tbl_name,$where){
		return $this->db->get_where($tbl_name,$where)->result_array();
	}

    function addcertificate($data)
	{		
		$this->db->insert_batch('counselor_certificates',$data);
		$result = $this->db->insert_id();
		return $result;
	}
	
	
	function checkEmail($email_id){
		$sql = "SELECT * FROM member WHERE email='".$email_id."'";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	
	function inserttokenforpassword($email){
		$token=$this->getToken(20);
		$this->db->update('member',array('forgetpass'=>$token),array('email'=>$email));
		return $token;

	}
	
	function getToken($length)
	{
	    $token = "";
	    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
	    $codeAlphabet.= "0123456789";
	   $max = strlen($codeAlphabet); 

	    for ($i=0; $i < $length; $i++) {
	        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
	    }

	    return $token;
	}
	
    function getalltips($page){		
		 $limit = 10;
		  if($page > 0)
		  {
		   $page = ($page * $limit);
		  }
		$this->db->select('*,tips.id as tips_id');
		$this->db->from('tips');
		$this->db->join('tips_category','tips_category.id = tips.category_id','left');
		$this->db->order_by('tips.id', 'desc');
		$this->db->limit($limit, $page);
		$query = $this->db->get();		
		$jbb = $query->result_array();	 				
		return $jbb;
	}
	
	function gettipsdetails($id){
		
		$this->db->select('tips.*,tips_category.title as cat_name');
		$this->db->from('tips');
		$this->db->join('tips_category','tips_category.id = tips.category_id','left');
		$this->db->where('tips.id',$id);
		$result = $this->db->get();
		return $result->row_array();
	}
	
	function memberReg($data){
		$this->db->insert('member',$data);
		return $insert_id = $this->db->insert_id();
	}
	
	function checkotp($data){
		
		$email   		= $data->email;
		$otp   		= $data->otp;
		
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where('email',$email);
		$this->db->where('otp',$otp);
		$result = $this->db->get();
		return $result->row_array();
	}
	
	function doSaveProfileData($memberId,$data){
        $this->db->where('id',$memberId);
        if(isset($data['PHPSESSID'])){
        	unset($data['PHPSESSID']);
        }
        $this->db->update('member',$data);
        return true;
    }
	
	function mymatch($data,$page){
		$interest_id = $this->db->get_where('member_interest',array('member_id'=>$data->id))->result_array();
		 //echo $this->db->last_query(); die();
		$block_id = $this->db->get_where('block_member',array('from_member_id'=>$data->id))->result_array();	
		if(count($interest_id) <= 0){
			return array();
		}else{
		  $limit = 10;
		  if($page > 0)
		  {
		   $page = ($page * $limit);
		  }
		
			$this->db->select('member.*,countries.id as country_id,countries.name as country_name,states.id as state_id, states.name as state_name,cities.id as city_id,cities.name as city_name,member_interest.id as interest_id');	
			
			$this->db->from('member');
						
			$this->db->join('countries','countries.id = member.country','left');
			$this->db->join('states','states.id = member.state','left');
			$this->db->join('cities','cities.id = member.city','left');
			
			$this->db->join('member_interest','member_interest.member_id = member.id','left');
			
			foreach($interest_id as $member_interest){
				
			    $interest = $member_interest['interest_id']; 			 
				$this->db->or_where('member_interest.interest_id',$interest);
				$this->db->where_not_in('member.id',$data->id);
				
				 foreach($block_id as $blocked_member){
			 
					  $blocked_member_id = $blocked_member['to_member_id'];
					  $this->db->where_not_in('member.id',$blocked_member_id);
				 }
				 
				if(isset($data->loking_for)&& $data->loking_for!=''){
			
					$this->db->where('member.man_woman',$data->loking_for);
				
				} 
				
				
				$this->db->group_by('member.id');			
			//$this->db->where_not_in('member.id',$data->id);
			
			//$this->db->where_in('member.id',$data->id, FALSE);
       
			//$this->db->order_by('total', 'desc');
			//$this->db->where('member.member_type','1');
			
			if(isset($data->country)&& $data->country!=''){
			
				$this->db->where('member.country',$data->country);
			}
			
			if(isset($data->state)&& $data->state!=''){
			
				$this->db->where('member.state',$data->state);
			}
			
			if(isset($data->city)&& $data->city!=''){
			
				$this->db->where('member.city',$data->city);
			}
						
			
																							
			if((isset($data->age_from)&& $data->age_from !='') && (isset($data->age_to)&& $data->age_to !='')){
				$this->db->where('age >=', $data->age_from);
				$this->db->where('age <=', $data->age_to);
			}
			
			$this->db->limit($limit, $page);
				
				
			} 
			
			
			
			
			
			$result = $this->db->get();
			return $result->result_array();
		}
		  
		
	}
	
	function mymatchDetails($id){
		
		$this->db->select('*');
		$this->db->from('member');
		$this->db->join('member_more','member_more.member_id = member.id','left');
		$this->db->where('member.id',$id);
		$result = $this->db->get();
		return $result->row();
		
	}
	
	function success_varify($otp)
	{
		$sql = "UPDATE member SET otp_varification = '1' WHERE otp = ".$otp."";	
		$recordSet = $this->db->query($sql);
		
		if (!$recordSet )
		{
			return false;
		}
	}
	
	function resetpassword($data){
		
		$sql = "UPDATE member SET password ='".md5($data->password)."' WHERE id = ".$data->id."";	
		$recordSet = $this->db->query($sql);
		
		if (!$recordSet)
		{
			return false;
		}
	}
	
	function resentotp($otp,$email){
		
		$sql = "UPDATE member SET otp =".$otp." WHERE email = '".$email."'";	
		$recordSet = $this->db->query($sql);
		
		if (!$recordSet)
		{
			return false;
		}
	}
	
	function search($data,$page){
		
		 $limit = 10;
		  if($page > 0)
		  {
		   $page = ($page * $limit);
		  }
		
			$this->db->select('member.*,member_more.*,countries.id as country_id,countries.name as country_name,states.id as state_id, states.name as state_name,cities.id as city_id,cities.name as city_name');	
			$this->db->from('member');
			$this->db->join('member_more','member_more.member_id = member.id');
			$this->db->join('countries','countries.id = member.country','left');
			$this->db->join('states','states.id = member.state','left');
			$this->db->join('cities','cities.id = member.city','left');
			$this->db->where('member.member_type','1');
			
			if(isset($data->country)&& $data->country!=''){
			
				$this->db->where('member.country',$data->country);
			}
			if((isset($data->age_from)&& $data->age_from !='') && (isset($data->age_to)&& $data->age_to !='')){
				$this->db->where('age >=', $data->age_from);
				$this->db->where('age <=', $data->age_to);
			}
			
			if(isset($data->loking_for)&& $data->loking_for!=''){
			
				$this->db->where('member.interested_in',$data->loking_for);
			}
			if(isset($data->zip)&& $data->zip!=''){
			
				$this->db->where('member.zip',$data->zip);
			}
			
			if(isset($data->language)&& $data->language!=''){
				
				$this->db->where('member_more.language',$data->language);				
			}
			
			if(isset($data->education)&& $data->education!=''){   
				
				$this->db->where('member_more.education',$data->education);				
			}
			
			if(isset($data->have_kids)&& $data->have_kids!=''){   
				
				$this->db->where('member_more.have_kids',$data->have_kids);				
			}
			
			if(isset($data->smoking)&& $data->smoking!=''){   
				
				$this->db->where('member_more.smoking',$data->smoking);				
			}
			
			if(isset($data->drinking)&& $data->drinking!=''){   
				
				$this->db->where('member_more.drinking',$data->drinking);				
			}
			
			if(isset($data->height)&& $data->height!=''){   
				
				$this->db->where('member_more.height',$data->height);				
			}
			
			if(isset($data->body_type)&& $data->body_type!=''){   
				
				$this->db->where('member_more.body_type',$data->body_type);				
			}
			
			if(isset($data->eye)&& $data->eye!=''){   
				
				$this->db->where('member_more.eye',$data->eye);				
			}
			
			if(isset($data->hair)&& $data->hair!=''){   
				
				$this->db->where('member_more.hair',$data->hair);				
			}
			$this->db->limit($limit, $page);
			$result = $this->db->get();
			return $result->result_array();
	}
	
	function getallcounselor($page,$data){
		
		$limit = 10;
		  if($page > 0)
		  {
		   $page = ($page * $limit);
		  }	
		  
		$this->db->select('member.*,member.id as member_id,member.name as member_name,countries.id as country_id,countries.name as country_name,states.id as state_id,states.name as state_name,cities.id as city_id,cities.name as city_name');
		//$this->db->select('*');
		$this->db->from('member');
		$this->db->join('countries','countries.id = member.country','left');
		$this->db->join('states','states.id = member.state','left');
		$this->db->join('cities','cities.id = member.city','left');
		if(isset($data->country)&& $data->country!=''){			
			//$country_sql = 'member.name as member_name,countries.id as country_id,countries.name as country_name';
			//$this->db->select('member.*,"'.$country_sql.'"');			
			$this->db->where('member.country',$data->country);
		}		
		if(isset($data->state)&& $data->state!=''){			
			$this->db->where('member.state',$data->state);
		}
		
		if(isset($data->city)&& $data->city!=''){			
			$this->db->where('member.city',$data->city);
		}
		
		if(isset($data->zip)&& $data->zip!=''){			
			$this->db->where('member.zip',$data->zip);
		}		
		$this->db->where('member.member_type',2);
		$this->db->limit($limit, $page);
		$query = $this->db->get();
		$result =  $query->result_array();
		
		foreach($result as $k=>$val)
		{
			 if($val['member_id']!=''){
				
				$result[$k]['certificate'] = $this->db->get_where('counselor_certificates',array('member_id'=>$val['member_id']))->result_array();				
				$result[$k]['Booked'] = $this->db->get_where('counselor_booking',array('counselor_id'=>$val['member_id'],'member_id'=>$data->id))->result_array();
				
			} 
			
			
		} 
		
		return $result;
	}
	
	function getallcountry()
	{
		$this->db->select('*');
		$this->db->from('countries');
		$result = $this->db->get();
		return $result->result_array();		
	}
	
	function getstate($id)
	{		
		$this->db->select('*');
		$this->db->from('states');
		$this->db->where('country_id',$id);
		$result = $this->db->get();
		return $result->result_array();		
	}
	
	function getcity($id)
	{
		$this->db->select('*');
		$this->db->from('cities');
		$this->db->where('state_id',$id);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function getallethnicity()
	{
		$this->db->select('*');
		$this->db->from('ethnicity');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function getallfaith()
	{
		$this->db->select('*');
		$this->db->from('faith');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function getalllanguage()
	{
		$this->db->select('*');
		$this->db->from('language');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function getalleducation()
	{
		$this->db->select('*');
		$this->db->from('education');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
		
	function getalleyetype()
	{		
		$this->db->select('*');
		$this->db->from('eye_type');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function getallhairtype()
	{
		$this->db->select('*');
		$this->db->from('hair_type');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function getAllOutdoorActivities()
	{
		$this->db->select('*');
		$this->db->from('outdoor_activities');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function getAllIndoorActivities()
	{
		$this->db->select('*');
		$this->db->from('indoor_activities');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function getAllVacationPlace()
	{
		$this->db->select('*');
		$this->db->from('vacation_place');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function getAllBodyType()
	{
		$this->db->select('*');
		$this->db->from('body_type');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function doSaveAppearanceData($member_id,$memberData,$memberMoreData){
		
		//pr($memberMoreData);
		
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
	
	function getallpet()
	{
		$this->db->select('*');
		$this->db->from('pet');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
	function block_member($data,$request)
	{
		$block_id = $this->db->get_where('block_member',array('from_member_id'=>$request->id,'to_member_id'=>$request->to_member_id))->result_array();
		
		if($block_id){
			$this->db->where('to_member_id',$request->to_member_id);
			$this->db->delete('block_member');
			return true;
		}else{
			
			$this->db->insert('block_member',$data);
		   return $insert_id = $this->db->insert_id();
		}				
	}
	
	function getBlocklist($id)
	{
		$this->db->select('*');
		$this->db->from('member');
		$this->db->join('block_member','block_member.to_member_id = member.id','left');
		$this->db->where('block_member.from_member_id',$id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function insert_interest($data,$member_id){
		
		$this->db->where('member_id',$member_id);
		$this->db->delete('member_interest');		
		$this->db->insert_batch('member_interest',$data);
		return $insert_id = $this->db->insert_id();
	}
	
	function getallinterest()
	{
		$this->db->select('*');
		$this->db->from('interest');
		$this->db->where('is_active',1);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function getmyprofile($memberId,$type){
		$this->db->select('member.*,member_more.*,countries.id as country_id,countries.name as country_name,states.id as state_id, states.name as state_name,cities.id as city_id,cities.name as city_name,body_type.id as body_type_id,body_type.type as body_type_name,hair_type.id as hair_type_id,hair_type.type as hair_type_name,eye_type.id as eye_type_id,eye_type.type as eye_type_name,ethnicity.id as ethnicity_id,ethnicity.ethnicity as ethnicity_name,faith.id as faith_id,faith.faith_name as faithName,language.id as language_id,language.name as language_name,education.id as education_id,education.name as education_name,member.id as member_id,member.name as member_name');
		
		$this->db->from('member');
        $this->db->join('member_more','member_more.member_id = member.id','left');
        $this->db->join('countries','countries.id = member.country','left');
        $this->db->join('states','states.id = member.state','left');
        $this->db->join('cities','cities.id = member.city','left');
        $this->db->join('body_type','body_type.id = member_more.body_type','left'); 
        $this->db->join('hair_type','hair_type.id = member_more.hair','left'); 
        $this->db->join('eye_type','eye_type.id = member_more.eye','left'); 
        $this->db->join('ethnicity','ethnicity.id = member_more.ethnicity','left'); 
        $this->db->join('faith','faith.id = member_more.faith','left'); 
        $this->db->join('language','language.id = member_more.language','left'); 
        $this->db->join('education','education.id = member_more.education','left'); 
        $this->db->join('indoor_activities','indoor_activities.id = member_more.indoor_activities','left'); 
        $this->db->join('outdoor_activities','outdoor_activities.id = member_more.outdoor_activities','left'); 
        $this->db->join('vacation_place','vacation_place.id = member_more.vacation_place','left'); 
       
		//$this->db->join('member_interest','member_interest.member_id = member.id','left'); 
		
		//$this->db->join('interest','interest.id = member_interest.interest_id','left'); 
		
		$this->db->where('member.id',$memberId);
		$this->db->where('member.member_type',$type);
		$this->db->where('member.is_active',1);
		
		/* $result = $this->db->get();
		return $result->result_array();	 */
		
		$query = $this->db->get();
		$result =  $query->result_array();
		
		$paidmember = $this->db->get_where('member_buyed_plan',array('member_id'=>$memberId,'is_active'=>1))->result_array();
		
		//pr($paidmember);
		
		if($paidmember){
			
			$result[0]['paidmember'] =1;
		}else{
			
			$result[0]['paidmember'] =0;
		}
		
		$result[0]['member_photo'] = $this->db->get_where('member_photo',array('member_id'=>$memberId))->result_array();

		$result[0]['member_video'] = $this->db->get_where('member_video',array('member_id'=>$memberId))->result_array();
		
		
		
		return $result;
	}
	
	function getmemberinterest($id)	
	{
		$this->db->select('interest.id as interest_id,interest.name as interest_name');
		$this->db->from('interest');
		$this->db->join('member_interest','member_interest.interest_id = interest.id','left');
		$this->db->where('member_interest.member_id',$id);
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function gettipscategory()
	{
		$this->db->select('*');
		$this->db->from('tips_category');
		$this->db->where('is_active',1);
		$this->db->where('parent',0);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function getTipssubcategory($id){
		
		$this->db->select('*');
		$this->db->from('tips_category');
		$this->db->where('is_active',1);
		$this->db->where('parent',$id);
		$result = $this->db->get();
		return $result->result_array();	
	}
	
	function checkfavarite($id,$favarite_id)
	{
		$this->db->select('*');
		$this->db->from('my_favorite');
		$this->db->where('member_id',$id);		
		$this->db->where('favorite_member_id',$favarite_id);		
		$result = $this->db->get();
		return $result->result_array();	
	}

	function insertfavorite($data){
		$this->db->insert('my_favorite',$data);
		return $insert_id = $this->db->insert_id();
	}
	
	function updatefavorite($id,$favarite_id,$data){
		$this->db->where('member_id',$id);
		$this->db->where('favorite_member_id',$favarite_id);
		$this->db->update('my_favorite',$data);
		return true;
    }
	
	function getfavoritelist($id){
		
		$this->db->select('*,member.id as member_id');
		$this->db->from('member');
		$this->db->join('my_favorite','my_favorite.favorite_member_id = member.id','left');
		$this->db->where('my_favorite.member_id',$id);				
		$this->db->where('my_favorite.is_delete',1);				
		$result = $this->db->get();
		return $result->result_array();	
		
	}
	
	function bookingcheck($member_id,$counselor_id,$booking_date){
				
		$checkdate = date('Y-m-d',strtotime($booking_date));
		
		$this->db->select('*');
        $this->db->from('counselor_booking');
        $this->db->where('member_id',$member_id);
        $this->db->where('counselor_id',$counselor_id);
        $this->db->where('created_date',$checkdate);
        return $this->db->get()->result_array();
	}
	
	function booking_counselor($data){
		$data['created_date'] = date('Y-m-d',strtotime($data['booking_date']));		
		$this->db->insert('counselor_booking',$data);
		return $insert_id = $this->db->insert_id();
	}
	
	function savePaymentData($memberPayDetails){
	    $this->db->insert('member_buyed_plan',$memberPayDetails);
	    return true;
    }
	
	function searchfavorite($data,$page)
	{
		  $limit = 10;
		  if($page > 0)
		  {
		    $page = ($page * $limit);
		  }
		
		$this->db->select('member.*,member.id as member_id,countries.id as country_id,countries.name as country_name');	
		
		$this->db->from('member');
		$this->db->join('member_more','member_more.member_id = member.id');
		$this->db->join('my_favorite','my_favorite.favorite_member_id = member.id','left');
		$this->db->join('countries','countries.id = member.country','left');
		if(isset($data->country)&& $data->country!=''){			
				$this->db->where('member.country',$data->country);
		}
		
		if((isset($data->age_from)&& $data->age_from !='') && (isset($data->age_to)&& $data->age_to !='')){
				$this->db->where('age >=', $data->age_from);
				$this->db->where('age <=', $data->age_to);
		}
		
		if(isset($data->loking_for)&& $data->loking_for!=''){			
				$this->db->where('member.man_woman',$data->loking_for);
		}
		
		$this->db->where('my_favorite.member_id',$data->id);				
		$this->db->where('my_favorite.is_delete',1);
		$this->db->limit($limit, $page);
		$result = $this->db->get();
		return $result->result_array();
		
		
	}
	
	function searchtips($data,$page){
			
		 $limit = 10;
		  if($page > 0)
		  {
		   $page = ($page * $limit);
		  }
		$this->db->select('*,tips.id as tips_id');
		$this->db->from('tips');
		$this->db->join('tips_category','tips_category.id = tips.category_id','left');
		
		if(isset($data->category_id)&& $data->category_id!=''){			
				$this->db->where('tips.category_id',$data->category_id);
		}		
		if(isset($data->sub_category_id)&& $data->sub_category_id!=''){			
				$this->db->where('tips.sub_category_id',$data->sub_category_id);
		}			
		$this->db->order_by('tips.id', 'desc');
		$this->db->limit($limit, $page);
		$query = $this->db->get();
		$result =  $query->result_array();
		foreach($result as $k=>$val)
		{
			if($val['icon']!=''){
			$result[$k]['tips_image'] = file_upload_base_url().'tips_image/' .$val['icon'];
			}
		}
		return $result;
	}
	
	function addmemberPhoto($id,$data){
		
		/* $this->db->where('member_id',$id);
		$this->db->delete('member_photo'); */
		
		$this->db->insert_batch('member_photo',$data);
		$result = $this->db->insert_id();
		return $result;
		
	}

	function addmemberVideo($id,$data){
		
		/* $this->db->where('member_id',$id);
		$this->db->delete('member_photo'); */
		
		$this->db->insert_batch('member_video',$data);
		$result = $this->db->insert_id();
		return $result;
		
	}
	
	function deactiveaccount($id)
	{
		$sql = "UPDATE member SET is_active = '0' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);
		return true;
		if (!$recordSet )
		{
			return false;
		}
	}
	// daily matches 
	function daily_matches($memberId,$start=0)
	{
		$limit=10;
		if($start > 0)
		{
			$start = $start*$limit;
		}
		 $sql = "select distinct(member_id),member.* from member_interest inner join member on member_interest.member_id=member.id  where interest_id in(select interest_id from member_interest where member_id=$memberId) $where and member_id!= $memberId and (member_id not in( select to_member_id from block_member where from_member_id = $memberId) and member_id not in( select from_member_id  from block_member where to_member_id = $memberId))  order by member.id desc ";
		$result = $this->db->query($sql)->result_array(); 
		foreach($result as $k=>$val)
		{
			$city_name = $this->db->where('id',$val['city'])->get('cities')->result_array();
			$state_name = $this->db->where('id',$val['state'])->get('states')->result_array();
			$country_name = $this->db->where('id',$val['country'])->get('countries')->result_array();
			$result[$k]['member_details'] =  $this->db->where('member_id',$val['member_id'])->get('member_more')->result_array();
			$result[$k]['city_name'] =  isset($city_name[0]['name'])?$city_name[0]['name']:'-';
			$result[$k]['state_name'] =  isset($state_name[0]['name'])?$state_name[0]['name']:'-';
			$result[$k]['country_name'] =  isset($country_name[0]['name'])?$country_name[0]['name']:'-';
		}
		return $result;
	}
	// recent matches 
	function recent_matches($memberId)
	{
		$sql = "select distinct(member_id),member.* from member_interest inner join member on member_interest.member_id=member.id  where interest_id in(select interest_id from member_interest where member_id=$memberId) $where and member_id!= $memberId and (member_id not in( select to_member_id from block_member where from_member_id = $memberId) and member_id not in( select from_member_id  from block_member where to_member_id = $memberId))  order by member.id desc limit 0,5 ";
		$result = $this->db->query($sql)->result_array(); 
		foreach($result as $k=>$val)
		{
			$city_name = $this->db->where('id',$val['city'])->get('cities')->result_array();
			$state_name = $this->db->where('id',$val['state'])->get('states')->result_array();
			$country_name = $this->db->where('id',$val['country'])->get('countries')->result_array();
			$result[$k]['member_details'] =  $this->db->where('member_id',$val['member_id'])->get('member_more')->result_array();
			$result[$k]['city_name'] =  isset($city_name[0]['name'])?$city_name[0]['name']:'-';
			$result[$k]['state_name'] =  isset($state_name[0]['name'])?$state_name[0]['name']:'-';
			$result[$k]['country_name'] =  isset($country_name[0]['name'])?$country_name[0]['name']:'-';
		}
		return $result;
	}
	
	//member photo details 
	public function photo_details($photo_id)
	{
		$photo_details = $this->db->where('id',$photo_id)->get('member_photo')->result_array();
		return $photo_details;
	}
    // check counciler available date
	public function check_counciler_available_date($counselor_id,$add_date,$start_time,$end_time)
	{
		
		$this->db->select('*');
        $this->db->from('counselor_avalable');      
        $this->db->where('counselor_id',$counselor_id);
        $this->db->where('avalable_date',$add_date);
		$this->db->where("start_time  BETWEEN 	 '$start_time' AND '$end_time'");
		$this->db->or_where("end_time BETWEEN 	'$start_time' AND '$end_time'");
        return $this->db->get()->result_array();
	}
}