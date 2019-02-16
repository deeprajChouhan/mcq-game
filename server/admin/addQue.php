<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="post"  enctype="multipart/form-data">
        <input type="text" name="ques" id="ques" placeholder="question name" required/>
        <input type="text" name="ans" id="ques" placeholder="answer" required/>
        <input type="file" name="Filename" required>
        <input type="submit" value="submit">
        <?php
            include '../connection.php';
            if(isset($_FILES["Filename"])){
                $name = $_POST["ques"];
                $ans = $_POST["ans"];
                $file_name = $_FILES['Filename']['name'];
                $file_size =$_FILES['Filename']['size'];
                $file_tmp =$_FILES['Filename']['tmp_name'];
                $file_type=$_FILES['Filename']['type'];
                $target = "../../server/questions/".$name;
                $target = $target . basename( $_FILES['Filename']['name']);
                move_uploaded_file($_FILES['Filename']['tmp_name'],$target);
                $sql = "insert into questions_details (name,path,answer) values ('$name','$target','$ans')";
                if($conn->query($sql)){
                    echo "<script>window.location.assign('addQue.php');</script>";
                }
            }   
        ?>
    </form>
</body>
</html>
<?php

?>