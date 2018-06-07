<?php

class QuestionsController {

    public function get() {
        $db = new Database;
        $questions = $db->get_all_questions();

        return view('admin/questions', compact('questions'));
    }
}