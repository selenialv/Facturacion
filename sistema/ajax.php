<?php
include  "../conexion.php";
session_start();
    //print_r($_POST);exit;

if(!empty($_POST))
{
    if($_POST['action'] == 'infoProducto')
    {
        $producto_id = $_POST['producto'];

        $query = mysqli_query($conection, "SELECT codproducto, descripcion FROM
        producto WHERE codproducto = $producto_id AND estatus =1");

        mysqli_close($conection);

        $result = mysqli_num_rows($query);
        if($result > 0)
        {
            $data = mysqli_fetch_assoc($query);

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }
        echo 'error';
        exit;
    }
}
      //para agregar productos mediante ajax
    if($_POST['action'] == 'addProduct')
    { 
            if(!empty($_POST['cantidad']) ||!empty($_POST['precio']) || !empty($_POST['producto_id']))
            {
                $cantidad = $_POST['cantidad'];
                $precio = $_POST['precio'];
                $producto_id = $_POST['producto_id'];
                $usuario_id = $_SESSION['idUser'];

                $query_insert = mysqli_query($conection, "INSERT INTO entradas 
                (codproducto, cantidad, precio, usuario_id) 
                VALUES($producto_id, $cantidad, $precio, $usuario_id)");

                if($query_insert)
                {
                    //ejecutar procedimiento almacenado
                    $query_udp = mysqli_query($conection, "CALL actualizar_precio_producto($cantidad,
                    $precio, $producto_id)");

                    $result_pro = mysqli_num_rows($query_udp);
                    if($result_pro > 0)
                    {
                        $data = mysqli_fetch_assoc($query_udp);
                        $data ['producto_id'] = $producto_id;
                        //devolver en formato json
                        echo json_encode($data, JSON_UNESCAPED_UNICODE);
                        exit;
                    }
                    else 
                    {
                        echo "error";
                    }
                    mysqli_close($conection); //cerrar conexión

                }
                else 
                {
                    echo "error";
                }

                exit;

            }
    }
    
    //Eliminar producto
    if(!empty($_POST))
    {
        if($_POST['action'] == 'delProduct')
        {
            if(empty($_POST['producto_id']) || !is_numeric($_POST['producto_id']))
            {
                echo 'error';
            }
            else
            {
                $idproducto = $_POST['producto_id'];
                $query_delete= mysqli_query($conection, "UPDATE producto SET estatus = 0 WHERE codproducto = $idproducto");
                mysqli_close($conection); //cerrar conexión

                if($query_delete)
                {
                    echo 'ok';
                }
                else
                {
                    echo  "error";
                }
            }

            echo 'error';
        }
        exit;
    }


exit;

?>