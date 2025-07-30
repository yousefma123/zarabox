<?php 

    use App\Controllers\Home\Home;
    require_once __DIR__ . '/shared/bootstrap.php';
    $home = new Home();

    if (!isset($dynamicTitle)) {
        require("public/components/header.php");
        include('public/components/navbar.php');
    }