<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Friend extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
	}
	
	
	function request($to_user) {
		$userdata = $this->session->userdata('userdata');
		$user_id = $userdata['user_id'];
		
		$q = $this->db->get_where('user', array('screen_name'=> $to_user), 1);
		if($q->num_rows > 0){
			$user = $q->first_row('array');
			
			$this->load->library('encrypt');
			$guid = $this->encrypt->sha1($userdata['screen_name'].$to_user);
			$this->friendlib->request($userdata['user_id'],$user['id'],$guid);
			redirect('/user/' . $to_user);
		}
	
	}
	
	function confirm($guid=null)
	{
		if(isset($guid)){
			
			// user who was added by other
			$this->db->where('guid', $guid);
			$q = $this->db->get("friend");
			$user = $q->first_row('array');
			
			$this->db->where('id',$user['to']);
			$quser = $this->db->get('user');
			
			$ownuser = $quser->first_row('array');
			
			$userdata = $this->session->userdata('userdata');
			if ($userdata['user_id'] == $ownuser['id']) {
				//echo 'confirm';
				$this->db->where('guid',$guid);
				$this->db->update('friend',array('status'=>1)); 
				echo 'updated';
			}else {
				echo 'login';
			}
			
		
			//echo $user;
		}
	}

}