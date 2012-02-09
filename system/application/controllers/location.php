<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Location extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
	}
	
	function index() {
		$this->create();
	}
	
	function create()
	{
		
		$userdata = $this->session->userdata('userdata');
		if (!$userdata['logged_in']) {
			redirect('/login/');
	
		}else {
			
			
				$data['owner_data'] =  $userdata;
			
			$this->load->view('location/create_location_view',$data);
			
		}
	}
	
	function place($place_id=FALSE)
	{
		$sessiondata = $this->session->userdata('userdata');
		if (!$sessiondata['logged_in']) {
			redirect('/login','refresh');
			return;
		}
		
		if(!$place_id)	show_404();
		
		
		// Query Place data
		$this->db->select('*');
		$this->db->from('place');
		$this->db->join('place_address', 'place.id = place_address.place_id');
		$this->db->where('place.id', $place_id);
		$this->db->limit(1);
		$place_q = $this->db->get();
		$placedata = $place_q->first_row('array');
		
		
		// Query Userdata
		$user_q = $this->db->get_where('user', array('id'=>$sessiondata['user_id']), 1);
		$userdata = $user_q->first_row('array');
		
		// Query Tip of Place
		$tip_q = $this->db->select('*')->from('tip')->join('user','tip.user_id = user.id')->where('place_id',$placedata['id'])->order_by('datetime','desc')->limit(5)->get();
		$tipdata = $tip_q->result('array');
		
	
	
	
		$photo_data = $this->db->select('*')->from('place_photo')->where('place_id',$place_id)->order_by('datetime','desc')->limit(10)->get()->result('array');
		
		
		$this->load->library('locationlib');
		$data['user_in_location'] = $this->locationlib->who_checkin_in($placedata['place_id']);
		$data['place_data'] = $placedata;
		$data['user_data'] = $userdata;
		$data['tip_data'] = $tipdata;
		
		
		
		$data['photo_data'] = $photo_data;
		$this->load->view('location/place_view',$data);
		
		
	}
	
	function searchbyuser()
	{
		$lat = $this->input->post('lat_field', TRUE);
		$lng = $this->input->post('lng_field', TRUE);
	
		/*
		$this->load->library('rest', array(
		    'server' => 'http://maps.googleapis.com/maps/api/geocode/'
		));
		*/
	
		
		$q_text = 'http://maps.googleapis.com/maps/api/geocode/';
		$q_text = $q_text . 'json?latlng='.$lat.','.$lng.'&sensor=false';
		$location = json_decode((file_get_contents($q_text)));	
			
		if ($location->status == 'OK') {
				redirect('/location/create_info/'.$lat.'/'.$lng);
			}else if ($location->status == 'ZERO_RESULTS') {
				echo "Something wrong";
				echo "<br/>Please Try Again !!";
			}
	}
	
	function create_info($lat,$lng)
	{
		//$this->load->library('rest', array(
		//    'server' => 'http://maps.googleapis.com/maps/api/geocode/'
		//));
		
	
		$q_text = 'http://maps.googleapis.com/maps/api/geocode/';
	
		$q_text = $q_text . 'json?latlng='.$lat.','.$lng.'&sensor=false';
		$location = json_decode((file_get_contents($q_text)));	
		//$location = $this->rest->get($q_text);
		
			if ($location->status == 'OK') {
				$map_results = $location->results;
				foreach ($map_results[0]->address_components as $address) {
					switch ($address->types[0]) {
						case 'route':
							$location_data['route'] = $address->long_name;
							break;
						case 'locality':
							$location_data['locality'] = $address->long_name;
							break;
						case 'administrative_area_level_3':
							$location_data['amphoe'] = $address->long_name;
							break;	
						case 'administrative_area_level_1':
							$location_data['province'] = $address->long_name;
							break;
						case 'country':
							$location_data['country'] = $address->long_name;
							break;
						case 'postal_code':
							$location_data['postal_code'] = $address->long_name;
							break;
						default:
							break;
					}
				}
				$location_data['lat'] = $map_results[0]->geometry->location->lat;
				$location_data['lng'] = $map_results[0]->geometry->location->lng;
				$data['location_data'] = $location_data;
			
				$data['owner_data'] =  $this->session->userdata('userdata');;
				$this->load->view('location/create_info_view', $data);
				
				 						
				
					
			}else if ($location->status == 'ZERO_RESULTS') {
				echo "Something wrong";
				echo "<br/>Please Try Again !!";
			}
	}
	
	function searchbytext()
	{
		$userdata = $this->session->userdata('userdata');
		if($userdata['logged_in']){
		$this->form_validation->set_rules('location_search_text','Search Text','required');
		
		if($this->form_validation->run()){
			$inputtext = $this->input->post('location_search_text');
			$newtext = str_replace(" ", "+", $inputtext);
			/*
			$this->load->library('rest', array(
			    'server' => 'http://maps.googleapis.com/maps/api/geocode/'
			));
		*/
			$q_text = 'http://maps.googleapis.com/maps/api/geocode/';
			$q_text = $q_text . 'json?address='.$newtext.'&sensor=false';
			$location = json_decode((file_get_contents($q_text)));
			//$location = $this->rest->get($q_text);

				if ($location->status == 'OK') {
					$map_results = $location->results;
					foreach ($map_results[0]->address_components as $address) {
						switch ($address->types[0]) {
							case 'route':
								$location_data['route'] = $address->long_name;
								break;
							case 'locality':
								$location_data['locality'] = $address->long_name;
								break;
							case 'administrative_area_level_3':
								$location_data['amphoe'] = $address->long_name;
								break;	
							case 'administrative_area_level_1':
								$location_data['province'] = $address->long_name;
								break;
							case 'country':
								$location_data['country'] = $address->long_name;
								break;
							case 'postal_code':
								$location_data['postal_code'] = $address->long_name;
								break;
							default:
								break;
						}
					}
					$location_data['lat'] = $map_results[0]->geometry->location->lat;
					$location_data['lng'] = $map_results[0]->geometry->location->lng;
					$data['location_data'] = $location_data;
					
					
					$data['owner_data'] =  $userdata;
					$this->load->view('location/create_info_view', $data);




				}else if ($location->status == 'ZERO_RESULTS') {
					echo "Something wrong";
					echo "<br/>Please Try Again !!";
				}
			
			
		}else{
			$this->load->view('create_location_view');
		}
		
	}else{
		redirect('login/');
	}
	}

	
	function location_created()
	{
		
		
		$userdata = $this->session->userdata('userdata');
		if($userdata['logged_in']){
		$this->form_validation->set_rules('location_name','Location Name','required|max_length[255]');
		$this->form_validation->set_rules('location_description','Location Description','max_length[520]');
		$this->form_validation->set_rules('location_tambon','Tambon Name','max_length[255]');
		$this->form_validation->set_rules('location_amphoe','Amphoe Name','max_length[255]');
		$this->form_validation->set_rules('location_address','Amphoe Name','max_length[255]');
		$this->form_validation->set_rules('location_province','Province Name','max_length[255]');
		$this->form_validation->set_rules('location_country','Country Name','max_length[255]');
		$this->form_validation->set_rules('location_postal_code','Postal Code','numeric|max_length[10]');
		$this->form_validation->set_rules('location_lat','','required');
		$this->form_validation->set_rules('location_lng','','required');
	
		if($this->form_validation->run()){
		
			
			$name = $this->input->post('location_name', TRUE);
			$description = $this->input->post('location_description', TRUE);
			$lat = $this->input->post('location_lat', TRUE);
			$lng = $this->input->post('location_lng', TRUE);
			$create_by = $userdata['user_id'];
			$this->load->library('encrypt');
			$guid = $this->encrypt->sha1($create_by . $name . date("Y-m-d H:i:s") . $lat . $lng);
			$official = 0;
						 
			$place = array(
				'name' => $name,
				'description' => $description,
				'lat'=>$lat,
				'lng'=>$lng,
				'create_by'=>$create_by,
				'create_date'=>date("Y-m-d H:i:s"),
				'official'=>$official,
				'guid'=>$guid
			 );
			
			$place_value = $this->db->insert('place', $place);
			$q = $this->db->get_where('place', array('guid'=>$guid),1);
			
			$result = $q->first_row('array');
			
			$place_id = $result['id'];
			
			$place_address = array(
				'place_id'=>$place_id,
				'address'=>$this->input->post('location_address', TRUE),
				'tambon'=> $this->input->post('location_tambon', TRUE),
				'amphoe'=> $this->input->post('location_amphoe', TRUE),
				'province'=> $this->input->post('location_province', TRUE),
				'country'=> $this->input->post('location_country', TRUE),
				'postal'=>$this->input->post('location_postal_code', TRUE)
				);
				
				$this->db->insert('place_address', $place_address);
				$data['owner_data'] =  $userdata;
				
				$this->db->where('guid',$guid);
				$q = $this->db->get('place',1);
				$data['place'] = $q->first_row('array');
			$this->load->view('location/location_creaetd_success_view',$data);
			
		}else{
			$location_data['route'] = $this->input->post('location_address', TRUE);
			$location_data['locality'] = $this->input->post('location_tambon', TRUE);
			$location_data['amphoe'] = $this->input->post('location_amphoe', TRUE);
			$location_data['province'] = $this->input->post('location_province', TRUE);
			$location_data['country'] = $this->input->post('location_country', TRUE);
			$location_data['lat'] = $this->input->post('location_lat', TRUE);
			$location_data['lng'] = $this->input->post('location_lng', TRUE);
			$location_data['name'] = $this->input->post('location_name', TRUE);
			$location_data['description'] = $this->input->post('location_description', TRUE);
			$location_data['postal_code'] = $this->input->post('location_postal_code', TRUE);
		
			$data['owner_data'] =  $userdata;
			$data['location_data'] = $location_data;
			$this->load->view('location/create_info_view',$data);
		}
		
	}else{
		redirect('login/');
	}
		
	}
	
	
	
	// Dispaly All Tips of Place
	function tips($place_id=FALSE)
	{
		$sessiondata = $this->session->userdata('userdata');
		if (!$sessiondata['logged_in']) {
			redirect('/login','refresh');
			return;
		}
		
		if(!$place_id)	show_404();
		
			// Query Place data
			$this->db->select('*');
			$this->db->from('place');
			$this->db->join('place_address', 'place.id = place_address.place_id');
			$this->db->where('place.id', $place_id);
			$place_q = $this->db->get();
			$placedata = $place_q->first_row('array');


			// Query Userdata
			$user_q = $this->db->get_where('user', array('id'=>$sessiondata['user_id']), 1);
			$userdata = $user_q->first_row('array');

			// Query Tip of Place
			$tip_q = $this->db->select('*')->from('tip')->join('user','tip.user_id = user.id')->where('place_id',$placedata['id'])->order_by('datetime','desc')->get();
			$tipdata = $tip_q->result('array');

			$this->load->library('locationlib');
			$data['user_in_location'] = $this->locationlib->who_checkin_in($placedata['place_id']);
			$data['place_data'] = $placedata;
			$data['user_data'] = $userdata;
			$data['tip_data'] = $tipdata;

			$this->load->view('location/tips_view',$data);
		
		
		
	}
	
	function mapview($place_id=false)
	{
		$sessiondata =  $this->session->userdata('userdata');
		
		if($sessiondata['logged_in']){
			$user_data = $this->db->get_where('user', array('id'=>$sessiondata['user_id']), 1)->first_row('array');
			$data['user_data'] = $user_data;
		}
		if (!$place_id) {
			show_404();
		}else {
			$place_data = $this->db->get_where('place', array('id'=>$place_id),1)->first_row('array');
			
		
			// Set Lower and Upper for get relative palce
			$low_lat = $place_data['lat'] - 0.015;
			$up_lat = $place_data['lat'] + 0.015;
			$low_lng = $place_data['lng'] - 0.015;
			$up_lng = $place_data['lng'] + 0.015;
			
			$this->db->where('lat >', $low_lat);
			$this->db->where('lat <', $up_lat);
			$this->db->where('lng >', $low_lng);
			$this->db->where('lng <', $up_lng);
		//	$this->db->where('id !=', $place_data['id']);
			$relate_data = $this->db->get('place',10)->result('array');
			
			$data['place_data'] = $place_data;
			$data['relate_data'] = $relate_data;
			$this->load->view('location/mapview',$data);
		}
	}
	
	function photo_upload()
	{
			$sessiondata = $this->session->userdata('userdata');
			if (!$sessiondata['logged_in']) {
				redirect('/login','refresh');
				return;
			}
			
			$user_data = $this->db->get_where('user', array('id'=>$sessiondata['user_id']), 1)->first_row('array');
			$place_id = $this->input->post('place_id', TRUE);
			// Upload File Config
			$uploadCon = array(
				'upload_path' => realpath(APPPATH . '../../files/temp'),
				'allowed_types' => 'gif|jpg|jpeg|png',
				'max_size' => '2000',
				'encrypt_name' => TRUE
				);
		
			$this->load->library('upload', $uploadCon);

			if (!$this->upload->do_upload()) {
				$error = array('error1' => $this->upload->display_errors());
				print_r($error);
			} else {
				$uploadData = array('upload_data' => $this->upload->data());
				$imgData = $uploadData['upload_data'];
				
				$imageCon = array(
					'image_library' => 'gd2',
					'source_image' => $imgData['full_path'],
					'maintain_ratio' => TRUE,
						'new_image' => APPPATH . '../../files/location_photo/' . $imgData['file_name']
					);
				
				$ratio = $imgData['image_width'] / $imgData['image_height'];
				
				if($imgData['image_width'] > 720){
					$imageCon['width'] = 720;
					$imageCon['height'] = 720 / $ratio; 
				}
				/*
				else if($imgData['image_height'] > 720){
					$imageCon['height'] = 720;
					$imageCon['width'] = 720 / $ratio; 
				}
				*/
				
				$this->load->library('image_lib',$imageCon);
				
				if($this->image_lib->resize()){
					$this->image_lib->clear();
						
					$imgThumbCon = array(
						'image_library' => 'gd2',
						'source_image' => $imgData['full_path'],
						'maintain_ratio' => TRUE,
						'width' => 320,
						'height' => 320 / $ratio,
						'new_image' => APPPATH . '../../files/location_photo/thumb/' . 'thumb_' . $imgData['file_name']
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
					   	'source_image' => APPPATH . '../../files/location_photo/thumb/' . 'thumb_' . $imgData['file_name'],
						'maintain_ratio'=>FALSE
					);
					
					$this->load->helper('file');
					$fileinfo = getimagesize(realpath($imgSmallThumbCon['source_image']));
					
					$center_x = $fileinfo[0] / 2;
					$center_y = $fileinfo[1] / 2;
				//	if($fileinfo[0] > $fileinfo[1]){
						$imgSmallThumbCon['x_axis'] = $center_x - 160 ;
						$imgSmallThumbCon['y_axis'] = 0;
						$imgSmallThumbCon['width'] = 320;
					
						//	$imgSmallThumbCon['x_axis'] = 0 ;
						//	$imgSmallThumbCon['y_axis'] = $center_y - 150;
							$imgSmallThumbCon['height'] = 300 / $ratio;
						//	$imgSmallThumbCon['y_axis'] = 100;
					//}else if ($fileinfo[0] < $fileinfo[1]) {
					
						
						//	$imgSmallThumbCon['x_axis'] = 100;
				//	}
					$this->image_lib->initialize($imgSmallThumbCon);
					if ($this->image_lib->crop()) {
						$guid = $this->encrypt->sha1(date("Y-m-d H:i:s") . $imgData['file_name']);
						$location_photo = array(
							'user_id' => $user_data['id'],
							'place_id' => $place_id,
							'lat' => '',
							'lng' =>'',
							'caption'=>'No Caption',
							'datetime'=> date("Y-m-d H:i:s"),
							'image_path' => $imgData['file_name'],
							'thumbnail_path'=> 'thumb_' . $imgData['file_name'],
							'guid'=>$guid
						);
						
						$this->db->insert('place_photo', $location_photo);
						$this->load->helper('file');
						unlink(realpath(APPPATH . '../../files/temp/' . $imgData['file_name']));
						
						$place_photo_data = $this->db->get_where('place_photo', array('guid'=>$guid), 1)->first_row('array');
						$data['photo_data'] = $place_photo_data;
						$data['user_data'] = $user_data;
						$data['place_data'] = $this->db->get_where('place', array('id'=>$place_photo_data['place_id']),1)->first_row('array');
						$this->load->view('location/place_photo_caption',$data);
						
					}else{
						echo $this->image_lib->display_errors('<p>', '</p>');
					}
					
					}else {
						echo $this->image_lib->display_errors('<p>', '</p>');
					}
				
			}else{
				echo $this->image_lib->display_errors('<p>', '</p>');
			}
				
			}// end else
	}
	
	function setcaption()
	{
		$sessiondata = $this->session->userdata('userdata');
		if(!$sessiondata['logged_in']){
			redirect('/login/');
			return;
		}
		
		$place_id = $this->input->post('place_id', TRUE);
		$photo_id = $this->input->post('photo_id', TRUE);
		$photo_guid = $this->input->post('photo_guid', TRUE);
		$user_id = $this->input->post('user_id', TRUE);
		$caption_text = $this->input->post('caption_text', TRUE);
		
		$this->db->where('place_id', $place_id);
		$this->db->where('id', $photo_id);
		$this->db->where('guid', $photo_guid);
		$this->db->where('user_id', $user_id);
		$this->db->update('place_photo', array('caption'=>$caption_text));
		
		redirect('location/place/'.$place_id);
	}
	
	function photo_view($photo_id)
	{
		$sessiondata = $this->session->userdata('userdata');
		
		if($sessiondata['logged_in']){
			$user_data =$this->db->get_where('user', array('id'=>$sessiondata['user_id']),1)->first_row('array');
			
			$is_like = $this->db->get_where('place_photo_like', array('user_id'=>$user_data['id'],'place_photo_id'=>$photo_id), 1)->num_rows();
			
			$data['is_like'] = $is_like == 0 ? FALSE : TRUE;
			$data['user_data'] = $user_data;
		}
		
	
		$photo_data = $this->db->get_where('place_photo', array('id'=>$photo_id), 1)->first_row('array');
		
		
				$this->db->select('*');
				$this->db->from('place');
				$this->db->join('place_address', 'place.id = place_address.place_id');
				$this->db->where('place.id', $photo_data['place_id']);
				$place_q = $this->db->get();
				$place_data = $place_q->first_row('array');
				
		$this->load->library('locationlib');
		$data['user_in_location'] = $this->locationlib->who_checkin_in($place_data['id']);
		$data['place_data'] = $place_data;
		$data['photo_data'] = $photo_data;
		$this->load->view('location/place_photo_view',$data);
		
	}
	
	function like_photo()
	{
		$user_id = $this->input->post('user_id', TRUE);
		$photo_id = $this->input->post('photo_id', TRUE);
		$place_id = $this->input->post('place_id', TRUE);
		$datetime = date("Y-m-d H:i:s");
		
		$is_like = $this->db->get_where('place_photo_like', array('user_id'=>$user_id,'place_photo_id'=>$photo_id),1);
		
		if($is_like->num_rows()>0){
			$this->db->where('user_id', $user_id);
			$this->db->where('place_photo_id', $photo_id);
			$this->db->delete('place_photo_like');
			echo "UNLIKED";
		}else{
			$like_data = array(
				'user_id' => $user_id,
				'place_photo_id' => $photo_id,
				'datetime' => $datetime,
				'like_type' => 1
				);
			$this->db->insert('place_photo_like', $like_data);
			
			$this->db->select('place_photo_like.place_photo_id as photo_id,place_id,place_photo.thumbnail_path,sum(like_type) as like_count');
			$this->db->join('place_photo', 'place_photo_like.place_photo_id = place_photo.id');
			$this->db->where('place_id', $place_id);
			$this->db->group_by('place_photo_id');
			$this->db->order_by('like_type','desc');
			$best_like = $this->db->get('place_photo_like');
			
			if($best_like->num_rows() > 0){
				$best_like = $best_like->first_row('array');
				
				$this->db->where('id', $best_like['place_id']);
				$this->db->update('place', array('thumbnail'=>$best_like['thumbnail_path']));
			}
			
			
			echo "LIKED";
		}
		
	
	}
	
	function photos($place_id=FALSE)
	{
		if (!$place_id) {
			show_404();
			return;
		}
		
			$sessiondata = $this->session->userdata('userdata');

			if($sessiondata['logged_in']){
				$user_data =$this->db->get_where('user', array('id'=>$sessiondata['user_id']),1)->first_row('array');
				
				$data['user_data'] = $user_data;
			}
		
		$photo_data = $this->db->select('*')->from('place_photo')->where('place_id',$place_id)->order_by('datetime','desc')->limit(30)->get()->result('array');
		
		$place_data = $this->db->select('*')->from('place')->join('place_address','place.id = place_address.place_id')->where('place_id',$place_id)->limit(1)->get()->first_row('array');
			$this->load->library('locationlib');
		$data['user_in_location'] = $this->locationlib->who_checkin_in($place_data['id']);
		$data['photo_data'] = $photo_data;
		$data['place_data'] = $place_data;
		$this->load->view('location/place_photos_view', $data);
		
		
	}
	
	function testcount()
	{
			$this->db->select('place_photo_like.place_photo_id as photo_id,place_id,place_photo.thumbnail_path,sum(like_type) as like_count');
			$this->db->join('place_photo', 'place_photo_like.place_photo_id = place_photo.id');
			$this->db->where('place_id', '4');
			$this->db->group_by('place_photo_id');
			$this->db->order_by('like_type','desc');
			$best_like = $this->db->get('place_photo_like');
		
		print_r($best_like->result());die();
		
	}



}