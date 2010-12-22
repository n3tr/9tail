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
	
	function place($place_id)
	{
		$this->load->view('location/place_view');
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


}