<?php 
require('database.php');
require('login_functions.inc.php');
if (!isset($_COOKIE['user_id'])){
	redirect_user('iniciar_sesión.php');
} else {
	$data_user = data_user($dbc,$_COOKIE['user_id']);
};

if ($_SERVER['REQUEST_METHOD']=='POST'){
	$nombre = $_POST['nombre'];
	$resultado = buscar_gente($dbc,$nombre,$_COOKIE['user_id']);
	if ($resultado=="No se ha encontrado el usuario"){
		echo "<h1>$resultado</h1>";
	} else {
		echo "<h3>Se han encontrado los siguientes usuarios:</h3>";
		//debug(var_dump($resultado));
		//var_dump($resultado);
		if (isset($resultado)){
			foreach ($resultado as $result) {
				echo "<h3><a href=\"messages.php?nombre=".$result["nombre"]."&id_emisor=".$_COOKIE["user_id"]."&id_receptor=".$result["id"]."\"/>".$result["nombre"]."</a></h3>";
			}
		} else {
			echo "<h3><a href=\"messages.php?nombre=".$resultado["nombre"]."&id_emisor=".$_COOKIE["user_id"]."&id_receptor=".$resultado["id"]."\">".$resultado["nombre"]."</a></h3>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Panel de mensajes</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" href="css/search_bar.css">
  	<script type="text/javascript" src="js/panel_de_mensajes.js">
  	</script>
</head>
<body>

<div class="container">
	<div id="search_users">
		<div class="container">
			<div class="row">
				<h2>Buscar gente del Foro</h2>
				<form action="panel_de_mensajes.php" method="post">
					<div id="custom-search-input">
		               	<div class="input-group col-md-12">
		                    <input type="text" class="search-query form-control" placeholder="Buscar" name="nombre" />
		                    <span class="input-group-btn">
		                    	<button class="btn btn-danger" type="submit">
		                    		<span class="glyphicon glyphicon-search"></span>
		                    	</button>
		                    </span>
		                </div>
		            </div>
				</form>
	           	
			</div>
		</div>
	</div>
	<div id ="users_list">
	<?php 
	$mensajes = user_messages($dbc,$_COOKIE['user_id']);
	//debug($mensajes);
	//var_dump($mensajes);
	if ($mensajes=="No se ha encontrado ningún mensaje suyo"){
		echo "<h2>No se ha encontrado ningún mensaje para usted</h2>";
	} else {
		foreach ($mensajes as $mensaje) {
			echo "<p><a href=\"messages.php?nombre=".$mensaje["nombre"]."&id_emisor=".$_COOKIE["user_id"]."&id_receptor=".$mensaje["id_emisor"]."\">".$mensaje["nombre"].":  ". $mensaje["mensaje"]."</a><p>";
		}
		//echo "<span><a href=\"messages.php?nombre=".$mensaje["nombre"]."&id_emisor=".$_COOKIE["user_id"]."&id_receptor=".$mensaje["id_receptor"]."\">".$mensaje["nombre"].":  ". $mensaje["mensaje"]."</a><span>";
	}
	?>
	</div>
	<button id="Holatrigger" type="button" class="btn btn-info" onclick="refreshdata()">Cargar hola mundo</button>
	<a type="button" class="btn btn-info" href="panel.php">Ir hacia el Panel de usuario</a>
	<div id="Hola">
		
	</div>
</div>

</body>
</html>