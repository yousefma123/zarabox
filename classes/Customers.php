<?php 

    @session_start();

    class Customers {

        public $conn, $Functions;
        
        public function __construct()
        {
            require_once ('Connection.php');
            require_once ('Functions.php');
            $connection = new Connection(); 
            $this->conn = $connection->DB;
            $this->Functions = new Functions();
        }

        public function _createCustomer($token, $branch)
        { 
            if((isset($token) && $token == @$_SESSION['token']) || $_api === true){
                $errors = [];

                $phone = trim(strip_tags($_POST['phone']));
                if(is_numeric($phone) && strlen($phone) === 9) {
                    if($this->Functions->select("`id`", "`customers`", "fetch", "WHERE `phone` = '$phone'")['rowCount'] != 0){
                        $note = "هذا الرقم مسجل من قبل";
                    }
                } else {
                    $errors[] .= "برجاء إدخال رقم جوال صالح";
                }

                $name = trim(strip_tags($_POST['name']));

                if(!isset($name) || empty($name)){
                    $errors[] .= "برجاء إدخال اسم العميل";
                }
               
                if(empty($errors)){
                    $insert = $this->conn->prepare("INSERT 
                                                    INTO 
                                                    `customers` (`branch`, `name`, `phone`) 
                                                    VALUES(?, ?, ?)");
                    $insert->execute([
                        $branch,
                        $name,
                        $phone
                    ]);
                    if($insert->rowCount() > 0){
                        $this->Functions->_alert('تم إضافة العميل بنجاح');
                        if (isset($note)) {
                            echo "<div class='alert alert-primary rounded-4'>هذا العميل مسجل من قبل</div>";
                        }
                    }
                }else{
                    $show_errors = '';
                    foreach($errors as $err){
                        $show_errors .= "<div>".$err."</div>"; 
                    }
                    echo '<div class="alert alert-danger rounded-4 w-100"><div>'.$show_errors.'</div></div>';
                }
            }
        }

        public function _updateCustomer($id, $branch, $token)
        { 
            if(isset($token) && $token == $_SESSION['token']){
                $errors = [];
                if(isset($id) && !empty($id)){
                    $checkCustomer = $this->Functions->select('*', 'customers', 'fetch', "WHERE `id` = $id && `branch` = $branch && `status` = 1");
                    if($checkCustomer['rowCount'] != 1){
                        $errors[] .= "Error in customer id";
                    }
                }else{
                    $errors[] .= "Error in customer not found";
                }

                $phone = trim(strip_tags($_POST['phone']));
                if(is_numeric($phone) && strlen($phone) === 9) {
                    if($this->Functions->select("`id`", "`customers`", "fetch", "WHERE `phone` = '$phone' AND `id` != $id")['rowCount'] != 0){
                        $errors[] .= "هذا الرقم مسجل من قبل";
                    }
                } else {
                    $errors[] .= "برجاء إدخال رقم جوال صالح";
                }
                
                if(!isset($_POST['name']) || empty($_POST['name'])){
                    $errors[] .= "برجاء عدم ترك اسم العميل فارغا";
                }
                
              
                if(empty($errors)){
                    $insert = $this->conn->prepare("UPDATE `customers` SET `name` = ?, `phone` = ? WHERE `id` = ?");
                    $insert->execute([
                        $_POST['name'],
                        $phone,
                        $id
                    ]);
                    if($insert->rowCount() > 0){
                        $this->Functions->_alert('تم تعديل بيانات العميل بنجاح');
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

        public function _search_panel($data, $_api = false)
        { 
            $data = json_decode($data, true);
            if((isset($data['token']) && $data['token'] == @$_SESSION['token']) || $_api == true){
                if($data['type'] == 'name'){
                    $where = "WHERE `customers`.name LIKE '%".$data['where']."%'";
                }elseif($data['type'] == 'phone'){
                    $where = "WHERE `customers`.`phone` LIKE '".$data['where']."%'";
                }
                
                $branch = '';
                if (isset($data['branch'])) $branch = "AND `branch` = ".$data['branch'];

                $response = $this->Functions->select("*", "`customers`", "fetchAll", "$where $branch");
               
                echo json_encode([
                    "status"   => true,
                    "rowCount" => $response['rowCount'],
                    "fetchAll" => $response['fetchAll']
                ]);
            }
        }

        // public function _deleteAccount($id, $token)
        // {
        //     if(isset($token) && $token == $_SESSION['token']){
        //         $errors = [];
        //         if(isset($id) && !empty($id)){
        //             $customer_id = $id;
        //             $checkCustomer = $this->Functions->select('`id`, `first_name`, `last_name`', 'customers', 'fetch', "WHERE `id` = $customer_id");
        //             if($checkCustomer['rowCount'] != 1){
        //                 return false;
        //             }
        //         }else{
        //             $errors[] .= "Error in customer not found";
        //         }

        //         $checkIssues = $this->Functions->select("`id`", "`issues`", "fetch", "WHERE `customer` = $customer_id");
        //         if($checkIssues['rowCount'] > 0) $errors[] .= "لا يمكن حذف العميل لأنه مرتبط بقضايا";

        //         $checkConsultings = $this->Functions->select("`id`", "`consultings`", "fetch", "WHERE `customer` = $customer_id");
        //         if($checkConsultings['rowCount'] > 0) $errors[] .= "لا يمكن حذف العميل لأنه مرتبط باستشارات";
        //         if(empty($errors)){
        //             $delete = $this->conn->prepare("DELETE FROM `customers` WHERE `id` = ? LIMIT 1");
        //             $delete->execute([$customer_id]);
        //             if($delete->rowCount() == 1){
        //                 $recivers = [];
        //                 $this->Functions->_notifications(
        //                     0,
        //                     $recivers,
        //                     "لقد تم حذف الموظف <br> ".$checkCustomer['fetch']['first_name'].' '.$checkCustomer['fetch']['last_name'],
        //                     "#"
        //                 );
        //                 $this->Functions->_alert("تم حذف العميل بنجاح");
        //             }
        //         }else{
        //             $show_errors = '';
        //             foreach($errors as $err){
        //                 $show_errors .= "<div>".$err."</div>"; 
        //             }
        //             $this->Functions->_alert($show_errors, 'error');
        //         }
        //     }
        // }
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search']) && isset($_GET['data'])):
        $Customers = new Customers();
        $Customers->_search_panel($_GET['data']);
    endif;
    