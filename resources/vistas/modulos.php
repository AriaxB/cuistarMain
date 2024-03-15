<?php
include_once '../php/conexion.php'; 
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
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
    <link rel="stylesheet" href="
https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css
">
    <link rel="stylesheet" type="text/css" href="
https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css
"/>
    <link rel="stylesheet" type="text/css" href="
https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css
"/>
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <title>CUISTAR</title>
</head>
<style>
    .informacion-usuario {
        display: flex;
    justify-content: center;
    flex-wrap: wrap;
}
.informacion-usuario {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    position: absolute;
    top: 55%;
    left: 49%;
    margin-right: auto;
    margin-left: 10%;
    transform: translate(-51%, -57%);
    width: 56%;
    text-align: center;
    border-radius: 5px;
    max-height: 92vh;
    overflow-x: auto; 
    font-size: 0.5em;
}


.cajita {
    width: 140px;
    margin: 17px;
    padding: 20px;
    background-color: #f5f5f5;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 6px rgb(0 0 0 / 18%);
}

.cajita img {
    width: 88%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 10px;
}

.cajita h2 {
    margin-bottom: 10px;
    font-size: 20px;
}

.cajita p {
    margin-bottom: 15px;
    font-size: 16px;
}

.cajita button {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.cajita button:hover {
    background-color: #0056b3;
}




</style>
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
    <div class="informacion-usuario">
    <div class="cajita">
        <img src="../img/productos.jpg" alt="Módulo 1">
        <h2>Módulo</h2>
        <p>Inventario 🐩</p>
        <button onclick="window.location.href = 'productosAdmin.php';">Seleccionar </button>
    </div>
    
    <div class="cajita">
         <img src="../img/ventas.jpg" alt="Módulo 1">
        <h2>Módulo</h2>
        <p>Ventas 🐕‍🦺</p>
        <button onclick="window.location.href = 'ventasAdmin.php';">Seleccionar</button>
    </div>
    <div class="cajita">
         <img src="../img/pqrs.jpg" alt="Módulo 1">
        <h2>Módulo</h2>
        <p>Pqrs 🐶</p>
        <button onclick="window.location.href = 'pqrsAdmin.php';">Selecionar</button>
     </div>
            <div class="cajita">
            <img src="../img/mascotas.jpg" alt="Módulo 1">
            <h2>Módulo</h2>
            <p>Mascotas 🐾</p>
            <button onclick="window.location.href = 'mascotasAdmin.php';">Seleccionar</button>
        </div>

    <div class="cajita">
         <img src="../img/proveedores.jpg" alt="Módulo 1">
        <h2>Módulo</h2>
        <p>Proveedores 🐕</p>
        <button onclick="window.location.href = 'proveedoresAdmin.php';">Seleccionar</button>
    </div>
</div>

    </main>
</div>
</body>
</html> 