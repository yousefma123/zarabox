<?php

    session_start();
    use Dotenv\Dotenv;
    use App\Helpers\Statement;
    require_once __DIR__ . '/../shared/bootstrap.php';
    if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])){
        $user = $_SESSION['admin'];
        $statement = new Statement();
        $checkUser = $statement->select("*", "`admins`", "fetch", "WHERE `email` = '$user' && `token` = '".$_SESSION['token']."' && `status` = 1");
        if($checkUser['rowCount'] == 1){
            $dash = true;
            $myData = $checkUser['fetch'];
            $dir_name = "admin";
        }else{
            header("location:../logout");
            die();
        } 
    }else{
        header("location:../logout");
        die();
    } 
