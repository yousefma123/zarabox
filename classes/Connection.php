<?php

    class Connection {
        protected $host = "localhost";
        protected $dbname = "u226525736_technobond";
        protected $user = "u226525736_technobond";
        protected $pass = "D[8s+zAGg94h";
        public $DB;
        
        public function __construct() {
            try {

                $this->DB = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->user, $this->pass);
                return $this->DB;
            }
            catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    