<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Login extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
			$this->load->library('form_validation');
			$this->load->library('encrypt');
			$this->load->library('email');
	}
	
	function index() {
		
$userdata = $this->session->userdata('userdata');

		if($userdata['logged_in'] == FALSE){
			$this->load->view('login_view');
		}else {
			redirect('/user/');
		}
		
	}
	
	// Call When User Click Activate Link Form Email
	// Note : This Method Must be fix Later
	// Now User Screen Name to Active User Account
	function activate($screen_name = null)
	{
		if (isset($screen_name)) {
			# code...
		$this->db->where('screen_name', $screen_name);
		$q = $this->db->get('user',1);
		
		if($q->num_rows() > 0){
			$row = $q->first_row('array');
			$row['status'] = 1;
			$this->db->where('id', $row['id']);
			$this->db->update('user', $row);	
			$this->load->view('activate_view');
		}else {
		// Sent Something to User that Activation Process can't be Success with some reason
		// eg. User not found.
		echo 'Error to Active Account';
		}
	}else {
		echo 'false';
	}
		
	}
	
}