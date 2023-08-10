<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}
function check_access($role_id, $menu_id)
{
    $ci = get_instance();
    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function notification_issue($role_id){

    $ci = get_instance();
	$ci->db->select('uraian_isu, daftar_isu.created_at')->from('daftar_tindakan');
	$ci->db->join('user_role', 'user_role.id = daftar_tindakan.dept_penerima');
	$ci->db->join('daftar_isu', 'daftar_isu.no_isu = daftar_tindakan.no_isu');
    $ci->db->where('dept_penerima', $role_id);
    $ci->db->where('status !=', 200);
    $results = $ci->db->get()->result_array();

	return $results;
}

function auto_logout(){
	$ci = get_instance();
	$ci->session->unset_userdata('email');
	$ci->session->unset_userdata('role_id');
}
