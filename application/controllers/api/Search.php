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
            $users = $this->search->getUsers();
            $resultCount = $this->search->countUsers();
        } else {
            $users = $this->search->getUsers($query);
            $resultCount = $this->search->countUsers($query);
        }

        if ($users) {
            $this->response([
                'status' => true,
                'result_count' => $resultCount,
                'result' => $users
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'user not found'
            ], 404);
        }
    }
}