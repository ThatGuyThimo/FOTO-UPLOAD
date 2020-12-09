<?php
//read the config-file
require('../../../../../includes/config.inc.php');
session_start();
// check if the user is loggedin

$eventname = basename(__DIR__);

$compare = "SELECT Username
            FROM user
            JOIN users ON users.userID = user.userID
            JOIN groups ON groups.groupID = users.groupID
            JOIN events ON events.groupID = groups.groupID
            JOIN event ON event.eventID = events.eventID
            WHERE Eventname = '$eventname'";

$acces = mysqli_query($mysqli, $compare);
$check = false;
while ($names = mysqli_fetch_array($acces)) {
  if (strtolower($_SESSION['Username']) == strtolower($names['Username'])) {
    $check = true;
  } else if ($check != true) {
    $check = false;
  }
}

if ($check == false) {
  header("Location:../../inlog.php");
  exit;
}


$userID = $_SESSION['userID'];
?>
<!DOCTYPE html>
<html lang="eng">

<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../../../style/output/style.min.css">
  <script src="../../../../../assets/js/fontawesome.js"></script>
  <title><?php echo $eventname; ?></title>
</head>

<body>
  <div class="Banner">
    <!-- get the groupname and eventname -->
    <div class="header"><?php echo $eventname; ?></div>
    <div> 
      <a href="delete_form_event.html"><i class="fad fa-folder-minus"></i></a>
      <a href="deletePhotos.php"><i class="fad fa-sliders-h"></i></a>
      <i onclick="window.history.back();" style="margin-right: 1.5em; cursor: pointer;" class="fad fa-undo"></i>
      <a href="../../../../../includes/logout.inc.php"><i class="fad fa-sign-out-alt"></i></a>
    </div>
  </div>
  <div class="photos">
    <!-- show all the pictures inside the folder -->
    <?php
    // query every userid in relation with the group
    $query = "SELECT link
                  FROM images
                  INNER JOIN event ON event.eventID = images.eventID
                  WHERE Eventname = '$eventname'";
    //execute the query
    $result = mysqli_query($mysqli, $query);

    // loop door alle rijen dat heen
    // make an if loop to check if there is something inside the query
    if (!$result) {
      echo "<h2>There are on event yet...<h2>";
    } else {
      while ($row = mysqli_fetch_array($result)) {
    ?>
        <div class="Tile">
          <img src="<?php echo "../$eventname/photos/" . $row['link']; ?>" alt="" srcset="">
          <a href="<?php echo "../$eventname/photos/" . $row['link']; ?>">Bekijk afbeelding</a>
        </div>
    <?php
      }
    }
    ?>
  </div>
  <main>
    <form class="fotoForm" method="post" enctype="multipart/form-data">
      <input class="fotoInput" type="file" name="photo[]" id="photo" multiple>
      <input class="fotoSubmit" type="submit" name="submit" id="submit" value="Upload Foto's">
    </form>
  </main>

</body>

</html>
<?php
if (isset($_POST['submit'])) {


  foreach ($_FILES['photo']['name'] as $key => $val) {
    $map = __DIR__ . "/photos/";

    $file = $_FILES['photo']['name'][$key];

    move_uploaded_file($_FILES['photo']['tmp_name'][$key], $map . $file);

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
  }

  header("Location:index.php");
}
?>