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
			
			$this->load->library('rest', array(
			    'server' => 'http://maps.googleapis.com/maps/api/geocode/'
			));
			$map = $this->rest->get('json?address=ขอนแก่น&sensor=false');
		
			$data['map_results'] = $map->results;
			
			$this->load->view('location/create_location_view',$data);
			
		}
	}
	
	function searchbyuser()
	{
		$lat = $this->input->post('lat_field', TRUE);
		$lng = $this->input->post('lng_field', TRUE);
	
		
		$this->load->library('rest', array(
		    'server' => 'http://maps.googleapis.com/maps/api/geocode/'
		));
		
	
		
		$q_text = 'json?latlng='.$lat.','.$lng.'&sensor=false';
		$location = $this->rest->get($q_text);
		
			if ($location->status == 'OK') {
			
				redirect('/location/create_info/'.$lat.'/'.$lng);
			}else if ($location->status == 'ZERO_RESULTS') {
				echo "Something wrong";
				echo "<br/>Please Try Again !!";
			}
	}
	
	function create_info($lat,$lng)
	{
		$this->load->library('rest', array(
		    'server' => 'http://maps.googleapis.com/maps/api/geocode/'
		));
		
	
		
		$q_text = 'json?latlng='.$lat.','.$lng.'&sensor=false';
		$location = $this->rest->get($q_text);
		
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
			
				$this->load->view('location/create_info_view', $data);
				
				 						
				
					
			}else if ($location->status == 'ZERO_RESULTS') {
				echo "Something wrong";
				echo "<br/>Please Try Again !!";
			}
	}
	
	function location_created()
	{
		$this->form_validation->set_rules('location_name','Location Name','required|max_length[255]');
		$this->form_validation->set_rules('location_tambon','Tambon Name','max_length[255]');
		$this->form_validation->set_rules('location_amphoe','Amphoe Name','max_length[255]');
		$this->form_validation->set_rules('location_province','Province Name','max_length[255]');
		$this->form_validation->set_rules('location_country','Country Name','max_length[255]');
		$this->form_validation->set_rules('location_postal_code','Postal Code','alpha|max_length[255]');
		$this->load->view('location/location_created');
	}


}