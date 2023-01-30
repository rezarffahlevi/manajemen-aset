<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_master');
	}
	public function index()
	{
		if ($this->M_master->access(['Admin', 'SPV'])) {
			redirect('home/');
		}
		$this->load->view('login');
	}
	public function validate()
	{
		if (!isset($_POST['username']) || empty($_POST['password'])) {
			redirect('auth/');
		}
		$username 		= htmlspecialchars($_POST['username']);
		$password		= htmlspecialchars(md5(sha1($_POST['password'])));
		$start_time = time();

		$where		= [
			'username' => $username,
			'password' => $password,
		];
		$check_user	= $this->M_master->get_id('user', $where)->row();
		// var_dump($check_user); die();
		$redirect	= '';
		if (!empty($check_user)) {
			$new_data	= [
				'id'			=> $check_user->id,
				'nama'			=> $check_user->nama,
				'level'			=> $check_user->level,
				'username'		=> $check_user->username,
				'start_time' 	=> $start_time,
				'last_time' 	=> $start_time
			];

			$this->session->set_userdata($new_data);
			// $this->session->set_userdata(['name' => 'bypass']);
			$redirect	= 'home/';
		} else {
			$flash_data	= [
				'username' => $username
			];

			$this->session->set_flashdata($flash_data);
			$this->M_master->warning('username or password is wrong');
			$redirect	= 'auth/';
		}

		redirect($redirect);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/');
	}
}
