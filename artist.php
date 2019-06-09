<?php
include_once("includes/includedFiles.php");

if (!isset($_SESSION['logged'])) {
    header("Location: register.php");
}

isset($_GET['id']) ? $artist_id = htmlspecialchars($_GET['id']) : header("Location: index.php");

$artist_id = $conn->real_escape_string($artist_id);
$result = $conn->query("SELECT * FROM artists WHERE id = '$artist_id'") or die($conn->error);
$artist = $result->fetch_array();

$artist = new Artist($conn, $artist['id']);

?>

<div class="entityInfo">
    <?php
    echo $artist->getName();
    ?>
    <button>Play</button>
</div>