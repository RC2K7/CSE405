<?php
    session_start();
    
    $request = json_decode(file_get_contents('php://input'), true);
    
    
    $username = $request['username'];
    $password = $request['password'];
    
    $responseObject = array();
    
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=react", "rc2k7");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare("SELECT password, click_count FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        // Redirect if no user exists
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
            $_SESSION['username'] = $username;
            $responseObject['result'] = 'success';
            $responseObject['click_count'] = $row['click_count'];
            print(json_encode($responseObject));
            exit();
        }
        
        // Grab click_count
    } catch (PDOException $e) {
        $responseObject['result'] = 'error';
        $responseObject['msg'] = $e->getMessage();
        print(json_encode($responseObject));
        exit();
    }
?>