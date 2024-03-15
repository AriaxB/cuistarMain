<?php
include_once '../php/conexion.php'; 
session_start();

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}

// Verificar si se ha enviado el formulario para eliminar la venta
if(isset($_POST['eliminar_venta'])) {
    $id_venta = $_POST['id_venta'];
    
    // Verificar si existen detalles asociados a esta venta en la tabla `pedido`
    $query_check_pedidos = "SELECT COUNT(*) as total FROM pedido WHERE id_orden = '$id_venta'";
    $resultado_check_pedidos = mysqli_query($conexion, $query_check_pedidos);
    $row_check_pedidos = mysqli_fetch_assoc($resultado_check_pedidos);
    $total_pedidos = $row_check_pedidos['total'];
    
    // Si existen detalles, mostrar un mensaje y no realizar la eliminación
    if($total_pedidos > 0) {
        echo "<script>alert('Primero elimine los detalles asociados a esta venta');</script>";
    } else {
        // No hay detalles asociados, podemos eliminar la venta
        // Realizar la eliminación de la venta en la base de datos
        $query_delete_venta = "DELETE FROM ventas WHERE id_venta = '$id_venta'";
        $resultado_delete_venta = mysqli_query($conexion, $query_delete_venta);

        // Verificar si la eliminación fue exitosa
        if($resultado_delete_venta) {
            // Redirigir a la misma página para actualizar la tabla
            echo "<script>alert('Venta eliminada correctamente');</script>";
            echo "<script>window.location.href = '{$_SERVER['PHP_SELF']}';</script>";
            exit();
        } else {
            echo "Error al eliminar la venta.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
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
                    <img class="foto-perfil" style="width: 80px; height: 80px; margin-bottom: 5px; margin-left: 15px; margin-right:auto;" src="<?php echo isset($_SESSION['foto_perfil']) && !empty($_SESSION['foto_perfil']) ? '../imgPerfiles/' . $_SESSION['foto_perfil'] : '../imgPerfiles/perfilPredeterminado.jpg'; ?>" alt="Foto de perfil">
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
                    </div>
                </div>
            </footer>
        </aside>
        <main>
            <div class="tablas-informativas">
                <div class="tabla-impresion">
                    <h2>Todas las Órdenes de pedido 🐕‍🦺</h2>
                    <table id="t-all">
                        <thead>
                        <tr>
                            <th>N° Orden</th>
                            <th>Cliente</th>
                            <th>Celular</th>
                            <th>Correo</th>
                            <th>Cedula</th>
                            <th>Fecha del pedido</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT v.id_user, v.id_venta, v.fecha_creacion, u.nombres, u.apellidos, u.telefono, u.correo, u.cedula
                                  FROM ventas v
                                  INNER JOIN usuarios u ON v.id_user = u.id_usuario";
                        $resultado = mysqli_query($conexion, $query);
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            echo '<tr>';
                            echo "<td>".$row['id_venta']."</td>";
                            echo "<td>".$row['nombres']." ".$row['apellidos']."</td>";
                            echo "<td>".$row['telefono']."</td>";
                            echo "<td>".$row['correo']."</td>";
                            echo "<td>".$row['cedula']."</td>";
                            echo "<td>".$row['fecha_creacion']."</td>";
                            echo "<td>
                                 
                                    <form action='ventasDetalles.php' method='get'>
                                        <input type='hidden' name='id_orden' value='".$row['id_venta']."'>
                                        <button class=\"boton-login\" type='submit'>Ver detalles</button>
                                    </form>
                                 <form action='' method='post'>
    <input type='hidden' name='id_venta' value='".$row['id_venta']."'>
    <button class=\"boton-login\" type='submit' name='eliminar_venta'>Eliminar</button>
</form>

                                  </td>";
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
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
                    'copy', '', 'excel', 'pdf', ''
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
