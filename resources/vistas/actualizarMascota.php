<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 4) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

// Verificar si se ha enviado un ID de mascota para actualizar
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id_mascota = $_GET['id'];

    // Consultar los datos de la mascota
    $sql = "SELECT m.*, g.descripcion AS genero_desc, p.descripcion AS peso_desc, c.descripcion AS categoria_desc, e.descripcion AS estatura_desc, CONCAT(u.nombres, ' ', u.apellidos) AS nombre_completo
            FROM mascotas m
            LEFT JOIN genero g ON m.id_genero = g.id_genero
            LEFT JOIN peso p ON m.id_peso = p.id_peso
            LEFT JOIN categoria c ON m.id_categoria = c.id_categoria
            LEFT JOIN estatura e ON m.id_estatura = e.id_estatura
            LEFT JOIN usuarios u ON m.id_usuario = u.id_usuario
            WHERE m.id_mascota = $id_mascota";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row['nombre_mascota'];
        $edad = $row['edad_mascota'];
        $raza = $row['raza'];
        $peso = isset($row['peso_desc']) ? $row['peso_desc'] : ''; // Verificar si la clave 'peso_desc' existe en el array
        $genero = isset($row['genero_desc']) ? $row['genero_desc'] : ''; // Verificar si la clave 'genero_desc' existe en el array
        $categoria = isset($row['categoria_desc']) ? $row['categoria_desc'] : ''; // Verificar si la clave 'categoria_desc' existe en el array
        $estatura = isset($row['estatura_desc']) ? $row['estatura_desc'] : ''; // Verificar si la clave 'estatura_desc' existe en el array
    } else {
        echo "No se encontró la mascota con el ID proporcionado.";
        exit();
    }
} else {
    echo "No se proporcionó un ID de mascota válido.";
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
    <link rel="shortcut icon" href="../img/logo.png"type="image/x-icon">
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
            <li><a href="perfil.php">Datos</a></li>
            <li><a href="mascotas.php">Mascotas</a></li>
            <li><a href="Aprovadas.php">Pedidos</a></li>
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

                    <form action="../php/actualizarMascotas.php" method="POST">
                        <input type="hidden" id="id_mascota" name="id_mascota" value="<?php echo $id_mascota; ?>">
                        <label for="nombre">Nombre de la mascota:</label>

                        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                        <br><br>
                        <label for="edad">Edad de la mascota:</label>
                        <input type="tect" id="edad" name="edad" value="<?php echo $edad; ?>" required>
                        <br><br>
                        <label for="raza">Raza de la mascota:</label>
                        <input type="text" id="raza" name="raza" value="<?php echo $raza; ?>" required>
                        <br><br>
                        <label for="peso">Peso de la mascota:</label>
                        <select class="controls" id="peso" name="peso" required>
                            <?php
                            // Consultar los pesos disponibles
                            $sql = "SELECT id_peso, descripcion FROM peso";
                            $result = $conexion->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id_peso']}'";
                                    if ($row['descripcion'] === $peso) {
                                        echo " selected";
                                    }
                                    echo ">{$row['descripcion']}</option>";
                                }
                            }
                            ?>
                        </select>
                        <br><br>
                        <label  for="genero">Género de la mascota:</label>
                        <select class="controls" id="genero" name="genero" required>
                            <?php
                            // Consultar los géneros disponibles
                            $sql = "SELECT id_genero, descripcion FROM genero";
                            $result = $conexion->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id_genero']}'";
                                    if ($row['descripcion'] === $genero) {
                                        echo " selected";
                                    }
                                    echo ">{$row['descripcion']}</option>";
                                }
                            }
                            ?>
                        </select>
                        <br><br>
                        <label for="categoria">Categoría de la mascota:</label>
                        <select class="controls" id="categoria" name="categoria" required>
                            <?php
                            // Consultar las categorías disponibles
                            $sql = "SELECT id_categoria, descripcion FROM categoria";
                            $result = $conexion->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id_categoria']}'";
                                    if ($row['descripcion'] === $categoria) {
                                        echo " selected";
                                    }
                                    echo ">{$row['descripcion']}</option>";
                                }
                            }
                            ?>
                        </select>
                        <br><br>
                        <label for="estatura">Estatura de la mascota:</label>
                        <select class="controls" id="estatura" name="estatura" required>
                            <?php
                            // Consultar las estaturas disponibles
                            $sql = "SELECT id_estatura, descripcion FROM estatura";
                            $result = $conexion->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id_estatura']}'";
                                    if ($row['descripcion'] === $estatura) {
                                        echo " selected";
                                    }
                                    echo ">{$row['descripcion']}</option>";
                                }
                            }
                            ?>
                        </select>
                        <br><br>
                        <input class="boton-login"  style=" width: 50%; max-width: 200px; cursor: pointer;" type="submit" value="Actualizar">
                    </form>
                    <a href="mascotas.php" class="boton-login">Cancelar</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
