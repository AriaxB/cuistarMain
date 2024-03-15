<?php
session_start();
include_once '../php/conexion.php';

// Verificar si el usuario tiene la sesión iniciada y es de tipo 3 (supongo que tipo 3 significa el rol de administrador)
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: ../../vistas/iniciarSesion.php");
    exit(); 
}

// Verificar si se ha enviado el formulario de eliminación
if(isset($_POST['eliminar_orden'])) {
    // Obtener el ID del pedido a eliminar
    $id_pedido = $_POST['id_orden'];
    
    // Realizar la consulta para eliminar el pedido de la base de datos
    $query_eliminar = "DELETE FROM pedido WHERE id_pedido = $id_pedido";
    $resultado_eliminar = mysqli_query($conexion, $query_eliminar);
    
    // Verificar si la eliminación fue exitosa
    if($resultado_eliminar) {
        // Redirigir de vuelta a la página de ventasDetalles.php para mostrar los resultados actualizados
        header("Location: ventasAdmin.php");
        exit();
    } else {
        // Manejar el error si la eliminación falla
        echo "Error al eliminar el pedido: " . mysqli_error($conexion);
    }
}
?>
