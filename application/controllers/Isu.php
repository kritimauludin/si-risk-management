<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Isu extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

	public function getNoIsu()
	{
		$todayTime = date("Y-m-d", time());

		$this->db->select('*');
		$this->db->from('daftar_isu');
		$this->db->where('DATE(created_at)', $todayTime); //use date function
		$data = $this->db->get()->result();

		$countIsu = count($data);
		$countIsu++;
		$char = "/RM/MCP/";
		$noIsu = $countIsu . $char . date('d/m/y');

		$this->db->where('no_isu', $noIsu);
		$testExist = count($this->db->get('daftar_isu')->result());
		if ($testExist > 0) {
			$noIsu = $countIsu + 1 . $char . date('d/m/y');
		}

		echo json_encode($noIsu);
	}

	public function index()
	{
		$data['title'] = 'Risk Management';
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();

		$todayTime = date("Y-m-d H:i:s", time());
		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

		$data['daftar_kemungkinan'] = $this->db->get('daftar_kemungkinan')->result_array();
		$data['daftar_dampak'] = $this->db->get('daftar_dampak')->result_array();

		$this->db->where('role !=', 'admin');
		$this->db->where('id !=', $roleId);
		$data['roles'] = $this->db->get('user_role')->result_array();

		//query builder for 'daftar isu'
		$this->db->select('daftar_isu.*, user_role.role');
		$this->db->from('daftar_isu');
		$this->db->join('user_role', 'user_role.id = daftar_isu.dept_penerbit');
		if ($roleId != 1) {
			$this->db->where('daftar_isu.dept_penerbit =', $roleId);
		}

		$data['daftar_isu'] =  $this->db->get()->result_array();


		//query builder untuk mendapatkan daftar tindakan tiap isu
		foreach ($data['daftar_isu'] as $isu) {
			$this->db->select('daftar_tindakan.id, daftar_tindakan.no_tindakan, dept_penerima, role');
			$this->db->where('no_isu', $isu['no_isu']);
			$this->db->join('user_role', 'user_role.id = daftar_tindakan.dept_penerima');
			$data['tindakan']['' . $isu['no_isu'] . ''] = $this->db->get('daftar_tindakan')->result_array();
		}

		$this->form_validation->set_rules('ket_dampak', 'ket_dampak', 'required');
		$this->form_validation->set_rules('uraian_isu', 'uraian_isu', 'required');
		$this->form_validation->set_rules('tgl_target', 'tgl_target', 'required');
		$this->form_validation->set_rules('url_lampiran_isu', 'url_lampiran_isu', 'file');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('isu/index', $data);
			$this->load->view('templates/footer');
		} else {
			$noIsu = $this->input->post('no_isu');

			$file_name = str_replace('.', '', $noIsu);
			$config['upload_path']          = FCPATH . 'uploads/lampiran-isu';
			$config['allowed_types']        = 'pdf|jpg|jpeg|png';
			$config['file_name']            = $file_name;
			$config['overwrite']            = true;
			$config['max_size']             = 5024; // 5MB

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('url_lampiran_isu')) {
				$uploaded_data = $this->upload->data();
				$dataIsu['url_lampiran_isu'] = $uploaded_data['file_name'];
			}

			$bobot = $this->input->post('kemungkinan') * $this->input->post('dampak');

			for ($i = 0; $i < count($this->input->post('role_id')); $i++) {
				$noTindakan = $noIsu . '-' . $i + 1;

				$daftarTindakan[$i] = [
					'no_tindakan' => $noTindakan,
					'no_isu' => $noIsu,
					'uraian_tindakan' => '',
					'dept_penerima' => $this->input->post('role_id[' . $i . ']'),
					'tgl_target' => $this->input->post('tgl_target'),
					'status'	=> '202',
					'created_at'  => $todayTime
				];
			}


			$dataIsu = [
				'no_isu' => $noIsu,
				'uraian_isu' => $this->input->post('uraian_isu'),
				'dept_penerbit' => $roleId,
				'sumber' => $this->input->post('sumber'),
				'tgl_target' => $this->input->post('tgl_target'),
				'dampak' => $this->input->post('ket_dampak'),
				'kemungkinan' => $this->input->post('kemungkinan'),
				'dampak' => $this->input->post('dampak'),
				'bobot' => $bobot,
				'terhadap' => $this->input->post('terhadap'),

				'created_at'  => $todayTime
			];

			// print_r($dataIsu);
			// print_r($tempTindakan);

			$this->db->insert('daftar_isu', $dataIsu);
			$this->db->insert_batch('daftar_tindakan', $daftarTindakan);
			$this->session->set_flashdata('message', 'Isu baru berhasil ditambahkan!');
			redirect('isu');
		}
	}

	public function updateIsu()
	{
		$data['title'] = 'Risk Management';
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();

		$todayTime = date("Y-m-d H:i:s", time());
		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

		$data['daftar_kemungkinan'] = $this->db->get('daftar_kemungkinan')->result_array();
		$data['daftar_dampak'] = $this->db->get('daftar_dampak')->result_array();

		$this->db->where('role !=', 'admin');
		$this->db->where('id !=', $roleId);
		$data['roles'] = $this->db->get('user_role')->result_array();

		//query builder for 'daftar isu'
		$this->db->select('*');
		$this->db->from('daftar_isu');
		$this->db->join('user_role', 'user_role.id = daftar_isu.dept_penerbit');
		if ($roleId != 1) {
			$this->db->where('daftar_isu.dept_penerbit =', $roleId);
		}

		$data['daftar_isu'] =  $this->db->get()->result_array();


		//query builder untuk mendapatkan daftar tindakan
		foreach ($data['daftar_isu'] as $isu) {
			$this->db->select('daftar_tindakan.id, dept_penerima, role');
			$this->db->where('no_isu', $isu['no_isu']);
			$this->db->join('user_role', 'user_role.id = daftar_tindakan.dept_penerima');
			$data['tindakan']['' . $isu['no_isu'] . ''] = $this->db->get('daftar_tindakan')->result_array();
		}

		$this->form_validation->set_rules('ket_dampak', 'ket_dampak', 'required');
		$this->form_validation->set_rules('uraian_isu', 'uraian_isu', 'required');
		$this->form_validation->set_rules('tgl_target', 'tgl_target', 'required');
		$this->form_validation->set_rules('url_lampiran_isu', 'url_lampiran_isu', 'file');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('isu/index', $data);
			$this->load->view('templates/footer');
		} else {
			$noIsu = $this->input->post('no_isu');

			$file_name = str_replace('.', '', $noIsu);
			$config['upload_path']          = FCPATH . 'uploads/lampiran-isu';
			$config['allowed_types']        = 'pdf|jpg|jpeg|png';
			$config['file_name']            = $file_name;
			$config['overwrite']            = true;
			$config['max_size']             = 5024; // 5MB

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('url_lampiran_isu')) {
				$uploaded_data = $this->upload->data();
				$dataIsu['url_lampiran_isu'] = $uploaded_data['file_name'];
			}
			$bobot = $this->input->post('kemungkinan') * $this->input->post('dampak');


			$dataIsu = [
				'uraian_isu' => $this->input->post('uraian_isu'),
				'dept_penerbit' => $roleId,
				'sumber' => $this->input->post('sumber'),
				'tgl_target' => $this->input->post('tgl_target'),
				'dampak' => $this->input->post('ket_dampak'),
				'kemungkinan' => $this->input->post('kemungkinan'),
				'dampak' => $this->input->post('dampak'),
				'bobot' => $bobot,
				'terhadap' => $this->input->post('terhadap'),
				'updated_at'  => $todayTime
			];

			$this->db->where('no_isu', $noIsu);
			$this->db->update('daftar_isu', $dataIsu);

			foreach ($data['tindakan'][$noIsu] as $data) {
				$noTindakan = $this->input->post('no_tindakan[' . $data['id'] . ']');
				$deptPenerima = $this->input->post('role_id[' . $data['id'] . ']');

				$daftarTindakan = [
					'dept_penerima' => $deptPenerima,
					'updated_at'  => $todayTime
				];

				$this->db->where('no_tindakan', $noTindakan);
				$this->db->update('daftar_tindakan', $daftarTindakan);
			}
			$this->session->set_flashdata('message', 'Isu dan divisi berhasil diubah!');
			redirect('isu');
		}
	}

	public function lihatIsu($kode)
	{
		$noIsu = base64_decode($kode);

		$data['title'] = $noIsu;
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);


		//query builder group
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();

		$data['daftar_kemungkinan'] = $this->db->get('daftar_kemungkinan')->result_array();
		$data['daftar_dampak'] = $this->db->get('daftar_dampak')->result_array();

		//query builder for 'data isu'
		$this->db->select('*');
		$this->db->from('daftar_isu');
		$this->db->join('user_role', 'user_role.id = daftar_isu.dept_penerbit');
		$data['dataIsu'] = $this->db->where('daftar_isu.no_isu =', $noIsu)->get()->row();


		//query builder for 'daftar tindakan'
		$this->db->select('*');
		$this->db->from('daftar_tindakan');
		$this->db->join('user_role', 'user_role.id = daftar_tindakan.dept_penerima');
		$data['daftarTindakan'] =  $this->db->where('daftar_tindakan.no_isu =', $noIsu)->get()->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('isu/lihat-isu', $data);
		$this->load->view('templates/footer');
	}

	public function tindakan()
	{
		$data['title'] = 'Daftar Tindakan';
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();

		$todayTime = date("Y-m-d H:i:s", time());
		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

		$data['daftar_kemungkinan'] = $this->db->get('daftar_kemungkinan')->result_array();
		$data['daftar_dampak'] = $this->db->get('daftar_dampak')->result_array();

		$this->db->where('role !=', 'admin');
		$this->db->where('id !=', $data['user']['role_id']);
		$data['roles'] = $this->db->get('user_role')->result_array();

		//query builder for 'daftar isu'
		$this->db->select('*');
		$this->db->from('daftar_tindakan');
		$this->db->join('daftar_isu', 'daftar_isu.no_isu = daftar_tindakan.no_isu');
		$this->db->join('user_role', 'daftar_isu.dept_penerbit = user_role.id');
		$this->db->where('daftar_tindakan.dept_penerima =', $roleId);
		$data['daftar_tindakan'] =  $this->db->get()->result_array();

		$this->form_validation->set_rules('uraian_tindakan', 'uraian_tindakan', 'required');
		$this->form_validation->set_rules('tgl_aktual', 'tgl_aktual', 'required');
		$this->form_validation->set_rules('url_lampiran_tindakan', 'url_lampiran_tindakan', 'file');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('tindakan/tindakan', $data);
			$this->load->view('templates/footer');
		} else {
			$noTindakan = $this->input->post('no_tindakan');

			$file_name = str_replace('.', '', $noTindakan);
			$config['upload_path']          = FCPATH . 'uploads/lampiran-tindakan';
			$config['allowed_types']        = 'pdf|jpg|jpeg|png';
			$config['file_name']            = $file_name;
			$config['overwrite']            = true;
			$config['max_size']             = 5024; // 5MB

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('url_lampiran_tindakan')) {
				$uploaded_data = $this->upload->data();
				$dataTindakan['url_lampiran_tindakan'] = $uploaded_data['file_name'];
			}
			$dataTindakan = [
				'uraian_tindakan' => $this->input->post('uraian_tindakan'),
				'dept_penerima' => $roleId,
				'tgl_aktual' => $this->input->post('tgl_aktual'),
				'status'	=> '200',
				'created_at'  => $todayTime
			];

			// print_r($dataTindakan);
			// print_r($tempTindakan);

			$this->db->where('no_tindakan', $noTindakan);
			$this->db->update('daftar_tindakan', $dataTindakan);
			$this->session->set_flashdata('message', 'Tindakan divisimu berhasil dicatat!');
			redirect('isu/tindakan');
		}
	}

	public function deleteData($kode)
	{
		$noIsu = base64_decode($kode);

		//delete isu dengan no isu tersebut
		$this->db->where('no_isu', $noIsu);
		$this->db->delete('daftar_isu');

		//delete semua tindakan dengan no isu tersebut
		$this->db->where('no_isu', $noIsu);
		$this->db->delete('daftar_tindakan');

		$this->session->set_flashdata('message', 'Data isu berhasil dihapus!');
		redirect('isu');
	}
}
