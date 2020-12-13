<!doctype html>
<html lang="nl" style="overflow:hidden;">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
    <meta charset="utf-8">
    <title>Login - JXT</title>
    <link rel="stylesheet" href="../style/output/style.min.css">
    <script src="../assets/js/fontawesome.js"></script>
    <script type="text/javascript">
        const userPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const userPrefersLight = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches;

        var onloadCallback = function() {
            grecaptcha.render("check", {
                sitekey: "6Lcgd-IZAAAAALDXzqOGaBXWmJHCuA71_g3LiQ2T",
                theme: userPrefersDark ? 'dark' : 'light',
            });
        }
    </script>
</head>

<body>
    <div class="Banner">
        <div class="header">Inloggen</div>
        <div>
            <a href="../"><i class="fad fa-home-lg"></i></a>
        </div>
    </div>
    <main>
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
                        <div class="g-recaptcha" id="check"></div>
                    </div>
                </div>
                <div class="formItem submitBtn">
                    <input class="Btn_login" type="submit" name="Inlog" value="inloggen">
                </div>
            </form>
        </div>
    </main>
    <svg class="BackgroundSVG" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="var(--backgroundSVG)" fill-opacity="1" d="M0,192L34.3,176C68.6,160,137,128,206,138.7C274.3,149,343,203,411,202.7C480,203,549,149,617,122.7C685.7,96,754,96,823,112C891.4,128,960,160,1029,192C1097.1,224,1166,256,1234,256C1302.9,256,1371,224,1406,208L1440,192L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
    </svg>

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
</body>


</html>