<?php
require_once "pdo.php";

session_start();

if (isset($_POST['Cancel'])) {
        header("Location: index.php");
}


if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['headline']) && isset($_POST['summary'])
     && isset($_POST['email']) && isset($_POST['Add']) && isset($_POST['profile_id']) ) {

      if(strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1 || strlen($_POST['email']) < 1 ) {

     	$_SESSION['error'] = "All fields are required";
      header("Location: edit.php?profile_id=" . $_POST["profile_id"]);
      return;

     } else if (false === strpos($_POST['email'], '@')){

      $_SESSION['error'] = "Email must have an at-sign (@)";
      header("Location: edit.php?profile_id=" . $_POST["profile_id"]);
      return;

     } else {

       $stmt = $pdo->prepare('UPDATE Profile SET first_name = :fn, last_name = :an,
        email = :em, headline = :he, summary = :su
        WHERE profile_id = :pid');
       $stmt->execute(array(
           ':pid' => $_POST['profile_id'],
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

if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}


?>
<!DOCTYPE html>
<html>
<head>
<title>LUI Yu On's Profile Edit</title>
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
<h1>Editing Profile for UMSI</h1>
<form method="post" action="edit.php">
  <p>First Name:
              <input type="text" name="first_name" size="60" value="<?php echo $row['first_name'] ?>"/></p>
          <p>Last Name:
              <input type="text" name="last_name" size="60" value="<?php echo $row['last_name'] ?>"/></p>
          <p>Email:
              <input type="text" name="email" size="30" value="<?php echo $row['email'] ?>"/></p>
          <p>Headline:<br/>
              <input type="text" name="headline" size="80" value="<?php echo $row['headline'] ?>"/></p>
          <p>Summary:<br/>
              <textarea name="summary" rows="8" cols="80"><?php echo $row['summary'] ?></textarea>
          <p>
<input type="hidden" name="profile_id" value="<?= $_GET['profile_id'] ?>">
<input type="submit" name="Add" value="Save">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>
