<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Sign In';

			$this->load->view('auth/login', $data);
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$user = $this->db->get_where('users', ['username' => $username])->row_array();

		if ($user) {
			if (password_verify($password, $user['password'])) {
				$data = [
					'username' => $user['username'],
					'exp' => $user['expired'],
				];

				$this->session->set_userdata($data);

				redirect('keuangan');
			} else {
				$this->session->set_flashdata('alert', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Wrong Password!</div>');

				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('alert', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			Username not registered</div>');

			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata(['username', 'isAdmin']);

		$this->session->set_flashdata('alert', '<div class="alert alert-success alert-dismissible fade show" role="alert">
		Logout was successfully</div>');

		redirect('auth');
	}
}
