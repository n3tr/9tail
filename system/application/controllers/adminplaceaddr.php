<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Adminplaceaddr extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
			$this->load->scaffolding('place_address');
	}
	
	//php 4 constructor
	function Adminplace() {
		parent::Controller();
	}
	
	function index() {
		
	}

}