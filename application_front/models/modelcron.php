<?php
class ModelCron extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	function getNewPropertyPoasted($previousDate){
		$this->db->select('*');
		$this->db->from('posted_property');
		$this->db->where(array('created_date'=>$previousDate));
		$resultset = $this->db->get();
		return $resultset->result_array();
	}
	function getSavedPropetyMatchMember($newProperty){
		$property_utilities_id = explode(',',$newProperty['property_utilities_id']);
		$property_features_id = explode(',',$newProperty['property_features_id']);

		$this->db->select('member.first_name,member.last_name,member.email,saved_search.beds,saved_search.beds_max,saved_search.min_price,saved_search.max_price,member_notification.notify_type');
		$this->db->from('saved_search');
		$this->db->join('member','member.id=saved_search.member_id');
		$this->db->join('member_notification','member_notification.member_id=saved_search.member_id');
		$this->db->where('member.member_type',2);
    if($newProperty['property_availability']>0){
      $this->db->where('saved_search.availabity',$newProperty['property_availability']);
    }
    $this->db->where('saved_search.poster_name',$newProperty['poster_name']);
		$this->db->where('saved_search.bath',$newProperty['bathrooms']);
		$this->db->where('saved_search.furnished_status',$newProperty['furnished_status']);
		$this->db->where('FIND_IN_SET('.$newProperty['property_type_id'].', saved_search.property_type)');
		$this->db->where('member_notification.notify_type',2);
		foreach($property_utilities_id as $property_utilities){
			if($property_utilities!=''){
				$this->db->or_where('FIND_IN_SET('.$property_utilities.', saved_search.utilities)');
			}

		}
		foreach($property_features_id as $property_features){
			if($property_features!=''){
				$this->db->or_where('FIND_IN_SET('.$property_features.', saved_search.features)');
			}
		}
        $this->db->where('saved_search.beds <=',$newProperty['bedrooms']);
		//$this->db->where('saved_search.beds_max >=',$newProperty['bedrooms']);
		//$this->db->where('saved_search.beds <=',$newProperty['bedrooms']);

		$this->db->where('saved_search.max_price >=',$newProperty['price']);
		$this->db->where('saved_search.min_price <=',$newProperty['price']);

		$resultSet = $this->db->get();
		//echo $this->db->last_query();
		return $resultSet->result_array();
	}
}
?>
