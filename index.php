<?php
session_start();
if (array_key_exists('logout', $_GET)) {
    $error = "";
    unset($_SESSION['id']);
    setcookie('id', "", time() - 60 * 60);
    $_COOKIE['id'] = "undf";
    session_destroy();
} else if (array_key_exists('id', $_SESSION) or (array_key_exists('id', $_COOKIE) and $_COOKIE['id'] != "undf")) {
    header('Location: loggedInPage.php');
}
if (array_key_exists('submit', $_POST)) {
    include('include/connection.php');
    if ($_POST['submit'] == 0) {
        // SignUp Code
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $sql = "SELECT `id` FROM `users` WHERE `email`='$email'";
        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($result);

        if (array_key_exists('id', $row)) {
            $error .= "This email id is already taken !";
        } else {
            $sql = "INSERT INTO `users` (`full_name`,`email`,`password`,`diary`) VALUES('$name','$email','$password','')";
            if (!mysqli_query($conn, $sql)) {
                $error .= "Unable to Sign you up - Please try again later";
                // echo mysqli_error($conn);
            }
            $_SESSION['id'] = mysqli_insert_id($conn);
            if ($_POST['stayLoggedIn'] == 1) {
                setcookie('id', mysqli_insert_id($conn), time() + 60 * 60 * 24 * 365);
            }
            header('Location: loggedInPage.php');
        }
    } else {
        // LogIn Code
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (!$row) {
            $error .= "Invalid Email or Password Combination Entered!";
            // print_r($row);
        } else {
            $_SESSION['id'] = $row['id'];
            if ($_POST['stayLoggedIn'] == 1) {
                setcookie('id', $row['id'], time() + 60 * 60 * 24 * 365);
            }
            header('Location: loggedInPage.php');
        }
    }
}

?>


<?php
include('include/header.php');
?>

<body>
    <div class="container align-items-center" id="formContainer">
        <h1 class="text-center logo-name" id="main-logo">Secret Diary</h1>
        <p class="text-center"><strong>Store your thoughts permanently and securly.</strong></p>

        <!-- Sign Up Form -->
        <form method="POST" id="signup-form">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="stayLoggedIn" name="stayLoggedIn" value="1">
                <label class="form-check-label" for="stayLoggedIn">Keep me logged in</label>
            </div>
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-success" name="submit" value="0">SignUp!</button>
            </div>
            <div class="mb-3 text-center">
                <label class="form-label">Already have an account ?</label><br />
                <button type="button" class="btn btn-secondary" id="toggleLogin">Login!</button>
            </div>
        </form>


        <!-- Login Form -->
        <form method="POST" id="login-form" class="hidden">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="stayLoggedIn" name="stayLoggedIn" value="1">
                <label class="form-check-label" for="stayLoggedIn">Keep me logged in</label>
            </div>
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-success" name="submit" value="1">LogIn!</button>
            </div>
            <div class="mb-3 text-center">
                <label class="form-label">New user feel free to register!</label><br />
                <button type="button" class="btn btn-secondary" id="toggleSignup">SignUp!</button>
            </div>
        </form>
        <?php
        if ($error) {
            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
        }
        ?>


    </div>






    <?php include('include/footer.php'); ?>