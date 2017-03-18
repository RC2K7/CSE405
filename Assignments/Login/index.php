<?php
    session_start();
    
    if(isset($_SESSION['username'])) {
        header("Location: ./clickme.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <body>
        <form action="login.php" method="post">
            Username: <input type="text" value="alice" name="username" size="36" />
            Password: <input type="password" value="1234" name="password" size="36" />
                      <input type="submit" value="Login" />
        </form>
    </body>
</html>