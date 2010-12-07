<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Session extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
		$this->load->library('encrypt');
		$this->load->helper('date');
	}
	
	function index() {
		
	}
	
	// Login form submot to here and Validation that form
	function login()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email','Email','required|trim|valid_email');
		$this->form_validation->set_rules('password','password','required|trim');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('login_view');
		}
		else {
			
		}
	}

}