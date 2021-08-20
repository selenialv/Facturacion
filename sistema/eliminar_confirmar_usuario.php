<?php
 include "../conexion.php";
if(!empty($_POST)){

    if($_POST['idusuario'] == 2)
    {
        header("location: lista_usuario.php");
        mysqli_close($conection); //cerrar conexión
        exit;
    }
    $idusuario = $_POST['idusuario'];
   
    //$query_delete= mysqli_query ($conection, "DELETE FROM usuario WHERE idusuario =$idusuario");
    $query_delete= mysqli_query($conection, "UPDATE usuario SET estatus = 0 WHERE idusuario = $idusuario");
    if($query_delete){
        header ("Location: lista_usuario.php");
    }
    else {
        echo  "Error al eliminar";
    }

}

if(empty($_REQUEST['id']) || $_REQUEST['id'] == 2){
    header:('Location: lista_usuario.php');
    mysqli_close($conection); //cerrar conexión
}else {
   
    $idusuario= $_REQUEST['id'];

    $query= mysqli_query($conection,"SELECT u.nombre, u.usuario, r.rol FROm usuario u INNER JOIN rol r on u.rol = r.idrol WHERE u.idusuario=$idusuario");
      
    mysqli_close($conection); //cerrar conexión
    $result = mysqli_num_rows($query);

    if($result > 0){
        while ($data = mysqli_fetch_array($query)){
            $nombre = $data['nombre'];
            $usuario=$data['usuario'];
            $rol = $data['rol'];
        }
    
        }
        else {
            header('Location: Lista_usuario.php');
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php  include "includes/scripts.php"; ?>

	<title>Eliminar usuario</title>
</head>
<body>
<?php  include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
            <h2> ¿Está seguro de eliminar el siguiente registro? </h2>
            <p>Nombre: <span> <?php echo $nombre; ?> </span></p>
            <p>Usuario: <span> <?php echo $usuario; ?> </span></p>
            <p>Tipo de usuario: <span> <?php echo $rol; ?> </span></p>

            <form method="post" action="">
                <input type="hidden" name="idusuario"value="<?php echo $idusuario; ?>">
                <a href="lista_usuario.php" class="btn_cancel">Cancelar </a>
                <input type="submit" value="Aceptar" class="btn_ok">
</form>
</di>


	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>