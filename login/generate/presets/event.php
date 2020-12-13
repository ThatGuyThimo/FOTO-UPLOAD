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

mysqli_result();

$userID = $_SESSION['userID'];
?>
<!DOCTYPE html>
<html lang="eng">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../../../style/output/style.min.css">
  <script src="../../../../../assets/js/fontawesome.js"></script>
  <title><?php echo $eventname; ?> - JXT</title>
</head>

<body>
  <div class="Banner">
    <!-- get the groupname and eventname -->
    <div class="header"><?php echo $eventname; ?></div>
    <div>
      <a title="verwijder event" href="delete_form_event.html"><i class="fad fa-folder-minus"></i></a>
      <a title="verwijder foto's" href="deletePhotos.php"><i class="fad fa-sliders-h"></i></a>
      <a href="../../">
        <i style="margin-right: 1.5em; cursor: pointer;" class="fad fa-undo"></i>
      </a>
      <a title="log uit" href="../../../../../includes/logout.inc.php"><i class="fad fa-sign-out-alt"></i></a>
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
      <input class="fotoInput" type="file" name="photo[]" id="photo" multiple required>
      <input class="fotoSubmit" type="submit" name="submit" id="submit" value="Upload Foto's">
    </form>
  </main>
  <svg class="BackgroundSVG" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="var(--backgroundSVG)" fill-opacity="1" d="M0,256L48,229.3C96,203,192,149,288,154.7C384,160,480,224,576,218.7C672,213,768,139,864,128C960,117,1056,171,1152,197.3C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>

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