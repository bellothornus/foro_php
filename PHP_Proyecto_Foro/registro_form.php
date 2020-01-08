<!DOCTYPE html>
<html>
<head>
	<title>Registro del Foro</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" href="search_bar.css">
</head>
<body>
<?php 

if ($_SERVER['REQUEST_METHOD']=='POST'){
	require('database.php');
	require('login_functions.inc.php');
	//aquí miraremos de ver si el usuario ha introducido un nombre de usuario 
	if (empty($_POST['usuario'])){
		echo '<h1>Ha habido un error con en el campo "usuario", revise el campo.</h1>';
		$error="error";
	}else{
		$usuario = mysqli_real_escape_string($dbc, trim($_POST['usuario']));
	};
	//aquí el primer if mira si los dos campos contienen algo
	//si no, error, si sí, mirará el otro if para ver si concuerdan
	//si concuerdan, guarda la variable para guardarla en la base de datos.
	//si no, no lo guarda y tirará error.
	if (empty($_POST['password']) or (empty($_POST['pass2']))){
		echo '<h1>Ha habido un error con en el campo "contraseña" o confirmar contraseña, revise los campos.</h1>';
		$error="error";
	}else{
		if ($_POST['password']!=$_POST['pass2']){
			echo '<h1> El campo Contraseña no concuerda con la confirmación, inténtelo de nuevo</h1>';
			$error="error";
		}else{
			$contraseña = mysqli_real_escape_string($dbc, trim($_POST['password']));
		}
	};
	//guarda la contraseña
	if (empty($_POST['email'])){
		echo '<h1>El campo email no existe o hay algún error.</h1>';
		$error="error";
	}else{
		$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	//hacemos el input del usuario
	if (!isset($error)){
	$q = "INSERT INTO usuarios (nombre, password, email, creado) VALUES ('$usuario', SHA('$contraseña'), '$email', NOW() )";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if ($r) { // si la query funcionó.

			// muestra esto:
			echo '<h1>Gracias!</h1>
		<p>Estas registado. Ya puedes iniciar sesión</p><p><br></p>';
		} else { // Si no fue bien.

			// Muestra esto:
			echo '<h1>Error del sistema</h1>
			<p class="error">No pudimos registrarte debido a un error. Sentimos el inconveniente.</p>';

			// Muestra también esto para depurar:
			echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $q . '</p>';

		} // fin del if para comprobar la query.
		mysqli_close($dbc);
	};
};
?>
<h1>Registrate:</h1>
<form action="registro_form.php" method="post">
	<p>Nombre de usuario: <input type="text" name="usuario" size="15" maxlength="60" value="<?php if (isset($_POST['usuario'])) echo $_POST['usuario']; ?>"></p>
	<p>Contraseña: <input type="password" name="password" size="15" maxlength="40" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"></p>
	<p>Confirmar contraseña: <input type="password" name="pass2" size="15" maxlength="40" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" ></p>
	<p>Dirección de E-mail: <input type="email" name="email" size="20" maxlength="70" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" > </p>
	
	<p><input type="submit" name="submit" value="Register"></p>
</form>
<a href="iniciar_sesión.php">Iniciar Sesión</a>
</body>
</html>