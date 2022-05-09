<?php
require_once "pdo.php";

if ( strlen($_POST['who']) < 1 ){
  die("Name parameter missing");
}

if ( isset($_POST['logout'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

if ( !is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) ) {
    $failure = "Mileage and year must be numeric";
} else if ( strlen($_POST['make']) < 1 ){
    $failure = "Make is required";
} else {
  $failure = false;
  $success = false;
}

if ( $failure === false ) {
    $sql = "INSERT INTO autos (make, year, mileage)
              VALUES (:mk, :yr, :mi)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage']));
    $success = 'Record inserted';
}

?>
<!DOCTYPE html>
<html>
<head>
<title>LUI Yu On's Automobile Tracker</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">
<?php
echo '<h1>Tracking Autos for $_POST['who']</h1>';
if ($failure !== false){
  echo '<p style="color: red;">$failure</p>';
}
else if ($success !== false){
  echo '<p style="color: green;">$success</p>';
}
?>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>

<h2>Automobiles</h2>
<ul>
<p>
</ul>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script></body>
</html>
