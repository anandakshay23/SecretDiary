<?php
    session_start();
    if(array_key_exists('content',$_POST)){
        include('include/connection.php');
        $id = $_SESSION['id'];
        $content = $_POST['content'];
        $sql = "UPDATE users SET diary='$content' WHERE id='$id' LIMIT 1";
        mysqli_query($conn,$sql);
    }
?>
