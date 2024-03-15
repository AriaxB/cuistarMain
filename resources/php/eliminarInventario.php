<?php

if(isset($_POST['id_stock'])) {

    include_once 'conexion.php';


    $id_stock = mysqli_real_escape_string($conexion, $_POST['id_stock']);


    $sql = "DELETE FROM stock_inventario WHERE id_stock = '$id_stock'";


    if ($conexion->query($sql) === TRUE) {
  
        header("Location: ../vistas/inventarioAdmin.php?mensaje=Registro eliminado correctamente");
        exit();
    } else {

        echo "Error al eliminar el registro: " . $conexion->error;
    }


    $conexion->close();
} else {

    header("Location: ../vistas/inventarioAdmin.php");
    exit();
}
?>
