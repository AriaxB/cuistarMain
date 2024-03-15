<?php
session_start();

include_once '../conexion.php';
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 4) {
    header("Location: iniciarSesion.php");
    exit();
}



// Consulta para obtener los productos
$sql = "SELECT * FROM productos";
$result = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="shortcut icon" href="../../img/logo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <title>CUISTAR</title>
</head>
<style>
    .container {
        display: flex;
        justify-content: center;
    }

    .informacion-usuario {
    left: 0;
    right: 0;
    margin: auto;
    width: 56%;
    /* background-color: rgba(255, 255, 255, 0.63); */
    text-align: center;
    border-radius: 5px;
    padding: 20px;
    max-height: 80vh;
    overflow-y: auto;
    font-size: 1em;
    /* flex-wrap: wrap; */
}
    .products {
    padding: 20px;
    box-sizing: border-box;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    /* Centra horizontalmente */
    gap: 20px;
    /* Espacio entre los productos */
    list-style: none; /* Elimina los puntos de la lista */
    margin: 0;
    padding: 0;
}



.products {
    padding: 20px;
    box-sizing: border-box;
    display: flex;
    gap: 20px;
    list-style: none;
    margin: 0;
    padding: 0;
        flex-wrap: wrap-reverse;
    align-content: center;
    justify-content: space-evenly;
    align-items: center;
}

    .product img {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    .product h3 {
        margin-top: 0;
        font-size: 18px;
        text-align: center;
    }

    .product p {
        margin: 0;
        font-size: 16px;
        text-align: center;
    }

    .product .add-to-cart {
        text-align: center;
    }

    .product .add-to-cart button {
        padding: 8px 16px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .empty-cart-message {
    text-align: center; 
    margin-top: 20px; 
    font-size: 20px;
    margin-bottom: 8px;
}

.empty-cart-message h1 {
    margin-bottom: 10px;
}


.acciones {
    margin-top: 20px;
    align-self: flex-end; 
}
</style>

<body>
    <header>
        <div class="logo">
            <a href="Index.html">
                <img src="../../img/logo.png" style="width: 50px; height: 50px" alt="Logo">
            </a>
        </div>
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="../../vistas/inicio.php">volver</a></li>
                <li><a href="../../vistas/perfil.php">Perfil</a></li>
                <li><a href="../cerrarSesion.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">

        <div class=" informacion-usuario">
           
            <div class="products">
            <?php
                // Manejo del carrito de compras
if (isset($_POST['id_producto'])) {
    $idProd = $_POST['id_producto'];
    $query = "SELECT * FROM productos WHERE id_producto='$idProd';";
    $result = mysqli_query($conexion, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }
        $cantidadDisponible = $row['cantidad'];
        if (isset($_SESSION['carrito'][$idProd])) {
            // Verifica primero si agregar uno supera la cantidad disponible
            if ($_SESSION['carrito'][$idProd]['cantidad'] < $cantidadDisponible) {
                $_SESSION['carrito'][$idProd]['cantidad']++;
            } else {
                echo "<script>alert('La cantidad especificada no está disponible en el stock');</script>";
                echo "<script>window.location.href='./carrito.php';</script>";
                exit;
            }
        } else {
            $_SESSION['carrito'][$idProd] = array(
                'nombre_prod' => $row['nombre'],
                'precio_uni' => $row['precio'],
                'imagen' => $row["imagen"],
                'cantidad' => 1
            );
        }
    } else {
        echo "<script>alert('No se encontró el producto');</script>";
        echo "<script>window.location.href='../../vistas/inicio.php';</script>";
        exit;
    }
}
                if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
                    foreach ($_SESSION['carrito'] as $indice => $producto) {
                        echo "<h3>" . $producto['nombre_prod'] . "</h3>";
                        echo "<p>Precio unitario: $" . $producto['precio_uni'] . "</p>";
                        echo "<p>Cantidad: " . $producto['cantidad'] . "</p>";
                        echo "<img src='../../imgProducto/" . $producto['imagen'] . "' alt='" . $producto['nombre_prod'] . "' style='width: 223px; height: 125px; object-fit: cover;'>";
                        
                        echo "<div class='acciones'>";
                        echo "<form method='post' action='./quitarProducto.php'>
                                <input type='hidden' id='id' name='id_producto' value='$indice'>
                                <button type='submit' id='eliminar_prod'>Eliminar producto</button>
                            </form>";
                        echo "<br>";
                        echo "</div>";
                    
                    }
                    echo "<a href='vaciarCarrito.php'>Vaciar carrito</a><br>";
                    echo "<a href='./agregarDescripcion.php'><button>continuar</button></a>";
                } else {
                    echo "<div class='informacion-usuario'>";
                    echo "<div class='empty-cart-message'>";
                    echo "<img src='../../img/carrito.png' alt='Carrito vacío' style='width: 267px; height: 263px;'>";
                    echo "<h1>El carrito está vacío</h1>";
                    echo "<a href='../../vistas/inicio.php'><button class='boton-login '>Añadir ahora</button></a>";
                    echo "</div>";
                    echo "</div>";

                }
                ?>
            </div>
        </div>
    </div>


</body>
<footer>
    <div class="left-column">
        <p>&copy; 2024 Cuistar</p>
    </div>
    <hr class="custom-hr">
    <div class="right-column">
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</footer>


</html>