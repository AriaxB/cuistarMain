<?php
session_start();

include_once '../conexion.php';
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 4) {
    header("Location: ../../vistas/iniciarSesion.php");
    exit();
}

// Función para verificar si la cantidad en el carrito excede la cantidad disponible en el inventario
function verificarStock($idProd, $conexion) {
    $query = "SELECT cantidad FROM productos WHERE id_producto='$idProd';";
    $result = mysqli_query($conexion, $query);
    $row = mysqli_fetch_assoc($result);
    $cantidadDisponible = $row['cantidad'];
    return $cantidadDisponible;
}

// Verificar si se ha enviado el formulario para agregar un producto al carrito
if (isset($_POST['id_producto'])) {
    // Obtener el ID del producto desde el formulario
    $idProd = $_POST['id_producto'];

    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION['carrito'][$idProd])) {
        // Incrementar la cantidad del producto en el carrito
        $_SESSION['carrito'][$idProd]['cantidad']++;
    } else {
        // Consultar la base de datos para obtener la información del producto con el ID dado
        $query = "SELECT * FROM productos WHERE id_producto='$idProd';";
        $result = mysqli_query($conexion, $query);
        $row = mysqli_fetch_assoc($result);

        // Si el producto no está en el carrito, agregarlo al carrito con una cantidad inicial de 1
        $_SESSION['carrito'][$idProd] = array(
            'nombre_prod' => $row['nombre'],
            'precio_uni' => $row['precio'],
            'imagen' => $row["imagen"],
            'cantidad' => 1
        );
    }
}

// Verificar si el carrito está vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: carritoVacio.php");
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
    <link rel="stylesheet" href="../../css/styles.css?1.0">
    <link rel="shortcut icon" href="../../img/logo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <title>CUISTAR</title>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
        }

        .informacion-usuario {
            width: 48%;
            padding: 20px;
        }

        .products {
            display: inline-grid;
            flex-wrap: wrap;
            gap: 20px;
            list-style: none;
            margin: 0;
            padding: 0;
            justify-content: center;
        }

        .product {
            width: 250px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .product img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .product h3 {
            margin-top: 0;
            font-size: 18px;
        }

        .product p {
            margin: 0;
            font-size: 16px;
        }

        .product .acciones {
            margin-top: 10px;
        }

        .product .acciones form {
            display: inline-block;
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

        .description-order {
            width: auto;
            padding: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .description-order form {
            text-align: center;
        }

        .description-order textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
            resize: none;
            padding: 5px;
        }

        .description-order {
            background-color: #c2c1dd3d;
            margin: auto;
            padding: 2%;
            width: 40%;
            height: auto;
            border: #000 2px solid;
            border-radius: 10px;
            margin-top: 8%;
        }

        .product {
            background: #c2c1dd3d;
            border: 1px solid #000;
            padding: 40px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>

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
        <div class="informacion-usuario">
            <div class="products">
                <h1>Productos agregados</h1>
                <?php
           if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
                    foreach ($_SESSION['carrito'] as $indice => $producto) {
                        echo "<div class='product'>";
                        echo "<h3>" . $producto['nombre_prod'] . "</h3>";
                        echo "<img src='../../imgProducto/" . $producto['imagen'] . "' alt='" . $producto['nombre_prod'] . "' style='width: 100%;'>";
                        echo "<p>Precio unitario: $" . $producto['precio_uni'] . "</p>";
                        echo "<p class='cantidad' id='cantidad_$indice'>" . $producto['cantidad'] . "</p>";
                        echo "<div class='acciones'>";
                        echo "<button class='btn-aumentar' onclick='aumentarCantidad(\"$indice\")'>+</button>";
                        echo "<button class='btn-disminuir' onclick='disminuirCantidad(\"$indice\")'>-</button>";
                        echo "<form method='post' action='./quitarProducto.php'>";
                        echo "<input type='hidden' id='id' name='id_producto' value='$indice'>";
                        echo "<button type='submit' id='eliminar_prod'>Eliminar producto</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='empty-cart-message'>Tu carrito está vacío</p>";
                }
                ?>
            </div>
        </div>
        <div class="description-order">
            <img src="../../img/carritoEnvio.png" alt="Descripción de la imagen" style="width: 500px; height: auto;">
            <form action='./crearOrden.php' method='post'>
                <textarea name='descripcion' id='descripcion_orden' placeholder='Ingrese alguna descripción para realizar su pedido'></textarea>
                <button class='boton-login' type='submit'>Crear pedido</button>
            </form>
            <form method='post' action='./vaciarCarrito.php'>
                <button class='boton-login' type='submit'>Vaciar carrito</button>
            </form>
            <div style="text-align: center;">
                <button class='boton-login' onclick="window.location.href='../../vistas/inicio.php'">Cancelar</button>
            </div>
        </div>
    </div>

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

    <script>
        // Función para aumentar la cantidad de un producto en el carrito
        function aumentarCantidad(idProducto) {
            var cantidadElem = document.getElementById('cantidad_' + idProducto);
            var nuevaCantidad = parseInt(cantidadElem.textContent) + 1;
            var cantidadDisponible = <?php echo json_encode(verificarStock(idProducto, $conexion)); ?>;

            if (nuevaCantidad <= cantidadDisponible) {
                cantidadElem.textContent = nuevaCantidad;
                guardarCarritoEnCookie(); // Guardar el carrito en la cookie después de aumentar la cantidad
            } else {
                alert('La cantidad especificada no está disponible en el stock');
            }
        }

        // Función para disminuir la cantidad de un producto en el carrito
        function disminuirCantidad(idProducto) {
            var cantidadElem = document.getElementById('cantidad_' + idProducto);
            var cantidad = parseInt(cantidadElem.textContent);
            if (cantidad > 1) {
                var nuevaCantidad = cantidad - 1;
                cantidadElem.textContent = nuevaCantidad;
                guardarCarritoEnCookie(); // Guardar el carrito en la cookie después de disminuir la cantidad
            }
        }

        // Función para guardar el carrito en una cookie
        function guardarCarritoEnCookie() {
            var carrito = <?php echo json_encode($_SESSION['carrito']); ?>;
            document.cookie = 'carrito=' + JSON.stringify(carrito) + '; path=/';
        }

        // Función para cargar el carrito desde la cookie cuando se carga la página
        window.onload = function() {
            var cookies = document.cookie.split(';');
            var carritoCookie;
            cookies.forEach(function(cookie) {
                var parts = cookie.split('=');
                if (parts[0].trim() === 'carrito') {
                    carritoCookie = parts[1];
                }
            });
            if (carritoCookie) {
                var carrito = JSON.parse(carritoCookie);
                <?php $_SESSION['carrito'] = '<script>document.write(JSON.stringify(carrito));</script>'; ?>;
            }
        };
    </script>

</body>

</html>
