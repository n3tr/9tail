<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Adminreport extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
			$this->load->scaffolding('user_report');
	}
	

}