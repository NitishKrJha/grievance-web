<?php
class ModelNotification extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
	function getList(&$config,&$start,&$param)
	{
       // echo "hi"; die;
		
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
		$member_id		= $param['memberId'];
		if($isSession == 0)
		{
			$sortType    	= $this->nsession->get_param('FRONT_NOTIFICATION','sortType','DESC');
			$sortField   	= $this->nsession->get_param('FRONT_NOTIFICATION','sortField','id');
			$searchField 	= $this->nsession->get_param('FRONT_NOTIFICATION','searchField','');
			$searchString 	= $this->nsession->get_param('FRONT_NOTIFICATION','searchString','');
			$searchText  	= $this->nsession->get_param('FRONT_NOTIFICATION','searchText','');
			$searchFromDate = $this->nsession->get_param('FRONT_NOTIFICATION','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('FRONT_NOTIFICATION','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('FRONT_NOTIFICATION','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('FRONT_NOTIFICATION','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('FRONT_NOTIFICATION','searchDisplay',20);
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

		$this->nsession->set_userdata('FRONT_NOTIFICATION', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->where('member_notification.member_id',$member_id);
		$recordSet = $this->db->get('member_notification');
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
			$this->db->select('member_notification.*,mem1.name as name');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
		$this->db->join('member mem1','mem1.id=member_notification.member_id');
		$this->db->order_by('member_notification.id',$sortType);
		$this->db->limit($config['per_page'],$start);
		$this->db->where('member_notification.member_id',$member_id);
		$recordSet = $this->db->get('member_notification');
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
}