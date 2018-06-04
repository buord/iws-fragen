<?php

class QuestionsController {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function get() {
        $questions = $this->db->get_all_questions();

        return view('admin/questions', compact('questions'));
    }
}