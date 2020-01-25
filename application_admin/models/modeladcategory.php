<?php
class ModelAdcategory extends CI_Model {
	
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
		$this->db->select('tips_category.*');

		$recordSet = $this->db->get('tips_category'); 
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
			$this->db->select('tips_category.*');
			if(isset($sessionDataArray['searchField'])){
				$this->db->like($sessionDataArray['searchField'],$sessionDataArray['searchString'],'both');
			}
			
		$this->db->order_by($sortField,$sortType);
		$this->db->limit($config['per_page'],$start);
		$recordSet = $this->db->get('tips_category');
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
	
	function nosLevel()
	{
		$sql = "SELECT COUNT(*) as cnt from tips_category WHERE id <> 0 GROUP BY level";
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
			$sql = "SELECT id, title_en from tips_category WHERE level = '".($lv-1)."' order by title_en ASC";
			
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
		$insertData = array(
			'level'=>$data['level'],
			'parent'=>$data['parent'],
			'title_en'=>$data['title_en'],
			'title_ch'=>$data['title_ch'],
			'is_paid'=>$data['is_paid'],
			'icon'=>$data['icon'],
			'created'=>$data['created']
		);
		$this->db->insert('tips_category',$insertData);
		$last_insert_id = $this->db->insert_id(); 
		if($data['is_paid']==1 && $data['level']==0){
			for($i=0;$i<count($data['price']);$i++){
				$insertPlanData = array(
					'tips_category_id'=>$last_insert_id,
					'price'=>$data['price'][$i],
					'number_posting'=>$data['number_posting'][$i]
				);
				$this->db->insert('tips_category_plan',$insertPlanData);
			}
		}
		if($last_insert_id)
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
		$updateData = array(
			'level'=>$data['level'],
			'parent'=>$data['parent'],
			'title_en'=>$data['title_en'],
			'title_ch'=>$data['title_ch'],
			'is_paid'=>$data['is_paid'],
			'icon'=>$data['icon'],
			'modified'=>$data['modified']
		);
		$this->db->where('id',$id);
		$this->db->update('tips_category',$updateData);
		$affected_rows =$this->db->affected_rows();
		
		/* Delete from tips_category_plan */
		$this->db->delete('tips_category_plan', array('tips_category_id' => $id)); 
		
		/* Insert it into  tips_category_plan */
		if($data['is_paid']==1 && $data['level']==0){
			for($i=0;$i<count($data['price']);$i++){
				$insertPlanData = array(
					'tips_category_id'=>$id,
					'price'=>$data['price'][$i],
					'number_posting'=>$data['number_posting'][$i]
				);
				$this->db->insert('tips_category_plan',$insertPlanData);
			}
		}
		if($affected_rows)
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
		$this->db->delete('tips_category', array('id' => $id));
		$this->db->delete('tips_category_plan', array('tips_category_id' => $id)); 
		return true;
	}

    function getSingle($id)
	{
		$sql = "SELECT * FROM tips_category WHERE id = ".$id;
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
	function getCategoryPlan($tips_category_id){
		return $this->db->select('*')->where('tips_category_id',$tips_category_id)->get('tips_category_plan')->result_array();
	}
}

?>