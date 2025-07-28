<?php

namespace App\Controllers\Size;
require_once __DIR__ . '/../../../shared/bootstrap.php';

use App\Database\Connection;
use App\Helpers\Statement;
use App\Helpers\Alert;

class Size
{
    protected $conn;
    protected $statement;
    protected $alert;

    public function __construct()
    {
        $this->conn     = (new Connection())->DB;
        $this->statement= new Statement();
        $this->alert    = new Alert();
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function delete()
    {
        //
    }

    public function fetchSizes()
    {
        echo json_encode($this->statement->select("*", "`sizes`", "fetchAll", "WHERE `type` = ".$_GET['type']."")['fetchAll']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['fetchSizes'])):
    $size = (new Size())->fetchSizes();
endif;