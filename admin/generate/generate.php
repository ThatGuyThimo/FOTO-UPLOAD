<?php
$eventname = $_GET["eventname"];
$eventindex = "index.$eventname";
$eventstyle = "style.$eventname";

$indextext = file_get_contents("test.html");

$styletext = file_get_contents("style.css");

mkdir("../../login/events", $eventname)

$create_file = fopen("$eventindex.php", "w");
fwrite($create_file, $indextext);
fclose($create_file);

$create_style = fopen("$eventstyle.css", "w");
fwrite($create_style, $styletext);
fclose($create_style);

header("location:$eventindex.php");
?>