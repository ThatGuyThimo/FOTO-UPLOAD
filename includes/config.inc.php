<?php
// Dit zijn de MYSQL inloggegevens.
// Zorg dat deze gegevens overeenkomen met de gegevens van de MYSQL server.
define('SERVER', 'localhost');
define('USERNAME', 'Jaap');
define('PASSWORD', '');
define('NAME', 'foto-album');

$mysqli = mysqli_connect(SERVER, USERNAME, PASSWORD, NAME);

if ($mysqli === false) die('ERROR: Could not connect. ' . mysqli_connect_error());

?>