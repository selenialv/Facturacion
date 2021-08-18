<?php

include "../Conexion.php"; // Llamado a la BD.
if(!empty($_POST))

{
    $alert ='';

    if(empty($_POST['nombre']) || empty($_POST['correo'])|| empty($_POST['usuario']) || empty($_POST['clave'])|| 
    empty($_POST['rol']))
    {
        $alert ='<p class="msg_error"> Todos los campos son obligatorios</p>'; 
    } else{
        

        $nombre = $_POST['nombre'];
        $email = $_POST['correo'];
        $user = $_POST['usuario'];
        $clave= md5 ($_POST['clave']);// la sintaxis md5 se utiliza para encriptar la clave.
        $rol = $_POST['rol'];

        $query= mysqli_query($conection, "SELECT * FROM usuario WHERE usuario ='$user' OR correo='$email'  ");
        $result = mysqli_fetch_array($query);

        if($result > 0) {
            $alert ='<p class="msg_error"> El correo ya existe</p>'; 
        
        } else {
            $query_insert = mysqli_query($conection, "INSERT INTO usuario (nombre, correo, usuario, clave, rol) 
            VALUE ('$nombre', '$email', '$user', '$clave','$rol')" );

            if($query_insert)
            {
                $alert='<p class="msg_save"> 
                Usuario creado correctamente </p>';


            } else 
              {
                  $alert='<p class="msg_error"> 
                  Error al crear el usuario</p>';
              }
        }

    }
}
//mostrar datos
if(empty($_GET['id']))
{
    header('Location: lista_usuario.php');
}

//trayendo los registros con inner Join
$iduser = $_GET['id'];

$Sql= mysqli_query($conection,"SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) as idrol, (r.rol) as rol 
            FROM usuario u INNER JOIN rol r 
            ON u.rol = r.idrol WHERE idusuario= $iduser");

            $result_sql=mysqli_num_rows($sql);

            if($result_sql == 0){
                header('Location: lista_usuario.php');
            } else {
                while($data = mysqli_fetch_array($sql)){
                    $iduser = $data['idusuario'];
                    $nombre = $data['nombre'];
                    $correo = $data['correo'];
                    $usuario = $data['usuario'];
                    $idrol= $data['idrol'];
                    $rol = $data['rol'];
                    

                }
            }
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php  include "includes/scripts.php"; ?>

	<title>Actualizar usuario</title>
</head>
<body>
<?php  include "includes/header.php"; ?>
	<section id="container">
		
    <div class="form_register">

    <h1>Actualizar usuario </h1>
    <hr>
    <div class="alert"> <?php echo isset($alert) ? $alert:'';?> </div>  
    
    <form action="" method="post">
        <label for="nombre">Nombre completo </label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre completo">
        <label for="correo"> Correo electrónico </label>
        <input type="email" name="correo" id="correo" placeholder="Correo electrónico">
        <label for="usuario"> Usuario </label>
        <input type="usuario" name="usuario" id="usuario" placeholder="Usuario">
        <label for="clave"> Contraseña </label>
        <input type="password" name="clave" id="clave" placeholder="Contraseña">
        <label for="rol"> Tipo Usuario </label>


       <?php 
       
      $query_rol = mysqli_query($conection, "SELECT * FROM rol");
      $result_rol= mysqli_num_rows($query_rol);

       ?>
        <select name="rol" id="rol">
<?php
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
<input type="submit" value="Actualizar usuario" class="btn_save">
</form>


</div>  
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>