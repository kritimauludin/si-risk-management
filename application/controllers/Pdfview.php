<?php
defined('BASEPATH') or exit('No direct script allowed access');

require 'vendor/autoload.php';

class Pdfview extends CI_Controller
{
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
        $fileName = 'Document ISU '. $noIsu;
        $paper = 'A4';
        $orientation = 'potrait';

        $html = $this->load->view('isu/report-isu', $data, true);

        //dompdf run
        $pdf->WriteHTML($html);
        $pdf->Output($fileName, 'I');
        // $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }

    public function reportIsu()
    {
        $pdf = new Mpdf\Mpdf();

        $data['title'] = 'Rekap History ISU';

        //query builder group
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

        //query builder for 'daftar isu'
		$this->db->select('daftar_isu.*, user_role.role');
		$this->db->from('daftar_isu');
		$this->db->join('user_role', 'user_role.id = daftar_isu.dept_penerbit');
		if ($roleId != 1) {
			$this->db->where('daftar_isu.dept_penerbit =', $roleId);
		}

		$data['daftar_isu'] =  $this->db->get()->result_array();

        //for filename
        $fileName = 'Report '. date('Y-m-d');
        $paper = 'A4';
        $orientation = 'potrait';

        $html = $this->load->view('isu/all-report-isu', $data, true);

        //dompdf run
        $pdf->WriteHTML($html);
        $pdf->Output();
    }
}
