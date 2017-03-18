<?php
    session_start();
    
    if (!isset($_SESSION['username'])) {
        header('Location: ./index.html');
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <script src="ajax.js"></script>
        <link rel="stylesheet" href="/Skeleton/css/normalize.css" type="text/css" />
        <link rel="stylesheet" href="/Skeleton/css/skeleton.css" type="text/css" />
    </head>
    
    <body>
        <div class="container">
            <div class="row">
                <div class="three columns u-pull-right">
                    <form action="logout.php" method="post">
                        <input type="submit" value="Logout"/>
                    </form>
                </div>
            </div>
            
            <div class="row">
                <div class="four columns">
                    Total Clicks: <span id="page_views">0</span>
                </div>
                <div class="three columns">
                    <button class="button-primary u-full-width" onclick="performClick()">Click Me!</button>
                </div>
            </div>
        </div>
    </body>
    
    <script>
        function performClick() {
            console.log('Enter Click');
            ajax('click.php', null, function(responseObject) {
                document.getElementById('page_views').innerHTML = responseObject.counter;
            });
            console.log('Completed Click');
        }
    </script>
</html>