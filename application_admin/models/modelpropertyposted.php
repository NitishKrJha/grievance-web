<?php

class ModelPropertyPosted extends CI_Model {

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
			$sortType    	= $this->nsession->get_param('ADMIN_POSTEDADS','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_POSTEDADS','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_POSTEDADS','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_POSTEDADS','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_POSTEDADS','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_POSTEDADS','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_POSTEDADS','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_POSTEDADS','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_POSTEDADS','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_POSTEDADS','searchDisplay',20);
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

		$this->nsession->set_userdata('ADMIN_POSTEDADS', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(posted_property.id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('posted_property.*');
		$this->db->join('member','member.id=posted_property.member_id');
		$this->db->where('member.is_delete',0);
		$this->db->where('posted_property.property_is_deleted',0);

		$recordSet = $this->db->get('posted_property');
	//	echo $this->db->last_query();
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

		if($page > 0 && $page < $config['total_rows'])
			$start = $page;
			$this->db->select('posted_property.*,member.is_delete');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
		$this->db->join('member','member.id=posted_property.member_id');
		$this->db->where('member.is_delete',0);
		$this->db->where('posted_property.property_is_deleted',0);
		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('posted_property');
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

	function activate($id)
	{
		$this->db->where('id',$id);
		$this->db->update('posted_property',array('is_active'=>1));
		return true;
	}

	function inactive($id)
	{
		$this->db->where('id',$id);
		$this->db->update('posted_property',array('is_active'=>0));
		return true;
	}
	function getsingle_empdata($id){
		$this->db->select('first_name,email');
		$this->db->from('member');
		$this->db->where('id',$id);
		$data = $this->db->get();
		return $data->row();

	}
	function getSingle($id){
		$this->db->select('posted_property.*,member.first_name,member.last_name,member.email,property_type.name');
		$this->db->join('member','member.id=posted_property.member_id');
		$this->db->join('property_type','property_type.id=posted_property.property_type_id');
		$resultSet = $this->db->get('posted_property');
		echo $this->db->last_query();
		return $resultSet->result_array();
	}
	function getCategory(){
		$this->db->select('*');
		$this->db->from('ad_category');
		$this->db->where(array('level'=>0,'parent'=>0));
		return $this->db->get()->result_array();
	}
	function getMemberIdFromProperty($id){
		$this->db->select('member_id');
		$this->db->from('posted_property');
		$this->db->where('id',$id);
		return $this->db->get()->row_array();
	}
	function doDeleteProperty($id){
		$this->db->where('id',$id);
		$this->db->update('posted_property',array('property_is_deleted'=>1));
		return true;
	}
}

?>
