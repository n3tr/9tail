<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class User extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
		$this->load->library('form_validation');
		$this->load->library('encrypt');
		$this->load->library('email');
	}
	
	function index() {
		$userdata = $this->session->userdata('logged_in');
		if($userdata == TRUE){
			redirect('/profile/');
		}
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
	
	// Call When User Submit Register Form
	function register_submit()
	{
		//register submit to here
		
		
		$this->form_validation->set_rules('email','Email','required|trim|valid_email|max_length[50]');
		$this->form_validation->set_rules('password','password','required|trim|max_length[50]|min_length[6]');
		$this->form_validation->set_rules('screen_name','Screen Name','required|trim|max_length[50]|min-length[4]');
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
				. $this->config->item('base_url') . 'index.php/user/activate/' . $data['screen_name']
				. "\r\n"
				. "\r\n"
				. 'Thank you,'
				. "\r\n"
				. '9Tail Site'
				);
				
					if($this->email->send())
					{
						echo 'Your email was sent, fool.';
					}

					else
					{
						show_error($this->email->print_debugger());
					}
				
				$this->load->view('success_register');
				
			}
		}
	}
	
	function login_submit()
	{
			// when user login
		
	}


	// Call When User Click Activate Link Form Email
	// Note : This Method Must be fix Later
	// Now User Screen Name to Active User Account
	function activate()
	{
		$screen_name = $this->uri->segment(3);
		$this->db->where('screen_name', $screen_name);
		$q = $this->db->get('user',1);
		
		if($q->num_rows() > 0){
			$row = $q->first_row('array');
			$row['status'] = 1;
			$this->db->where('id', $row['id']);
			$this->db->update('user', $row);	
			echo 'active user';
		}else {
		
		// Sent Something to User that Activation Process can't be Success with some reason
		// eg. User not found.
		echo 'Error to Active Account';
		}
		
	}

}