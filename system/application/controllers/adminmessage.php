<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Adminmessage extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
			$this->load->scaffolding('messages');
	}
	
	//php 4 constructor
	function Adminmessage() {
		parent::Controller();
	}
	
	function index() {
		
	}

}