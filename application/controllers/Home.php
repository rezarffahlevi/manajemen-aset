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

		$data['less_stock'] = $this->M_master->get_id('material', 'jumlah <= 20')->result();
		$materials = $this->M_master->get('material')->result();
		$material_name = array();
		$stock = array();
		foreach ($materials as $material){
			array_push($material_name, $material->material);
			array_push($stock, $material->jumlah);
		}
		$data['material_name'] = join($material_name, ',');
		$data['stock'] = join($stock, ',');
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
