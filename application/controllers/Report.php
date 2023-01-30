<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_master');
		if (!$this->M_master->access(['Superadmin', 'Admin', 'User'])) {
			redirect('auth/');
		}
	}

	public function index()
	{
		$data['tipe_user'] 	= $this->session->userdata('tipe');
		$data['content'] 	= 'content/report';
		$this->load->view('layout', $data);
	}

	public function jx_get_data()
	{
		$from  = $this->input->post('from');
		$to  = $this->input->post('to');
		$summary_for  = $this->input->post('group_by');

		$table = 'users u';
		$join = [
			'peminjaman p' => 'u.id_user=p.id_pegawai',
		];
		$where = "DATE(p.created_date) BETWEEN '" . $from . "' AND '" . $to . "'";
		$select = 'nama, email field2, count(id_user) jumlah';
		$group_by = 'id_user';

		switch ($summary_for) {
			case 'pegawai':
				$table = 'users u';
				$select = 'nama, "Duren Tiga" as lokasi_kantor, jabatan, count(id_user) jumlah';
				$join = [
					'peminjaman p' => 'u.id_user=p.id_pegawai',
				];
				$group_by = 'id_user';
				break;
			case 'sopir':
				$table = 'sopir s';
				$select = 'nama, no_telp, count(p.id_sopir) jumlah, alamat_pelanggan';
				$join = [
					'peminjaman p' => 's.id_sopir=p.id_sopir',
				];
				$group_by = 's.id_sopir';
				break;
			case 'mobil':
				$table = 'mobil m';
				$select = 'm.plat plat, "Indorent" as perusahaan, j.jenis, count(s.id_mobil) jumlah';
				$join = [
					'sopir s' => 'm.id_mobil=s.id_mobil',
					'jenis j' => 'j.id_jenis=m.id_jenis',
					'peminjaman p' => 's.id_sopir=p.id_sopir',
				];
				$group_by = 'm.id_mobil';
				break;
			default:
				$table = 'mobil m';
				$select = 'u.nama, "Duren Tiga" as lokasi_kantor, u.email, s.nama nama_sopir, no_telp, jenis, "Indorent" as perusahaan, plat, count(s.id_mobil) jumlah, alamat_pelanggan, "Ada" as dokumen';
				$join = [
					'sopir s' => 'm.id_mobil=s.id_mobil',
					'jenis j' => 'j.id_jenis=m.id_jenis',
					'peminjaman p' => 's.id_sopir=p.id_sopir',
					'users u' => 'u.id_user=p.id_pegawai',
				];
				$group_by = 'm.id_mobil';
				break;
		}

		$select .= ', GROUP_CONCAT(alamat_pelanggan) tujuan, GROUP_CONCAT(Date(p.created_date)) tanggal, GROUP_CONCAT(Time(p.created_date)) jam';
		$start  = $this->input->post('start');
		$get    = $this->M_master->get_data_table($table, $start, $join, $select, $where, ['nama'], $group_by, 'jumlah DESC');

		$data           = $get['data'];
		$get['data']    = [];
		$start          = $start + 1;
		foreach ($data as $v) {
			$button = '';

			switch ($summary_for) {
				case 'pegawai':
					$get['data'][]   = [
						$start,
						$v->nama,
						$v->lokasi_kantor,
						$v->jabatan,
						$v->jumlah,
						str_replace(',', ',<br>', $v->tanggal),
						str_replace(',', ',<br>', $v->jam),
					];
					break;
				case 'sopir':
					$get['data'][]   = [
						$start,
						$v->nama,
						$v->no_telp ?? '-',
						$v->alamat_pelanggan,
						$v->jumlah,
						str_replace(',', ',<br>', $v->tanggal),
						str_replace(',', ',<br>', $v->jam),
					];
					break;
				case 'mobil':
					$get['data'][]   = [
						$start,
						$v->plat,
						$v->perusahaan,
						$v->jenis,
						$v->jumlah,
						str_replace(',', ',<br>', $v->tanggal),
						str_replace(',', ',<br>', $v->jam),
					];
					break;
				default:
					$get['data'][]   = [
						$start,
						$v->nama,
						$v->lokasi_kantor,
						$v->email,
						$v->nama_sopir,
						$v->no_telp ?? '-',
						$v->jenis,
						$v->perusahaan,
						$v->plat,
						$v->jumlah,
						str_replace(',', ',<br>', $v->tujuan),
						str_replace(',', ',<br>', $v->tanggal),
						str_replace(',', ',<br>', $v->jam),
						$v->dokumen,
					];
					break;
			}
			$start++;
		}

		echo json_encode($get);
	}

	public function print($from, $to, $group)
	{
		$this->load->library('Pdf');

		$data = new stdClass();
		$data->data	= $this->M_master->print_report($from, $to, $group)->result();

		$this->load->helper('date');
		$data->group = strtoupper($group);
		$data->from = tgl_indo($from);
		$data->to = tgl_indo($to);
		switch ($group) {
			case 'pegawai':
				$data->field = ['nama' => 'Nama Pegawai', 'lokasi_kantor' => 'Lokasi Kantor', 'jabatan' => 'Divisi', 'jumlah' => 'Jumlah Keberangkatan', 'tanggal' => 'Tanggal', 'jam' => 'Jam'];
				break;
			case 'sopir':
				$data->field = ['nama' => 'Nama Sopir', 'no_telp' => 'No Telp', 'alamat_pelanggan' => 'Tujuan', 'jumlah' => 'Jumlah Keberangkatan', 'tanggal' => 'Tanggal', 'jam' => 'Jam'];
				break;
			case 'mobil':
				$data->field = ['plat' => 'No Plat', 'perusahaan' => 'Perusahaan', 'jenis' => 'Jenis Mobil', 'jumlah' => 'Jumlah Keberangkatan', 'tanggal' => 'Tanggal', 'jam' => 'Jam'];
				break;
			default:
				$data->field =  ['nama' => 'Nama Peminjam', 'lokasi_kantor' => 'Lokasi Kantor', 'email' => 'Email Pegawai', 'nama_sopir' => 'Nama Sopir', 'no-telp' => 'No Telp', 'jenis' => 'Jenis Mobil', 'perusahaan' => 'Perusahaan', 'plat' => 'Plat Nomor', 'jumlah' => 'Jumlah Keberangkatan', 'tujuan' => 'Tujuan', 'tanggal' => 'Tanggal', 'jam' => 'Jam', 'dokumen' => 'Dokumen Pendukung'];
				break;
		}
		// echo json_encode($data);
		$this->pdf->create_report($data, $group . '_' . $from . '_' . $to);
	}
}
