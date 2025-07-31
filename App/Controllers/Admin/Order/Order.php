<?php

namespace App\Controllers\Admin\Order;

use App\Database\Connection;
use App\Helpers\Statement;
use App\Helpers\Alert;
use PDO;

class Order
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


    public function delete($token)
        {
            if (!isset($token) || $token != $_SESSION['token']) return false;
        
            $delete = $this->conn->prepare("DELETE FROM `orders` WHERE `id` = ? LIMIT 1");
            $delete->execute([$_GET['id']]);
            if($delete->rowCount() == 1){
                $this->alert->push('تم حذف الطلب بنجاح');
            }
    }
}