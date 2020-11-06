<?php
// start session
session_start();
//  controll of there is a username saved

if (!isset($_SESSION['Username']) || strlen($_SESSION['Username']) == 0) {
    // no vallid login, send back to inlog
    header("Location:../login/groeps/index.php");
    exit;
} if (isset($_SESSION['level']) && $_SESSION['level'] != 2 OR $_SESSION['level'] != 1) {
    // not a user send back to blank.php
    header("Location:blank.php");
    exit;
}
?>