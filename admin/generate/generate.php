<?php
if (isset($_GET['submit'])) {

    $eventname = $_GET["eventname"];
    $eventindex = "index.$eventname";
    $eventstyle = "style.$eventname";
    $path = "../../login/events/$eventname/";

    $indextext = file_get_contents("index.html");

    $styletext = file_get_contents("style.css");

    mkdir("$path");

    $create_file = fopen($path, "$eventindex.php", "w");
    fwrite($create_file, $indextext);
    fclose($create_file);

    $create_style = fopen($path, "$eventstyle.css", "w");
    fwrite($create_style, $styletext);
    fclose($create_style);

    // header("location:$path$eventindex.php");

} else {
    echo "<p>U komt niet van de generate form</p>";
}
?>