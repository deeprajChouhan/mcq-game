<!DOCTYPE html>
<html lang="en" >

<?php 
error_reporting(0);
session_start();?>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

  <link href='https://fonts.googleapis.com/css?family=Alegreya+Sans+SC' rel='stylesheet' type='text/css'>

  
  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>

  <nav class="nav-user navbar-fixed-top topnav" role="navigation">
  <a href="#" class="logo"><i class="fa fa-th-large"></i></a>
  <p>Brain-A-Thon</p>
  
  <div class="nav-right-c">     
    <li class="drop-wrap">
      <a href="#" id="drop1" class="link-c dropdown-toggle" data-toggle="dropdown" role="button">
     <?php echo $_SESSION['uname'];?><i class="fa fa-caret-down"></i>
        <ul class="dropdown-menu pull-right" aria-labelledby="drop1">
          <li><a href="../after/">Logout</a></li>
          <li><a href="#">Help</a></li>
        </ul>
      </a>
    </li>
  </div><!--- end nav-right-c --->
</nav>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>

  

</body>

</html>
