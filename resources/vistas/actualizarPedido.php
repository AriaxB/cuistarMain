<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

// Obtener la ID del pedido de la URL
$idPedido = isset($_GET['id_pedido']) ? $_GET['id_pedido'] : null;

// Consultar los detalles del pedido que se va a actualizar
$query = "SELECT pr.nombre, p.id_pedido, p.id_orden, p.cantidad, v.descripcion, p.valor_total, u.nombres, u.apellidos, u.correo, u.telefono, u.cedula
          FROM id21913908_cuistar.ventas as v
          INNER JOIN id21913908_cuistar.pedido as p ON v.id_venta = p.id_orden
          INNER JOIN id21913908_cuistar.productos as pr ON pr.id_producto = p.id_producto
          INNER JOIN usuarios AS u ON v.id_user = u.id_usuario
          WHERE (p.id_pedido = '$idPedido')";
$resultado = mysqli_query($conexion, $query);
$row = mysqli_fetch_assoc($resultado);
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
                  <form action="../php/actualizarPedido.php" method="post">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" value="<?php echo $row['cantidad']; ?>" required>
                    <!-- Input oculto para enviar la ID del pedido -->
                    <input type="hidden" name="id_pedido" value="<?php echo $idPedido; ?>">
                    <button type="submit" class="boton-login" name="actualizar_pedido">Actualizar</button>
                </form>
                <a href="ventasDetalles.php?id_orden=<?php echo $row['id_orden']; ?>" class="boton-login">Cancelar</a>


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
