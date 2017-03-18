<?php
    session_start();
    
    $responseObj = array( 'loggedIn' => 'false' );
    if(isset($_SESSION['project_username'])) {
        $responseObj['loggedIn'] = 'true';
    }
    print(json_encode($responseObj));
?>