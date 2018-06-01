<?php

class HomeController {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function get() {
        $questions = $this->db->get_questions();

        return view('index', compact('questions'));
    }
}