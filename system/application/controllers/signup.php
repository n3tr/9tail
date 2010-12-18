<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Signup extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
		
	}
	
	function index() {
		$userdata = $this->session->userdata('userdata');
		if(!$userdata['logged_in']){
			$this->load->view('signup_view');
		}else{
			redirect('/','Refresh');
		}
	}
	
	function submit()
	{
		//register submit to here
		
		$userdata = $this->session->userdata('userdata');
		if($userdata['logged_in']){
			redirect('/','Refresh');
		}
		
		$this->form_validation->set_rules('email','Email','required|trim|valid_email|max_length[50]');
		$this->form_validation->set_rules('password','password','required|trim|max_length[50]|min_length[6]');
		$this->form_validation->set_rules('screen_name','Screen Name','required|trim|max_length[50]|min-length[4]');
		$this->form_validation->set_rules('firstname','First Name','required|trim|max_length[250]');
		$this->form_validation->set_rules('lastname','Last Name','required|trim|max_length[250]');
		
		if($this->form_validation->run() == FALSE){
			$this->load->view('signup_view');
			
		}else {
			
			$this->db->where('email', $this->input->post('email'));
			$this->db->or_where('screen_name', $this->input->post('screen_name'));
			$q = $this->db->get('user');
			
			if($q->num_rows() > 0){
				$this->load->view('signup_view');
								
			}else {
				
				$this->load->library('encrypt');
				$password = $this->encrypt->encode($this->input->post('password'), 'userpassword');
				$data = array(
					'screen_name' => strtolower($this->input->post('screen_name')), 
					'email' => $this->input->post('email'),
					'password' => $password,
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'status' => 0,
					'create_date' => date("Y-m-d H:i:s")
				);

				// Insert User Data to Database
				$this->db->insert('user', $data);
				
				// Activation Email Sent
				$this->email->set_newline("\r\n");
				$this->email->from('admin@9tail.com', 'Register Confirmation Email');
				$this->email->to($data['email']);		
				$this->email->subject('Register Confirmation Email');		
				$this->email->message('To ' . $data['firstname'] . ' ' . $data['lastname'] 
				. "\r\n"
				. "\r\n"
				. 'Click link below to Activate your Account'
				. "\r\n"
				. "\r\n"
				. $this->config->item('base_url') . 'index.php/login/activate/' . $data['screen_name']
				. "\r\n"
				. "\r\n"
				. 'Thank you,'
				. "\r\n"
				. '9Tail Site'
				);
					
					if($this->email->send())
					{
						
					}

					else
					{
					
					}
				$this->load->view('success_register',$data);
				
				
			}
		}
	}

}