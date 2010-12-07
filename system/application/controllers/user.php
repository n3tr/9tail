<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class User extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
		$this->load->library('form_validation');
	}
	
	function index() {
		$this->login();
	}
	
	//Load Login Page
	function login()
	{	
		$this->load->view('login_view');
	}
	
	//Load Register Page
	function register(){
		$this->load->view('register_view');
	}
	
	function register_submit()
	{
		//register submit to here
		
		
		$this->form_validation->set_rules('email','Email','required|trim|valid_email|max_length[50]');
		$this->form_validation->set_rules('password','password','required|trim|max_length[50]');
		$this->form_validation->set_rules('screen_name','Screen Name','required|trim|max_length[50]');
		$this->form_validation->set_rules('firstname','First Name','required|trim|max_length[250]');
		$this->form_validation->set_rules('lastname','Last Name','required|trim|max_length[250]');
		
		if($this->form_validation->run() == FALSE){
			$this->load->view('register_view');
			
		}else {
			
			$this->db->where('email', $this->input->post('email'));
			$this->db->or_where('screen_name', $this->input->post('screen_name'));
			$q = $this->db->get('user');
			
			if($q->num_rows() > 0){
			

				$this->load->view('register_view');
								
			}else {
				$this->load->library('encrypt');
				$password = $this->encrypt->encode($this->input->post('password'), 'userpassword');
				$data = array(
					'screen_name' => $this->input->post('screen_name'), 
					'email' => $this->input->post('email'),
					'password' => $password,
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'status' => 0
				);

				$this->db->insert('user', $data);
				$this->load->view('success_register');
				
			}
		}
	}

}