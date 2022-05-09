<?php
require_once "pdo.php";

session_start();
if ( ! isset($_SESSION['account']) ) {
    die('ACCESS DENIED');
}

if (isset($_POST['cancel'])) {
        header("Location: index.php");
}

if ( isset($_POST['model']) && isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['Add']) ) {

      if(strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {

     	$_SESSION['error'] = "All fields are required";
      header("Location: add.php");
      return;

     } else if (! is_numeric($_POST['mileage']) ) {

     	$_SESSION['error'] = "Mileage must be numeric";
      header("Location: add.php");
      return;

     } else if (! is_numeric($_POST['year'])) {

     	$_SESSION['error'] = "Year must be numeric";
      header("Location: add.php");
      return;

     } else {

    $sql = "INSERT INTO autos (make, year, mileage, model)
              VALUES (:mk, :yr, :mi, :mo)";
		$stmt = $pdo->prepare('INSERT INTO autos
  		(make, year, mileage, model) VALUES ( :mk, :yr, :mi, :mo)');
		$stmt->execute(array(
  			':mk' => $_POST['make'],
  			':yr' => $_POST['year'],
  			':mi' => $_POST['mileage'],
        ':mo' => $_POST['model'])
		);
		$_SESSION['success'] = "Record added";
    header("Location: index.php");
    return;
    }

}


?>
<!DOCTYPE html>

<!-- view code -->

<html>
<head>
<title>LUI Yu On Automobile Tracker</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
  <?php
  if ( isset($_SESSION["account"]) ) {
  		  echo "<h1>Tracking Automobiles for ";
      	echo htmlentities($_SESSION["account"]);
      	echo "</h1>";
      }

  if ( isset($_SESSION['success']) ) {
      	echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
        unset($_SESSION['success']);
  } else if ( isset($_SESSION['error']) ) {
      	echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
  }
  ?>

  <form method="post">
  <p>Make:
  <input type="text" name="make" size="60"></p>
  <p>Model:
  <input type="text" name="model"></p>
  <p>Year:
  <input type="text" name="year"></p>
  <p>Mileage:
  <input type="text" name="mileage"></p>

  <p><input type="submit" name="Add" value="Add"/>
  <input type="submit" name="cancel" value="cancel">
  </p>

  </form>

</div>
</body>
</html>
