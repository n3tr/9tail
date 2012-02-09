<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Profile extends CI_Controller {

	//php 5 constructor
	function __construct() {
		parent::__construct();
	}
	
	
	function index() {
		
	}
	
	function user($profile_id=FALSE){
		
		$sessiondata = $this->session->userdata('userdata');
		
		if (!$sessiondata['logged_in']) {
			redirect('login');
		}
		
		
		$user_data = $this->db->get_where('user', array('id'=>$sessiondata['user_id']), 1)->first_row('array');
		
		if(!$profile_id){
			$profile_data = $user_data;
		}else{
			$profile_data = $this->db->get_where('user', array('id'=>$profile_id),1)->first_row('array');
		}
		
		$this->db->select('*');
		$this->db->from('messages');
		$this->db->join('user', 'user.id = messages.from');
		$this->db->where('to', $profile_data['id']);
		$this->db->limit(10);
		$this->db->order_by('datetime','desc');
		$status = $this->db->get()->result('array');

		$data['messages'] = $status;
		$data['user_data'] = $user_data;
		$data['profile_data'] = $profile_data;
		
		$this->load->view('profile/user',$data);
		
	}
	
	function getstatus()
	{
	
		$userid = $this->input->post('userid', TRUE);
		
		$this->db->select('*');
		$this->db->from('messages');
		$this->db->join('user', 'user.id = messages.from');
		$this->db->where('to', $userid);
		$this->db->limit(10);
		$this->db->order_by('datetime','desc');
		$status = $this->db->get();
		
		$data['status'] = $status->result('array');

		$this->load->view('ajax/statusofuser',$data);
	}
	
	function postmessage()
	{
		$text = $this->input->post('post_text', TRUE);
		$from = $this->input->post('from', TRUE);
		$to = $this->input->post('to', TRUE);
		$message = array(
			'text' => $text,
			'from' => $from,
			'to' => $to,
			'datetime' => date("Y-m-d H:i:s")
			);
		
		$this->db->insert('messages', $message);
		
	
			$this->db->select('*');
			$this->db->from('messages');
			$this->db->join('user', 'user.id = messages.from');
			$this->db->where('to', $message['to']);
			$this->db->where('datetime', $message['datetime']);
			$this->db->limit(1);
			$this->db->order_by('datetime','desc');
			$status = $this->db->get()->first_row('array');
			
		$data['json_data'] = $status;
		$this->load->view('ajax/return_json',$data);
	}
	
	function photo($profile_id=FALSE)
	{
			$sessiondata = $this->session->userdata('userdata');

			if (!$sessiondata['logged_in']) {
				redirect('login');
			}


			$user_data = $this->db->get_where('user', array('id'=>$sessiondata['user_id']), 1)->first_row('array');

			if(!$profile_id){
				$profile_data = $user_data;
			}else{
				$profile_data = $this->db->get_where('user', array('id'=>$profile_id),1)->first_row('array');
			}
			
			$this->db->select('*');
			$this->db->from('user_photo');
		
			$this->db->where('user_id', $profile_data['id']);
			$this->db->limit(20);
			$this->db->order_by('datetime','desc');
			$photo = $this->db->get()->result('array');

			$data['photo_data'] = $photo;
			$data['user_data'] = $user_data;
			$data['profile_data'] = $profile_data;

			$this->load->view('profile/photo',$data);
			
	}
	
	function photoid($photo_id=FALSE)
	{
			$sessiondata = $this->session->userdata('userdata');

			if (!$sessiondata['logged_in']) {
				redirect('login');
			}
			
			$this->db->select('*');
			$this->db->from('user_photo');
			$this->db->where('id', $photo_id);
			$this->db->limit(1);
			$photo_data = $this->db->get()->first_row('array');


			$user_data = $this->db->get_where('user', array('id'=>$sessiondata['user_id']), 1)->first_row('array');

			if($user_data['id'] == $photo_data['user_id']){
				$profile_data = $user_data;
			}else{
				$profile_data = $this->db->get_where('user', array('id'=>$photo_data['user_id']),1)->first_row('array');
			}
			
			
			$data['photo_data'] = $photo_data;
			$data['user_data'] = $user_data;
			$data['profile_data'] = $profile_data;

			$this->load->view('photo/photo_viewer',$data);
	}

}