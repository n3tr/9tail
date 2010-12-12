<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Friend extends Model {
	
	var $to = '';
	var $from = '';
	var $datetime ='';
	var $guid = '';
	var $status = '';
	//php 5 constructor
	function __construct() {
		parent::Model();
	}
	
	//php 4 constructor
	function Friend() {
		parent::Model();
	}
	
	function function_name() {
		
	}

}