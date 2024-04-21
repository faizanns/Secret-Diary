<?php

/*session_start();

if (array_key_exists('email', $_POST) OR array_key_exists('password', $_POST)) {
    
    $link = mysqli_connect("localhost", "root", "", "users-test-data");

    if (mysqli_connect_error()) {

            die ("there were errors connecting to the database.");

    }
    
    if ($_POST['email'] == '') {
        
        echo "<p>Email Address is a required field.</p>";
        
    } else if ($_POST['password'] == '') {
        
        echo "<p>Password is required.</p>";
            
    } else {
        
        $query = "SELECT `id` FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
        
        $result = mysqli_query($link, $query);
        
        if (mysqli_num_rows($result) > 0) {
            
            echo "<p>That email address has already been taken.</p>";
            
        } else {
            $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
            
            if (mysqli_query($link, $query)) {
                
                $_SESSION['email'] = $_POST['email'];
                
                header("location: session.php");
                
            } else {
                
                echo "<p>there was a problem signing you up - please try again later.</p>";
                
            }
        }
            
        
        // below is difficult my try.
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $count = 1;

        $query = "SELECT `email` FROM `users`";

        if ($result = mysqli_query($link, $query)) {
            
            $found = false;
            
            $noOfRows = mysqli_num_rows($result);
            
            while ($count <= $noOfRows && $found == false) {
                
                $query = "SELECT `email` FROM `users` WHERE `id` = ".$count. "";

                $result = mysqli_query($link, $query);
            
                $row = mysqli_fetch_array($result);
                
                if ($row[0] == $email) {
                    $found = true;
                    echo "<p>This email is already registered!</p>";
                } else {
                    
                    $count = $count + 1;
                    
                }

            }
            
            if ($found == false) {
                
                $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $email)."', '".mysqli_real_escape_string($link, $password)."')";
                
                mysqli_query($link, $query);
                
                echo "Congrats, it is done finally.";
                
            }

        } else {
            
            echo "<p>Sorry - You could not be registered</p>";
        
        }
        
    }
    
}
*/
?>
<!--
<!DOCTYPE html>
<html>

    <body>
        <h3>Sign UP</h3>
        <form method="post">
            <p>Enter email:</p>
            <input type="text" placeholder="Email Address" name="email">

            <p>Enter password:</p>
            <input type="password" placeholder="Password" name="password">

            <br><br>
            <button type="submit" name="submit-btn">Sign Up</button>
        </form>
    
    </body>

</html>  -->

<?php
/*
    //setcookie("customerId", "1234", time() + 60 * 60 * 24);

    //setcookie("customerId", "", time() - 60 * 60);

    setcookie("customerId", "", time() + 60 * 60);

    $_COOKIE["customerId"] = "test";

    echo $_COOKIE["customerId"];
*/
?>

<?php
/*
    // Generate a hash of the password "mypassword"
    $hash = password_hash("mypassword", PASSWORD_DEFAULT);

    // Echoing it out, so we can see it:
    echo $hash;

    // Some line breaks for a cleaner output:
    echo "<br><br>";

    // Using password_verify() to check if "mypassword" matches the hash.
    // Try changing "mypassword" below to something else and then refresh the page.
    if (password_verify('mypassword', $hash)) {
        echo 'Password is valid!';
    } else {
        echo 'Invalid password.';
    }
*/
?>

<?php

session_start();

$error = "";

if (array_key_exists("logout", $_GET)) {
    
    unset($_SESSION['id']);
    setcookie("id", "", time() - 60 * 60);
    $_COOKIE['id'] = "";
    
} else if (array_key_exists("id", $_SESSION) AND ($_SESSION['id']) OR (array_key_exists("id", $_COOKIE)) AND $_COOKIE['id']) {
    
    header("location: login-page.php");
    
}

if (isset($_POST['submit'])) {

    include("connection.php");

    if ($_POST['email'] == '') {

        $error .= "email is required<br>";

    }
    
    if($_POST['password'] == '') {

        $error .= "password is required<br>";

    }
    
    if ($error != "") {
        
        $error = "<p>There were errors in your form:</p>".$error;
        
    } else {
    
        if ($_POST['signUp'] == '0') {

            $query = "SELECT * FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";

            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {

                $row = mysqli_fetch_array($result);

                if (password_verify($_POST['password'], $row[2])) {

                    $_SESSION['id'] = $row['id'];

                    if (isset($_POST['stay_loggedin'][0])) {

                        setcookie("id", $row['id'], time() + 60 * 60 * 24 * 365);

                    }
                    
                    header("location: login-page.php");

                } else {

                    if ($row[2] != $_POST['password']) {

                        $error = "Incorrect password! please try again.";

                    } else {

                        $error = "there was an error logging you in.";

                    }

                }


            } else {

                $error = "This email is not registered - Sign up now!";

            }

        } else {

            $query = "SELECT * FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $_POST['email'])."'";

            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {

                $error .= "<p>That email address has already been taken.</p>";

            } else {

                $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

                $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $hash)."')";

                if (mysqli_query($link, $query)) {

                    $_SESSION['id'] = mysqli_insert_id($link);

                    if (isset($_POST['stay_loggedin'][1])) {

                        setcookie("id", mysqli_insert_id($link), time() + 60 * 60 * 24 * 365);

                    }

                    header("location: login-page.php");

                } else {

                    $error .= "<p>there was a problem signing you up - please try again later.</p>";

                }
            }

        }
        
    }

}

?>

<?php include("header.php");?>
      
      <div class="container" id="homePageContaniner">
      
        <h1>Secret Diary</h1>
          
        <p><strong>Store your thoughts permanently and securely.</strong></p>
          
          <div><?php if($error != "") {
    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
} ?></div>
    
            <form method="post" id="logInForm">
                
                <p>Log in using your username and password.</p>
                
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Your Email" name="email">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" placeholder="Password" name="password">
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="exampleCheck1" type="checkbox" name="stay_loggedin[]">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    <input type="hidden" name="signUp" value="0">
                </div>
                <div class="form-group">
                    <input class="btn btn-success" type="submit" name="submit" value="Log In">
                </div>
                
                <p><a class="toggleForm">Sign Up</a></p>


            </form>

            <form method="post" id="signUpForm">
                
                <p>Interested? Sign up now!</p>
                
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Your Email" name="email">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" placeholder="Password" name="password">
                </div>
                <div class="form-check">
                    <input class="form-check-input" id="exampleCheck2" type="checkbox" name="stay_loggedin[]">
                    <label class="form-check-label" for="exampleCheck2">Check me out</label>
                    <input type="hidden" name="signUp" value="1">
                </div>
                <div class="form-group">
                    <input class="btn btn-success" type="submit" name="submit" value="Sign Up">
                </div>
                
                <p><a class="toggleForm">Log In</a></p>

            </form>
      
      </div>

<?php include("footer.php");?>





