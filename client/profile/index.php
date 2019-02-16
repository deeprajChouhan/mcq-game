<!DOCTYPE html>
<html lang="en" >
<?php session_start(); ?>
<head>
  <meta charset="UTF-8">
  <title>City 3D</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css'>

      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>

  
<div class="container-fluid fixed-top header disable-selection">
  <div class="row">
    <div class="col"></div>
    <div class="col-md-6">
      <div class="row">
        <div class="col">
          <h1><strong><?php echo $_SESSION["uname"]; ?>></strong></h1>
          <p class="small"><?php echo $_SESSION["email"];?></p>
          <p class="strong"><a class='follow' href="../gamePannel/">Start Game</a></p>
          <!--.btn.btn-danger(href='#',role='button', onclick='cameraSet()') + ADD LINE-->
        </div>
      </div>
    </div>
    <div class="col"></div>
  </div>
</div>
<!--.container-fluid.fixed-bottom.footer
.row
 .col
  h4 Experiment N.3
  small
   a(href='https://dribbble.com/victorvergara', target='_blank') dribbble.com/victorvergara
-->
  <script src='js/three.min.js'></script>
<script src='js/constants.js'></script>
<script src='js/bootstrap.min.js'></script>
<script src='js/TweenMax.min.js'></script>

  

    <script  src="js/index.js"></script>




</body>

</html>
