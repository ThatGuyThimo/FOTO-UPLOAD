<?php
// check if user comes the from
if (isset($_GET['submit'])) {

    $groupname = $_POST["Groupname"];
    $groupindex = "index.$groupname";
    $path = "/groeps/$groupname/";

    // grab the content of the files for the group
    $indextext = file_get_contents("generate/presets/group.homepage.php");
    $eventtext = file_get_contents("generate/presets/form.event.generate.php");
    $generate_event_text = file_get_contents("generate/presets/event.generate.php");

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

    // create the event directory
    mkdir("$path/events");

    // send the user to the new page
    header("location:$path$groupindex.php");

  } else {
    // if the user does not come from the form then send him an error
    echo "<p>Error unknown form post submit.</p>";
  }
?>