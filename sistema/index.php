<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php  include "includes/scripts.php"; ?>

	<title>Sistema Ventas</title>
</head>
<body>


<?php  include "includes/header.php"; 
include "../conexion.php";


$query_dash = mysqli_query($conection, "CALL dataDashboard();");
$result_das = mysqli_num_rows($query_dash);
if($result_das > 0) {
	$data_dash = mysqli_fetch_assoc($query_dash);
	mysqli_close($conection);

}

?>

	<section id="container">

		<div class="divContainer">
			<div>
            <h1 class="titlePanelControl">Panel de control</h1>
</div>

<div class="dashboard">

	<?php
	if($_SESSION['rol'] == 1)
	{
		?>
	<a href="lista_usuarios.php">
		<i class="fas fa-users"> </i>
		<P>
		   <strong> Usuarios</strong></br>
		   <span><?= $data_dash ['usuarios']; ?> </span>
</p>
</a>
<?php
}
?>
<a href="lista_clientes.php">
		<i class="fas fa-user"> </i>
		<P>
		   <strong> Clientes</strong></br>
		   <span><?= $data_dash ['clientes']; ?> </span>
</p>
</a>

<?php
	if($_SESSION['rol'] == 1)
	{
		?>
<a href="lista_proveedor.php">
		<i class="far fa-building"> </i>
		<P>
		   <strong> Proveedores</strong></br>
		   <span><?= $data_dash ['proveedores'];?></span>
</p>
</a>

<?php
}
?>

<a href="lista_producto.php">
		<i class="fas fa-cubes"> </i>
		<P>
		   <strong> Productos</strong></br>
		   <span><?= $data_dash ['productos']; ?> </span>
</p>
</a>
<a href="ventas.php">
		<i class="fas fa-file-alt"> </i>
		<P>
		   <strong> Ventas</strong></br>
		   <span><?= $data_dash ['ventas'];?> </span>
</p>
</a>
</div>
		</div>


	<div class="divInfoSistema">
		<div>
			<h1 class="titlePanelControl">Configuración</h1>
			
</div> 
        <div class="containerPerfil">
			<div class="containerDataUser">
				<div class="logoUser">
					<img src="img/logoUser.png">
</div>
        <div class="divDataUser">
			<h4> Información Personal </h4>
			<div>
				<label> Nombre: </label> <span> Selenia </span>
            </div>
           
			<div>
				<label> Correo: </label> <span> Selenia </span>
             </div>
			 <h4> Datos usuario </h4>
			 <div>
				 <label>Rol:</label> <span> selenia </span>
            </div>
			<div>
			<label>Usuario:</label> <span> admin </span>
            </div>
			<h4>Cambiar contraseña </h4>
			<form action="" method="post" name="frmChangePass" id="frmChangePass">
				<div>
					<input type="password" name="txtPassUser" id="textPassUser" placeholder="Contraseña actual" required>
                </div>
				<div>
					<input type="password" name="txtNewPassUser" id="textNewPassUser" placeholder="Nueva contraseña" required>
                </div>
				<div>
					<button type="submit" class="btn_save  btnChangePass"> <i class="fas fa-key"></i>Cambiar contraseña </button>
                </div>

     </form>			
		</div>
     </div>

<div class="containerDataEmpresa">

	<div class="logoEmpresa">
	     <img src="img/logoEmpresa.png">
    </div>
	<h4> Datos del negocio <h4>



   <form action =""	 method= "post" name="frmEmpresa" id="frmempresa">
	   <input type="hidden" name="action" value ="udpateDataEmpresa"> 

	   <div>
		   <label style="color:black;"> Ruc: </label><input type="text" name="txtNit" id="txtNit" placeholder="Ruc del negocio" value=""required>
       </div>
	   <div>
	   <label style="color:black;"> Nombre: </label><input type="text" name="txtNombre" id="txtNombre" placeholder="Nombre del negocio" value=""required>
       </div>
	   <div>
	   <label style="color:black;"> Razon social: </label><input type="text" name="txtRSocial" id="txtRSocial" placeholder="Razon social" value=""required>
       </div>
	   <div>
	   <label style="color:black;"> Teléfono: </label><input type="text" name="txtTelEmpresa" id="txtTelEmpresa" placeholder="Teléfono del negocio" value=""required>
       </div>
	   <div>
	   <label style="color:black;"> Correo electrónico: </label><input type="email" name="txtEmailEmpresa" id="txtEmailEmpresa" placeholder="Correo del negocio" value=""required>
       </div>
	   <div>
	   <label style="color:black;"> Dirección: </label><input type="text" name="txtDirEmpresa" id="txtDirEmpresa" placeholder="Dirección del negocio" value=""required>
       </div>
	   <div>
	   <label style="color:black;"> IVA (%): </label><input type="text" name="txtIva" id="txtIva" placeholder="Impuesto al valor agregado
	   (IVA) " value=""required>
       </div>
	   
	   <div class="alertFormEmpresa" style="display: none;"> </div>
       <div>
		   <button type="submit" class="btn_save btnChangePass"> <i class="far fa-save fa-lg"></i> Guardar datos </button>
         
           </div>
    </form>

</div>


</div>
</div>
	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>