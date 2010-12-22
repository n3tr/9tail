<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Locationlib {

	// return 0 if not friend
	// return 1 if pendding
	// return 2 if freind.
	// 
	function get_last_checkin_of_user($user_id)
	{
		$CI =& get_instance();
		$sql = 'SELECT * from tail_checkin JOIN tail_place ON tail_place.id = tail_checkin.place_id where tail_checkin.user_id = ? order by tail_checkin.datetime desc limit 1';
		$q = $CI->db->query($sql,$user_id);
		if($q->num_rows() > 0){
		return $q->first_row('array');	
		}else {
			return 0;
		}
		
	}
  }

?>