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
            $this->response([
                'message' => 'Not Found',
                'hint' => 'try users/{username}'
            ], 404);
        } else {
            $user = $this->user->getUser($id);
        }

        if ($user) {
            $this->response([
                'id' => $user->id,
                'no_induk' => $user->no_induk,
                'nama' => $user->nama,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'gender' => $user->gender,
                'tempat_lahir' => $user->tempat_lahir,
                'tgl_lahir' => $user->tgl_lahir,
                'alamat' => $user->alamat,
                'user_created' => $user->user_created
            ], 200);
        } else {
            $this->response([
                'message' => 'id not found'
            ], 404);
        }
    }

    // public function index_delete()
    // {
    //     $id = $this->delete('id');

    //     if ($id === null) {
    //         $this->response([
    //             'status' => false,
    //             'message' => 'provides an id!'
    //         ], 400);
    //     } else {
    //         if ($this->user->deleteUser($id) > 0) {
    //             // OK
    //             $this->response([
    //                 'status' => true,
    //                 'id' => $id,
    //                 'message' => 'deleted'
    //             ], 200);
    //         } else {
    //             // id not found
    //             $this->response([
    //                 'status' => false,
    //                 'message' => 'id not found!'
    //             ], 400);
    //         }
    //     }
    // }

    // public function index_put()
    // {
    //     $id = $this->put('id');
    //     $data = [
    //         'no_induk' => $this->put('o_induk'),
    //         'nama' => $this->put('nama'),
    //         // 'username' => $this->put('username'),
    //         'email' => $this->put('email'),
    //         'tempat_lahir' => $this->put('tempat_lahir'),
    //         'tgl_lahir' => $this->put('tgl_lahir'),
    //         'alamat' => $this->put('alamat'),
    //         'role' => $this->put('role')
    //     ];

    //     if ($this->user->updateUser($data, $id) > 0) {
    //         $this->response([
    //             'status' => true,
    //             'message' => 'data user has been updated'
    //         ], 200);
    //     } else {
    //         $this->response([
    //             'status' => false,
    //             'message' => 'failed to update new data!'
    //         ], 400);
    //     }
    // }
}
