<?php 
if (!isset($_COOKIE['user_id'])){
	redirect_user('iniciar_sesión.php');
};

require("database.php");
require("login_functions.inc.php");
if ($_SERVER['REQUEST_METHOD']=='POST'){
	$mensaje = $_POST['mensaje'];
	$id_emisor = $_POST['id_emisor'];
	$nombre = $_POST['nombre'];
	$id_receptor = $_POST['id_receptor'];
	enviar_mensaje($dbc,$mensaje,$id_emisor,$id_receptor,$nombre);
} else {
	if ($_REQUEST['id_emisor']!=$_COOKIE['user_id']){
	redirect_user('iniciar_sesión.php');
	}
	$nombre = $_REQUEST['nombre'];
	$id_receptor = $_REQUEST['id_receptor'];
	$id_emisor = $_REQUEST['id_emisor'];
	$mensajes = mensajes_emisor_receptor($dbc, $id_emisor, $id_receptor);
	if ($mensajes=="No se ha encontrado ningún mensaje con este usuario"){
		echo "<h1>$mensajes</h1>";
	} else {

	}
};

?>
<!DOCTYPE html>
<html>
<head>
	<title>Mensajes</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" href="search_bar.css">
</head>
<body>
	<div class="container">
		<div id="nombre">
			<span><?php echo "Enviando mensajes a: ".$nombre; ?></span>
		</div>	
		<div id="mensajes">
			<?php 
			//var_dump($mensajes);
			//for($i=0;$i<=count($mensajes);$i++){
			//	echo '<p>'.$mensajes["nombre"].': '.$mensajes["mensaje"].'</p>';
			//}
			foreach ($mensajes as $mensaje) {
				echo "<p>".$mensaje["nombre"].":". $mensaje["mensaje"]."   ". $mensaje["creado"]."</p>";
			}

			?>
		</div>	
	
	<form action="messages.php" method="post">
		<p>Mensaje a enviar: <input type="text" name="mensaje"></p>
		<p><input style="display:none;" type="text" name="nombre" value=<?php echo $_REQUEST['nombre'];?>></p>
		<p><input style="display:none;" type="text" name="id_emisor" value=<?php echo $_REQUEST['id_emisor'];?>></p>
		<p><input style="display:none;" type="text" name="id_receptor" value=<?php echo $_REQUEST['id_receptor']?>></p>
		<input type="submit" name="submit" value="Enviar Mensaje" class="btn btn-info">
		<a href="panel_de_mensajes.php" class="btn btn-info">Volver hacia atrás</a>
	</form>
	
	</div>
</body>
</html>