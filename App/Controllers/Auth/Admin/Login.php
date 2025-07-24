<?php

    namespace App\Controllers\Auth\Admin;
    use App\Database\Connection;
    use App\Helpers\TokenCreator;

    class Login {

        protected $conn;
        protected TokenCreator $token;

        public function __construct(TokenCreator $token)
        {
            $this->conn = (new Connection())->DB;
            $this->token = $token;
        }

        public function index() 
        {
            if (!$this->token->check('token', $_POST['csrf'])) return false;
            if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $stmt = $this->conn->prepare("SELECT `id`, `email`, `password`
                                            FROM `admins`
                                            WHERE `email` = :email && `status` = 1
                                            LIMIT 1");
                $stmt->bindParam(":email", $_POST['email']);
                $stmt->execute();
                if($stmt->rowCount() == 1){
                    $data = $stmt->fetch();
                    if (password_verify($_POST['password'], $data['password'])) {
                        self::updateToken($data['id'], $_POST['csrf']);
                        $_SESSION['admin'] = $data['email'];
                        header("location:home");
                        exit();
                    } 
                }
            }
            return true;
        }

        public function updateToken($userid, $token)
        {
            $update = $this->conn->prepare("UPDATE `admins` SET `token` = :token WHERE `id` = :id LIMIT 1");
            $update->bindParam(":token", $token);
            $update->bindParam(":id", $userid);
            $update->execute();
        }

        public function setToken() 
        {
            $token = $this->token->create('token');
            if ($token['status'] === true) {
                return $this->token->store('token', $token['value']);
            }
            return $token['value'];
        }

    }