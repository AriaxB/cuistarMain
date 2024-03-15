<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

// Verificar si se ha enviado un ID de PQRS para actualizar
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id_pqrs = $_GET['id'];

    // Consultar los datos de la PQRS
    $sql = "SELECT p.*, 
                   u.nombres AS descripcion_usuario, 
                   t.descripcion AS descripcion_tipo, 
                   e.descripcion AS descripcion_estado
            FROM pqrs p
            LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario
            LEFT JOIN tipo_pqrs t ON p.id_tipo = t.id_tipo
            LEFT JOIN estado e ON p.id_estado = e.id_estado
            WHERE p.id_pqrs = $id_pqrs";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_estado = $row['id_estado'];
        $cedula = $row['cedula'];
        $nombres = $row['nombres'];
        $apellidos = $row['apellidos'];
        $correo_electronico = $row['correo_electronico'];
        $asunto = $row['asunto'];
        $nombre_archivo = $row['evidencia']; // Obtener el nombre del archivo de evidencia
        $respuesta = $row['respuesta'];
    } else {
        echo "No se encontró la PQRS con el ID proporcionado.";
        exit();
    }
} else {
    echo "No se proporcionó un ID de PQRS válido.";
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
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
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
                <li><a href="pqrs.php">PQRS</a></li>
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
                     <img class="foto-perfil" style="width: 80px; height: 80px; margin-bottom: 5px; margin-left: 15px; margin-ringht:auto;" src="<?php echo isset($_SESSION['foto_perfil']) && !empty($_SESSION['foto_perfil']) ? '../imgPerfiles/' . $_SESSION['foto_perfil'] : '../imgPerfiles/perfilPredeterminado.jpg'; ?>" alt="Foto de perfil"> </br></br></br></br>
                    <form action="../php/actualizarPqrs.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_pqrs" value="<?php echo $id_pqrs; ?>">
                        <label for="nombres">Nombres:</label>
                        <input type="text" id="nombres" name="nombres" value="<?php echo $nombres; ?>" required readonly>
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos; ?>" required readonly>
                        <label for="correo_electronico">Correo Electrónico:</label>
                        <input type="email" id="correo_electronico" name="correo_electronico" value="<?php echo $correo_electronico; ?>" required readonly>
                         <label for="cedula">Cédula:</label>
                        <input type="text" id="cedula" name="cedula" value="<?php echo $cedula; ?>" required readonly>
                        <label for="asunto">Asunto:</label>
                        <textarea id="asunto" name="asunto" required readonly><?php echo $asunto; ?></textarea>

                        <label for="evidencia">Evidencia:</label>
                        <?php
                        if (!empty($nombre_archivo)) {
                            $ruta_evidencia = "../archivoPqrs/" . $nombre_archivo;
                            echo "<input type='text' id='evidencia' name='evidencia' value='Clic aqui para ver evidencia' readonly onclick='verEvidencia(\"$ruta_evidencia\")' style='cursor: pointer;'>";
                        } else {
                            echo "<input type='text' id='evidencia' name='evidencia' value='No hay evidencia adjunta' readonly>";
                        }
                        ?>
                        
                        <script>
                        function verEvidencia(ruta) {
                            window.open(ruta, '_blank');
                        }
                        </script>
                        <label for="respuesta">Estado:</label>
                         <select class="controls" id="id_estado" name="id_estado" required  >
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
                        <label for="respuesta">Respuesta:</label>
                        <textarea id="respuesta" name="respuesta" required><?php echo $respuesta; ?></textarea>


                        <input class="boton-login" type="submit" value="Responder PQRS">
                    </form>
                    <a href="pqrsAdmin.php" class="boton-login">Cancelar</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>