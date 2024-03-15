<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre_producto = $_POST['nombre_producto'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $precio_producto = $_POST['precio_producto'];
    $cantidad_producto = $_POST['cantidad_producto'];
    $id_talla = $_POST['id_talla'];
    $id_unidad_medida = $_POST['id_unidad_medida'];
    $id_categoria = $_POST['id_categoria'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $id_tipo_producto = $_POST['id_tipo_producto'];

    $ruta_imagen = '../imgProducto/';

    $nombre_imagen = $_FILES['imagen_producto']['name'];
    $tipo_imagen = $_FILES['imagen_producto']['type'];
    $tamaño_imagen = $_FILES['imagen_producto']['size'];
    $temp_imagen = $_FILES['imagen_producto']['tmp_name'];

    $ruta_imagen = $ruta_imagen . $nombre_imagen;
    move_uploaded_file($temp_imagen, $ruta_imagen);

    $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad, id_tallas, id_unidadmedida, id_categoria, id_tipoprodu, imagen,fecha_vencimiento) 
            VALUES ('$nombre_producto', '$descripcion_producto', '$precio_producto', '$cantidad_producto', '$id_talla', '$id_unidad_medida', '$id_categoria', '$id_tipo_producto', '$ruta_imagen','$fecha_vencimiento')";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../vistas/productosAdmin.php");
    } else {
        echo "Error al insertar el producto: " . $conexion->error;
    }

    $conexion->close();
}
?>
