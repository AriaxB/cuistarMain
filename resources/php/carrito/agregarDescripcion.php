    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/styles.css?1.0">
        <link rel="shortcut icon" href="../../img/logo.png" type="image/x-icon">
        <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
        <title>CUISTAR</title>
    </head>

    <body>
        <header>
            <div class="logo">
                <a href="Index.html">
                    <img src="../../img/logo.png" style="width: 50px; height: 50px" alt="Logo">
                </a>
            </div>
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <nav>
                <ul class="menu">
                    <li><a href="../../vistas/inicio.php">volver</a></li>
                    <li><a href="../../vistas/perfil.php">Perfil</a></li>
                    <li><a href="../cerrarSesion.php">Cerrar sesión</a></li>
                </ul>
            </nav>
        </header>

        <div class="description-order">
            <?php
            echo "
        <form class='orderDescription' form action='./crearOrden.php' method='post'>
            <textarea name='descripcion' id='descripcion_orden' placeholder='ingrese alguna descripcion para realizar su pedido'></textarea>
            <button type='submit'>crear pedido</button>
        </form>
        <a class='btn-cancelar' href='../../vistas/inicio.php'><button>cancelar</button></a>
    
    ";
            ?>

        </div>


    </body>
    <footer>
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


    </html>