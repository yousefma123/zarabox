<?php 

    @session_start();
    class EmployeesAuth {

        public $conn, $Functions;
        public function __construct()
        {
            require_once (dirname(__DIR__).'/Connection.php');
            require_once (dirname(__DIR__).'/Functions.php');
            $connection = new Connection(); 
            $this->conn = $connection->DB;
            $this->Functions = new Functions();
            require dirname(__DIR__)."/../vendor/autoload.php";
        }

        public function _login($phone, $password, $token, $_api = false, $job = 1)
        {
            if(isset($token) && $token === @$_SESSION['token'] && !isset($_SESSION['employee']) || $_api = true){
                $errors     = false;
                $phone      = trim(strip_tags($phone));
                $password   = strip_tags($password);

                if (empty($phone) || !is_numeric($phone)) {
                    $errors = "برجاء إدخال رقم جوال صالح";
                } elseif (empty($password)) {
                    $errors = "برجاء إدخال كلمة المرور";
                } else{
                    $stmt = $this->conn->prepare("SELECT * FROM `employees` WHERE `phone` = :phone  AND `job` = :job AND `status` = 1 LIMIT 1");
                    $stmt->bindParam(":phone", $phone);
                    $stmt->bindParam(":job", $job);
                    $stmt->execute();
                    if($stmt->rowCount() == 1){
                        $fetch_data = $stmt->fetch(PDO::FETCH_ASSOC);
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

        public function _update_login_info($data, $token, $_api = false)
        {
            if((isset($token) && $token == @$_SESSION['token']) || $_api === true)
            {
                $errors = [];

                if(isset($data['id']) && is_numeric($data['id'])){
                    $check_user = $this->Functions->select("`id`, `image`, `password`", "`employees`", "fetch", "WHERE `id` = ".$data['id']."", "", "LIMIT 1");
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

                    $update = $this->conn->prepare("UPDATE `employees` SET `password` = ? WHERE `id` = ? LIMIT 1");
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
    }