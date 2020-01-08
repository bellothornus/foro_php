<!DOCTYPE html>
<html>
<head>
	<title>Iniciar sesión</title>
</head>
<body>
<?php 
require('database.php');
require('login_functions.inc.php');
if ($_SERVER['REQUEST_METHOD']=='POST'){
	list($check, $data) = check_login($dbc, $_POST['usuario'], $_POST['password']);
	if ($check) { // OK!

		// Set the cookies:
		setcookie('user_id', $data['id']);
		setcookie('username', $data['nombre']);

		// Redirect:
		redirect_user('sesion_iniciada.php');

	} else { // Unsuccessful!

		// Assign $data to $errors for error reporting
		// in the login_page.inc.php file.
		$errors = $data;

	}

	mysqli_close($dbc); // Close the database connection.
}
?>
<form action="iniciar_sesión.php" method="post">
	<span>Usuario:</span>
	<input type="text" name="usuario">
	<span>Contraseña:</span>
	<input type="password" name="password">
	<span>Confirmar Contraseña:</span>
	<input type="password" name="pass2">
	<input type="submit" name="submit">
</form>
</body>
</html>