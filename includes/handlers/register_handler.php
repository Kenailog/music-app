<?php

if (isset($_POST['registerButton'])) {
    $username = sanitizeFormUsername($_POST['username']);
    $user_first_name = sanitizeFormString($_POST['userFirstName']);
    $user_last_name = sanitizeFormString($_POST['userLastName']);
    $user_email = sanitizeFormString($_POST['email']);
    $user_email_confirm = sanitizeFormString($_POST['emailConfirm']);
    $password = sanitizeFormPassword($_POST['password']);
    $password_confirm = sanitizeFormPassword($_POST['passwordConfirm']);

    if ($account->register($username, $user_first_name, $user_last_name, $user_email, $user_email_confirm, $password, $password_confirm)) {
        $_SESSION['logged'] = $username;
        header("Location: index.php");
    }
}

function sanitizeFormUsername($input_text)
{
    return str_replace(' ', '', strip_tags($input_text));
}

function sanitizeFormString($input_text)
{
    return ucfirst(strtolower(sanitizeFormUsername($input_text)));
}

function sanitizeFormPassword($input_text)
{
    return strip_tags($input_text);
}
