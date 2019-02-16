<?php
    include 'connection.php';
    session_start();
    $uname = $_SESSION['uname'];
    $sql = "select answered from logindetails where uname = '$uname'";
    $res = $conn->query($sql);
    $row = $res->fetch_array();
    $array = explode(" ",$row['answered']);
    $array_sort = array_unique($array);
    echo sizeof($array_sort) - 2;
?>