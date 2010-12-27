<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Friendlib {

	// return 0 if not friend
	// return 1 if pendding
	// return 2 if freind.
	// 

    function check_friend($from_user,$to_user)
    {
		
		$CI =& get_instance();
		//$q1 = $CI->db->get_where('friend', array('from' => $from_user,'to' => $to_user), 1);
		//$q2 = $CI->db->get_where('friend', array('from' => $to_user,'to' => $from_user), 1);
		// 
		// 
		
		/*
		  $CI->db->where(array(
			'from' =>  1,
			'to' => 3
			));
		$CI->db->where(array(
			'from' => 3,
			'to' => 1
			));
		 */
		
		$sql = "SELECT * FROM (`tail_friend`) WHERE (`from` = ? AND `to` = ?) OR (`from` = ? AND `to` = ? ) LIMIT 1";
		
		
		
		$q = $CI->db->query($sql,array($from_user,$to_user,$to_user,$from_user));
	
		if ($q->num_rows > 0) {
			$is_friend = $q->first_row('array');
			
			
			if ($is_friend['status'] == 1) {
				return 2;
			}else {
				return 1;
			}
			
		}else {
		
			return 0;
		}
    }

	function who_added($user1,$user2)
	{
		$CI =& get_instance();
		$q = $CI->db->get_where('friend', array('from' => $user1,'to' => $user2), 1);
		if ($q->num_rows > 0) {
			return $user1;
		}else{
			return $user2;
		}
	}

	function request($from_id,$to_id,$guid)
	{
			$CI =& get_instance();
			
		
		$friend = array(
			'to' => $to_id,
			'from' => $from_id,
			'guid' => $guid,
			'datetime' => date("Y-m-d H:i:s"),
			'status' => 0
			);
		
		
		$CI->db->insert('friend', $friend);
	
		
		$emaillib = new Emaillib();
		$emaillib->friend_request($from_id,$to_id,$guid);
		
	}
	
	// Return Friend Count of User
	function get_friend_count($user_id)
	{
		
			$CI =& get_instance();
			/*
				$CI->db->where(array(
					'from' =>  $user_id,
					'status'=> 1
					));
				$CI->db->or_where(array(
					'to' => $user_id,
					'status'=> 1
					));
			*/
			$sql = "SELECT * FROM tail_friend WHERE ( tail_friend.to = ".$user_id." OR tail_friend.from = ".$user_id." ) AND tail_friend.status = 1";
			
				$q = $CI->db->query($sql);
		return $q->num_rows();
	}
	

	function get_friend_list($user_id)
	{
		$CI =& get_instance();
				$sql1 = "SELECT tail_friend.to as user_id, tail_user.screen_name, tail_user.firstname, tail_user.lastname, tail_user.thumbnail,tail_user.small_thumbnail FROM
		tail_friend JOIN tail_user ON tail_user.id = tail_friend.to WHERE tail_friend.from = ". $user_id . " AND tail_friend.status = 1";
				$sql2 = " UNION SELECT tail_friend.from as tail_user_id,tail_user.screen_name,tail_user.firstname,tail_user.lastname,tail_user.thumbnail,tail_user.small_thumbnail  FROM
				tail_friend JOIN tail_user ON tail_user.id = tail_friend.from WHERE tail_friend.to =" . $user_id." AND tail_friend.status = 1";
				$sql = $sql1 . $sql2;
				$q = $CI->db->query($sql);
				
				//echo $q->result('array');die();
				return $q->result('array');
	}
	
	function friend_guid($user1,$user2)
	{
		$CI =& get_instance();
		$CI->db->where('from', $user1);
		$CI->db->where('to', $user2);
		$CI->db->select('guid');
		$q= $CI->db->get('friend',1);
		
		if ($q->num_rows() > 0) {
			return $q->first_row('array');
		}else {
			return 0;
		}
	}
	

}

?>