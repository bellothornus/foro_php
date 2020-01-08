$(document).ready(function() {
	function like(){
  		var display = document.getElementById("content");
  		var xmlhttp = new XMLHttpRequest();
  		var id_usuario = $("#user_id").value();
  		var id_comentario = $(this).parent().parent().attr("id");
  		var id_usuario_likeado = $(this).parent().parent().attr("id_usuario");
  		xmlhttp.open("GET", "like.php?id_usuario="+id_usuario+"&id_comentario="+id_comentario+"&id_usuario_likeado="+id_usuario_likeado	);
  		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  		xmlhttp.send();
  		xmlhttp.onreadystatechange = function() {
    		if (this.readyState === 4 && this.status === 200) {
      			//display.innerHTML = this.responseText;
      			$(this).attr({
      				disabled: 'true'
      			});
      			
    		} else {
      			//display.innerHTML = "Loading...";
      			$(this).text("Loading...");
    		};
  		}
	}
});