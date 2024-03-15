<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
include_once '../php/conexion.php';
session_start();
function obtenerCiudades() {
    global $conexion;

    $sql = "SELECT id_ciudad, descripcion FROM ciudad";
    $result = $conexion->query($sql);

    if (!$result) {
        die("Error al obtener las ciudades: " . $conexion->error);
    }
    
    $ciudades = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ciudades[$row['id_ciudad']] = $row['descripcion'];
        }
    }
    
    return $ciudades;
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
    <link rel="shortcut icon" href="../../resources/img/logo.png" image/x-icon">
    <title>CUISTAR</title>
</head>
<body>
    <main>
    <form class="form-admin" style="margin-top: 50vh; margin-bottom:-44vh;" action="../php/registrar.php" method="POST" id="registrationForm">
            <div class="form-header"
                <h4 style="display: flex; align-items: center; margin: 0; font-size: 1.5em;">
                    <img src="../img/logo.png" alt="logo" style="width: 60px; height: 60px; margin-right: 20px; margin-bottom: 10px;">Registrarse
                </h4>
            </div>
            <input class="controls" type="text" placeholder="Nombres" name="nombres" required>
            <input class="controls" type="text" placeholder="Apellidos" name="apellidos" required>
           
            <input class="controls" type="tel" placeholder="Teléfono" name="telefono" pattern="[0-9]{10}" title="Debe contener 10 dígitos numéricos" required>
            <input class="controls" type="text" placeholder="Cédula" name="cedula" required>
            <select class="controls" name="id_ciudad" required>
                <option value="" disabled selected>Selecciona tu ciudad</option>
                <?php
                $ciudades = obtenerCiudades();
                foreach ($ciudades as $id => $ciudad) {
                    echo "<option value='{$id}'>{$ciudad}</option>";
                }
                ?>
            </select>
            <input class="controls" type="email" placeholder="Correo" name="correo" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}" title="Por favor, introduce un correo electrónico válido" required>
            <input class="controls" type="password" id="password" placeholder="Contraseña" name="contrasena" pattern="^(?=.*[A-Z]).{8,}$" required title="La contraseña debe contener al menos 8 caracteres con una letra mayúscula.">
            <input class="controls" type="password" id="confirmPassword" placeholder="Confirmar Contraseña" required>

            <div id="message" style="color: red; font-size: 20px;">
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
            </div>
            <p id="passwordError" style="color: red; display: none;">Las contraseñas no coinciden.</p>
            
            
            <p style="color: black;">¿Ya tiene una cuenta? <a href="iniciarSesion.php">Inicia sesión.</a></p>
            <input class="boton-login" value="Registrarse" type="submit" style="width: 100%; max-width: 200px; margin: 10px auto; ">
        </form>
        
        <script>
            document.getElementById("registrationForm").addEventListener("submit", function(event) {
                var password = document.getElementById("password").value;
                var confirmPassword = document.getElementById("confirmPassword").value;
                
                if (password !== confirmPassword) {
                    document.getElementById("passwordError").style.display = "block";
                    event.preventDefault();
                }
            });
        </script>
        
    </main>
</body>
</html>
