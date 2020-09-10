<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agenda_surat_keluar extends CI_Controller
{
    function __construct()
    { 
        parent::__construct();
        is_login();
        $this->load->model('Agenda_surat_keluar_model');
        $this->load->model('Klasifikasi_arsip_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','agenda_surat_keluar/agenda_surat_keluar_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Agenda_surat_keluar_model->json();
    }

    public function read($id) 
    {
        $row = $this->Agenda_surat_keluar_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'tgl_surat' => $row->tgl_surat,
		'no_surat' => $row->no_surat,
		'tujuan' => $row->tujuan,
		'perihal' => $row->perihal,
		'hub_surat_lain' => $row->hub_surat_lain,
		'kode_arsip' => $row->kode_arsip,
	    );
            $this->template->load('template','agenda_surat_keluar/agenda_surat_keluar_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('agenda_surat_keluar'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'TAMBAH',
            'action' => site_url('agenda_surat_keluar/create_action'),
	    'id' => set_value('id'),
	    'tgl_surat' => set_value('tgl_surat'),
	    'no_surat' => set_value('no_surat'),
	    'tujuan' => set_value('tujuan'),
	    'perihal' => set_value('perihal'),
	    'hub_surat_lain' => set_value('hub_surat_lain'),
	    'kode_arsip' => set_value('kode_arsip'),
        'klasifikasi_arsip' => $this->Klasifikasi_arsip_model->get_kode_surat(),
	);
        $this->template->load('template','agenda_surat_keluar/agenda_surat_keluar_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'tgl_surat' => $this->input->post('tgl_surat',TRUE),
		'no_surat' => $this->input->post('no_surat',TRUE),
		'tujuan' => $this->input->post('tujuan',TRUE),
		'perihal' => $this->input->post('perihal',TRUE),
		'hub_surat_lain' => $this->input->post('hub_surat_lain',TRUE),
		'kode_arsip' => $this->input->post('kode_arsip',TRUE),
	    );

            $this->Agenda_surat_keluar_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('agenda_surat_keluar'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Agenda_surat_keluar_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'UPDATE',
                'action' => site_url('agenda_surat_keluar/update_action'),
		'id' => set_value('id', $row->id),
		'tgl_surat' => set_value('tgl_surat', $row->tgl_surat),
		'no_surat' => set_value('no_surat', $row->no_surat),
		'tujuan' => set_value('tujuan', $row->tujuan),
		'perihal' => set_value('perihal', $row->perihal),
		'hub_surat_lain' => set_value('hub_surat_lain', $row->hub_surat_lain),
		'kode_arsip' => set_value('kode_arsip', $row->kode_arsip),
        'klasifikasi_arsip' => $this->Klasifikasi_arsip_model->get_kode_surat(),
	    );
            $this->template->load('template','agenda_surat_keluar/agenda_surat_keluar_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('agenda_surat_keluar'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'tgl_surat' => $this->input->post('tgl_surat',TRUE),
		'no_surat' => $this->input->post('no_surat',TRUE),
		'tujuan' => $this->input->post('tujuan',TRUE),
		'perihal' => $this->input->post('perihal',TRUE),
		'hub_surat_lain' => $this->input->post('hub_surat_lain',TRUE),
		'kode_arsip' => $this->input->post('kode_arsip',TRUE),
	    );

            $this->Agenda_surat_keluar_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('agenda_surat_keluar'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Agenda_surat_keluar_model->get_by_id($id);

        if ($row) {
            $this->Agenda_surat_keluar_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('agenda_surat_keluar'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('agenda_surat_keluar'));
        }
    }

    function kode_arsipautocomplate(){
        autocomplate_json('klasifikasi_arsip', 'kode_surat');
    }
    
    public function _rules() 
    {
	$this->form_validation->set_rules('tgl_surat', 'tgl surat', 'trim|required');
	$this->form_validation->set_rules('no_surat', 'no surat', 'trim|required');
	$this->form_validation->set_rules('tujuan', 'tujuan', 'trim|required');
	$this->form_validation->set_rules('perihal', 'perihal', 'trim|required');
	$this->form_validation->set_rules('hub_surat_lain', 'hub surat lain', 'trim|required');
	$this->form_validation->set_rules('kode_arsip', 'kode arsip', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "agenda_surat_keluar.xls";
        $judul = "agenda_surat_keluar";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Surat");
	xlsWriteLabel($tablehead, $kolomhead++, "No Surat");
	xlsWriteLabel($tablehead, $kolomhead++, "Tujuan");
	xlsWriteLabel($tablehead, $kolomhead++, "Perihal");
	xlsWriteLabel($tablehead, $kolomhead++, "Hub Surat Lain");
	xlsWriteLabel($tablehead, $kolomhead++, "Kode Arsip");

	foreach ($this->Agenda_surat_keluar_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_surat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->no_surat);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tujuan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->perihal);
	    xlsWriteLabel($tablebody, $kolombody++, $data->hub_surat_lain);
	    xlsWriteLabel($tablebody, $kolombody++, $data->kode_arsip);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=agenda_surat_keluar.doc");

        $data = array(
            'agenda_surat_keluar_data' => $this->Agenda_surat_keluar_model->get_all(),
            'start' => 0,
            'logo_instansi' => base_url('assets/foto_profil/').$this->session->userdata('logo_instansi'),
            'nama_instansi' => $this->session->userdata('nama_instansi'),
            'alamat_instansi' => $this->session->userdata('alamat_instansi'),
            'email_instansi' => $this->session->userdata('email_instansi'),
            'notelp_instansi' => $this->session->userdata('notelp_instansi'),
            'website_instansi' => $this->session->userdata('website_instansi'),
        );
        
        $this->load->view('agenda_surat_keluar/agenda_surat_keluar_doc',$data);
    }
    function pdf() {
        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', 'A4');
        // membuat halaman baru
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 13);
        $pdf->Cell(22,20,$pdf->Image(base_url('assets/foto_profil/').$this->session->userdata('logo_instansi'),10,10,20,20),0,0,'C');        
        $pdf->Cell(240,5,$this->session->userdata('nama_instansi'),0,1);
        $pdf->SetFont('Times', '', 12);   
        $pdf->Cell(22,5,'',0,0);  
        $pdf->Cell(240,5,$this->session->userdata('alamat_instansi'),0,1);
        $pdf->SetFont('Times', '', 12);   
        $pdf->Cell(22,5,'',0,0);  
        $pdf->Cell(240,5,'Telp/Fax: '.$this->session->userdata('notelp_instansi'),0,1);
        $pdf->SetFont('Times', '', 11);   
        $pdf->Cell(22,5,'',0,0);  
        $pdf->Cell(240,5,'Email: '.$this->session->userdata('email_instansi').' Website: '.$this->session->userdata('website_instansi'),0,1);
        $pdf->Cell(22,3,'','B',0);  
        $pdf->Cell(240,3,'','B',1);


        $pdf->Cell(10,5,'',0,1);
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Times', 'B', 11);
        // mencetak string 
        $pdf->Cell(270,6,'....................................................',0,1,'C');
        $pdf->Cell(270,6,'BUKU AGENDA SURAT KELUAR',0,1,'C');
        $pdf->Cell(270,6,'Bulan ............................................',0,1,'C');
        $pdf->Cell(10,5,'',0,1);
        $pdf->Cell(10,6,'No',1,0,'C');
        $pdf->Cell(25,6,'Tgl. Surat',1,0,'C');
        $pdf->Cell(40,6,'Nomor Surat',1,0,'C');
        $pdf->Cell(50,6,'Dikirim Kepada',1,0,'C');
        $pdf->Cell(60,6,'Perihal',1,0,'C');
        $pdf->Cell(40,6,'Hub. Dengan Surat Lain',1,0,'C');
        $pdf->Cell(30,6,'Kode Arsip',1,1,'C');

       $pdf->SetFont('Times', '', 10);
        $agenda_surat_keluar = $this->db->get('agenda_surat_keluar')->result();
        $no = 1;
        foreach ($agenda_surat_keluar as $row){
            $pdf->Cell(10,6,$no++,1,0,'C'); 
            $pdf->Cell(25,6,shortdate_indo($row->tgl_surat),1,0,'L');
            $pdf->Cell(40,6,$row->no_surat,1,0,'L');
            $pdf->Cell(50,6,$row->tujuan,1,0,'L');
            $pdf->Cell(60,6,$row->perihal,1,0,'L');
            $pdf->Cell(40,6,$row->hub_surat_lain,1,0,'L');
            $pdf->Cell(30,6,$row->kode_arsip,1,1,'L');
        }
        $pdf->SetTitle('BUKU AGENDA SURAT KELUAR');
        $pdf->Output();
    }

}

/* End of file Agenda_surat_keluar.php */
/* Location: ./application/controllers/Agenda_surat_keluar.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-09-06 05:08:40 */
/* http://harviacode.com */