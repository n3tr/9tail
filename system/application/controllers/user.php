<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class User extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
		$this->load->library('friendlib');
		$this->load->library('locationlib');
	}
	
	function index()
	{
		$userdata = $this->session->userdata('userdata');
		if ($userdata['logged_in']) {
			redirect('/user/'. $userdata['screen_name']);
		}else{
			redirect('/login/','Refresh');
		}
		//$this->profile($userdata['screen_name']);
		
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
				user.screen_name,
				user.small_thumbnail
				');
				
			$this->db->order_by('datetime','desc'); 
			$q = $this->db->get();
			
			$last_checkin = $this->locationlib->get_last_checkin_of_user($userdata['user_id']);
			
			$this->db->from('tip');
			$this->db->join('user', 'user.id = tip.user_id');
			$this->db->where('place_id', $last_checkin['place_id']);
			$this->db->select('
			tip.id,
			tip.text,
			tip.datetime,
			user.screen_name,
			user.small_thumbnail
			');
			$this->db->order_by('datetime','desc');
			$tip = $this->db->get();

			
			//print_r($q->result('array'));die();
			
			$data['tips'] = $tip->result('array');
			$data['messages'] = $q->result('array');
			$data['friend_count'] = $this->friendlib->get_friend_count($userdata['user_id']);
			$data['last_checkin'] = $last_checkin;
			$data['user_in_location'] = $this->locationlib->who_checkin_in($last_checkin['place_id']);
			
			
			
			$this->load->view('profile/owner_user_view',$data);
			
		}else if($this->uri->segment(2) == TRUE){
		
			
				$this->db->where('id', $userdata['user_id']);
				$q = $this->db->get('user');
				$owner_data =$q->first_row('array');
				$data['owner_data'] =  $owner_data;
				
				$this->db->where('screen_name', $this->uri->segment(2));
				$q = $this->db->get('user');
				
				if ($q->num_rows() > 0) {
					
					$user_data = $q->first_row('array');
					$data['user_data'] = $user_data;
					



					$this->db->from('messages');
					$this->db->join('user', 'user.id = messages.from');
					$this->db->where('to', $user_data['id']);
						$this->db->select('
						messages.id,
						messages.to,
						messages.from,
						messages.text,
						messages.datetime,
						user.screen_name,
						user.small_thumbnail
						
						');

					$this->db->order_by('datetime','desc'); 
					$q = $this->db->get();

				//	print_r($q->result('array'));die();

					$data['messages'] = $q->result('array');
					$data['friend_count'] = $this->friendlib->get_friend_count($user_data['id']);
					$last_checkin = $this->locationlib->get_last_checkin_of_user($user_data['id']);
					$data['last_checkin'] = $last_checkin;
					$data['user_in_location'] = $this->locationlib->who_checkin_in($last_checkin['place_id']);
					// is Friend
					
				
					if ($this->friendlib->check_friend($userdata['user_id'],$user_data['id']) == 2){
						
						
						$this->load->view('profile/user_view',$data);
						
						
					// Check Pendding
					}else if ($this->friendlib->check_friend($userdata['user_id'],$user_data['id']) == 1) {
						
						//Check user request
						if ($this->friendlib->who_added($userdata['user_id'],$user_data['id']) == $userdata['user_id']) {
							$data['friend_pedding'] = 1;
							$this->load->view('profile/pedding_request',$data);
						}else {
							$friend_guid = $this->friendlib->friend_guid($user_data['id'],$userdata['user_id']);
						
							$data['friend_guid'] = $friend_guid;
							$this->load->view('profile/pedding_request',$data);
							
						}
						
						// not Friend
					}else {
						$this->load->view('profile/pedding_request',$data);
					}
					
				}else{
					
					$this->load->view('profile/user_not_found',$data);
				}
			
					
		}else{
			echo "Something wrong !!";
		}
	}
	
	function set_profile_image($photo_id)
	{
		$userdata = $this->session->userdata('userdata');
		
		if(!$userdata['logged_in']){
			redirect('/login','refresh');
			return;
		}
		
		$photo = $this->db->get_where('user_photo', array('id'=>$photo_id), 1)->first_row('array');
		if($userdata['user_id'] == $photo['user_id']){
			
			
			
			$user = array(
				'thumbnail' => $photo['thumb_path'], 
				'small_thumbnail'=> $photo['thumb_path']
				);
			
			$this->db->where('id', $userdata['user_id']);
			$this->db->update('user', $user);
			redirect('/photo/id/'.$photo_id,'refresh');
		}
		
		
		
	}
	
	
}