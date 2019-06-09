<?php
include_once('includes/config.php');
include_once("includes/classes/Artist.php");
include_once("includes/classes/Album.php");
include_once("includes/classes/Song.php");

isset($_SESSION['logged']) ? $username = $_SESSION['logged'] : header("Location: register.php");
echo "<script>username = '$username'</script>";
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
            <?php include_once("includes/navBarContainer.php"); ?>

            <div id="mainViewContainer">
                <div id="mainContent">