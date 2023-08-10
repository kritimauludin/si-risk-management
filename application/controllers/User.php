<?php

use FontLib\Table\Type\post;

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }
    public function editProfile()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);
        $this->form_validation->set_rules('update_name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('update_no_hp', 'No HP', 'required|min_length[10]');
        $this->form_validation->set_rules('update_alamat', 'Alamat', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/index', $data);
            $this->load->view('templates/footer');
        } else {
            $id = $this->input->post('id');
			$password = $this->input->post('update_password');

            $data = [
                'name' => $this->input->post('update_name'),
                'email'  => $this->input->post('update_email'),
                'no_hp' => $this->input->post('update_no_hp'),
                'alamat' => $this->input->post('update_alamat')
            ];

			if($password != ''){
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
				$data['password'] = $password_hash;
			}

            $this->db->where('id', $id);
            $this->db->update('user', $data);
            $this->session->set_flashdata('message', 'Data user berhasil diupdate!');
            redirect('user');
        }
    }
}
