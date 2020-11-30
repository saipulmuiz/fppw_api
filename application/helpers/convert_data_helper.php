<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('convert_gender')) {
    function convert_gender($gender)
    {
        $cvGender = "";
        if ($gender == 1) {
            $cvGender = "Laki-laki";
        } elseif ($gender == 2) {
            $cvGender = "Perempuan";
        } else {
            $cvGender = null;
        }
        return $cvGender;
    }
}

if (!function_exists('convert_role')) {
    function convert_role($role)
    {
        $cvRole = "";
        $CI = &get_instance();
        if ($role != null) {
           $cvRole = $CI->db->get_where('tbl_role', ['id' => $role])->row()->level;
        } else {
            $cvRole = null;
        }
        return $cvRole;
    }
}

if (!function_exists('convert_user')) {
    function convert_user($user)
    {
        $cvUser = "";
        $CI = &get_instance();
        if ($user != null) {
           $cvUser = $CI->db->get_where('tbl_user', ['id' => $user])->row();
        } else {
            $cvUser = null;
        }
        return $cvUser;
    }
}
