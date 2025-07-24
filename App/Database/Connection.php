<?php

    namespace App\Database;

    use PDO;
    use PDOException;

    class Connection {
        public $DB;

        public function __construct() {
            $host   = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $user   = $_ENV['DB_USER'];
            $pass   = $_ENV['DB_PASS'];
            try {
                $this->DB = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
                return $this->DB;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }
