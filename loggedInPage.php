<?php

    session_start();

    if(array_key_exists("id",$_COOKIE)) {
        $_SESSION['id']=$_COOKIE['id'];
    }

    if(array_key_exists("id",$_SESSION)) {
        echo "<p>Logged In! <a href='index.php?logout=1'>Logout</a></p>";
    } else {
        header("Location: index.php");
    }


    include ("header.php");

?>

<div class="container-fluid">

    <div class="form-group">
        <textarea class="form-control" id="diary" rows="3"></textarea>
    </div>



</div>





<?php


    include ("footer.php");


?>