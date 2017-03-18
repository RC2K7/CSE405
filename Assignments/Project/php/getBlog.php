<?php
    $responseObj = array();
    $request = json_decode(file_get_contents('php://input'), true);
    
    $targetUsername = $request['targetUser'];
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=project', 'rc2k7');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare('SELECT blogtext FROM users WHERE username = :username');
        $stmt->bindParam(":username", $targetUsername);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            $responseObj['blogtext'] = "Could not find blog.";
            print(json_encode($responseObj));
            exit();
        }
        
        $result = $stmt->fetch();
        $responseObj['blogtext'] = $result['blogtext'];
        print(json_encode($responseObj));
    } catch (PDOException $e) {
        $responseObj['blogtext'] = 'Error communicating to database';
        print(json_encode($responseObj));
    }
?>