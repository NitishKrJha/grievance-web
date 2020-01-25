<?php

class ModelBroadcastPrice extends CI_Model {
	
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
			$sortType    	= $this->nsession->get_param('ADMIN_BROADCASTPRICE','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_BROADCASTPRICE','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_BROADCASTPRICE','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_BROADCASTPRICE','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_BROADCASTPRICE','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_BROADCASTPRICE','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_BROADCASTPRICE','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_BROADCASTPRICE','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_BROADCASTPRICE','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_BROADCASTPRICE','searchDisplay',20);
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
		
		$this->nsession->set_userdata('ADMIN_BROADCASTPRICE', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(retailer_price_range.id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('retailer_price_range.*');
		$this->db->join('members','members.id=retailer_price_range.retailer_id');
		//$this->db->where('members.type','1');

		$recordSet = $this->db->get('retailer_price_range'); 
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
			$this->db->select('members.id as retailer_id,members.name as retailer_name,retailer_price_range.id as range_id,retailer_price_range.starting_range as starting_range,retailer_price_range.ending_range as ending_range,retailer_price_range.price as price');
			$this->db->join('members','members.id=retailer_price_range.retailer_id');
			$this->db->where(array('members.type'=>'1','members.status'=>'1'));
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
			
		$this->db->order_by('members.id','DESC');
		$this->db->order_by('retailer_price_range.id','ASC');
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('retailer_price_range');
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
		for($i=0;$i<count($data['starting_range']);$i++){
			
			$inset_data = array(
				'retailer_id'=>$data['retailer'],
				'starting_range'=>$data['starting_range'][$i],
				'ending_range'=>$data['ending_range'][$i],
				'price'=>$data['price'][$i],
			);
			$this->db->insert('retailer_price_range',$inset_data);
		}
		return true;
	}
	
	function editContent($data,$id)
	{		
		$memberData = array(
               'name' => $data['name']
					);

		$this->db->where('id', $id);
		$this->db->update('members', $memberData); 
		
		$memberMoreData = array(
               'address' => $data['address']
					);

		$this->db->where('memberid', $id);
		$this->db->update('membersmore', $memberMoreData); 
		return true;
	}
	
	function getRetailerList(){
		$this->db->select('*');
		$this->db->from('members');
		$this->db->where(array('type'=>1,'status'=>1));
		$this->db->where('`id` NOT IN (SELECT `retailer_id` FROM `retailer_price_range`)', NULL, FALSE);
		return $this->db->get()->result_array();
	}
	function do_delete($contentId){
		$this->db->where('retailer_id', $contentId);
		$this->db->delete('retailer_price_range');
		return true;
	}
}

?>