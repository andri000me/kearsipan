<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Agenda_surat_masuk_model');
        $this->load->model('Agenda_surat_keluar_model');
        $this->load->model('Daftar_arsip_model');
        $this->load->model('Index_arsip_model');
    }

    public function index() {
        //$this->load->view('table');
        $data = array(
            'total_suratmasuk' => $this->Agenda_surat_masuk_model->total_rows(),
            'total_suratkeluar' => $this->Agenda_surat_keluar_model->total_rows(),
            'total_daftararsip' => $this->Daftar_arsip_model->total_rows(),
            'total_indexarsip' => $this->Index_arsip_model->total_rows(),
        );
        $this->template->load('template', 'welcome',$data);
    }

    public function form() {
        //$this->load->view('table');
        $this->template->load('template', 'form');
    }
    
    function autocomplate(){
        autocomplate_json('tbl_user', 'full_name');
    }

    function __autocomplate() {
        $this->db->like('nama_lengkap', $_GET['term']);
        $this->db->select('nama_lengkap');
        $products = $this->db->get('pegawai')->result();
        foreach ($products as $product) {
            $return_arr[] = $product->nama_lengkap;
        }

        echo json_encode($return_arr);
    }

    function pdf() {
        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', 'A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string 
        $pdf->Cell(190, 7, 'SEKOLAH MENENGAH KEJURUSAN NEEGRI 2 LANGSA', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 7, 'DAFTAR SISWA KELAS IX JURUSAN REKAYASA PERANGKAT LUNAK', 0, 1, 'C');
        $pdf->Output();
    }

}
