<?php

class ModelContactType extends CI_Model {
	
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
			$sortType    	= $this->nsession->get_param('ADMIN_CONTACT_TYPE','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_CONTACT_TYPE','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_CONTACT_TYPE','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_CONTACT_TYPE','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_CONTACT_TYPE','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_CONTACT_TYPE','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_CONTACT_TYPE','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_CONTACT_TYPE','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_CONTACT_TYPE','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_CONTACT_TYPE','searchDisplay',20);
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
		
		$this->nsession->set_userdata('ADMIN_CONTACT_TYPE', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(contact_type.id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('contact_type.id,contact_type.title,contact_type.is_active,contact_type.del_status,contact_industry.title as contact_industry_title');
		$this->db->join('contact_industry','contact_industry.id=contact_type.contact_industry_id');
		$this->db->where('contact_type.del_status','0');
		$recordSet = $this->db->get('contact_type'); 
		//echo $this->db->last_query();
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
			//$this->db->select('contact_type.*');
			$this->db->select('contact_type.id,contact_type.title,contact_type.is_active,contact_type.del_status,contact_industry.title as contact_industry_title');
			$this->db->join('contact_industry','contact_industry.id=contact_type.contact_industry_id');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
			
		$this->db->where('contact_type.del_status','0');
		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('contact_type');
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
			'title'=>$data['title'],
			'contact_industry_id'=>$data['contact_industry']
		);
		$this->db->insert('contact_type',$memberArr);
		$insert_id = $this->db->insert_id();
		
		return true;
	}
	
	function editContent($data,$id)
	{		
		$memberData = array(
             'title'=>$data['title'],
			 'contact_industry_id'=>$data['contact_industry']
			);

		$this->db->where('id', $id);
		$this->db->update('contact_type', $memberData); 
		
		return true;
	}
	
	function activate($id)
	{
		$sql = "UPDATE contact_type SET is_active = '1' WHERE id = ".$id."";	
		$recordSet = $this->db->query($sql);
		return true;
	}

	function inactive($id)
	{
		$sql = "UPDATE contact_type SET is_active = '0' WHERE id = ".$id."";	
		$recordSet = $this->db->query($sql);
		
		return true;
	}

	function getSingle($id){
		$this->db->select('*');
		$this->db->from('contact_type');
		$this->db->where('id',$id);
		$data = $this->db->get();
		return $data->row_array();
	}

	function deleteitem($id){
		$this->db->where('id', $id);
		$this->db->update('contact_type', array('del_status'=>1)); 
		return true;
	}
	function getContactIndustry(){
		$where = array(
			'is_active'=>'1',
			'del_status'=>'0'
		);
		return $this->db->select('*')->where($where)->get('contact_industry')->result_array();
	}
	
}

?>