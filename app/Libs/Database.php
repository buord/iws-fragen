<?php

class Database {
    private $dsn = DB_CONNECTION . ':dbname=' . DB_DATABASE . ';' . DB_HOST;
    private $user = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $pdo;
    private $builder;

    function __construct() {
        $this->pdo = new PDO($this->dsn, $this->user, $this->password, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ));
        $this->builder = new QueryBuilder();
    }

    public function get_all_questions() {
        $query = $this->builder->select('*')
                    ->from('questions')
                    ->get();
        $statement = $this->pdo->query($query);
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

        return $questions;
    }

    public function get_question($id) {
        $query = $this->builder->select('*')
                    ->from('questions')
                    ->where('id = ?')
                    ->get();
        $statement = $this->pdo->prepare($query);

        $statement->execute([$id]);

        $question = $statement->fetchAll(PDO::FETCH_ASSOC);

        return empty($question) ? $question : $question[0];
    }

    public function add_question($season, $round, $question) {
        $query = $this->builder->insert_into('questions (season, round, question)')
                    ->values('(?, ?, ?)')
                    ->get();
        $statement = $this->pdo->prepare($query);

        $statement->execute([$season, $round, $question]);
    }

    public function add_answer($answer, $question_id, $picked) {
        $query = $this->builder->insert_into('answers (answer, question_id, picked)')
                    ->values('(?, ?, ?)')
                    ->get();
        $statement = $this->pdo->prepare($query);

        $statement->execute([$answer, $question_id, $picked]);
    }

    public function get_answers($question_id) {
        $query = $this->builder->select('*')
                    ->from('answers')
                    ->where('question_id = ?')
                    ->get();
        $statement = $this->pdo->prepare($query);
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