<?php
session_start();
if($_SESSION['rol'] != 1){
    header("location: ./"); //restringiendo acceso al sistema. 
}
 include "../conexion.php";
if(!empty($_POST)){

    if(empty($_POST['idcliente']) ){
        header ("Location: lista_clientes.php"); 
        mysqli_close($conection); //cerrar conexión
    }
  
    $idcliente = $_POST['idcliente'];
   
    //$query_delete= mysqli_query ($conection, "DELETE FROM usuario WHERE idusuario =$idusuario");
    $query_delete= mysqli_query($conection, "UPDATE cliente SET estatus = 0 WHERE idcliente = $idcliente");
    mysqli_close($conection); //cerrar conexión
    if($query_delete){
        echo  "Cliente eliminado con exito";
        header ("Location: lista_clientes.php");
    }
    else {
        echo  "Error al eliminar";
    }

}

if(empty($_REQUEST['id'])){
    header:('Location: lista_clientes.php');
    mysqli_close($conection); //cerrar conexión
}else {
   
    $idcliente= $_REQUEST['id'];

    $query= mysqli_query($conection,"SELECT * FROM cliente 
     WHERE idcliente =$idcliente");
      
    mysqli_close($conection); //cerrar conexión
    $result = mysqli_num_rows($query);

    if($result > 0){
        while ($data = mysqli_fetch_array($query)){
            $nit=$data['nit'];
            $nombre = $data['nombre'];
           
        }
    
        }
        else {
            header('Location: Lista_clientes.php');
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php  include "includes/scripts.php"; ?>

	<title>Eliminar cliente</title>
</head>
<body>
<?php  include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
        <i class="fas fa-user-times fa-7x" style="color: #e66262"></i>
        <br>
        <br>
            <h2> ¿Está seguro de eliminar el siguiente registro? </h2>
            <p>Nombre de cliente: <span> <?php echo $nombre; ?> </span></p>
            <p>Cedula: <span> <?php echo $nit; ?> </span></p>
            

            <form method="post" action="">
                <input type="hidden" name="idcliente"value="<?php echo $idcliente; ?>">
                <a href="lista_clientes.php" class="btn_cancel">Cancelar </a>
                <input type="submit" value="Eliminar" class="btn_ok">
</form>
</di>


	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>