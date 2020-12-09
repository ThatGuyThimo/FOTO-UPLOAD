<?php
//read the config-file
require('../../../includes/config.inc.php');
session_start();
// check if the user is loggedin

$groupname = basename(__DIR__);

$compare = "SELECT Username
            FROM user
            JOIN users ON users.userID = user.userID
            JOIN groups ON groups.groupID = users.groupID
            WHERE groupname = '$groupname'";

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

?>
<!DOCTYPE html>
<html lang="eng">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../style/output/style.min.css">
  <script src="../../../assets/js/fontawesome.js"></script>
  <title><?php echo $groupname; ?></title>
</head>

<body>
  <div class="Banner">
    <div class="header">Events</div>
    <div>
      <a href="delete_form.html"><i class="fad fa-folder-minus"></i></a>
      <a href="../../groupselect.php">
        <i style="margin-right: 1.5em; cursor: pointer;" class="fad fa-undo"></i>
      </a>
      <a href="../../../includes/logout.inc.php"><i class="fad fa-sign-out-alt"></i></a>
    </div>
  </div>
  <main>
    <div class="groupList">
      <div class="scroll">

        <?php
        // query every userid in relation with the group
        $userID = $_SESSION['userID'];
        $query = "SELECT Eventname
                  FROM event
                  INNER JOIN events ON event.eventID = events.eventID
                  INNER JOIN groups ON events.groupID = groups.groupID
                  WHERE groupname = '$groupname'";
        //execute the query
        $result = mysqli_query($mysqli, $query);

        // loop door alle rijen dat heen
        // make an if loop to check if there is something inside the query
        if (!$result) {
          echo "<h2>There are on event yet...<h2>";
        } else {
          while ($row = mysqli_fetch_array($result)) {
        ?>
            <a href="events/<?php echo $row['Eventname'] ?>">
              <div class="eventItem">
                <div class="event">
                  <?php echo $row['Eventname'] ?>
                </div>
              </div>
            </a>
        <?php
          }
        }
        ?>
      </div>
    </div>
    <form action="" method="post">
      <div class="aanmaak">

        <!-- input the name of the group -->
        <input class="EventInput" type="text" name="Eventname" placeholder="Eventnaam" required="required">
        <div class="Item">
          <input type="submit" name="submit" value="Event aanmaken" id="submit">
        </div>
    </form>
  </main>

  <?php
  if (isset($_POST['submit'])) {

    // put the eventname inside a variable 
    $Eventname = $_POST['Eventname'];

    // insert the event name and id and who made the event
    $EventQuery = "INSERT INTO event VALUES (NULL, '$Eventname')";

    $execute = mysqli_query($mysqli, $EventQuery);

    // get the group id from the database
    $getgroupID = "SELECT groupID FROM groups WHERE Groupname = '$groupname'";

    $getID = mysqli_query($mysqli, $getgroupID);

    // put the group number inside a variable
    $groupID = mysqli_fetch_row($getID);
    $GID = $groupID[0];

    // get the event id from the database
    $geteventID = "SELECT eventID FROM event WHERE Eventname = '$Eventname' ORDER BY eventID DESC";

    $getID = mysqli_query($mysqli, $geteventID);

    // put the group number inside a variable
    $eventID = mysqli_fetch_row($getID);
    $EID = $eventID[0];

    // insert everu user into users with user id and group id
    $createEvents = "INSERT INTO events VALUE($EID, $GID)";
    $done = mysqli_query($mysqli, $createEvents);

    // put the groupname inside a variable
    $Eventname = $_POST["Eventname"];



    // set the right path for the group
    $path = "events/$Eventname/";
    $pathPhotos = "events/$Eventname/photos";

    // create the directory for the new group
    mkdir("$path");
    mkdir("$pathPhotos");

    $indextext = file_get_contents("../../generate/presets/event.php");
    $deletetext = file_get_contents("../../generate/presets/deletePhotos.php");
    $deleteevent = file_get_contents("../../generate/presets/delete_form_event.html");
    $deleteeventphp = file_get_contents("../../generate/presets/delete_event.php");
    $deleteeventajax = file_get_contents("../../generate/presets/event_ajax.js");

    // create index.html in the specified path
    $create_file = fopen($path . "index.php", "w");
    fwrite($create_file, $indextext);
    fclose($create_file);

    // create index.html in the specified path
    $create_file = fopen($path . "deletePhotos.php", "w");
    fwrite($create_file, $deletetext);
    fclose($create_file);

    // create delete_form_event.html in the specified path
    $create_file = fopen($path . "delete_form_event.html", "w");
    fwrite($create_file, $deleteevent);
    fclose($create_file);

    // create delete_event.php in the specified path
    $create_file = fopen($path . "delete_event.php", "w");
    fwrite($create_file, $deleteeventphp);
    fclose($create_file);

    // create event_ajax.js in the specified path
    $create_file = fopen($path . "event_ajax.js", "w");
    fwrite($create_file, $deleteeventajax);
    fclose($create_file);

    // send the user to the new page
    header("location:index.php");
  }
  ?>
</body>

</html>