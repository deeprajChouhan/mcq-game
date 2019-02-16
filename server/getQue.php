<?php
    error_reporting(0);
    include 'connection.php';
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    if($_GET['que']){
        $que = $_GET['que'];
        $sql = "select * from questions_details where name = '$que'";
        $res = $conn->query($sql);
        $questions = "";
        while($row_questions = $res->fetch_array()){
            $questions = '{"name" : "'.$row_questions[name].'","path" : "'.$row_questions[path].'"}';
        }
        echo '{"records" : "'.$questions.'"}';
    }
?>