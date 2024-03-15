<?php
session_start();
include_once '../php/conexion.php';

// Verificar si el usuario tiene la sesión iniciada y el rol correcto
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: ../../vistas/iniciarSesion.php");
    exit(); 
}

// Obtener el ID del usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];

// Consulta para obtener los datos del usuario
$sql = "SELECT u.*, r.descripcion AS nombre_rol
        FROM usuarios u
        INNER JOIN roll r ON u.id_roll = r.id_rol
        WHERE u.id_usuario = $id_usuario"; 

// Comenzar la estructura HTML
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css?1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <title>CUISTAR</title>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <ul>
                <div class="contenedor-foto">
                    <!-- Mostrar la imagen de perfil -->
                    <img class="foto-perfil" style="width: 80px; height: 80px; margin-bottom: 5px; margin-left: 15px; margin-right:auto;" src="<?php echo isset($_SESSION['foto_perfil']) && !empty($_SESSION['foto_perfil']) ? '../imgPerfiles/' . $_SESSION['foto_perfil'] : '../../imgPerfiles/perfilPredeterminado.jpg'; ?>" alt="Foto de perfil">
                    <h1><?php echo $_SESSION['nombres'] . ' ' . $_SESSION['apellidos']; ?></h1>
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
                    </div>
                </div>
            </footer>
        </aside>
        <main>
            <div class="tablas-informativas">
                <div class="tabla-impresion">
                    <h2>Detalles del pedido 🐕‍🦺</h2>
                    <table id="t-all">
                        <thead>
                            <tr>
                                <th>N° orden</th>
                                <th>N° pedido</th>
                                <th>Cliente</th>
                                <th>Correo</th>
                                <th>Celular</th>
                                <th>Cedula</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Valor Total</th>
                                <th>Acciones</th> <!-- Nuevo -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Obtener el ID del usuario de la sesión
                            $idUser = $_SESSION['id_usuario'];
                            $idOrden = $_GET['id_orden']; // Obtener el ID de la orden desde la URL
                            
                            // Consulta para obtener los detalles de la orden
                            $query = "SELECT pr.nombre, p.id_pedido, p.id_orden, p.cantidad, v.descripcion, p.valor_total, u.nombres, u.apellidos, u.correo, u.telefono, u.cedula
                                      FROM id21913908_cuistar.ventas as v
                                      INNER JOIN id21913908_cuistar.pedido as p ON v.id_venta = p.id_orden
                                      INNER JOIN id21913908_cuistar.productos as pr ON pr.id_producto = p.id_producto
                                      INNER JOIN usuarios AS u ON v.id_user = u.id_usuario
                                      WHERE (v.id_venta = '$idOrden')";

                            // Consulta para obtener la descripción y fecha de creación de la orden
                            $query2 = "SELECT descripcion, fecha_creacion FROM ventas WHERE id_venta='$idOrden'";

                            // Consulta para obtener el valor total de la orden
                            $query3 = "SELECT sum(p.valor_total) as total
                                       FROM id21913908_cuistar.ventas as v
                                       INNER JOIN id21913908_cuistar.pedido as p ON v.id_venta=p.id_orden
                                       INNER JOIN id21913908_cuistar.productos as pr ON pr.id_producto=p.id_producto
                                       WHERE (v.id_venta='$idOrden');";

                            // Ejecutar las consultas
                            $resultado = mysqli_query($conexion, $query);
                            $resultado2 = mysqli_query($conexion, $query2);
                            $resultado3 = mysqli_query($conexion, $query3);

                            // Obtener los datos de la orden y mostrarlos en la tabla
                            $r2 = mysqli_fetch_assoc($resultado2);
                            while ($row = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td>" . $row['id_orden'] . "</td>"; // Aquí se cambió a id_orden
                                echo "<td>" . $row['id_pedido'] . "</td>";
                                echo "<td>" . $row['nombres'] . " " . $row['apellidos'] . "</td>";
                                echo "<td>" . $row['correo'] . "</td>";
                                echo "<td>" . $row['telefono'] . "</td>";
                                echo "<td>" . $row['cedula'] . "</td>";
                                echo "<td>" . $row['nombre'] . "</td>";
                                echo "<td>" . $row['cantidad'] . "</td>";
                                echo "<td>" . $row['valor_total'] . "</td>";
                                echo "<td>";
                                echo "<button onclick=\"window.location.href='actualizarPedido.php?id_pedido={$row['id_pedido']}'\" class='boton-login'>Actualizar</button>";
                                echo "<form action='eliminarDetallesPedido.php' method='post'>";
                                echo "<input type='hidden' name='id_orden' value='{$row['id_pedido']}'>"; // Aquí se cambió a id_orden
                                echo "<button type='submit' name='eliminar_orden' onclick=\"return confirm('¿Estás seguro de que quieres eliminar este pedido?');\" class='boton-login'>Eliminar</button>";
                                echo "</form>";                            
                                echo "</td>";
                                echo "</tr>";

                            }
                            ?>
                        </tbody>
                    </table>
                    <h1 style="font-size: 15px;">Descripción: <?php echo $r2['descripcion'] ?></h1>
                    <h1 style="font-size: 15px;">Fecha de creación: <?php echo $r2['fecha_creacion'] ?></h1>
                    <h1>Valor total: <?php
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
    <!-- Incluir jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Incluir DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Incluir los botones de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>

    <!-- Opcional: Incluir los botones adicionales (copy, csv, excel, pdf, print) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

    <!-- Inicializar DataTables -->
    <script>
        $(document).ready(function () {
            $('#t-all').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron registros coincidentes",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": activar para ordenar la columna ascendente",
                        "sortDescending": ": activar para ordenar la columna descendente"
                    }
                }
            });
        });
    </script>
</body>
</html>
