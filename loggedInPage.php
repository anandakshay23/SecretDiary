<?php
session_start();
if (array_key_exists('id', $_COOKIE)) {
    $_SESSION['id'] = $_COOKIE['id'];
}
if (array_key_exists('id', $_SESSION)) {
    include('include/connection.php');
    $id = intval($_SESSION['id']);
    $sql = "SELECT * FROM `users` WHERE id=$id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        echo "Error in Fetching data";
    }
    $name = $row['full_name'];
    $content = $row['diary'];
} else {
    header("Location: index.php");
}
?>

<?php
include('include/header.php');
?>

<body>
    <nav class="navbar sticky-top navbar-light bg-light" id="logginInPage-navbar">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 logo-name" id="navbarLogo">Secret Diary</span>
            <div class="d-flex">
                <span class="navbar-brand mb-0 h3" id="user-name">
                    <?php echo $name; ?>
                </span>
                <a href='index.php?logout=1'><button class="btn btn-outline-success">Logout</button></a>
            </div>
        </div>
    </nav>
    <div class="container" id="diaryContainer">
        <textarea name="diary" id="diary" class="form-control" data-gramm_editor="false">
        <?php echo $content; ?>
        </textarea>
    </div>

    <?php include('include/footer.php'); ?>