<?php
include("../../config.php");
if (isset($_POST['songId'])) {
    $query = $conn->query('SELECT * FROM songs WHERE id =' . $_POST['songId']) or die($conn->error);
    $result = $query->fetch_assoc();
    echo json_encode($result);
}
