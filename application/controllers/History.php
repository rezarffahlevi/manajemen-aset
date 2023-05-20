<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_master');
		if (!$this->M_master->access(['Admin', 'SPV'])) {
			redirect('auth/');
		}
	}

	public function spr()
	{
		$data['content'] = 'content/history_spr';
		$this->load->view('layout', $data);
	}

    public function reservasi()
	{
		$data['content'] = 'content/history_reservasi';
		$this->load->view('layout', $data);
	}
    
    public function rma()
	{
		$data['content'] = 'content/history_rma';
		$this->load->view('layout', $data);
	}
	
}