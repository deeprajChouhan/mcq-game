function getQue(){

}
function displayImage(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("img").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "../../server/getData.php?id=0@20@0", true);
  xhttp.send();
}

function check(){
  var ans = document.getElementById("search").value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("img").innerHTML = this.responseText;
    }
  };
  document.getElementById("search").value = "Try Here..";
  var xhttp1 = new XMLHttpRequest();
  xhttp1.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(this.responseText == 35) window.location.assign("../");
      document.getElementById("counter").innerHTML = this.responseText;
      
    }
  }
  xhttp.open("GET", "../../server/questionCover.php?answer="+ans, true);
  xhttp.send();
  xhttp1.open("GET" , "../../server/getSize.php",true);
  xhttp1.send();
}
setInterval(function(){ window.location.assign("../after/"); }, 3600000);

