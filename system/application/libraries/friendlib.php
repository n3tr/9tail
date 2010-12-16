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
		$CI->db->where(array(
			'from' =>  $from_user,
			'to' => $to_user
			));
		$CI->db->or_where(array(
			'from' => $to_user,
			'to' => $from_user
			));
		
		$q = $CI->db->get('friend');
		
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
				$CI->db->where(array(
					'from' =>  $user_id,
					'status'=> 1
					));
				$CI->db->or_where(array(
					'to' => $user_id,
					'status'=> 1
					));

				$q = $CI->db->get('friend');
		return $CI->db->count_all_results();
	}
	

	function get_friend_list($user_id)
	{
		$CI =& get_instance();
				$sql1 = "SELECT friend.to as user_id,user.screen_name,user.firstname,user.lastname FROM
		friend JOIN user ON user.id = friend.to WHERE friend.from = ". $user_id . " AND friend.status = 1";
				$sql2 = " UNION SELECT friend.from as user_id,user.screen_name,firstname,user.lastname  FROM
				friend JOIN user ON user.id = friend.from WHERE friend.to =" . $user_id." AND friend.status = 1";
				$sql = $sql1 . $sql2;
				$q = $CI->db->query($sql);
			
				return $q->result('array');
	}
}

?>