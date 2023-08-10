<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function index()
    {
        $data['title'] = 'Department';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/department', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->session->set_flashdata('message', 'department berhasil ditambahkan!');
            redirect('admin/index');
        }
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);


        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id!=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/roleAccess', $data);
        $this->load->view('templates/footer');
    }
	
    public function updateRole()
    {
        $this->form_validation->set_rules('updaterole', 'updaterole', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('admin/index');
            $this->load->view('templates/footer');
        } else {
            $id = $this->input->post('id');
            $updaterole = $this->input->post('updaterole');

            $this->db->where('id', $id);
            $this->db->update('user_role', ['role' => $updaterole]);
            $this->session->set_flashdata('message', 'department berhasil diubah!');
            redirect('admin/index');
        }
    }
    public function deleteRole($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_role');
        $this->session->set_flashdata('message', 'department dihapus!');
        redirect('admin/index');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];
        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $this->session->set_flashdata('message', 'Access Changed!');
    }

	public function userManagement(){
		$data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);
		
        $this->load->model('User_model', 'user');

		$data['roles'] = $this->db->get('user_role')->result_array();
		$data['users'] = $this->user->getUser();

		$this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'email already to use!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]', [
            'min_length' => 'Password to short!'
        ]);
        if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/user-management', $data);
			$this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email', true);

            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
				'no_hp' => $this->input->post('no_hp'),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role_id')
            ];
            $this->db->insert('user', $data);
            $this->session->set_flashdata('success', 'Your account has been created');
            redirect('/admin/usermanagement');
		}
	}

	public function updateUser()
    {
        $data['title'] = 'Update User';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

        $this->form_validation->set_rules('update_name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('update_no_hp', 'No HP', 'required|min_length[10]');
        $this->form_validation->set_rules('updaterole_id', 'role_id', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
			$this->load->view('admin/user-management', $data);
            $this->load->view('templates/footer');
        } else {
            $id = $this->input->post('id');

			$password = $this->input->post('update_password');
			
            $data = [
                'name' => $this->input->post('update_name'),
                'email'  => $this->input->post('update_email'),
                'role_id'  => $this->input->post('updaterole_id'),
                'no_hp' => $this->input->post('update_no_hp'),				
            ];
			if($password != ''){
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
				$data['password'] = $password_hash;
			}

            $this->db->where('id', $id);
            $this->db->update('user', $data);
            $this->session->set_flashdata('message', 'Data user berhasil diupdate!');
            redirect('admin/usermanagement');
        }
    }

	public function deleteUser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');

		
        $this->session->set_flashdata('message', 'Data user telah dihapus!');
        redirect('admin/usermanagement');
    }
}
