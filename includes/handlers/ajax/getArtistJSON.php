<?php
include("../../config.php");
if (isset($_POST['artistId'])) {
    $query = $conn->query('SELECT * FROM artists WHERE id =' . $_POST['artistId']) or die($conn->error);
    $result = $query->fetch_assoc();
    echo json_encode($result);
}
