<?php

    namespace App\Controllers\Category;
    use App\Database\Connection;
    use App\Helpers\Uploader;
    use App\Helpers\Alert;
    use App\Helpers\Statement;
    use App\Helpers\FileSystem;

    class Category {

        protected $conn;
        protected $alert;
        protected $uploader;
        protected $fileSystem;
        protected $statement;

        public function __construct()
        {
            $this->conn         = (new Connection())->DB;
            $this->alert        = (new Alert());
            $this->uploader     = (new Uploader());
            $this->fileSystem   = (new FileSystem());
            $this->statement    = (new Statement());
        }

        public function create() 
        {
            $errors = [];
            $name_ar = trim(strip_tags($_POST['name_ar']));
            $name_en = trim(strip_tags($_POST['name_en']));

            if (!isset($name_ar) || empty($name_ar)) {
                $errors[] .= "Please add arabic name";
            }

            if (!isset($name_en) || empty($name_en)) {
                $errors[] .= "Please add english name";
            }

            if(isset($_FILES['cover']['tmp_name']) && !empty($_FILES['cover']['tmp_name'])){
                $checkCover = $this->uploader->check(
                    $_FILES['cover'],
                    1000000,
                    ['jpg', 'jpeg', 'png', 'svg', 'webp']
                );
                if(!$checkCover){
                    $errors[] .= $this->uploader->message;
                }
            } 

            if (empty($errors)) {
                $this->uploader->store(
                    $_FILES['cover'],
                    PUBLIC_PATH . '/uploads/categories'
                );
                $insert = $this->conn->prepare("INSERT INTO `categories` (`name_ar`, `name_en`, `cover`) VALUES(?, ?, ?)");
                $insert->execute([
                    $name_ar,
                    $name_en,
                    $this->uploader->name
                ]);
                if ($insert->rowCount() == 1) {
                    $this->alert->push('تمت إضافة القسم بنجاح');
                }
            } else {
                $this->alert->push($errors[0], 'error');
            }
        }

        public function update()
    {
        $errors = [];
        $name_ar= trim(strip_tags($_POST['name_ar']));
        $name_en= trim(strip_tags($_POST['name_en']));
        $cover  = $_POST['oldCover'] ?? null;

        if (!isset($name_ar) || empty($name_ar)) {
            $errors[] .= "Please add arabic name";
        }

        if (!isset($name_en) || empty($name_en)) {
            $errors[] .= "Please add english name";
        }

        if(isset($_FILES['cover']['tmp_name']) && !empty($_FILES['cover']['tmp_name'])){
            $checkCover = $this->uploader->check(
                $_FILES['cover'],
                1000000,
                ['jpg', 'jpeg', 'png', 'svg', 'webp']
            );
            if(!$checkCover){
                $errors[] .= $this->uploader->message;
            } else {
                $newImage = true;
            }
        } 

        if (empty($errors)) {
            if (isset($newImage)) {
                $this->uploader->store(
                    $_FILES['cover'],
                    PUBLIC_PATH . '/uploads/categories'
                );
                if ($this->uploader->status) $cover = $this->uploader->name;
            }
            $update = $this->conn->prepare("UPDATE `categories` SET `name_ar` = ?, `name_en` = ?, `cover` = ? WHERE `id` = ? LIMIT 1");
            $update->execute([
                $name_ar,
                $name_en,
                $cover,
                $_GET['id']
            ]);
            if ($update->rowCount() == 1) {
                $this->alert->push('تم تعديل القسم بنجاح');
            }
        } else {
            $this->alert->push($errors[0], 'error');
        }
    }

        public function delete($token)
        {
            if (!isset($token) || $token != $_SESSION['token']) return false;
        
            $item = $this->statement->select("`cover`", "`categories`", "fetch", "WHERE `id` = ".$_GET['id']."", "LIMIT 1");
            if($item['rowCount'] == 1){
                $delete = $this->conn->prepare("DELETE FROM `categories` WHERE `id` = ? LIMIT 1");
                $delete->execute([$_GET['id']]);
                if($delete->rowCount() == 1){
                    $this->alert->push('تم حذف القسم بنجاح');
                    $this->fileSystem->remove(PUBLIC_PATH.'/uploads/categories/'.$item['fetch']['cover']);
                }
            }
        }
    }