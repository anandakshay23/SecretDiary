<?php
    $db_hostname = "localhost";
    $db_username = "root";
    $db_password = "root";
    $db_dbname = "secret_diary";
    $conn = mysqli_connect($db_hostname,$db_username,$db_password,$db_dbname);
    if(!$conn){
        die("Connection Error");
    }
?>