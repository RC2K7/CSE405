<?php
    // Connect to Database
    include 'config.php';
    
    try {
        $dbh = new PDO("mysql:localhost=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
?>