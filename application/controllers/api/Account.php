<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Account extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
    }

    public function register_post()
    {
        $data = [
            'nama' => $this->post('nama', TRUE),
            'username' => $this->post('username', TRUE),
            'email' => $this->post('email', TRUE),
            'password' => md5($this->post('password', TRUE)),
        ];

        if ($this->user->createUser($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new user has been created'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!'
            ], 400);
        }
    }

    public function login_post()
    {
        $data = [
            'username' => trim($this->input->post('username', TRUE)),
            'password' => md5(trim($this->input->post('password', TRUE)))
        ];

        $check = $this->db->get_where('tbl_user', array('username' => $this->post('username', TRUE)));
        $row = $this->db->get_where('tbl_user', $data)->row();
        $count = empty($row) ? 0 : 1;

        if ($check->num_rows() >= 1) {
            if ($count >= 1) {
                $result = [
                    'logged_in' => true,
                    'id' => $row->id,
                    'username' => $row->username,
                    'nama' => $row->nama,
                ];

                $this->response([
                    'status' => true,
                    'message' => 'login successfull',
                    'result' => $result
                ], 200);
            } else {
                $this->response([
                    'status' => true,
                    'message' => 'login failed, check your password again!'
                ], 401);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'username not found!'
            ], 401);
        }
    }
}
