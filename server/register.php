<?php
    include 'connection.php';
    if(isset($_GET['values'])){
        $values = $_GET['values'];
    }
    $values = explode(",",$values);
    $sql_select = "select qid from questions_details";
    $res_select = $conn->query($sql_select);
    $out_data = array();
    while($row_select = $res_select->fetch_array()){
        array_push($out_data,$row_select['qid']);
    }
    $out_string = implode(" ",$out_data);
    echo $sql = "insert into logindetails (uname,uname1,email,password,questions) values ('$values[0]','$values[1]','$values[2]','$values[3]','$out_string')";
    if($conn->query($sql)) header("Location:../client/");
?>