<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Users extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $user = $this->user->getUser();
        } else {
            $user = $this->user->getUser($id);
        }

        if ($user) {
            $this->response([
                'status' => true,
                'result' => $user
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], 404);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provides an id!'
            ], 400);
        } else {
            if ($this->user->deleteUser($id) > 0) {
                // OK
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted'
                ], 200);
            } else {
                // id not found
                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ], 400);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nama' => $this->post('nama', TRUE),
            'username' => $this->post('username', TRUE),
            'email' => $this->post('email', TRUE),
            'phone' => $this->post('phone', TRUE),
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

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'nama' => $this->put('nama'),
            'username' => $this->put('username'),
            'email' => $this->put('email'),
            'phone' => $this->put('phone')
        ];

        if ($this->user->updateUser($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data user has been updated'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to update new data!'
            ], 400);
        }
    }
}
