<?php
    if (isset($_POST['login'])) {
        if (isset($_POST['login_username']) and isset($_POST['login_password'])) {
            $stmt = $dbh->prepare('SELECT password FROM users WHERE username = :username');
            $stmt->bindParam(':username', $_POST['login_username']);
            $stmt->execute();
            
            if ($stmt->rowCount() === 0) {
                exit();
            }
            
            $result = $stmt->fetch();
            if (strcmp($result['password'], $_POST['login_password']) === 0) {
                $_SESSION['blog_user'] = $_POST['login_username'];
            }
        }
    } elseif (isset($_POST['logout'])) {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
?>