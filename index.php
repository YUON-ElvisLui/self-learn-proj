<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['account']) ) {
    die('Not logged in');
    header("welcome.php");
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
if ( isset($_SESSION['name']) ) {
		  echo "<h1> Welcome to the Automobiles Database";
    	echo "</h1>";
    }
?>

<h2>Welcome to the Automobiles Database</h2>

<?php
if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
} else if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>


<?php
$stmt = $pdo->query("SELECT make, year, mileage, model FROM autos");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ){
  echo("<p>No rows found</p>");
}
else {
$stmt = $pdo->query("SELECT make, year, mileage, model, autos_id FROM autos");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo("<table border=1> <thead><tr>
<th>Make</th>
<th>Model</th>
<th>Year</th>
<th>Mileage</th>
<th>Action</th>
</tr></thead>");
$stmt = $pdo->query("SELECT make, year, mileage, model, autos_id FROM autos");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

  echo "<tr><td>";
  echo(htmlentities($row['make']));
  echo("</td><td>");
  echo(htmlentities($row['model']));
  echo("</td><td>");
  echo(htmlentities($row['year']));
  echo("</td><td>");
  echo(htmlentities($row['mileage']));
  echo("</td><td>");
  echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit </a> / ');
  echo('<a href="delete.php?autos_id='.$row['autos_id'].'"> Delete</a>');
  echo("</td></tr>\n");

}
}
?>
</table>
<p>
<a href="add.php">Add New Entry</a>
<a href="logout.php">Logout</a>
</p>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</div>
</html>
