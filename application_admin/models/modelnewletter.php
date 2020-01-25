<?php

class ModelNewletter extends CI_Model {
	
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
		//$employeeName 	= $param['employeeName'];
		//$employeePhone 	= $param['employeePhone'];
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
			$sortType    	= $this->nsession->get_param('ADMIN_NEWSLETTER','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_NEWSLETTER','sortField','id');
			//$employeeName   = $this->nsession->get_param('ADMIN_NEWSLETTER','employeeName','');
			//$employeePhone  = $this->nsession->get_param('ADMIN_NEWSLETTER','employeePhone','');
			$searchField 	= $this->nsession->get_param('ADMIN_NEWSLETTER','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_NEWSLETTER','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_NEWSLETTER','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_NEWSLETTER','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_NEWSLETTER','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_NEWSLETTER','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_NEWSLETTER','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_NEWSLETTER','searchDisplay',20);
		}
		
		//========= SET SESSION DATA FOR SEARCH / PAGE / SORT Condition etc =====================
		$sessionDataArray = array();
		$sessionDataArray['sortType'] 		= $sortType;
		$sessionDataArray['sortField'] 		= $sortField;
		//$sessionDataArray['employeeName'] 		= $employeeName;
		//$sessionDataArray['employeePhone'] 		= $employeePhone;
		$sessionDataArray['searchField'] 	= $searchField;
		$sessionDataArray['searchString'] 	= $searchString;
		$sessionDataArray['searchText'] 	= $searchText;		
		$sessionDataArray['searchFromDate'] = $searchFromDate;		
		$sessionDataArray['searchToDate'] 	= $searchToDate;
		$sessionDataArray['searchAlpha'] 	= $searchAlpha;	
		$sessionDataArray['searchMode'] 	= $searchMode;
		$sessionDataArray['searchDisplay'] 	= $searchDisplay;		
		
		$this->nsession->set_userdata('ADMIN_NEWSLETTER', $sessionDataArray);
		//==============================================================
		
		$orderBy = " order by newsletter.".$sortField." ".$sortType;
		$where = " WHERE newsletter.is_active = '1'" ;
		//$where = ' AND member_type = 1';
		
		if($searchMode=='ALPHA')
		{
			if($searchAlpha <> "" )
			{
				$where .= " AND entry_date like '".$searchAlpha."%' ";  
			}		
		}
		else 
		{
			if($searchField == "")
			{
			  $searchField='entry_date';
			} 
			
			if($searchString <> "" )
			{   
				$where .= " AND ".$searchField. " like '%".$searchString."%' "; 
			}
			
			/* if(isset($sessionDataArray['employeeName'])  && $sessionDataArray['employeeName']!=''){
				$where .= " AND display_name like '%".$sessionDataArray['employeeName']."%' OR last_name like '%".$sessionDataArray['employeeName']."%' "; 
			}
			
			if(isset($sessionDataArray['employeePhone'])  && $sessionDataArray['employeePhone']!=''){
				
				//$sqlQuery="SELECT * FROM `employer_details` WHERE `phone_no` LIKE '%".$sessionDataArray['employerPhone']."%'";
				//$queryRecord = $this->db->query($sqlQuery);
				$where .= " AND members.id IN (SELECT member_id FROM `employee_details` WHERE `phone_no` LIKE '%".$sessionDataArray['employeePhone']."%') "; 
			} */
			
			
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
		
		$sql="SELECT COUNT(id) as TotalrecordCount FROM newsletter $where $orderBy";
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
	
		$sql=" SELECT newsletter.id,newsletter.email,newsletter.post_date,newsletter.is_active
				FROM newsletter
				$where 
				$orderBy  
				LIMIT ".$start.",".$config['per_page'] ;
				
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
	function GetEmail(){
		$query = "SELECT * FROM newsletter where is_active='1'";
		$result = $this->db->query($query);
		return $result = $result->result_array();
	}
}

?>