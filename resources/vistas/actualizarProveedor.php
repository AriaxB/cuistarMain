<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_proveedor = $_GET['id'];

    $sql = "SELECT pr.*, tp.descripcion as nombre_producto FROM proveedores pr
            INNER JOIN tipo_producto tp ON pr.id_producto = tp.id_tipoprodu
            WHERE pr.id_nit = $id_proveedor";
    $result = $conexion->query($sql);

    if (!$result) {
        die("Error al obtener los datos del proveedor: " . $conexion->error);
    }

    $proveedor = $result->fetch_assoc();
} else {

    header("Location: listaProveedores.php");
    exit();
}
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <title>CUISTAR - Editar Proveedor</title>
</head>

<body>
<div class="container">
    <aside class="sidebar">
        <ul>
            <div class="contenedor-foto">
                <!-- Mostrar la imagen de perfil -->
                <img class="foto-perfil" style="width: 80px; height: 80px; margin-bottom: 5px; margin-left: 15px; margin-ringht:auto;" src="<?php echo isset($_SESSION['foto_perfil']) && !empty($_SESSION['foto_perfil']) ? '../imgPerfiles/' . $_SESSION['foto_perfil'] : '../imgPerfiles/perfilPredeterminado.jpg'; ?>" alt="Foto de perfil">
                <?php   
                echo '<h1>' . $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'] . '</h1>';
                ?>
            </div>
            <li></li>
            <li><a href="administrador.php">Datos</a></li>
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
                <form action="../php/actualizarProveedor.php" method="POST" enctype="multipart/form-data" onsubmit="return validarDatosProveedor()">
                    <input type="hidden" name="id_proveedor" value="<?php echo $proveedor['id_nit']; ?>">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" value="<?php echo $proveedor['nombres']; ?>" required>
                    <label for="apellidos">Apellidos:</label>
                    <input id="apellidos" name="apellidos" value="<?php echo $proveedor['apellidos']; ?>" required></input>
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo $proveedor['telefono']; ?>" required>
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" value="<?php echo $proveedor['direccion']; ?>" required>
                    <label for="correo">Correo:</label>
                    <input type="email" id="correo" name="correo" value="<?php echo $proveedor['correo']; ?>" required>
                    <label for="id_producto">Producto:</label>
                    <select class="controls" id="id_producto" name="id_producto" required>
                        <?php
                        $sql_productos = "SELECT id_tipoprodu, descripcion FROM tipo_producto";
                        $result_productos = $conexion->query($sql_productos);

                        if ($result_productos->num_rows > 0) {
                            while ($row_producto = $result_productos->fetch_assoc()) {
                                $selected = ($row_producto['id_tipoprodu'] == $proveedor['id_producto']) ? 'selected' : '';
                                echo "<option value='{$row_producto['id_tipoprodu']}' $selected>{$row_producto['descripcion']}</option>";
                            }
                        } else {
                            echo "<option value=''>No hay productos disponibles</option>";
                        }
                        ?>
                    </select>
                    <label for="fecha">Fecha:</label>
                    <input type="text" id="fecha" name="fecha" value="<?php echo $proveedor['fecha']; ?>" required>
                    <div id="calendario"></div>
                    <input class="boton-login" style="width: 50%; max-width: 200px; cursor: pointer;" value="Actualizar Proveedor" type="submit">
                </form>
                <a href="proveedoresAdmin.php" class="boton-login">Cancelar</a>
            </div>
        </div>
        <script>
            function validarDatosProveedor() {
                // Puedes agregar lógica de validación aquí según tus necesidades
                return true;
            }
        </script>
        <script>
            $(function() {
                $("#fecha").datepicker({
                    dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function(dateText) {
                        $(this).val(dateText);
                    }
                });
                $("#fecha").datepicker("option", "showAnim", "slideDown");
                $("#fecha").datepicker("option", "beforeShow", function(input, inst) {
                    inst.dpDiv.css({
                        marginTop: (-input.offsetHeight) + 'px',
                        marginLeft: input.offsetWidth + 'px'
                    });
                });
            });
        </script>
    </main>
</div>
</body>
</html>
