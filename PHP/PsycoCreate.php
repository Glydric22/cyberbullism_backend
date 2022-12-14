<?php
require('config.php');
require('PsycoCheckAlbo.php');
$nome = removeSQLDelimitersFrom($_POST['nome']);
$cognome = removeSQLDelimitersFrom($_POST['cognome']);
$email = removeSQLDelimitersFrom($_POST['email']);
$password = removeSQLDelimitersFrom($_POST['password']);

//controlli generici di input
if (!filter_var($email, FILTER_VALIDATE_EMAIL))
  die("invalid-email");

if (!$password)
  die("empty-password");

checkPsyco($nome, $cognome, $email);

// controlla che l'utente non esista già
$result = mysqli_query($conn, "select * from psyco where email='$email' and password='$password'");
if (!$result) {
  echo (mysqli_error($conn));
}
if (mysqli_num_rows($result) != 0)
  die("email-already-in-use");

// inserisce l'utente in quanto non sono stati trovati problemi
if (!mysqli_query($conn, "insert into psyco(email,nome,cognome,password) values('$email', '$nome', '$cognome', '$password')")) {
  echo (mysqli_error($conn));
}
mysqli_close($conn);
