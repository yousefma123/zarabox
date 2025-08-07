
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(@$settings == true){ 
    // require(dirname(__DIR__)."/../config.php");  
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title><?php if(isset($page_title) && !empty($page_title)){echo $page_title;}else{echo 'ZaraBox';}?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="author" content="ZaraBox">
    <meta name="theme-color" content="#fbfbfb">
    <meta name="description" content="<?= isset($page_description) ? $page_description : 'Zarabox description' ; ?>" />
    <meta name="keywords" content="ZaraBox">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= public_url('layouts/css') ?>/toast.min.css">
    <script type="text/javascript" src="<?= public_url('layouts/js') ?>/toast.js"></script>
    <link rel="stylesheet" href="<?= public_url('layouts/css') ?>/bootstrap.min.css">

    <link rel="stylesheet" href="<?= public_url('layouts/css') ?>/owl-carousel.css">
    <link rel="stylesheet" href="<?= public_url('layouts/css') ?>/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= public_url('layouts/css') ?>/all.min.css">
    <link rel="stylesheet" href="<?= public_url('layouts/css') ?>/pe-icons.css">
    <link rel="stylesheet" href="<?= public_url('layouts/css') ?>/style.css?new3">

</head>
<body dir="rtl" <?= isset($background) ?  "style='background:$background !important'" : '' ; ?>>
<?php } ?>