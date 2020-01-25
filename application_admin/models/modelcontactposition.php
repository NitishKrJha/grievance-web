<?php

class ModelContactPosition extends CI_Model {
	
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
			$sortType    	= $this->nsession->get_param('ADMIN_CONTACT_POSITION','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_CONTACT_POSITION','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_CONTACT_POSITION','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_CONTACT_POSITION','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_CONTACT_POSITION','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_CONTACT_POSITION','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_CONTACT_POSITION','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_CONTACT_POSITION','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_CONTACT_POSITION','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_CONTACT_POSITION','searchDisplay',20);
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
		
		$this->nsession->set_userdata('ADMIN_CONTACT_POSITION', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('contact_position.*');
		$this->db->where('del_status','0');
		$recordSet = $this->db->get('contact_position'); 
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
			$this->db->select('contact_position.*');

			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
			
		$this->db->where('del_status','0');

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('contact_position');
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
		$memberArr = array(
			'position_number'=>$data['position_number'],
			'position_desc'=>$data['position_desc']
		);
		$this->db->insert('contact_position',$memberArr);
		$insert_id = $this->db->insert_id();
		
		return true;
	}
	
	function editContent($data,$id)
	{		
		$memberData = array(
             'position_number'=>$data['position_number'],
             'position_desc'=>$data['position_desc']
					);

		$this->db->where('id', $id);
		$this->db->update('contact_position', $memberData); 
		
		return true;
	}
	
	function activate($id)
	{
		$sql = "UPDATE contact_position SET is_active = '1' WHERE id = ".$id."";	
		$recordSet = $this->db->query($sql);
		return true;
	}

	function inactive($id)
	{
		$sql = "UPDATE contact_position SET is_active = '0' WHERE id = ".$id."";	
		$recordSet = $this->db->query($sql);
		
		return true;
	}

	function getSingle($id){
		$this->db->select('*');
		$this->db->from('contact_position');
		$this->db->where('id',$id);
		$data = $this->db->get();
		return $data->row_array();
	}

	function deleteitem($id){
		$this->db->where('id', $id);
		$this->db->update('contact_position', array('del_status'=>1)); 
		return true;
	}
	
}

?>