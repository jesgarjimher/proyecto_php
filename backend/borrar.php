<?php

       require_once("sesion.php");

require("../conexion_discoteca.php");
$conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);

// borar grupo
if (isset($_GET["cod_grupo"])) {
    $id = (int)$_GET["cod_grupo"];

    try {
        
        $consulta = mysqli_query($conexion, "SELECT foto FROM grupos WHERE cod_grupo = $id");
        $fila = mysqli_fetch_assoc($consulta);
        if($fila && !empty($fila['foto'])) {
            $ruta = "../media/img/grupos/" . $fila['foto'];
            if(file_exists($ruta)) unlink($ruta);
        }

        if(mysqli_query($conexion, "DELETE FROM grupos WHERE cod_grupo = $id")) {
            header("Location: grupos_back.php?mensaje=eliminado");
        }else {
                header("Location: grupos_back.php?error=Error");
        }
    }catch (Throwable $error) {
        $error = $error->getMessage();
        header("Location:grupos_back.php?error=$error");
    }
    exit(); 
}

//album
if (isset($_GET["cod_album"]) && !isset($_GET["cod_cancion"])) { //negacion para que no borre album con el metodo borrar cancion
    $cod_album = $_GET["cod_album"];

    try {
        $consulta = mysqli_query($conexion, "SELECT portada FROM albumes WHERE cod_album = $cod_album");
        $fila = mysqli_fetch_assoc($consulta);
        if($fila && !empty($fila["portada"])) {
            $ruta = "../media/img/albumes/" . $fila["portada"];
            if (file_exists($ruta)) unlink($ruta);
        }

        if(mysqli_query($conexion, "DELETE FROM albumes WHERE cod_album = $cod_album")) {
            $mensaje = "Eliminado corectamente";
            header("Location: albumes_back.php?mensaje=$mensaje");
        }else {
            $error = "Error al borrar";
            header("Location: albumes_back.php?error=$error");
        }
    }catch(Throwable $error) {
        $error = $error->getMessage();
        header("Location: grupos_back.php?error=$error");
    }
    exit();
}


if (isset($_GET["cod_cancion"]) && isset($_GET["cod_album"])) {
    $cod_cancion = (int)$_GET["cod_cancion"];
    $cod_album = $_GET["cod_album"];

    try {
        if (mysqli_query($conexion, "DELETE FROM canciones WHERE cod_cancion = $cod_cancion")) {
            $mensaje = "Canción eliminada";
            if($cod_album) {
                header("Location:canciones_back.php?cod_album=$cod_album&mensaje=$mensaje");
            }else {
                header("Location:grupos_back.php?mensaje=$mensaje");
            }
        }else {
            $error = "Error al borrar";
            if($cod_album) {
                header("Location:canciones_back.php?cod_album=$cod_album&error=$error");
            }else {
                header("Location:grupos_back.php?error=$error");
            }
        }
    }catch(Throwable $error) {
        $error = $error->getMessage();
        header("Location: grupos_back.php?error=$error");
    }
    exit();
}

header("Location:grupos_back.php");
?>