<?php
    session_start();
    
    $request = json_decode(file_get_contents('php://input'), true);
    $targetUsername = $request['targetUser'];
    
    $responseObj = array('canEdit' => 'false');
    
    if (isset($_SESSION['project_username']) and $_SESSION['project_username'] === $targetUsername) {
        $responseObj['canEdit'] = 'true';
    }
    
    print(json_encode($responseObj));
?>