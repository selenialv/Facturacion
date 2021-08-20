<?php

include "../Conexion.php"; // Llamado a la BD.
if(!empty($_POST))

{
    $alert ='';

    if(empty($_POST['nombre']) || empty($_POST['correo'])|| empty($_POST['usuario']) || 
    empty($_POST['rol']))
    {
        $alert ='<p class="msg_error"> Todos los campos son obligatorios</p>'; 
    } else{
        
        $idUsuario  = $_POST['idUsuario'];
        $nombre = $_POST['nombre'];
        $email = $_POST['correo'];
        $user = $_POST['usuario'];
        $clave= md5 ($_POST['clave']);// la sintaxis md5 se utiliza para encriptar la clave.
        $rol = $_POST['rol'];



        $query= mysqli_query($conection, "SELECT * FROM usuario WHERE (usuario ='$user' AND idusuario !=$idUsuario)OR 
        (correo='$email' AND idusuario != $idUsuario)");
        $result = mysqli_fetch_array($query);

        if($result > 0) {
            $alert ='<p class="msg_error"> El correo ya existe</p>'; 
        
        } else {
            if(empty($_POST['clave']))
            {
                $sql_update = mysqli_query($conection,"UPDATE usuario
                SET nombre = '$nombre', correo = '$email', usuario
                = '$user', rol = $rol
                WHERE idusuario= $idUsuario" );
            }
            else{
                $sql_update = mysqli_query($conection,"UPDATE usuario
                SET nombre = '$nombre', correo = '$email', usuario
                = '$user', clave= '$clave', rol = $rol
                WHERE idusuario= $idUsuario" );

            }
            

            if($sql_update)
            {
                $alert='<p class="msg_save"> 
                Usuario actualizado correctamente </p>';


            } else 
              {
                  $alert='<p class="msg_error"> 
                  Error al actualizar el usuario</p>';
              }
        }

    }
    mysqli_close($conection);  //cerrar conexion
}
//veirfica que el id, si no lo encuentra, regrese a la pagina principal
if(empty($_GET['id']))
{
    header('Location: lista_usuario.php');
    mysqli_close($conection);  //cerrar conexion
}

$iduser = $_GET['id'];


$sql = mysqli_query($conection, "SELECT u.idusuario, u.nombre, u.correo,u.usuario,(u.rol) as idrol,(r.rol)
as rol FROM usuario u INNER JOIN rol r
on u.rol = r.idrol
WHERE idusuario= $iduser");

mysqli_close($conection);  //cerrar conexion


$result_sql = mysqli_num_rows($sql);
if($result_sql == 0){
    header('Location: lista_usuario.php');
    
}
else {
    $option ='';
    while($data = mysqli_fetch_array($sql))
    {
        $iduser = $data['idusuario'];
        $nombre= $data['nombre'];
        $correo = $data['correo'];
        $usuario = $data['usuario']; 
        $idrol = $data['idrol'];
        $rol = $data['rol'];


        if($idrol= 1){
            $option = '<option value="'.$idrol.'" select> '.$rol.' </option>';
        
        } else if($idrol == 2){
            $option = '<option value="'.$idrol.'"select> '.$rol.' </option>';

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php  include "includes/scripts.php"; ?>

	<title>Editar Usuario</title>
</head>
<body>
<?php  include "includes/header.php"; ?>
	<section id="container">
		
    <div class="form_register">

    <h1>Editar Usuario </h1>
    <hr>
    <div class="alert"> <?php echo isset($alert) ? $alert:'';?> </div>  
    
    <form action="" method="post">
        <input type="hidden" name="idUsuario" value="<?php echo $iduser;?>">
        <label for="nombre">Nombre completo </label>  
        <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre;?>"> 
        <label for="correo"> Correo electrónico </label>
        <input type="email" name="correo" id="correo" placeholder="Correo electrónico"value="<?php echo $correo;?>">
        <label for="usuario"> Usuario </label>
        <input type="usuario" name="usuario" id="usuario" placeholder="Usuario"value="<?php echo $usuario;?>">
        <label for="clave"> Contraseña </label>
        <input type="password" name="clave" id="clave" placeholder="Contraseña">
        <label for="rol"> Tipo Usuario </label>


       <?php 
       include "../Conexion.php"; // Llamado a la BD.
       
      $query_rol = mysqli_query($conection, "SELECT * FROM rol");
      mysqli_close($conection);  //cerrar conexion
      $result_rol= mysqli_num_rows($query_rol);

       ?>
        <select name="rol" id="rol" class="notItemOne">
<?php
echo $option;
        if($result_rol > 0)
       {
        while ($rol = mysqli_fetch_array($query_rol))
        {
            ?>
            
             <option value="<?php echo $rol["idrol"]; ?>"> <?php echo $rol ["rol"] ?>  </option>
             <?php
        }
       }
       ?>
        

</select>
<input type="submit" value="Editar usuario" class="btn_save">
</form>


</div>  
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>