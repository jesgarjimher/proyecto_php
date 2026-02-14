<?php

try{
    require("../conexion_discoteca.php");

}catch(Throwable $t){
    echo "Mensaje: ".$t->getMessage();
    exit();
}


try {
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar"])) {
        $user = trim($_POST["user"]);
        $pass = $_POST["pass"];

        if(empty($user) || empty($pass)) {
            die("Todos los campos son obligatorios");
        }

        $conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);
        $user = mysqli_real_escape_string($conexion, $user); //mysqli_real_escape...no permite inyectar ciertos caracteres peligrosos a la consulta sql
        $pass = mysqli_real_escape_string($conexion, $pass);

        $password_hash = password_hash($pass, PASSWORD_DEFAULT);
        $consulta = "INSERT INTO usuarios (usuario, password_hash) VALUES ('$user','$password_hash');";

        mysqli_query($conexion, $consulta);

        echo "Usuario registrado con éxito";
        mysqli_close($conexion);
        }

}catch(mysqli_sql_exception $msg) {
    echo "<p>Error nº.  ".$msg->getCode()."</p>";
    echo "<p>Mensaje:  ".$msg->getMessage()."</p>";
}















?>