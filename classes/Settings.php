<?php 

    @session_start();
    class Settings {

        public $conn, $Functions;
        public function __construct()
        {
            require_once ('Connection.php');
            require_once ('Functions.php');
            $connection = new Connection(); 
            $this->conn = $connection->DB;
            $this->Functions = new Functions();
        }

        public function _update_tax_number($tax_number)
        { 
            $errors = [];
            $tax_number = trim(strip_tags($tax_number));
            if(!isset($tax_number) || empty($tax_number)){
                $errors[] .= "Error in tax number";
            }

            if(empty($errors)){
                $update = $this->conn->prepare("UPDATE `settings` SET `value` = ? WHERE `name` = ?");
                $update->execute([$tax_number, "tax_number"]);
                if($update->rowCount() > 0){
                    $this->Functions->_alert("تم حفظ الرقم الضريبي بنجاح", 3000);
                }
            }else{
                $show_errors = '';
                foreach($errors as $err){
                    $show_errors .= "<div>".$err."</div>"; 
                }
                $this->Functions->_alert($show_errors, 'error');
            }
        }

        public function _update_setting($name, $value, $token)
        { 
            if(isset($token) && $token == $_SESSION['token']){
                $errors = [];
                $value = trim(strip_tags($value));
                if(!isset($value) || empty($value)){
                    $errors[] .= "برجاء إدخال الحقول المطلوبة";
                }

                if(empty($errors)){
                    $update = $this->conn->prepare("UPDATE `settings` SET `value` = ? WHERE `name` = ?");
                    $update->execute([$value, $name]);
                    if($update->rowCount() > 0){
                        $this->Functions->_alert("تم حفظ الإعدادات بنجاح", 3000);
                    }
                }else{
                    $show_errors = '';
                    foreach($errors as $err){
                        $show_errors .= "<div>".$err."</div>"; 
                    }
                    $this->Functions->_alert($show_errors, 'error');
                }
            }
        }

        public function _createBranch($token)
        { 
            if(isset($token) && $token == $_SESSION['token']){
                $errors = [];
                
                $name       = trim(strip_tags($_POST['name']));
                $country    = trim(strip_tags($_POST['country']));
                $city       = trim(strip_tags($_POST['city']));

                if(!isset($name) || empty($name)){
                    $errors[] .= "برجاء إدخال اسم الفرع";
                }
                if(!isset($country) || empty($country)){
                    $errors[] .= "برجاء إدخال الدولة";
                }
                if(!isset($city) || empty($city)){
                    $errors[] .= "برجاء إدخال المدينة";
                }
               
                if(empty($errors)){
                    $insert = $this->conn->prepare("INSERT INTO `branches` (`name`, `country`, `city`) VALUES(?, ?, ?)");
                    $insert->execute([
                        $name,
                        $country,
                        $city,
                    ]);
                    if($insert->rowCount() > 0){
                        $this->Functions->_alert('تم إضافة الفرع بنجاح');
                    }
                }else{
                    $show_errors = '';
                    foreach($errors as $err){
                        $show_errors .= "<div>".$err."</div>"; 
                    }
                    $this->Functions->_alert($show_errors, 'error');
                }
            }
        }
        
        public function _deleteBranch($branch, $token)
        {
            if (!isset($token) || $token !== $_SESSION['token']) return;
            
            if(isset($branch) && is_numeric($branch)){

                $delete = $this->conn->prepare("DELETE FROM `branches` WHERE `id` = ?  LIMIT 1");
                $delete->execute([$branch]);
                if($delete->rowCount() == 1){
                    $this->Functions->_alert('تم حذف الفرع بنجاح');
                }

            }
        }

        public function _updateBranch($id, $token)
        { 
            if(isset($token) && $token == $_SESSION['token']){
                $errors = [];
                if(isset($id) && !empty($id)){
                    if($this->Functions->select('`id`', 'branches', 'fetch', "WHERE `id` = $id")['rowCount'] != 1){
                        $errors[] .= "Error in branch id";
                    }
                }else{
                    $errors[] .= "Error in branch not found";
                }
                
                $name       = trim(strip_tags($_POST['name']));
                $country    = trim(strip_tags($_POST['country']));
                $city       = trim(strip_tags($_POST['city']));

                if(!isset($name) || empty($name)){
                    $errors[] .= "برجاء إدخال اسم الفرع";
                }
                if(!isset($country) || empty($country)){
                    $errors[] .= "برجاء إدخال الدولة";
                }
                if(!isset($city) || empty($city)){
                    $errors[] .= "برجاء إدخال المدينة";
                }

                if(empty($errors)){
                    $update = $this->conn->prepare("UPDATE `branches` SET `name` = ?, `country` = ?, `city` = ? WHERE `id` = ?");
                    $update->execute([
                        $name,
                        $country,
                        $city,
                        $id
                    ]);
                    if($update->rowCount() > 0){
                        $this->Functions->_alert('تم تعديل بيانات الفرع بنجاح');
                    }
                }else{
                    $show_errors = '';
                    foreach($errors as $err){
                        $show_errors .= "<div>".$err."</div>"; 
                    }
                    $this->Functions->_alert($show_errors, 'error');
                }
            }
        }
        
        public function _getBranchUsers()
        {
            if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
                $branch     = $_GET['branch'];
            
                $drivers    = $this->Functions->select("`id`, `name`", "`employees`", "fetchAll", "WHERE `branch` = $branch AND `job` = 2");
                $customers  = $this->Functions->select("`id`, `name`", "`customers`", "fetchAll", "WHERE `branch` = $branch");

                echo json_encode([
                    "drivers" => $drivers['fetchAll'],
                    "customers"=> $customers['fetchAll']
                ]);
            }
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['getBranchUsers'])):
        $data = new Settings();
        $data->_getBranchUsers();
    endif;