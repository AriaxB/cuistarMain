<?php
session_start();
include_once '../php/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];

    $sql = "SELECT id_usuario, id_roll, contrasena FROM usuarios WHERE correo = '$correo'";
    $result = $conexion->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $id_usuario = $row["id_usuario"];
        $id_roll = $row["id_roll"];
        $contrasena_hash = $row["contrasena"];

        if (password_verify($clave, $contrasena_hash)) {
            $_SESSION["id_usuario"] = $id_usuario;
            $_SESSION["id_roll"] = $id_roll;

            switch ($id_roll) {
                case 1:
                    header("Location: admin.php");
                    break;
                case 2:
                    header("Location: empleado.php"); 
                    break;
                case 3:
                    header("Location: ../vistas/administrador.php"); 
                    break;
                default:
                    header("Location: ../vistas/inicio.php");
            }
            exit();
        } else {
            $_SESSION['message'] = "Contraseña incorrecta.";
            header("Location: ../vistas/iniciarSesion.php"); 
            exit();
        }
    } else {
        $_SESSION['message'] = "El correo electrónico no está registrado.";
        header("Location: ../vistas/registrarse.php"); 
        exit();
    }
} else {
    header("Location: ../vistas/iniciarSesion.php");
    exit();
}
?>
