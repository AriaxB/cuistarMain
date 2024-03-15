<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $id_producto = $_POST['id_producto'];
    $fecha = $_POST['fecha']; 


    $sql = "INSERT INTO proveedores (nombres, apellidos, telefono, direccion, correo, id_producto, fecha) VALUES ('$nombres', '$apellidos', '$telefono', '$direccion', '$correo', '$id_producto', '$fecha')";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../vistas/proveedoresAdmin.php");
        exit();
    } else {
        echo "Error al agregar el proveedor: " . $conexion->error;
    }
} else {
    echo "No se recibió una solicitud POST";
}

$conexion->close();
?>
