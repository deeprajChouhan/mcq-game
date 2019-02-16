<?php
    include 'connection.php';
    session_start();
    if(isset($_POST["submit"])){
        $uname =  $_POST["username"];
        $pass = $_POST["password"];
        $_SESSION['uname'] = $uname;
        echo $sql = "select * from logindetails where uname = '$uname' and password = '$pass'";
        $res = $conn->query($sql);
        $row = $res->fetch_array();
        if($row["uname"] == $uname && $row["password"] == $pass){
            $_SESSION["email"] = $row["email"];
            $_SESSION['uname'] = $uname;
            header("Location:../client/profile/");
        }else{
            header("Location:../client/login");
        }
    }

?>