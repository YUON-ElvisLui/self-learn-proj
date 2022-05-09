<?php
require_once "pdo.php";
session_start();

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

if (isset($_POST['Cancel'])) {
        header("Location: index.php");
}

if ( isset($_POST['model']) && isset($_POST['make']) && isset($_POST['year'])
       && isset($_POST['mileage']) && isset($_POST['autos_id']) ) {

      if(strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) {

     	$_SESSION['error'] = "All fields are required";
      header("Location: edit.php?autos_id=".$_POST['autos_id']);
      return;

     } else if (! is_numeric($_POST['mileage']) ) {

     	$_SESSION['error'] = "Mileage must be numeric";
      header("Location: edit.php?autos_id=".$_POST['autos_id']);
      return;

     } else if (! is_numeric($_POST['year'])) {

     	$_SESSION['error'] = "Year must be numeric";
      header("Location: edit.php?autos_id=".$_POST['autos_id']);
      return;

     } else {

     	$sql = "UPDATE autos SET make = :mk,
            model = :mo, year = :yr, mileage = :mi
            WHERE autos_id = :autos_id";

		  $stmt = $pdo->prepare($sql);

      $stmt->execute(array(
  			':mk' => $_POST['make'],
        ':mo' => $_POST['model'],
  			':yr' => $_POST['year'],
  			':mi' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']
        )
		);

		$_SESSION['success'] = "Record updated";
    header("Location: index.php");
    return;

    }

}


$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$mo = $row['model'];
$mi = $row['mileage'];
$yr = $row['year'];
$mk = $row['make'];
$autos_id = $row['autos_id'];

?>
<h2>Editing Automobile</h2>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $mk ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $mo ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $yr ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $mi ?>"></p>
<input type="hidden" name="autos_id" value="<?= $autos_id ?>">

<p><input type="submit" name="Save" value="Update"/>
<p><input type="submit" name="Cancel" value="Cancel"/>
</form>
