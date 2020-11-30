<?php

class Event_model extends CI_Model
{
    public $_table = 'tbl_event';

    public function getEventById($event_id = null)
    {
        if ($event_id !== null) {
            return $this->db->get_where($this->_table, ['event_id' => $event_id])->row();
        }
    }

    public function countEvent()
    {
        $this->db->select('*');
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    public function getEvent()
    {
        return $this->db->get_where($this->_table, ['active_event' => 1])->result_array();
    }

    public function getEventUpcoming()
    {
    }
}
