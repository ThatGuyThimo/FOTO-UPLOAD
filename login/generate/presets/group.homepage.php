<?php
//read the config-file
require('../../../includes/config.inc.php');
session_start();
// check if the user is loggedin

$groupname = basename(__DIR__);
$usertest = $_SESSION['userID'];
$ownercheck = "SELECT userID FROM groups WHERE Groupname = '$groupname'";
$owner = mysqli_query($mysqli, $ownercheck);

// $kaas = mysqli_query($mysqli, $ownercheck);
// var_dump($kaas);

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
  <title><?php echo $groupname; ?> - JXT</title>
</head>

<body>
  <div class="Banner">
    <div class="header">Events</div>
    <div>
    <?php
      //this is terrible code and formating.... too bad!
      while ($row = $owner->fetch_assoc()) {
      if ($row['userID'] == $usertest)  
      {?>
      <a href="delete_form.html"><i class="fad fa-folder-minus"></i></a>
      <?php }}?>
      <a title="terug" href="../../groupselect.php">
        <i style="margin-right: 1.5em; cursor: pointer;" class="fad fa-undo"></i>
      </a>
      <a title="log uit" href="../../../includes/logout.inc.php"><i class="fad fa-sign-out-alt"></i></a>
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
          echo "<h2>There are no event yet...<h2>";
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
<svg class="BackgroundSVG" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="var(--backgroundSVG)" fill-opacity="1" d="M0,64L34.3,85.3C68.6,107,137,149,206,176C274.3,203,343,213,411,186.7C480,160,549,96,617,96C685.7,96,754,160,823,165.3C891.4,171,960,117,1029,101.3C1097.1,85,1166,107,1234,112C1302.9,117,1371,107,1406,101.3L1440,96L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path></svg>
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