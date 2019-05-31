<?php
include('includes/config.php');

isset($_SESSION['logged']) ? $username = $_SESSION['logged'] : header("Location: register.php");

?>

<!DOCTYPE html>

<head>
    <title>Main</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
    <div id="mainContainer">

        <div id="topContainer">
            <?php include("includes/navBarContainer.php"); ?>

            <div id="mainViewContainer">
                <div id="mainContent">