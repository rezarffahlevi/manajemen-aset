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
		$data['content'] = 'content/approval';
		$this->load->view('layout', $data);
	}

	public function jx_get_data()
	{
		$join = [
			'material' => ['on' => 'material.id=reservasi.material_id', 'join' => 'INNER JOIN'],
			'spr' => ['on' => 'material.spr_id=spr.id', 'join' => 'INNER JOIN'],
			'rekanan' => ['on' => 'rekanan.id=spr.rekanan_id', 'join' => 'INNER JOIN'],
			'penyimpanan' => ['on' => 'penyimpanan.id=material.penyimpanan_id', 'join' => 'INNER JOIN'],
		];
		$select = '*, ';
		$select .= 'reservasi.id as id, reservasi.jumlah as jumlah';
		$where = 'reservasi.status = "Butuh Persetujuan"';
		$start = $this->input->post('start');
		$get = $this->M_master->get_data_table('reservasi', $start, $join, $select, $where, ['no_spr', 'judul'], null, 'reservasi.id DESC');

		$data = $get['data'];
		$get['data'] = [];
		$start = $start + 1;
		foreach ($data as $v) {
			$button = '';
			// $button .= '
			// 		<a target="_blank" href="' . base_url('rent/send_whatsapp/' . $v->id) . '" class="btn btn-info"><i class="fa fa-whatsapp"></i></a>
			// 		';
			$button .= '<span class="label label-danger approval" onclick="onAprovalClick(\'' . base64_encode(json_encode($v)) . '\')">Butuh Persetujuan</span>';


			$get['data'][] = [
				$start,
				$v->number,
				$v->material,
				$v->brand,
				$v->vendor,
				$v->lokasi,
				$v->pic,
				$v->jumlah,
				$v->tgl,
				$button
			];
			$start++;
		}

		echo json_encode($get);
	}

	public function jx_get_history()
	{
		$join = [
			'material' => ['on' => 'material.id=reservasi.material_id', 'join' => 'LEFT'],
			'penyimpanan' => ['on' => 'penyimpanan.id=reservasi.penyimpanan_id', 'join' => 'LEFT'],
		];
		$select = '*, ';
		$select .= 'reservasi.id as id, reservasi.keterangan as keterangan, reservasi.jumlah as jumlah, reservasi.status as status';
		$start = $this->input->post('start');
		$get = $this->M_master->get_data_table('reservasi', $start, $join, $select, null, ['reservasi.keterangan', 'lokasi_tujuan'], null, 'reservasi.id DESC');
		
		$data = $get['data'];
		$get['data'] = [];
		$start = $start + 1;
		foreach ($data as $v) {
			// $button = '';
			// if ($v->status == 'Butuh Persetujuan')
			// 	$button .= '<span class="label label-danger">' . $v->status . '</span>';


			$get['data'][] = [
				$start,
				$v->jumlah,
				$v->pic,
				$v->keterangan,
				$v->lokasi_tujuan,
				$v->material,
				$v->lokasi,
				$v->status,
				$v->tgl_reservasi,
				// $button
			];
			$start++;
		}

		echo json_encode($get);
	}

	public function approval()
	{
		if ($this->input->method(TRUE) == 'POST') {
			$reservasi_id = $this->input->post('reservasi_id');
			$material_id = $this->input->post('material_id');
			$jumlah = $this->input->post('jumlah');
			$status = $this->input->post('status');

			$where = ['id' => $material_id];
			$material = $this->M_master->get_id('material', $where)->row();
			if ((($material->jumlah - $jumlah) >= 0) || $status == 'Ditolak') {
				$data_update = [];
				$this->M_master->edit('reservasi', ['status' => $status], ['id' => $reservasi_id]);
				if ($status == 'Disetujui') {
					$data_update['jumlah'] = $material->jumlah - $jumlah;
					$this->M_master->edit('material', $data_update, $where);
				}
				$this->M_master->success('Reservasi berhasil ' . $status);
			} else {
				$this->M_master->wrong('Gagal, stok sudah tidak mencukupi. Silahkan membuat Reservasi baru.');
			}

			redirect('reservasi/');
		}
	}
}
