<?php
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

include_once '../php/conexion.php'; 

$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT u.*, r.descripcion AS nombre_rol
        FROM usuarios u
        INNER JOIN roll r ON u.id_roll = r.id_rol
        WHERE u.id_usuario = $id_usuario"; 

$result = $conexion->query($sql);

if ($result && $result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['id_roll'] = $row['id_roll']; 
    $_SESSION['id_usuario'] = $row['id_usuario'];
    $_SESSION['nombres'] = $row['nombres'];
    $_SESSION['apellidos'] = $row['apellidos'];
    $_SESSION['correo'] = $row['correo'];
    $_SESSION['telefono'] = $row['telefono'];
    $_SESSION['id_ciudad'] = $row['id_ciudad'];
    $_SESSION['cedula'] = $row['cedula'];
    $_SESSION['foto_perfil'] = $row['foto_perfil'];
    $_SESSION['nombre_rol'] = $row['nombre_rol'];

    // Obtener el nombre de la ciudad
    $id_ciudad = $row['id_ciudad'];
    $sql_ciudad = "SELECT descripcion FROM ciudad WHERE id_ciudad = $id_ciudad";
    $result_ciudad = $conexion->query($sql_ciudad);
    if ($result_ciudad && $result_ciudad->num_rows == 1) {
        $row_ciudad = $result_ciudad->fetch_assoc();
        $_SESSION['nombre_ciudad'] = $row_ciudad['descripcion'];
    }

} else {
    echo "Error: No se pudo obtener los datos del usuario.";
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
        <img class="foto-perfil" style="width: 80px; height: 80px; margin-bottom: 5px; margin-left: 15px; margin-ringht:auto;" src="<?php echo isset($_SESSION['foto_perfil']) && !empty($_SESSION['foto_perfil']) ? '../imgPerfiles/' . $_SESSION['foto_perfil'] : '../imgPerfiles/perfilPredeterminado.jpg'; ?>" alt="Foto de perfil">

            <?php
       
            if (isset($_SESSION['id_usuario'])) {
                echo '<h1>Tipo de usuario: ' . $_SESSION['nombre_rol'] . '</h1>';
                echo '<h1>Nombres: ' . $_SESSION['nombres'] . '</h1>';
                echo '<h1>Apellidos: ' . $_SESSION['apellidos'] . '</h1>';
                echo '<h1>Correo: ' . $_SESSION['correo'] . '</h1>';
                echo '<h1>Teléfono: ' . $_SESSION['telefono'] . '</h1>';
                echo '<h1>Ciudad: ' . $_SESSION['nombre_ciudad'] . '</h1>';
                echo '<h1>Cédula: ' . $_SESSION['cedula'] . '</h1>';
            } else {
                echo '<h1>¡Hola, invitado!</h1>';
            }
            ?>
            <a href="actualizarPefilAdmin.php" class="boton-login">Actualizar</a>
        </div>
    </main>
</div>
</body>
</html>
