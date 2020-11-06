
<html lang="nl">
</html>
<?php
if (isset($_POST['Inlog'])) {
    require '../includes/config.inc.php';
    session_start();

    $Username = $_POST['Username'];
    $Password = sha1($_POST['Password']);

    $user = "SELECT * FROM User WHERE Username = '$Username' AND Password = '$Password'";

    $resultuser = mysqli_query($mysqli, $user);

    if(mysqli_num_rows($resultuser) > 0) {

        $fetchuser = mysqli_fetch_array($resultuser);

        $_SESSION['Username'] = $Username;
        $_SESSION['level'] = $fetchuser['level'];
        $_SESSION['userID'] = $fetchuser['userID'];

        header("Location:blank.php");
        // var_dump($_SESSION['level']);
        // var_dump($userstudent['level']);

    } else {
        echo "<p>Naam en/of wachtwoord zijn onjuist.</p>";
        echo "<p><a href='index.php'>Probeer opnieuw</a>";
    }
}
