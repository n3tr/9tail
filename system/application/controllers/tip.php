<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Tip extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
	}
	
	function index() {
		
	}
	
	function addtip(){
		
		$userdata = $this->session->userdata('userdata');
		
		if(!$userdata['logged_in'])
		{
			redirect('/login/','refresh');
			return;
		}
		
		
		$tip_text = $this->input->post('tip_text', TRUE);
		$user_id = $this->input->post('tip_user_id', TRUE);
		$place_id = $this->input->post('tip_place_id', TRUE);
		
	

		$tip = array('text' => $tip_text, 
		'user_id' => $user_id,
		'place_id' => $place_id,
		'datetime' => date("Y-m-d H:i:s")
		);
		
		$this->db->insert('tip', $tip);
		
		if($this->input->post('ajax')){
			$this->db->where('place_id', $place_id);
			$this->db->where('user_id',$user_id);
			$this->db->order_by('datetime','desc');
			$tip_q = $this->db->get('tip',1);
			$tip_data = $tip_q->first_row('array');
			
			$this->db->select('id,firstname,lastname,screen_name,thumbnail,small_thumbnail');
			$this->db->where('id', $tip_data['user_id']);
			$user_q = $this->db->get('user',1);
			
			$data['tip'] = $user_q->first_row('array');
			$data['user'] = $tip_data;
			$this->load->view('tip/tip_profile_result',$data);
			return;
		}
	
	
		redirect('/user/'.$userdata['screen_name']);
	
	}
	
	// This use for AJAX Call in Place View Only
	function addtip_from_place()
	{
			$tip_text = $this->input->post('tip_text', TRUE);
			$user_id = $this->input->post('user_id', TRUE);
			$place_id = $this->input->post('place_id', TRUE);
			$tip = array('text' => $tip_text, 
				'user_id' => $user_id,
				'place_id' => $place_id,
				'datetime' => date("Y-m-d H:i:s")
			);
			
			$this->db->insert('tip', $tip);
			if($this->input->post('ajax')){
				
					$this->db->where('datetime',$tip['datetime']);
					$tip_q = $this->db->get('tip',1);
					$tip_data = $tip_q->first_row('array');

					$this->db->select('id,firstname,lastname,screen_name,thumbnail,small_thumbnail');
					$this->db->where('id', $tip_data['user_id']);
					$user_q = $this->db->get('user',1);
					$data['tip'] = $tip_data;
					$data['user'] = $user_q->first_row('array');
					
				
				
				$this->load->view('ajax/addtip_return',$data);
				return;
			}
	
			
			
		
		
	}

}