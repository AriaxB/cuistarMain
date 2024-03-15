<?php
session_start();
include_once '../php/conexion.php';
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

function obtenerCiudades() {
    global $conexion;

    $sql = "SELECT id_ciudad, descripcion FROM ciudad";
    $result = $conexion->query($sql);

    if (!$result) {
        die("Error al obtener las ciudades: " . $conexion->error);
    }
    
    $ciudades = array(); // Mueve esta línea aquí
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ciudades[$row['id_ciudad']] = $row['descripcion'];
        }
    }
    
    return $ciudades; // Asegúrate de devolver el array $ciudades correctamente
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
    <link rel="shortcut icon" href="resources/img/logo.png"type="image/x-icon">
    <title>ODS</title>
</head>


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
                <form action="../php/upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="foto_perfil" accept="image/*">
            <input  type="submit" value="Subir Imagen">
        </form>
                <form action="../php/actualizarDatosUsuario.php" method="POST" onsubmit="return validarContrasenas()">
              

                    <label for="nombre_completo">Nombre completo:</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" value="<?php echo $_SESSION['nombres']; ?>" required>

                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" value="<?php echo $_SESSION['apellidos']; ?>" required>

                    <label for="correo">Correo electrónico:</label>
                    <input type="email" id="correo" name="correo" value="<?php echo $_SESSION['correo']; ?>"  pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}" title="Por favor, introduce un correo electrónico válido" required>
                    <label for="celular">Celular:</label>
                    <input type="text" id="celular" name="celular" value="<?php echo $_SESSION['telefono']; ?>" pattern="[0-9]{10}" title="Debe contener 10 dígitos numéricos" required>
                    
                    <label for="cedula">Cédula:</label>
                    <input type="text" id="cedula" name="cedula" value="<?php echo $_SESSION['cedula']; ?>" required>


                    <label for="ciudad">Ciudad:</label>
                    <select class="controls" name="id_ciudad" required>
                        <option value="" disabled>Selecciona tu ciudad</option>
                        <?php
                        $ciudades = obtenerCiudades();
                        $ciudad_predeterminada = $_SESSION['id_ciudad'];
                        foreach ($ciudades as $id => $ciudad) {
                            if ($id == $ciudad_predeterminada) {
                                echo "<option value='{$id}' selected>{$ciudad}</option>";
                            } else {
                                echo "<option value='{$id}'>{$ciudad}</option>";
                            }
                        }
                        ?>
                    </select>

                    <label for="contrasena">Nueva contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" class="input-password" placeholder="**********"pattern="^(?=.*[A-Z]).{8,}$"  title="La contraseña debe contener al menos 8 caracteres con una letra mayúscula.">

                    <label for="confirmar_contrasena">Confirmar contraseña:</label>
                    <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" class="input-password" placeholder="**********">

                
                

                    <input class="boton-login" style=" width: 50%; max-width: 200px; cursor: pointer;" value="Actualizar" type="submit">
                </form>
                <a href="perfil.php" class="boton-login">Cancelar</a>
            </div>
        </div>
        <script>

    function validarContrasenas() {
        var contrasena = document.getElementById("contrasena").value;
        var confirmar_contrasena = document.getElementById("confirmar_contrasena").value;

        if (contrasena != confirmar_contrasena) {
            alert("Las contraseñas no coinciden");
            return false;
        }
        return true; 
    }
</script>
    </main>
</div>
</body>
</html>
