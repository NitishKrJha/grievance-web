<?php
class ModelTips extends CI_Model {

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
		
		$category_id	    = $param['category_id'];
		$sub_category_id	    = $param['sub_category_id'];

		if($isSession == 0)
		{
			$sortType    	= $this->nsession->get_param('ADMIN_MEMBER','sortType','DESC');
			$sortField   	= $this->nsession->get_param('ADMIN_MEMBER','sortField','id');
			$searchField 	= $this->nsession->get_param('ADMIN_MEMBER','searchField','');
			$searchString 	= $this->nsession->get_param('ADMIN_MEMBER','searchString','');
			$searchText  	= $this->nsession->get_param('ADMIN_MEMBER','searchText','');
			$searchFromDate = $this->nsession->get_param('ADMIN_MEMBER','searchFromDate','');
			$searchToDate  	= $this->nsession->get_param('ADMIN_MEMBER','searchToDate','');
			$searchAlpha  	= $this->nsession->get_param('ADMIN_MEMBER','searchAlpha','');
			$searchMode  	= $this->nsession->get_param('ADMIN_MEMBER','searchMode','STRING');
			$searchDisplay  = $this->nsession->get_param('ADMIN_MEMBER','searchDisplay',20);
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

		
		if($category_id!=''){
            $sessionDataArray['category_id'] 	        = $category_id ;
		}
		
		if($sub_category_id!=''){
            $sessionDataArray['sub_category_id'] 	        = $sub_category_id ;
		}
		
		$this->nsession->set_userdata('ADMIN_TIPS', $sessionDataArray);
		
		//==============================================================
		$this->db->select('COUNT(id) as TotalrecordCount');
		if(isset($sessionDataArray['searchField'])){
			$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
		}
		$this->db->select('tips.*');

		$recordSet = $this->db->get('tips');
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
			$this->db->select('tips.*,tips_category.title as cat_name');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
		$this->db->join('tips_category','tips_category.id = tips.category_id','left');
		
		if($category_id){		
			$this->db->where('tips.category_id',$category_id);			
		}
		
		if($sub_category_id){		
			$this->db->where('tips.sub_category_id',$sub_category_id);			
		}
		
		$this->db->order_by('tips.id',$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('tips');
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

	
	function getSingle($id){
		/* $sql = "SELECT
				 *
				FROM
				  tips
				WHERE
				 id = ".$id."";
		$result = $this->db->query($sql); */
		$this->db->select('tips.*,tips_category.title as cat_name');
		$this->db->from('tips');
		$this->db->join('tips_category','tips_category.id = tips.category_id','left');
		$this->db->where('tips.id',$id);
		$result = $this->db->get();
		return $result->row_array();
	}
	
	function check_plan($member_id){
		
		$this->db->select('*');
        $this->db->from('member_buyed_plan');
        $this->db->where('member_id',$member_id);
        $this->db->where('is_active',1);
        return $this->db->get()->row_array();
	}
	
	function reading_update($id)
	{
		$get_total=$this->db->select('tips_reads_remaning')->get_where('member_buyed_plan',array('id'=>$id))->row_array();
		if(count($get_total) > 0){
			$num=((int)$get_total['tips_reads_remaning'] - 1);
			if($num > 0){
				$r=$this->db->update('member_buyed_plan',array('tips_reads_remaning'=>(int)$num),array('id'=>$id));
				//sleep(1);
				//echo $this->db->last_query(); die();
			}
		}
		return $r;
	}
}
