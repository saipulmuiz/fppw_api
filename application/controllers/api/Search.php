<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Search extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Search_model', 'search');
    }
    public function users_get()
    {
        $query = $this->get('q');
        if ($query === null) {
            $this->response([
                'message' => 'Validation Failed',
                'errors' => ([
                    'resource' => 'Search',
                    'field' => 'q',
                    'code' => 'missing'
                ]),
                'hint' => 'check the url'
            ], 422);
        } else {
            $users = $this->search->getUsers($query);
            $resultCount = $this->search->countUsers($query);
        }

        if ($users) {
            foreach ($users as $user) {
                // var_dump($user['id']);
                $data = ([
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
                ]);
            }
            $this->response([
                'total_count' => $resultCount,
                'items' => $data
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'user not found'
            ], 404);
        }
    }
}
