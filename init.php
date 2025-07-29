<?php 

    require_once __DIR__ . '/shared/bootstrap.php';
    if (!isset($dynamicTitle)) {
        require("public/components/header.php");
        include('public/components/navbar.php');
    }