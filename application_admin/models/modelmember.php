<?php

class ModelMember extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

	function getList(&$config,&$start,&$param)
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

		$this->nsession->set_userdata('ADMIN_MEMBER', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(member.id) as TotalrecordCount');
		
		//$this->db->select('member.*');
		
		$this->db->join('member_buyed_plan','member.id=member_buyed_plan.member_id','left');
		$this->db->where('member.member_type','1');
		$this->db->where('member.is_delete','0');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		
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
			
			$this->db->select('member.picture as memberPicture, member.created as createdDate, member.name as MemberName,member.maritial_status as maritialStatus,member.interested_in as interestedIn,member.man_woman as gender,member.is_active as member_active,member.id as memberId,member.email as user_email,member.future_member as futureMember');
			$this->db->from('member');
			// $this->db->join('member_buyed_plan','member.id=member_buyed_plan.member_id','left');
		 	if(isset($sessionDataArray['searchField'])){
				
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
		$this->db->where('member.member_type','1');
		$this->db->where('member.is_delete','0');

		//$this->db->where('member_buyed_plan.is_active',1);
		$this->db->order_by('member.id',$sortType);
		//$this->db->group_by('member.id');
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get();
		//echo $this->db->last_query(); die();
		$rs = false;

		if ($recordSet->num_rows() > 0)
        {
           	$rs = array();
			$isEscapeArr = array();
			foreach ($recordSet->result_array() as $row)
			{
				$p_data=$this->db->select('is_active,id,membership_plan_data')->get_where('member_buyed_plan',array('member_id'=>$row['memberId'],'is_active'=>1))->row_array();
				$row['plan_active']=0;
				$row['buyed_id']=0;
				$row['membership_plan_data']=json_encode(array());
				if(isset($p_data['is_active'])){
					$row['plan_active']=$p_data['is_active'];
					$row['buyed_id']=$p_data['id'];
					$row['membership_plan_data']=$p_data['membership_plan_data'];
				}
				foreach($row as $key=>$val){
					if(!in_array($key,$isEscapeArr)){
							//member_buyed_plan.*,member_buyed_plan.is_active as plan_active,member_buyed_plan.id as buyed_id
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

	function addContent($data)
	{
		$this->db->insert('member',$data);
		return true;
	}

	function editContent($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('member', $data);
		return true;
	}

	function activate($id)	
	{
		//echo "jbb"; die; 
		
		$sql = "UPDATE member SET is_active = '1' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}
	
	function add($id)	
	{
		//echo "jbb"; die; 
		
		$sql = "UPDATE member SET future_member = '2' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}

	function remove($id)
	{
		$sql = "UPDATE member SET future_member = '1' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}
	
	function inactive($id)
	{
		$sql = "UPDATE member SET is_active = '2' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}
	function getsingle_empdata($id){
		$this->db->select('name,email');
		$this->db->from('member');
		$this->db->where('id',$id);
		$data = $this->db->get();
		return $data->row();
	}

	function getMyProfileData($id){

		$this->db->join('member_more','member_more.member_id=member.id','Left Outer');
		$this->db->join('body_type','body_type.id=member_more.body_type','Left Outer');
        $this->db->join('hair_type','hair_type.id=member_more.hair','Left Outer');
        $this->db->join('eye_type','eye_type.id=member_more.eye','Left Outer');
        $this->db->join('ethnicity','ethnicity.id=member_more.ethnicity','Left Outer');
        $this->db->join('faith','faith.id=member_more.faith','Left Outer');
        $this->db->join('language','language.id=member_more.language','Left Outer');
        $this->db->join('countries','countries.id=member_more.country','Left Outer');
        $this->db->join('states','states.id=member_more.state','Left Outer');
        $this->db->join('cities','cities.id=member_more.city','Left Outer');
        $this->db->join('education','education.id=member_more.education','Left Outer');
		$data=$this->db->select('member.*,member_more.*,body_type.type bodyType,hair_type.type hairType,eye_type.type eyeType,ethnicity.ethnicity ethnicityType,faith.faith_name faithType,language.name languageType,countries.name countriesType,states.name statesType,cities.name citiesType,education.name educationType')->get_where('member',array('member.id'=>$id))->row_array();
		//echo $this->db->last_query();
		//pr($data);
		if(count($data) > 0){
			$data['photo']=$this->db->select('id,photo')->get_where('member_photo',array('member_id'=>$data['member_id']))->result_array();
			$data['video']=$this->db->select('id,video')->get_where('member_video',array('member_id'=>$data['member_id']))->result_array();
			$data['member_buyed_plan']=$this->db->select('*')->get_where('member_buyed_plan',array('member_id'=>$data['member_id'],'is_active'=>1))->result_array();
			$this->db->join('interest','interest.id = member_interest.interest_id','left');
			$data['member_interest']=$this->db->select('*')->get_where('member_interest',array('member_id'=>$data['member_id']))->result_array();
			$integerIDs = array_map('intval', explode(',', $data['indoor_activities']));
			$this->db->where_in('id',$integerIDs);
			$indoor_activities_data=$this->db->select('GROUP_CONCAT(activities) as gra')->get_where('indoor_activities',array('is_active'=>1))->row_array();
			$data['indoor_activities_data']=isset($indoor_activities_data['gra'])?$indoor_activities_data['gra']:'';
			$integerIDs=array();
			$integerIDs = array_map('intval', explode(',', $data['outdoor_activities']));
			$this->db->where_in('id',$integerIDs);
			$outdoor_activities_data=$this->db->select('GROUP_CONCAT(activities) as gra')->get_where('outdoor_activities',array('is_active'=>1))->row_array();
			$data['outdoor_activities_data']=isset($outdoor_activities_data['gra'])?$outdoor_activities_data['gra']:'';
			$integerIDs=array();
			$integerIDs = array_map('intval', explode(',', $data['pet']));
			$this->db->where_in('id',$integerIDs);
			$pet_data=$this->db->select('GROUP_CONCAT(pet_name) as gra')->get_where('pet',array('is_active'=>1))->row_array();
			$data['pet_data']=isset($pet_data['gra'])?$pet_data['gra']:'';
			$integerIDs=array();
			$integerIDs = array_map('intval', explode(',', $data['vacation_place']));
			$this->db->where_in('id',$integerIDs);
			$vacation_place_data=$this->db->select('GROUP_CONCAT(name) as gra')->get_where('vacation_place',array('is_active'=>1))->row_array();
			$data['vacation_place_data']=isset($vacation_place_data['gra'])?$vacation_place_data['gra']:'';
		}
		return $data;
	}

	function getSingle($id){
		$sql = "SELECT
				 *
				FROM
				  member
				WHERE
				 id = ".$id."";
		$result = $this->db->query($sql);
		return $result->row_array();
	}
	function checkEmail($email_id){
		$this->db->select('*');
    $this->db->from('member');
    $this->db->where(array('email'=>$email_id,'is_delete'=>0));
    $result =  $this->db->get();
    return $result->result_array();
	}
	function doDeleteMemeber($id){
		$this->db->where('id',$id);
		$this->db->update('member',array('is_delete'=>1));
		return true;
	}
	function DeleteMemeber($id)
	{
		$user_details  = $this->db->where('id',$id)->get('member')->result_array();
		$email = isset($user_details[0]['email'])?$user_details[0]['email'].'_del':'';
		$this->db->where('id',$id);
		$this->db->update('member',array('is_delete'=>2,'email'=>$email));
		return true;
	}
	function checkUsername($username){
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where('username',$username);
		return $this->db->get()->result_array();
	}
	
	function update_url($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('member',$data);
		/* $affected_rows =$this->db->affected_rows();
		if($affected_rows)
		{
			return $affected_rows;
		}
		else
		{
			return false;
		} */
	}
	
	function get_member_details($member_id)
	{
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where('id',$member_id);
		return $this->db->get()->result_array();
	}

	function insertData($tbl_name,$data){
		$result=$this->db->insert($tbl_name,$data);
		return $this->db->insert_id();
	}

	function updateData($tbl_name,$data,$check){
		$result=$this->db->update($tbl_name,$data,$check);
		return true;
	}

	function delData($tbl_name,$where){
		return $this->db->delete($tbl_name,$where);
	}

	function getSingleData($tbl_name,$where){
		return $this->db->get_where($tbl_name,$where)->row_array();
	}
	function getAllDatalist($tbl_name,$where){
		return $this->db->get_where($tbl_name,$where)->result_array();
	}
}

?>
