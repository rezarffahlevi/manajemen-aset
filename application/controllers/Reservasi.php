<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reservasi extends CI_Controller
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
		$data['content'] = 'content/manajemen';
		$this->load->view('layout', $data);
	}

	public function jx_get_data()
	{
		$join = [
			'material' => ['on' => 'material.id=reservasi.material_id', 'join' => 'LEFT'],
			'penyimpanan' => ['on' => 'penyimpanan.id=reservasi.penyimpanan_id', 'join' => 'LEFT'],
		];
		$select = '*, ';
		$select .= 'reservasi.id as id, reservasi.keterangan as keterangan';
		$start = $this->input->post('start');
		$get = $this->M_master->get_data_table('reservasi', $start, $join, $select, null, ['reservasi.keterangan', 'lokasi_tujuan'], null, 'reservasi.id DESC');

		$data = $get['data'];
		$get['data'] = [];
		$start = $start + 1;
		foreach ($data as $v) {
			$button = '';
			// $button .= '
			// 		<button type="button" class="btn btn-success" onclick="edit_status(\'' . base64_encode(json_encode($v)) . '\')"><i class="fa ' . 'fa-eye' . '"></i></button>
			// 		';

			// $button .= '
			// 		<a target="_blank" href="' . base_url('rent/send_whatsapp/' . $v->id) . '" class="btn btn-info"><i class="fa fa-whatsapp"></i></a>
			// 		';


			$get['data'][] = [
				$start,
				$v->jumlah,
				$v->keterangan,
				$v->lokasi_tujuan,
				$v->material,
				$v->lokasi,
				// $button
			];
			$start++;
		}

		echo json_encode($get);
	}

	public function delete()
	{
		if ($this->input->method(TRUE) == 'POST') {
			$id = $this->input->post('id');

			$where = ['id_peminjaman' => $id];
			$del = $this->M_master->del('peminjaman', $where);

			if ($del)
				$this->M_master->success('Berhasil hapus data');

			redirect('rent/');
		}
	}
}