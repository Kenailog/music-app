<?php
include("../../config.php");
if (isset($_POST['songId'])) {
   $conn->query("UPDATE songs SET plays = plays + 1 WHERE id =" .  $_POST['songId'] . "")  or die($conn->error);
}
