<?php
    // Establish Database Connection
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=track2", "rc2k7");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare("UPDATE pageviews SET counter = counter + 1");
        $stmt->execute();
        $stmt = $dbh->prepare("SELECT counter FROM pageviews");
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = $row["counter"];
        
        $responseObject = array('counter' => $counter);
        $jsonString = json_encode($responseObject);
        print($jsonString);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>