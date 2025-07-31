<?php

namespace App\Controllers\Category;

use App\Database\Connection;
use App\Helpers\Statement;
use PDO;

class Category
{
    protected $conn;
    protected $statement;

    public $category, $products;

    public function __construct()
    {
        $this->conn     = (new Connection())->DB;
        $this->statement= new Statement();

        $stmt = $this->statement->select("*", "categories", "fetch", "WHERE `id` = ".$_GET['id']."", "LIMIT 1");
        if ($stmt['rowCount'] != 1) {
            header('Location: 404.html');
            exit;
        }
        $this->category = $stmt['fetch'];
        self::products();
    }

    public function products()
    {

        $stmt = $this->conn->prepare("SELECT 
                                p.*,
                                (
                                    SELECT pi.image 
                                    FROM product_images pi 
                                    WHERE pi.product = p.id 
                                    ORDER BY pi.id ASC 
                                    LIMIT 1
                                ) AS image
                            FROM 
                                products p
                            WHERE 
                                p.category = :category_id
                            LIMIT 200
                            ");
        $stmt->execute(['category_id' => $this->category['id']]);
        $this->category['products'] = $stmt->fetchAll(PDO::FETCH_ASSOC);  
    }
}