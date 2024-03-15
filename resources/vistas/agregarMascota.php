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
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <title>CUISTAR - Agregar Mascota</title>
</head>

<body>
    <div class="container">
    <aside class="sidebar">
        <ul>
            <div class="contenedor-foto">
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
      
                </div>
            </div>
        </footer>
    </aside>

    <main>
        <div class="informacion-modulos">
            <div class="contenedor-foto">           
                <img class="foto-perfil" style="width: 80px; height: 80px; margin-bottom: 5px; margin-left: 15px; margin-ringht:auto;" src="<?php echo isset($_SESSION['foto_perfil']) && !empty($_SESSION['foto_perfil']) ? '../imgPerfiles/' . $_SESSION['foto_perfil'] : '../imgPerfiles/perfilPredeterminado.jpg'; ?>" alt="Foto de perfil">

                <form action="../php/agregarMascota.php" method="POST">
                    <label for="nombre">Nombre de la mascota:</label>
                    <input type="text" id="nombre" name="nombre" required>
                    <br><br>
                    <label for="edad">Edad de la mascota:</label>
                    <input type="number" id="edad" name="edad" required>
                    <br><br>
                    <label for="raza">Raza de la mascota:</label>
                    <input type="text" id="raza" name="raza" required>
                    <br><br>
                    <label for="peso">Peso de la mascota:</label>
                    <select class="controls" id="peso" name="peso" required>
                        <?php
                        $sql = "SELECT id_peso, descripcion FROM peso";
                        $result = $conexion->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id_peso']}'>{$row['descripcion']}</option>";
                            }
                        }
                        ?>
                    </select>
                    <br><br>
                    <label for="genero">Género de la mascota:</label>
                    <select class="controls" id="genero" name="genero" required>
                        <?php
                        $sql = "SELECT id_genero, descripcion FROM genero";
                        $result = $conexion->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id_genero']}'>{$row['descripcion']}</option>";
                            }
                        }
                        ?>
                    </select>
                    <br><br>
                    <label for="categoria">Categoría de la mascota:</label>
                    <select class="controls" id="categoria" name="categoria" required>
                        <?php
                        $sql = "SELECT id_categoria, descripcion FROM categoria";
                        $result = $conexion->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id_categoria']}'>{$row['descripcion']}</option>";
                            }
                        }
                        ?>
                    </select>
                    <br><br>
                    <label for="estatura">Estatura de la mascota:</label>
                    <select class="controls" id="estatura" name="estatura" required>
                        <?php
                        $sql = "SELECT id_estatura, descripcion FROM estatura";
                        $result = $conexion->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id_estatura']}'>{$row['descripcion']}</option>";
                            }
                        }
                        ?>
                    </select>
                    <br><br>
                    <input class="boton-login" style="width: 50%; max-width: 200px; cursor: pointer;" type="submit" value="Agregar">
                </form>
                <a href="mascotas.php" class="boton-login">Cancelar</a>
            </div>
        </div>
    </main>
</div>
</body>
</html>
