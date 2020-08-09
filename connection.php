<?php

    $link = mysqli_connect("localhost","root","root","secretID");

    if(mysqli_connect_error()){
        die("You are not connected with database");
    }

?>