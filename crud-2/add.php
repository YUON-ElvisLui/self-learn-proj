<?php
require_once "pdo.php";

session_start();

if ( !isset($_SESSION['name']) && ! isset($_SESSION['user_id']) ) {
    die('ACCESS DENIED');
}

if (isset($_POST['cancel'])) {
        header("Location: index.php");
}

if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['headline']) && isset($_POST['summary']) && isset($_POST['email']) && isset($_POST['Add']) ) {

      if(strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1 || strlen($_POST['email']) < 1 ) {
     	$_SESSION['error'] = "All fields are required";
      header("Location: add.php");
      return;
     }
     else if (false === strpos($_POST['email'], '@')){
      $_SESSION['error'] = "Email must have an at-sign (@)";
      header("Location: add.php");
      return;
     }
     else {
       $stmt = $pdo->prepare('INSERT INTO Profile
           (user_id, first_name, last_name, email, headline, summary)
           VALUES ( :uid, :fn, :an, :em, :he, :su)');
       $stmt->execute(array(
           ':uid' => $_SESSION['user_id'],
           ':fn' => $_POST['first_name'],
           ':an' => $_POST['last_name'],
           ':em' => $_POST['email'],
           ':he' => $_POST['headline'],
           ':su' => $_POST['summary'])
       );
		$_SESSION['success'] = "Record added";
    header("Location: index.php");
    return;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>LUI Yu On's Profile Add</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">

</head>
<body>
<div class="container">
  <?php

  if ( isset($_SESSION['success']) ) {
      	echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
        unset($_SESSION['success']);
  } else if ( isset($_SESSION['error']) ) {
      	echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
  }
  ?>
<h1>Adding Profile for UMSI</h1>
<form method="post">
<p>First Name:
<input type="text" name="first_name" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"/></p>
<p>Email:
<input type="text" name="email" size="30"/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80"/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80"></textarea>
<p>
<input type="submit" name="Add" value="Add">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>
