<?php
    $hostname = "localhost";
    $user = "root";
    $password = "";
    $dbname = "instacatta";

    $conn = mysqli_connect($hostname, $user, $password, $dbname);

    if(!$conn){
        die("Something goes wrong");
    }
?>