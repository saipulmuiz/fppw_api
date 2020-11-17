<?php

class User_model extends CI_Model
{
    public $_table = 'tbl_user';

    public function getUser($id = null)
    {
        if ($id !== null) {
            return $this->db->get_where($this->_table, ['id' => $id])->row();
        }
    }

    public function deleteUser($id)
    {
        $this->db->delete($this->_table, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function createUser($data)
    {
        // $this->db->insert($this->_table, $data);
        // return $this->db->affected_rows();
        return 1;
    }

    public function forgottPassword($email, $token)
    {
        // $this->db->set('forgotten_password_code', $token);
        // $this->db->where('email', $email);
        // $this->db->update('tbl_user');
        return 1;
    }

    public function updateUser($data, $id)
    {
        $this->db->update($this->_table, $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
