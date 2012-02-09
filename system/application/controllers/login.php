<?php 

if (! defined('BASEPATH')) exit('No direct script access');

class Login extends Controller {

	//php 5 constructor
	function __construct() {
		parent::Controller();
			$this->load->library('form_validation');
			$this->load->library('encrypt');
			$this->load->library('email');
	}
	
	function index() {
		
$userdata = $this->session->userdata('userdata');

		if($userdata['logged_in'] == FALSE){
			$this->load->view('login_view');
		}else {
			redirect('/user/');
		}
		
	}
	
	// Call When User Click Activate Link Form Email
	// Note : This Method Must be fix Later
	// Now User Screen Name to Active User Account
	function activate($guid = null)
	{
		if (isset($guid)) {
			
		$this->db->where('guid', $guid);
		$q = $this->db->get('user',1);
		
		if($q->num_rows() > 0){
			$row = $q->first_row('array');
			$row['status'] = 1;
			$this->db->where('id', $row['id']);
			$this->db->update('user', $row);	
			$this->load->view('activate_view');
		}else {
		// Sent Something to User that Activation Process can't be Success with some reason
		// eg. User not found.
		echo 'Error to Active Account';
		}
	}else {
		echo 'false';
	}
		
	}
	
	function forgot()
	{
		$sessiondata = $this->session->userdata('userdata');
		if ($sessiondata['logged_in']) {
			redirect('/login','refresh');
		}
		
		$this->load->view('pwd_recovery');
	}
	
	function recovery_pwd()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email','Email','required|trim|valid_email');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('pwd_recovery');

		}else{
		
			$user_email = $this->input->post('email', TRUE);

			$user_q = $this->db->get_where('user', array('email'=>$user_email), 1);
		
			if($user_q->num_rows()>0){
				$userdata = $user_q->first_row('array');
				$this->emaillib->email_reset_pwd($userdata);
				$this->load->view('send_reset_pwd');
		
			}else{		
			// Data not exit
			}
		}
	}
	
	function password_reset($passwd=FALSE,$guid=FALSE)
	{
		$user_q = $this->db->get_where('user', array('password'=>$passwd,'guid'=>$guid),1);
		 if($user_q->num_rows() == 0){
			redirect('login/');
		}else {
			$data['guid'] = $guid;
			$data['password_id'] = $passwd;
			$this->load->view('set_new_password',$data);
		}
	}
	
	function set_new_password()
	{	
		$this->form_validation->set_rules('reset_password','Password','required|trim|max_length[50]|min_length[6]');
		$this->form_validation->set_rules('reset_conpassword','Confirm Password','required|trim|max_length[50]|min_length[6]|matches[reset_password]');
		
			if($this->form_validation->run() == FALSE){
				$data['password_id'] = $this->input->post('password_id', TRUE);
				$this->load->view('set_new_password',$data);

			}else {
				$password_id =$this->input->post('password_id', TRUE);
				$new_password = $this->input->post('reset_password', TRUE);
				$new_password = $this->encrypt->sha1($new_password);
				$guid = $this->input->post('guid', TRUE);
				// Set New Password.
				
				$this->db->where('guid', $guid);
				$this->db->where('password', $password_id);
				$this->db->update('user', array('password'=>$new_password));
				redirect('/login/');
			}
	}
	
}