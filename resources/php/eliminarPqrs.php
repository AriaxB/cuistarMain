<?php
session_start();
include_once 'conexion.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_pqrs = $_GET['id'];

    $consulta_existencia = "SELECT * FROM pqrs WHERE id_pqrs = $id_pqrs";
    $resultado_existencia = $conexion->query($consulta_existencia);

    if ($resultado_existencia->num_rows > 0) {
        $consulta_eliminar = "DELETE FROM pqrs WHERE id_pqrs = $id_pqrs";
        if ($conexion->query($consulta_eliminar) === TRUE) {
            header("Location: ../vistas/pqrsAdmin.php");
            exit();
        } else {
            echo "Error al eliminar la PQRS: " . $conexion->error;
        }
    } else {
        echo "La PQRS que intentas eliminar no existe.";
    }
} else {
    echo "ID de PQRS inválido.";
}

$conexion->close();
?>
