<?php



try {
    require("../conexion_discoteca.php");
}catch(Throwable $error) {
    echo "Mensaje: ".$error->getMessage();
    exit();
}



try {
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar"])) {
        $user = trim($_POST["user"]);
        $pass = $_POST["pass"];

        if(empty($user) OR empty($pass)) {
            die("Por favor rellene todos los campos");
        }

    $conexion = mysqli_connect($servidor,$usuario,$password,$bbdd);
    $user = mysqli_real_escape_string($conexion,$user);
    $pass = mysqli_real_escape_string($conexion,$pass);
    
    $consulta = "SELECT id_usuario, password_hash FROM usuarios WHERE usuario = '$user';";
   
    $resultado = mysqli_query($conexion, $consulta);
    
    $fila = mysqli_fetch_array($resultado);

    if($fila && password_verify($pass, $fila["password_hash"])) {
        // login correcto, se inicia sesion
        session_start();
        $_SESSION["usuario"] = $_POST["user"];
        $_SESSION["logueado"] = true;
        $_SESSION["hora"] = time();
        header("Location:formulario_grupo.php");
        exit();
    } {
        header("Location:login.php?mensaje=1");
    }
    mysqli_close($conexion);

    }else {
        header("Location:login.php");
        exit();
    }

}catch(mysqli_sql_exception $msg) {
    echo "<p>Error cód: ".$msg->getCode()."</p>";
    echo "<p>Mensaje: ".$msg->getMessage()."</p>";
}



















?>