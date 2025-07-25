<?php

    session_start();
    require_once __DIR__ . '/../shared/bootstrap.php';
    use Dotenv\Dotenv;
    use App\Helpers\Statement;
    use App\Helpers\Paginator;
    if(isset($_SESSION['admin']) && !empty($_SESSION['admin'])){
        $user = $_SESSION['admin'];
        $statement = new Statement();
        $checkUser = $statement->select("*", "`admins`", "fetch", "WHERE `email` = '$user' && `token` = '".$_SESSION['token']."' && `status` = 1");
        if($checkUser['rowCount'] == 1){
            $dash = true;
            require( PUBLIC_PATH . '/components/dashboard/header.php' );
            include( PUBLIC_PATH . '/components/dashboard/navbar.php' );
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
