<?php
include("includes/header.php");

if (!isset($_SESSION['logged'])) {
    header("Location: register.php");
}

isset($_GET['id']) ? $album_id = htmlspecialchars($_GET['id']) : header("Location: index.php");

$album_id = $conn->real_escape_string($album_id);
$query = $conn->query("SELECT * FROM albums al JOIN artists ar ON ar.id = al.id WHERE al.id = '$album_id'");

while($row = $query->fetch_array()) {
    echo $row['title'];
    echo $row['name'];
}

include("includes/footer.php");
