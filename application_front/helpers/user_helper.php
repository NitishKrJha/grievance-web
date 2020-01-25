<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

     
		
		function get_where($tbl_name,$where=array())
		{
			$ci =& get_instance();
			return $ci->db->get_where($tbl_name,$where)->result_array();
		}

		function get_where_limit($tbl_name,$where,$limit=1,$order_by='')
		{
			$ci =& get_instance();
			if($order_by!=''){
				$ci->db->order_by($order_by,'DESC');
			}
			$ci->db->limit($limit);
			return $ci->db->get_where($tbl_name,$where)->result_array();
		}
		
		function get_interest()
		{
			$ci =& get_instance();
			return $ci->db->get_where('interest')->result_array();
		}
		
		function get_interest_member()
		{
			$ci =& get_instance();			
			$member_id 	= $ci->nsession->userdata('member_session_id');							
			return $ci->db->get_where('member_interest',array('member_id'=>$member_id))->result_array();
		}
		function get_user_id()
			{
				$ci =& get_instance();
				$user_id = $ci->nsession->userdata('member_session_id');
				$mmr_user_id =  $ci->input->cookie('mmr_user_id',true);
				
				
				if($mmr_user_id!='')
				{
					//user details 
					  $user_details = $ci->db->where('id',$mmr_user_id)->get('member')->result_array();
					//  echo"<pre>";print_r($user_details);
					if(!empty($user_details))
					{
						$ci->nsession->set_userdata('member_session_id', $user_details[0]['id']);
						$ci->nsession->set_userdata('member_session_membertype',$user_details[0]['member_type']);
						$ci->nsession->set_userdata('member_session_email', $user_details[0]['email']);
						$ci->nsession->set_userdata('member_session_name', $user_details[0]['name']);
						$ci->nsession->set_userdata('profileImg',$user_details[0]['picture']);
						$ci->nsession->set_userdata('coverImg',$user_details[0]['cover_image']);
					}
					
					return $mmr_user_id;
				}
				else if($user_id!='')
				{
					return $user_id;
				}
				else
				{
					return false;
				}
			}
			
			function time_elapsed_string($datetime, $full = false) {
					$now = new DateTime;
					$ago = new DateTime($datetime);
					$diff = $now->diff($ago);

					$diff->w = floor($diff->d / 7);
					$diff->d -= $diff->w * 7;

					$string = array(
						'y' => 'year',
						'm' => 'month',
						'w' => 'week',
						'd' => 'day',
						'h' => 'hour',
						'i' => 'minute',
						's' => 'second',
					);
					foreach ($string as $k => &$v) {
						if ($diff->$k) {
							$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
						} else {
							unset($string[$k]);
						}
					}

					if (!$full) $string = array_slice($string, 0, 1);
					return $string ? implode(', ', $string) . ' ago' : 'just now';
				}