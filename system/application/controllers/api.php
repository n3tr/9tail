<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class API extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
	}
	
	function index() {
		echo "Access Denied";
	
	}
	
	function place($place_id=FALSE)
	{
		if (!$place_id) {
			echo "Missing Parameter";
			return;
		}
		
		$this->db->select('*');
		$this->db->from('place');
		$this->db->join('place_address', 'place_address.place_id = place_id');
		$this->db->where('place.id', $place_id);
		$place_data = $this->db->get();
		
		if($place_data->num_rows() == 0){
			// Check Result Existing , if not return Not Found
			echo "Not found";
				return;
		}
		
		$place_data = $place_data->first_row('array');
		echo json_encode($place_data);
	
	}
	
	function place_search($text=FALSE,$limit = 10)
	{
	
		
		$sql = 'SELECT tail_place.*,count(tail_checkin.id) as checkin_count FROM tail_place LEFT JOIN tail_checkin ON tail_checkin.place_id = tail_place.id where tail_place.name LIKE "%'.$text.'%" group by tail_place.id order by checkin_count desc limit ' . $limit;
		
		$q = $this->db->query($sql);
		
		
		$place = $q->result('array');
		
		echo json_encode($place);
	}
	
	function photo($photo_id=FALSE)
	{
		if (!$photo_id) {
			echo "Missing Parameter";
			return;
		}
		
		$photo_data = $this->db->get_where('place_photo', array('id'=>$photo_id), 1);
		
		if($photo_data->num_rows() == 0){
			// Check Result Existing , if not return Not Found
			echo "Not found";
			return;
		}
		
		$photo_data = $photo_data->first_row('array');
		echo json_encode($photo_data);
		
	}

	function place_photo($place_id=FALSE,$limit=10)
	{
		if (!$place_id) {
			echo "Missing Parameter";
			return;
		}
		
		$this->db->select('*,place_photo.id as photo_id,place.id as place_id');
		$this->db->from('place_photo');
		$this->db->join('place', 'place_photo.place_id = place.id');
		$this->db->where('place.id', $place_id);
		$this->db->limit($limit);
		$this->db->order_by('place_photo.datetime','desc');
		$place_data = $this->db->get();
		
		if($place_data->num_rows() == 0){
			// Check Result Existing , if not return Not Found
			echo "Not found";
				return;
		}
		
		$place_data = $place_data->result('array');
		echo json_encode($place_data);
	
		
	}
}