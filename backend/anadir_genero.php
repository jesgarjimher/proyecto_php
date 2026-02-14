<?php
       require_once("sesion.php");


if(isset($_POST["enviar"])) {
    try {
        require("../conexion_discoteca.php");
    }catch(Throwable $error) {
        echo "Mensaje: ".$error->getMessage();
        exit();
    }



    try {
        $generoPost = $_POST["genero"];

        //1. Conexion
        $conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);
        $genero = mysqli_real_escape_string($conexion, $generoPost);


        //2. base de datos 
        mysqli_select_db($conexion, $bbdd);

        //3. definir query
        $consulta = "INSERT INTO generos (genero) VALUES ('$genero');";

        //4. ejecutar query
        $resultado = mysqli_query($conexion, $consulta);

        //5. cerrar conexion
        mysqli_close($conexion);
    }catch(mysqli_sql_exception $msg) {
        $error = $msg->getCode();
        $mensaje = $msg->getMessage();
        header("Location:formulario_genero.php?error=$error&mensaje=$mensaje");
        exit();
    }

}else {
    header("Location:formulario_genero.php");
    exit();
}



?>