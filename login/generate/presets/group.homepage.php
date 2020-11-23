<?php
session_start();
// check if the user is loggedin
if (!isset($_SESSION['Username']) || strlen($_SESSION['Username']) == 0) {
  header("Location:index.php");
  exit;
}

//read the config-file
require('../../../includes/config.inc.php');

// get the groupname
$groupname = basename(__DIR__);
?>
<!DOCTYPE html>
<html lang="eng">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../../style/style.css">
  <script src="script.js"></script>
  <title><?php echo $groupname; ?></title>
</head>

<body>
  <div class="Banner">
    <div class="header">Events</div>
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
                  WHERE groupname = $groupname";
        //execute the query
        $result = mysqli_query($mysqli, $query);

        var_dump(mysqli_query($mysqli, $query));
        var_dump($mysqli);
        var_dump($groupname);
        // loop door alle rijen dat heen
        // make an if loop to check if there is something inside the query
        if (!mysqli_fetch_array($result)) {
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
    
    // put the groupname inside a variable 
    $Eventname = $_POST['Eventname'];

    // insert the group name and id and who made the group
    $EventQuery = "INSERT INTO event VALUES (NULL, '$Eventname')";

    $execute = mysqli_query($mysqli, $EventQuery);

    // get the group id from the database
    $getgroupID = "SELECT groupID FROM groups WHERE Groupname = '$groupname'";

    $getID = mysqli_query($mysqli, $getgroupID);

    // put the group number inside a variable
    $groupID = mysqli_fetch_row($getID);
    $GID = $groupID[0];

    // get the event id from the database
    $geteventID = "SELECT eventID FROM event WHERE Eventname = '$Eventname'";

    $getID = mysqli_query($mysqli, $geteventID);

    // put the group number inside a variable
    $eventID = mysqli_fetch_row($getID);
    $EID = $eventID[0];

    // insert everu user into users with user id and group id
    $createEvents = "INSERT INTO events VALUE($EID, $GID)";
    $done = mysqli_query($mysqli, $createEvents);

    // // put the groupname inside a variable
    // $Eventname = $_POST["Groupname"];

    // // set the name for the group index page
    // $groupindex = "index";

    // // set the right path for the group
    // $path = "groups/$Eventname/";

    // // grab the content of the files for the group
    // $indextext = file_get_contents("generate/presets/group.homepage.php");
    // $eventtext = file_get_contents("generate/presets/form.event.generate.php");
    // $generate_event_text = file_get_contents("generate/presets/event.generate.php");

    // // create the directory for the new group
    // mkdir("$path");

    // // create index.html in the specified path
    // $create_file = fopen($path . "$groupindex.php", "w");
    // fwrite($create_file, $indextext);
    // fclose($create_file);

    // // create form.event.generate.php
    // $create_file = fopen($path . "form.event.generate.php", "w");
    // fwrite($create_file, $eventtext);
    // fclose($create_file);

    // // create the event generater
    // $create_file = fopen($path . "event.generate.php", "w");
    // fwrite($create_file, $generate_event_text);
    // fclose($create_file);

    // // create the event directory
    // mkdir("$path/events");

    // // send the user to the new page
    // header("location:groupselect.php");
  }
  ?>
</body>

</html>