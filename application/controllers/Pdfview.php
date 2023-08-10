<?php
defined('BASEPATH') or exit('No direct script allowed access');

require 'vendor/autoload.php';

class Pdfview extends CI_Controller
{
    public function consultation($kode)
    {
        $pdf = new Mpdf\Mpdf();

        $data['title'] = 'Rekap Hasil Konsultasi';

        //query builder group
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        //query builder for 'data user'
        $this->db->select('*');
        $this->db->from('user');
        $this->db->join('hasil_diagnosa', 'hasil_diagnosa.user_id = user.id');
        $this->db->join('daftar_penyakit', 'hasil_diagnosa.kode_penyakit = daftar_penyakit.kode_penyakit');
        $data['dataPemilik'] = $this->db->where('hasil_diagnosa.kode_konsultasi =', $kode)->get()->result_array();

        //query builder for 'gejala diinput'
        $this->db->select('*');
        $this->db->from('hasil_diagnosa');
        $this->db->join('temp_diagnosa', 'temp_diagnosa.kode_konsultasi = hasil_diagnosa.kode_konsultasi');
        $this->db->join('daftar_gejala', 'temp_diagnosa.kode_gejala = daftar_gejala.kode_gejala');
        $this->db->where('hasil_diagnosa.user_id', $data['user']['id']);
        $data['gejalaDipilih'] =  $this->db->where('hasil_diagnosa.kode_konsultasi =', $kode)->get()->result_array();

        //for filename
        $file_pdf = 'rekap_hasil_konsultasi';
        $paper = 'A4';
        $orientation = 'potrait';

        $html = $this->load->view('diagnosis/report-diagnosis', $data, true);

        //dompdf run
        $pdf->WriteHTML($html);
        $pdf->Output();
        // $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function isu($kode)
    {
        $pdf = new Mpdf\Mpdf();
		$noIsu = base64_decode($kode);

        $data['title'] = $noIsu;

        //query builder group
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        //query builder for 'data isu'
        $this->db->select('*');
        $this->db->from('daftar_isu');
        $this->db->join('user_role', 'user_role.id = daftar_isu.dept_penerbit');
        $data['dataIsu'] = $this->db->where('daftar_isu.no_isu =', $noIsu)->get()->row();
		// print_r( $data['dataIsu']);


        //query builder for 'daftar tindakan'
        $this->db->select('*');
        $this->db->from('daftar_tindakan');
        $this->db->join('user_role', 'user_role.id = daftar_tindakan.dept_penerima');
        $data['daftarTindakan'] =  $this->db->where('daftar_tindakan.no_isu =', $noIsu)->get()->result_array();


        //for filename
        $file_pdf = 'Document ISU';
        $paper = 'A4';
        $orientation = 'potrait';

        $html = $this->load->view('isu/report-isu', $data, true);

        //dompdf run
        $pdf->WriteHTML($html);
        $pdf->Output();
        // $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function historyConsultation()
    {
        $pdf = new Mpdf\Mpdf();

        $data['title'] = 'Rekap History Konsultasi';

        //query builder group
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

         //query builder for 'data user'
		 $this->db->select(
			'user.name, user.no_hp, hasil_diagnosa.kode_konsultasi, hasil_diagnosa.created_at, hasil_diagnosa.tingkat_kepercayaan, 
			 daftar_penyakit.nama_penyakit, daftar_penyakit.solusi'
		);
        $this->db->from('hasil_diagnosa');
        $this->db->join('user', 'user.id = hasil_diagnosa.user_id');
        $this->db->join('daftar_penyakit', 'daftar_penyakit.kode_penyakit = hasil_diagnosa.kode_penyakit');
        $data['historys'] = $this->db->get()->result_array();

        //for filename
        $file_pdf = 'rekap_history_konsultasi';
        $paper = 'A4';
        $orientation = 'potrait';

        $html = $this->load->view('history/report-history-konsultasi', $data, true);

        //dompdf run
        $pdf->WriteHTML($html);
        $pdf->Output();
    }
}
