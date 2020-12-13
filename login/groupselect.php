<?php
session_start();
// check if the user is loggedin
if (!isset($_SESSION['Username']) || strlen($_SESSION['Username']) == 0) {
  header("Location:index.php");
  exit;
}

//read the config-file
require('../includes/config.inc.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/output/style.min.css">
  <script src="../assets/js/fontawesome.js"></script>
  <title>Groepen maken - JXT</title>
</head>

<body>
  <div class="Banner">
    <div class="header">Groeps</div>
    <div>
      <div><a title="log uit" href="../includes/logout.inc.php"><i class="fad fa-sign-out-alt"></i></a></div>
    </div>
  </div>
  <main>
    <div class="groupList">
      <div class="scroll">

        <?php
        // query every userid in relation with the group
        $userID = $_SESSION['userID'];
        $query = "SELECT Groupname, groupDate  
              FROM groups
              WHERE groupID IN (SELECT groupID
                              FROM users
                              WHERE userID = $userID)";
        //execute the query
        $result = mysqli_query($mysqli, $query);

        // loop door alle rijen dat heen
        while ($row = mysqli_fetch_array($result)) {
        ?>
          <a href="groups/<?php echo $row['Groupname'] ?>">
            <div class="groupItem">
              <div class="group">
                <?php echo $row['Groupname'] ?>
              </div>
              <div class="group">
                <?php echo $row['groupDate'] ?>
                <?php
                // $groupDate = time();
                // echo  date('D, d M Y - h:i', $groupDate);
                ?>
              </div>
            </div>
          </a>
        <?php
        }
        ?>
      </div>
    </div>
    <form action="" method="post">
      <div class="aanmaak">

        <!-- input the name of the group -->
        <input class="GroupInput" type="text" name="Groupname" placeholder="Groepnaam" required="required">
        <div class="userList">
          <?php
          // query all users
          $query = "SELECT userID, Username FROM user ORDER BY Username";

          //execute the query
          $result = mysqli_query($mysqli, $query);

          // show all the users
          while ($row = mysqli_fetch_array($result)) {
          ?>
            <div class="userItem">
              <input class="input" type="checkbox" name="<?php echo 'member[]' ?>" value="<?php echo $row['userID'] ?>" id="<?php echo $row['userID'] ?>">
              <label for="<?php echo $row['userID'] ?>">
                <?php echo $row['Username'] ?>
              </label>
            </div>
          <?php
          }
          ?>
        </div>
        <div class="Item">
          <input type="submit" name="submit" value="Groep aanmaken" id="submit">
        </div>
    </form>
  </main>
  <svg class="BackgroundSVG" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="var(--backgroundSVG)" fill-opacity="1" d="M0,64L26.7,74.7C53.3,85,107,107,160,128C213.3,149,267,171,320,176C373.3,181,427,171,480,144C533.3,117,587,75,640,69.3C693.3,64,747,96,800,96C853.3,96,907,64,960,74.7C1013.3,85,1067,139,1120,144C1173.3,149,1227,107,1280,101.3C1333.3,96,1387,128,1413,144L1440,160L1440,320L1413.3,320C1386.7,320,1333,320,1280,320C1226.7,320,1173,320,1120,320C1066.7,320,1013,320,960,320C906.7,320,853,320,800,320C746.7,320,693,320,640,320C586.7,320,533,320,480,320C426.7,320,373,320,320,320C266.7,320,213,320,160,320C106.7,320,53,320,27,320L0,320Z"></path>
  </svg>
  <?php
  if (isset($_POST['submit'])) {

    // put the groupname inside a variable 
    $Groupname = $_POST['Groupname'];

    $checkgroupname = "SELECT Groupname FROM groups WHERE Groupname = '$Groupname'";

    $testquery = mysqli_query($mysqli, $checkgroupname);

    // check if the group name already exists
    if (mysqli_num_rows($testquery) == 0) {
      // insert the group name and id and who made the group
      $array = $_POST['member'];
      foreach ($array as $member => $value) {
        if ($value == NULL){
          echo "<script>alert('No user('s) selected');</script>";
        } else {
        $createUsers = "INSERT INTO users VALUE($value, $GID)";
        $done = mysqli_query($mysqli, $createUsers);
        }
      }
      // $groupQuery = "INSERT INTO groups VALUES ($userID,'$Groupname',NULL, current_timestamp())";
      $groupQuery = "INSERT INTO groups VALUES ($userID,'$Groupname',NULL, current_timestamp())";

      $execute = mysqli_query($mysqli, $groupQuery);

      // get the group id from the database
      $getgroupID = "SELECT groupID FROM groups WHERE Groupname = '$Groupname'";

      $getID = mysqli_query($mysqli, $getgroupID);

      // put the group number inside a variable
      $groupID = mysqli_fetch_row($getID);
      $GID = $groupID[0];

      // insert everu user into users with user id and group id
      // put the groupname inside a variable
      $groupname = $_POST["Groupname"];

      // set the name for the group index page
      $groupindex = "index";

      // set the right path for the group
      $path = "groups/$groupname/";

      // grab the content of the files for the group
      $indextext = file_get_contents("generate/presets/group.homepage.php");
      $eventtext = file_get_contents("generate/presets/form.event.generate.php");
      $generate_event_text = file_get_contents("generate/presets/event.generate.php");
      $deletetext = file_get_contents("generate/presets/delete.php");
      $ajaxtext = file_get_contents("generate/presets/ajax.js");
      $delete_form_html = file_get_contents("generate/presets/delete_form.html");

      // create the directory for the new group
      mkdir("$path");

      // create index.html in the specified path
      $create_file = fopen($path . "$groupindex.php", "w");
      fwrite($create_file, $indextext);
      fclose($create_file);

      // create form.event.generate.php
      $create_file = fopen($path . "form.event.generate.php", "w");
      fwrite($create_file, $eventtext);
      fclose($create_file);

      // create the event generater
      $create_file = fopen($path . "event.generate.php", "w");
      fwrite($create_file, $generate_event_text);
      fclose($create_file);

      // create the delete page
      $create_file = fopen($path . "delete.php", "w");
      fwrite($create_file, $deletetext);
      fclose($create_file);

      // create the delete page
      $create_file = fopen($path . "delete.php", "w");
      fwrite($create_file, $deletetext);
      fclose($create_file);

      // create the ajax page
      $create_file = fopen($path . "ajax.js", "w");
      fwrite($create_file, $ajaxtext);
      fclose($create_file);

      // create the deleteform page
      $create_file = fopen($path . "delete_form.html", "w");
      fwrite($create_file, $delete_form_html);
      fclose($create_file);

      // create the event directory
      mkdir("$path/events");

      // send the user to the new page
      //header("location:groupselect.php");
      // sort of fix (the bug was only present on Jelle's device)
      echo "<script>window.location.href='groupselect.php'</script>";
    } else {
      echo "<script>alert('Groupname already exists');</script>";
      echo "<script>window.location.href='groupselect.php'</script>";
    }
  }
  ?>
</body>

</html>