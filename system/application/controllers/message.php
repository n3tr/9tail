<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Message extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
	}
	
	function index() {
		
	}
	
	function post()
	{
		$userdata = $this->session->userdata('userdata');
		if ($userdata['logged_in']  && $userdata['user_id'] == $this->input->post('from')) {
			$message = array(
				'text' => $this->input->post('text'),
				'from' => $this->input->post('from'),
				'to' => $this->input->post('to'),
				'datetime' => date("Y-m-d H:i:s")
				);

			if($message['text'] != ''){
				$this->db->insert('messages', $message);
				if($this->input->post('from') == $this->input->post('to')){
				redirect('/user/');
				}else {
					$this->db->select('screen_name');
					$this->db->where('id',$this->input->post('to'));
					$q = $this->db->get('user');
					$user = $q->first_row('array');
					
					redirect('/user/' . $user['screen_name']);
				}
			}else{
					$this->db->select('screen_name');
					$this->db->where('id',$this->input->post('to'));
					$q = $this->db->get('user');
					$user = $q->first_row('array');
					
					redirect('/user/' . $user['screen_name']);
				redirect('/user/');
			}
		}else{
			echo 'error';
			
		}
		
			
	}

}