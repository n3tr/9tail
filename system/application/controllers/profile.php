<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Profile extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
	}
	
	function index() {
		$this->load->view('profile_view');
	}

}