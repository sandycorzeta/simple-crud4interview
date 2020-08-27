<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//load helper
		$this->load->helper('url');
		$this->load->helper('form');
		//load library
		$this->load->library('form_validation');
		$this->load->library('session');
		//load model
		$this->load->model('user');
	}

	public function index()
	{
		if(isset($this->session->userdata['loggedin']))
		{
			redirect('dashboard');
		}
		$this->load->view('index-page');
	}

	public function register()
	{
		if(!empty($this->input->post()))
		{
			$this->form_validation->set_rules('uname', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			if($this->form_validation->run() == false)
			{
				redirect('/register');
			} else {
				$data['uname'] = $this->input->post('uname');
				$data['password'] = $this->input->post('password');
				$data['email'] = $this->input->post('email');
				$result = $this->user->register($data);
				if ($result == true)
				{
					$data['message'] = 'Registration Success';
					redirect('/register', 'refresh');
				} else {
					$data['message'] = 'Registration Failed (Username already exist)';
					redirect('/register', 'refresh');
				}
			}
		} else {
			$this->load->view('register-form');
		}
	}
	
	public function login()
	{
		if(!empty($this->input->post()))
		{
			$this->form_validation->set_rules('uname', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			if($this->form_validation->run() == FALSE)
			{
				if(isset($this->session->userdata['loggedin']))
				{
					redirect('admin');
				} else {
					redirect('', 'refresh');
				}
			} else {
				$data['uname'] = $this->input->post('uname');
				$data['password'] = $this->input->post('password');
				$result = $this->user->login($data);
				if($result == true)
				{
					$userinfo = $this->user->get($this->input->post('uname'));
					if($userinfo != false)
					{
						$session = array(
							'uid' => $userinfo[0]->uid,
							'username' => $userinfo[0]->uname,
							'email' => $userinfo[0]->email,
						);
						$this->session->set_userdata('loggedin', $session);
						redirect('dashboard', 'refresh');
					}
				} else {
					$data['error_message'] = 'Invalid Username or Password';
					redirect('','refresh');
				}
			}
		} else {
			$this->load->view('login-form');
		}
	}
	public function logout()
	{
		$session = null;
		$this->session->unset_userdata('loggedin', $session);
		$data['message'] = 'Success Logout';
		redirect('','refresh');
	}

	public function dashboard()
	{
		if(isset($this->session->userdata['loggedin']))
		{
			$data['users'] = $this->user->get_all();
			$this->load->view('dashboard', $data);
		} else {
			redirect('');
		}
	}

	public function create()
	{
		if(isset($this->session->userdata['loggedin']))
		{
			if(!empty($this->input->post()))
			{
				$this->form_validation->set_rules('uname', 'Username', 'trim|required');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required');
				$this->form_validation->set_rules('firstname', 'First Name', 'trim');
				$this->form_validation->set_rules('lastname', 'Last Name', 'trim');
				$this->form_validation->set_rules('address', 'Address', 'trim');
				$this->form_validation->set_rules('website', 'Website', 'trim');
				if($this->form_validation->run() == false)
				{
					redirect('/create');
				} else {
					$data['uname'] = $this->input->post('uname');
					$data['password'] = $this->input->post('password');
					$data['email'] = $this->input->post('email');
					$data['firstname'] = $this->input->post('firstname');
					$data['lastname'] = $this->input->post('lastname');
					$data['address'] = $this->input->post('address');
					$data['website'] = $this->input->post('website');
					$result = $this->user->register($data);
					if ($result == true)
					{
						$data['message'] = 'Registration Success';
						redirect('/dashboard');
					} else {
						$data['message'] = 'Registration Failed (Username already exist)';
						redirect('/create');
					}
				}
			} else {
				$this->load->view('create-form');	
			}
		} else {
			redirect('');
		}
	}

	public function view($id)
	{
		if(isset($this->session->userdata['loggedin']))
		{
			$data['users'] = $this->user->get_by_id($id);
			$this->load->view('view-form', $data);
		} else {
			redirect('');
		}
	}

	public function edit($id)
	{
		if(isset($this->session->userdata['loggedin']))
		{
			$data['users'] = $this->user->get_by_id($id);
			$this->load->view('edit-form', $data);
		} else {
			redirect('');
		}
	}

	public function delete($id)
	{
		if(isset($this->session->userdata['loggedin']))
		{
			$this->user->delete($id);
			$data['message'] = 'Delete Success';
			redirect('dashboard');
		} else {
			redirect('');
		}
	}
	
	public function update()
	{
		if(isset($this->session->userdata['loggedin']))
		{
			if(!empty($this->input->post()))
			{
				$this->form_validation->set_rules('uid', 'User ID', 'trim|required');
				$this->form_validation->set_rules('uname', 'Username', 'trim|required');
				$this->form_validation->set_rules('password', 'Password', 'trim');
				$this->form_validation->set_rules('email', 'Email', 'trim');
				$this->form_validation->set_rules('firstname', 'First Name', 'trim');
				$this->form_validation->set_rules('lastname', 'Last Name', 'trim');
				$this->form_validation->set_rules('address', 'Address', 'trim');
				$this->form_validation->set_rules('website', 'Website', 'trim');
				if($this->form_validation->run() == false)
				{
					redirect('/edit/'.print_r($this->input->post('uid')));
				} else {
					$data['uid'] = $this->input->post('uid');
					$data['uname'] = $this->input->post('uname');
					$data['password'] = $this->input->post('password');
					$data['email'] = $this->input->post('email');
					$data['firstname'] = $this->input->post('firstname');
					$data['lastname'] = $this->input->post('lastname');
					$data['address'] = $this->input->post('address');
					$data['website'] = $this->input->post('website');
					$result = $this->user->edit($data);
					if ($result == true)
					{
						$data['message'] = 'Update Success';
						$uid = $data['uid'];
						redirect("/edit/$uid");
					} else {
						$data['message'] = 'Update Failed';
						$uid = $data['uid'];
						redirect("/edit/$uid");
					}
				}
			} else {
				redirect('dashboard');
			}
		} else {
			redirect('');
		}
	}
}
