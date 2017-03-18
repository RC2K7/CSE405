<?php
    session_start();
    
    include './inc/dbhandler.php';
    
    // Covers Login and Logout Mechanics
    include './inc/loginhandler.php';
    
    // Get User Parameter
    if (!isset($_GET['u'])) {
        header('Location: ./index.php');
        exit();
    }
    
    // Strip User
    $user = $_GET['u'];
    
    if (isset($_POST['edit'])) {
        header("Location: ./editblog.php?u=$user");
        exit();
    }
    
    // Get Row for User
    $stmt = $dbh->prepare('SELECT blogtext FROM users WHERE username = :username');
    $stmt->bindParam(':username', $user);
    $stmt->execute();
    
    // Check User Was Found
    if ($stmt->rowCount() === 0) {
        //header('Location: ./index.php');
        exit('No Blog Found');
    }
    
    // Save Results and Strip Blog_Text
    $result = $stmt->fetch();
    $blogtext = $result['blogtext'];
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/Skeleton/css/normalize.css" type="text/css" />
        <link rel="stylesheet" href="/Skeleton/css/skeleton.css" type="text/css" />
    </head>
    
    <body>
        <div class="container">
            <div class="row">
                <div class="two columns">
                    <a class="button" href="./index.php">Home</a>
                </div>
                
                <form method="post">
                    <?php
                        if (isset($_SESSION['blog_user'])) {
                            echo '
                                <div class="two columns">
                                    <input class="u-full-width" type="submit" name="logout" value="Logout" />
                                </div>
                            ';
                            if ($_SESSION['blog_user'] === $user) {
                                echo '
                                    <div class="two columns">
                                        <input class="u-full-width" type="submit" name="edit" value="Edit Page" />
                                    </div>
                                ';
                            }
                        } else {
                            echo '
                            <div class="three columns">
                                <input class="u-full-width" type="text" name="login_username" placeholder="Username"/>
                            </div>
                            
                            <div class="three columns">
                                <input class="u-full-width" type="password" name="login_password" placeholder="Password" />
                            </div>
                            
                            <div class="two columns">
                                <input class="u-full-width" type="submit" name="login" value="Login" />
                            </div>
                            ';
                        }
                    ?>
                </form>
            </div>
            
            <div class="row">
                <div class="six columns">
                    <?php
                        echo "<h2>$user's - Blog</h2>";
                    ?>
                </div>
            </div>
            
            <div class="row">
                <div class="column">
                    <pre><p><?php print($blogtext); ?></p></pre>
                </div>
            </div>
            
            <div class="row">
                <div class="column">
                    
                </div>
            </div>
        </div>
    </body>
</html>