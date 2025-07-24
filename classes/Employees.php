<?php 

    @session_start();

    class Employees {

        public $conn, $Functions;
        
        public function __construct()
        {
            require_once ('Connection.php');
            require_once ('Functions.php');
            $connection = new Connection(); 
            $this->conn = $connection->DB;
            $this->Functions = new Functions();
        }

        public function _createEmployee($token, $add_from_accountant = null)
        { 
            if(isset($token) && $token == $_SESSION['token']){
                $errors = [];

                if ($add_from_accountant != null) {
                    $_POST['branch'] = $add_from_accountant['branch'];
                    $_POST['job'] = $add_from_accountant['job'];
                }
                
                if(isset($_POST['branch']) && !empty($_POST['branch'])){
                    $branch_id = $_POST['branch'];
                    if($this->Functions->select('`id`', 'branches', 'fetch', "WHERE `id` = $branch_id && `status` = 1")['rowCount'] !=1 ){
                        $errors[] .= "Error in branch id";
                    }
                }else{
                    $errors[] .= "Error in branch not found";
                }
            
                if(isset($_POST['job']) && !empty($_POST['job'])){
                    $job_id = $_POST['job'];
                    if($this->Functions->select('`id`', 'jobs', 'fetch', "WHERE `id` = $job_id && `status` = 1")['rowCount'] !=1 ){
                        $errors[] .= "Error in job id";
                    }
                }else{
                    $errors[] .= "Error in job not found";
                }
                
                $phone = trim(strip_tags($_POST['phone']));
                if(is_numeric($phone) && strlen($phone) === 9) {
                    if($this->Functions->select("`id`", "`employees`", "fetch", "WHERE `phone` = '$phone' AND `job` = ".$_POST['job']."")['rowCount'] != 0){
                        $errors[] .= "هذا الرقم مسجل من قبل";
                    }
                } else {
                    $errors[] .= "برجاء إدخال رقم جوال صالح";
                }
               
                $fname = trim(strip_tags($_POST['first_name']));
                $mname = trim(strip_tags($_POST['middel_name']));
                $lname = trim(strip_tags($_POST['last_name']));
                
                if(!isset($fname) || empty($fname)){
                    $errors[] .= "برجاء إدخال الاسم الاول";
                }
                if(!isset($lname) || empty($lname)){
                    $errors[] .= "برجاء إدخال الاسم الأوسط";
                }
                if(!isset($lname) || empty($lname)){
                    $errors[] .= "برجاء إدخال الاسم الأخير";
                }
               
                if(empty($errors)){
                    $password = random_int(100000, 999999);
                    $insert = $this->conn->prepare("INSERT 
                                                    INTO 
                                                    `employees` (`name`, `job`, `branch`, `phone`, `password`) 
                                                    VALUES(?, ?, ?, ?, ?)");
                    $insert->execute([
                        $fname. ' '. $mname. ' '. $lname,
                        $job_id,
                        $branch_id,
                        $phone,
                        password_hash($password, PASSWORD_DEFAULT)
                    ]);

                    if($insert->rowCount() > 0){
                        $this->Functions->_alert('تم إضافة الموظف بنجاح');
                        echo "<div class='alert alert-primary rounded-4'>كلمة المرور لهذا الموظف: <b>$password</b></div>";
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

        public function _updateEmployee($id, $token, $branch = null)
        {
            if(isset($token) && $token == $_SESSION['token']){
                $errors = [];

                if ($branch != null) $branch = "AND `branch` = $branch AND `job` = 2";

                if(isset($id) && !empty($id)){
                    $checkEmployee = $this->Functions->select('`id`, `password`, `job`', 'employees', 'fetch', "WHERE `id` = $id $branch");
                    if($checkEmployee['rowCount'] != 1){
                        $errors[] .= "Error in employee id";
                    }
                }else{
                    $errors[] .= "Error in employee not found";
                }
             
                $fname = trim(strip_tags($_POST['first_name']));
                $mname = trim(strip_tags($_POST['middel_name']));
                $lname = trim(strip_tags($_POST['last_name']));
                
                if(!isset($fname) || empty($fname)){
                    $errors[] .= "برجاء إدخال الاسم الاول";
                }
                if(!isset($lname) || empty($lname)){
                    $errors[] .= "برجاء إدخال الاسم الأوسط";
                }
                if(!isset($lname) || empty($lname)){
                    $errors[] .= "برجاء إدخال الاسم الأخير";
                }

                $phone = trim(strip_tags($_POST['phone']));
                if(is_numeric($phone) && strlen($phone) === 9) {
                    if($this->Functions->select("`id`", "`employees`", "fetch", "WHERE `phone` = '$phone' && `id` != $id AND `job` = ".$checkEmployee['fetch']['job']."")['rowCount'] != 0){
                        $errors[] .= "هذا الرقم مسجل من قبل";
                    }
                } else {
                    $errors[] .= "برجاء إدخال رقم جوال صالح";
                }
               
                if(empty($errors)){
                    if(isset($_POST['password']) && !empty($_POST['password'])) {
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    } else {
                        $password = $checkEmployee['fetch']['password'];
                    }
                    $insert = $this->conn->prepare("UPDATE `employees` SET `name` = ?, `phone` = ?, `password` = ? WHERE `id` = ? LIMIT 1");
                    $insert->execute([
                        $fname. ' '. $mname. ' '. $lname,
                        $phone,
                        $password,
                        $id
                    ]);
                    if($insert->rowCount() > 0){
                        $this->Functions->_alert('تم تعديل بيانات الموظف بنجاح');
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

        public function _activeAccount($data, $token)
        {
            if(isset($token) && $token == $_SESSION['token']){
                $errors = [];
                if(!isset($data['code']) || empty($data['code'])){
                    $errors[] .= "Error in code";
                }
                if(!empty($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    $email = $data['email'];
                    $code = $data['code'];
                    if($this->Functions->select("`id`", "`employees`", "fetch", "WHERE `email` = '$email' && `verify_code` = '$code' && `status` = 0")['rowCount'] == 0){
                        $errors[] .= "Error in email and code";
                    }
                }else{
                    $errors[] .= "Error in email";
                }
                if(!isset($data['password']) || empty($data['password'])){
                    $errors[] .= "Error in password";
                }
                if(!isset($data['checkPassword']) || empty($data['checkPassword'])){
                    $errors[] .= "Error in checkPassword";
                }

                if($data['password'] != $data['checkPassword']){
                    $errors[] .= "Error in password(s)";
                }

                if(empty($errors)){
                    $update = $this->conn->prepare("UPDATE `employees` SET `password` = ?, `status` = ? WHERE `email` = ?");
                    $update->execute([password_hash($data['password'], PASSWORD_DEFAULT), 1, $data['email']]);
                    if($update->rowCount() > 0){
                        $text_msg = 
                        "
                            <div dir='rtl' style='text-align:right;'>
                                مرحبا, ".$data['first_name'].' '.$data['middel_name']."<br>
                                تم تفعيل حسابك بنجاح
                            </div>
                        ";
                        if($this->Functions->_PHPMailer('تم تفعيل الحساب بنجاح', $text_msg, 'mohamy@teraninja.com', $data['email'], 'Mohamy') == true){
                            $this->Functions->_alert("تم تفعيل حسابك بنجاح، علما أنه سيتم إرسال رسالة تأكد ذلك عبر بريدكم", '', 10000);
                            header("Refresh:3;login");
                            exit();
                        }
                    }
                }else{
                    $show_errors = '';
                    foreach($errors as $err){
                        $this->Functions->_alert($err, 'error', 5000);
                    }
                }
            } 
        }

        public function _restoreAccount($data)
        {
            $data = json_decode($data, true);
            if(isset($data['token']) && $data['token'] == $_SESSION['token']){
                $errors = [];
                if(isset($data['id']) && !empty($data['id'])){
                    $employee_id = $data['id'];
                    $checkEmployee = $this->Functions->select('`id`, `email`, `verify_code`, `first_name`, `middel_name`', 'employees', 'fetch', "WHERE (`id` = $employee_id) && (`status` = 1 || `status` = 0 )");
                    if($checkEmployee['rowCount'] != 1){
                        return false;
                    }
                }else{
                    $errors[] .= "Error in employee not found";
                }

                if(empty($errors)){
                    $code = random_int(100000, 999999);
                    $update = $this->conn->prepare("UPDATE `employees` SET `password` = ?, `status` = ?, `verify_code` = ? WHERE `id` = ?");
                    $update->execute(['', 0, $code, $employee_id]);
                    if($update->rowCount() > 0){
                        $email = $checkEmployee['fetch']['email'];
                        $text_msg = 
                        "
                        <div dir='rtl' style='text-align:right;'>
                            مرحبا, ".$checkEmployee['fetch']['first_name'].' '.$checkEmployee['fetch']['middel_name']."<br>
                            لاستعادة حسابكم برجاء التوجه إلى الرابط التالي وإكمال الإجراءات <br>
                            كود التفعيل: ".$code." <br>
                            <a href='".$data['url']."/employee/active?email=$email'><button style='margin-top:20px;font-size:18px;background-color:#ff5f5f;color:#fff;padding:10px 25px;border-radius:0.7rem;'>استعادة الحساب</button></a>
                        </div>
                        ";
                        if($this->Functions->_PHPMailer('رابط استعادة الحساب', $text_msg, 'mohamy@teraninja.com', $email, 'Mohamy') == true){
                            echo 'true';
                            return true;
                        }
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
    }