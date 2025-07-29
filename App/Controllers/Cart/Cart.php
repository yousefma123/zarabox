<?php

namespace App\Controllers\Cart;
require_once __DIR__ . '/../../../shared/bootstrap.php';

use App\Database\Connection;
use App\Helpers\Statement;
use App\Helpers\TokenCreator;

class Cart
{
    protected $conn;
    protected $token;

    public function __construct()
    {
        $this->conn     = (new Connection())->DB;
        $this->statement= new statement();
    }

    public function index()
    {
        $items = json_decode($_GET['products']);
        $final = array();
        $stmt = $this->conn->prepare("SELECT products.id, products.name, products.price,
                                        product_images.image
                                    FROM products
                                    INNER JOIN (
                                        SELECT MIN(id) AS id, product, image
                                        FROM product_images
                                        GROUP BY product
                                    ) AS product_images ON product_images.product = products.id
                                    WHERE products.id = ? AND products.status = 1"
                                    );
        foreach($items as $item):
            $stmt->execute(array($item->id));
            $size = self::getSize($item->size);
            if ($stmt->rowCount() == 1 && $size):
                $product = $stmt->fetch();
                $product['quantity'] = $item->quantity;
                $product['size'] = $size;
                $product['sizeId'] = $item->size;
                array_push($final, $product);
            endif;
        endforeach;

        echo json_encode($final);
    }

    protected function getSize($id) 
    {
        return $this->statement->select("`name`", "`sizes`", "fetch", "WHERE `id` = $id", "LIMIT 1")['fetch']['name'] ?? null;
    }

    public function setToken() 
    {
        $tokenCreator = new TokenCreator();
        $token = $tokenCreator->create('token');
        if ($token['status'] === true) {
            return $tokenCreator->store('token', $token['value']);
        }
        return $token['value'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['getProducts'])):
    $Cart = (new Cart())->index();
endif;



