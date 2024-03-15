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

$tallas = obtenerDatosRelacionados('tallas', 'id_tallas', 'descripcion');
$unidades_medida = obtenerDatosRelacionados('unidad_medida', 'id_unidadmedida', 'descripcion');
$categorias = obtenerDatosRelacionados('categoria', 'id_categoria', 'descripcion');
$tipos_producto = obtenerDatosRelacionados('tipo_producto', 'id_tipoprodu', 'descripcion');
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
    <link rel="shortcut icon" href="..//img/logo.png" type="image/x-icon">
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
                <form action="../php/insertarProducto.php" method="POST" enctype="multipart/form-data" onsubmit="return validarDatosProducto()">
                    <label for="nombre_producto">Nombre del producto:</label>
                    <input type="text" id="nombre_producto" name="nombre_producto" required>
                    <label for="descripcion_producto">Descripción del producto:</label>
                    <input id="descripcion_producto" name="descripcion_producto" required></input>
                    <label for="precio_producto">Precio:</label>
                    <input type="number" id="precio_producto" name="precio_producto" min="0" step="0.01" required>
                    <label for="cantidad_producto">Cantidad:</label>
                    <input type="number" id="cantidad_producto" name="cantidad_producto" min="0" required>
                    <label for="id_talla">Talla:</label>
                    <select class="controls" id="id_talla" name="id_talla" required>
                        <option value="" disabled selected>Selecciona una talla</option>
                        <?php
                        foreach ($tallas as $id => $talla) {
                            echo "<option value='{$id}'>{$talla}</option>";
                        }
                        ?>
                    </select>
                    <label for="id_unidad_medida">Unidad de Medida:</label>
                    <select  class="controls" id="id_unidad_medida" name="id_unidad_medida" required>
                        <option value="" disabled selected>Selecciona una unidad de medida</option>
                        <?php
                        foreach ($unidades_medida as $id => $unidad_medida) {
                            echo "<option value='{$id}'>{$unidad_medida}</option>";
                        }
                        ?>
                    </select>
                    <label for="id_categoria">Categoría:</label>
                    <select class="controls" id="id_categoria" name="id_categoria" required>
                        <option value="" disabled selected>Selecciona una categoría</option>
                        <?php
                        foreach ($categorias as $id => $categoria) {
                            echo "<option value='{$id}'>{$categoria}</option>";
                        }
                        ?>
                    </select>
                    <label for="id_tipo_producto">Tipo de Producto:</label>
                    <select class="controls" id="id_tipo_producto" name="id_tipo_producto" required>
                        <option value="" disabled selected>Selecciona un tipo de producto</option>
                        <?php
                        foreach ($tipos_producto as $id => $tipo_producto) {
                            echo "<option value='{$id}'>{$tipo_producto}</option>";
                        }
                        ?>
                    
                    </select>
                     <label for="fecha_vencimeinto">Fecha de vencimiento:</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" required>  
                    <label  for="imagen_producto">Imagen:</label>
                    <input type="file" id="imagen_producto" name="imagen_producto" accept="image/*" required>
                    <input class="boton-login" style="width: 50%; max-width: 200px; cursor: pointer;" value="Agregar Producto" type="submit">
                </form>
                <a href="productosAdmin.php" class="boton-login">Cancelar</a>
            </div>
        </div>
        <script>
            function validarDatosProducto() {
                // Aquí puedes agregar validaciones de los campos del formulario de inserción de productos
                return true;
            }
        </script>
    </main>
</div>
</body>
</html>
