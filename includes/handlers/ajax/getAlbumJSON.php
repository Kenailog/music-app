<?php
include("../../config.php");
if (isset($_POST['albumId'])) {
    $query = $conn->query('SELECT * FROM albums WHERE id =' . $_POST['albumId'])  or die($conn->error);
    $result = $query->fetch_assoc();
    echo json_encode($result);
}
