<?php
session_start();
$id = $_POST['id_producto'];

if (isset($_SESSION['carrito'][$id])) {
    unset($_SESSION['carrito'][$id]);
    echo "<script>
            alert('producto eliminado');
            window.location.href='./carrito.php'
          </script>";
} else {
    // echo "no se recibio el id";
}
?>
