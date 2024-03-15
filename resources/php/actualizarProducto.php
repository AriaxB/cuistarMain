<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $precio_producto = $_POST['precio_producto'];
    $cantidad_producto = $_POST['cantidad_producto'];
    $id_talla = $_POST['id_talla'];
    $id_unidad_medida = $_POST['id_unidad_medida'];
    $id_categoria = $_POST['id_categoria'];
    $id_tipo_producto = $_POST['id_tipo_producto'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    
    // Verificar si se cargó una nueva imagen
    if(isset($_FILES['imagen_producto']) && $_FILES['imagen_producto']['size'] > 0) {
        $ruta_imagen = '../imgProducto/';
        $nombre_imagen = $_FILES['imagen_producto']['name'];
        $tipo_imagen = $_FILES['imagen_producto']['type'];
        $temp_imagen = $_FILES['imagen_producto']['tmp_name'];
        $ruta_imagen = $ruta_imagen . $nombre_imagen;
        move_uploaded_file($temp_imagen, $ruta_imagen);
    } else {
        // Si no se cargó una nueva imagen, conservar la imagen existente
        $sql_imagen = "SELECT imagen FROM productos WHERE id_producto = $id_producto";
        $result_imagen = $conexion->query($sql_imagen);
        $row_imagen = $result_imagen->fetch_assoc();
        $ruta_imagen = $row_imagen['imagen'];
    }

    // Realizar la actualización con los datos obtenidos
   $sql = "UPDATE productos SET 
                nombre = '$nombre_producto',
                descripcion = '$descripcion_producto',
                precio = '$precio_producto',
                cantidad = '$cantidad_producto',
                id_tallas = '$id_talla',
                id_unidadmedida = '$id_unidad_medida',
                id_categoria = '$id_categoria',
                id_tipoprodu = '$id_tipo_producto',
                imagen = '$ruta_imagen',
                fecha_vencimiento = '$fecha_vencimiento'
            WHERE id_producto = $id_producto";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ../vistas/productosAdmin.php");
    } else {
        echo "Error al actualizar el producto: " . $conexion->error;
    }

    $conexion->close();
}
?>
