<?php
session_start();
// Verificar si la sesión ya está iniciada
if (isset($_SESSION['id_usuario'])) {
    // Redirigir según el rol del usuario
    switch ($_SESSION['id_roll']) {
        case '4':
            header("Location: inicio.php");
            break;
        case '3':
            header("Location: administrador.php");
            break;
        default:
            // Redirigir a una página genérica en caso de un rol desconocido
            header("Location: inicio.php");
            break;
    }
    exit(); // Finalizar la ejecución del script
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
        <form class="form-admin" action="../php/iniciarSesion.php" method="POST">
            <div class="form-header">
                <h4 style="display: flex; align-items: center; margin: 0; font-size: 1.5em;">
                    <img src="../img/logo.png" alt="logo" style="width: 60px; height: 60px; margin-right: 20px; margin-bottom: 10px;">Iniciar sesión
                </h4>
            </div>
            <input class="controls" type="text" placeholder="Correo" name="correo" required>
            <input class="controls" type="password" placeholder="Contraseña" name="clave" required>
            </div>
            <div id="message" style="color: red; font-size: 20px;">
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); // Eliminar el mensaje después de mostrarlo
                }
                ?>
            <p style="color: black;">¿No tiene una cuenta? <a href="registrarse.php">Cree una.</a></p>
            <input class="boton-login value="Iniciar sesión" type="submit" style="width: 100%; max-width: 200px; margin: 10px auto; ">
        </form>
    </main>
</body>
</html>
