<?php

    namespace App\Controllers\Category;
    use App\Database\Connection;
    use App\Helpers\Uploader;
    use App\Helpers\Alert;

    class Category {

        protected $conn;
        protected $alert;
        protected $uploader;

        public function __construct()
        {
            $this->conn     = (new Connection())->DB;
            $this->alert    = (new Alert());
            $this->uploader = (new Uploader());
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
            } else {
                $errors[] .= "Please upload cover";
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
    }