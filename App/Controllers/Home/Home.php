<?php

namespace App\Controllers\Home;

use App\Database\Connection;
use App\Helpers\Statement;

class Home
{
    protected $conn;
    protected $statement;

    public function __construct()
    {
        $this->conn     = (new Connection())->DB;
        $this->statement= new Statement();
    }

    public function categories()
    {
        $categories = $this->statement->getJoinData(
            "DISTINCT `categories`.*",
            "`categories`",
            "INNER JOIN `products` ON `products`.category = `categories`.id",
            "fetchAll",
            "",
            "LIMIT 4"
        );
        return $categories;
    }

    public function categoryWithProducts()
    {
        $categories = self::categories()['fetchAll'];
        foreach($categories as &$category):
            $product = $this->statement->select("*", "`products`", "fetchAll", "WHERE `category` = ".$category['id']."", "LIMIT 8");
            $category['products'] = $product['fetchAll'];
        endforeach;
        return $categories;
    }

    public function productImages($id)
    {
        return array_column($this->statement->select("*", "`product_images`", "fetchAll", "WHERE `product` = $id")['fetchAll'], 'image');
    }

    public function delete()
    {
        //
    }

    public function update()
    {
        //
    }
}