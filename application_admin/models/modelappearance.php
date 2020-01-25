<?php

class ModelAppearance extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

	function getbodyList(&$config,&$start,&$param)
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
			$sortType    	= $this->nsession->get_param('ADMIN_BODY','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_BODY','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_BODY','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_BODY','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_BODY','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_BODY','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_BODY','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_BODY','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_BODY','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_BODY','searchDisplay',20);
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

		$this->nsession->set_userdata('ADMIN_BODY', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('body_type.*');

		$recordSet = $this->db->get('body_type');
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
			$this->db->select('body_type.*');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('body_type');
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

	function addbodyContent($data)
	{
		$this->db->insert('body_type',$data);
		return true;
	}

	function editbodyContent($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('body_type', $data);
		return true;
	}

	function bodyactivate($id)
	{
		$sql = "UPDATE body_type SET is_active = '1' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}

	function bodyinactive($id)
	{
		$sql = "UPDATE body_type SET is_active = '2' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}
	function getbodySingle($id){
		$sql = "SELECT
				 *
				FROM
				  body_type
				WHERE
				 id = ".$id."";
		$result = $this->db->query($sql);
		return $result->row_array();
	}
	function bodydelete($id){
		$this->db->where('id',$id);
		$this->db->delete('body_type');
		return true;	
	}
	function gethairList(&$config,&$start,&$param)
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
			$sortType    	= $this->nsession->get_param('ADMIN_HAIR','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_HAIR','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_HAIR','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_HAIR','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_HAIR','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_HAIR','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_HAIR','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_HAIR','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_HAIR','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_HAIR','searchDisplay',20);
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

		$this->nsession->set_userdata('ADMIN_HAIR', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('hair_type.*');

		$recordSet = $this->db->get('hair_type');
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
			$this->db->select('hair_type.*');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('hair_type');
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

	function addhairContent($data)
	{
		$this->db->insert('hair_type',$data);
		return true;
	}

	function edithairContent($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('hair_type', $data);
		return true;
	}

	function hairactivate($id)
	{
		$sql = "UPDATE hair_type SET is_active = '1' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}

	function hairinactive($id)
	{
		$sql = "UPDATE hair_type SET is_active = '2' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}
	function gethairSingle($id){
		$sql = "SELECT
				 *
				FROM
				  hair_type
				WHERE
				 id = ".$id."";
		$result = $this->db->query($sql);
		return $result->row_array();
	}
	function hairdelete($id){
		$this->db->where('id',$id);
		$this->db->delete('hair_type');
		return true;	
	}
	function geteyeList(&$config,&$start,&$param)
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
			$sortType    	= $this->nsession->get_param('ADMIN_EYE','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_EYE','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_EYE','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_EYE','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_EYE','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_EYE','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_EYE','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_EYE','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_EYE','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_EYE','searchDisplay',20);
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

		$this->nsession->set_userdata('ADMIN_EYE', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('eye_type.*');

		$recordSet = $this->db->get('eye_type');
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
			$this->db->select('eye_type.*');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('eye_type');
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

	function addeyeContent($data)
	{
		$this->db->insert('eye_type',$data);
		return true;
	}

	function editeyeContent($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('eye_type', $data);
		return true;
	}

	function eyeactivate($id)
	{
		$sql = "UPDATE eye_type SET is_active = '1' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}

	function eyeinactive($id)
	{
		$sql = "UPDATE eye_type SET is_active = '2' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}
	function geteyeSingle($id){
		$sql = "SELECT
				 *
				FROM
				  eye_type
				WHERE
				 id = ".$id."";
		$result = $this->db->query($sql);
		return $result->row_array();
	}
	function eyedelete($id){
		$this->db->where('id',$id);
		$this->db->delete('eye_type');
		return true;	
	}
	function checkIfBodyApply($id){
		$this->db->select('*');
		$this->db->from('member_more');
		$this->db->where('body_type',$id);
		return $this->db->get()->num_rows();
	}
	function checkIfHairApply($id){
		$this->db->select('*');
		$this->db->from('member_more');
		$this->db->where('hair',$id);
		return $this->db->get()->num_rows();
	}
	function checkIfEyeApply($id){
		$this->db->select('*');
		$this->db->from('member_more');
		$this->db->where('eye',$id);
		return $this->db->get()->num_rows();
	}
}

?>
