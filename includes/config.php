<?php
ob_start();
session_start();
$timezone = date_default_timezone_set("EUROPE/WARSAW");
$conn = mysqli_connect("localhost", "root", "", "musicapp") or die("Failed to connect database: " . mysqli_connect_errno());
