<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Login extends CI_Controller {

	//php 5 constructor
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$sessiondata = $this->session->userdata('userdata');
		
		if($sessiondata['logged_in'])
		{
			redirect('profile/user');
		
		}else{
		$this->load->view('login/login');	
		}
		
		
		
	}
	
	function signin()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email','Email','required|trim|valid_email');
		$this->form_validation->set_rules('password','password','required|trim');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('login/login');
		}
		else {
			$this->load->library('encrypt');
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$password = $this->encrypt->sha1($password);
				
	
				$this->db->where('email', $email);
				$this->db->where('password',$password);
				$q = $this->db->get('user');
				
				if($q->num_rows() > 0){
					
					$data = $q->first_row('array');
					
					// Check Status is user activate account
					if ($data['status'] == 1){ 
						$this->add($data);
						//$this->load->view('profile/user');
						redirect('profile/user');
						
					}else{
						// user not activate account
						
						redirect('/login');
					}
				
				}else {
					// email or password not match
					
					redirect('/login');
				
				}
		}
		
	}
	
	function add($data)
	{
		
		$session_data = array(
				'user_id' => $data['id'],
				'email' => $data['email'],
				'screen_name' => $data['screen_name'],
				'firstname' => $data['firstname'],
				'lastname' => $data['lastname'],
				'logged_in' => TRUE
				);
		$this->session->set_userdata('userdata',$session_data);
	

		
	}
	
	function logout()
	{
			$this->session->unset_userdata('userdata');
			redirect('/');
	}

}

