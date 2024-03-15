<?php
session_start();
include_once '../php/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST['nombre_completo'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $cedula = $_POST['cedula'];
    $id_ciudad = $_POST['id_ciudad'];
    $contrasena = $_POST['contrasena'];

    if (isset($_FILES['fotoPerfil']['name']) && !empty($_FILES['fotoPerfil']['name'])) {
        $foto_perfil = $_FILES['fotoPerfil']['name']; 
        $foto_perfil_temp = $_FILES['fotoPerfil']['tmp_name']; 
    
        if (move_uploaded_file($foto_perfil_temp, "../imgPerfiles/$foto_perfil")) {
            $sql .= ", foto_perfil='$foto_perfil'";
        } else {
            echo "Error al mover el archivo.";
            exit();
        }
    }
    

    $sql = "UPDATE usuarios SET nombres='$nombre_completo', apellidos='$apellido', correo='$correo', telefono='$celular', cedula='$cedula', id_ciudad='$id_ciudad'";

    if (isset($foto_perfil)) {
        $sql .= ", foto_perfil='$foto_perfil'";
    }

    $sql .= " WHERE id_usuario='{$_SESSION['id_usuario']}'";

    if ($conexion->query($sql) === TRUE) {
        if (!empty($contrasena)) {
            $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql_contrasena = "UPDATE usuario SET contrasena='$contrasena_encriptada' WHERE id_usuario='{$_SESSION['id_usuario']}'";
            if ($conexion->query($sql_contrasena) === FALSE) {
                echo "Error al actualizar la contraseña: " . $conexion->error;
                exit();
            }
        }
        header("Location: ../vistas/perfil.php?exito=1");
    } else {
        echo "Error al actualizar los datos: " . $conexion->error;
    }

    $conexion->close();
}
?>
