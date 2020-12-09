<?php
//read the config-file
require('../../../../../includes/config.inc.php');
session_start();
// check if the user is loggedin

$eventname = basename(__DIR__);

$userID = $_SESSION["userID"];
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
    <div class="header"><?php echo $eventname ?></div>
    <div>
    <a href="../<?php echo $eventname?>">
      <i style="margin-right: 1.5em; cursor: pointer;" class="fad fa-undo"></i>
    </a>
    </div>
  </div>
  <main>
    <form method="post" class="formPhotoEdit">
      <div class="photosEdit">
        <!-- show all the pictures inside the folder -->
        <?php
        // query every userid in relation with the group
        $query = "SELECT link, ID
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
            <div class="Tile">
              <input type="checkbox" name="<?php echo 'photo[]' ?>" id="<?php echo $row['ID'] ?>" value="<?php echo $row['ID'] ?>">
              <label for="<?php echo $row['ID'] ?>">
                <img src="<?php echo "../$eventname/photos/" . $row['link']; ?>" for="<?php echo $row['ID'] ?>" alt="" srcset="">
              </label>
            </div>

        <?php
          }
        }
        ?>
      </div>

      <input class="deletePhotoBtn" type="submit" name="submit" value="verwijder" id="submit">
    </form>
  </main>
</body>

</html>
<?php
if (isset($_POST['submit'])) {

  // delete the photo out of the database
  $array = $_POST['photo'];
  foreach ($array as $photo => $value) {
    // get the name of the photo
    $getname = "SELECT link
              FROM images
              WHERE ID = $value";
    $sendquery = mysqli_query($mysqli, $getname);
    // get the 
    $rawname = mysqli_fetch_array($sendquery);

    $filename = $rawname['link'];

    unlink("photos/" . $filename);

    $deletephoto = "DELETE FROM images WHERE ID = $value";
    $done = mysqli_query($mysqli, $deletephoto);
  }

  header("Location:index.php");
}
?>