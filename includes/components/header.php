
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(@$settings == true){ 
    require(dirname(__DIR__)."/../config.php");  
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title><?php if(isset($page_title) && !empty($page_title)){echo $page_title;}else{echo 'تكنو بوند';}?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="author" content="تكنو بوند">
    <meta name="theme-color" content="#fbfbfb">
    <meta name="description" content="تكنو بوند" />
    <meta name="keywords" content="تكنو بوند">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $url ?>/includes/layouts/css/slim-select.css">
    <link rel="stylesheet" href="<?= $url ?>/includes/layouts/css/toast.min.css">
    <script type="text/javascript" src="<?= $url ?>/includes/layouts/js/toast.js"></script>
    <link rel="stylesheet" href="<?= $url ?>/includes/layouts/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $url ?>/includes/layouts/css/style.css?new3">
</head>
<body dir="rtl" <?= isset($background) ?  "style='background:$background !important'" : '' ; ?>>
<?php } ?>