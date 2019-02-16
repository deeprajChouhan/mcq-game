<!DOCTYPE html>
<html lang="en" >
<?php
?>
<head>
  <meta charset="UTF-8">
  <title>Craigslist Dashboard</title>
  
   <?php session_start();?>

    <link rel="stylesheet" href="css/style.css">

<script src="js/angular.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>
 <link rel="stylesheet" href="css/style.css">

  <script>
    var counter = 1;
  </script>
</head>
<script src='http://cdnjs.cloudflare.com/ajax/libs/three.js/r70/three.min.js'></script>
<script src="js/theme.js"></script>
<body ng-app="imgApp" ng-controller="myCtrl" onload="displayImage()">

  <!--
  Couldnt Resist, looked too good not to try

  https://dribbble.com/shots/1847266-Craigslist-Redesign?list=searches&tag=craigslist&offset=1
-->


<nav class="app--nav state--loaded">
  
  <!--Logo-->
  <a href="#" class="app--logo">Play Here</a>
  
  <!--Side nav filters-->
  <div class="rslt__fltr">  

    <!--area filter-->
    <div class="rslt__fltr ui-nav-menu" js-ui-menu>
    <label for="search" class="hdr__srch">
      <center><h1><div id="counter">
      </div></h1></center>
      </label>
    </div>
    <div class="rslt__fltr ui-nav-menu" js-ui-menu>
    <label for="search" class="hdr__srch">
        <input type="text" class="srch__txt" name="search" style="border:0.5px solid white;width:90%;" id="search" placeholder="Try Here" onclick="checkAns()"/>
        <span class="srch__icn"><i class="ion-ios-search"></i></span>
      </label>
    </div>
  
    <div class="rslt__fltr__acts">
      <button class="btn__rds btn__prim btn-act--reset" onclick="check()">
        <span class="btn__seg btn__seg--txt">Submit Answer</span>
      </button>
    </div>
    <div class="rslt__fltr ui-nav-menu" js-ui-menu>
    <div style="border:0.5px solid white;width:91%;"> 
          Time left : 
        <input id="minutes" type="text" style="width: 20px; 
             border: none; font-size: 21px;  
            font-weight: bold; color: white;"><font size="5" readonly> : 
        </font> 
        <input id="seconds" type="text" style="width: 20px; 
        border: none; font-size: 21px;  
       font-weight: bold; color: white;" readonly>
    </div> 
    <script  src="js/timer.js"></script>
  </div>
    
    
    
  </div>
</nav>

<main class="app--core">
  <?php include '../bar/index.php';?>
  <br><br><br><br><br><br><div style="margin-left:24%;" id='img' class="que">
  
  </div>  
</main>

<script src="js/work.js"></script>
<script  src="js/index.js"></script>





</body>

</html>
