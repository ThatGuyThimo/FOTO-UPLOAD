<?php
// check if user comes from form.generate.php
if (isset($_GET['submit'])) {

    $groepname = $_GET["groepname"];
    $groepindex = "index.$groepname";
    $path = "../groeps/$groepname/";

    // grab the content of the files for the groep
    $indextext = file_get_contents("presets/group.homepage.php");
    $eventtext = file_get_contents("presets/form.event.generate.php");
    $generate_event_text = file_get_contents("presets/event.generate.php");

    // create the directory for the new groep
    mkdir("$path");

    // create index.html in the specified path
    $create_file = fopen($path . "$groepindex.php", "w");
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
    header("location:$path$groepindex.php");

} else {
    // if the user does not come from form.generate.php then send him an error
    echo "<p>U komt niet van de groepmaker</p>";
}
?>