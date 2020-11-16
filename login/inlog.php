<!doctype html>
<html lang="nl">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta charset="utf-8">
    <title>Foto-album-Login</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <div class="Banner">
        <div class="header">Inloggen</div>
    </div>
    <div class="inlogdiv">
        <form method="POST" action="inlog.verwerk.php" enctype="multipart/form-data">
            <div class="Form">
                <div class="formItem">
                    <label for="Username">Gebruikersnaam</label>
                    <input type="text" name="Username">
                </div>
                <div class="formItem">
                    <label for="Username">Wachtwoord</label>
                    <input type="password" name="Password" id="myInput">
                </div>
                <div class="formItem">
                    <div class="g-recaptcha" data-sitekey="6Lcgd-IZAAAAALDXzqOGaBXWmJHCuA71_g3LiQ2T"></div>
                </div>
            </div>
            <div class="formItem submitBtn">
                <input class="Btn_login" type="submit" name="Inlog" value="inloggen">
            </div>
        </form>
    </div>


</body>


</html>