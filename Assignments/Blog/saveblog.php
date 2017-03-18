<?php
    session_start();
    
    include './inc/dbhandler.php';
    
    if (!isset($_SESSION['blog_user'])) {
        header('Location: ./index.php');
        exit();
    }
    
    if (!isset($_GET['u'])) {
        header('Location: ./index.php');
        exit();
    }
    
    if ($_SESSION['blog_user'] !== $_GET['u']) {
        header('Location: ./index.php');
        exit();
    }
    
    if (!isset($_POST['blogdetails'])) {
        header('Location: ./index.php');
        exit();
    }
    
    $user = $_GET['u'];
    $blogtext = $_POST['blogdetails'];
    
    $stmt = $dbh->prepare("UPDATE users SET blogtext = :blogtext WHERE username = :username");
    $stmt->bindParam(':blogtext', $blogtext);
    $stmt->bindParam(':username', $user);
    $stmt->execute();
    
    header('Location: ./viewblog.php?u=' . $user);
?>