<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Adminphoto extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
			$this->load->scaffolding('user_photo');
	}
	
	//php 4 constructor
	function Adminphoto() {
		parent::Controller();
	}
	
	function index() {
		
	}

}