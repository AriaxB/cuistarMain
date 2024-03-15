<?php
session_start();
include_once 'conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 4) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$raza = $_POST['raza'];
$peso = $_POST['peso'];
$genero = $_POST['genero'];
$categoria = $_POST['categoria'];
$estatura = $_POST['estatura'];

$id_usuario = $_SESSION['id_usuario'];

$sql = "INSERT INTO mascotas (nombre_mascota, edad_mascota, raza, id_peso, id_genero, id_categoria, id_estatura, id_usuario) 
        VALUES ('$nombre', '$edad', '$raza', '$peso', '$genero', '$categoria', '$estatura', '$id_usuario')";

if ($conexion->query($sql) === TRUE) {
    header("Location: ../vistas/mascotas.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

$conexion->close();
?>
