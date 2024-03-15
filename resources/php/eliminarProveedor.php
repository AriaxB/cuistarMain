<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['id_proveedor']) && !empty($_POST['id_proveedor'])) {
        $id_proveedor = $_POST['id_proveedor'];

        
        $sql = "DELETE FROM proveedores WHERE id_nit = $id_proveedor";

        if ($conexion->query($sql) === TRUE) {
            header("Location: ../vistas/proveedoresAdmin.php");
            exit();
        } else {
            echo "Error al eliminar el proveedor: " . $conexion->error;
        }
    } else {
        echo "ID de proveedor no válido";
    }
} else {
    echo "No se recibió una solicitud POST";
}

$conexion->close();
?>
