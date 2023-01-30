<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_master extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_id($table, $where = null, $order = null)
	{
		$this->db->order_by($order);
		$where == null ? null : $this->db->where($where);
		return $this->db->get($table);
	}
	function get_like($table, $like = null, $where = null, $join = [], $order = null)
	{
		foreach ($join as $key => $value) {
			$this->db->join($key, $value, 'LEFT');
		}
		$this->db->order_by($order);
		if ($like != null) $this->db->like($like);
		if ($where != null) $this->db->where($where);
		return $this->db->get($table);
	}

	function search_sopir($like = null, $where = null)
	{
		$this->db->select('peminjaman.status status_peminjaman'); // Sopir
		$this->db->select('sopir.id_sopir id_sopir, sopir.nama nama_sopir'); // Sopir
		$this->db->select('mobil.warna warna, mobil.plat plat'); // Mobil
		$this->db->select('jenis.jenis jenis'); // Jenis
		$this->db->join('peminjaman', 'sopir.id_sopir = peminjaman.id_sopir and peminjaman.status != "done"', 'LEFT');
		$this->db->join('mobil', 'sopir.id_mobil = mobil.id_mobil');
		$this->db->join('jenis', 'mobil.id_jenis = jenis.id_jenis');
		$this->db->order_by('sopir.nama', 'ASC');
		if ($like != null) $this->db->like($like);
		if ($where != null) $this->db->where($where);
		return $this->db->get('sopir');
	}
	function get_count_id($table, $where)
	{
		$this->db->where($where);
		return $this->db->query("SELECT COUNT(*) AS total FROM $table WHERE $where");
	}
	function get_join_id($table, $join, $where, $select = '*', $order = null)
	{
		$this->db->select($select);

		foreach ($join as $j) {
			$this->db->join($j['table'], $j['fk']);
		}
		$this->db->order_by($order);
		$this->db->where($where);

		return $this->db->get($table);
	}
	function get_join($table, $join, $on, $order = null)
	{
		$this->db->join($join, $on);
		$this->db->order_by($order);
		return $this->db->get($table);
	}

	function get($table, $order = null)
	{
		$this->db->order_by($order);
		return $this->db->get($table);
	}
	function get_data_table($table, $start, $join = [], $select = null, $where = null, $search_key = [], $group_by = null, $order_by = null)
	{
		$draw       = $this->input->post('draw');
		$length     = $this->input->post('length');
		$search     = $this->input->post('search')['value'];

		$output     = [
			'draw'              => $draw,
			'recordsTotal'      => 0,
			'recordsFiltered'   => 0,
			'data'              => []
		];

		foreach ($join as $key => $value) {
			$on = is_array($value) ? $value['on'] : $value;
			$join = is_array($value) ? $value['join'] : 'INNER';
			$this->db->join($key, $on, $join);
		}
		if ($select) {
			$this->db->select($select);
		}
		$get	= $this->db->from($table)
			->limit($length, $start);
		if ($search != '') {
			foreach ($search_key as $value) {
				$get->or_like('LOWER(' . $value . ')', strtolower($search));
			}
		}
		if ($where) {
			$this->db->where($where);
		}
		if ($group_by) {
			$this->db->group_by($group_by);
		}
		if ($order_by) {
			$this->db->order_by($order_by);
		}

		$output['data']	= $get->get()->result();
		$output['recordsTotal'] = $output['recordsFiltered']  = $this->db->from($table)->count_all_results();

		return $output;
	}
	function add($table, $data)
	{
		return $this->db->insert($table, $data);
	}
	function edit($table, $data, $where)
	{
		$this->db->where($where);
		return $this->db->update($table, $data);
	}
	function del($table, $where)
	{
		$this->db->where($where);
		return $this->db->delete($table);
	}
	function search($table, $like)
	{
		$this->db->like($like);
		return $this->db->get($table);
	}
	function print_report($from, $to, $group)
	{
		switch ($group) {
			case 'pegawai':
				$sql = "SELECT nama, 'Duren Tiga' as lokasi_kantor, jabatan, count(id_user) jumlah, count(id_user) jumlah, GROUP_CONCAT(Date(p.created_date)) tanggal, GROUP_CONCAT(Time(p.created_date)) jam FROM users u JOIN peminjaman p ON u.id_user = p.id_pegawai WHERE DATE(p.created_date) BETWEEN '" . $from . "' AND '" . $to . "' GROUP BY id_user;";
				break;
			case 'sopir':
				$sql = "SELECT nama, no_telp, count(p.id_sopir) jumlah, alamat_pelanggan, GROUP_CONCAT(Date(p.created_date)) tanggal, GROUP_CONCAT(Time(p.created_date)) jam FROM sopir s JOIN peminjaman p ON s.id_sopir = p.id_sopir WHERE DATE(p.created_date) BETWEEN '" . $from . "' AND '" . $to . "' GROUP BY p.id_sopir";
				break;
			case 'mobil':
				$sql = "SELECT m.plat plat, 'Indorent' as perusahaan, j.jenis, count(s.id_mobil) jumlah, GROUP_CONCAT(Date(p.created_date)) tanggal, GROUP_CONCAT(Time(p.created_date)) jam FROM mobil m JOIN sopir s ON m.id_mobil = s.id_mobil JOIN jenis j ON j.id_jenis = m.id_jenis JOIN peminjaman p ON s.id_sopir = p.id_sopir
				WHERE DATE(p.created_date) BETWEEN '" . $from . "' AND '" . $to . "' GROUP BY p.id_sopir;";
				break;
			default:
				$sql = "SELECT u.nama, 'Duren Tiga' as lokasi_kantor, u.email, s.nama nama_sopir, no_telp, jenis, 'Indorent' as perusahaan, plat, count(s.id_mobil) jumlah, alamat_pelanggan, 'Ada' as dokumen, GROUP_CONCAT(alamat_pelanggan) tujuan, GROUP_CONCAT(Date(p.created_date)) tanggal, GROUP_CONCAT(Time(p.created_date)) jam FROM users u JOIN peminjaman p ON u.id_user = p.id_pegawai JOIN sopir s ON p.id_sopir = s.id_sopir JOIN mobil m ON m.id_mobil = s.id_mobil JOIN jenis j ON j.id_jenis = m.id_jenis WHERE DATE(p.created_date) BETWEEN '" . $from . "' AND '" . $to . "' GROUP BY id_user;";
				break;
		}
		return $this->db->query($sql);
	}
	function success($mess)
	{
		$this->session->set_flashdata("msg", ['success', $mess]);
		// "<div class='alert alert-info'><center>" . $mess . "</center></div>");
	}
	function wrong($mess)
	{
		$this->session->set_flashdata("msg", ['danger', $mess]);
		// "<div class='alert alert-danger'><center>" . $mess . "</center></div>");
	}
	function warning($mess)
	{
		$this->session->set_flashdata("msg", ['warning', $mess]);
		// "<div class='alert alert-warning'><center>" . $mess . "</center></div>");
	}
	function access($only)
	{
		$access =  in_array($this->session->userdata('level'), $only);
		return $access;
	}
}
