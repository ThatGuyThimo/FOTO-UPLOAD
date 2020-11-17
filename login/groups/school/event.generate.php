<?php
// check if user comes from form.generate.php
if (isset($_GET['submit'])) {

    $eventname = $_GET["eventname"];
    $eventindex = "index.$eventname";
    $path = "/events/$eventname/";

    // grab the content of the files for the groep
    $indextext = file_get_contents("../../generate/presets/presets/event.php");

    // create the directory for the new groep
    mkdir("$path");

    // create index.html in the specified path
    $create_file = fopen($path . "$eventindex.php", "w");
    fwrite($create_file, $indextext);
    fclose($create_file);

    // send the user to the new page
    header("location:$path$eventindex.php");

} else {
    // if the user does not come from form.generate.php then send him an error
    echo "<p>U komt niet van de eventmaker</p>";
}
?>