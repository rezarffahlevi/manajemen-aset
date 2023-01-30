<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Material extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_master');
        if (!$this->M_master->access(['Admin'])) {
            redirect('auth/');
        }
    }

    public function jx_get_data()
    {
        $start  = $this->input->post('start');

		$select = '*, material.id as id'; // Peminjaman
        $join = [
			'penyimpanan' => ['on' => 'material.penyimpanan_id = penyimpanan.id', 'join' => 'LEFT'],
        ];
        $get    = $this->M_master->get_data_table('material', $start, $join, $select, null, ['material']);

        $data           = $get['data'];
        $get['data']    = [];
        $start          = $start + 1;
        foreach ($data as $v) {
            $button    = '
			<button type="button" class="btn btn-primary" onclick="show_edit(\'' . base64_encode(json_encode($v)) . '\')"><i class="fa fa-pencil"></i></button>
			<button type="button" class="btn btn-danger" onclick="show_delete(\'' . $v->id . '\')"><i class="fa fa-times"></i></button>
			';

            $get['data'][]   = [
                $start,
                $v->number,
                $v->material,
                $v->brand,
                $v->vendor,
                $v->lokasi,
                $v->jumlah,
                $button
            ];
            $start++;
        }

        echo json_encode($get);
    }

    public function save()
    {
        if ($this->input->method(TRUE) == 'POST') {
            $id      = $this->input->post('id');
            $number   = $this->input->post('number');
            $material   = $this->input->post('material');
            $brand   = $this->input->post('brand');
            $vendor   = $this->input->post('vendor');
            $penyimpanan_id   = $this->input->post('penyimpanan_id');
            $jumlah   = $this->input->post('jumlah');

            $data   = [
                'number' => $number,
                'material' => $material,
                'brand' => $brand,
                'vendor' => $vendor,
                'penyimpanan_id' => $penyimpanan_id,
                'jumlah' => $jumlah,
            ];
            $msg    = 'Berhasil tambah data';
            if (!empty($id)) {
                $where  = ['id' => $id];
                $edit   = $this->M_master->edit('material', $data, $where);
                $msg    = 'Berhasil ubah data';
            } else {
                $add    = $this->M_master->add('material', $data);
            }

            $this->M_master->success($msg);
            redirect('master/material/');
        }
    }

	public function ajax_search($param = null)
	{
		$results = [];
		$like = null;
		$where = null;
		if ($param)
			$like = ['id' => $param, 'material' => $param, 'number' => $param];

		$data = $this->M_master->get_like('material', $like, $where)->result();
		foreach ($data as $key => $value) {
			$result['id'] = $value->id;
			$result['text'] = $value->number . ' | ' . $value->material;
			$results[] = $result;
		}

		$output = [
			'results' => $results
		];

		echo json_encode($output);
	}
    
    public function delete()
    {
        if ($this->input->method(TRUE) == 'POST') {
            $id     = $this->input->post('id');

            $where  = ['id' => $id];
            $del    = $this->M_master->del('material', $where);

            $this->M_master->success('Berhasil hapus data');
            redirect('master/material/');
        }
    }
}
