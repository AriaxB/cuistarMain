<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 4) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $id_usuario = $_SESSION['id_usuario'];
    $id_tipo = $_POST['id_tipo'];
    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo_electronico = $_POST['correo_electronico'];
    $asunto = $_POST['asunto'];
    $fecha = date("Y-m-d");
    $id_estado = $_POST['id_estado'];
    
    // Subir el archivo de evidencia
    $targetDir = "../archivoPqrs/";
    $evidencia = basename($_FILES["evidencia"]["name"]);
    $targetFilePath = $targetDir . $evidencia;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    // Verificar si es un archivo real o falso
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Subir archivo al servidor
        if(move_uploaded_file($_FILES["evidencia"]["tmp_name"], $targetFilePath)){
            // Preparar la consulta SQL para insertar los datos en la tabla "pqrs"
            $sql = "INSERT INTO pqrs (id_usuario, id_tipo, cedula, nombres, apellidos, correo_electronico, asunto, evidencia, fecha, id_estado) 
                    VALUES ('$id_usuario', '$id_tipo', '$cedula', '$nombres', '$apellidos', '$correo_electronico', '$asunto', '$evidencia', '$fecha', '$id_estado')";
            
            // Ejecutar la consulta SQL
            if ($conexion->query($sql) === TRUE) {
                header("Location: ../vistas/perfil.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
        }else{
            echo "Error al subir el archivo.";
        }
    }else{
        echo 'Solo se permiten archivos JPG, JPEG, PNG, GIF y PDF.';
    }
    // Cierra la conexión a la base de datos
    $conexion->close();
}
?>

