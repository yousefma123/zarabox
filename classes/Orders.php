<?php 

    @session_start();
    class Orders {

        public $conn, $Functions;
        
        public function __construct()
        {
            require_once ('Connection.php');
            require_once ('Functions.php');
            $connection = new Connection(); 
            $this->conn = $connection->DB;
            $this->Functions = new Functions();
        }

        public function _create($id, $branch, $token)
        { 
            if((isset($token) && $token == @$_SESSION['token'])){
                $errors = [];

                if(!empty($_POST['customer']) && is_numeric($_POST['customer'])){
                    $customer = strip_tags($_POST['customer']);
                    if($this->Functions->select("`id`", "`customers`", "fetch", "WHERE `id` = $customer AND `branch` = $branch")['rowCount'] != 1){
                        $errors[] .= "العميل غير موجود";
                    }
                }else{
                    $errors[] .= "Error in customer";
                }

                if(isset($_POST['notes']) && !empty($_POST['notes'])){
                    $notes = trim(strip_tags($_POST['notes']));
                }
                
                if(isset($_POST['invoiceNumber']) && !empty($_POST['invoiceNumber'])){
                    $_POST['invoiceNumber'] = trim(strip_tags($_POST['invoiceNumber']));
                }else{
                    $errors[] .= "برجاء إضافة رقم الفاتورة";
                }

                if(isset($_FILES['invoice']['tmp_name']) && !empty($_FILES['invoice']['tmp_name'])){
                    $upload_file = $this->Functions->_upload_file(
                        $_FILES['invoice'],
                        'null',
                        3000000,
                        ['pdf'], true
                    );
                    if($upload_file['type'] == "error"){
                        $errors[] .= $upload_file['message'];
                    }
                } else {
                    $errors[] .= "برجاء رفع الفاتورة";
                }
               
                if(empty($errors)){
                    $invoice = '123';
                    if(isset($_FILES['invoice']['tmp_name']) && !empty($_FILES['invoice']['tmp_name'])){
                        $upload_file= $this->Functions->_upload_file(
                            $_FILES['invoice'],
                            '/includes/uploads/orders/invoices/',
                            3000000,
                            [],
                            false, false
                        );
                        if($upload_file['type'] == 'success') $invoice = $upload_file['file_name'];
                    }
                    
                    $insert = $this->conn->prepare("INSERT 
                                INTO 
                                `orders` 
                                (`branch`, `accountant`, `customer`, `notes_before`, `invoice`, `invoice_number`) 
                                VALUES(?, ?, ?, ?, ?, ?)");
                    $insert->execute([
                        $branch,
                        $id,
                        $customer,
                        $notes ?? NULL,
                        $invoice,
                        $_POST['invoiceNumber']
                    ]);
                    if($insert->rowCount() > 0){
                        $this->Functions->_alert('تم إضافة الطلب بنجاح');
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

        public function _accept_order($token, $userid, $order, $_api = false)
        { 
            if((isset($token) && $token == @$_SESSION['token']) || $_api === true){
                $errors = [];

                if(isset($order) && is_numeric($order)){
                    $employee_with_last_order = $this->Functions->_getJoinData(
                        "`employees`.branch,
                        `orders`.id AS order_id",
                        "`employees`",
                        "LEFT JOIN `orders` ON `orders`.driver = `employees`.id AND `orders`.status = '1'",
                        "fetch",
                        "WHERE `employees`.id = $userid",
                        "ORDER BY `orders`.id ASC",
                        "LIMIT 1"
                    );
                    // if (is_null($employee_with_last_order['fetch']['order_id'])) {
                        $check = $this->Functions->_getJoinData(
                            "`orders`.*,
                            `customers`.phone, `customers`.name",
                            "`orders`",
                            "INNER JOIN `customers` ON `customers`.id = `orders`.customer",
                            "fetch",
                            "WHERE (`orders`.id = $order AND `orders`.branch = ".$employee_with_last_order['fetch']['branch']." AND `orders`.status = '0')",
                            "LIMIT 1"
                        );
                        if($check['rowCount'] != 1){
                            $errors[] .= "هذا الطلب لم يعد متاح أو قد تم تسليمه لسائق آخر";
                        }
                    // } else {
                    //     $errors[] .= "لا يمكنك استلام طلب جديد أثناء توصيلك لطلب آخر";
                    // }
                }else{
                    $errors[] .= "Error in order id, not found!";
                }

                if(!isset($userid) || empty($userid)){
                    $errors[] .= "Error in user id, not found!";
                }

                if(empty($errors)){
                    $otp = random_int(10000, 99999);
                    $update = $this->conn->prepare("UPDATE `orders` SET `driver` = ?, `otp` = ?, `status` = ? WHERE `id` = ? LIMIT 1");
                    $update->execute([$userid, $otp, '1', $order]);
                    if($update->rowCount() == 1){
                        self::_send_otp($check['fetch']['phone'], $check['fetch']['invoice_number'], $otp);
                        if($_api === false){
                            $this->Functions->_alert('تم استلام هذا الطلب بنجاح، برجاء العمل على توصيله');
                        } else {
                            return ["status" => true, "message" => "تم استلام هذا الطلب بنجاح، برجاء العمل على توصيله"];
                        }
                    }
                }else{
                    if($_api === true) return ["status" => false, "message" => $errors[0]];
                    $show_errors = '';
                    foreach($errors as $err){
                        $show_errors .= "<div>".$err."</div>"; 
                    }
                    $this->Functions->_alert($show_errors, 'error');
                }
            }
        }

        private function _send_otp($phone, $invoice_number, Int $otp) 
        {
            require('Otp.php');
            $Otp = new Otp($phone, $invoice_number, $otp);
        }

        public function _receive_order($token, $userid, $order, $_api = false)
        { 
            if((isset($token) && $token == @$_SESSION['token']) || $_api === true){
                $errors = [];

                if (isset($_POST['otp_code']) && is_numeric($_POST['otp_code'])) {
                    if(isset($order) && is_numeric($order)){
                        $check = $this->Functions->select("*", "`orders`", "fetch", "WHERE `id` = $order AND `driver` = $userid AND `status` = '1'", "LIMIT 1");
                        if($check['rowCount'] != 1){
                            $errors[] .= "هذا الطلب غير متاح لك تسليمه";
                        } else {
                            if ($check['fetch']['otp'] != $_POST['otp_code']) {
                                $errors[] .= "رمز التحقق (OTP) المدخل غير صحيح";
                            }
                        }
                    }else{
                        $errors[] .= "Error in order id, not found!";
                    }
                } else {
                    $errors[] .= "Please enter otp code for this order";
                }

                if(!isset($userid) || empty($userid)){
                    $errors[] .= "Error in user id, not found!";
                }

                if(empty($errors)){
                    $update = $this->conn->prepare("UPDATE `orders` SET `delivery_date` = ?, `status` = ? WHERE `id` = ? LIMIT 1");
                    $update->execute([date("Y-m-d H:i:s"), '2', $order]);
                    if($update->rowCount() == 1){
                        if($_api === false){
                            $this->Functions->_alert('تم تسليم هذا الطلب بنجاح');
                        } else {
                            return ["status" => true, "message" => "تم تسليم هذا الطلب بنجاح"];
                        }
                    }
                }else{
                    if($_api === true) return ["status" => false, "message" => $errors[0]];
                    $show_errors = '';
                    foreach($errors as $err){
                        $show_errors .= "<div>".$err."</div>"; 
                    }
                    $this->Functions->_alert($show_errors, 'error');
                }
            }
        }

        public function _send_notes($userid, $orderid, $notes, $token)
        { 
            if((isset($token) && $token == @$_SESSION['token'])){
                $errors = [];

                $check = $this->Functions->select("`id`, `notes_after`", "`orders`", "fetch", "WHERE `id` = $orderid AND `accountant` = $userid", "", "LIMIT 1");
                if($check['rowCount'] != 1){
                    $errors[] .= "إضافة الملاحظات على هذا الطلب ليس من صلاحياتك";
                }else{
                    if(!empty($check['fetch']['notes_after'])){
                        $errors[] .= "تم إضافة الملاحظات على هذا الطلب من قبل";
                    }
                }

                $notes = trim(strip_tags($notes));
                if(!isset($notes) || empty($notes)){
                    $errors[] .= "برجاء عدم ترك الملاحظات فارغة";
                }
                
                if(empty($errors)){
                    $update = $this->conn->prepare("UPDATE `orders` SET `notes_after` = ? WHERE `id` = ? LIMIT 1");
                    $update->execute([$notes, $orderid]);
                    if($update->rowCount() > 0){
                        $this->Functions->_alert('تم إرسال الملاحظات بنجاح');
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
        
        public function _download($token, $branch = null)
        {
            if((!isset($token) || $token != @$_SESSION['token'])) return;

            $errors = [];

            if (!isset($_POST['from']) || empty($_POST['from'])) {
                $errors[] .= "برجاء إدخال تاريخ بداية البحث";
            }

            if (!isset($_POST['to']) || empty($_POST['to'])) {
                $errors[] .= "برجاء إدخال تاريخ نهاية البحث";
            }

            if (empty($errors)){
                if (is_null($branch)) {
                    $stmt = $this->conn->prepare("SELECT * FROM `orders` WHERE `created_date` BETWEEN ? AND ?");
                    $stmt->execute([$_POST['from'], $_POST['to']]);
                } else {
                    $stmt = $this->conn->prepare("SELECT * FROM `orders` WHERE (`created_date` BETWEEN ? AND ?) AND `branch` = ?");
                    $stmt->execute([$_POST['from'], $_POST['to'], $branch]);
                }
                if ($stmt->rowCount() > 0) {
                    header("Location: download?from=".$_POST['from']."&to=".$_POST['to']."&branch=$branch");
                    exit();
                } else {
                    echo "<div class='alert alert-warning rounded-3 shadow-sm'>لا يوجد نتائج وفقا للبيانات المدخلة</div>";
                }
            }else{
                $show_errors = '';
                foreach($errors as $err){
                    $show_errors .= "<div>".$err."</div>"; 
                }
                $this->Functions->_alert($show_errors, 'error');
            }
        }

        public function _delete($id, $branch)
        {
            if(isset($id) && is_numeric($id) && is_numeric($branch)){
                $getItem = $this->Functions->select("`id`, `invoice`", "`orders`", "fetch", "WHERE `id` = $id && `branch` = $branch AND `status` != '2'", "LIMIT 1");
                if($getItem['rowCount'] == 1){
                    $delete = $this->conn->prepare("DELETE FROM `orders` WHERE `id` = ? AND `status` != '2' LIMIT 1");
                    $delete->execute([$id]);
                    if($delete->rowCount() == 1){
                        $this->Functions->_alert('تم حذف الطلب بنجاح');
                        if(empty($getItem['fetch']['invoice'])) return true;
                        $this->Functions->_removeFile(dirname(__DIR__).'/includes/uploads/orders/invoices/'.$getItem['fetch']['invoice']);
                    }
                }
            }
        }
        
        public function _admin_search($token)
        {
            if(!isset($token) || $token != $_SESSION['token']) return;
            return self::_search_panel($_POST['branch'] ?? null);
        }
        
        public function _employee_search($token, $branch)
        {
            if(!isset($token) || $token != $_SESSION['token']) return;
            return self::_search_panel($branch);
        }
        
        public function _search_panel($branch)
        { 
            if (!empty($_POST['from']) && !empty($_POST['to'])) {
                $dates = "AND `orders`.created_date BETWEEN '".$_POST['from']."' AND '".$_POST['to']."'";
            } elseif (!empty($_POST['from']) && empty($_POST['to'])) {
                $dates = "AND `orders`.created_date >= '".$_POST['from']."'";
            } elseif (empty($_POST['from']) && !empty($_POST['to'])) {
                $dates = "AND `orders`.created_date <= '".$_POST['to']."'";
            } else {
                $dates = '';
            }
            
            if (is_numeric($branch)) {
                $branch = "AND `orders`.branch = $branch";
            } else {
                $branch = '';
            }
    
            $customer   = is_numeric($_POST['customer']) ? 'AND `orders`.customer = '.$_POST['customer'] : '';
            $driver     = is_numeric($_POST['driver']) ? 'AND `orders`.driver =  '.$_POST['driver'] : '';
            $status     = is_numeric($_POST['status']) ? 'AND `orders`.status = "'.$_POST['status'].'"' : '';
            
            if(!$dates && !$customer && !$driver && !$status && !$branch) return;
       
            $stmt = $this->conn->prepare("SELECT
                                            `orders`.*,
                                            `customers`.name AS customer_name,
                                            `employees`.name AS driver_name,
                                            `branches`.name AS branch_name
                                        FROM 
                                            `orders`
                                        INNER JOIN 
                                            `customers` ON `customers`.id = `orders`.customer
                                        INNER JOIN 
                                            `branches` ON `branches`.id = `orders`.branch
                                        LEFT JOIN 
                                            `employees` ON `employees`.id = `orders`.driver
                                        WHERE 
                                            1 = 1
                                        $branch
                                        $dates
                                        $customer
                                        $driver
                                        $status
                                        ");
                                        
            $stmt->execute();
            return [
                "rowCount" => $stmt->rowCount(),
                "fetchAll" => $stmt->fetchAll()
            ];
        }
        
    }