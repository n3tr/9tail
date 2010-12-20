<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Checkin extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
	}
	
	function index() {
		$userdata = $this->session->userdata('userdata');
		if ($userdata['logged_in']) {
			$data['owner_data'] = $userdata;
			$this->load->view('checkin/usercheckin_view',$data);
		}else {
			redirect('/login/','Refresh');
			
		}
	}
	
	function get_nearly($lat=null,$lng=null)
	{
		
			$low_lat = $lat - 0.009;
			$up_lat = $lat + 0.009;
			$low_lng = $lng - 0.009;
			$up_lng = $lng + 0.009;
			
			$sql = 'SELECT 9tail_db.place.*,count(9tail_db.checkin.id) as checkin_count FROM 9tail_db.place LEFT JOIN 9tail_db.checkin ON checkin.place_id = place.id where place.lat > ? AND place.lat < ? AND place.lng > ? AND place.lng < ? group by place.id order by checkin_count desc limit 10';
			$q = $this->db->query($sql,array($low_lat,$up_lat,$low_lng,$up_lng));
			
			//$this->db->where('lat >', $low_lat);
			//$this->db->where('lat <', $up_lat);
			//$this->db->where('lng >', $low_lng);
			//$this->db->where('lng <', $up_lng);
			//$q = $this->db->get('place',10);
		
			$data['results'] = $q->result('array');
			$this->load->view('checkin/get_location_result',$data);
	
	}
	
	function searchlocation()
	{
		$text = $this->input->get('searchtext');
		$sql = 'SELECT 9tail_db.place.*,count(9tail_db.checkin.id) as checkin_count FROM 9tail_db.place LEFT JOIN 9tail_db.checkin ON checkin.place_id = place.id where place.name LIKE "%'.$text.'%" group by place.id order by checkin_count desc limit 10';
		
		$q = $this->db->query($sql);
		//$q = $this->db->get('place',10);
		$data['results'] = $q->result('array');
		$this->load->view('checkin/get_location_result',$data);
	}
	
	function place($place_id)
	{
		$userdata = $this->session->userdata('userdata');
		if($userdata['logged_in']){
			$this->db->where('user_id',$userdata['user_id']);
			$this->db->order_by('datetime','desc');
			$q = $this->db->get('checkin',1);
			if ($q->num_rows == 0) {
				$checkin = array(
					'user_id'=> $userdata['user_id'],
					'place_id'=> $place_id,
					'datetime'=> date("Y-m-d H:i:s")
					);
					$this->db->insert('checkin', $checkin);
					redirect('/','refresh');
					//echo "Checkin Time";
			}else{
				$now = date("Y-m-d H:i:s");
				$result = $q->first_row('array');
				$lastcheckin = $result['datetime'];
				$timediff = (strtotime($now) - strtotime($lastcheckin)) / 60 ;
				
				if ($result['place_id'] == $place_id && $timediff < 60) {
					$this->db->where('id', $result['id']);
					$this->db->update('checkin',array('datetime'=> date("Y-m-d H:i:s")));
					redirect('/','refresh');
					//echo "Update Time";
					
				}else{
					$checkin = array(
						'user_id' => $userdata['user_id'], 
						'place_id'=> $place_id,
						'datetime'=> date("Y-m-d H:i:s")
						);
						$this->db->insert('checkin', $checkin);
						redirect('/','refresh');
				}
			
			}
		}
	}
	
}