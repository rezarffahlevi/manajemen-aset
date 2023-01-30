<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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

		$data['hari'] = $this->M_master->get_count_id('spr', "DATE(created_at) BETWEEN '" . date('Y-m-d') . "' AND '" . date('Y-m-d')  . "'")->row('total');
		$data['minggu'] = $this->M_master->get_count_id('spr', "DATE(created_at) BETWEEN '" . date("Y-m-d", strtotime(date("Y-m-d") . "-7 day")) . "' AND '" . date('Y-m-d')  . "'")->row('total');
		$data['bulan'] = $this->M_master->get_count_id('spr', "DATE(created_at) BETWEEN '" . date("Y-m-d", strtotime(date("Y-m-d") . "-30 day")) . "' AND '" . date('Y-m-d')  . "'")->row('total');
		$data['content'] = 'content/dashboard';
		$this->load->view('layout', $data);
	}

	public function jx_get_list_notif()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$join		= [
			['table' => 'users pegawai', 'fk' => 'peminjaman.id_pegawai=pegawai.id_user']
		];
		$where		= [
			'id_kapool' => $this->session->userdata('id'),
			'status' => 'queue',
		];
		$select		= 'pegawai.nama nama_pegawai';
		$get_data	= $this->M_master->get_join_id('peminjaman', $join, $where, $select);

		echo json_encode($get_data->result());
	}
}
