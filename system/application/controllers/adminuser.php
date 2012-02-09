<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Adminuser extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
		
		$this->load->scaffolding('user');
	}
	
	//php 4 constructor
	function Adminuser() {
		parent::Controller();
	}
		

}