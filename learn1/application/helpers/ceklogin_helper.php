<?php

function is_loggedin($allowed_roles = [])
{
    $ci = get_instance();

    // Cek apakah user sudah login
    if (!$ci->session->userdata('email')) {
        redirect('auth');
        exit; // penting biar eksekusi berhenti
    }

    // Cek role jika ada pembatasan
    if (!empty($allowed_roles)) {
        $role_id = $ci->session->userdata('role_id');

        $ci->load->library('user_agent');

        if (!in_array($role_id, $allowed_roles)) {
            if ($ci->agent->referrer()) {
                redirect($ci->agent->referrer());
            } else {
                redirect('auth/blocked');
            }
            exit;
        }
    }
}
