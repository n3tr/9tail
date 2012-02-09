<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Adminalbum extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
			$this->load->scaffolding('photo_album');
	}
	
	//php 4 constructor
	function Adminalbum() {
		parent::Controller();
	}
	
	function index() {
		
	}

}