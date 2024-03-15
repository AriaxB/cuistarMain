<?php
 session_start();
 include_once '../../php/conexion.php';
 // Verificar si el usuario tiene la sesión iniciada
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 4) { 
    header("Location: ../../vistas/iniciarSesion.php");
    exit(); 
}
 $id_usuario = $_SESSION['id_usuario'];
    $sql = "SELECT u.*, r.descripcion AS nombre_rol
            FROM usuarios u
            INNER JOIN roll r ON u.id_roll = r.id_rol
            WHERE u.id_usuario = $id_usuario"; 
 ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="shortcut icon" href="../../img/logo.png" type="image/x-icon">
    <title>CUISTAR</title>
</head>

<body>
    <div class="container">
        <aside class="sidebar">
            <ul>
                <div class="contenedor-foto">
                    <!-- Mostrar la imagen de perfil -->
                    <img class="foto-perfil" style="width: 80px; height: 80px; margin-bottom: 5px; margin-left: 15px; margin-right:auto;" src="<?php echo isset($_SESSION['foto_perfil']) && !empty($_SESSION['foto_perfil']) ? '../imgPerfiles/' . $_SESSION['foto_perfil'] : '../../imgPerfiles/perfilPredeterminado.jpg'; ?>" alt="Foto de perfil">
                <?php   
                echo '<h1>' . $_SESSION['nombres'] . ' ' . $_SESSION['apellidos'] . '</h1>';
                ?>
                </div>
                <li></li>
                <li><a href="../../vistas/perfil.php">Datos</a></li>
                <li><a href="../../vistas/mascotas.php">Mascotas</a></li>
                <li><a href="verOrdenes.php">Pedidos</a></li>
                <li><a href="../../vistas/pqrs.php">Pqrs</a></li>
                <li><a href="../../vistas/inicio.php">Regresar</a></li>
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
            <div class="tablas-informativas">
                <div class="tabla-impresion">
                    <h2>Detalle de la orden de pedido 🐕‍🦺</h2>
                    <table>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Valor Total</th>
                        </tr>
                        <?php
                        $idUser = $_SESSION['id_usuario'];
                        $idOrden = $_GET['id_orden'];
                        //consulta para traer los productos
                        $query = "SELECT pr.nombre, p.cantidad, v.descripcion, p.valor_total
                        FROM id21913908_cuistar.ventas as v
                        INNER JOIN id21913908_cuistar.pedido as p ON v.id_venta = p.id_orden
                        INNER JOIN id21913908_cuistar.productos as pr ON pr.id_producto = p.id_producto
                        WHERE (v.id_venta = '$idOrden');
                        ";
                        //consulta para traer fecha de la orden
                        $query2 = "SELECT fecha_creacion, descripcion FROM ventas WHERE id_venta='$idOrden'";
                        //consulta para sumar los totales de los pedidos asociados a la orden
                        $query3 = "SELECT sum(p.valor_total) as total
                        from id21913908_cuistar.ventas as v
                        inner join id21913908_cuistar.pedido as p on v.id_venta=p.id_orden
                        inner join id21913908_cuistar.productos as pr on pr.id_producto=p.id_producto
                         where (v.id_venta='$idOrden');";
                        $resultado = mysqli_query($conexion, $query);
                        $resultado2 = mysqli_query($conexion, $query2);
                        $resultado3 = mysqli_query($conexion, $query3);
                        $r2 = mysqli_fetch_assoc($resultado2);
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td>" . $row['nombre'] . "</td>";
                            echo "<td>" . $row['cantidad'] . "</td>";
                            echo "<td>" . $row['valor_total'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                 
                       </table>
                     <p>Descripcion: <?php echo $r2['descripcion'] ?></p>
                    <h1 style="font-size: 15px;">fecha de creacion: <?php echo $r2['fecha_creacion'] ?></h1>
                    <h1>valor total: <?php
                                        if ($resultado3 && mysqli_num_rows($resultado3) > 0) {
                                            $r3 = mysqli_fetch_assoc($resultado3);
                                            $total = $r3['total'];

                                            echo $total;
                                        } else {
                                            echo "error" . mysqli_connect_error($conexion);
                                        }

                                        ?></h1>
                </div>
            </div>
        </main>
    </div>
</body>

</html>