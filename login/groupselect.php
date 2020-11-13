<?php
session_start();

if (!isset($_SESSION['Username']) || strlen($_SESSION['Username']) == 0) {
  header("Location:index.php");
  exit;
}

//lees het config-bestand
require('../includes/config.inc.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php

  // maak een query voor de database
  $userID = $_SESSION['userID'];
  $query = "SELECT Groupname 
              FROM group 
              WHERE userID = (SELECT userID
                              FROM users
                              WHERE userID = $userID)";

  //voer de query uit
  $result = mysqli_query($mysqli, $query);

  var_dump($result);

  // loop door alle rijen dat heen
  while ($row = mysqli_fetch_array($result)) {
    // start een tabelrij
    echo "<a herf=" . $row['Groupname'] . ">" . $row['Groupname'] . "</a>";

    //sluit de tabelrij
    echo "</tr>";
  }

  // sluit de tabel
  echo "</table>";
  ?>
</body>

</html>