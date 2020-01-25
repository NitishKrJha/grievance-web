<?php

class ModelFlag extends CI_Model {

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
			$sortType    	= $this->nsession->get_param('ADMIN_FLAG','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_FLAG','sortField','flag_id');
			$searchField 	= $this->nsession->get_param('ADMIN_FLAG','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_FLAG','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_FLAG','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_FLAG','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_FLAG','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_FLAG','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_FLAG','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_FLAG','searchDisplay',20);
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

		$this->nsession->set_userdata('ADMIN_FLAG', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(flag_id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('member_flag.*');

		$recordSet = $this->db->get('member_flag');
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
			$this->db->select('member_flag.*,mem1.name as fromName,mem2.name as toName');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
			$this->db->join('member mem1','mem1.id=member_flag.member_id');
        	$this->db->join('member mem2','mem2.id=member_flag.created_by');
			$this->db->order_by('member_flag.flag_id',$sortType);
			$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('member_flag');
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
		$this->db->insert('member_flag',$data);
		return true;
	}

	function editContent($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('member_flag', $data);
		return true;
	}

	function activate($id)
	{
		$sql = "UPDATE member_flag SET assign = '0' WHERE flag_id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}

	function inactive($id)
	{
		$sql = "UPDATE member_flag SET assign = '1' WHERE flag_id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}
	function getsingle_empdata($id){
		
		$this->db->select('member_flag.*,mem1.name as fromName,mem2.name as toName');
		$this->db->from('member_flag');
		$this->db->join('member mem1','mem1.id=member_flag.member_id');
        $this->db->join('member mem2','mem2.id=member_flag.created_by');
		$this->db->where('member_flag.flag_id',$id);
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
				  member_flag
				WHERE
				 flag_id = ".$id."";
		$result = $this->db->query($sql);
		return $result->row_array();
	}
	function checkEmail($email_id){
		$this->db->select('*');
    $this->db->from('member_flag');
    $this->db->where(array('email'=>$email_id,'is_delete'=>0));
    $result =  $this->db->get();
    return $result->result_array();
	}
	function doDeleteMemeber($id){
		$this->db->where('id',$id);
		$this->db->update('member_flag',array('is_delete'=>1));
		return true;
	}
	function detete($id){
		$this->db->where('id',$id);
		$this->db->delete('member_flag');
		return true;
	}
}

?>
