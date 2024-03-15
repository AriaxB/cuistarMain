<?php
session_start();
include_once '../php/conexion.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['id_roll'] != 3) { 
    header("Location: iniciarSesion.php");
    exit(); 
}


    $sql = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.imagen,p.cantidad, p.salidas, p.fecha_vencimiento, um.descripcion AS unidad_medida_desc, c.descripcion AS categoria_desc, t.descripcion AS talla_desc, tp.descripcion AS tipo_producto_desc
            FROM productos p
            LEFT JOIN unidad_medida um ON p.id_unidadmedida = um.id_unidadmedida
            LEFT JOIN categoria c ON p.id_categoria = c.id_categoria
            LEFT JOIN tallas t ON p.id_tallas = t.id_tallas    
            LEFT JOIN tipo_producto tp ON p.id_tipoprodu = tp.id_tipoprodu";



$result = $conexion->query($sql);

if ($result === false) {
    echo "Error al ejecutar la consulta: " . $conexion->error;
} else {
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
            <div class="contenedor-foto" >
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
                </div>
            </div>
        </footer>
    </aside>
        <main>
            <div class="tablas-informativas">
                <div class="tabla-impresion">
                    <h2>Productos 🐩</h2>
                <form action="" method="GET" onsubmit="buscarProducto()">
                    <div style="display: flex;justify-content: flex-start;align-items: center;margin-right: 27%;">
                      
                        <div>   
                           
                            <a href="agregarProducto.php" class="boton-login">Agregar</a>
                        </div>
                    </div>
                </form>
                 <table id="t-all">
                    <thead>
                    <tr>
                        <th>N° Producto</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Unidad de Medida</th>
                        <th>Categoría</th>
                        <th>Talla</th>
                        <th>Tipo de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Fecha de vencimiento</th>
                        <th>Salidas</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['id_producto']}</td>";
                            echo "<td>{$row['nombre']}</td>";
                            echo "<td>{$row['descripcion']}</td>";
                            echo "<td>{$row['unidad_medida_desc']}</td>";
                            echo "<td>{$row['categoria_desc']}</td>";
                            echo "<td>{$row['talla_desc']}</td>";
                            echo "<td>{$row['tipo_producto_desc']}</td>";
                            echo "<td>{$row['cantidad']}</td>";
                            echo "<td>{$row['precio']}</td>";
                            echo "<td>{$row['fecha_vencimiento']}</td>";
                            echo "<td>{$row['salidas']}</td>";
                              
                  

          

                           
                            echo "<td><img src='{$row['imagen']}' alt='{$row['nombre']}' style='width: 100px; height: auto;'></td>";
                            echo "<td>";
                            echo "<button onclick=\"window.location.href='actualizarProducto.php?id={$row['id_producto']}'\" class='boton-login'>Actualizar</button>";
                            echo "<form action='../php/eliminarProducto.php' method='POST'>";
                            echo "<input type='hidden' name='id_producto' value='{$row['id_producto']}'>";
                            echo "<button type='submit' onclick=\"return confirm('¿Estás seguro de que quieres eliminar este producto?');\" class='boton-login'>Eliminar</button>";
                            echo "</form>";                            echo "</td>";
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

<script>
    function eliminarProducto(id_producto) {
        if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
            window.location.href = `../php/eliminarProducto.php?id=${id_producto}`;
        }
    }
</script>

</html>
<?php
}
?> 
