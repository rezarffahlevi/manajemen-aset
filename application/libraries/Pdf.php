<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf
{
    protected $logo;

    public function __construct()
    {
        $this->logo = base_url('assets/img/logo_icon.png');
    }

    public function create_letter($data = [], $filename = 'letter.pdf')
    {
        $path   = FCPATH . "uploads";
        $CI     = &get_instance();
        $CI->load->helper('date');

        $images     = ['logo' => $this->logo];
        $terbilang  = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima'];
        $data->terbilang    = $terbilang[$data->jumlah_penumpang];
        $data       = array_merge($images, ['data' => $data]);
        $data['tanggal']    = tgl_indo(date('Y-m-d'));
        // echo '<pre>';print_r($data);exit;

        // $CI->load->view('letter', $data);

        $html       = $CI->load->view('letter', $data, true);

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A5', 'portrait');

        $options = new \Dompdf\Options();
        // set options indvidiually
        $options->set('defaultMediaType', 'all');
        $options->set('isFontSubsettingEnabled', true);
        $dompdf->render();

        $dompdf->stream($filename, array("Attachment" => 0));
    }

    public function create_report($data = [], $filename = 'letter.pdf')
    {
        $path   = FCPATH . "uploads";
        $CI     = &get_instance();
        $CI->load->helper('date');

        $images     = ['logo' => $this->logo];
        $terbilang  = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima'];
        // $data->terbilang    = $terbilang[$data->jumlah_penumpang];
        $data       = array_merge($images, ['data' => $data]);
        $data['tanggal']    = tgl_indo(date('Y-m-d'));
        // echo '<pre>';print_r($data);exit;

        // $CI->load->view('letter', $data);

        $html       = $CI->load->view('print_report', $data, true);

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream($filename, array("Attachment" => 0));
    }
}
