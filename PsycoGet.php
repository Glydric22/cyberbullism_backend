<?php
require('config.php');
$email = removeSQLDelimitersFrom($_GET['email']);
$password = removeSQLDelimitersFrom($_GET['password']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL))
  die("invalid-email");

$result = mysqli_query($conn, "select * from psyco where email='$email' and password='$password'");
if (!$result) {
  echo (mysqli_error($conn));
}
if (mysqli_num_rows($result) > 0) {
  $row[] = mysqli_fetch_assoc($result);
  echo json_encode($row[0]);
} else
  die("user-not-found");

mysqli_free_result($result);
mysqli_close($conn);