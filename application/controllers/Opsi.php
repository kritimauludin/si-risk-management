<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Opsi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

	public function meeting()
	{
		$data['title'] = 'Jadwalkan Meeting';
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

		$data['meeting_room'] = $this->db->get('meeting_room')->result_array();

		//query builder for 'daftar isu'
		$this->db->select('meeting.*, user_role.role, meeting_room.room');
		$this->db->from('meeting');
		$this->db->join('user_role', 'user_role.id = meeting.initiate_id');
		$this->db->join('meeting_room', 'meeting_room.id = meeting.room_id');
		if ($roleId != 1) {
			$this->db->where('meeting.initiate_id =', $roleId);
		}

		$data['meeting'] =  $this->db->get()->result_array();


		//query builder untuk mendapatkan daftar tindakan tiap isu
		foreach ($data['meeting'] as $meet) {
			$this->db->select('meeting_participant.*, role');
			$this->db->where('meeting_id', $meet['id']);
			$this->db->join('user_role', 'user_role.id = meeting_participant.participant_id');
			$data['participant']['' . $meet['id'] . ''] = $this->db->get('meeting_participant')->result_array();
		}

		// print_r($data['meeting']);

		$this->form_validation->set_rules('agenda', 'agenda', 'required');
		$this->form_validation->set_rules('room_id', 'room_id', 'required');
		$this->form_validation->set_rules('meeting_date', 'meeting_date', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('opsi/meeting-schedule', $data);
			$this->load->view('templates/footer');
		} else {
			$meetingId = md5(microtime());
			// print_r($meetingId);

			
			for ($i = 0; $i < count($this->input->post('participant_id')); $i++) {

				$daftarParticipant[$i] = [
					'meeting_id' => $meetingId,
					'participant_id' => $this->input->post('participant_id[' . $i . ']'),
					'created_at'  => $todayTime
				];
			}

			$dataMeeting= [
				'id' => $meetingId,
				'agenda' => $this->input->post('agenda'),
				'initiate_id' => $roleId,
				'room_id' => $this->input->post('room_id'),
				'meeting_date' => $this->input->post('meeting_date'),
				'created_at'  => $todayTime
			];

			$this->db->insert('meeting', $dataMeeting);
			$this->db->insert_batch('meeting_participant', $daftarParticipant);
			$this->session->set_flashdata('message', 'Jadwal meeting berhasil dibuat!');
			redirect('opsi/meeting');
		}
	}

	// meeting status code 
	// 200 : approved
	// 201 : rejected
	// 202 : waiting
	public function approveMeeting($id)
	{
		//delete isu dengan no isu tersebut
		$this->db->where('id', $id);
		$this->db->update('meeting', ['status' => 200]);

		$this->session->set_flashdata('message', 'Meeting berhasil disetujui!');
		redirect('opsi/meeting');
	}
	public function rejectMeeting($id)
	{
		//delete isu dengan no isu tersebut
		$this->db->where('id', $id);
		$this->db->update('meeting', ['status' => 201]);

		$this->session->set_flashdata('message', 'Meeting ditolak!');
		redirect('opsi/meeting');
	}

	public function updateMeeting()
	{
		$data['title'] = 'Jadwalkan Meeting';
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

		$data['meeting_room'] = $this->db->get('meeting_room')->result_array();

		//query builder for 'daftar isu'
		$this->db->select('meeting.*, user_role.role, meeting_room.room');
		$this->db->from('meeting');
		$this->db->join('user_role', 'user_role.id = meeting.initiate_id');
		$this->db->join('meeting_room', 'meeting_room.id = meeting.room_id');
		if ($roleId != 1) {
			$this->db->where('meeting.initiate_id =', $roleId);
		}

		$data['meeting'] =  $this->db->get()->result_array();


		//query builder untuk mendapatkan daftar tindakan tiap isu
		foreach ($data['meeting'] as $meet) {
			$this->db->select('meeting_participant.*, role');
			$this->db->where('meeting_id', $meet['id']);
			$this->db->join('user_role', 'user_role.id = meeting_participant.participant_id');
			$data['participant']['' . $meet['id'] . ''] = $this->db->get('meeting_participant')->result_array();
		}

		$this->form_validation->set_rules('agenda', 'agenda', 'required');
		$this->form_validation->set_rules('room_id', 'room_id', 'required');
		$this->form_validation->set_rules('meeting_date', 'meeting_date', 'required');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('opsi/meeting-schedule', $data);
			$this->load->view('templates/footer');
		} else {
			$meetingId = $this->input->post('meeting_id');
			for ($i = 0; $i < count($this->input->post('participant_id')); $i++) {

				$daftarParticipant[$i] = [
					'meeting_id' => $meetingId,
					'participant_id' => $this->input->post('participant_id[' . $i . ']'),
					'created_at'  => $todayTime
				];
			}

			$dataMeeting= [
				'id' => $meetingId,
				'agenda' => $this->input->post('agenda'),
				'room_id' => $this->input->post('room_id'),
				'meeting_date' => $this->input->post('meeting_date'),
				'updated_at'  => $todayTime
			];

			$this->db->where('id', $meetingId);
			$this->db->update('meeting', $dataMeeting);

			foreach ($data['participant'][$meetingId] as $data) {
				$id = $this->input->post('id[' . $data['id'] . ']');
				$participantId = $this->input->post('participant_id[' . $data['id'] . ']');

				$daftarParticipant = [
					'participant_id' => $participantId,
					'updated_at'  => $todayTime
				];

				$this->db->where('id', $id);
				$this->db->update('meeting_participant', $daftarParticipant);
			}
			$this->session->set_flashdata('message', 'Jadwal meeting berhasil diubah!');

			redirect('opsi/meeting');
		}
	}

	public function invitation()
	{
		$data['title'] = 'Undangan Meeting';
		$data['user'] = $this->db->get_where('user', ['email' =>
		$this->session->userdata('email')])->row_array();

		$todayTime = date("Y-m-d H:i:s", time());
		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

		$this->db->where('role !=', 'admin');
		$this->db->where('id !=', $data['user']['role_id']);
		$data['roles'] = $this->db->get('user_role')->result_array();

		//query builder for 'daftar isu'
		$this->db->select('meeting_participant.*, role, meeting.*, room');
		$this->db->join('meeting', 'meeting.id = meeting_participant.meeting_id');
		$this->db->join('user_role', 'user_role.id = meeting.initiate_id');
		$this->db->join('meeting_room', 'meeting_room.id = meeting.room_id');
		$this->db->where('participant_id', $roleId);
		$this->db->where('status', 200);
		$data['allInvitation'] = $this->db->get('meeting_participant')->result_array();

		foreach ($data['allInvitation'] as $meet) {
			$this->db->select('meeting_participant.*, role');
			$this->db->where('meeting_id', $meet['id']);
			$this->db->join('user_role', 'user_role.id = meeting_participant.participant_id');
			$data['participant']['' . $meet['id'] . ''] = $this->db->get('meeting_participant')->result_array();
		}

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('opsi/meeting-invitation', $data);
			$this->load->view('templates/footer');
	}

	public function meetingRoom()
    {
		$data['title'] = 'Daftar Ruangan';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

        $data['meetingRoom'] = $this->db->get('meeting_room')->result_array();

        $this->form_validation->set_rules('room', 'room', 'required');
        $this->form_validation->set_rules('operational_hours', 'operational_hours', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('opsi/meeting-room', $data);
            $this->load->view('templates/footer');
        } else {
			$todayTime = date("Y-m-d H:i:s", time());

			$dataMeetingRoom = [
				'room' => $this->input->post('room'),
				'operational_hours' => $this->input->post('operational_hours'),
				'created_at' => $todayTime
			];

            $this->db->insert('meeting_room', $dataMeetingRoom);
            $this->session->set_flashdata('message', 'Ruang meeting berhasil ditambahkan!');
            redirect('opsi/meetingroom');
        }
	}

	public function updateMeetingRoom()
    {
		$data['title'] = 'Daftar Ruangan';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

		$roleId = $data['user']['role_id'];

		$data['notifications'] =  notification_issue($roleId);

        $data['meetingRoom'] = $this->db->get('meeting_room')->result_array();

        $this->form_validation->set_rules('room', 'room', 'required');
        $this->form_validation->set_rules('operational_hours', 'operational_hours', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('opsi/meeting-room', $data);
            $this->load->view('templates/footer');
        } else {
			$todayTime = date("Y-m-d H:i:s", time());
			$id = $this->input->post('id');

			$dataMeetingRoom = [
				'room' => $this->input->post('room'),
				'operational_hours' => $this->input->post('operational_hours'),
				'updated_at' => $todayTime
			];

			$this->db->where('id', $id);
            $this->db->update('meeting_room', $dataMeetingRoom);
            $this->session->set_flashdata('message', 'Ruang meeting berhasil diubah!');
            redirect('opsi/meetingroom');
        }
	}

	public function deleteRoom($id)
	{

		//delete isu dengan no isu tersebut
		$this->db->where('id', $id);
		$this->db->delete('meeting_room');

		$this->session->set_flashdata('message', 'Data ruangan berhasil dihapus!');
		redirect('opsi/meetingroom');
	}

	public function deleteMeeting($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('meeting');

		$this->db->where('meeting_id', $id);
		$this->db->delete('meeting_participant');

		$this->session->set_flashdata('message', 'Data meeting berhasil dihapus!');
		redirect('opsi/meeting');
	}
}
