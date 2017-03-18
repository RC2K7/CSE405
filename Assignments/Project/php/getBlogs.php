<?php
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=project', 'rc2k7');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare('SELECT username FROM users');
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            exit();
        }
        
        $result = $stmt->fetchAll();
        print(json_encode($result));
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>