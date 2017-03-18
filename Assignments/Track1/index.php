<?php
    // Establish Database Connection
    try {
        $dbh = new PDO("mysql:host=localhost;dbname=track1", "rc2k7");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare("UPDATE pageviews SET counter = counter + 1");
        $stmt->execute();
        $stmt = $dbh->prepare("SELECT counter FROM pageviews");
        $stmt->execute();
        $row = $stmt->fetch();
        $counter = $row["counter"];
        
        echo "Total Page Counts: $counter";
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>