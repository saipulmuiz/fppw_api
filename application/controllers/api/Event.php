<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Event extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('tgl_indo');
        $this->load->helper('convert_data');
        $this->load->model('Event_model', 'event');
    }

    public function index_get()
    {
        $event_id = $this->get('eventid');
        if ($event_id === null) {
            $event = $this->event->getEvent();
            $resultCount = $this->event->countEvent();
            $this->response([
                'total_count' => $resultCount,
                'items' => $event
            ], 200);
        } else {
            $event = $this->event->getEventById($event_id);
        }

        $mulai = split_datetime($event->tgl_mulai);
        $selesai = split_datetime($event->tgl_selesai);

        if ($event) {
            $this->response([
                'id' => $event->id,
                'event_id' => $event->event_id,
                'nama_event' => $event->nama_event,
                'tgl_mulai' => $mulai->date,
                'tgl_selesai' => $selesai->date,
                'waktu_mulai' => $mulai->time,
                'waktu_selesai' => $selesai->time,
                'deskripsi_event' => $event->deskripsi_event,
                'lokasi_event' => $event->lokasi_event,
                'img_event' => $event->img_event,
                'event_created' => $event->event_created,
                'created_by' => convert_user($event->created_by)->nama,
                'photo' => convert_user($event->created_by)->photo
            ], 200);
        } else {
            $this->response([
                'message' => 'event id not found'
            ], 404);
        }
    }

    public function event_get()
    {
        $event_id = $this->get('eventid');
        if ($event_id === null) {
            $this->response([
                'message' => 'Not Found',
                'hint' => 'try event/{event_id}'
            ], 404);
        } else {
            $event = $this->event->getEventById($event_id);
        }

        if ($event) {
            $this->response([], 200);
        } else {
            $this->response([
                'message' => 'event id not found'
            ], 404);
        }
    }
}
