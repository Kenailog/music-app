<?php
include('includes/config.php');
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");

isset($_SESSION['logged']) ? $username = $_SESSION['logged'] : header("Location: register.php");

?>

<!DOCTYPE html>

<head>
    <title>Main</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="assets/scripts/script.js"></script>
</head>

<body>
    <div id="mainContainer">

        <div id="topContainer">
            <?php include("includes/navBarContainer.php"); ?>

            <div id="mainViewContainer">
                <div id="mainContent">