<?php // Do not put any HTML above this line

session_start();
$salt = 'XyZzy12*_';
$stored_hash = hash('md5', $salt.'php123');  // Pw is php123

if ( isset($_POST['email']) && isset($_POST['pass']) ) {

    unset($_SESSION["account"]);

    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {

      $_SESSION['error'] = "User name and password are required";
      header("Location: login.php");
      return;

    } else if (false === strpos($_POST['email'], '@')){

      $_SESSION['error'] = "Email must have an at-sign (@)";
      header("Location: login.php");
      return;

    }
    else {

        $check = hash('md5', $salt.$_POST['pass']);

        if ( $check == $stored_hash ) {

            $_SESSION["account"] = $_POST['email'];
            header("Location: index.php");
            error_log("Login success ".$_POST['email']);
            return;

        } else {

          $_SESSION['error'] = "Incorrect password";
          header("Location: login.php");
          error_log("Login fail ".$_POST['email']." $check");
          return;

        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>
<?php require_once "bootstrap.php"; ?>
<title>LUI Yu On's Login Page</title>
</head>

<body>

<div class="container">
<h1><a>Please Log In</a></h1>

<?php

if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
    unset($_SESSION['error']);
}

?>

<form method="POST">
<label for="nam">User name</label>
<input type="text" name="email" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>

</div>
</body>
