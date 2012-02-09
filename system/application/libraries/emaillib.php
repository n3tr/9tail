<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Emaillib {


    function friend_request($from_id,$to_id,$guid)
    {
	
		$CI =& get_instance();
		
		$to_q = $CI->db->get_where('user', array('id'=>$to_id), 1);
		$from_q = $CI->db->get_where('user', array('id'=>$from_id), 1);
		$to_user = $to_q->first_row('array');
		$from_user = $from_q->first_row('array');
		
	
		$CI->email->set_newline("\r\n");
		$CI->email->from('system@9tail.com', '9Tail System');
		$CI->email->to($to_user['email']);		
		$CI->email->subject($from_user['screen_name'] . ' want to be your friend.');		
		$CI->email->message('To ' . $to_user['firstname'] . ' ' . $to_user['lastname'] 
			. "\r\n"
			. "\r\n"
			. 'Click link below to Activate your Account'
			. "\r\n"
			. "\r\n"
			. $CI->config->item('base_url') . 'index.php/friend/request_list/'
			. "\r\n"
			. "\r\n"
			. 'Thank you,'
			. "\r\n"
			. '9Tail Site'
			);
			if($CI->email->send())
			{
				return;
			}else {
				show_error($CI->email->print_debugger());
			}
	}   
	
	function email_reset_pwd($userdata)
    {

		$CI =& get_instance();

		$CI->email->set_newline("\r\n");
		$CI->email->from('system@9tail.com', '9Tail System');
		$CI->email->to($userdata['email']);		
		$CI->email->subject('Password Reset for ' . $userdata['screen_name']);		
		$CI->email->message('To ' . $userdata['firstname'] . ' ' . $userdata['lastname'] 
			. "\r\n"
			. "\r\n"
			. 'Click link below to Reset your Password'
			. "\r\n"
			. "\r\n"
			. $CI->config->item('base_url') . 'index.php/login/password_reset/'
			. $userdata['password'] .'/'
			. $userdata['guid']
			. "\r\n"
			. "\r\n"
			. 'Thank you,'
			. "\r\n"
			. '9Tail Site'
			);
			if($CI->email->send())
			{
				return;
			}else {
				show_error($CI->email->print_debugger());
			}
	}    
}
?>