<?php
require('config.php');
// get user
$email = removeSQLDelimitersFrom($_GET['email']);
$password = removeSQLDelimitersFrom($_GET['password']);

checkExists("psyco", $conn, $email, $password);


// get chats
$otherEmail = removeSQLDelimitersFrom($_GET['otherEmail']);
$psyco_query = "SELECT
    user_email AS otherEmail,
    nome,
    cognome,
    testo,
    data,
    gravita,
    CASE WHEN sender = 0 THEN 1 WHEN sender = 1 THEN 0
END AS sender
FROM
    messaggio join utente on user_email=email
WHERE
    psyco_email = '$email' AND user_email = '$otherEmail'
ORDER BY DATA
DESC
";
$result = mysqli_query($conn, $psyco_query);

if (!$result) {
  die(mysqli_error($conn));
}

$rows = array();
while ($row = mysqli_fetch_assoc($result)) {
  $rows[] = $row;
}

echo json_encode($rows);

mysqli_free_result($result);
mysqli_close($conn);