<?php
session_start();
include_once '../php/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_proveedor = mysqli_real_escape_string($conexion, $_POST['id_proveedor']);
    $nombres = mysqli_real_escape_string($conexion, $_POST['nombres']);
    $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $id_producto = mysqli_real_escape_string($conexion, $_POST['id_producto']);
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);

    $sql = "UPDATE proveedores SET nombres='$nombres', apellidos='$apellidos', telefono='$telefono', direccion='$direccion', correo='$correo', id_producto='$id_producto', fecha='$fecha' WHERE id_nit=$id_proveedor";

    if (mysqli_query($conexion, $sql)) {
        header("Location: ../vistas/proveedoresAdmin.php");
        exit();
    } else {
        echo "Error al actualizar el proveedor: " . mysqli_error($conexion);
    }
}
?>