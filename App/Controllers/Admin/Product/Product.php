<?php

namespace App\Controllers\Admin\Product;

use App\Database\Connection;
use App\Helpers\Statement;
use App\Helpers\FileSystem;
use App\Helpers\Uploader;
use App\Helpers\Alert;

class Product
{
    protected $conn;
    protected $alert;
    protected $statement;
    protected $uploader;
    protected $fileSystem;

    public $data = null;

    public function __construct()
    {
        $this->conn         = (new Connection())->DB;
        $this->alert        = new Alert();
        $this->uploader     = new Uploader();
        $this->statement    = new Statement();
        $this->fileSystem   = new FileSystem();
    }

    public function create()
    {
        $errors = [];
        $name       = trim(strip_tags($_POST['name']));
        $price      = trim(strip_tags($_POST['price']));
        $description= trim(strip_tags($_POST['description']));
        $sizeType   = trim(strip_tags($_POST['size_type']));
        $sizes      = $_POST['sizes'];

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

        if (!isset($sizeType) || !is_numeric($sizeType)) {
            $errors[] .= "Please add size type";
        }

        if (!isset($sizes) || empty($sizes)) {
            $errors[] .= "Please add sizes";
        }

        if (!isset($description) || empty($description)) {
            $errors[] .= "Please add description";
        }

        if(isset($_FILES['images']['tmp_name'][0]) && !empty($_FILES['images']['tmp_name'][0])){
            if(count($_FILES['images']['tmp_name']) <= 8){
                foreach($_FILES['images']['tmp_name'] as $key => $file){
                    $file_array = [
                        "name"      => $_FILES['images']['name'][$key],
                        "size"      => $_FILES['images']['size'][$key],
                        "tmp_name"  => $_FILES['images']['tmp_name'][$key]
                    ];
                    $checkImage = $this->uploader->check(
                        $file_array,
                        2000000,
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
            $insert = $this->conn->prepare("INSERT INTO `products` (`category`, `name`, `price`, `sizeType`, `sizes`, `description`) VALUES(?, ?, ?, ?, ?, ?)");
            $insert->execute([
                $_POST['category'],
                $name,
                $price,
                $sizeType,
                implode(',', $sizes),
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

    public function update()
    {
        $errors = [];
        $name       = trim(strip_tags($_POST['name']));
        $price      = trim(strip_tags($_POST['price']));
        $description= trim(strip_tags($_POST['description']));
        $sizeType   = trim(strip_tags($_POST['size_type']));
        $sizes      = $_POST['sizes'];

        if (!isset($name) || empty($name)) {
            $errors[] .= "Please add name";
        }

        if (!isset($price) || !is_numeric($price)) {
            $errors[] .= "Please add name";
        }

        if (!isset($sizeType) || !is_numeric($sizeType)) {
            $errors[] .= "Please add size type";
        }

        if (!isset($sizes) || empty($sizes)) {
            $errors[] .= "Please add sizes";
        }

        if (!isset($description) || empty($description)) {
            $errors[] .= "Please add description";
        }

        $imagesWillDelete = array();

        $check = true;

        if (count($_FILES['images']['tmp_name']) > 0 && count($_FILES['images']['tmp_name']) <= 8):
            foreach($_FILES['images']['tmp_name'] as $key => $image):
                if (isset($_POST['image_ids'][$key])):
                    if (!empty($_FILES['images']['tmp_name'][$key])):
                        array_push($imagesWillDelete, $_POST['image_ids'][$key]);
                        $check = true;
                    else:
                        $check = false;
                    endif;
                else:
                    if (!isset($_FILES['images']['tmp_name'][$key]) || empty($_FILES['images']['tmp_name'][$key])):
                        $check = false;
                    else:
                        $check = true;
                    endif;
                endif;
    
                if (!$check) continue;
    
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
                } else {
    
                }
                $check = true;
            endforeach;
        else:
            $errors[] .= "Images must be <= 5";
        endif;

        if (empty($errors)) {
            
            $newImage = self::uploadImages($_GET['id'], $_FILES['images']);

            if (!empty($imagesWillDelete)) {
                $oldImage = self::deleteImages($imagesWillDelete);
            }

            $update = $this->conn->prepare("UPDATE `products` SET `name` = ?, `price` = ?, `sizeType` = ?, `sizes` = ?, `description` = ? WHERE `id` = ? LIMIT 1");
            $update->execute([
                $name,
                $price,
                $sizeType,
                implode(',', $sizes),
                $description,
                $_GET['id']
            ]);
            if ($update->rowCount() == 1) {
                $this->alert->push('تم تعديل المنتج بنجاح');
            }
        } else {
            $this->alert->push($errors[0], 'error');
        }
    }

    protected function uploadImages($product, $files)
    {
        $insert = $this->conn->prepare("INSERT INTO `product_images` (`product`, `image`) VALUES(?, ?)");
        foreach($_FILES['images']['tmp_name'] as $key => $file){
            if (empty($_FILES['images']['tmp_name'][$key])) continue;
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

    protected function deleteImages(Array $images): Bool
    {
        $images = implode(',', $images);
        $stmt = $this->statement->select("`image`", "`product_images`", "fetchAll", "WHERE `id` IN ($images)");
        foreach($stmt['fetchAll'] as $image):
            $this->fileSystem->remove(PUBLIC_PATH . '/uploads/products/'.$image['image']);
        endforeach;
        $delete = $this->conn->prepare("DELETE FROM `product_images` WHERE `id` IN (?)");
        $delete->execute([$images]);
        return true;
    }

    public function check()
    {
        echo json_encode($this->statement->select("*", "`products`", "fetch", "WHERE `id` = ".$_GET['id']." AND FIND_IN_SET(".$_GET['size'].", `sizes`)")['fetch']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['checkProduct'])):
    $product = (new Product())->check();
endif;

