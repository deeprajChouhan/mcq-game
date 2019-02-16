<!DOCTYPE html>
<?php 
  include '../../server/connection.php';
  session_start();
?>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Game profile concept (Responsive)</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,500,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
  
  
      <link rel="stylesheet" href="css/style.css">

  
</head>
<?php
  $uname = $_SESSION['uname'];
  $sql = "select answered from logindetails where uname = '$uname'";
  $res = $conn->query($sql);
  $row = $res->fetch_array();
  $answers = $row['answered'];
  $answers = explode(" ",$answers);
  $answers = array_unique($answers);
  $sql_pos = "select * from logindetails";
  $res_pos = $conn->query($sql_pos);
  $ans_form = array();
  $details = array();
  $ararys_sort = array();
  while($row_pos = $res_pos->fetch_array()){
    $uname = $row_pos['uname'];
    $arrays = explode(" ",$row_pos['answered']);
    $arrays_sort = array_unique($arrays);
    array_push($details,$uname,sizeof($arrays_sort));
    array_push($ans_form,$details);
    $details = array();
  } 
?>
<body>
<?php
  $size = sizeof($answers) - 2;
  $email = $_SESSION['email'];
  $sql = "update logindetails set counter='$size' where email='$email'";
  $conn->query($sql);
?>
  <main class="profile">
  <h1 class="profile-title">
    Game Over
  </h1>
  <div class="profile-container">
    <div class="user">
      <div class="image-container">
        <img alt="" class="avatar" src="https://image.freepik.com/free-vector/coloured-knight-design_1152-54.jpg" />
      </div>
      <div class="user-info">
        <p class="user-name">
          <?php echo $_SESSION['uname'];?>
        </p>
        <div class="user-subinfo">
          <p class="user-class">
            <?php echo $_SESSION['email'];?>
          </p>
        
        </div>
      </div>
    </div>
    <div class="info-container">
      <div class="info">
        <div class="title">
          Score
        </div>
        <div class="description">
        <?php echo (sizeof($answers)-2) * 5;?>
        </div>
      </div>
      <div class="info">
        <div class="title">
          Total Questions
        </div>
        <div class="description">
          <?php echo sizeof($answers) - 2;?>
        </div>
      </div>
    
      <div class="span share-btn">
        <i class="material-icons">share</i>
      </div>
      <div class="span share-btn">
        <i class="material-icons"><a href="../../server/logout.php">done</i>
      </div>
    </div>
  </div>
</main>
  
  

    <script  src="js/index.js"></script>




</body>

</html>
