<?php

class ModelContent extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	function getContent($page_name)
	{
		$sql = "SELECT * FROM contents WHERE page_name = '".$page_name."'";
		$recordSet = $this->db->query($sql);
		$row = $recordSet->row();
		return $row;
		
	}
	
	function addCmsContent($data)
	{
		$inserData = array(
			'content'=>$data['content'],
			'page_name'=>$data['page_name'],
			'modified_date'=>date('Y-m-d H:i:s')
		);
		$this->db->insert('contents',$inserData);
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
	
	function editCmsContent($data)
	{	
		$UpdateData = array(
			'content'=>$data['content'],
			'page_name'=>$data['page_name'],
			'modified_date'=>date('Y-m-d H:i:s')
		);
		$this->db->where('page_name',$data['page_name']);
		$this->db->update('contents',$UpdateData);
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
}

?>