<?php

class ModelPet extends CI_Model {

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
			$sortType    	= $this->nsession->get_param('ADMIN_PET','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_PET','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_PET','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_PET','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_PET','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_PET','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_PET','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_PET','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_PET','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_PET','searchDisplay',20);
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

		$this->nsession->set_userdata('ADMIN_PET', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('pet.*');

		$recordSet = $this->db->get('pet');
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
			$this->db->select('pet.*');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('pet');
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
		$this->db->insert('pet',$data);
		return true;
	}

	function editContent($data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update('pet', $data);
		return true;
	}

	function activate($id)
	{
		$sql = "UPDATE pet SET is_active = '1' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}

	function inactive($id)
	{
		$sql = "UPDATE pet SET is_active = '2' WHERE id = ".$id."";
		$recordSet = $this->db->query($sql);

		if (!$recordSet )
		{
			return false;
		}
	}
	function getSingle($id){
		$sql = "SELECT
				 *
				FROM
				  pet
				WHERE
				 id = ".$id."";
		$result = $this->db->query($sql);
		return $result->row_array();
	}
	function checkIfApply($id){
		$this->db->select('*');
		$this->db->from('member_more');
		$this->db->where('pet',$id);
		return $this->db->get()->num_rows();
	}
	function delete($id){
		$this->db->where('id',$id);
		$this->db->delete('pet');
		return true;	
	}
}

?>
