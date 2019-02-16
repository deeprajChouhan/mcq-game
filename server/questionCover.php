
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
     body{background-color:#f2f2f2}

#frame{
  position:relative;
  padding:0;
  margin:0;
  border:solid 15px #555; 
  max-width:600px;
  margin:40px auto;
  box-shadow:-3px -3px 12px #999;
  
  }
#border{
  position:relative;
  padding:0;
  margin:0;
  border:solid 70px white;
 box-shadow:-3px -3px 12px #999;
     }  
img{
  display:block;
  padding:0;
  margin:0;
  width:100%;
  height:auto;
  border-top:solid 2px #aaa;
  border-left:solid 2px #aaa;
  border-bottom:solid 2px #ccc;
  border-right:solid 2px #ccc;
  }
 
</style>
<?php
    session_start();
    include 'connection.php';
    if($_GET['answer']){
        $answer = $_GET['answer'];
    }
    $question_id =  $_SESSION['queid'];
    $sql_check = "select * from questions_details where qid='$question_id' and answer='$answer'";
    $res = $conn->query($sql_check);
    $row = $res->fetch_array();
    if($row['answer'] == $answer){
        $email = $_SESSION['email'];
        $sql_answered = "select answered,questions from logindetails where email='$email'";
        $res = $conn->query($sql_answered);
        $row_answer = $res->fetch_array();
        $question_array = explode(" ",$row_answer['questions']);
        $questions_string = implode(" ",$question_array);
        $answers_string = $row_answer["answered"];
        $key = array_rand($question_array,1);
        $queid = $question_array[$key];
        $_SESSION['queid'] =  $queid;
        $answer = $question_array[$key];
        unset($question_array[$key]);
        $sql = "select path from questions_details where qid=".$queid."";
                $res = $conn->query($sql);
                while($row = $res->fetch_array()){
                    $path = $row["path"];
                    $_SESSION['path'] = $path;
                    echo "
                    <div id='frame'>
                    <div id='border'>
                      <img src='".$path."' alt='Drawing'>
                    </div><!-- #border -->
                  </div><!-- #frame -->
                    ";
                }
                $email = $_SESSION['email'];
                $sql_insert = "update logindetails set answered ='$answers_string $answer',questions='$questions_string' where email = '$email'";
                $conn->query($sql_insert);
           
    }else{
        $path = $_SESSION['path'];
        echo "<script>document.getElementById('wrong').style.display = 'block';</script>";
        echo "
        <div id='frame'>
        <div id='border'>
          <img src='".$path."' alt='Drawing'>
        </div><!-- #border -->
      </div><!-- #frame -->
        ";
        echo '
        <div class="alert alert-danger">
        <strong>Wrong answer.</strong>
        </div>
        ';
    }
?>