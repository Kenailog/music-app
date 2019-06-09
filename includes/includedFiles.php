<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    include_once('includes/config.php');
    include_once("includes/classes/Artist.php");
    include_once("includes/classes/Album.php");
    include_once("includes/classes/Song.php");
} else {
    include_once("includes/header.php");
    include_once("includes/footer.php");

    echo "<script>loadContent('" . $_SERVER['REQUEST_URI'] . "')</script>";
    exit;
}
