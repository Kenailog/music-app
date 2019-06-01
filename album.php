<?php
include("includes/header.php");
include("includes/classes/Artist.php");


if (!isset($_SESSION['logged'])) {
    header("Location: register.php");
}

isset($_GET['id']) ? $album_id = htmlspecialchars($_GET['id']) : header("Location: index.php");

$album_id = $conn->real_escape_string($album_id);
$query = $conn->query("SELECT * FROM albums WHERE id = '$album_id'") or die($conn->error);

$artist_id = $query->fetch_array();

$artist = new Artist($conn, $artist_id['id']);

echo $artist->getName();
include("includes/footer.php");
