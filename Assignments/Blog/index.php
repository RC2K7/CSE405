<?php
    session_start();
    
    include './inc/dbhandler.php';
    
    // Covers Login and Logout Mechanics
    include './inc/loginhandler.php';
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
                <div class="column">
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Blog Link</th>
                        </tr>
                        <?php
                            try {
                                $dbh = new PDO('mysql:host=localhost;dbname=blog', 'rc2k7');
                                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt = $dbh->prepare('SELECT username FROM users');
                                $stmt->execute();
                                
                                if ($stmt->rowCount() === 0) {
                                    exit();
                                }
                                
                                $result = $stmt->fetchAll();
                                foreach ($result as $entry) {
                                    echo '<tr><br /><td>' . $entry['username'] . '</td><br /><td><a href="./viewblog.php?u=' . $entry['username'] . '">View Blog</a></td><br /></tr><br />';
                                }
                            } catch (PDOException $e) {
                                exit($e->getMessage());
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>