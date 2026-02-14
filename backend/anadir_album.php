<?php
       require_once("sesion.php");


if(isset($_POST["enviar"])) {
    try {
        require("../conexion_discoteca.php");

        
    }catch(Throwable $error) {
        echo "Mensaje: ".$error->getMessage();
        exit();
    }



    //comprobar si se envia una foto y crear carpeta destino si no existiera
    if(isset($_FILES["portada"]) && $_FILES["portada"]["name"] != "") {
        if(!file_exists("../media/img/albumes")) {
            mkdir("../media/img/albumes", 0777);
        }
    }


    $archivo = $_FILES["portada"]["tmp_name"];
    $tipo = $_FILES["portada"]["type"];
    $size = $_FILES["portada"]["size"];
    $destino = "../media/img/albumes/".$_FILES["portada"]["name"];

    $file_name = $_FILES["portada"]["name"];


    if ((($tipo == "image/png" || $tipo == "image/jpeg" || $tipo == "image/jpg")) && ($size <= 524880)) {
                //si la foto cumple las condiciones
                if (!file_exists($destino)) { //si no existe el archivo en el destino
                    //no existe --> lo subimos
                    if (move_uploaded_file($archivo, $destino)) {
                        echo "<p>Archivo subido correctamente</p>";
                    } else {
                        $msg = "Error al subir la foto de portada";
                        header("Location:formulario_album.php?error=Error&mensaje=$msg");
                        exit();
                    }
                } else {
                    //ya existe la foto en la carpeta
                    $msg = "Ya existe una foto con ese titulo";
                    header("Location:formulario_album.php?error=Error&mensaje=$msg");
                    exit();
                }

            } else {
                $msg = "Formato de la foto inválido";
                header("Location:formulario_album.php?error=Error&mensaje=$msg");
                exit();
            }

        

            try {

                $titulo = $_POST["titulo"];
                $fecha = $_POST["fecha"];
                $cod_grupo = $_POST["cod_grupo"];
                $cod_genero = $_POST["cod_genero"];

                //1. Conexion
                $conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);

                $ultima_id = mysqli_query($conexion, "SELECT MAX(cod_album) AS max_id FROM albumes");
                $fila_id = mysqli_fetch_assoc($ultima_id);
                $nuevo_id = $fila_id['max_id'] + 1; // Calculamos el siguiente

                //2. BBDD
                mysqli_select_db($conexion, $bbdd);

                //3. Definir query de álbum
                if(isset($_FILES['portada']) && $_FILES['portada']['name'] != "") {
                    $consulta = "INSERT INTO albumes(cod_album,titulo,fecha,cod_grupo,portada) VALUES('$nuevo_id','$titulo','$fecha','$cod_grupo','$file_name');"; 
                }else {
                    $consulta = "INSERT INTO albumes(cod_album,titulo,fecha,cod_grupo) VALUES('$nuevo_id','$titulo','$fecha','$cod_grupo');";
                }




                //4. ejecutar query
                $resultado = mysqli_query($conexion, $consulta);

                //5. query de tabla album_genero
                    //id del album insertardo
                $id_album = $nuevo_id;
                $consultaRelacion = "INSERT INTO albumes_generos (cod_album, cod_genero) VALUES($id_album, $cod_genero);";

                //6. ejecutar query de tabla relacion album_genero
                $resultadoRelacion = mysqli_query($conexion,$consultaRelacion);

                //7.cerrar conexion
                mysqli_close($conexion);
                $mensaje = "Álbum $titulo anadido con éxito";
                header("Location:formulario_canciones.php?cod_album=$nuevo_id&mensaje=$mensaje");

            }catch(mysqli_sql_exception $msg) {
                $error = $msg->getCode();
                $mensaje = $msg->getMessage();
                header("Location:formulario_album?error=$error&mensaje=$mensaje");
                exit();
            }


}else {
    header("Location:formulario_album.php");
    exit();
}

?>