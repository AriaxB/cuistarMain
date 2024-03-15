<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 4) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_mascota = $_POST['id_mascota'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $raza = $_POST['raza'];
    $peso = $_POST['peso'];
    $genero = $_POST['genero'];
    $categoria = $_POST['categoria'];
    $estatura = $_POST['estatura'];
    $sql = "UPDATE mascotas SET 
            nombre_mascota = '$nombre', 
            edad_mascota = '$edad', 
            raza = '$raza', 
            id_peso = '$peso', 
            id_genero = '$genero', 
            id_categoria = '$categoria', 
            id_estatura = '$estatura' 
            WHERE id_mascota = $id_mascota";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../vistas/mascotas.php");
        exit();
    } else {
        echo "Error al actualizar los datos de la mascota: " . $conexion->error;
    }
    $conexion->close();
} else {
    header("Location: ../vistas/mascotas.php");
    exit();
}
?>
