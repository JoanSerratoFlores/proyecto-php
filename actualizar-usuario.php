<?php

if (isset($_POST)) {

//CONEXION A LA BASE DE DATOS
    require_once 'includes/conexion.php';

    //INICIAR SESION
    if (!isset($_SESSION)) {
        session_start();
    }


    //Recoger los valores del fdormulario de registro

    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db, $_POST['nombre']) : false;
    $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db, $_POST['apellidos']) : false;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, trim($_POST['email'])) : false;

//Array de errores
    $errores = array();

//Validar los datos antes de guardarlos en la base de datos
//Validar el nombre    

    if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
        $nombre_validado = true;
    } else {
        $nombre_validado = false;
        $errores['nombre'] = "El nombre no es valido";
    }
    //Validar los apellidos
    if (!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)) {
        $apellidos_validado = true;
    } else {
        $apellidos_validado = false;
        $errores['apellidos'] = "Los apellidos no son validos";
    }
    //Validar el email
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_validado = true;
    } else {
        $email_validado = false;
        $errores['email'] = "El email no es valido";
    }

    if (count($errores) == 0) {
        
        $usuario = $_SESSION['usuario'];
        $guardar_usuario = true;

        //COMPROBAR SU EL EMAIL YA EXISTE
        $sql = "SELECT id,email FROM usuarios WHERE email = '$email'; ";
        $isset_email = mysqli_query($db, $sql);
        $isset_user= mysqli_fetch_assoc($isset_email);

        if($isset_user['id'] == $usuario['id'] || empty($isset_user)) {
            //ACTUALIZAR USUARIO EN LA TABLA USUARIOS DE LA BBDD
            $usuario = $_SESSION['usuario']['id'];
            $sql = "UPDATE usuarios SET nombre='$nombre',apellidos='$apellidos',email='$email' WHERE id=" . $_SESSION['usuario']['id'];
            $guardar = mysqli_query($db, $sql);

            if ($guardar) {
                $_SESSION['usuario']['nombre'] = $nombre;
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $_SESSION['usuario']['email'] = $email;

                $_SESSION['completado'] = "Tus datos se han actualizado con éxito";
            } else {
                $_SESSION['errores']['general'] = "Fallo al actualizar el usuario";
            }
        }else{
            $_SESSION['errores']['general'] = "El usuario ya existe";            
        }
    } else {

        $_SESSION['errores'] = $errores;
        
    }
    header('Location:mis-datos.php');
}


