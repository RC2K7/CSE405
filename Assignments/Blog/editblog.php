<?php
    session_start();
    
    include './inc/dbhandler.php';
    
    // Include Login and Logout
    include './inc/loginhandler.php';
    
    // Check if user is logged in and allowed to edit blog
    if (!isset($_SESSION['blog_user'])) {
        header('Location: ./index.php');
        exit('You Are Not Logged In');
    }
    
    if (!isset($_GET['u'])) {
        header('Location: ./index.php');
        exit('Missing User Name');
    }
    
    $user = $_GET['u'];
    
    if ($_SESSION['blog_user'] !== $user) {
        header('Location: ./index.php');
        exit('You Do Not Have Permission To Edit This Blog');
    }
    
    // Get BlogText from Database
    $stmt = $dbh->prepare('SELECT blogtext FROM users WHERE username = :username');
    $stmt->bindParam(':username', $user);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        header('Location: ./index.php');
        exit('Could Not Find User in Database');
    }
    
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
                        echo "<h2>Editing $user's Blog</h2>";
                    ?>
                </div>
            </div>
            
            <form action="./saveblog.php<?php echo '?u=' . $user; ?>" method="post">
                <label for="blogdetails">Blog Details:</label>
                <textarea class="u-full-width" name="blogdetails" style="font-size: 11pt"><?php print($blogtext) ?></textarea></br>
                <input type="submit" value="Save"/>
            </form>
        </div>
    </body>
</html>