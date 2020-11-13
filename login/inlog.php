<!doctype html>
<html lang="nl">

<head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta charset="utf-8">
    <title>Foto-album-Login</title>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <h1>LOG IN:</h1>
    <div class="inlogdiv">
        <form method="POST" action="inlog.verwerk.php" enctype="multipart/form-data">
            <div class="formItem">
                <label for="Username">Username</label>
                <input type="text" name="Username">
            </div>
            <div class="formItem">
                <label for="Username">Password</label>
                <input type="password" name="Password" id="myInput">
            </div>
            <div class="formItem">
                <div class="g-recaptcha" data-sitekey="6Lcgd-IZAAAAALDXzqOGaBXWmJHCuA71_g3LiQ2T"></div>
            </div>
            <div class="formItem">
                <input class="sumbitBtn Btn" type="submit" name="Inlog" value="LOG IN">
            </div>
        </form>
    </div>


</body>


</html>