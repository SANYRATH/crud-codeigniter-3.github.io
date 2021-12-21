<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('login');
	}

	public function registerIndex()
	{
		$this->load->view('register');
	}
	

	function register()
	{
		//$this->load->view('register');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('name', 'User Name', 'required');
			$this->form_validation->set_rules('email', 'Email ', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == TRUE) {
				$name = $this->input->post('name');
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$data = array(
					'name' => $name,
					'email' => $email,
					'password' => sha1($password),
					'status'=>'1'
				);
				$this->load->model('user_model');
				$this->user_model->insertuser($data);
				$this->session->set_flashdata('success','đăng kí thành công');
				redirect(base_url('welcome/index'));
			}
		}
	}

	function login()
	{
		$this->load->view('login');
	}

	function loginNow()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->form_validation->set_rules('email', 'Email ', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == TRUE) 
			{

				$email = $this->input->post('email');
				$password = $this->input->post('password');
				$password = sha1($password);

				$this->load->model('user_model');
				$status = $this->user_model->checkPassword($password, $email);
				if ($status!=false) {
					$name = $status->name;
					$email = $status->email;

					$session_data = array(
						'name' => $name,
						'email' => $email,
					);
					$this->session->set_userdata('UserloginSession', $session_data);
					redirect(base_url('welcome/dashboard'));
				} else {
					 $this->session->set_flashdata('error', 'email hoặc pass đã sai');
					redirect(base_url('welcome/login'));
				}
			} else {
			
				$this->session->set_flashdata('error', 'email hoặc pass đã sai');
					redirect(base_url('welcome/login'));
			}
		}
	}

	function dashboard()
	{
		$this->load->view('dashboard');
	}
}
