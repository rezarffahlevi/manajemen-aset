<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rma extends CI_Controller
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
			'material' => ['on' => 'material.id=rma.material_id', 'join' => 'LEFT'],
			'penyimpanan' => ['on' => 'penyimpanan.id=rma.penyimpanan_id', 'join' => 'LEFT'],
		];
		$select = '*, ';
		$select .= 'rma.id as id, rma.keterangan as keterangan, rma.jumlah as jumlah';
		$start = $this->input->post('start');
		$get = $this->M_master->get_data_table('rma', $start, $join, $select, null, ['rma.keterangan', 'lokasi_barang'], null, 'rma.id DESC');

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
				$v->lokasi_barang,
				$v->material,
				$v->lokasi,
				$v->pic,
				$v->tgl_rma,
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