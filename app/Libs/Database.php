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

    public function get_questions() {
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
                'question_number' => $question_numbers[$row['season']][$row['round']]++
            ];
        }

        return $questions;
    }

    public function add_question($season, $round, $question) {
        $query = $this->builder->insert_into('questions (season, round, question)')
                    ->values('(?, ?, ?)')
                    ->get();
        $statement = $this->pdo->prepare($query);

        $statement->execute([$season, $round, $question]);
    }
}