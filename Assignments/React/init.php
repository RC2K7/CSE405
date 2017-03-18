<?php
    session_start();
    
    if (!isset($_SESSION['username'])) {
        exit();
    }
    
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=react", "rc2k7");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare("SELECT click_count FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = $row["click_count"];
        
        $responseObject = array('counter' => $counter);
        print(json_encode($responseObject));
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>