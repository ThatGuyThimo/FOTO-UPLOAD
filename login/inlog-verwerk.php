
<html lang="nl">
</html>
<?php
if (isset($_POST['Inlog'])) {
    require '../includes/config.inc.php';
    session_start();

    $Username = $_POST['Username'];
    $Password = sha1($_POST['Password']);

    $admin = "SELECT * FROM Admin WHERE Username = '$Username' AND Password = '$Password'";
    $user = "SELECT * FROM User WHERE Username = '$Username' AND Password = '$Password'";

    $resultadmin = mysqli_query($mysqli, $admin);
    $resultuser = mysqli_query($mysqli, $user);
    // var_dump($mentor);
    // var_dump($student);
    // var_dump($resultaatmentor);
    // var_dump($resultaatstudent);
    if (mysqli_num_rows($resultadmin) > 0) {

        $fetchadmin = mysqli_fetch_array($resultadmin);

        $_SESSION['Username'] = $Username;
        $_SESSION['level'] = $fetchadmin['level'];


        header("Location:blank.php");
        // var_dump($_SESSION['level']);
        // var_dump($user['level']);

    } else if(mysqli_num_rows($resultuser) > 0) {

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
