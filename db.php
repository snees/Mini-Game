<?php
    $host = "localhost";
    $userid = "root";
    $userpw = "#904033d6!";
    $databasename ="MIN";

    $conn = mysqli_connect($host, $userid, $userpw, $databasename);
    mysqli_query($conn, "set session character_set_connection=utf8;");
    mysqli_query($conn, "set session character_set_results=utf8;");
    mysqli_query($conn, "set session character_set_client=utf8;");

?>