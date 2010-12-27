<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Photo extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
		$this->load->helper('file');
	}
	
	//php 4 constructor
	function Photo() {
		parent::Controller();
		$this->load->helper('file');
	}
	
	function index() {
		
		$userdata = $this->session->userdata('userdata');
		if (!$userdata['logged_in']) {
			redirect('/login','refresh');
			return;
		
		}else{
			$this->user();
		}
		
//$this->load->view('user_photo/photo_upload_view');
	}
	
	function user($user_screen_name=null)
	{
		$userdata = $this->session->userdata('userdata');
		if (!$userdata['logged_in']) {
			redirect('/login','refresh');
			return;
		}
		
		if(!isset($user_screen_name)){
			$this->db->where('user_id', $userdata['user_id']);
			$q = $this->db->get('photo_album');
			
			if($q->num_rows>0){
				$data['album_list'] = $q->result('array');
			}
			$q = $this->db->get_where('user', array('id'=>$userdata['user_id']),1);
			$data['user_data'] = $q->first_row('array');
			$data['owner_data'] = $q->first_row('array');
			$this->load->view('user_photo/list_album_view',$data);
		}else{
			$owner_data = $this->db->get_where('user', array('id'=>$userdata['user_id']), 1)->first_row('array');
			$data['owner_data'] = 	$owner_data;
			
			$q=$this->db->get_where('user', array('screen_name'=>$user_screen_name),1);
			
			if($q->num_rows() == 0){
				show_404('page');
				//	$this->load->view('profile/user_not_found',$data);
					return;
			}
			
			$_userdata = $q->first_row('array');
			
			$this->db->where('user_id', $_userdata['id']);
			$q = $this->db->get('photo_album');
			
			if($q->num_rows>0){
				$data['album_list'] = $q->result('array');
			}

			$q = $this->db->get_where('user', array('id'=>$userdata['user_id']), 1);
			$data['user_data'] = $_userdata;
		$data['friend_count'] = $this->friendlib->get_friend_count($_userdata['id']);
			
			if($this->friendlib->check_friend($owner_data['id'],$_userdata['id']) == 2 || $owner_data['id'] == $_userdata['id'] ){
				$this->load->view('user_photo/list_album_view',$data);
			}else{

				if ($this->friendlib->check_friend($userdata['user_id'],$_userdata['id']) == 1) {

					//Check user request
					if ($this->friendlib->who_added($userdata['user_id'],$_userdata['id']) == $userdata['user_id']) {
						$data['friend_pedding'] = 1;
						$this->load->view('profile/pedding_request',$data);
					}else {
						$friend_guid = $this->friendlib->friend_guid($_userdata['id'],$userdata['user_id']);

						$data['friend_guid'] = $friend_guid;
						$this->load->view('profile/pedding_request',$data);

					}

					// not Friend
				}else {
					$this->load->view('profile/pedding_request',$data);
				}
			}
			
			
		}
		
		
	}
	
	function id($id=null)
	{
		$userdata = $this->session->userdata('userdata');
		if (!isset($userdata['logged_in'])) {
			redirect('/login','refresh');
			return;
		}
		
	
		$q = $this->db->get_where('user_photo', array('id'=>$id), 1);
		if($q->num_rows() == 0){
			show_404('page');
			//	$this->load->view('profile/user_not_found',$data);
				return;
		}
			
		$photo = $q->first_row('array');
		$data['photo'] = $photo;
		
		$_userdata = $this->db->get_where('user', array('id'=>$photo['user_id']))->first_row('array');
		$data['user_data'] = $_userdata;
		
		$q = $this->db->get_where('user', array('id'=>$userdata['user_id']),1);
		$owner_data = $q->first_row('array');
		$data['owner_data'] = $owner_data;
		$data['friend_count'] = $this->friendlib->get_friend_count($_userdata['id']);
	
		if($this->friendlib->check_friend($owner_data['id'],$_userdata['id']) == 2 || $owner_data['id'] == $_userdata['id'] ){
		$this->load->view('user_photo/single_photo_view',$data);
		}else{
			
			if ($this->friendlib->check_friend($userdata['user_id'],$_userdata['id']) == 1) {

				//Check user request
				if ($this->friendlib->who_added($userdata['user_id'],$_userdata['id']) == $userdata['user_id']) {
					$data['friend_pedding'] = 1;
					$this->load->view('profile/pedding_request',$data);
				}else {
					$friend_guid = $this->friendlib->friend_guid($_userdata['id'],$userdata['user_id']);
				
					$data['friend_guid'] = $friend_guid;
					$this->load->view('profile/pedding_request',$data);
					
				}
				
				// not Friend
			}else {
				$this->load->view('profile/pedding_request',$data);
			}
		}
	}
	
	function upload()
	{
	
		$userdata = $this->session->userdata('userdata');
		if (!$userdata['logged_in']) {
			redirect('/login','refresh');
			return;
		}
		
		
	//	$file_name = md5('user_photo' . $userdata['screen_name'] . date("Y-m-d H:i:s"));
	//	$config['upload_path'] = realpath(APPPATH . '../../files/temp');
	//	$config['allowed_types'] = 'gif|jpg|jpeg|png';
	//	$config['max_size'] = '3000';
	 //	$config['file_name'] = $file_name.'.jpg';
	//	$config['encrypt_name'] = TRUE;
		
		$uploadCon = array(
			'upload_path' => realpath(APPPATH . '../../files/temp'),
			'allowed_types' => 'gif|jpg|jpeg|png',
			'max_size' => '2000',
			'encrypt_name' => TRUE
			);
		
		$this->load->library('upload', $uploadCon);
		
		if (!$this->upload->do_upload()) {
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
		}else {
			$uploadData = array('upload_data' => $this->upload->data());
			$imgData = $uploadData['upload_data'];
	
			$imageCon = array(
				'image_library' => 'gd2',
				'source_image' => $imgData['full_path'],
				'maintain_ratio' => TRUE,
				'new_image' => APPPATH . '../../files/user_photo/' . $imgData['file_name']
				);
				
				if($imgData['image_width'] > 720){
					$imageCon['width'] = 720;
				}
				
				if($imgData['image_height'] > 720){
					$imageCon['height'] = 720;
				}
				
			$this->load->library('image_lib',$imageCon);
			if($this->image_lib->resize()){
				
				$this->image_lib->clear();
				
				$imgThumbCon = array(
					'image_library' => 'gd2',
					'source_image' => $imgData['full_path'],
					'maintain_ratio' => TRUE,
					'width' => 200,
					'height' => 200,
					'new_image' => APPPATH . '../../files/user_photo/thumb/' . 'thumb_' . $imgData['file_name']
					
					);
					
					if($imgData['image_height'] > $imgData['image_width']){
						$imgThumbCon['master_dim'] = 'width';
						
					
					}else if ($imgData['image_height'] < $imgData['image_width']) {
						$imgThumbCon['master_dim'] = 'height';
		
					}
					
					$this->image_lib->initialize($imgThumbCon);
					if ($this->image_lib->resize()) {
						// Create 200*200 thumbnail
						
						$this->image_lib->clear();
						
						$imgSmallThumbCon = array(
						   	'image_library' => 'gd2',
						   	'source_image' => APPPATH . '../../files/user_photo/thumb/' . 'thumb_' . $imgData['file_name'],
						'maintain_ratio'=>FALSE
						);
						$this->load->helper('file');
						$fileinfo = getimagesize(realpath($imgSmallThumbCon['source_image']));
						
						$center_x = $fileinfo[0] / 2;
						$center_y = $fileinfo[1] / 2;
						if($fileinfo[0] > $fileinfo[1]){
							$imgSmallThumbCon['x_axis'] = $center_x - 100 ;
							$imgSmallThumbCon['y_axis'] = 0;
							$imgSmallThumbCon['width'] = 200;
						
							//	$imgSmallThumbCon['y_axis'] = 100;
						}else if ($fileinfo[0] < $fileinfo[1]) {
						
								$imgSmallThumbCon['x_axis'] = 0 ;
								$imgSmallThumbCon['y_axis'] = $center_y - 100;
								$imgSmallThumbCon['height'] = 200;
							//	$imgSmallThumbCon['x_axis'] = 100;
						}
						$this->image_lib->initialize($imgSmallThumbCon);
						
						if ($this->image_lib->crop()) {
						
							$user_photo = array(
								'album_id' => $this->input->post('album_id', TRUE),
								'user_id' => $userdata['user_id'],
								'lat' => '',
								'lng' =>'',
								'datetime'=> date("Y-m-d H:i:s"),
								'path' => $imgData['file_name'],
								'thumb_path'=> 'thumb_' . $imgData['file_name']
							);
							
							$this->db->insert('user_photo', $user_photo);
							$this->load->helper('file');
							unlink(realpath(APPPATH . '../../files/temp/' . $imgData['file_name']));
							redirect('album/id/' . $user_photo['album_id'],'refresh');
							
						}else{
							echo $this->image_lib->display_errors('<p>', '</p>');
						}
						
						
					
					}else {
						echo $this->image_lib->display_errors('<p>', '</p>');
					}
				
			}else{
				echo $this->image_lib->display_errors('<p>', '</p>');
			}
			
		}
	}

}