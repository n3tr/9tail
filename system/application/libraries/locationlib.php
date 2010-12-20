<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Locationlib {

	// return 0 if not friend
	// return 1 if pendding
	// return 2 if freind.
	// 
	function get_last_checkin_of_user($user_id)
	{
		$CI =& get_instance();
		$sql = 'SELECT * from 9tail_db.checkin JOIN 9tail_db.place ON place.id = checkin.place_id where checkin.user_id = ? order by checkin.datetime desc limit 1';
		$q = $CI->db->query($sql,$user_id);
		return $q->first_row('array');
	}
  }

?>