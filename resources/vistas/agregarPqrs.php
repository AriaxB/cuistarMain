<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 4) { 
    header("Location: iniciarSesion.php");
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
    <link rel="shortcut icon" href="..//img/logo.png" type="image/x-icon">
    <title>CUISTAR</title>
</head>

<style>
.informacion-modulos {
    position: absolute;
    top: 50%;
    left: 50%;
    margin-right: auto;
    transform: translate(-60%, -50%);
    width: 50%;
    max-width: 50%;
    background-color: #c2c1dd3d;
    text-align: center;
    border-radius: 5px;
    padding: 20px;
    max-height: 80vh;
    overflow-y: auto;
    font-size: 0.5em;
}

select.controls {
    margin-top: 10px;
    border: 1px solid #ccc;
    padding: 6px;
    box-sizing: border-box;
    margin-bottom: 26px;
    width: 841px;
    font-size: 13px;
}

textarea {
    max-width: 841px;
    min-width: 841px;
    min-height: 150px;
    max-height: 150px;
}

</style>


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
                <li><a href="perfil.php">Datos</a></li>
                <li><a href="mascotas.php">Mascotas</a></li>
                <li><a href="../vistas/ordenes/verOrdenes.php">Pedidos</a></li>
                <li><a href="pqrs.php">Pqrs</a></li>
                <li><a href="inicio.php">Regresar</a></li>
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
                <form action="../php/agregarPqrs.php" method="POST" enctype="multipart/form-data" onsubmit="return validarDatosProducto()">
                <label  for="id_tipo">Tipo:</label>
                    <select class="controls" id="id_tipo" name="id_tipo" required>
                        <option value="" disabled selected>Selecciona el tipo</option>
                        <?php
                        $sql = "SELECT id_tipo, descripcion FROM tipo_pqrs";
                        $result = $conexion->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id_tipo'] . "'>" . $row['descripcion'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                   <label for="cedula"></label>
<select class="controls" id="id_estado" name="id_estado" required  style=" display: none;">
    <?php
    $sql = "SELECT id_estado, descripcion FROM estado"; 
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $selected = ($row['id_estado'] == 1) ? 'selected' : ''; // Marcar como seleccionado si es el id 1
            echo "<option value='" . $row['id_estado'] . "' $selected>" . $row['descripcion'] . "</option>";
        }
    }
    ?>
</select>

                    <label for="cedula">Cédula:</label>
                    <input type="text" id="cedula" name="cedula" required>
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" required>
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" required>
                    <label for="correo_electronico">Correo Electrónico:</label>
                    <input type="email" id="correo_electronico" name="correo_electronico" required>
                    <label for="asunto">Asunto:</label>
                    <input type="text" id="asunto" name="asunto" required>
                    <label for="evidencia">Evidencia:</label>
                    <input type="file" id="evidencia" name="evidencia" accept="image/*, .pdf" required>

                    <input class="boton-login" style="width: 50%; max-width: 200px; cursor: pointer;" value="Enviar PQRS" type="submit">
                </form>
                <a href="pqrs.php" class="boton-login">Cancelar</a>
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