function refreshdata(){
  var display = document.getElementById("content");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET", "hello.php");
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp.send();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      //display.innerHTML = this.responseText;
      $("#Hola").text(this.responseText);
      $("#Holatrigger").attr({
      	disabled: 'true'
      });
    } else {
      //display.innerHTML = "Loading...";
      $("#Hola").text("Loading...");
    };
  }
}

function buscar_gente(){
  var display = document.getElementById("content");
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET", "buscar_gente.php");
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp.send(
  	""
  	);
  xmlhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      //display.innerHTML = this.responseText;
      $("#Hola").text(this.responseText);
    } else {
      //display.innerHTML = "Loading...";
      $("#Hola").text("Loading...");
    };
  }
}