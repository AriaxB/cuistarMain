<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

function obtenerDatosRelacionados($tabla, $campo_id, $campo_descripcion) {
    global $conexion;

    $sql = "SELECT $campo_id, $campo_descripcion FROM $tabla";
    $result = $conexion->query($sql);

    if (!$result) {
        die("Error al obtener los datos de $tabla: " . $conexion->error);
    }
    
    $datos = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $datos[$row[$campo_id]] = $row[$campo_descripcion];
        }
    }
    
    return $datos;
}
$productos = obtenerDatosRelacionados('productos', 'id_producto', 'nombre');
$tallas = obtenerDatosRelacionados('tallas', 'id_tallas', 'descripcion');
$unidades_medida = obtenerDatosRelacionados('unidad_medida', 'id_unidadmedida', 'descripcion');
$categorias = obtenerDatosRelacionados('categoria', 'id_categoria', 'descripcion');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css?1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <title>CUISTAR</title>
</head>

<body>
<div class="container">
<aside class="sidebar">
        <ul>
            <div class="contenedor-foto" >
                <!-- Mostrar la imagen de perfil -->
                <img class="foto-perfil" style="width: 80px; height: 80px; margin-bottom: 5px; margin-left: 15px; margin-ringht:auto;" src="<?php echo isset($_SESSION['foto_perfil']) && !empty($_SESSION['foto_perfil']) ? '../imgPerfiles/' . $_SESSION['foto_perfil'] : '../imgPerfiles/perfilPredeterminado.jpg'; ?>" alt="Foto de perfil">
                <?php   
                echo '<h1>' . $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'] . '</h1>';
                ?>
            </div>
            <li></li>
            <li><a href="Publicidad.php">Datos</a></li>
            <li><a href="modulos.php">Modulos</a></li>
            <li><a href="../php/cerrarSesion.php">Cerrar sesión</a></li>
        </ul>
        <footer class="custom-footer">
            <div class="left-column">
                <p>&copy; 2024 Cuistar</p>
            </div>
            <hr class="custom-hr">
            <div class="right-column">
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <!-- Agrega más íconos y enlaces para otras redes sociales según sea necesario -->
                </div>
            </div>
        </footer>
    </aside>

    <main>
        <div class="informacion-modulos">
            <div class="contenedor-foto">
                
            <img class="foto-perfil" style="width: 80px; height: 80px; margin-bottom: 5px; margin-left: 15px; margin-ringht:auto;" src="<?php echo isset($_SESSION['foto_perfil']) && !empty($_SESSION['foto_perfil']) ? '../imgPerfiles/' . $_SESSION['foto_perfil'] : '../imgPerfiles/perfilPredeterminado.jpg'; ?>" alt="Foto de perfil">
            
                <form action="../php/agregarInventario.php" method="POST" enctype="multipart/form-data" onsubmit="return validarDatosProducto()">
                    <label for="id_producto">Producto:</label>
                    <select class="controls" id="id_producto" name="id_producto" required>
                        <option value="" disabled selected>Selecciona un producto</option>
                        <?php foreach ($productos as $id => $producto) { ?>
                            <option value="<?php echo $id; ?>"><?php echo $producto; ?></option>
                        <?php } ?>
                    </select><br><br>
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" required><br><br>
                    <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" required><br><br>
                    <input  type="submit" value="Agregar Producto" class="boton-login">
                </form>
                <a href="inventarioAdmin.php" class="boton-login">Cancelar</a>
            </div>
        </div>
        <script>
            function validarDatosProducto() {

                return true;
            }
        </script>
    </main>
</div>
</body>
</html>
