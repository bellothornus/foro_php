<?php # Script 12.6 - logout.php
// This page lets the user logout.

// If no cookie is present, redirect the user:
if (!isset($_COOKIE['user_id'])) {

	// Need the function:
	require('includes/login_functions.inc.php');
	redirect_user('iniciar_sesión.php');

} else { // Delete the cookies:
	setcookie('user_id', '', time()-3600, '/', '', 0, 0);
	setcookie('username', '', time()-3600, '/', '', 0, 0);
}

// Print a customized message:
$mensaje =  "<h1>has salido de la sesión!</h1>
<p>Has salido de la sesión, {$_COOKIE['username']}!</p>
<p><a href=\"iniciar_sesión.php\">Iniciar sesión</a></p>";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Logout!</title>
</head>
<body>
	<div> <?php echo $mensaje; ?> </div>
</body>
</html>