<?php # Script 12.4 - loggedin.php
// The user is redirected here from login.php.

// If no cookie is present, redirect the user:
if (!isset($_COOKIE['user_id'])) {

	// Need the functions:
	require('login_functions.inc.php');
	redirect_user('iniciar_sesión.php');

}
// Print a customized message:
$mensaje =  "<h1>Has inicado Sesión!</h1>
<p>Has iniciado sesión, {$_COOKIE['username']}!</p>
<p><a href=\"logout.php\">Salir de la sesión</a></p>
<p><a href=\"panel.php\">Ir a tu panel de usuario</a></p>";
?>
<!DOCTYPE html>
<html>
<head>
	<title>sesion inicada</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div> <?php echo $mensaje; ?> </div>
	<div>
		<span> Aquí puedes buscar a una persona registrada en el foro:</span>
	</div>
</body>
</html>