<?php
session_start();
include_once '../php/conexion.php';

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
                <div class="contenedor-foto">
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
            <div class="tablas-informativas">
                <div class="tabla-impresion">
                    <h2>PQRS 🐶</h2>
                    <!-- Formulario de búsqueda sin select -->
                    <form action="" method="GET">
                  
                    </form>
                    <!-- Tabla de resultados -->
                     <table id="t-all">
                         <thead>
                        <tr>
                            <th>N° PQRS</th>
                            <th>Tipo</th>
                            <th>Cédula</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Correo Electrónico</th>
                            <th>Asunto</th>
                            <th>Evidencia</th>
                            <th>Fecha</th>
                            <th>Respuesta</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                         <tbody>
                        <?php
                        if (isset($_GET['busqueda'])) {
                            // Si se ha enviado una búsqueda, procesarla
                            $busqueda = $_GET['busqueda'];
                            // Realizar la consulta con la búsqueda
                            $sql = "SELECT p.*, t.descripcion AS tipo_desc, e.descripcion AS estado_desc
                                    FROM pqrs p
                                    LEFT JOIN tipo_pqrs t ON p.id_tipo = t.id_tipo
                                    LEFT JOIN estado e ON p.id_estado = e.id_estado
                                    WHERE p.nombres LIKE '%$busqueda%' OR p.apellidos LIKE '%$busqueda%' OR p.asunto LIKE '%$busqueda%'";
                            $result = $conexion->query($sql);
                        
                            if ($result === false) {
                                echo "Error al ejecutar la consulta: " . $conexion->error;
                            } else {
                                // Mostrar los resultados de la búsqueda de PQRS
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['id_pqrs']}</td>";
                                    echo "<td>{$row['tipo_desc']}</td>";
                                    echo "<td>{$row['cedula']}</td>";
                                    echo "<td>{$row['nombres']}</td>";
                                    echo "<td>{$row['apellidos']}</td>";
                                    echo "<td>{$row['correo_electronico']}</td>";
                                    echo "<td>{$row['asunto']}</td>";
                                    echo "<td>{$row['evidencia']}</td>";
                                    echo "<td>{$row['fecha']}</td>";
                                    echo "<td>{$row['respuesta']}</td>";
                                    echo "<td>{$row['estado_desc']}</td>";
                        
                                    echo "<td>";
                                    echo "<button onclick=\"window.location.href='actualizarPqrs.php?id={$row['id_pqrs']}'\" class='boton-login'>Responder</button>";
                                    echo "<button onclick=\"if(confirm('¿Estás seguro de que quieres eliminar esta PQRS?')) { window.location.href='../php/eliminarPqrs.php?id={$row['id_pqrs']}'; }\" class='boton-login'> Eliminar </button>";
                                    echo "</td>";
                        
                                    echo "</tr>";
                                }
                            }
                        } else {
                            // Si no se ha enviado una búsqueda, mostrar todas las PQRS
                            $sql = "SELECT p.*, t.descripcion AS tipo_desc, e.descripcion AS estado_desc
                                    FROM pqrs p
                                    LEFT JOIN tipo_pqrs t ON p.id_tipo = t.id_tipo
                                    LEFT JOIN estado e ON p.id_estado = e.id_estado";
                            $result = $conexion->query($sql);
                        
                            if ($result === false) {
                                echo "Error al ejecutar la consulta: " . $conexion->error;
                            } else {
                                // Mostrar todas las PQRS
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['id_pqrs']}</td>";
                                    echo "<td>{$row['tipo_desc']}</td>";
                                    echo "<td>{$row['cedula']}</td>";
                                    echo "<td>{$row['nombres']}</td>";
                                    echo "<td>{$row['apellidos']}</td>";
                                    echo "<td>{$row['correo_electronico']}</td>";
                                    echo "<td>{$row['asunto']}</td>";
                                    echo "<td>{$row['evidencia']}</td>";
                                    echo "<td>{$row['fecha']}</td>";
                                    echo "<td>{$row['respuesta']}</td>";
                                    echo "<td>{$row['estado_desc']}</td>";
                        
                                    echo "<td>";
                                    echo "<button onclick=\"window.location.href='actualizarPqrs.php?id={$row['id_pqrs']}'\" class='boton-login'>Responder</button>";
                                    echo "<button onclick=\"if(confirm('¿Estás seguro de que quieres eliminar esta PQRS?')) { window.location.href='../php/eliminarPqrs.php?id={$row['id_pqrs']}'; }\" class='boton-login'> Eliminar </button>";
                                    echo "</td>";
                        
                                    echo "</tr>";
                                }
                            }
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
