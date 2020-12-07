<?php
session_start();
// check if the user is loggedin
if (!isset($_SESSION['Username']) || strlen($_SESSION['Username']) == 0) {
  header("Location:index.php");
  exit;
}

//read the config-file
require('../../../../../includes/config.inc.php');

// get the groupname
$eventname = basename(__DIR__);

$userID = $_SESSION["userID"];
?>
<!DOCTYPE html>
<html lang="eng">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../../../../style/output/style.css">
  <title><?php echo $eventname; ?></title>
</head>

<body>
  <div class="Banner">
    <!-- get the groupname and eventname -->
    <div class="header"><?php echo $eventname . " - "; ?></div>
    <a href="index.php">Back</a>
  </div>
  <div class="photo's">
    <!-- show all the pictures inside the folder -->
    <?php
    // query every userid in relation with the group
    $query = "SELECT link
                  FROM images
                  INNER JOIN event ON event.eventID = images.eventID
                  WHERE Eventname = '$eventname' AND userID = $userID";
    //execute the query
    $result = mysqli_query($mysqli, $query);

    // loop door alle rijen dat heen
    // make an if loop to check if there is something inside the query
    if (!$result) {
      echo "<h2>There are on event yet...<h2>";
    } else {
      while ($row = mysqli_fetch_array($result)) {
    ?>
        <input type="checkbox" name="" id=""><img src="<?php echo "../$eventname/photos/" . $row['link']; ?>" alt="" srcset="" style="width: 50px;"></input>
        
    <?php
      }
    }
    ?>
  </div>
  <form method="post" enctype="multipart/form-data">
    <input type="file" name="photo" id="photo">
    <input type="submit" name="submit" id="submit">
  </form>
</body>

</html>
<?php
if (isset($_POST['submit'])) {
  if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $map = __DIR__ . "/photos/";

    $file = $_FILES['photo']['name'];

    move_uploaded_file($_FILES['photo']['tmp_name'], $map . $file);

    $searchID = "SELECT eventID
              FROM event
              WHERE Eventname = '$eventname'";
    //execute the query
    $newsearchID = mysqli_query($mysqli, $searchID);

    echo $eventname;

    $raweventID = mysqli_fetch_array($newsearchID);

    $eventID = $raweventID['eventID']; 

    $upload = "INSERT INTO images VALUES (NULL, '$file', $userID, $eventID)";

    $execute = mysqli_query($mysqli, $upload);

    header("Location:index.php");
  }
}
?>