<?php

class ModelActivities extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

	function getindoorList(&$config,&$start,&$param)
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
			$sortType    	= $this->nsession->get_param('ADMIN_INDOOR','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_INDOOR','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_INDOOR','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_INDOOR','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_INDOOR','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_INDOOR','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_INDOOR','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_INDOOR','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_INDOOR','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_INDOOR','searchDisplay',20);
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

		$this->nsession->set_userdata('ADMIN_INDOOR', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('indoor_activities.*');

		$recordSet = $this->db->get('indoor_activities');
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
			$this->db->select('indoor_activities.*');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('indoor_activities');
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

	function addindoorContent($data)
	{
		$this->db->insert('indoor_activities',$data);
		return true;
	}

	function editindoorContent($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('indoor_activities', $data);
		return true;
	}

	function indooractivate($id)
	{
		$sql = "UPDATE indoor_activities SET is_active = '1' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}

	function indoorinactive($id)
	{
		$sql = "UPDATE indoor_activities SET is_active = '2' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}
	function getindoorSingle($id){
		$sql = "SELECT
				 *
				FROM
				  indoor_activities
				WHERE
				 id = ".$id."";
		$result = $this->db->query($sql);
		return $result->row_array();
	}
	function indoordelete($id){
		$this->db->where('id',$id);
		$this->db->delete('indoor_activities');
		return true;	
	}
	function getoutdoorList(&$config,&$start,&$param)
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
			$sortType    	= $this->nsession->get_param('ADMIN_OUTDOOR','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_OUTDOOR','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_OUTDOOR','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_OUTDOOR','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_OUTDOOR','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_OUTDOOR','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_OUTDOOR','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_OUTDOOR','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_OUTDOOR','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_OUTDOOR','searchDisplay',20);
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

		$this->nsession->set_userdata('ADMIN_OUTDOOR', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('outdoor_activities.*');

		$recordSet = $this->db->get('outdoor_activities');
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
			$this->db->select('outdoor_activities.*');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('outdoor_activities');
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

	function addoutdoorContent($data)
	{
		$this->db->insert('outdoor_activities',$data);
		return true;
	}

	function editoutdoorContent($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('outdoor_activities', $data);
		return true;
	}

	function outdooractivate($id)
	{
		$sql = "UPDATE outdoor_activities SET is_active = '1' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}

	function outdoorinactive($id)
	{
		$sql = "UPDATE outdoor_activities SET is_active = '2' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}
	function getoutdoorSingle($id){
		$sql = "SELECT
				 *
				FROM
				  outdoor_activities
				WHERE
				 id = ".$id."";
		$result = $this->db->query($sql);
		return $result->row_array();
	}
	function outdoordelete($id){
		$this->db->where('id',$id);
		$this->db->delete('outdoor_activities');
		return true;	
	}
	function checkIfIndoorApply($id){
		$this->db->select('*');
		$this->db->from('member_more');
		$this->db->where('indoor_activities',$id);
		return $this->db->get()->num_rows();
	}
	function checkIfOutdoorApply($id){
		$this->db->select('*');
		$this->db->from('member_more');
		$this->db->where('outdoor_activities',$id);
		return $this->db->get()->num_rows();
	}
}

?>
