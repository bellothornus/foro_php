<?php # Script 12.2 - login_functions.inc.php
// This page defines two functions used by the login/logout process.

/* This function determines an absolute URL and redirects the user there.
 * The function takes one argument: the page to be redirected to.
 * The argument defaults to index.php.
 */
function redirect_user($page = 'index.php') {

	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');

	// Add the page:
	$url .= '/' . $page;

	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script.

} // End of redirect_user() function.


/* This function validates the form data (the email address and password).
 * If both are present, the database is queried.
 * The function requires a database connection.
 * The function returns an array of information, including:
 * - a TRUE/FALSE variable indicating success
 * - an array of either errors or the database result
 */
function check_login($dbc, $email = '', $pass = '') {

	$errors = []; // Initialize error array.

	// Validate the email address:
	if (empty($email)) {
		$errors[] = 'You forgot to enter your username.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($email));
	}

	// Validate the password:
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($pass));
	}

	if (empty($errors)) { // If everything's OK.

		// Retrieve the user_id and first_name for that email/password combination:
		$q = "SELECT id, nombre FROM usuarios WHERE nombre='$e' AND password=SHA('$p')";
		$r = @mysqli_query($dbc, $q); // Run the query.

		// Check the result:
		if (mysqli_num_rows($r) == 1) {

			// Fetch the record:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

			// Return true and the record:
			return [true, $row];

		} else { // Not a match!
			$errors[] = 'The email address and password entered do not match those on file.';
		}

	} // End of empty($errors) IF.

	// Return false and the errors:
	return [false, $errors];

} // End of check_login() function.
function data_user($dbc,$user_id){
	$errors = [];

	if (empty($errors)){
		$q = "SELECT * FROM usuarios WHERE id='$user_id'";
		$r = @mysqli_query($dbc,$q);

		if (mysqli_num_rows($r) == 1){
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			return [true, $row];
		} else {
			$errors[]= 'Ha habido un error en el codigo, vuelvalo a intentar';
		}
	}
	return [false, $erros];
};

function debug($data){
	if (is_array($data)){
		foreach($data as $d){
			if (is_array($d)){
				foreach($d as $d2){
					echo '<script> console.log("'.$d2.'")</script>';
				};
			} else {
				echo '<script> console.log("'.$d.'")</script>';
			};
		};
	} else {
		echo '<script> console.log("'.$data.'")</script>';
	}
};

function user_messages($dbc, $user_id){
	$errors = [];
	if (empty($errors)){
		//$q = "SELECT mensaje, nombre, id_emisor, id_receptor from mensajes inner join usuarios on usuarios.id=mensajes.id_receptor where id_emisor='$user_id'";
		//select mensaje, nombre, id_emisor, id_receptor from mensajes
		//where (id_emisor='$user_id' or id_emisor='$id_receptor') and (id_receptor='id_receptor' or id_receptor='$user_id')
		//order by creado


		$q = "SELECT MIN(mensaje) as mensaje, nombre, id_receptor, id_emisor from mensajes 
				inner join usuarios on usuarios.id=mensajes.id_emisor  
				where id_receptor='$user_id' and id_emisor!='$user_id' 
				-- order by mensajes.creado 
				group by nombre
				order by mensajes.creado asc;";
		//$r = @mysqli_query($dbc,$q);
		$r = $dbc->query($q);
		if (mysqli_num_rows($r)>=1){
			//$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			//return $row;
			return $r;
		} else {
			$errors= "No se ha encontrado ningún mensaje suyo";
		}
	}
	return $errors;
};
function mensajes_emisor_receptor($dbc, $id_emisor, $id_receptor){
    $errors = [];
    if (empty($errors)){
    	$q = "SELECT mensajes.id,mensaje, nombre, id_receptor,mensajes.creado from mensajes inner join usuarios on usuarios.id=id_emisor where id_receptor='$id_receptor' and id_emisor='$id_emisor'
			union
				SELECT mensajes.id,mensaje, nombre, id_receptor,mensajes.creado from mensajes inner join usuarios on usuarios.id=id_emisor where id_receptor='$id_emisor' and id_emisor='$id_receptor'
					order by creado;";
    	//$r = @mysqli_query($dbc,$q);
    	$r = $dbc->query($q);
    	if (mysqli_num_rows($r)>0){
    		//while($row = $r -> fetch_assoc()){
    			//$array = [];
    			//array_push($array, $row);
    			
    		//};
    		return $r;
    		//return $array;

    		//$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
    		//return $row;
    		// row de prueba;
    		//$row = mysqli_fetch($r,MYSQLI_ASSOC);
    	} else {
    		$errors="No se ha encontrado ningún mensaje con este usuario";
    		echo mysqli_error($dbc);
    	}
    }
    return $errors;
};

function buscar_gente($dbc, $nombre,$id){
	$errors = [];
	if (empty($errors)){
		$q = "SELECT nombre, id from usuarios where (nombre='$nombre' and id!='$id')";
		//$r = @mysqli_query($dbc,$q);
		$r = $dbc->query($q);
		if (mysqli_num_rows($r)>=1){
			//$row = mysqli_fetch_array($r,MYSQLI_ASSOC);
			return $r;
			//return $row;
		} else { 
			$errors="No se ha encontrado el usuario";
			return $errors;
		}
	}
}

function enviar_mensaje($dbc,$mensaje,$id_emisor,$id_receptor,$nombre){
	$errors = [];
	if (empty($errors)){
		$q = "INSERT into mensajes(mensaje,id_emisor,id_receptor,creado) 
		values('$mensaje','$id_emisor','$id_receptor',NOW())";
		//$r = @mysqli_query($dbc,$q);
		if (mysqli_query($dbc,$q)){
			redirect_user("messages.php?nombre=$nombre&id_emisor=$id_emisor&id_receptor=$id_receptor");
		} else {
			debug($id_emisor);
			debug($_COOKIE['user_id']);
			echo $id_emisor;
			echo $mensaje;
			echo $id_receptor;
			echo mysqli_error($dbc);
		}
	}
}

function list_categories($dbc){
	$errors = [];
	if (empty($errors)){
		$q = "SELECT nombre, id from categorias";
		$r = $dbc->query($q);
		if (mysqli_num_rows($r)>=1){
			return $r;
		} else {
			echo mysqli_error($dbc);
		}
	}
}

function list_threads($dbc,$id_categoria){
	$errors =[];
	if (empty($errors)){
		$q = "SELECT threads.id, titulo, comentario_principal, nombre from threads
		inner join usuarios on usuarios.id=threads.id_usuario
		where id_categoria='$id_categoria'";
		$r = $dbc->query($q);
		if (mysqli_num_rows($r)>=1){
			return $r;
		} else {
			return mysqli_error($dbc);
		}
	}
}

function enviar_thread($dbc,$titulo,$comentario,$id_categoria,$id_usuario){
	$errors = [];
	if (empty($errors)){
		$q = "INSERT into threads(titulo,comentario_principal,id_categoria,id_usuario, creado)
		values ('$titulo','$comentario','$id_categoria','$id_usuario', NOW())";
		//$r = $dbc->query($q);
		if (mysqli_query($dbc,$q)){
			redirect_user("categoria.php?id=$id_categoria");
		} else {
			echo mysqli_error($dbc);
		}
	}
}

function listar_comentarios($dbc,$id_thread){
	$errors = [];
	if (empty($errors)){
		$q = "SELECT comentarios.id, comentarios.comentario, usuarios.nombre, comentarios.likes, comentarios.dislikes, comentarios.creado, usuarios.id as id_usuario
			from comentarios
			inner join threads on threads.id=comentarios.id_thread inner join usuarios on usuarios.id=comentarios.id_usuario_autor
			where comentarios.id_thread='$id_thread';";
		$r = $dbc->query($q);
		if (mysqli_num_rows($r)>=1){
			return $r;
		} else {
			return mysqli_error($dbc);
		}
	}
}
function comprobar_comentario($dbc,$id_usuario){
	$errors = [];
	if (empty($errors)){
		$q= "SELECT id_comentarios, comentarios.comentario, likes.like from likes
			inner join comentarios on comentarios.id=likes.id_comentarios
			where likes.id_usuario_likeador='$id_usuario';";
		$r=$dbc->query($q);
		if (mysqli_num_rows($r)>=1){
			return $r;
		} else {
			return mysqli_error($dbc);
		}
	}
	
}
function enviar_comentario($dbc, $comentario,$id_usuario,$id_thread){
	$errors = [];
	if (empty($errors)){
		$q = "INSERT into comentarios(comentario, id_usuario_autor,id_thread, creado)
		values('$comentario','$id_usuario','$id_thread', NOW())";
		//$r = $dbc->query($q);
		if (mysqli_query($dbc,$q)){
			redirect_user("thread.php?id=$id_thread");
		} else {
			return mysqli_error($dbc);
		}
	}
}