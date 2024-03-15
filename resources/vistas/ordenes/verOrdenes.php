<?php
session_start();
include_once '../../php/conexion.php';

// Verificar si el usuario tiene la sesión iniciada
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 4) { 
    header("Location: ../../vistas/iniciarSesion.php");
    exit(); 
}

$idUsuario = $_SESSION['id_usuario'];

// Obtener los datos del usuario actual
$queryUsuario = "SELECT * FROM usuarios WHERE id_usuario = $idUsuario";
$resultadoUsuario = mysqli_query($conexion, $queryUsuario);
$datosUsuario = mysqli_fetch_assoc($resultadoUsuario);

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
                    <img class="foto-perfil" style="width: 80px; height: 80px; margin-bottom: 5px; margin-left: 15px; margin-right:auto;" src="<?php echo isset($datosUsuario['foto_perfil']) && !empty($datosUsuario['foto_perfil']) ? '../../imgPerfiles/' . $datosUsuario['foto_perfil'] : '../../imgPerfiles/perfilPredeterminado.jpg'; ?>" alt="Foto de perfil">
                    <h1><?php echo $datosUsuario['nombres'] . ' ' . $datosUsuario['apellidos']; ?></h1>
                </div>
                <li></li>
                <li><a href="../../vistas/perfil.php">Datos</a></li>
                <li><a href="../../vistas/mascotas.php">Mascotas</a></li>
                <li><a href="verOrdenes.php">Pedidos</a></li>
                <li><a href="../../vistas/pqrs.php">Pqrs</a></li>
                <li><a href="../../vistas/inicio.php">Regresar</a></li>
                <li><a href="../../php/cerrarSesion.php">Cerrar sesión</a></li>
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
                    <h2>Tus Órdenes Pedidos 🐕‍🦺</h2>
                    <table id="t-all">
                        <thead>
                        <tr>
                            <th>N° Orden</th>
                            <th>Cliente</th>
                            <th>Teléfono</th>
                            <th>Correo Electrónico</th>
                            <th>Cédula</th>
                            <th>Fecha de creación</th>
                            <th>Ver</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $queryPedidos = "SELECT v.id_venta, v.fecha_creacion, u.nombres, u.apellidos, u.telefono, u.correo, u.cedula
                                  FROM ventas v
                                  INNER JOIN usuarios u ON v.id_user = u.id_usuario
                                  WHERE v.id_user = $idUsuario";
                        $resultadoPedidos = mysqli_query($conexion, $queryPedidos);
                        while ($row = mysqli_fetch_assoc($resultadoPedidos)) {
                            echo '<tr>';
                            echo "<td>".$row['id_venta']."</td>";
                            echo "<td>".$row['nombres']." ".$row['apellidos']."</td>";
                            echo "<td>".$row['telefono']."</td>";
                            echo "<td>".$row['correo']."</td>";
                            echo "<td>".$row['cedula']."</td>";
                            echo "<td>".$row['fecha_creacion']."</td>";
                            echo "<td><form action='verDetalles.php' method='get'>
                                <input type='hidden' name='id_orden' id='id_orden' value='".$row['id_venta']."' >
                             <button class=\"boton-login\" type='submit'>Ver detalles</button>

                                </form></td>";
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
