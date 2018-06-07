<?php

class AnswersController {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function get($question_id) {
        $_SESSION['_token'] = create_token(16);
        $question = $this->db->get_question($question_id);
        $answers = $this->db->get_answers($question_id);

        if (!empty($question)) {
            view('admin/answers', compact('question', 'answers'));
        }
    }

    public function post($id) {
        // Don't resend the same data when page is refreshed
        if (isset($_SESSION['_token']) && isset($_SESSION[$_SESSION['_token']])) {
            return false;
        }

        $_SESSION[$_SESSION['_token']] = 1;

        // Protect agains CSRF attacks
        if (!isset($_POST['_token']) || $_POST['_token'] !== $_SESSION['_token']) {
            return false;
        }

        $answers = $this->extract_answers($_POST['answers']);

        foreach ($answers as $answer) {
            $this->db->add_answer(trim($answer[0]), $id, $answer[1]);
        }

        view('admin/answers-feedback', compact('id'));
    }

    private function extract_answers($answers) {
        $answers = explode(PHP_EOL, $answers);
        $extracted = [];

        foreach ($answers as $answer) {
            if (preg_match('/^(\d+)\s+(.+)$/', $answer, $matches)) {
                $extracted[] = [$matches[2], $matches[1]];
            }
        }
        
        return $extracted;
    }
}