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
    if(isset($_GET['id'])){
        $id = $_GET["id"];
     
    }
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    function checkAns($ans,$path){
        include 'connection.php';
        echo $sql = "select qid from questions_details where qid = '$path' and answer='$ans'";
        $res = $conn->query($sql);
        $row = $res->fetch_array();
        if($row == 0){
            return 0;
        }else{
            return 1;
        }
    }
    function perform($id){
        $id_arr = explode("@",$id);
        $uid = $id_arr[0];
        $qno = $id_arr[1];
        $path = $id_arr[2];
        include 'connection.php';
        $sql = "select * from questions_details";
        $res = $conn->query($sql);
        $out_data = array();
        $count = 0;
        while($row = $res->fetch_array()){
            if($id == 0 || $id == 1){
                array_push($out_data,$row['qid']);
            }   
        }
        
        if($id == 0){     
        $key = array_rand($out_data,1);
        $question = $out_data[$key];
                $sql = "select path from questions_details where qid=".$question."";
                $res = $conn->query($sql);
                while($row = $res->fetch_array()){
                    $path = $row["path"];
                    $_SESSION['queid'] = $question;
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
                unset($out_data[$key]);
                $out_string = implode(" ",$out_data);
                $sql_insert = "update logindetails set answered='$question ',questions='$out_string' where email = '$email'";
                $conn->query($sql_insert);
        }
       /* $answered = array();
        if($id == 1){

                    if(checkAns($id_arr[1],$_SESSION['queid'])){
                        $email = $_SESSION['email'];
                        $sql_get = "select answered from logindetails where email='$email'";
                        $res = $conn->query($sql_get);
                        while($row = $res->fetch_array()){
                            $answered = explode(" ",$row['answered']);
                        }
                        print_r($answered);
                        $key = array_rand($out_data,1);
                        $question = $out_data[$key];
                        if(in_array($question,$answered)){
                            echo "match found";
                        }
                        echo $sql = "select path from questions_details where qid=".$question."";
                        $res = $conn->query($sql);
                         while($row = $res->fetch_array()){
                            $path = $row["path"];
                            $_SESSION['path'] = $path;
                           echo "<center><img id='imgSrc' src='$path'/></center>";
                        } 
                        $email = $_SESSION['email'];
                        $sql_insert = "update logindetails set answered='$question ' where email = '$email'";
                        $conn->query($sql_insert);  
                    }else{
                        echo "wrong ans";
                        $id = $_SESSION['queid'];
                        $path = $_SESSION['path'];
                        echo "<center><img id='imgSrc' src='$path'/></center>";
                    }        
                    
        }*/
    }
    perform($id);
   
?>