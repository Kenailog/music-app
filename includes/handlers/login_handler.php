<?php

if (isset($_POST['loginButton'])) {
    if ($account->login($_POST["loginUsername"], $_POST["loginPassword"])) {
        $_SESSION['logged'] = $_POST["loginUsername"];
        header("Location: index.php");
    }
}
