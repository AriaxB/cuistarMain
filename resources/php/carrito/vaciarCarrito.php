<?php 
    session_start();
    if(isset($_SESSION['carrito'])){
        unset($_SESSION['carrito']);
        header("location: ../../vistas/inicio.php");
    }else{
        echo "error al vaciar carrito";
    }
    echo "<a href='../../vistas/inicio.php'>volver</a>";