<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_master');
		if (!$this->M_master->access(['Admin', 'SPV'])) {
			redirect('auth/');
		}
	}


	public function index()
	{
		if (!$this->M_master->access(['Admin'])) {
			redirect('auth/');
		}
		$data['content'] 	= 'content/user';
		$this->load->view('layout', $data);
	}

	public function jx_get_data()
	{
		$start  = $this->input->post('start');
		$get    = $this->M_master->get_data_table('user', $start, [], null, null, ['nama', 'username']);

		$data           = $get['data'];
		$get['data']    = [];
		$start          = $start + 1;
		foreach ($data as $v) {
			unset($v->password);

			$button    = '
			<button type="button" class="btn btn-primary" onclick="show_edit(\'' . base64_encode(json_encode($v)) . '\')"><i class="fa fa-pencil"></i></button>
			<button type="button" class="btn btn-danger" onclick="show_delete(\'' . $v->id . '\')"><i class="fa fa-times"></i></button>
			';

			$get['data'][]   = [
				$start,
				$v->nama,
				$v->username,
				$v->level,
				$button
			];
			$start++;
		}

		echo json_encode($get);
	}

	public function save()
	{
		if ($this->input->method(TRUE) == 'POST') {
			$id             = $this->input->post('id');
			$nama           = $this->input->post('nama');
			$level          = $this->input->post('level');
			$username		= $this->input->post('username');
			$password		= $this->input->post('password');

			$data   = [
				'nama'            => $nama,
				'level'           => $level,
				'username'        => $username,
			];

			if (!empty($password)) {
				$data['password'] = md5(sha1($password));
			}

			$msg    = 'Berhasil tambah data';

			try {
				if (!empty($id)) {
					$where  = ['id' => $id];
					$save   = $this->M_master->edit('user', $data, $where);
					$msg    = 'Berhasil ubah data';
				} else {
					$save    = $this->M_master->add('user', $data);
				}
				$this->M_master->success($msg);
			} catch (\Throwable $th) {
				$this->M_master->wrong($th);
			}

			if ($redirect = $this->input->post('redirect')) {
				redirect($redirect);
			} else {
				redirect('master/user/');
			}
		}
	}

	public function delete()
	{
		if (!$this->M_master->access(['Admin'])) {
			redirect('auth/');
		}
		if ($this->input->method(TRUE) == 'POST') {
			$id     = $this->input->post('id');

			$where  = ['id' => $id];
			$del    = $this->M_master->del('user', $where);

			$this->M_master->success('Berhasil hapus data');
			redirect('master/user/');
		}
	}

	public function profile()
	{
		$data['profile']	= $this->M_master->get_id('user', ['id' => $this->session->userdata('id')])->row();;
		$data['content'] 	= 'content/profile';
		$this->load->view('layout', $data);
	}
}
