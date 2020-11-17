<?php

class Search_model extends CI_Model
{
    public $tabelUser = 'tbl_user';

    public function getUsers($query = null)
    {
        if ($query === null) {
            return $this->db->get($this->tabelUser)->result_array();
        } else {
            $this->db->select('*');
            $this->db->from($this->tabelUser);
            $this->db->like('nama', $query);
            $users = $this->db->get()->result();
            // foreach ($users as $user) {
            //     $data = ([
            //         'id' => $user->id,
            //         'no_induk' => $user->no_induk,
            //         'nama' => $user->nama,
            //         'username' => $user->username,
            //         'email' => $user->email,
            //         'phone' => $user->phone,
            //         'gender' => $user->gender,
            //         'tempat_lahir' => $user->tempat_lahir,
            //         'tgl_lahir' => $user->tgl_lahir,
            //         'alamat' => $user->alamat,
            //         'user_created' => $user->user_created
            //     ]);
            // }
            return $users;
        }
    }

    public function countUsers($query = null)
    {
        if ($query === null) {
            return $this->db->count_all($this->tabelUser);
        } else {
            $this->db->select('*');
            $this->db->from($this->tabelUser);
            $this->db->like('nama', $query);
            return $this->db->count_all_results();
        }
    }
}
