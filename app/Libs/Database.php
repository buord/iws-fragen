<?php

class Database {
    private $dsn = DB_CONNECTION . ':dbname=' . DB_DATABASE . ';' . DB_HOST;
    private $user = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $pdo;

    function __construct() {
        $this->pdo = new PDO($this->dsn, $this->user, $this->password, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ));
    }

    public function get_all_questions() {
        $statement = $this->pdo->query("
            SELECT *
            FROM questions
        ");
        $questions = [];
        $question_numbers = [];

        foreach ($statement->fetchAll() as $row) {
            if (!isset($question_numbers[$row['season']][$row['round']])) {
                $question_numbers[$row['season']][$row['round']] = 1;
            }

            $questions[] = [
                'question' => $row['question'],
                'season' => $row['season'],
                'round' => $row['round'],
                'question_number' => $question_numbers[$row['season']][$row['round']]++,
                'id' => $row['id']
            ];
        }

        return array_reverse($questions);
    }

    public function get_question($id) {
        $statement = $this->pdo->prepare("
            SELECT *
            FROM questions
            WHERE id = ?
        ");

        $statement->execute([$id]);

        $question = $statement->fetchAll(PDO::FETCH_ASSOC);

        return empty($question) ? $question : $question[0];
    }

    public function add_question($season, $round, $question) {
        $statement = $this->pdo->prepare("
            INSERT INTO questions (season, round, question)
            VALUES (?, ?, ?)
        ");

        $statement->execute([$season, $round, $question]);
    }

    public function add_answer($answer, $question_id, $picked) {
        $statement = $this->pdo->prepare("
            INSERT INTO answers (answer, question_id, picked)
            VALUES (?, ?, ?)
        ");

        $statement->execute([$answer, $question_id, $picked]);
    }

    public function get_answers($question_id) {
        $statement = $this->pdo->prepare("
            SELECT *
            FROM answers
            WHERE question_id = ?
        ");
        $answers = [];

        $statement->execute([$question_id]);

        foreach ($statement->fetchAll() as $row) {

            $answers[] = [
                'answer' => $row['answer'],
                'picked' => $row['picked']
            ];
        }

        return $answers;
    }
}
