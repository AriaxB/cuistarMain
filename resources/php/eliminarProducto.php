<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    if(isset($_POST['id_producto']) && !empty($_POST['id_producto'])) {
        $id_producto = $_POST['id_producto'];

   
        $sql_imagen = "SELECT imagen FROM productos WHERE id_producto = $id_producto";
        $result_imagen = $conexion->query($sql_imagen);
        
        if($result_imagen->num_rows > 0) {
            $row_imagen = $result_imagen->fetch_assoc();
            $ruta_imagen = $row_imagen['imagen'];
            
 
            if(file_exists($ruta_imagen)) {
                unlink($ruta_imagen);
            }
        }

    
        $sql = "DELETE FROM productos WHERE id_producto = $id_producto";

        if ($conexion->query($sql) === TRUE) {
            header("Location: ../vistas/productosAdmin.php");
        } else {
            echo "Error al eliminar el producto: " . $conexion->error;
        }
    } else {
        echo "ID de producto no válido";
    }
} else {
    echo "No se recibió una solicitud POST";
}

$conexion->close();
?>
