<?php

class ModelSetting extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }


	function getGlobalData()
	{
		$sql="SELECT * FROM global_config ";
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
					$rs[$recordSet->fields['field_key']] = $recordSet->fields;
				}
        }
		return $rs;
	}


	//=========================================//
	#	Update Global Settings for the Website	#
	//=========================================//
	function updateGlobalSetting($data)
	{
		/***************** Site Information *****************/
		$sql = "UPDATE global_config SET field_value = '".$data['global_site_name']."' WHERE field_key='global_site_name' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_meta_title']."' WHERE field_key='global_meta_title' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_meta_keywords']."' WHERE field_key='global_meta_keywords' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_meta_description']."' WHERE field_key='global_meta_description' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_phone_number']."' WHERE field_key='global_phone_number' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_web_admin_headquarters_address']."' WHERE field_key='global_web_admin_headquarters_address' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_web_admin_secondary_address']."' WHERE field_key='global_web_admin_secondary_address' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_paypal_business_email']."' WHERE field_key='global_paypal_business_email' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_paypal_mode']."' WHERE field_key='global_paypal_mode' ";
		$recordSet = $this->db->query($sql);

		/***************** Social Site Link *****************/
		$sql = "UPDATE global_config SET field_value = '".$data['global_facebook_url']."' WHERE field_key='global_facebook_url' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_twitter_url']."' WHERE field_key='global_twitter_url' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_youtube_url']."' WHERE field_key='global_youtube_url' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_googleplus_url']."' WHERE field_key='global_googleplus_url' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_instagram_url']."' WHERE field_key='global_instagram_url' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_playstore_url']."' WHERE field_key='global_playstore_url' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_appstore_url']."' WHERE field_key='global_appstore_url' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_linkdin_url']."' WHERE field_key='global_linkdin_url' ";
		$recordSet = $this->db->query($sql);

		/***************** Email Information *****************/
		$sql = "UPDATE global_config SET field_value = '".$data['global_web_admin_name']."' WHERE field_key='global_web_admin_name' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_webadmin_email']."' WHERE field_key='global_webadmin_email' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".addslashes($data['global_email_signature'])."' WHERE field_key='global_email_signature' ";
		$recordSet = $this->db->query($sql);
		$sql = "UPDATE global_config SET field_value = '".$data['global_contact_email']."' WHERE field_key='global_contact_email' ";
		$recordSet = $this->db->query($sql);

		/***************** List Settings *****************/
		$sql = "UPDATE global_config SET field_value = '".$data['global_product_page_count']."' WHERE field_key='global_product_page_count' ";
		$recordSet = $this->db->query($sql);
		
		/***************** Extra Settings *****************/
		$sql = "UPDATE global_config SET field_value = '".$data['global_credit_price']."' WHERE field_key='global_credit_price' ";
		$recordSet = $this->db->query($sql);

		/************** Map **************/
		
		$sql = "UPDATE global_config SET field_value = '".$data['global_map_url']."' WHERE field_key='global_map_url' ";
		$recordSet = $this->db->query($sql);
		
		/*************Address******/
		
		$sql = "UPDATE global_config SET field_value = '".$data['global_address']."' WHERE field_key='global_address' ";
		$recordSet = $this->db->query($sql);
		
		return true;
	}

}

?>