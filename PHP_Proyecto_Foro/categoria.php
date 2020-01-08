<?php 
if (!isset($_COOKIE['user_id'])){
	redirect_user('iniciar_sesión.php');
};

require("database.php");
require("login_functions.inc.php");

if ($_SERVER['REQUEST_METHOD']=='POST'){
	enviar_thread($dbc,$_POST['titulo'],$_POST['comentario_principal'],$_POST['id'],$_COOKIE['user_id']);
} else {
	$threads = list_threads($dbc,$_REQUEST['id']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Threads</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" href="css/search_bar.css">
  	<script type="text/javascript" src="js/panel_de_mensajes.js">
  	</script>
</head>
<body>
<?php 
if (!empty($threads)){
	foreach($threads as $thread){
		echo "<p><a href=\"thread.php?id=".$thread['id']."\">".$thread['nombre'].":  <b>".$thread['titulo']."</b>".$thread['comentario_principal']."</a></p>";
	};
} else {
	//var_dump($threads);
	echo "<h1>No hay ningún thread en esta página web, crea uno!</h1>";
};
?>
<div class="container">
	<form class="form-group" action="categoria.php" method="post">
		<p>Introduzca el título aquí: <input class="form-control" type="text" name="titulo"></p>
		<p>Introduzca el comentario o la duda aquí: <textarea class="form-control" name="comentario_principal"></textarea></p>
		<p><input style="display:none;" type="text" name="id" value="<?php echo $_REQUEST['id'] ?>"></p>
		<input class="btn btn-info" type="submit" name="submit">
		<a type="button" class="btn btn-info" href="foro.php">Volver hacia atrás</a>
	</form>
</div>
</body>
</html>