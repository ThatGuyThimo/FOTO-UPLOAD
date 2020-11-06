<?php
// check if usre comes from form.generate.php
if (isset($_GET['submit'])) {

    $eventname = $_GET["eventname"];
    $eventindex = "index.$eventname";
    // $eventstyle = "style";
    $path = "../../login/events/$eventname/";

    // grab the content of the files for the event
    $indextext = file_get_contents("index.html");
    // $styletext = file_get_contents("style.css");

    // make the directory for the new event
    mkdir("$path");

    // create index.html in the specified path
    $create_file = fopen($path . "$eventindex.php", "w");
    fwrite($create_file, $indextext);
    fclose($create_file);

    // create style.css in the specified path
    // $create_style = fopen($path2 . "$eventstyle.css", "w");
    // fwrite($create_style, $styletext);
    // fclose($create_style);

    // send the user to the new page
    header("location:$path$eventindex.php");

} else {
    // if the user does not come from form.generate.php the send him an error
    echo "<p>U komt niet van de generate form</p>";
}
?>