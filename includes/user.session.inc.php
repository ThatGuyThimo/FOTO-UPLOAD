<?php
// start session
session_start();
//  controll of there is a username saved

if (!isset($_SESSION['Username']) || strlen($_SESSION['Username']) == 0) {
    // no vallid login, send back to form
    header("Location:../login/index.php");
    exit;
} if (isset($_SESSION['level']) && $_SESSION['level'] != 2) {
    // not a mentor send back to home.php
    header("Location:blank.php");
    exit;
}
?>