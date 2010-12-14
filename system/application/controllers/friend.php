<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Friend extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
	}
	
	function index()
	{
		$userdata = $this->session->userdata('userdata');
		
		$this->db->where('to', $userdata['user_id']);
		$this->db->join('user', 'user.id = friend.from');
		$q = $this->db->get('friend');
		$data['owner_data'] = $this->db->get_where('user', array('id'=>$userdata['user_id']),1);
		$data['friend_list'] = $q->result('array');
		$this->load->view('friend_list_view', $data);
	}
	
	function request_friend($to_user) {
		$userdata = $this->session->userdata('userdata');
		$user_id = $userdata['user_id'];
		
		$q = $this->db->get_where('user', array('screen_name'=> $to_user), 1);
		if($q->num_rows > 0){
			$user = $q->first_row('array');
			
			$this->load->library('encrypt');
			$guid = $this->encrypt->sha1($userdata['screen_name'].$to_user);
			$this->friendlib->request($userdata['user_id'],$user['id'],$guid);
			redirect('/user/' . $to_user);
		}
	
	}
	
	function confirm($guid=null,$from_user=null)
	{
		if(isset($guid)){
			
			// user who was added by other
			$this->db->where('guid', $guid);
			$q = $this->db->get("friend");
			$user = $q->first_row('array');
			
			$this->db->where('id',$user['to']);
			$quser = $this->db->get('user');
			
			$ownuser = $quser->first_row('array');
			
			$userdata = $this->session->userdata('userdata');
			if ($userdata['user_id'] == $ownuser['id']) {
				//echo 'confirm';
				$this->db->where('guid',$guid);
				$this->db->update('friend',array('status'=>1)); 
				
				if(isset($from_user)){
					
					redirect('/user/'.$from_user);
					
				}else {
					redirect('/friend/request_list');
				}
				
			}else {
				redirect('/login');
			}
			
		
			//echo $user;
		}
	}
	function request_list()
	{
		$userdata =$this->session->userdata('userdata');
		
		if ($userdata['logged_in']) {
			
			
			$this->db->select('*');
			//$this->db->from('friend')->where(array('to' => $userdata['user_id'],'status'=>0 ));
			$this->db->where('to',$userdata['user_id']);
			$this->db->join('user', 'user.id = friend.from');
			
			$q = $this->db->get('friend');
		
			//$q = $this->db->get_where('friend', array('to'=>$userdata['user_id'],'status'=>0));
		
			if ($q->num_rows() > 0) {
				
				$data['request_list'] = $q->result('array');
				
				$this->db->where('id', $userdata['user_id']);
				$q = $this->db->get('user');
				
				$data['owner_data'] = $q->first_row('array');
				$this->load->view('request_list_view', $data);
				
			}else{
				$this->db->where('id', $userdata['user_id']);
				$q = $this->db->get('user');
				$owner_user = $q->first_row('array');
				$data['owner_data'] = $owner_user;
				$this->load->view('request_list_view', $data);
			}
		}
		
		
	}

}