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
            return $this->db->get()->result_array();
        }
    }
    
    public function countUsers($query = null) {
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
