<?php

class Search_model extends CI_Model
{
    public $tabelUser = 'tbl_user';

    public function getUsers($query = null, $offset = null, $itemsRow = null)
    {
        if ($query === null) {
            return $this->db->get($this->tabelUser)->result_array();
        } else {
            $this->db->select('*');
            $this->db->from($this->tabelUser);
            $this->db->like('nama', $query);
            $this->db->limit($itemsRow, $offset);
            $users = $this->db->get()->result();
            $i = 0;
            if ($users) {
                foreach ($users as $user) {
                    $data[$i] = ([
                        'id' => $user->id,
                        'no_induk' => $user->no_induk,
                        'nama' => $user->nama,
                        'username' => $user->username,
                        'role' => convert_role($user->role),
                        'photo' => $user->photo,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'gender' => convert_gender($user->gender),
                        'tempat_lahir' => $user->tempat_lahir,
                        'tgl_lahir' => $user->tgl_lahir,
                        'alamat' => $user->alamat,
                        'user_created' => $user->user_created
                    ]);
                    $i++;
                }
            } else {
                $data = null;
            }
            return $data;
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
