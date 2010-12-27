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
	
	function who_checkin_in($place_id=null)
	{
		$CI =& get_instance();
		$sql = 'select t1.id,user_id,place_id,datetime,t3.screen_name,t3.thumbnail,t3.small_thumbnail,t3.firstname,t3.lastname
				from tail_checkin t1
				join tail_user t3 on t1.user_id = t3.id

			 where (datetime = (select MAX(datetime) 
				from tail_checkin t2
				where t1.user_id = t2.user_id) AND t1.place_id = ?)
				order by datetime desc';
		
		if(!isset($place_id)){
			return 0;
		}
		
		$q = $CI->db->query($sql,$place_id);
		return $q->result('array');
	
	}
  }



?>