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
              FROM groups
              WHERE userID = (SELECT userID
                              FROM users
                              WHERE userID = $userID)";

  //voer de query uit
  $result = mysqli_query($mysqli, $query);

  // loop door alle rijen dat heen
  while ($row = mysqli_fetch_array($result)) {
    echo "<a href=" . $row['Groupname'] . ">" . $row['Groupname'] . "</a>";
  }
  ?>
  <form action="" method="post">
    <input type="text" placeholder="Groupname">
    <div class="list">
      <?php
      // maak een query voor de database
      $query = "SELECT userID, Username FROM user";

      //voer de query uit
      $result = mysqli_query($mysqli, $query);

      // loop door alle rijen dat heen
      while ($row = mysqli_fetch_array($result)) {
        echo "<button>" . $row['Username'] . "<input type='checkbox' name='checkbox" . $row['userID'] . "' id='" . $row['userID'] . "' value='true' ></button>";
      }
      ?>
    </div>
    <input type="submit" value="submit">
  </form>
  <?php
  if (isset($_POST['submit'])) {
    echo $_POST['checkbox'];
    if ($_POST['checkbox'] == 'true') {
      echo "true";
    }
    // $Groupname = $_POST['Groupname'];
    // $groupQuery = "INSERT INTO groups VALUES ($userID,$Groupname,NULL)";

    // $execute = mysqli_query($mysqli, $groupQuery);
  }
  ?>
</body>

</html>