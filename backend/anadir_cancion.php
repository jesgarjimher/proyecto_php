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

                $tituloGet = $_POST["titulo"];
                $duracion = $_POST["duracion"];
                $cod_album = $_POST["cod_album"];
                $num_pista = $_POST["num_pista"];

                //1. Conexion
                $conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);
                mysqli_set_charset($conexion, "utf8");
                //escapamos simbolos como comillas y evita inyeccion de ciertos caracteres
                $titulo = mysqli_real_escape_string($conexion, $tituloGet);

                //2. BBDD
                mysqli_select_db($conexion, $bbdd);

                
                if (isset($_POST["cod_cancion_editar"])) {
                    $cod_cancion_editar = $_POST["cod_cancion_editar"];
                }else {
                    $cod_cancion_editar = null;
                }

                if ($cod_cancion_editar) {
                    $id_edit = $_POST["cod_cancion_editar"];
                    $comprobar_pista = "SELECT * FROM canciones WHERE cod_album = $cod_album AND num_pista = $num_pista AND cod_cancion != $id_edit";
                } else {
                    $comprobar_pista = "SELECT * FROM canciones WHERE cod_album = $cod_album AND num_pista = $num_pista";
                }

                // comprobar la existencia de la pista en el album
                $resultadoComprobacion = mysqli_query($conexion, $comprobar_pista);

                if(mysqli_num_rows($resultadoComprobacion) > 0) {
                    // existe duplicado, luego rediigimos con mensaje
                    $mensaje = "Pista: $num_pista ya existe, revisa las pistas del album";
                    header("Location: formulario_canciones.php?error=duplicada&mensaje=$mensaje&cod_album=$cod_album");
                    exit();
                }

                if($cod_cancion_editar) {
                    $id_edit = $_POST["cod_cancion_editar"];
                    $consulta = "UPDATE canciones 
                                SET titulo='$titulo', duracion='$duracion', num_pista=$num_pista, cod_album=$cod_album 
                                WHERE cod_cancion=$id_edit";
                }else { //si es crear
                    $ultima_id = mysqli_query($conexion, "SELECT MAX(cod_cancion) AS max_id FROM canciones");
                    $fila_id = mysqli_fetch_assoc($ultima_id);
                    $nuevo_id = $fila_id['max_id'] + 1; // calculamos el siguiente

                    //3. Definir query de álbum
                    $consulta = "INSERT INTO canciones(cod_cancion,titulo,duracion,num_pista,cod_album) VALUES($nuevo_id,'$titulo','$duracion',$num_pista,$cod_album);"; 


                }



                //4. ejecutar query
                $resultado = mysqli_query($conexion, $consulta);

                //7.cerrar conexion
                mysqli_close($conexion);
                $mensaje = "Canción guardada con éxito";
                header("Location:formulario_canciones.php?mensaje=$mensaje&cod_album=$cod_album");

            }catch(mysqli_sql_exception $msg) {
                $error = $msg->getCode();
                $mensaje = $msg->getMessage();

                if($error == 1062) {
                    $mensaje = "El num de pista elegido ya existe para el album";
                }
                header("Location:formulario_canciones.php?error=$error&mensaje=$mensaje");
                exit();
            }


}else {
    header("Location:formulario_cancion.php");
    exit();
}

?>