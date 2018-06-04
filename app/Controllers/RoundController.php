<?php

class RoundController {

    public function get() {
        $_SESSION['_token'] = create_token(16);

        return view('admin/new-round');
    }

    public function post() {
        // Don't resend the same data when page is refreshed
        if (isset($_SESSION['_token']) && isset($_SESSION[$_SESSION['_token']])) {
            return false;
        }

        $_SESSION[$_SESSION['_token']] = 1;

        // Protect agains CSRF attacks
        if (!isset($_POST['_token']) || $_POST['_token'] !== $_SESSION['_token']) {
            return false;
        }

        $db = new Database;
        $season = $_POST['season'];
        $round = $_POST['round'];
        $questions = $this->extract_questions($_POST['questions']);

        foreach ($questions as $question) {
            $db->add_question($season, $round, trim($question));
        }

        view('admin/new-round-feedback');
    }

    private function extract_questions($questions) {
        $questions = explode(PHP_EOL, $questions);
        $extracted = [];

        foreach ($questions as $question) {
            if (preg_match('/^\d+\.\s?(.+)$/', $question, $matches)) {
                $extracted[] = $matches[1];
            } else {
                if ($question !== "") {
                    $extracted[sizeof($extracted) - 1] .= $question;                    
                }
            }
        }
        
        return $extracted;
    }
}