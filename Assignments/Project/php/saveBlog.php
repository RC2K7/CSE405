<?php
    session_start();
    
    if (!isset($_SESSION['project_username'])) {
        exit();
    }
    
    $request = json_decode(file_get_contents('php://input'), true);
    
    $user = $_SESSION['project_username'];
    $blogtext = $request['blogText'];
    
    try{
        $dbh = new PDO('mysql:host=localhost;dbname=project', 'rc2k7');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $stmt = $dbh->prepare("UPDATE users SET blogtext = :blogtext WHERE username = :username");
        $stmt->bindParam(':blogtext', $blogtext);
        $stmt->bindParam(':username', $user);
        $stmt->execute();
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>