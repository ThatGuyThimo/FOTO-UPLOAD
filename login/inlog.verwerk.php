<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Er is iets verkeert gegaan | Error</title>
    <link rel="stylesheet" href="../style/output/style.css">
</head>

<body>
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
            'secret' => '6Lcb0ekZAAAAAEg3LJrC3z4LWhUkl4H1Uav4t0QM',
            'response' => $_POST["g-recaptcha-response"]
        );
        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query($data),
                'header' => 'Content-Type: application/x-www-form-urlencoded'
            )
        );
        $context = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success = json_decode($verify);
        // inlog and captcha check
        if (mysqli_num_rows($resultuser) > 0 && $captcha_success->success == true) {

            $fetchuser = mysqli_fetch_array($resultuser);
            // save the username level and ID in the session
            $_SESSION['Username'] = $Username;
            $_SESSION['userID'] = $fetchuser['userID'];
            // send the user to the team select
            header("Location:groupselect.php");
        } else if ($captcha_success->success == false) {
            // if captcha is false display this
    ?>
            <div class="Banner">
                <div class="header">Captcha is mislukt</div>
            </div>
            <div class="error">
                <a class="Btn" onclick="window.history.back();">Probeer het opnieuw</a>
            </div>
        <?php
        } else {
            // if username and or password is incorrect display this
        ?>
            <div class="Banner">
                <div class="header">Gegevens zijn onjuist</div>
            </div>
            <div class="error">
                <a class="Btn" onclick="window.history.back();">Probeer het opnieuw</a>
            </div>
    <?php
        }
    }
    ?>
</body>

</html>