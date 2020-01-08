<?php 
require("database.php");
require("login_functions.inc.php");

$resultado = actualizar_like($dbc,'14','3','3');
//echo $resultado;
echo "<br/>";
var_dump($resultado);
function actualizar_like($dbc,$id_comentario,$id_usuario,$id_usuario_likeado){
	$errors = [];
	if (empty($errors)){
		$q = "SELECT likes.like  from likes
			where likes.id_usuario_likeador='$id_usuario' and likes.id_comentarios='$id_comentario';";
		$r = $dbc->query($q);
		//return mysqli_num_rows($r);
		if (mysqli_num_rows($r)==0){
			//var_dump($r);
			//return mysqli_num_rows($r);
			//foreach ($r as $re) {
				//return $re["like"];
			if (empty($r["likes"])){
				//return "Hola";
				//return (empty($re["likes"]));
				$q2= "INSERT into likes(likes.id_comentarios,likes.id_usuario_likeador,likes.id_ususario_likeado, likes.like,creado) 
					values('$id_comentario','$id_usuario','$id_usuario_likeado','1',NOW());";
				$q3= "UPDATE comentarios
					set likes=likes + 1
					where comentarios.id='14'";
					//return "En el If";
					//return var_dump($q2);
				if (mysqli_query($dbc,$q2)){
					echo "<h1>Ha funcionado</h1>";
					//redirect_user("thread.php?id=1");
					//return "Hola";
				} else {
					echo "<h1>No ha funcionado</h1>";
					return mysqli_error($dbc);
				}
				if (mysqli_query($dbc,$q3)){
					echo "<h1>Ha funcionado</h1>";
					//redirect_user("thread.php?id=1");
					return "ha funcionado";
				} else {
					echo "<h1>No ha funcionado</h1>";
					return mysqli_error($dbc);
				}
			} else {
			return "Despues del IF";
			return mysqli_error($dbc); 
			}
			//}
		} else {
			return "Algo ha pasado";
			return mysqli_error($dbc);
		}
	} else {
		return mysqli_error($dbc);
	}
}



?>