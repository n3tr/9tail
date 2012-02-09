<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Adminplace extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
			$this->load->scaffolding('place');
	}
	
	//php 4 constructor
	function Adminplace() {
		parent::Controller();
	}
	
	function index() {
		
	}

}