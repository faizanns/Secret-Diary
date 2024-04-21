<?php

    session_start();

    $diaryContent = "";

    if (array_key_exists("id", $_COOKIE) && $_COOKIE['id']) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }

    if (array_key_exists("id", $_SESSION) && $_SESSION['id']) {
        
        include("connection.php");
        
        $query = "SELECT `diary` from `users` WHERE  id = ".mysqli_real_escape_string($link, $_SESSION['id'])." LIMIT 1";
        
        $row = mysqli_fetch_array(mysqli_query($link, $query));
        
        $diaryContent = $row['diary'];
        
    } else {
        
        header("location: index.php");
        
    }

    include("header.php");

?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light" navbar-fixed-top>

        <a class="navbar-brand" href="#">Secret Diary</a>

        <div class="form-inline my-2 my-lg-0">

            <a href="index.php?logout=1"><button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button></a>

        </div>

    </nav>

    <div class="container-fluid" id="containerLoggedInPage">

        <textarea class="form-control" id="diary"><?php echo $diaryContent ?></textarea>
    
    </div>
    
<?php

    include("footer.php");

/*    if (isset($_POST['go_back'])) {
        
        setcookie("logged-in", "0000", time() - 60 * 60);
        
        header("location: index.php");
        
    }
*/

?>

<!--
<!DOCTYPE html>

<html>
    <body>

        <form method="post">
            <button type="submit" name="go_back">Login Page</button>
        </form>

    </body>
</html>
-->