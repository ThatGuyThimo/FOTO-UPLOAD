<!doctype html>
<html lang="nl">
<head>
    
    <meta charset="utf-8">
    <title>Microsoft-Login</title>
</head>
<body>
<?php
session_start();
?>


 
  <h1>LOG IN:</h1>
 
<div class="inlogdiv">

    <form method="post" action="inlog-verwerk.php">
    
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

        </table>
    </form>
</div>

    

</body>


</html>