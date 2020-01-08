<?php 
if (!isset($_COOKIE['user_id'])){
	redirect_user('iniciar_sesión.php');
};

require("database.php");
require("login_functions.inc.php");

if ($_SERVER['REQUEST_METHOD']=='POST'){
	$comentario = $_POST['comentario'];
	$id_usuario = $_COOKIE['user_id'];
	$id_thread = $_POST['id_thread'];
	enviar_comentario($dbc,$comentario,$id_usuario,$id_thread);
} else {
	$comentarios = listar_comentarios($dbc,$_REQUEST['id']);
	$comprobacion = comprobar_comentario($dbc,$_COOKIE["user_id"]);
}
$previous = $_SERVER['HTTP_REFERER'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Thread</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" href="css/search_bar.css">
  	<script type="text/javascript" src="js/thread.js">
  	</script>
  	<script type="text/javascript" charset="utf-8">
	$(function(){    
	    $(".like").click(function() {
	  		var display = document.getElementById("content");
	  		var xmlhttp = new XMLHttpRequest();
	  		var id_usuario = $("#user_id").attr("value");
	  		var id_comentario = $(this).parent().parent().attr("id");
	  		var id_usuario_likeado = $(this).parent().parent().attr("id_usuario");
	  		var id_thread = $("#id_thread").attr("value");
	  		var button =  this;
	  		xmlhttp.open("GET", "like.php?id_usuario="+id_usuario+"&id_comentario="+id_comentario+"&id_usuario_likeado="+id_usuario_likeado+"&id_thread="+id_thread);
	  		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	  		xmlhttp.send();
	  		xmlhttp.onreadystatechange = function() {
	    		if (this.readyState === 4 && this.status === 200) {
	      			//display.innerHTML = this.responseText;
	      			$(button).attr({
	      				disabled: 'true'
	      			});
	      			console.log("Ha funcionado la petición");
	      			var text = $(button).text();
	      			$(button).text(parseFloat(text)+1);
	    		} else {
	      			$(this).text("Loading...");
	      			console.log(this.responseText);
	    		};
	  		}
		});
		$(".dislike").click(function() {
	  		var display = document.getElementById("content");
	  		var xmlhttp = new XMLHttpRequest();
	  		var id_usuario = $("#user_id").attr("value");
	  		var id_comentario = $(this).parent().parent().attr("id");
	  		var id_usuario_likeado = $(this).parent().parent().attr("id_usuario");
	  		var id_thread = $("#id_thread").attr("value");
	  		var button =  this;
	  		xmlhttp.open("GET", "dislike.php?id_usuario="+id_usuario+"&id_comentario="+id_comentario+"&id_usuario_likeado="+id_usuario_likeado+"&id_thread="+id_thread);
	  		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	  		xmlhttp.send();
	  		xmlhttp.onreadystatechange = function() {
	    		if (this.readyState === 4 && this.status === 200) {
	      			$(button).attr({
	      				disabled: 'true'
	      			});
	      			console.log("Ha funcionado la petición");
	      			var text = $(button).text();
	      			$(button).text(parseFloat(text)+1);
	    		} else {
	      			$(this).text("Loading...");
	      			console.log(this.responseText);
	    		};
	  		}
		});
	});
  	</script>
</head>
<body>
<div class="container">
	<form class="form-group" action="thread.php" method="post">
		<p>Introduzca el comentario: <textarea class="form-control" name="comentario"></textarea></p>
		<p><input id="id_thread"style="display:none;" type="text" name="id_thread" value="<?php echo $_REQUEST['id'] ?>"></p>
		<input class="btn btn-info" type="submit" name="submit">
		<a type="button" class="btn btn-info" href="<?php echo $previous ?>">Volver hacia atrás</a>
	</form>
	<?php 
	$array = [];
	foreach ($comprobacion as $cmp) {
		array_push($array, [$cmp["id_comentarios"],$cmp["like"]]);
	}
	echo "<div class=\"container\">";
	foreach($comentarios as $comentario){
		echo "<p><b>".$comentario["nombre"].":</b> "."</p>";
		echo "<p>".$comentario['comentario']."</p>";
		echo "<p>".$comentario["creado"]."</p>";
		echo "<div class=\"row\" id=\"".$comentario["id"]."\" id_usuario=\"".$comentario["id_usuario"]."\">";
		$interactuado=[];
		foreach ($array as $ar) {
			if (($comentario["id"]==$ar[0]) and ($ar[1]=="1")) {
				echo "<div class=\"col-xs-1\">";
				echo "<button disabled=\"true\" class=\"glyphicon glyphicon-thumbs-up like btn btn-success\">".$comentario["likes"]."</button>";
				echo "</div>";
				echo "<div class=\"col-xs-11\">";
				echo "<button class=\"glyphicon glyphicon-thumbs-down dislike btn btn-danger\">".$comentario["dislikes"]."</button>";
				echo "</div>";
				echo "<input style=\"display:none;\"type=\"text\" value=\"".$comentario["id"]."\"/>";
				array_push($interactuado, 1);
				break;
			} elseif (($comentario["id"]==$ar[0]) and ($ar[1]=="0")) {
				echo "<div class=\"col-xs-1\">";
				echo "<button class=\"glyphicon glyphicon-thumbs-up like btn btn-success\">".$comentario["likes"]."</button>";
				echo "</div>";
				echo "<div class=\"col-xs-11\">";
				echo "<button disabled=\"true\"class=\"glyphicon glyphicon-thumbs-down dislike btn btn-danger\">".$comentario["dislikes"]."</button>";
				echo "</div>";
				echo "<input style=\"display:none;\"type=\"text\" value=\"".$comentario["id"]."\"/>";
				array_push($interactuado, 1);
				break;
			} else {
				continue;
			};
		};
		if (empty($interactuado)){
			echo "<div class=\"col-xs-1\">";
			echo "<button class=\"glyphicon glyphicon-thumbs-up like btn btn-success\">".$comentario["likes"]."</button>";
			echo "</div>";
			echo "<div class=\"col-xs-11\">";
			echo "<button class=\"glyphicon glyphicon-thumbs-down dislike btn btn-danger\">".$comentario["dislikes"]."</button>";
			echo "</div>";
			echo "<input style=\"display:none;\"type=\"text\" value=\"".$comentario["id"]."\"/>";
		} else {
			array_diff($interactuado, ["1"]);
		};
		echo "</div>";
	};
	echo "</div>";
	?>
	<input id="user_id" type="text" name="" value="<?php echo $_COOKIE['user_id']?>" style="display:none;">
</div>
</body>
</html>