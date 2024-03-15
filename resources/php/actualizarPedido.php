<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: ../../vistas/iniciarSesion.php");
    exit(); 
}

$idPedido = $_POST['id_pedido'];
$cantidad = $_POST['cantidad'];

$query = "UPDATE id21913908_cuistar.pedido SET cantidad = '$cantidad' WHERE id_pedido = '$idPedido'";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    // Obtener la ID de la orden asociada al pedido actualizado
    $query_orden = "SELECT id_orden FROM id21913908_cuistar.pedido WHERE id_pedido = '$idPedido'";
    $resultado_orden = mysqli_query($conexion, $query_orden);
    
    // Verificar si la consulta devuelve algún resultado
    if (mysqli_num_rows($resultado_orden) > 0) {
        $row_orden = mysqli_fetch_assoc($resultado_orden);
        $idOrden = $row_orden['id_orden'];

        // Redirigir a la página de detalles de ventas con la ID de la orden en la URL
        header("Location: ../vistas/ventasDetalles.php?id_orden=$idOrden");
    } else {
        // Si no se encuentra ninguna orden asociada, redirigir a una página de error o realizar alguna acción adecuada
        echo "Error: No se encontró ninguna orden asociada al pedido.";
    }
} else {
    echo "Error al actualizar el pedido";
}
?>
