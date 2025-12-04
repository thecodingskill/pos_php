
<?php
require '../config/function.php';
require 'authentication.php';
// call only in the header others that use header.php also can use this function
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/jpeg" sizes="256x256" href="../admin/assets/img/logo.jpg">
    <title>Fashion POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />

    <link href="assets/css/styles.css" rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/custom.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />  <!-- form Select 2  = JQeury -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css"/> <!-- Alertify Css -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css"/> <!-- Alertify Css -->
</head>

<body class="sb-nav-fixed">

    <?php include('navbar.php');?>

    <div id="layoutSidenav">

        <?php include('sidebar.php'); ?>

        <div id="layoutSidenav_content">
            <main>