<?php
class ModelDynamicform extends CI_Model {
	
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
			$sortType    	= $this->nsession->get_param('ADMIN_SERVICES','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_SERVICES','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_SERVICES','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_SERVICES','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_SERVICES','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_SERVICES','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_SERVICES','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_SERVICES','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_SERVICES','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_SERVICES','searchDisplay',20);
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
		
		$this->nsession->set_userdata('ADMIN_SERVICES', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('ad_category.*');

		$recordSet = $this->db->get('ad_category'); 
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
			$this->db->select('ad_category.*');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
			
		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('ad_category');
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
	function getAdParent(){
		$this->db->select('*');
		$this->db->from('ad_category');
		$this->db->where('level','0');
		$this->db->where('is_active','1');
		return $this->db->get()->result_array();
	}
	function getChildData($parent){
		$this->db->select('*');
		$this->db->from('ad_category');
		$this->db->where('level','1');
		$this->db->where('is_active','1');
		$this->db->where('parent',$parent);
		return $this->db->get()->result_array();
	}
}

?>