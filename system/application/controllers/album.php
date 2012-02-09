<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Album extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
	}
	
	//php 4 constructor
	function Album() {
		parent::Controller();
	}
	
	function index() {
		
$userdata = $this->session->userdata('userdata');
		if($userdata['logged_in']){
			$this->user();
		}else{
			redirect('/login','refresh');
			return;
		}
	}
	
	function create()
	{
		
		$userdata = $this->session->userdata('userdata');
		if (!$userdata['logged_in']) {
			redirect('/login','Refresh');
			return;
		}
		
			$q = $this->db->get_where('user', array('id'=>$userdata['user_id']),1);
			$data['user_data'] = $q->first_row('array');
			$data['owner_data'] = $q->first_row('array');
		$this->load->view('album/create_album_view', $data);
	}
	
	function created()
	{
		$userdata = $this->session->userdata('userdata');
		if (!$userdata['logged_in']) {
			redirect('/login','Refresh');
			return;
		}
		
		$this->form_validation->set_rules('album_name','Album Name','required');
		
		if ($this->form_validation->run()) {
			$name = $this->input->post('album_name', TRUE);
			
			$albumdata = array(
				'name' => $name,
				'place_id' => '',
				'user_id' => $userdata['user_id'],
				'create_date' => date("Y-m-d H:i:s")
				);
			$this->db->insert('photo_album', $albumdata);
			redirect('/photo','refresh');
			
		}
		
		
	}
	
	function id($id=null)
	{
		$userdata = $this->session->userdata('userdata');
		if($userdata['logged_in']){
			if (isset($id)) {
				$data['owner_data'] = $this->db->get_where('user', array('id'=>$userdata['user_id']), 1)->first_row('array');
				$q = $this->db->get_where('photo_album', array('id'=>$id), 1);
					if($q->num_rows() == 0){
						show_404('page');
						//	$this->load->view('profile/user_not_found',$data);
							return;
					}
			
				$album = $q->first_row('array');
				
				$userdata = $this->db->get_where('user', array('id'=>$album['user_id']), 1);
			
				
				$data['album'] = $album;
				
				$q = $this->db->get_where('user_photo',array('album_id'=>$album['id'],'user_id'=>$album['user_id']));
				
				if($q->num_rows > 0){
				
					$data['photos'] = $q->result('array');
				}
				
			
				$data['user_data'] = $this->db->get_where('user', array('id'=>$album['user_id']),1)->first_row('array');
				
				$this->load->view('album/album_photo_view', $data);
			}
			
			
		}else{
			redirect('/login','refresh');
			return;
		}
	}
	
	function set_thumb($photo_id=null)
	{
		$userdata = $this->session->userdata('userdata');
		if (!isset($userdata['logged_in'])) {
			redirect('/login/','refresh');
			return;
		}
		
		if(!isset($photo_id)){
			redirect('/photo/id'.$photo_id);
			return;
		}
		
		$photo = $this->db->get_where('user_photo', array('id'=>$photo_id), 1)->first_row('array');
		
		if($userdata['user_id'] == $photo['user_id']) {
			$album = array(
				'thumb_path' => $photo['thumb_path']
				);
				
				$this->db->where('id', $photo['album_id']);
				$this->db->update('photo_album',$album);
				redirect('/album/id/'.$photo['album_id']);
		}else{
			redirect('/photo/id'.$photo_id);
		}
	}

}