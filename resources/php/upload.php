<?php
session_start();
include_once 'conexion.php';


// Verificar si se ha enviado una imagen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar la imagen si se ha enviado
    if (isset($_FILES['foto_perfil']) && !empty($_FILES['foto_perfil']['name'])) {
        $rutaCarpeta = '../imgPerfiles/';
        $nombreArchivo = $_FILES['foto_perfil']['name'];
        $rutaTemporal = $_FILES['foto_perfil']['tmp_name'];
        $rutaDestino = $rutaCarpeta . $nombreArchivo;
        $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'gif');
        $extensionArchivo = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

        if (in_array($extensionArchivo, $extensionesPermitidas) && $_FILES['foto_perfil']['size'] <= 5 * 1024 * 1024) {
            if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
                $usuario_id = $_SESSION['id_usuario'];

                $consulta = $conexion->prepare("UPDATE usuarios SET foto_perfil = ? WHERE id_usuario = ?");
                $consulta->bind_param('si', $nombreArchivo, $usuario_id);

                if ($consulta->execute()) {
                    $_SESSION['foto_perfil'] = $nombreArchivo;
                    
                    // Redirigir según el  roldel usuario
                    switch ($_SESSION['id_roll']) {
                        case '4':
                            header("Location: ../vistas/perfil.php");
                            exit();
                        case '3':
                            header("Location: ../vistas/administrador.php");
                            exit();
                        default:
                            // Manejar cualquier otro rol aquí
                            header("Location: ../../index.html");
                            exit();
                    }
                } else {
                    echo "Error al actualizar la base de datos";
                }
            } else {
                echo "Error al mover el archivo: " . $_FILES['foto_perfil']['error'];
            }
        } else {
            echo "Tipo de archivo no permitido o tamaño excedido.";
        }
    } else {
        echo "Selecciona una imagen ";
    }
}
?>
