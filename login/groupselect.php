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
              WHERE userID IN (SELECT userID
                              FROM users
                              WHERE userID = $userID)";

  //voer de query uit
  $result = mysqli_query($mysqli, $query);

  // loop door alle rijen dat heen
  while ($row = mysqli_fetch_array($result)) {
    echo "<a href=" . $row['Groupname'] . ">" . $row['Groupname'] . "</a><br>";
  }
  ?>
  <form action="" method="post">
    <input type="text" name="Groupname" placeholder="Groupname" require>
    <div class="list">
      <?php
      // maak een query voor de database
      $query = "SELECT userID, Username FROM user";

      //voer de query uit
      $result = mysqli_query($mysqli, $query);

      // loop door alle rijen dat heen
      while ($row = mysqli_fetch_array($result)) {
        echo "<button>" . $row['Username'] . "<input type='checkbox' name='member[]' id='" . $row['userID'] . "' value='" . $row['userID'] . "'></button>";
      }
      ?>
    </div>
    <input type="submit" name="submit" value="submit" id="submit">
  </form>
  <?php
  if (isset($_POST['submit'])) {
    // make table groups
    $Groupname = $_POST['Groupname'];

    $groupQuery = "INSERT INTO groups VALUES ($userID,'$Groupname',NULL)";

    $execute = mysqli_query($mysqli, $groupQuery);
    // get the group id
    $getgroupID = "SELECT groupID FROM groups WHERE Groupname = '$Groupname'";

    $getID = mysqli_query($mysqli, $getgroupID);

    $groupID = mysqli_fetch_row($getID);
    $GID = $groupID[0];
    // $groupID[0]
    // insert user into users with user id and group id

    $array = $_POST['member'];
    foreach ($array as $member => $value) {
      $createUsers = "INSERT INTO users VALUE($value, $GID)";
      $done = mysqli_query($mysqli, $createUsers);
    }
    require "//generate/generate.php";
  }
  ?>
</body>

</html>