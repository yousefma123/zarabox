<?php

    namespace App\Helpers;
    use App\Database\Connection;
    use PDO;

    class Statement {

        protected $conn;

        public function __construct()
        {
            $this->conn = (new Connection())->DB;
        }

        public function select($what, $table, $process, $where = NULL, $limit = NULL, $orderBy = "ORDER BY id DESC")
        {
            $stmt = $this->conn->prepare("SELECT $what FROM $table $where $orderBy $limit");
            $stmt->execute();
            switch ($process){
              case "fetch":
                return [
                  "rowCount"  => $stmt->rowCount(),
                  "fetch"     => $stmt->fetch(PDO::FETCH_ASSOC),
                ];
                break;
              case "fetchAll":
                return [
                  "rowCount" => $stmt->rowCount(),
                  "fetchAll" => $stmt->fetchAll(PDO::FETCH_ASSOC),
                ];
                break;
              }
        }

        public function getJoinData($what, $tabel, $join, $type, $where = '', $limit = '')
        {
            $stmt = $this->conn->prepare("SELECT $what FROM $tabel $join $where $limit");
            $stmt->execute();
            if($type == "fetch"){
                return [
                    "rowCount"  => $stmt->rowCount(),
                    "fetch"     => $stmt->fetch()
                ];
            }elseif($type == "fetchAll"){
                return [
                    "rowCount"  => $stmt->rowCount(),
                    "fetchAll"  => $stmt->fetchAll()
                ];
            }
        }
        
    }