<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_master');
    }

    public function jx_get_data()
    {
        if (!$this->M_master->access(['Admin'])) {
            redirect('auth/');
        }
        $start  = $this->input->post('start');
        $get    = $this->M_master->get_data_table('rekanan', $start, [], null, null, ['rekanan']);

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
                $v->nama_perusahaan,
                $v->pic,
                $v->email,
                $v->telp,
                $button
            ];
            $start++;
        }

        echo json_encode($get);
    }

    public function save()
    {
        if ($this->input->method(TRUE) == 'POST') {
            $id                 = $this->input->post('id');
            $nama_perusahaan    = $this->input->post('nama_perusahaan');
            $pic                = $this->input->post('pic');
            $email              = $this->input->post('email');
            $telp               = $this->input->post('telp');

            $data   = [
                'nama_perusahaan' => $nama_perusahaan,
                'pic' => $pic,
                'email' => $email,
                'telp' => $telp,
            ];

            $msg    = 'Berhasil tambah data';
            if (!empty($id)) {
                $where  = ['id' => $id];
                $edit   = $this->M_master->edit('rekanan', $data, $where);
                $msg    = 'Berhasil ubah data';
            } else {
                $add    = $this->M_master->add('rekanan', $data);
            }

            $this->M_master->success($msg);
            redirect('master/rekanan/');
        }
    }

    public function delete()
    {
        if ($this->input->method(TRUE) == 'POST') {
            $id     = $this->input->post('id');

            $where  = ['id' => $id];
            $del    = $this->M_master->del('rekanan', $where);

            $this->M_master->success('Berhasil hapus data');
            redirect('master/rekanan/');
        }
    }

	public function ajax_search($param = null)
	{
		$results = [];
		$like = null;
		$where = null;
		if ($param)
			$like = ['email' => $param, 'nama_perusahaan' => $param, 'pic' => $param];

		$data = $this->M_master->get_like('rekanan', $like, $where)->result();
		foreach ($data as $key => $value) {
			$result['id'] = $value->id;
			$result['text'] = $value->nama_perusahaan . ' | ' . $value->pic . ' | ' . $value->email;
			$results[] = $result;
		}

		$output = [
			'results' => $results
		];

		echo json_encode($output);
	}
}
