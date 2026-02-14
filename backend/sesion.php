<?php
session_start();

//comprobacion del estado logueado
if(!$_SESSION["logueado"]) {
    session_destroy();
    header("Location:login.php");
    exit();
}

//tiempo de sesion 20 mins
if($_SESSION["hora"] + 1200 < time()) {
    session_destroy();
    header("Location:login.php?mensaje=caducada");
    exit();
}

//inactividad 2mins
if(isset($_SESSION["timeout"])) {
    $vida_sesion = time() - $_SESSION["timeout"];
    if($vida_sesion > 120) {
        session_destroy();
        header("Location:login.php?mensaje=inactividad");
        exit();
    }
}

$_SESSION["timeout"] = time();



























?>