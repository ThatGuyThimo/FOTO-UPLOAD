<html lang="nl">
</html>
<?php
// check if the user comes from a form
if (isset($_POST['Inlog'])) {
    require '../includes/config.inc.php';
    session_start();

    $Username = $_POST['Username'];
    $Password = sha1($_POST['Password']);
    $captcha = $_POST['g-recaptcha-response'];
// make the database connection
    $user = "SELECT * FROM user WHERE Username = '$Username' AND Password = '$Password'";

    $resultuser = mysqli_query($mysqli, $user);

// captcha
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
    'secret' => '6Lcgd-IZAAAAAFHBuU84nDg7N4U2izBUOk1uoDQw',
    'response' => $_POST["g-recaptcha-response"]
);
$options = array(
    'http' => array (
                'method' => 'POST',
                'content' => http_build_query($data),
                'header' => 'Content-Type: application/x-www-form-urlencoded'
            )
        );
$context = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$captcha_success = json_decode($verify);
// inlog and captcha check
    if(mysqli_num_rows($resultuser) > 0 && $captcha_success->success==true) {

        $fetchuser = mysqli_fetch_array($resultuser);
// save the username level and ID in the session
        $_SESSION['Username'] = $Username;
        $_SESSION['level'] = $fetchuser['level'];
        $_SESSION['userID'] = $fetchuser['userID'];
// send the user to the homepage
        header("Location:blank.php");
    } else if($captcha_success->success == false) {
        // if captcha is false display this
        echo "<p>De captcha is incorrect!</p>";
        echo "<p><a href='inlog.php'>Probeer opnieuw</a>";
    } else {
        // if username and or password is incorrect display this
        echo "<p>Naam en/of wachtwoord zijn onjuist.</p>";
        echo "<p><a href='inlog.php'>Probeer opnieuw</a>";
    }
}