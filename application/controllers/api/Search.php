<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Search extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Search_model', 'search');
        $this->load->helper('convert_data');
    }
    public function users_get()
    {
        $itemsRow = 8;
        $query = $this->get('q');
        $page = $this->get('page');
        $resultCount = $this->search->countUsers($query);
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
        } else if ($page === null || $page == "") {
            $users = $this->search->getUsers($query);
            $totalPages = null;
            $itemsRow = null;
        } else {
            $totalPages = ceil($resultCount / $itemsRow);
            $offset = ($page - 1) * $itemsRow;
            $users = $this->search->getUsers($query, $offset, $itemsRow);
        }

        if ($users) {
            $this->response([
                'total_count' => $resultCount,
                'page' => $page,
                'per_page' => $itemsRow,
                'total_pages' => $totalPages,
                'items' => $users,
            ], 200);
        } else {
            if ($page > $totalPages && $resultCount != 0) {
                $this->response([
                    'message' => 'page not found'
                ], 404);
            } else {
                $this->response([
                    'message' => 'user not found'
                ], 404);
            }
        }
    }
}
