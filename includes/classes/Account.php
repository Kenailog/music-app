<?php

class Account
{
    private $error_array;
    private $conn;

    public function __construct($conn)
    {
        $this->error_array = array();
        $this->conn = $conn;
    }

    public function register($username, $first_name, $last_name, $email, $email_confirm, $password, $password_confirm)
    {
        $this->validateUserDetails($username, $first_name, $last_name, $email, $email_confirm, $password, $password_confirm);
        if (empty($this->error_array)) {
            return $this->insertUserDetails($username, $first_name, $last_name, $email, $password);
        } else {
            return false;
        }
    }

    public function login($username, $password)
    {
        $password = md5($password);
        if (mysqli_num_rows(mysqli_query($this->conn, "SELECT username FROM users WHERE username = '$username' AND password = '$password'")) == 1) {
            return true;
        } else {
            array_push($this->error_array, Constants::$INVALID_USERNAME_OR_PASSWORD);
            return false;
        }
    }

    private function validateUserDetails($username, $first_name, $last_name, $email, $email_confirm, $password, $password_confirm)
    {
        $this->validateUsername($username);
        $this->validateFirstName($first_name);
        $this->validateLastName($last_name);
        $this->validateEmails($email, $email_confirm);
        $this->validatePasswords($password, $password_confirm);
    }

    private function insertUserDetails($username, $first_name, $last_name, $email, $password)
    {
        $password = md5($password);
        $date = date("Y-m-d");
        $profile_pic = "assets/images/head_emerald.png";
        return mysqli_query($this->conn, "INSERT INTO users VALUES ('', '$username', '$first_name', '$last_name', '$email', '$password', '$date', '$profile_pic')");
    }

    private function validateUsername($username)
    {
        if (strlen($username) < 5  || strlen($username) > 25) {
            array_push($this->error_array, Constants::$USERNAME_LENGTH_ERROR);
            return;
        }

        if (mysqli_num_rows(mysqli_query($this->conn, "SELECT username FROM users WHERE username = '$username'")) > 0) {
            array_push($this->error_array, Constants::$USERNAME_ALREADY_EXISTS);
            return;
        }
    }

    private function validateFirstName($first_name)
    {
        if (strlen($first_name) < 2  || strlen($first_name) > 25) {
            array_push($this->error_array, Constants::$FIRSTNAME_LENGTH_ERROR);
            return;
        }
    }

    private function validateLastName($last_name)
    {
        if (strlen($last_name) < 2  || strlen($last_name) > 25) {
            array_push($this->error_array, Constants::$LASTNAME_LENGTH_ERROR);
            return;
        }
    }

    private function validateEmails($email, $email_confirm)
    {
        if ($email != $email_confirm) {
            array_push($this->error_array, Constants::$EMAILS_DO_NOT_MATCH);
            return;
        }

        if (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
            array_push($this->error_array, Constants::$INVALID_EMAIL);
            return;
        }

        if (mysqli_num_rows(mysqli_query($this->conn, "SELECT email FROM users WHERE email = '$email'")) > 0) {
            array_push($this->error_array, Constants::$EMAIL_ALREADY_EXISTS);
            return;
        }
    }

    private function validatePasswords($password, $password_confirm)
    {
        if ($password != $password_confirm) {
            array_push($this->error_array, Constants::$PASSWORDS_DO_NOT_MATCH);
            return;
        }

        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($this->error_array, Constants::$INVALID_PASSWORD);
            return;
        }

        if (strlen($password) < 5  || strlen($password) > 25) {
            array_push($this->error_array, Constants::$PASSWORD_LENGTH_ERROR);
            return;
        }
    }

    public function getError($error)
    {
        if (!in_array($error, $this->error_array)) {
            $error = '';
        }
        return "<span class='errorMessage'>$error</span>";
    }
}
