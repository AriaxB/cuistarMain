<?php
session_start();
include('../conexion.php');


if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
    $idUser=$_SESSION['id_usuario'];
    // Inserta la orden
// Inserta la orden
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : ""; // Obtener la descripción del formulario
    $query = "INSERT INTO ventas(id_user, id_estado, descripcion) VALUES ('$idUser', 3, '$descripcion')";

    if (mysqli_query($conexion, $query)) {
        $orden_id = mysqli_insert_id($conexion); // Obtiene el ID de la orden insertada
    } else {
        echo "Error al insertar la orden: " . mysqli_error($conexion);
        exit; // Sale del script si hay un error
    }

    // Inicializa una variable para verificar si todos los pedidos se agregaron correctamente
    $todosLosPedidosAgregados = true;
    // Ciclo para crear los pedidos asociados a la orden
    foreach ($_SESSION['carrito'] as $idProd => $details) {
        $cantidad = $details['cantidad'];
        $precioUnidad = $details['precio_uni']; // Asume que este valor está en tu array de sesión
        $valorTotalProd = $cantidad * $precioUnidad; // Calcula el valor total para este producto específico

        $query_pedido = "INSERT INTO pedido (id_orden,id_producto, cantidad, valor_total) VALUES ('$orden_id', '$idProd', '$cantidad', '$valorTotalProd')";
        
        if (!mysqli_query($conexion, $query_pedido)) {
            echo "Error al agregar el pedido: " . mysqli_error($conexion);
            $todosLosPedidosAgregados = false;
            break; 
        }
    }

    if ($todosLosPedidosAgregados) {
        unset($_SESSION['carrito']); // Limpia el carrito solo si todos los pedidos se agregaron correctamente
        echo "Todos los pedidos fueron agregados correctamente. <a href='../../vistas/inicio.php'>Volver</a>";
    } else {
        echo "Hubo un error al agregar los pedidos. Por favor, intente de nuevo. <a href='../../vistas/inicio.php'>Volver</a>";
    }
} else {
    echo "El carrito está vacío. <a href='../../vistas/inicio.php'>Volver</a>";
}
?>