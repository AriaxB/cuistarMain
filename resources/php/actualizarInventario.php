<?php
session_start();
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    $sql = "UPDATE stock_inventario SET cantidad = '$cantidad', Fecha_de_vencimiento = '$fecha_vencimiento' WHERE id_producto = '$id_producto'";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../vistas/inventarioAdmin.php");
    } else {
        echo "Error al actualizar el producto en el inventario: " . $conexion->error;
    }

    $conexion->close();
} else {
    header("Location: ../vistas/inventarioAdmin.php");
    exit();
}
?>
