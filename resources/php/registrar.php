<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
include_once '../php/conexion.php';

function encriptarContrasena($contrasena) {
    return password_hash($contrasena, PASSWORD_DEFAULT);
}

// Inicia la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $telefono = $_POST["telefono"];
    $cedula = $_POST["cedula"];
    $id_ciudad = $_POST["id_ciudad"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $contrasenaEncriptada = encriptarContrasena($contrasena); 
    $id_rol = 4; 

    $sql_verificar_correo = "SELECT id_usuario FROM usuarios WHERE correo = '$correo'";
    $result_verificar_correo = $conexion->query($sql_verificar_correo);
    if ($result_verificar_correo->num_rows > 0) {
        $_SESSION['message'] = "El correo electrónico ya está registrado. Por favor, utilice otro.";
        header("Location: ../vistas/registrarse.php");
        exit();
    } else {
        $sql_insertar_usuario = "INSERT INTO usuarios (nombres, apellidos, telefono, cedula, id_ciudad, correo, contrasena, id_roll) VALUES ('$nombres', '$apellidos', '$telefono', '$cedula', '$id_ciudad', '$correo', '$contrasenaEncriptada', '$id_rol')";
        
        if ($conexion->query($sql_insertar_usuario) === TRUE) {
            $_SESSION['message'] = "Usuario registrado exitosamente";
            header("Location: ../vistas/iniciarSesion.php");
            exit();
        } else {
            $_SESSION['message'] = "Error al registrar el usuario: " . $conexion->error;
        }
    }
}
?>
