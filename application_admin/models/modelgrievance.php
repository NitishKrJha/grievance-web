<?php
class ModelGrievance extends CI_Model {

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
			$sortType    	= $this->nsession->get_param('ADMIN_grievance','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_grievance','sortField','grievances.id');
			$searchField 	= $this->nsession->get_param('ADMIN_grievance','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_grievance','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_grievance','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_grievance','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_grievance','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_grievance','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_grievance','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_grievance','searchDisplay',10);
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

		$this->nsession->set_userdata('ADMIN_grievance', $sessionDataArray);
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('grievances.*');
		$recordSet = $this->db->get('grievances');
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
			$this->db->select('grievances.*,department.name as department_name,user.first_name as user_first_name,user.middle_name as user_middle_name,user.last_name as user_last_name,user.phone as user_phone,user.email as user_email,supervisor.first_name as supervisor_first_name,supervisor.middle_name as supervisor_middle_name,supervisor.last_name as supervisor_last_name,supervisor.phone as supervisor_phone,supervisor.email as supervisor_email');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}

		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$this->db->join('member as user','user.id=grievances.created_by','Left Outer');
		$this->db->join('member as supervisor','supervisor.id=grievances.modified_by','Left Outer');
		$this->db->join('department','department.id = grievances.department_id','Left Outer');
		$recordSet = $this->db->get('grievances');
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

	function getDetailById($id){
		$this->db->select('grievances.*,member.first_name,member.middle_name,member.last_name,member.phone as modifier_phone,member.phone as modifier_email');
		$this->db->join('member','member.id = grievances.modified_by','Left Outer');
		$this->db->where('grievances.id',$id);
		$this->db->from('grievances');
		$query=$this->db->get();
		if($query->num_rows() > 0){
			$data = $query->row_array();
			return $data;
		}
		return false;
	}
}
