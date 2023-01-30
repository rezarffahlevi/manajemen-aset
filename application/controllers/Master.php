<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_master');
		if (!$this->M_master->access(['Admin'])) {
			redirect('auth/');
		}
	}
	public function index()
	{
		// $data['content'] 	= 'content/edit-user';
		// $this->load->view('layout', $data);
	}

	public function user()
	{
		$data['content'] 	= 'content/user';
		$this->load->view('layout', $data);
	}

	public function material()
	{
		$data['content'] 	= 'content/material';
		$this->load->view('layout', $data);
	}

	public function rekanan()
	{
		$data['content'] 	= 'content/rekanan';
		$this->load->view('layout', $data);
	}

	public function penyimpanan()
	{
		$data['content'] 	= 'content/penyimpanan';
		$this->load->view('layout', $data);
	}
}
