<?php

class HomeController {

    public function get() {
        $db = new Database;
        $questions = $db->get_all_questions();

        return view('index', compact('questions'));
    }
}