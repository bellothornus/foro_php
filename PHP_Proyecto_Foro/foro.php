<?php 
if (!isset($_COOKIE['user_id'])){
	redirect_user('iniciar_sesión.php');
};

require("database.php");
require("login_functions.inc.php");

if ($_SERVER['REQUEST_METHOD']=='POST'){
	
} else {
	$categorias = list_categories($dbc);
};
?>
<!DOCTYPE html>
<html>
<head>
	<title>Foro</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" href="css/search_bar.css">
  	<script type="text/javascript" src="js/panel_de_mensajes.js">
  	</script>
</head>
<body>
<div class="container">
	<p>Categorías del Foro:</p>
	<?php 
	foreach ($categorias as $categoria){
		echo "<p><a href=\"categoria.php?id=".$categoria["id"]."\">".$categoria["nombre"]."</a></p>";
	}
	?>
</div>
</body>
</html>