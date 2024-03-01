<?php include "functions.php" ?>
<?php include "../includes/db.php" ?>
<?php ob_start()?>
<?php session_start(); ?>

<?php

if(!isset($_SESSION['user_role'])){
    header("Location: ../index.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin - Bootstrap Admin Template</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/summernote.css" rel="stylesheet"> <!-- Corrected the path -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    
</head>

<body>