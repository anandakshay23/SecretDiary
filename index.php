<?php

    session_start();

    if(array_key_exists("logout",$_GET)) {
        unset($_SESSION);

        setcookie("id","",time()-60*60);

        $_COOKIE['id']="";

    } else if((array_key_exists("id",$_SESSION) AND $_SESSION['id']) OR (array_key_exists("id",$_COOKIE) AND $_COOKIE['id'])){
        header("Location: loggedInPage.php");
    }





    include ("connection.php");




    $error = "";

    if(!$_POST['email']) {
        $error .= "An Email Required";
    }

    if(!$_POST['password']) {
        $error .= "A Password Required";
    }

    if($error != "") {
         $error = "<p>There were error(s) in your from:</p>".$error;
    } else {

        if($_POST['signUp']=='1') {
            $query = "SELECT id FROM users WHERE email = '" . mysqli_real_escape_string($link, $_POST['email']) . "' LIMIT 1";

            $result = mysqli_query($link, $query);

            if (mysqli_num_rows($result) > 0) {
                $error = "That email address is taken";
            } else {
                $query = "INSERT INTO users (email,password,diary) VALUES ('" . mysqli_real_escape_string($link, $_POST['email']) . "','" . mysqli_real_escape_string($link, $_POST['password']) . "','')";

                if (!mysqli_query($link, $query)) {
                    $error = "<p>Could not signed you up - Please Try again later</p>";
                } else {

                    $query = "UPDATE users SET password = '" . md5(md5(mysqli_insert_id($link)) . $_POST['password']) . "' WHERE id = " . mysqli_insert_id($link) . " LIMIT 1";

                    mysqli_query($link, $query);

                    $_SESSION['id'] = mysqli_insert_id($link);

                    if ($_POST['stayLoggedIn'] == 1) {

                        setcookie("id", mysqli_insert_id($link), time() + 60 * 60 * 24 * 365);

                    }

                    header("Location: loggedInPage.php");
                }
            }
        } else {

            $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link,$_POST['email'])."'";

            $result = mysqli_query($link,$query);

            $row = mysqli_fetch_array($result);

             if(isset($row)){
                 $hashedPassword = md5(md5( $row['id'].$_POST['password']));
                 if($hashedPassword==$row['password']){
                     $_SESSION['id']=$row['id'];


                     if ($_POST['stayLoggedIn'] == 1) {

                         setcookie("id",$row['id'], time() + 60 * 60 * 24 * 365);

                     }

                     header("Location: loggedInPage.php");
                 } else {
                     $error = "Email/Password is Incorrect !";
                 }
             }else {
                 $error = "Email/Password is Incorrect !";
             }
        }
        
        
    }

?>

<?php

    include("header.php");


?>



<div class="container" id="homepageContainer">
    <h1>Secret Diary</h1>

    <p>
        Store Your Thoughts Permanently with Security.
    </p>


    <div id="error">
        <?php
        echo $error;
        ?>
    </div>

    <form method="POST" id="signUpForm">

        <p>
            Interested Sign Up ;)
        </p>

        <div class="form-group">
            <input class="form-control" type="email" name="email" placeholder="Your Email">
        </div>

        <div class="form-group">
            <input class="form-control" type="password" name="password"  placeholder="Your Password">
        </div>

        <div class="form-group form-check">
            <input class="form-check-input" type="checkbox" name="stayLoggedIn" value=1>
            <label class="form-check-label" for="exampleCheck1">Stay Logged In</label>
        </div>

        <div class="form-group">
            <input type="hidden" value="1" name="signUp">

            <input class="btn btn-success" type="submit" name="submit" value="Sign Up!">

        </div>

        <div class="form-group">
            <button type="button" class="btn btn-primary toggleButton">Log In</button>
        </div>
    </form>


    <form method="POST" id="logInForm">

        <p>
            Log In with your email and password
        </p>

        <div class="form-group">
            <input class="form-control" type="email" name="email" placeholder="Your Email">
        </div>

        <div class="form-group">
            <input class="form-control" type="password" name="password"  placeholder="Your Password">
        </div>

        <div class="form-group form-check">
            <input class="form-check-input" type="checkbox" name="stayLoggedIn" value=1>
            <label class="form-check-label" for="exampleCheck1">Stay Logged In</label>
        </div>

        <div class="form-group">
            <input type="hidden" value="0" name="logIN">

            <input class="btn btn-success" type="submit" name="submit" value="Log In!">
        </div>

        <div class="form-group">
            <button type="button" class="btn btn-primary toggleButton">Sign Up</button>
        </div>
    </form>


</div>

<?php

    include ("footer.php");

?>






