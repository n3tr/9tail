<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Admintip extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
			$this->load->scaffolding('tip');
	}
	
	//php 4 constructor
	function Admintip() {
		parent::Controller();
	}
	
	function index() {
		
	}

}