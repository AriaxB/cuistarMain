<?php
session_start();

include_once '../php/conexion.php'; 
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 4) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

$sql = "SELECT p.id_producto, p.nombre, p.descripcion, um.descripcion AS unidad_medida, p.precio, p.id_categoria, p.id_tallas, p.imagen 
        FROM productos p
        INNER JOIN unidad_medida um ON p.id_unidadmedida = um.id_unidadmedida
        WHERE 1";


// Verificar si se envió una búsqueda
if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
    $busqueda = $_GET['busqueda'];
    $sql .= " AND (p.nombre LIKE '%$busqueda%' OR p.descripcion LIKE '%$busqueda%')";
}

// Verificar si se seleccionó un tipo de producto
if(isset($_GET['tipo_producto']) && !empty($_GET['tipo_producto'])) {
    $tipo_producto = $_GET['tipo_producto'];
    $sql .= " AND id_tipoprodu = $tipo_producto";
}

// Ejecutar la consulta
$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css?1.1">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <title>CUISTAR</title>
</head>
<style>
    .slider-frame img {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        display: block;
        margin: 25px auto;
    }

   .container {
    display: flex;
    margin: 2cm 0; /* Añade 2 cm de espacio en la parte superior e inferior */
    
}

   .sidebar {
        width: 250px; 
        height: auto;
        margin-right: 40px;
        padding: 50px;
        background-color: #f4f4f4;
        margin-left: 5cm; /* Ajuste de margen */
        max-height: calc(110vh - 100px); /* Altura máxima de la barra lateral */
    }
    

    /* Ajustar la apariencia de la barra de búsqueda */
    .sidebar form input[type="text"] {
        width: 80%; /* Ancho de la barra de búsqueda */
        padding: 10px; /* Espaciado interno */
        margin-bottom: 10px; /* Espaciado inferior */
    }
.products {
    padding: 20px;
    
    box-sizing: border-box;
    display: flex;
    flex-wrap: wrap;
    
    gap: 50px; /* Espacio entre los productos */
}

.product {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
    box-sizing: border-box;
    width: calc(20% - 20px); /* Hace los cuadros un poco más pequeños */
    margin-bottom: 20px;
    display: inline-block;
    vertical-align: top;
    height:auto; 
}

.product img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
}

.product h3 {
    margin-top: 0;
    font-size: 16px;
    text-align: center;
}

.product p {
    margin: 0;
    font-size: 14px;
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
footer.pie-pagina {
    background-color: #f8f8f8;
    padding: 20px 0;
    text-align: center;
}

.grupo-1{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.grupo-2 {
   align-items: center; 
}

.box {
    flex: 1;
    margin: 10px;
    text-align: left;
    margin-left: 2em; 
}



.box h2 {
    margin-top: 0;
    font-size: 18px;
    color: #333;
    margin-left: 2em; 
}

.box p {
    
    color: #666;
    margin-left: 2em; 
}



.red-social a {
    margin-right: 10px;
    color: #666;
    text-decoration: none;
    font-size: 18px;
    margin-left: 2em; 
}

.red-social a:hover {
    color: #333;
    margin-left: 2em; 
}
.grupo-2{
    background:#ffc0cb;
}
.grupo-2 small {
    font-size: 12px;
    color: #999;
    margin-left: 2em; 
}

.grupo-2 small b {
    color: #333;
    margin-left: 2em; 
}
</style>
<body>
    <header>
        <div class="logo">
            <a href="Index.html">
                <img src="../img/logo.png" style="width: 50px; height: 50px" alt="Logo">
            </a>
        </div>
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="../php/carrito/carrito.php">Carrito<?php                          
                                        if(isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
                                            echo " (".$count = count($_SESSION['carrito']).") ";              
                                        } else {
                                            echo " (",0,") ";
                                        }
                                        ?></a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="../php/cerrarSesion.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

         <div class="slider-container">
            <div class="slider-frame">
            <ul>
                <li><img src="../img/anuncio1.1.jpg" alt="Descripción" loading="lazy"></li>
                <li><img src="../img/anuncio2.2.jpg" alt="Descripción" loading="lazy"></li>
                <li><img src="../img/anuncio3.jpg" alt="Descripción" loading="lazy"></li>
                <li><img src="../img/anuncio4.1.jpg" alt="Descripción" loading="lazy"></li>
            
            </ul>
          </div>
        </div>

     <div class="container">
        <div class="sidebar">
   <form action="#" method="GET">
                <input type="text" name="busqueda" placeholder="Buscar producto">
                
            </form>
           

<ul id="Productos">
    <h3>Perros</h3>
    <li><a href="?tipo_producto=22">Alimentos</a></li>
    <li><a href="?tipo_producto=20">Juguetes</a></li>
    <li><a href="?tipo_producto=19">Accesorios </a></li>
    <li><a href="?tipo_producto=23">Ropa</a></li>
    <li><a href="?tipo_producto=18">Medicamentos</a></li>
    <h3>Gatos</h3>
    <!-- Enlaces de tipo_producto -->
    <li><a href="?tipo_producto=21">Alimentos</a></li>
    <li><a href="?tipo_producto=25">Juguetes</a></li>
    <li><a href="?tipo_producto=24">Accesorios </a></li>
    <li><a href="?tipo_producto=27">Ropa</a></li>
    <li><a href="?tipo_producto=26">Medicamentos</a></li>
    
</ul>
         
        </div>
 <div class="products">
            <!-- Mostrar productos -->
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<img src='".$row["imagen"]."' alt='".$row["nombre"]."' style='width: 223px; height: 125px; object-fit: cover;'>";
                    echo "<h3>".$row["nombre"]."</h3>";
                    echo "<p>".$row["descripcion"]."</p>";
                    echo "<p>".$row["unidad_medida"]."</p>";
                    echo "<p>Precio: $".$row["precio"]."</p>";
                    echo "<div class='add-to-cart'>";
                    echo "<input type='hidden' name='id_producto' id='id_producto' value='".$row["id_producto"]."'>";
              echo "<form action='../php/carrito/carrito.php' method='post'>";
                    echo "<input type='hidden' name='id_producto' id='id_producto' value='".$row["id_producto"]."'>";
                    echo "<button type='submit' onclick='redirect()' name='agregar_al_carrito'>Añadir al Carrito 🛒</button>";            
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay productos disponibles.</p>";
            }
            ?>
        </div>
    </div>
        
 
       
 <footer class="pie-pagina">
    <div class="grupo-1">
        <div class="box">
            <figure>
                <a href="Inicio.php">
                    <img src="logo.png" alt="Logo CUISTAR">
                </a>
            </figure>
        </div>
        <div class="box">
            <h2>SOBRE NOSOTROS</h2>
            <p>Somos una empresa dedicada a la venta de productos para mascotas </p>
            <p>Nos comprometemos con el bienestar y la felicidad de tus mascotas </p>
        </div>
        <div class="box">
            <h2>SIGUENOS</h2>
            <div class="red-social">
                <a href="https://es-la.facebook.com/" class="fa fa-facebook"></a>
                <a href="https://www.instagram.com/" class="fa fa-instagram"></a>
                <a href="https://twitter.com/?lang=es" class="fa fa-twitter"></a>
                <a href="https://www.youtube.com/" class="fa fa-youtube"></a>
            </div>
        </div>
    </div>
    <div class="grupo-2">
        <small>&copy; 2024 <b>CUISTAR</b> - Todos los Derechos Reservados.</small>
    </div>
</footer>


</body>

</html>
 


