<?php
    session_start();
    
    $request = json_decode(file_get_contents('php://input'), true);
    
    
    $username = $request['username'];
    $password = $request['password'];
    
    $responseObject = array();
    
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=project", "rc2k7");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        // If no user exists
        if ($stmt->rowCount() === 0) {
            $responseObject['result'] = 'failure';
            print(json_encode($responseObject));
            exit();
        }
        
        $row = $stmt->fetch();
        $actualPassword = $row['password'];
        
        if ($actualPassword !== $password) {
            $responseObject['result'] = 'failure';
            print(json_encode($responseObject));
            exit();
        } else {
            $_SESSION['project_username'] = $username;
            $responseObject['result'] = 'success';
            print(json_encode($responseObject));
            exit();
        }
    } catch (PDOException $e) {
        $responseObject['result'] = 'error';
        $responseObject['msg'] = $e->getMessage();
        print(json_encode($responseObject));
        exit();
    }
?>