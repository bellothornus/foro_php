<?php 
require('database.php');
require('login_functions.inc.php');
$id_comentario = $_REQUEST["id_comentario"];
$id_usuario = $_REQUEST["id_usuario"];
$id_usuario_likeado = $_REQUEST["id_usuario_likeado"];
$id_thread = $_REQUEST["id_thread"];
$resultado=actualizar_like($dbc,$id_comentario,$id_usuario,$id_usuario_likeado,$id_thread);
var_dump($resultado);
function actualizar_like($dbc,$id_comentario,$id_usuario,$id_usuario_likeado,$id_thread){
	$errors = [];
	if (empty($errors)){
		$q = "SELECT likes.like as likes from likes
			where likes.id_usuario_likeador='$id_usuario' and likes.id_comentarios='$id_comentario';";
		$r = $dbc->query($q);
		if (mysqli_num_rows($r)==0){
			if (!empty($r)){
				$q2= "INSERT into likes(likes.id_comentarios,likes.id_usuario_likeador,likes.id_ususario_likeado, likes.like,creado) 
					values('$id_comentario','$id_usuario','$id_usuario_likeado','0',NOW());";
				$q3= "UPDATE comentarios
					set dislikes=dislikes + 1
					where comentarios.id='$id_comentario'";
				if (mysqli_query($dbc,$q2)){
				} else {
					return mysqli_error($dbc);
				}
				if (mysqli_query($dbc,$q3)){
				} else {
					return mysqli_error($dbc);
				}
			} else {
			return mysqli_error($dbc); 
			}
		} else {
			return mysqli_error($dbc);
		}
	} else {
		return mysqli_error($dbc);
	}
}
?>