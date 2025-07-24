<?php 

    class Users {

        public $conn, $Functions;
        public function __construct()
        {
            require_once ('Connection.php');
            require_once ('Functions.php');
            $connection = new Connection(); 
            $this->conn = $connection->DB;
            $this->Functions = new Functions();
            require dirname(__DIR__)."/vendor/autoload.php";
        }

        public function _loginAdmins($email, $password, $token)
        {
            if(isset($token) && $token === $_SESSION['token'] && !isset($_SESSION['mainadmin'])){
                if(isset($email) && isset($email) && !empty($password)){
                    $stmt = $this->conn->prepare("SELECT * FROM `mainadmins` WHERE `email` = :email && `status` = 1 LIMIT 1");
                    $stmt->bindParam(":email", $email);
                    $stmt->execute();
                    if($stmt->rowCount() == 1){
                        $fetch_data = $stmt->fetch();
                        if(password_verify($password, $fetch_data['password'])){
                            $_SESSION['mainadmin'] = $fetch_data['email'];
                            $update = $this->conn->prepare("UPDATE `mainadmins` SET `token` = ?, `last_login` = ? WHERE `email` = ?")->execute([$token, date("l d M h:i A"), $email]);
                            header("location:home");
                            exit();
                        }else{
                            echo "<div class='mb-4 alert alert-danger text-center w-100 rounded-4'>بيانات الدخول غير صحيحة</div>";
                        }
                    }else{
                        echo "<div class='mb-4 alert alert-danger text-center w-100 rounded-4'>بيانات الدخول غير صحيحة</div>";
                    }
                }else{
                    echo "<div class='alert alert-danger text-center w-100 rounded-4'>برجاء إدخال جميع الحقول المطلوبة بالصيغة الصحيحة</div>";
                }
            }
        }

        public function _loginEmployees($phone, $password, $token, $_api = false)
        {
            if(isset($token) && $token === $_SESSION['token'] && !isset($_SESSION['employee']) || $_api = true){
                $errors     = false;
                $phone      = trim(strip_tags($phone));
                $password   = strip_tags($password);

                if (empty($phone) || !is_numeric($phone)) {
                    $errors = "برجاء إدخال رقم جوال صالح";
                } elseif (empty($password)) {
                    $errors = "برجاء إدخال كلمة المرور";
                } else{
                    $stmt = $this->conn->prepare("SELECT * FROM `employees` WHERE `phone` = :phone && `status` = 1 LIMIT 1");
                    $stmt->bindParam(":phone", $phone);
                    $stmt->execute();
                    if($stmt->rowCount() == 1){
                        $fetch_data = $stmt->fetch();
                        if(!password_verify($password, $fetch_data['password'])){
                            $errors = "بيانات الدخول غير صحيحة";
                        }
                    }else{
                        $errors = "بيانات الدخول غير صحيحة";
                    }
                }

                if(empty($errors)){
                    $token = $_api === true ? $this->Functions->_createToken() : $token;
                    $last_login = date('Y-m-d');
                    $update = $this->conn->prepare("UPDATE `employees` SET `token` = ?, `last_login` = ? WHERE `id` = ? LIMIT 1");
                    $update->execute([$token, $last_login, $fetch_data['id']]);
                    if($_api === false){
                        $_SESSION['employee'] = $fetch_data['phone'];
                        header("location:home");
                        exit();
                    } else {
                        unset($fetch_data['password']);
                        unset($fetch_data['verify_code']);
                        $fetch_data['last_login'] = $last_login;
                        $fetch_data['token'] = $token;

                        // Update || Insert device token when user loginig 
                        // $this->Functions->_update_device_token($fetch_data['id'], "drivers", $_POST['device_token']);
                        return [
                            "status"    => true,
                            "message"   => "",
                            "data"      => $fetch_data
                        ];
                    }
                }else{
                    if($_api === true) return ["status" => false, "message" => $errors];
                    echo "<div class='alert alert-danger rounded-4 shadow-sm w-100'>$errors</div>";
                }
            }
        }

        public function _loginCustomers($email, $token, $url, $platform = "web", $_api = false)
        {
            if((isset($token) && $token === @$_SESSION['token'] && !isset($_SESSION['customer'])) || $_api = true){
                if(isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $stmt = $this->conn->prepare("SELECT * FROM `customers` WHERE `email` = :email && `status` = 1 LIMIT 1");
                    $stmt->bindParam(":email", $email);
                    $stmt->execute();
                    if($stmt->rowCount() == 1){
                        $fetch_data = $stmt->fetch();
                        $name = $fetch_data['first_name'].' '.$fetch_data['middel_name'].' '.$fetch_data['last_name'];
                        $code = $this->Functions->_createToken();
                        $update = $this->conn->prepare("UPDATE `customers` SET `code` = ?, `last_code_time` = ? WHERE `id` = ?");
                        $update->execute([$code, time(), $fetch_data['id']]);
                        $_url = $url."/customer/authentication?email=$email&code=$code&platform=$platform";
                        $url = "<a href='$_url'>رابط تسجيل الدخول</a>";
                        $text_msg = "<div class='text-align:right;'> مرحبا $name. <br> رابط الدخول الخاص بك هو <b> $url </b></div>";
                        if($this->Functions->_PHPMailer(
                            "رابط تفعيل الدخول",
                            $text_msg,
                            'mohamy@teraninja.com',
                            $email,
                            'Mohamy'
                        )){
                            if($_api === false){
                                echo "<div class='alert alert-primary rounded-4 shadow-sm w-100'>برجاء التحقق من بريدك الإلكتروني لإكمال عملية الدخول.</div>";
                                $this->Functions->_alert('تم إرسال رابط تفعيل الدخول إلى بريدك الإلكتروني');
                            } else {
                                return ["status" => true, "message" => "تم إرسال رابط تفعيل الدخول إلى بريدك الإلكتروني", "id" => $fetch_data['id'], "customer_token" => $code];
                            }
                        }
                    }else{
                        if($_api === false){
                            echo "<div class='mb-4 alert alert-danger text-center w-100 rounded-4'>بيانات الدخول غير صحيحة</div>";
                        } else {
                            return ["status" => false, "message" => "بيانات الدخول غير صحيحة"];
                        }
                    }
                }else{
                    if($_api === false){
                        echo "<div class='alert alert-danger text-center w-100 rounded-4'>برجاء إدخال جميع الحقول المطلوبة بالصيغة الصحيحة</div>";
                    } else {
                        return ["status" => false, "message" => "برجاء إدخال جميع الحقول المطلوبة بالصيغة الصحيحة"];
                    }
                }
            }
        }
        
        public function _check_auth($email, $code, $platform, $token)
        {
            if(isset($token) && $token === $_SESSION['token'] && !isset($_SESSION['customer'])){
                if(isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $stmt = $this->conn->prepare("SELECT * 
                                                FROM `customers`
                                                WHERE `email` = :email && `code` = :code && `status` = 1
                                                LIMIT 1");
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":code", $code);
                    $stmt->execute();
                    if($stmt->rowCount() == 1){
                        $fetch_data = $stmt->fetch();
                        if($fetch_data['last_code_time'] + 86400 > time()){
                            if($platform['platform'] == "web"){
                                if(!isset($_SESSION['customer'])) $_SESSION['customer'] = $fetch_data['email'];
                                header("location:home");
                                exit();
                            }else{
                                if($platform['platform'] == "android"){
                                    header("location:".$platform['base_url']."userid=".$fetch_data['id']."_token=".$code);
                                }else{
                                    header("location:".$platform['base_url']."?userid=".$fetch_data['id']."&token=".$code);
                                }
                                exit();
                            }
                        } else {
                            echo "Sorry, this link has expired";
                        }
                    }
                }
            }
            return true;
        }
        
        public function _activeAccount($code, $email)
        {
            $code   = trim(strip_tags($code));
            $email  = trim(strip_tags($email));
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $stmt = $this->conn->prepare("SELECT `id` FROM `mainadmins` WHERE `email` = ? && `verify_code` = ? && `status` = ?");
                $stmt->execute([$email, $code, 0]);
                if($stmt->rowCount() == 1){
                    $update = $this->conn->prepare("UPDATE `mainadmins` SET `status` = ? WHERE `email` = ?");
                    $update->execute([1, $email]);
                    if($update->rowCount() == 1){
                        echo "<div class='mb-4 alert alert-success text-center w-100 rounded-4'>تم تفعيل حسابك بنجاح <br> برجاء تسجيل الدخول</div>";
                    }
                }
            }
        }

        public function _update_admin_login_info($data, $token, $_api = false)
        {
            if((isset($token) && $token == @$_SESSION['token']) || $_api === true)
            {
                $errors = [];

                if(isset($data['id']) && is_numeric($data['id'])){
                    $check_user = $this->Functions->select("`id`, `password`", "`mainadmins`", "fetch", "WHERE `id` = ".$data['id']."", "", "LIMIT 1");
                    if($check_user['rowCount'] != 1){
                        $errors[] .= "Error in user id";
                    }
                }else{
                    $errors[] .= "User id not found !";
                }

                if(isset($data['old_password']) && password_verify($data['old_password'], $check_user['fetch']['password'])){
                    if((!isset($data['new_password']) || !isset($data['verify_password']))
                    || ($data['new_password'] !== $data['verify_password'])){
                        $errors[] .= 'كلمة المرور الجديدة لا تتطابق مع كلمة المرور المدخلة في حقل التأكيد !';
                    }
                }else{
                    $errors[] .= "كلمة المرور القديمة غير صحيحة !";
                }

                if(empty($errors)){

                    $update = $this->conn->prepare("UPDATE `mainadmins` SET `password` = ? WHERE `id` = ?");
                    $update->execute([
                        password_hash($data['new_password'], PASSWORD_DEFAULT), 
                        $data['id']
                    ]);
                    if($update->rowCount() > 0){
                        if($_api === false){
                            return $this->Functions->_alert('تم تحديث كلمة المرور بنجاح');
                        } else {
                            return ["status" => true, "message" => "تم تحديث كلمة المرور بنجاح"];
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

        public function _delete_customer($id)
        {
            $errors = [];
            if(!isset($id) || empty($id) || !is_numeric($id)){
                return false;
            }

            if(empty($errors)){
                $update = $this->conn->prepare("UPDATE `customers` SET `status` = ? WHERE `id` = ?");
                $update->execute([2, $id]);
                if($update->rowCount() > 0){
                    return ["status" => true, "message" => "تم حذف الحساب بنجاح"];
                }
            }else{
                $show_errors = '';
                foreach($errors as $err){
                    $show_errors .= "<div>".$err."</div>"; 
                }
                $this->Functions->_alert($show_errors, 'error');
            }
        }

        public function _delete_employee($id)
        {
            $errors = [];
            if(!isset($id) || empty($id) || !is_numeric($id)){
                return false;
            }

            if(empty($errors)){
                $update = $this->conn->prepare("UPDATE `employees` SET `status` = ? WHERE `id` = ?");
                $update->execute([0, $id]);
                if($update->rowCount() > 0){
                    return ["status" => true, "message" => "تم حذف الحساب بنجاح"];
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