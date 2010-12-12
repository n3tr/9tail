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
	

}

?>