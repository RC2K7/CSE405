<?php
    session_start();
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=login", "rc2k7");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        // Redirect if no user exists
        if ($stmt->rowCount() === 0) {
            header('Location: ./index.html');
            exit();
        }
        
        $row = $stmt->fetch();
        $actualPassword = $row["password"];
        
        if ($actualPassword !== $password) {
            header('Location: ./index.html');
            exit();
        } else {
            $_SESSION['username'] = $username;
            header('Location: ./clickme.php');
            exit();
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>