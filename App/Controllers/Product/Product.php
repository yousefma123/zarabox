<?php

namespace App\Controllers\Product;
require_once __DIR__ . '/../../../shared/bootstrap.php';

use App\Database\Connection;
use App\Helpers\Statement;
use App\Helpers\Alert;

class Product
{
    protected $conn;
    protected $alert;
    protected $statement;

    public $data = null;

    public function __construct()
    {
        $this->conn         = (new Connection())->DB;
        $this->alert        = new Alert();
        $this->statement    = new Statement();
    }

    public function index()
    {
        if(isset($_GET['id']) && is_numeric($_GET['id'])):
            $stmt = $this->statement->getJoinData(
                "`products`.*, `product_images`.image",
                "`products`",
                "INNER JOIN `product_images` ON `product_images`.product = `products`.id",
                "fetchAll",
                "WHERE `products`.id = ".$_GET['id'].""
            );
            if ($stmt['rowCount'] == 0): 
                header('Location: 404.html');
                exit;
            endif;
            $this->data = $stmt['fetchAll'][0];
            $this->data['images']    = [];
            foreach($stmt['fetchAll'] as $item):
                array_push($this->data['images'], $item['image']);
            endforeach;
            $sizes = $this->statement->select("`id`, `name`", "`sizes`", "fetchAll", "WHERE `id` IN (".$stmt['fetchAll'][0]['sizes'].")");
            $this->data['sizes'] = $sizes['fetchAll'];
            unset($this->data['image']);
        else:
            header('Location: index');
            exit;
        endif;
            
    }

    public function related()
    {
        $stmt = $this->statement->getJoinData(
            "`products`.*, `product_images`.image",
            "`products`",
            "INNER JOIN (
                SELECT MIN(id) AS id, product, image
                FROM product_images
                GROUP BY product
            ) AS product_images ON product_images.product = products.id",
            "fetchAll",
            "WHERE `products`.category = ".$this->data['category']." AND `products`.id != ".$this->data['id'],
            "LIMIT 8"
        );

        return $stmt;
    }

    public function check()
    {
        echo json_encode($this->statement->select("*", "`products`", "fetch", "WHERE `id` = ".$_GET['id']." AND FIND_IN_SET(".$_GET['size'].", `sizes`)")['fetch']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['checkProduct'])):
    $product = (new Product())->check();
endif;

