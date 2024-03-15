<?php
session_start();
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_pqrs'])) {
        $id_pqrs = $_POST['id_pqrs'];
        $id_estado = $_POST['id_estado'];
        $respuesta = $_POST['respuesta'];

        // Actualizar la PQRS en la base de datos
        $sql = "UPDATE pqrs SET  id_estado = $id_estado, respuesta = '$respuesta' WHERE id_pqrs = $id_pqrs";

        if ($conexion->query($sql) === TRUE) {
            header("Location: ../vistas/pqrsAdmin.php");
        } else {
            echo "Error al actualizar la PQRS: " . $conexion->error;
        }
    } else {
        echo "No se proporcionó un ID de PQRS válido.";
    }
} else {
    echo "Acceso no permitido.";
}

$conexion->close();
?>
