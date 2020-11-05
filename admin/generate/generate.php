<?php
$eventname = $_GET["eventname"];
$eventindex = "event$eventname";
$indextext = "<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
        <title>test site</title>
    </head>
    <body>
        <h1>test site om te kijken of generate.php werkt $eventname</h1>
    </body>
</html>"
$create_file = fopen("$eventindex.php", "W")