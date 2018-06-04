<?php

class ApiController {
    private $db;

    public function __construct() {
        header('Content-type:application/json;charset=utf-8');

        $this->db = new Database;
    }

    public function get_answers($question_id) {
        $answers = $this->db->get_answers($question_id);

        $this->print_json($answers);
    }

    private function print_json($data) {
        echo json_encode($data);
    }
}