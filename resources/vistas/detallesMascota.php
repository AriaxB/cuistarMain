<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

// Verificar si se proporcionó un ID de mascota en la URL
if (!isset($_GET['id_mascota']) || empty($_GET['id_mascota'])) {
    // Mostrar un mensaje de error
    $error_message = "No se proporcionó un ID de mascota válido.";
}

// Si se proporcionó un ID de mascota, consultar la mascota
if (isset($_GET['id_mascota']) && !empty($_GET['id_mascota'])) {
    $id_mascota = $_GET['id_mascota'];
    
    // Consultar la mascota específica por su ID
    $sql = "SELECT m.*, g.descripcion AS genero_desc, p.descripcion AS peso_desc, c.descripcion AS categoria_desc, e.descripcion AS estatura_desc, CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo
            FROM mascotas m
            LEFT JOIN genero g ON m.id_genero = g.id_genero
            LEFT JOIN peso p ON m.id_peso = p.id_peso
            LEFT JOIN categoria c ON m.id_categoria = c.id_categoria
            LEFT JOIN estatura e ON m.id_estatura = e.id_estatura
            LEFT JOIN usuarios u ON m.id_usuario = u.id_usuario
            WHERE m.id_mascota = $id_mascota"; // Filtrar por el ID de la mascota
    $result = $conexion->query($sql);

    if (!$result || $result->num_rows === 0) {
        // Mostrar un mensaje de error si no se encuentra la mascota
        $error_message = "No se encontró la mascota.";
    } else {
        // Mostrar los detalles de la mascota
        $row = $result->fetch_assoc();
    }
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
        <img class="foto-perfil" style="width: 80px; height: 80px; margin-bottom: 5px; margin-left: 15px; margin-ringht:auto;" src="<?php echo isset($_SESSION['foto_perfil']) && !empty($_SESSION['foto_perfil']) ? '../imgPerfiles/' . $_SESSION['foto_perfil'] : '../imgPerfiles/perfilPredeterminado.jpg'; ?>" alt="Foto de perfil">

                <?php if (isset($error_message)) : ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                    <a href="mascotas.php">Volver a la lista de mascotas</a>
                </div>
                <?php endif; ?>

                <?php if (isset($row)) : ?>
         
                    <h2>Datos de la Mascota</h2>
                 
                    <h1>Nombre: <?php echo htmlspecialchars($row['nombre_mascota']); ?></h1>
                    <h1>Edad: <?php echo htmlspecialchars($row['edad_mascota']); ?></h1>
                    <h1>Raza: <?php echo htmlspecialchars($row['raza']); ?></h1>
                    <h1>Peso: <?php echo htmlspecialchars($row['peso_desc']); ?></h1>
                    <h1>Género: <?php echo htmlspecialchars($row['genero_desc']); ?></h1>
                    <h1>Categoría: <?php echo htmlspecialchars($row['categoria_desc']); ?></h1>
                    <h1>Estatura: <?php echo htmlspecialchars($row['estatura_desc']); ?></h1>

                    <a href="mascotasAdmin.php" class="boton-login">Volver</a>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>
