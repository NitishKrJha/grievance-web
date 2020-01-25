<?php

class ModelLogin extends CI_Model {

    var $username = '';
	var $admin_id = '';
	var $password = '';

	function __construct()
    {
        parent::__construct();
    }

	function authenticateUser($data)
    {
		$this->username   	= $data['username'];
		$this->password 	=  $data['password'];
		$login = false;

		$this->db->select('admin.*');
		$this->db->where('admin.username',$this->username);
		$this->db->where('admin.password',md5($this->password));
		$this->db->where('admin.type','1');
		$this->db->where('admin.status','1');

		$rs = $this->db->get('admin');

		if ($rs->num_rows() >0 )
		{
			$row = $rs->row();
			$login = true;			
		}
		//print_r($row);exit;

		if($login == true)	{			
			$this->nsession->set_userdata('admin_session_id', $row->id);
			$this->nsession->set_userdata('admin_session_username', $row->username);
			$this->nsession->set_userdata('admin_session_fname', $row->name);
			$this->nsession->set_userdata('admin_session_usertype', $row->type);
			return true;
		}
		else
		{
			return false;
		}
    }

	function isValidUsername($data)
    {

		$this->username   	= $data['username'];
		$query = "SELECT id FROM admin WHERE username = '".$this->username."' and status = 'Active' ";

		$rs = $this->db->query($query);
		if ($rs->num_rows() >0 )
		{
			$row = $rs->row();
			$id = $row->id;
			return $id;			
		}
		else
		{
			return false;
		}
    }

	function updateAdminEmail($id,$data)
	{
		$this->email_address	= $data['email_address'];
		$query = "update admin set email_address ='".$this->email_address."' where id ='".$id."'";
		$rs = $this->db->query($query);
		
		if($this->db->affected_rows())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function profileUpdate($id,$data)
	{
		$full_name			= $data['full_name'];
		$email_address		= $data['email_address'];

		$query = "UPDATE admin SET 
				full_name 				= '".$full_name."',
				email_address 			= '".$email_address."' where id ='".$id."'";

		$rs = $this->db->query($query);

		if($this->db->affected_rows())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function getEmail($id)
	{
		$query = "select email_address from admin where id ='".$id."'";
		$rs = $this->db->query($query);

		if($rs->num_rows() > 0)
		{
			$row = $rs->row();
			$email = $row->email_address;
			return $email;
		}
		else
		{
			return "";
		}
	}

	function updateAdminPass($id,$data)
	{
		$new_admin_pwd	=	$data['new_admin_pwd'];

		$query = "update admin set password = '".md5($new_admin_pwd)."' where id ='".$id."'";

		$rs = $this->db->query($query);

		if($this->db->affected_rows())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function getProfileData($id = 0)
	{
		$sql="SELECT * FROM admin WHERE id = ".$id." ";
		$recordSet = $this->db->query($sql);
		//pr($recordSet->fields);

		$rs = false;

		if ($recordSet->num_rows() > 0)
		{
			$rs = array();
			$isEscapeArr = array();
			$row = $recordSet->row_array();
			foreach($row as $key =>$val)
			{
				if(!in_array($key,$isEscapeArr))
					$recordSet->fields[$key] = outputEscapeString($val);
			}

			$rs[] = $recordSet->fields;
		}
		else
		{
			return false;
		}
		return $rs;		
	}

	function valideOldPassword(&$data)
	{	
		$oldpassword = $data['oldpassword'];
		$id = $this->nsession->userdata('admin_session_id');

		$admin_pwd_sql = "SELECT count(*) as CNT FROM admin WHERE id ='".$id."' and password ='".md5($oldpassword)."'";

		//echo $admin_pwd_sql; die();

		$recordSet = $this->db->query($admin_pwd_sql);

		$rs = false;		

		if($recordSet->num_rows() > 0)
		{
			$rs = array();
			$isEscapeArr = array();
			$row = $recordSet->row_array();

			if($row['CNT']>0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	function getOwnerCount(){
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where(array('member_type'=>1));
		return $this->db->get()->num_rows();
	}
	function getRenterCount(){
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where(array('member_type'=>2));
		return $this->db->get()->num_rows();
	}
	function getPropertyPostedCount(){
		$this->db->select('*');
		$this->db->from('posted_property');
		return $this->db->get()->num_rows();
	}
	function getBannerCount(){
		$this->db->select('*');
		$this->db->from('banner');
		return $this->db->get()->num_rows();
	}
	function getTotalMember(){
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where('member_type',1);		$this->db->where("is_delete != 2 ");
		return $this->db->get()->num_rows();
	}
	function getTotalcounselor(){
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where('member_type',2);
		return $this->db->get()->num_rows();
	}

}
?>