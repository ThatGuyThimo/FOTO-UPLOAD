<!doctype html>
<html lang="nl">
<head>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta charset="utf-8">
    <title>Foto-album-Login</title>
</head>
<body>


 
  <h1>LOG IN:</h1>
 
<div class="inlogdiv">

    <form method="POST" action="inlog.verwerk.php" enctype="multipart/form-data">
    
    <table border="0">
        
            <tr>
                <td>Username</td>
                <td><input type="text" name="Username"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="Password" id="myInput"></td>

            </tr>

            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="Inlog" value="LOG IN"></td>
            </tr>
            <tr>
            <div class="g-recaptcha" data-sitekey="6Lcgd-IZAAAAALDXzqOGaBXWmJHCuA71_g3LiQ2T"></div>
            </tr>
        </table>
    </form>
</div>

    

</body>


</html>