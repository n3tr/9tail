<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Profiles extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
	}
	
	function index($user) {
	
		$userdata = $this->session->userdata('userdata');
		if ($userdata['logged_in'] == FALSE) {
			redirect('/login');
		}else {
			
			$this->db->where('screen_name', $userdata['screen_name']);
			$q = $this->db->get('user');
			$data['owner_user'] = $q->first_row('array');
			$this->load->view('profile_view',$data);
		}
		

	}
	
	function user($user=null)
	{
		if (isset($user)) {
			echo $user;
		}else {
			echo "user not set";
		}
	
	}

}