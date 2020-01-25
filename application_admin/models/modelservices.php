<?php

class ModelServices extends CI_Model {
	
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
			$sortType    	= $this->nsession->get_param('ADMIN_SERVICES','sortType','ASC');
			$sortField   	= $this->nsession->get_param('ADMIN_SERVICES','sortField','title_en');
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
		$sessionDataArray['searchField'] 	= $searchField;
		$sessionDataArray['searchString'] 	= $searchString;
		$sessionDataArray['searchText'] 	= $searchText;		
		$sessionDataArray['searchFromDate'] = $searchFromDate;		
		$sessionDataArray['searchToDate'] 	= $searchToDate;
		$sessionDataArray['searchAlpha'] 	= $searchAlpha;	
		$sessionDataArray['searchMode'] 	= $searchMode;
		$sessionDataArray['searchDisplay'] 	= $searchDisplay;		
		
		$this->nsession->set_userdata('ADMIN_SERVICES', $sessionDataArray);
		//==============================================================
		
		$orderBy = " order by ".$sortField." ".$sortType;
		//$where = " WHERE is_active ='Y' " ;
		$where = '';
		
		if($searchMode=='ALPHA')
		{
			if($searchAlpha <> "" )
			{
				$where .= " AND title_en like '".$searchAlpha."%' ";  
			}		
		}
		else 
		{
			if($searchField == "")
			{
			  $searchField='title_en';
			} 
			
			if($searchString <> "" )
			{   
				$where .= " AND ".$searchField. " like '%".$searchString."%' "; 
			}
			
			if($searchFromDate <> "" && $searchText=='custom')
			{
				$where.= " AND date_format(postdate,'%Y-%m-%d') >= '".$searchFromDate."' "; 
			}		
			if($searchToDate <> ""  && $searchText=='custom')
			{
				$where.= " AND date_format(postdate,'%Y-%m-%d') <= '".$searchToDate."' "; 
			}		
			if($searchText=='this_month'){
				$where.= " AND date_format(postdate,'%Y-%m') = '".date("Y-m")."'  "; 
			}		
			if($searchText=='last_month'){
				$where.= " AND date_format(postdate,'%Y-%m') =  date_format(now() - INTERVAL 1 MONTH, '%Y-%m') ";  
			}		
			if($searchText=='last_3_months'){
				$where.= " AND postdate >= date_sub(NOW(), INTERVAL 3 MONTH)"; 
			}		
			if($searchText=='last_6_months'){
				$where.= " AND postdate >= date_sub(NOW(), INTERVAL 6 MONTH) "; 
			}		
			if($searchText=='this_year'){
				$where.= " AND date_format(postdate,'%Y') = '".date("Y")."'  "; 
			}
			if($searchText=='last_year'){
				$where.= "  AND date_format(postdate,'%Y') =  date_format(now() - INTERVAL 1 YEAR, '%Y') "; 
			}	
		}
		
		$sql="SELECT COUNT(id) as TotalrecordCount FROM services WHERE 1 $where $orderBy";
		$recordSet = $this->db->query($sql);
		
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
	
		$sql=" SELECT * FROM services WHERE 1 $where $orderBy  LIMIT ".$start.",".$config['per_page'] ;
		
		$recordSet = $this->db->query($sql);
		
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
	
	function nosLevel()
	{
		$sql = "SELECT COUNT(*) as cnt from services WHERE id <> 0 GROUP BY level";
		//echo $sql; die();
		$recordSet = $this->db->query($sql);
		$nos = $recordSet->row(); 
		
		if($recordSet)
		{
			return $recordSet->num_rows();
		}
		else
		{
			return false;
		}
	}
	
	function getParent($lv)
	{
		if($lv == 0)
		{
			return array();
		} else {
			$sql = "SELECT id, title_en from services WHERE level = '".($lv-1)."' order by title_en ASC";
			
			//echo $sql; die();
			$recordSet = $this->db->query($sql);
			$nos = $recordSet->row(); 
			
			if($recordSet)
			{
				return $recordSet->result_array();
			}
			else
			{
				return false;
			}
		}
	}
	
	function addContent($data)
	{
		$sql = "INSERT INTO services SET
				level		= '".$data['level']."',
				parent		= '".$data['parent']."',
				title_en	= '".addslashes($data['title_en'])."',
				title_fr	= '".addslashes($data['title_fr'])."',
				icon		= '".$data['icon']."'";
		//echo $sql; die();
		$result = $this->db->query($sql);
		$last_insert_id = $this->db->insert_id(); 
		
		if($result)
		{
			return $last_insert_id;
		}
		else
		{
			return false;
		}
	}
	
	function editContent($id,$data)
	{
		$sql = "UPDATE services SET
				level		= '".$data['level']."',
				parent		= '".$data['parent']."',
				title_en	= '".addslashes($data['title_en'])."',
				title_fr	= '".addslashes($data['title_fr'])."',
				icon		= '".$data['icon']."'
				WHERE id 	= ".$id."";	
	    //echo $sql; die();
		$result = $this->db->query($sql);
		$affected_rows =$this->db->affected_rows();
		
		if($result)
		{
			return $affected_rows;
		}
		else
		{
			return false;
		}
	}
	
	function delete($id)
	{
		$sql = "DELETE FROM services WHERE id = ".$id."";	
		$recordSet = $this->db->query($sql);
		
		if (!$recordSet )
		{
			return false;
		}
	}

    function getSingle($id)
	{
		$sql = "SELECT * FROM services WHERE id = ".$id;
		$recordSet = $this->db->query($sql);
		
		$rs = false;
		if ($recordSet->num_rows() > 0)
        {
           	$rs = array();
			$isEscapeArr = array('icon');
			foreach ($recordSet->result_array() as $row)
				{
					foreach($row as $key=>$val){
						if(!in_array($key,$isEscapeArr)){
							$recordSet->fields[$key] = outputEscapeString($val);
						}else{
							$recordSet->fields[$key] = outputEscapeString($val,'TEXTAREA');
						}
					}
					$rs[] = $recordSet->fields;
				}
        }
		return $rs;			
	}
	function checkIfRecord($title_en,$level){
		
		$this->db->select('COUNT(*) as count');
		$this->db->from('services');
		$this->db->where('title_en',$title_en);
		$this->db->where('level',$level);
		$returnData = $this->db->get();
		return $returnData->row();
	}
	
}

?>