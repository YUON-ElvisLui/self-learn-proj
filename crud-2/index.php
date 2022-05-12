<?php
require_once "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>

<title>LUI Yu On's Resume Registry</title>

<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">

<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">

<link rel="stylesheet"
    href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">

<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>

</head>
<body>
<div class="container">

<h2>LUI Yu On's Resume Registry</h2>
<?php
if ( ! isset($_SESSION['name']) && ! isset($_SESSION['user_id'])) {
    echo('<p><a href="login.php">Please log in</a></p>');
}
?>

<?php
if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
} else if ( isset($_SESSION['error']) ) {
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>

<?php
$stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, email, headline, summary FROM Profile");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row !== false ){
$stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, email, headline, summary FROM Profile");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo("<table border=1> <tr><th>Name</th><th>Headline</th><th>Action</th><tr>
<tr><td>");
$stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, email, headline, summary FROM Profile");

while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
  echo("<tr><td>");
  echo("<a href=view.php?profile_id=");
  echo($row['profile_id'].">");
  echo(htmlentities($row['first_name'])." ".htmlentities($row['last_name'])."</a>");
  echo("</td><td>");
  echo(htmlentities($row['headline']));
  echo("</td><td>");
  echo("<a href=edit.php?profile_id=");
  echo($row['profile_id'].">Edit</a> <a href=delete.php?profile_id=");
  echo($row['profile_id'].">Delete</a></td></tr>");
  echo("\n");
}

}
?>
</table>
<p><a href="add.php">Add New Entry</a></p>
<p>
<b>Note:</b> Your implementation should retain data across multiple
logout/login sessions.  This sample implementation clears all its
data periodically - which you should not do in your implementation.
</p>
</div>
</body>
