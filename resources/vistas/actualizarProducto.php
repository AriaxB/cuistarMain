<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

// Verificar si se ha enviado un ID de producto para editar
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_producto = $_GET['id'];

    // Consultar los datos del producto a editar
    $sql = "SELECT * FROM productos WHERE id_producto = $id_producto";
    $result = $conexion->query($sql);

    if (!$result) {
        die("Error al obtener los datos del producto: " . $conexion->error);
    }

    $producto = $result->fetch_assoc();
} else {
    // Si no se proporciona un ID de producto, redirigir a alguna página de error o lista de productos
    header("Location: listaProductos.php");
    exit();
}

// Obtener los datos relacionados para los select
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
    <title>CUISTAR - Editar Producto</title>
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
                <form action="../php/actualizarProducto.php" method="POST" enctype="multipart/form-data" onsubmit="return validarDatosProducto()">
                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                    <label for="nombre_producto">Nombre del producto:</label>
                    <input type="text" id="nombre_producto" name="nombre_producto" value="<?php echo $producto['nombre']; ?>" required>
                    <label for="descripcion_producto">Descripción del producto:</label>
                    <input id="descripcion_producto" name="descripcion_producto" value="<?php echo $producto['descripcion']; ?>" required></input>
                    <label for="precio_producto">Precio:</label>
                    <input type="number" id="precio_producto" name="precio_producto" min="0" step="0.01" value="<?php echo $producto['precio']; ?>" required>
                    <label for="cantidad_producto">Cantidad:</label>
                    <input type="number" id="cantidad_producto" name="cantidad_producto" min="0" value="<?php echo $producto['cantidad']; ?>" required>
                    <label for="id_talla">Talla:</label>
                    <select class="controls" id="id_talla" name="id_talla" required>
                        <?php
                        foreach ($tallas as $id => $talla) {
                            $selected = ($id == $producto['id_talla']) ? 'selected' : '';
                            echo "<option value='{$id}' $selected>{$talla}</option>";
                        }
                        ?>
                    </select>
                    <label for="id_unidad_medida">Unidad de Medida:</label>
                    <select class="controls" id="id_unidad_medida" name="id_unidad_medida" required>
                        <?php
                        foreach ($unidades_medida as $id => $unidad_medida) {
                            $selected = ($id == $producto['id_unidadmedida']) ? 'selected' : '';
                            echo "<option value='{$id}' $selected>{$unidad_medida}</option>";
                        }
                        ?>
                    </select>
                    <label for="id_categoria">Categoría:</label>
                    <select class="controls" id="id_categoria" name="id_categoria" required>
                        <?php
                        foreach ($categorias as $id => $categoria) {
                            $selected = ($id == $producto['id_categoria']) ? 'selected' : '';
                            echo "<option value='{$id}' $selected>{$categoria}</option>";
                        }
                        ?>
                    </select>
                    <label for="id_tipo_producto">Tipo de Producto:</label>
                    <select class="controls" id="id_tipo_producto" name="id_tipo_producto" required>
                        <?php
                        foreach ($tipos_producto as $id => $tipo_producto) {
                            $selected = ($id == $producto['id_tipoprodu']) ? 'selected' : '';
                            echo "<option value='{$id}' $selected>{$tipo_producto}</option>";
                        }
                        ?>
                    </select>
                     <label for="fecha_vencimiento">Fecha de vencimiento:</label>
                       <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo $producto['fecha_vencimiento']; ?>" required>
                       
                    <label for="cambiar_imagen">¿Cambiar imagen?</label>
                    <input type="checkbox" id="cambiar_imagen" name="cambiar_imagen" onchange="toggleImagenInput()">

                    <div id="nueva_imagen" style="display: none;">
                        <label for="imagen_producto">Nueva imagen:</label>
                        <input type="file" id="imagen_producto" name="imagen_producto" accept="image/*">
                    </div>
                    <input class="boton-login" style="width: 50%; max-width: 200px; cursor: pointer;" value="Actualizar Producto" type="submit">
                </form>
                <a href="productosAdmin.php" class="boton-login">Cancelar</a>
            </div>
        </div>
        <script>
            function validarDatosProducto() {
             
                return true;
            }
        </script>
        
<script>
    function toggleImagenInput() {
        var checkbox = document.getElementById('cambiar_imagen');
        var nuevaImagen = document.getElementById('nueva_imagen');

        if (checkbox.checked) {
            nuevaImagen.style.display = 'block';
        } else {
            nuevaImagen.style.display = 'none';
        }
    }
</script>
    </main>
</div>
</body>
</html>
