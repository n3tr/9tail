<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class User extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
		$this->load->library('friendlib');
	}
	
	function index()
	{
		$userdata = $this->session->userdata('userdata');
		//$this->profile($userdata['screen_name']);
		redirect('/user/'. $userdata['screen_name']);
	}
	
	function profile($user)
	{
		
		$userdata = $this->session->userdata('userdata');
		if ($userdata['logged_in'] == FALSE) {
			redirect('/login');
		}else if($this->uri->segment(2) == $userdata['screen_name']){
			
			$this->db->where('screen_name', $userdata['screen_name']);
			$q = $this->db->get('user');
			$owner_data =$q->first_row('array');
			$data['owner_data'] =  $owner_data;
			

			$this->db->from('messages');
			$this->db->join('user', 'user.id = messages.from');
			$this->db->where('to', $owner_data['id']);
				$this->db->select('
				messages.id,
				messages.to,
				messages.from,
				messages.text,
				messages.datetime,
				user.screen_name
				');
				
			$this->db->order_by('datetime','desc'); 
			$q = $this->db->get();
			
			//print_r($q->result('array'));die();
		
			$data['messages'] = $q->result('array');
			$data['friend_count'] = $this->friendlib->get_friend_count($userdata['user_id']);
			$this->load->view('owner_user_view',$data);
			
		}else if($this->uri->segment(2) == TRUE){
		
			
				
				$this->db->where('screen_name', $this->uri->segment(2));
				$q = $this->db->get('user');
				
				if ($q->num_rows() > 0) {
					
					$user_data = $q->first_row('array');
					$data['user_data'] = $user_data;
					$this->db->where('screen_name', $userdata['screen_name']);
					$q = $this->db->get('user');
					$owner_data =$q->first_row('array');
					$data['owner_data'] =  $owner_data;



					$this->db->from('messages');
					$this->db->join('user', 'user.id = messages.from');
					$this->db->where('to', $user_data['id']);
						$this->db->select('
						messages.id,
						messages.to,
						messages.from,
						messages.text,
						messages.datetime,
						user.screen_name
						');

					$this->db->order_by('datetime','desc'); 
					$q = $this->db->get();

				//	print_r($q->result('array'));die();

					$data['messages'] = $q->result('array');
					$data['friend_count'] = $this->friendlib->get_friend_count($user_data['id']);
					
					
					// is Friend
					if ($this->friendlib->check_friend($userdata['user_id'],$user_data['id']) == 2){
						$this->load->view('user_view',$data);
						
					// Check Pendding
					}else if ($this->friendlib->check_friend($userdata['user_id'],$user_data['id']) == 1) {
						
						//Check user request
						if ($this->friendlib->who_added($userdata['user_id'],$user_data['id']) == $userdata['user_id']) {
							echo 'pendding request';
						}else {
							echo 'Comfirm Here';
						}
						
						// not Friend
					}else {
						$this->load->view('user_not_friend',$data);
						//echo "not friend";
					}
					
					
					
		
					
				}else{
					
					echo "user not found";
				}
			
					
		}else{
			echo "Something wrong !!";
		}
	}

}