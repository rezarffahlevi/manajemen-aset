<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rent extends CI_Controller
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
		$data['content'] 	= 'content/rent';
		$this->load->view('layout', $data);
	}

	public function jx_get_data()
	{
		$join = [
			'users ptl' => 'ptl.id_user=peminjaman.id_ptl',
			'users kapool' => 'kapool.id_user=peminjaman.id_kapool',
			'sopir' => ['on' => 'sopir.id_sopir=peminjaman.id_sopir', 'join' => 'LEFT'],
			'mobil' => ['on' => 'mobil.id_mobil=sopir.id_mobil', 'join' => 'LEFT'],
			'jenis' => ['on' => 'jenis.id_jenis=mobil.id_jenis', 'join' => 'LEFT'],
		];
		$select = 'id_peminjaman, no_so, nama_pelanggan, peminjaman.status status_peminjaman, peminjaman.created_date tgl_berangkat, peminjaman.updated_date tgl_kembali, '; // Peminjaman
		$select .= 'ptl.nama nama_ptl, '; // PTL
		$select .= 'kapool.nama nama_kapool, '; // Kapool
		$select .= 'plat, warna, '; // Mobil
		$select .= 'jenis, ';
		$select .= 'sopir.nama nama_sopir'; // sopir
		$tipe_user = $this->session->userdata('tipe');
		$start  = $this->input->post('start');
		$get    = $this->M_master->get_data_table('peminjaman', $start, $join, $select, null, ['no_so', 'nama_pelanggan', 'ptl.nama', 'kapool.nama', 'plat', 'jenis', 'warna', 'sopir.nama'], null, 'id_peminjaman DESC');

		$data           = $get['data'];
		$get['data']    = [];
		$start          = $start + 1;
		foreach ($data as $v) {
			$button = '';
			$disabled = $v->status_peminjaman == 'queue' ? ' disabled' : '';
			if ($tipe_user != 'Admin') {
				$button	.= '
				<button type="button" class="btn btn-danger ' . ($v->status_peminjaman != 'queue' && $tipe_user != 'Superadmin' ? " disabled" : "") . '" onclick="show_delete(\'' . $v->id_peminjaman . '\')"><i class="fa fa-times"></i></button>
				';
			}
			if ($tipe_user == 'User' && $v->status_peminjaman == 'run') {
				$button .= '
				<button type="button" class="btn btn-success" onclick="edit_status(\'' . base64_encode(json_encode($v)) . '\')"><i class="fa fa-check"></i></button>
				';
			}
			if ($tipe_user != 'User') {
				if ($v->status_peminjaman != 'queue') {
					$button    .= '
					<a target="_blank" href="' . base_url('rent/print/' . $v->id_peminjaman) . '" class="btn btn-primary"><i class="fa fa-print"></i></a>
					';
					$button	.= '<button type="button" class="btn btn-primary' . $disabled . '" onclick="show_detail(\'' . $v->id_peminjaman . '\')"><i class="fa fa-file"></i></button>';
				}
				if ($v->status_peminjaman == 'queue' || $v->status_peminjaman == 'run') {
					$icon_btn = $v->status_peminjaman == 'run' ? 'fa-check' : 'fa-car';
					$button .= '
					<button type="button" class="btn btn-success" onclick="edit_status(\'' . base64_encode(json_encode($v)) . '\')"><i class="fa ' . $icon_btn . '"></i></button>
					';
				}

				if ($v->status_peminjaman == 'run') {
					$button    .= '
					<a target="_blank" href="' . base_url('rent/send_whatsapp/' . $v->id_peminjaman) . '" class="btn btn-info"><i class="fa fa-whatsapp"></i></a>
					';
				}
			}

			$get['data'][]   = [
				$start,
				$v->no_so,
				$v->nama_pelanggan,
				$v->nama_ptl,
				$v->nama_kapool,
				empty($v->nama_sopir) ? '-' : $v->nama_sopir,
				empty($v->plat) ? '-' : $v->jenis . ' ' . $v->warna . ' | ' . $v->plat,
				date('d-m-Y', strtotime($v->tgl_berangkat)),
				$v->status_peminjaman == 'done' ? date('d-m-Y', strtotime($v->tgl_kembali)) : '-',
				ucfirst($v->status_peminjaman),
				$button
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

	public function ajax_search_sopir($param = null)
	{
		$results = [];
		$like 	= null;
		if ($param)
			$like = ['nama' => $param];
		$data = $this->M_master->search_sopir($like, ['sopir.status' => 'hadir'])->result();
		foreach ($data as $key => $value) {
			if ($value->status_peminjaman == '') {
				$result['id'] = $value->id_sopir;
				$result['text'] = $value->nama_sopir . ' | ' . $value->jenis . ' ' . $value->warna . ' | ' . $value->plat;
				$results[] = $result;
			}
		}

		$output = [
			'results' => $results
		];

		echo json_encode($output);
	}

	public function save()
	{
		if ($this->input->method(TRUE) == 'POST') {
			$id             	= $this->input->post('id');
			$no_so           	= $this->input->post('no_so');
			$nama_pelanggan     = $this->input->post('nama_pelanggan');
			$alamat_pelanggan   = $this->input->post('alamat_pelanggan');
			$ptl          		= $this->input->post('ptl');
			$kapool          	= $this->input->post('kapool');
			$pegawai    	   	= $this->input->post('pegawai');
			$keperluan    	   	= $this->input->post('keperluan');
			$jumlah_penumpang   = $this->input->post('jumlah_penumpang');
			$sopir   	       	= $this->input->post('sopir');
			$date   			= $this->input->post('created_date');
			$created_date		= date('Y-m-d H:i:s', strtotime($date));

			$data   = [
				'no_so'             => $no_so,
				'nama_pelanggan'	=> $nama_pelanggan,
				'alamat_pelanggan'	=> $alamat_pelanggan,
				'id_ptl'         	=> $ptl,
				'id_kapool'         => $kapool,
				'id_pegawai'        => $pegawai,
				'id_sopir'         	=> null,
				'keperluan'         => $keperluan,
				'jumlah_penumpang'	=> $jumlah_penumpang,
				'status'         	=> 'queue',
				'created_date'      => $created_date,
			];

			$msg    = 'Berhasil tambah data';

			if (!empty($id)) {
				$where  = ['id_peminjaman' => $id];
				$edit   = $this->M_master->edit('peminjaman', $data, $where);
				$msg    = 'Berhasil ubah data';
			} else {
				$add    = $this->M_master->add('peminjaman', $data);
			}

			$this->M_master->success($msg);
			redirect('rent/');
		}
	}

	public function update_status()
	{
		if ($this->input->method(TRUE) == 'POST') {
			$id             	= $this->input->post('id');
			$sopir            	= $this->input->post('sopir');
			$status            	= $this->input->post('status');

			$data   = [
				'status'         	=> $status,
			];
			if ($sopir) {
				$data['id_sopir']         	= $sopir;
			}

			if (!empty($id)) {
				$where  = ['id_peminjaman' => $id];
				$edit   = $this->M_master->edit('peminjaman', $data, $where);
				$msg    = 'Berhasil ubah data';
			} else {
				$add    = $this->M_master->add('peminjaman', $data);
			}

			$this->M_master->success($msg);
			redirect('rent/');
		}
	}

	public function delete()
	{
		if ($this->input->method(TRUE) == 'POST') {
			$id     = $this->input->post('id');

			$where  = ['id_peminjaman' => $id];
			$del    = $this->M_master->del('peminjaman', $where);

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
			['table' => 'sopir', 'fk' => 'sopir.id_sopir=peminjaman.id_sopir',],
			['table' => 'mobil', 'fk' => 'mobil.id_mobil=sopir.id_mobil'],
		];
		$where = ['peminjaman.id_peminjaman' => $id_peminjaman];
		$select = 'no_so, nama_pelanggan, alamat_pelanggan, keperluan, jumlah_penumpang, peminjaman.status status_peminjaman, peminjaman.created_date tgl_berangkat, peminjaman.updated_date tgl_kembali, '; // Peminjaman
		$select .= 'pegawai.nama nama_pegawai, pegawai.jabatan jabatan_pegawai, '; // Pegawai
		$select .= 'ptl.nama nama_ptl, '; // PTL
		$select .= 'kapool.nama nama_kapool, kapool.ttd ttd_kapool, '; // Kapool
		$select .= 'plat, '; // Mobil
		$select .= 'sopir.nama nama_sopir'; // sopir
		$data	= $this->M_master->get_join_id('peminjaman', $join, $where, $select)->row();

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
		$data	= $this->M_master->get_join_id('peminjaman', $join, $where, $select)->row();

		$this->load->helper('date');
		$data->tanggal = tgl_indo(date('Y-m-d'));
		echo json_encode($data);
		// $this->pdf->create_letter($data, 'test.pdf');
	}

	public function send_whatsapp($id_peminjaman = '')
	{
		$this->load->helper('date');

		$join = [
			['table' => 'users ptl', 'fk' => 'ptl.id_user=peminjaman.id_ptl'],
			['table' => 'users kapool', 'fk' => 'kapool.id_user=peminjaman.id_kapool'],
			['table' => 'users pegawai', 'fk' => 'pegawai.id_user=peminjaman.id_pegawai'],
			['table' => 'sopir', 'fk' => 'sopir.id_sopir=peminjaman.id_sopir'],
			['table' => 'mobil', 'fk' => 'mobil.id_mobil=sopir.id_mobil'],
			['table' => 'jenis', 'fk' => 'jenis.id_jenis=mobil.id_jenis'],
		];
		$where = ['peminjaman.id_peminjaman' => $id_peminjaman];
		$select = 'no_so, nama_pelanggan, alamat_pelanggan, keperluan, jumlah_penumpang, '; // Peminjaman
		$select .= 'pegawai.nama nama_pegawai, pegawai.jabatan jabatan_pegawai, '; // Pegawai
		$select .= 'ptl.nama nama_ptl, '; // PTL
		$select .= 'kapool.nama nama_kapool, kapool.ttd ttd_kapool, '; // Kapool
		$select .= 'plat, warna, '; // Mobil
		$select .= 'jenis, '; // Jenis
		$select .= 'sopir.nama nama_sopir, sopir.no_telp no_telp_sopir'; // sopir
		$data	= $this->M_master->get_join_id('peminjaman', $join, $where, $select)->row();
		$no_telp = '62' . substr($data->no_telp_sopir, 1);

		$wa_msg = "https://web.whatsapp.com/send?phone={$no_telp}&text=-------SURAT+JALAN-------%0D%0APT+INDONESIA+COMNETS+PLUS%0D%0A-------------------------%0D%0A-------------------------%0D%0A%0D%0ANAMA+KARYAWAN%09%09+%3A+T_NAMA_KARYAWAN%0D%0AJABATAN%09%09%09%09+%3A+T_JABATAN%0D%0ANAMA+PTL%09%09%09+%3A+T_NAMA_PTL%0D%0AJENIS+PEKERJAAN%09%09+%3A+T_JENIS_PEKERJAAN%0D%0ANO.+SO%09%09%09%09+%3A+T_NO_SO%0D%0A%0D%0A-------------------------%0D%0A-------------------------%0D%0A%0D%0ANAMA+SUPIR%09%09%09+%3A+T_NAMA_SUPIR%0D%0AJENIS+MOBIL%09%09%09+%3A+T_JENIS+%2F+T_WARNA%0D%0ANOMOR+POLISI%09%09+%3A+T_NO_POL%0D%0ATANGGAL%09%09%09+%3A+T_TANGGAL%0D%0AWAKTU+PEMINJAMAN%09+%3A+T_WAKTU_PEMINJAMAN%0D%0A%0D%0A-------------------------%0D%0A-------------------------%0D%0A%0D%0ATERIMAKASIH+SELAMAT+JALAN+%26+JAGA+KESELAMATAN+BERKENDARA";

		$wa_msg = str_replace('T_NAMA_KARYAWAN', $data->nama_pegawai, $wa_msg);
		$wa_msg = str_replace('T_JABATAN', $data->jabatan_pegawai, $wa_msg);
		$wa_msg = str_replace('T_NAMA_PTL', $data->nama_ptl, $wa_msg);
		$wa_msg = str_replace('T_JENIS_PEKERJAAN', $data->keperluan, $wa_msg);
		$wa_msg = str_replace('T_NO_SO', $data->no_so, $wa_msg);
		$wa_msg = str_replace('T_NAMA_SUPIR', $data->nama_sopir, $wa_msg);
		$wa_msg = str_replace('T_JENIS', $data->jenis, $wa_msg);
		$wa_msg = str_replace('T_WARNA', $data->warna, $wa_msg);
		$wa_msg = str_replace('T_NO_POL', $data->plat, $wa_msg);
		$wa_msg = str_replace('T_TANGGAL', tgl_indo(date('Y-m-d')), $wa_msg);
		$wa_msg = str_replace('T_WAKTU_PEMINJAMAN', tgl_indo(date('Y-m-d')), $wa_msg);

		redirect($wa_msg);
	}
}
