<?php 
require('database.php');
require('login_functions.inc.php');
if (!isset($_COOKIE['user_id'])){
	redirect_user('iniciar_sesión.php');
} else {
	$data_user = data_user($dbc,$_COOKIE['user_id']);
};
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Panel de usuario</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" href="css/search_bar.css">
  	<script type="text/javascript" src="js/panel_de_mensajes.js">
  	</script>
</head>
<body>
<?php debug($data_user); ?>

<a href="panel_de_mensajes.php">Ve al panel de Mensajes</a>
<br>
<a href="foro.php">Llévame al foro!</a>
</body>
</html>