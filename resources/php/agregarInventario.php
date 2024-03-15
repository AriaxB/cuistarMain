<?php
session_start();
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];

    $sql = "INSERT INTO stock_inventario (id_producto, cantidad, Fecha_de_vencimiento) 
            VALUES ('$id_producto', '$cantidad', '$fecha_vencimiento')";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../vistas/inventarioAdmin.php");
    } else {
        echo "Error al agregar el producto al inventario: " . $conexion->error;
    }

    $conexion->close();
} else {
    header("Location: ../vistas/inventarioAdmin.php");
    exit();
}
?>
