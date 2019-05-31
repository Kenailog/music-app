<?php
include('includes/config.php');
include('includes/classes/Account.php');
include('includes/classes/Constans.php');

$account = new Account($conn);

include('includes/handlers/register_handler.php');
include('includes/handlers/login_handler.php');

if (isset($_SESSION['logged'])) {
  header("Location: index.php");
}

function getInputValue($input)
{
  if (isset($_POST[$input])) {
    echo $_POST[$input];
  }
}

?>

<!DOCTYPE html>

<head>
  <title>Apllication</title>
  <link rel="stylesheet" rel="text/css" href="assets/css/register.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="assets/scripts/register.js"></script>
</head>

<body>

  <?php
  isset($_POST["registerButton"]) ?
    print("<script>
                $(document).ready(function () {
                    $(\"#loginForm\").hide();
                    $(\"#registerForm\").show();
                });
            </script>")
    : print("<script>
                 $(document).ready(function () {
                    $(\"#loginForm\").show();
                    $(\"#registerForm\").hide();
                });
            </script>");
  ?>

  <div id="background">
    <div id="loginContainer">
      <div id="inputContainer">
        <form id="loginForm" action="register.php" method="post">
          <h2>Log in to your account</h2>
          <p>
            <?php echo $account->getError(Constants::$INVALID_USERNAME_OR_PASSWORD); ?>
            <label for="loginUsername">Username</label>
            <input type="text" id="loginUsername" name="loginUsername" placeholder="Username" value="<?php echo  getInputValue('loginUsername') ?>" required>
          </p>
          <p>
            <label for="loginPassword">Password</label>
            <input type="password" id="loginPassword" name="loginPassword" placeholder="password" value="<?php echo  getInputValue('loginPassword') ?>" required>
          </p>
          <button type="submit" name="loginButton">Log In</button>

          <div class="hasAccountText">
            <span id="hideLogin">Don't have an account? Sign up.</span>
          </div>
        </form>

        <form id="registerForm" action="register.php" method="post">
          <h2>Register</h2>
          <p>
            <?php echo $account->getError(Constants::$USERNAME_LENGTH_ERROR); ?>
            <?php echo $account->getError(Constants::$USERNAME_ALREADY_EXISTS); ?>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" value="<?php getInputValue('username') ?>" required>
          </p>
          <p>
            <?php echo $account->getError(Constants::$FIRSTNAME_LENGTH_ERROR); ?>
            <label for="userFirstName">Name</label>
            <input type="text" id="userFirstName" name="userFirstName" placeholder="First name" value="<?php getInputValue('userFirstName') ?>" required>
          </p>
          <p>
            <?php echo $account->getError(Constants::$LASTNAME_LENGTH_ERROR); ?>
            <label for="userLastName">Last Name</label>
            <input type="text" id="userLastName" name="userLastName" placeholder="Last name" value="<?php getInputValue('userLastName') ?>" required>
          </p>
          <p>
            <?php echo $account->getError(Constants::$EMAILS_DO_NOT_MATCH); ?>
            <?php echo $account->getError(Constants::$EMAIL_ALREADY_EXISTS); ?>
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="email" value="<?php getInputValue('email') ?>" required>
          </p>
          <p>
            <label for="emailConfirm">Confirm e-mail</label>
            <input type="email" id="emailConfirm" name="emailConfirm" placeholder="email" value="<?php getInputValue('emailConfirm') ?>" required>
          </p>
          <p>
            <?php echo $account->getError(Constants::$INVALID_PASSWORD); ?>
            <?php echo $account->getError(Constants::$PASSWORDS_DO_NOT_MATCH); ?>
            <?php echo $account->getError(Constants::$PASSWORD_LENGTH_ERROR); ?>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="password" value="<?php getInputValue('password') ?>" required>
          </p>
          <p>
            <label for="passwordConfirm">Confirm password</label>
            <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="password" value="<?php getInputValue('passwordConfirm') ?>" required>
          </p>
          <button type="submit" name="registerButton">Sign Up</button>

          <div class="hasAccountText">
            <span id="hideRegister">You already have an account? Log in here.</span>
          </div>
        </form>
      </div>

      <div id="loginText">
        <h1>Music for everyone. Discover tons of songs for free</h1>
      </div>
    </div>
  </div>
</body>
<html>