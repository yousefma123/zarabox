<?php

namespace App\Controllers\Product;

use App\Database\Connection;
use App\Helpers\Statement;
use App\Helpers\fileSystem;
use App\Helpers\Uploader;
use App\Helpers\Alert;

class Product
{
    protected $conn;
    protected $alert;
    protected $statement;
    protected $uploader;
    protected $fileSystem;

    public function __construct()
    {
        $this->conn         = (new Connection())->DB;
        $this->alert        = new Alert();
        $this->uploader     = new Uploader();
        $this->statement    = new Statement();
        $this->fileSystem   = new fileSystem();
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $errors = [];
        $name       = trim(strip_tags($_POST['name']));
        $price      = trim(strip_tags($_POST['price']));
        $description= trim(strip_tags($_POST['description']));

        $checkCat = $this->statement->select("id", "`categories`", "fetch", "WHERE `id` = ".$_POST['category']."");
        if ($checkCat['rowCount'] == 0) {
            $errors[] .= "Categoru not found";
        }

        if (!isset($name) || empty($name)) {
            $errors[] .= "Please add name";
        }

        if (!isset($price) || !is_numeric($price)) {
            $errors[] .= "Please add name";
        }

        if (!isset($description) || empty($description)) {
            $errors[] .= "Please add description";
        }

        if(isset($_FILES['images']['tmp_name'][0]) && !empty($_FILES['images']['tmp_name'][0])){
            if(count($_FILES['images']['tmp_name']) <= 5){
                foreach($_FILES['images']['tmp_name'] as $key => $file){
                    $file_array = [
                        "name"      => $_FILES['images']['name'][$key],
                        "size"      => $_FILES['images']['size'][$key],
                        "tmp_name"  => $_FILES['images']['tmp_name'][$key]
                    ];
                    $checkImage = $this->uploader->check(
                        $file_array,
                        1000000,
                        ['jpg', 'jpeg', 'png', 'svg', 'webp']
                    );
                    if(!$checkImage){
                        $errors[] .= $this->uploader->message;
                    }
                }
            }else{
                $errors[] .= "Images must be <= 5";
            }
        } else {
            $errors[] .= "Please upload product images";
        }

        if (empty($errors)) {
            $insert = $this->conn->prepare("INSERT INTO `products` (`category`, `name`, `price`, `description`) VALUES(?, ?, ?, ?)");
            $insert->execute([
                $_POST['category'],
                $name,
                $price,
                $description
            ]);
            if ($insert->rowCount() == 1) {
                self::uploadImages($this->conn->lastInsertId(), $_FILES['images']);
                $this->alert->push('تمت إضافة المنتج بنجاح');
            }
        } else {
            $this->alert->push($errors[0], 'error');
        }
    }

    protected function uploadImages($product, $files)
    {
        $insert = $this->conn->prepare("INSERT INTO `product_images` (`product`, `image`) VALUES(?, ?)");
        foreach($_FILES['images']['tmp_name'] as $key => $file){
            $file_array = [
                "name"      => $_FILES['images']['name'][$key],
                "size"      => $_FILES['images']['size'][$key],
                "tmp_name"  => $_FILES['images']['tmp_name'][$key]
            ];
            $upload = $this->uploader->store(
                $file_array,
                PUBLIC_PATH . '/uploads/products'
            );
            if($upload){
                $insert->execute(array($product, $this->uploader->name));
            }
        }
    }

    public function delete($token)
    {
        if (!isset($token) || $token != $_SESSION['token']) return false;
        
        $items = $this->statement->getJoinData(
            "products.id, product_images.*",
            "`products`", 
            "LEFT JOIN `product_images` ON `product_images`.product = `products`.id",
            "fetchAll",
            "WHERE `products`.id = ".$_GET['id']."",
            ""
        );
        if($items['rowCount'] > 0){
            $delete = $this->conn->prepare("DELETE FROM `products` WHERE `id` = ? LIMIT 1");
            $delete->execute([$_GET['id']]);
            if($delete->rowCount() == 1){
                $this->alert->push('تم حذف القسم بنجاح');
                foreach($items['fetchAll'] as $item){
                    $this->fileSystem->remove(PUBLIC_PATH.'/uploads/products/'.$item['image']);
                }
            }
        }
    }

    public function update()
    {
        //
    }
}