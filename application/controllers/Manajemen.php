<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manajemen extends CI_Controller
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
			'spr' => ['on' => 'material.spr_id=spr.id', 'join' => 'LEFT'],
			'rekanan' => ['on' => 'rekanan.id=spr.rekanan_id', 'join' => 'LEFT'],
			'penyimpanan' => ['on' => 'penyimpanan.id=material.penyimpanan_id', 'join' => 'LEFT'],
		];
		$select = '*, ';
		$select .= 'spr.id as id';
		$start = $this->input->post('start');
		$get = $this->M_master->get_data_table('material', $start, $join, $select, null, ['no_spr', 'judul'], null, 'created_at DESC');

		$data = $get['data'];
		$get['data'] = [];
		$start = $start + 1;
		foreach ($data as $v) {
			// $material = $this->M_master->get_id('reservasi', ['material_id' => $v->id, 'status' => 'Butuh Persetujuan'])->row();
			$button = '';
			// $button .= '
			// 		<a target="_blank" href="' . base_url('rent/send_whatsapp/' . $v->id) . '" class="btn btn-info"><i class="fa fa-whatsapp"></i></a>
			// 		';
			// if ($material) {
			// 	$button .= '<span class="label label-danger">Butuh Persetujuan</span>';
			// }

			$get['data'][] = [
				$start,
				$v->number,
				$v->material,
				$v->brand,
				$v->vendor,
				$v->lokasi,
				$v->jumlah,
				// $button
			];
			$start++;
		}

		echo json_encode($get);
	}

	public function ajax_search_user($jabatan = 'PTL', $param = null)
	{
		$results = [];
		$like = null;
		$where = null;
		if ($param)
			$like = ['nama' => $param];

		if ($jabatan === 'Pegawai')
			$where = "jabatan != 'Kapool' AND jabatan != 'PTL'";
		else
			$where = ['jabatan' => $jabatan];

		$data = $this->M_master->get_like('users', $like, $where)->result();
		foreach ($data as $key => $value) {
			$result['id'] = $value->id_user;
			$result['text'] = $value->nama . ' | ' . $value->email;
			$results[] = $result;
		}

		$output = [
			'results' => $results
		];

		echo json_encode($output);
	}

	public function save_spr()
	{
		if ($this->input->method(TRUE) == 'POST') {
			// SPR
			$id = $this->input->post('id');
			$judul = $this->input->post('judul');
			$no_spr = $this->input->post('no_spr');
			$rab = $this->input->post('rab');
			$realisasi = $this->input->post('realisasi');
			$jenis_anggaran = $this->input->post('jenis_anggaran');
			$rekanan = $this->input->post('rekanan');
			$nomor_io = $this->input->post('nomor_io');
			$date = $this->input->post('tgl');
			$tgl = date('Y-m-d', strtotime($date));
			$updated_at = date('Y-m-d H:i:s');

			$count_material = $this->input->post('count_material');

			$data = [
				'judul' => $judul,
				'no_spr' => $no_spr,
				'rab' => $rab,
				'realisasi' => $realisasi,
				'jenis_anggaran' => $jenis_anggaran,
				'rekanan_id' => $rekanan,
				'nomor_io' => $nomor_io,
				'tgl' => $tgl,
				// 'status' => 'Tersedia',
				'updated_at' => $updated_at,
			];

			$msg = 'Berhasil tambah data';

			if (!empty($id)) {
				$where = ['id' => $id];
				$edit = $this->M_master->edit('spr', $data, $where);
				$msg = 'Berhasil ubah data';
			} else {
				$this->load->database();
				$data['created_at'] = $updated_at;
				$add = $this->M_master->add('spr', $data);

				// MATERIALS
				$materials = array();
				for ($i = 1; $i <= $count_material; $i++) {
					$mat_number = $this->input->post('mat_number_' . $i);
					$mat_name = $this->input->post('mat_name_' . $i);
					$mat_brand = $this->input->post('mat_brand_' . $i);
					$mat_vendor = $this->input->post('mat_vendor_' . $i);
					$mat_penyimpanan_id = $this->input->post('mat_penyimpanan_id_' . $i);
					$mat_jumlah = $this->input->post('mat_jumlah_' . $i);
					$material = [
						'spr_id' => $this->db->insert_id(),
						'number' => $mat_number,
						'material' => $mat_name,
						'brand' => $mat_brand,
						'vendor' => $mat_vendor,
						'penyimpanan_id' => $mat_penyimpanan_id,
						'jumlah' => $mat_jumlah,
					];
					array_push($materials, $material);
				}
				$this->db->insert_batch('material', $materials);
			}

			$this->M_master->success($msg);
			redirect('manajemen/');
		}
	}

	public function update_stock()
	{
		if ($this->input->method(TRUE) == 'POST') {
			$id = $this->input->post('id');
			$material_number = $this->input->post('material_number');
			$storage_loc = $this->input->post('storage_loc');
			$update_stock = $this->input->post('update_stock');

			$data = [
				// 'number' => $material_number,
				'penyimpanan_id' => $storage_loc,
				'jumlah' => $update_stock,
			];
			$where = ['id' => $material_number];
			$edit = $this->M_master->edit('material', $data, $where);
			if ($edit)
				$msg = 'Berhasil ubah data';

			$this->M_master->success($msg);
			redirect('manajemen/');
		}
	}
	public function save_reservasi()
	{
		if ($this->input->method(TRUE) == 'POST') {
			$id = $this->input->post('id');
			$material_number = $this->input->post('material_number');
			$tgl = $this->input->post('tgl');
			$storage_loc = $this->input->post('storage_loc');
			$pic = $this->input->post('pic');
			$jumlah = $this->input->post('jumlah');
			$lokasi = $this->input->post('lokasi');
			$keterangan = $this->input->post('keterangan');
			$updated_at = date('Y-m-d H:i:s');

			$data = [
				'material_id' => $material_number,
				'tgl_reservasi' => $tgl,
				'penyimpanan_id' => $storage_loc,
				'pic' => $pic,
				'jumlah' => $jumlah,
				'lokasi_tujuan' => $lokasi,
				'keterangan' => $keterangan,
				'status' => 'Butuh Persetujuan',
				'created_at' => $updated_at,
			];

			// $data_update = [
			// 	'penyimpanan_id' => $storage_loc,
			// 	'jumlah' => $jumlah,
			// ];

			if (!empty($material_number)) {
				$where = ['id' => $material_number];
				// $material = $this->M_master->get_id('material', $where)->row();
				// $data_update['jumlah'] = $material->jumlah - $jumlah;
				$add = $this->M_master->add('reservasi', $data);
				// $edit = $this->M_master->edit('material', $data_update, $where);
				$msg = 'Berhasil membuat resevasi';
			} else {
				$add = $this->M_master->add('reservasi', $data);
				$msg = 'Berhasil tambah data';
			}

			$this->M_master->success($msg);
			redirect('reservasi/');
		}
	}

	public function save_rma()
	{
		if ($this->input->method(TRUE) == 'POST') {
			$id = $this->input->post('id');
			$material_number = $this->input->post('material_number');
			$tgl = $this->input->post('tgl');
			$lokasi = $this->input->post('lokasi');
			$storage_loc = $this->input->post('storage_loc');
			$lokasi = $this->input->post('lokasi');
			$pic = $this->input->post('pic');
			$jumlah = $this->input->post('jumlah');
			$keterangan = $this->input->post('keterangan');
			$updated_at = date('Y-m-d H:i:s');

			$data = [
				'material_id' => $material_number,
				'tgl_rma' => $tgl,
				'penyimpanan_id' => $storage_loc,
				'pic' => $pic,
				'jumlah' => $jumlah,
				'lokasi_barang' => $lokasi,
				'keterangan' => $keterangan,
				'created_at' => $updated_at,
			];

			$data_update = [
				'penyimpanan_id' => $storage_loc,
				'jumlah' => $jumlah,
			];

			if (!empty($material_number)) {
				$where = ['id' => $material_number];
				$material = $this->M_master->get_id('material', $where)->row();
				$data_update['jumlah'] = $material->jumlah + $jumlah;
				$add = $this->M_master->add('rma', $data);
				$edit = $this->M_master->edit('material', $data_update, $where);
				$msg = 'Berhasil membuat rma';
			} else {
				$add = $this->M_master->add('rma', $data);
				$msg = 'Berhasil tambah data';
			}

			$this->M_master->success($msg);
			redirect('manajemen/');
		}
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


	public function print($id_peminjaman)
	{
		$this->load->library('Pdf');
		$join = [
			['table' => 'users ptl', 'fk' => 'ptl.id_user=peminjaman.id_ptl'],
			['table' => 'users kapool', 'fk' => 'kapool.id_user=peminjaman.id_kapool'],
			['table' => 'users pegawai', 'fk' => 'pegawai.id_user=peminjaman.id_pegawai'],
			[
				'table' => 'sopir',
				'fk' => 'sopir.id_sopir=peminjaman.id_sopir',
			],
			['table' => 'mobil', 'fk' => 'mobil.id_mobil=sopir.id_mobil'],
		];
		$where = ['peminjaman.id_peminjaman' => $id_peminjaman];
		$select = 'no_so, nama_pelanggan, alamat_pelanggan, keperluan, jumlah_penumpang, peminjaman.status status_peminjaman, peminjaman.created_date tgl_berangkat, peminjaman.updated_date tgl_kembali, '; // Peminjaman
		$select .= 'pegawai.nama nama_pegawai, pegawai.jabatan jabatan_pegawai, '; // Pegawai
		$select .= 'ptl.nama nama_ptl, '; // PTL
		$select .= 'kapool.nama nama_kapool, kapool.ttd ttd_kapool, '; // Kapool
		$select .= 'plat, '; // Mobil
		$select .= 'sopir.nama nama_sopir'; // sopir
		$data = $this->M_master->get_join_id('peminjaman', $join, $where, $select)->row();

		$this->load->helper('date');
		$data->tanggal = tgl_indo(date('Y-m-d'));
		// echo json_encode($data);
		$this->pdf->create_letter($data, 'test.pdf');
		// $aa['content'] = 'letter';
		// $aa['data'] = $data;
		// $this->load->view('layout', $aa);
	}

	public function detail($id_peminjaman)
	{
		// $this->load->library('Pdf');
		$join = [
			['table' => 'users ptl', 'fk' => 'ptl.id_user=peminjaman.id_ptl'],
			['table' => 'users kapool', 'fk' => 'kapool.id_user=peminjaman.id_kapool'],
			['table' => 'users pegawai', 'fk' => 'pegawai.id_user=peminjaman.id_pegawai'],
			['table' => 'sopir', 'fk' => 'sopir.id_sopir=peminjaman.id_sopir'],
			['table' => 'mobil', 'fk' => 'mobil.id_mobil=sopir.id_mobil'],
		];
		$where = ['peminjaman.id_peminjaman' => $id_peminjaman];
		$select = 'no_so, nama_pelanggan, alamat_pelanggan, keperluan, jumlah_penumpang, peminjaman.status status_peminjaman, peminjaman.created_date tgl_berangkat, peminjaman.updated_date tgl_kembali, '; // Peminjaman
		$select .= 'pegawai.nama nama_pegawai, pegawai.jabatan jabatan_pegawai, '; // Pegawai
		$select .= 'ptl.nama nama_ptl, '; // PTL
		$select .= 'kapool.nama nama_kapool, kapool.ttd ttd_kapool, '; // Kapool
		$select .= 'plat, '; // Mobil
		$select .= 'sopir.nama nama_sopir'; // sopir
		$data = $this->M_master->get_join_id('peminjaman', $join, $where, $select)->row();

		$this->load->helper('date');
		$data->tanggal = tgl_indo(date('Y-m-d'));
		echo json_encode($data);
		// $this->pdf->create_letter($data, 'test.pdf');
	}
}