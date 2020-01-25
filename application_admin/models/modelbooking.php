<?php

class ModelBooking extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

	function getList(&$config,&$start,&$param)
	{
       // echo "hi"; die;
		
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
			$sortField   	= $this->nsession->get_param('ADMIN_MEMBER','sortField','booking_id');
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
		$this->db->select('COUNT(booking_id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('counselor_booking.*');

		$recordSet = $this->db->get('counselor_booking');
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
			$this->db->select('counselor_booking.timezone,counselor_booking.booking_id,mem1.name as memberName,mem2.name as counselorName,counselor_booking.booking_date,counselor_booking.assign');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
		$this->db->join('member mem1','mem1.id=counselor_booking.member_id');
        $this->db->join('member mem2','mem2.id=counselor_booking.counselor_id');
		$this->db->order_by('counselor_booking.booking_id',$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('counselor_booking');
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

	function addContent($data)
	{
		$this->db->insert('tips',$data);
		return true;
	}

	function editContent($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('tips', $data);
		return true;
	}

	function activate($id)
	{
		$sql = "UPDATE counselor_booking SET assign = '0' WHERE booking_id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}

	function inactive($id)
	{
		$sql = "UPDATE counselor_booking SET assign = '1' WHERE booking_id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}
	function getsingle_empdata($id){
		
		$this->db->select('*,mem1.email as member_email,mem1.name as memberName,mem2.name as counselorName,mem2.email as counselorEmail');
		$this->db->from('counselor_booking');
		$this->db->join('member mem1','mem1.id=counselor_booking.member_id');
        $this->db->join('member mem2','mem2.id=counselor_booking.counselor_id');
		$this->db->where('counselor_booking.booking_id',$id);
		$data = $this->db->get();
		return $data->result_array();

	}

	function insertData($tbl_name,$data,$where=array()){
		if(!empty($where) && count($where) > 0){
			return $this->db->update($tbl_name,$data,$where);
		}else{
			return $this->db->insert($tbl_name,$data);
		}
	}

	function getSingle($id){
		$sql = "SELECT
				 *
				FROM
				  tips
				WHERE
				 id = ".$id."";
		$result = $this->db->query($sql);
		return $result->row_array();
	}
	function checkEmail($email_id){
		$this->db->select('*');
    $this->db->from('tips');
    $this->db->where(array('email'=>$email_id,'is_delete'=>0));
    $result =  $this->db->get();
    return $result->result_array();
	}
	function doDeleteMemeber($id){
		$this->db->where('id',$id);
		$this->db->update('tips',array('is_delete'=>1));
		return true;
	}
	function detete($id){
		$this->db->where('id',$id);
		$this->db->delete('tips');
		return true;
	}
}

?>
