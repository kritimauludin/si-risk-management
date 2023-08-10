<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Klasifikasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function likelihood()
    {
		$data['title'] = 'Data Kemungkinan';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

        $data['likelihood'] = $this->db->get('daftar_kemungkinan')->result_array();

        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('frekuensi', 'Frekuensi', 'required');
        $this->form_validation->set_rules('kemungkinan_terjadi', 'Kemungkinan_terjadi', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('klasifikasi/likelihood', $data);
            $this->load->view('templates/footer');
        } else {
			$todayTime = date("Y-m-d H:i:s", time());
			$totalKemungkinan = count($data['likelihood']);

			$dataKemungkinan = [
				'peringkat' => $totalKemungkinan + 1,
				'deskripsi' => $this->input->post('deskripsi'),
				'keterangan' => $this->input->post('keterangan'),
				'frekuensi' => $this->input->post('frekuensi'),
				'kemungkinan_terjadi' => $this->input->post('kemungkinan_terjadi'),
				'created_at' => $todayTime
			];

            $this->db->insert('daftar_kemungkinan', $dataKemungkinan);
            $this->session->set_flashdata('message', 'Kemungkinan berhasil ditambahkan!');
            redirect('klasifikasi/likelihood');
        }
	}

    public function updateLikelihood()
    {
		$data['title'] = 'Update Data Kemungkinan';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

        $data['likelihood'] = $this->db->get('daftar_kemungkinan')->result_array();

        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('frekuensi', 'Frekuensi', 'required');
        $this->form_validation->set_rules('kemungkinan_terjadi', 'Kemungkinan_terjadi', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('klasifikasi/likelihood', $data);
            $this->load->view('templates/footer');
        } else {
			$todayTime = date("Y-m-d H:i:s", time());

			$peringkat = $this->input->post('peringkat');

			$dataKemungkinan = [
				'deskripsi' => $this->input->post('deskripsi'),
				'keterangan' => $this->input->post('keterangan'),
				'frekuensi' => $this->input->post('frekuensi'),
				'kemungkinan_terjadi' => $this->input->post('kemungkinan_terjadi'),
				'updated_at' => $todayTime
			];

            $this->db->where('peringkat', $peringkat);
            $this->db->update('daftar_kemungkinan', $dataKemungkinan);
            $this->session->set_flashdata('message', 'Data kemungkinan berhasil diubah!');
            redirect('klasifikasi/likelihood');
        }
	}
	
	public function deleteLikelihood($peringkat)
    {
        $this->db->where('peringkat', $peringkat);
        $this->db->delete('daftar_kemungkinan');
        $this->session->set_flashdata('message', 'Data kemungkinan berhasil dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function impact()
    {
		$data['title'] = 'Data Dampak';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

        $data['impact'] = $this->db->get('daftar_dampak')->result_array();

        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('klasifikasi/impact', $data);
            $this->load->view('templates/footer');
        } else {
			$todayTime = date("Y-m-d H:i:s", time());
			$totalDampak = count($data['impact']);

			$dataDampak = [
				'peringkat' => $totalDampak + 1,
				'deskripsi' => $this->input->post('deskripsi'),
				'created_at' => $todayTime
			];

            $this->db->insert('daftar_dampak', $dataDampak);
            $this->session->set_flashdata('message', 'Dampak berhasil ditambahkan!');
            redirect('klasifikasi/impact');
        }
	}

    public function updateImpact()
    {
		$data['title'] = 'Update Data Dampak';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

        $data['impact'] = $this->db->get('daftar_dampak')->result_array();

        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('klasifikasi/impact', $data);
            $this->load->view('templates/footer');
        } else {
			$todayTime = date("Y-m-d H:i:s", time());

			$peringkat = $this->input->post('peringkat');

			$dataDampak = [
				'deskripsi' => $this->input->post('deskripsi'),
				'updated_at' => $todayTime
			];

            $this->db->where('peringkat', $peringkat);
            $this->db->update('daftar_dampak', $dataDampak);
            $this->session->set_flashdata('message', 'Data dampak berhasil diubah!');
            redirect('klasifikasi/Impact');
        }
	}
	
	public function deleteImpact($peringkat)
    {
        $this->db->where('peringkat', $peringkat);
        $this->db->delete('daftar_dampak');
        $this->session->set_flashdata('message', 'Data dampak berhasil dihapus!');
        redirect($_SERVER['HTTP_REFERER']);
    }
	
}
