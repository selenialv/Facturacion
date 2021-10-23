<?php
session_start();

include "../Conexion.php";  //llamado de conexion

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php  include "includes/scripts.php"; ?>

	<title>Lista de clientes</title>
</head>
<body>
<?php  include "includes/header.php"; ?>
	<section id="container">

    <?php
    $busqueda = strtolower ($_REQUEST['busqueda']);
    if(empty($busqueda)){
        header("location: lista_clientes.php");
    
    }
    

    ?>
	<h1> Lista de clientes </h1>
    <a href="registro_usuario.php" class="btn_new"> Crear cliente </a>
    <form action="buscar_cliente.php" method="get" class="form_search"> 
        <input type="text" name ="busqueda" paceholder="buscar" value="<?php echo $busqueda; ?>">
        <button type="submit" class="btn_search"> <i class="fas fa-search"></i></button> 
</form>
    <div class="containerTable">
    <table>
        <tr>
           <th>Id </th>
            <th>Cedula </th>
            <th>Nombre</th>
            <th>telefono </th>
            <th>Dirección </th>
            <th>Acciones </th>
</tr>


<?php 

$sql_registe= mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM cliente
 WHERE ( idcliente LIKE '$busqueda' OR nombre
LIKE '$busqueda' OR nit LIKE '$busqueda' OR telefono LIKE '$busqueda' OR direccion LIKE '$busqueda') AND estatus = 1");


$result_register = mysqli_fetch_array($sql_registe);
$total_registro = $result_register['total_registro'];

$por_pagina = 5;
if(empty($_GET['pagina'])){
    $pagina=1;
}
else {
    $pagina = $_GET['pagina'];
}
$desde = ($pagina-1)* $por_pagina;
$total_paginas =ceil($total_registro / $por_pagina);


$query = mysqli_query($conection,"SELECT * FROM cliente WHERE 
 										( idcliente LIKE '%$busqueda%' OR 
 										 	nit LIKE '%$busqueda%' OR 
 											nombre LIKE '%$busqueda%' OR 
 											telefono LIKE '%$busqueda%' OR 
 											direccion LIKE '%$busqueda%' 
)
 										AND 
 										estatus = 1 ORDER BY idcliente ASC LIMIT $desde,$por_pagina
 										");

mysqli_close($conection); //cerrar conexión
$result = mysqli_num_rows($query); 
    if($result > 0){
        while($data = mysqli_fetch_array($query)){

?>
     <tr>
    <td> <?php echo $data ["idcliente"]  ?> </td>
    <td>  <?php echo $data ["nit"]  ?></td>
    <td>  <?php echo $data ["nombre"]  ?></td>
    <td>  <?php echo $data ["telefono"]  ?></td>
    <td>  <?php echo $data ["direccion"]  ?></td>

    <td>
        <a class="link_edit" href="editar_cliente.php? id=<?php echo $data ["idcliente"]; ?>"> Editar </a>
        
        <?php if($_SESSION['rol'] ==1) {  ?>
        
          
        
        <a class="link_delete" href="eliminar_confirmar_cliente.php? id=<?php echo $data ["idcliente"]; ?>">  Eliminar </a>
           
        <?php  } ?>
</td>
</tr>
 
<?php
    }
}
 
?>

</table>

</div>

<div class="paginador">
    <ul>
        <?php if($pagina != 1)
        {



        ?>
       <li> <a href="?pagina= <?php echo 1; ?> "> |< </a> </li>
       <li> <a href="?pagina =<?php echo $pagina -1; ?>"> << </a> </li>
  
        <?php 
        }

        for($i=1; $i <= $total_paginas; $i++){

            if($i == $pagina){
                echo '<li class= "pageSelected">' .$i.'</li>';
            }else{
                 echo '<li> <a href= "?pagina='.$i.'">'.$i.' </a></li>';
            }
            
        }
    if($pagina != $total_paginas)
        {
        ?>
        <li> <a href="?pagina =<?php echo $pagina + 1; ?>"> >> </a> </li>
        <li> <a href="?pagina= <?php echo  $total_paginas; ?>">>| </a> </li>
       <?php } 
       ?>

</ul>
</div>

	</section>

	<?php  include "includes/footer.php"; ?>
</body>
</html>