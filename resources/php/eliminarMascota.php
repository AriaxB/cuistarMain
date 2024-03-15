<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 4) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id_mascota = $_GET['id'];

    $sql_select = "SELECT * FROM mascotas WHERE id_mascota = $id_mascota";
    $result_select = $conexion->query($sql_select);

    if ($result_select->num_rows > 0) {
        $row = $result_select->fetch_assoc();
        $nombre_mascota = $row['nombre_mascota'];
        $sql_delete = "DELETE FROM mascotas WHERE id_mascota = $id_mascota";
        if ($conexion->query($sql_delete) === TRUE) {
            header("Location: ../vistas/mascotas.php");
            echo "La mascota $nombre_mascota se ha eliminado correctamente.";
        } else {
            echo "Error al eliminar la mascota: " . $conexion->error;
        }
    } else {
        echo "No se encontró la mascota con el ID proporcionado.";
    }
} else {
    echo "No se proporcionó un ID de mascota válido.";
}
?>
