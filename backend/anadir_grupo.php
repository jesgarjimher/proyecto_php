<?php

       require_once("sesion.php");

if(isset($_POST["enviar"])) {
    try {
        require("../conexion_discoteca.php");
    }catch(Throwable $error) {
        echo "Mensaje: ".$error->getMessage();
        exit();
    }

    $file_name = "";


    //comprobar si se envia una foto y crear carpeta destino si no existiera
    if(isset($_FILES["foto"]) && $_FILES["foto"]["name"] != "") {
        $archivo = $_FILES["foto"]["tmp_name"];
        $tipo = $_FILES["foto"]["type"];
        $size = $_FILES["foto"]["size"];
        $destino = "../media/img/grupos/".$_FILES["foto"]["name"];
        $file_name = $_FILES["foto"]["name"];



        if ((($tipo == "image/png" || $tipo == "image/jpeg" || $tipo == "image/jpg")) && ($size <= 1048576)) {
                    //si la foto cumple las condiciones
                    if(!file_exists("../media/img/grupos")) {
                        mkdir("../media/img/grupos", 0777);
                    }
                    if (!file_exists($destino)) { //si no existe el archivo en el destino
                        //no existe --> lo subimos
                        if (move_uploaded_file($archivo, $destino)) {
                            echo "<p>Archivo subido correctamente</p>";
                        } else {
                            $msg = "Error al subir la foto";
                            header("Location:formulario_grupo.php?error=Error&mensaje=$msg");
                            exit();
                        }
                    } else {
                        //ya existe la foto en la carpeta
                        $msg = "Ya existe una foto con ese nombre";
                        header("Location:formulario_grupo.php?error=Error&mensaje=$msg");
                        exit();
                    }

                } else {
                    $msg = "Formato de la foto inválido";
                    header("Location:formulario_grupo.php?error=Error&mensaje=$msg");
                    exit();
                }
        }    


            try {
                $nombre = $_POST["nombre"];
                $nacionalidad = $_POST["nacionalidad"];
                $biografia = $_POST["biografia"];

                 //1. Conexion
                    $conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);
                //2. BBDD
                    mysqli_select_db($conexion, $bbdd);
                if(isset($_POST["cod_grupo_editar"]) && !empty($_POST["cod_grupo_editar"])) {
                    //editar
                    $id = $_POST["cod_grupo_editar"];

                    if($file_name != "") {
                        $consulta = "UPDATE grupos SET nombre='$nombre', nacionalidad='$nacionalidad', biografia='$biografia', foto='$file_name' WHERE cod_grupo=$id";
                    }else {
                        $consulta = "UPDATE grupos SET nombre='$nombre', nacionalidad='$nacionalidad', biografia='$biografia' WHERE cod_grupo=$id;";
                    }
                    $id_grupo = $id;

                }else {
                    //guardar nuevo

                    $ultima_id = mysqli_query($conexion, "SELECT MAX(cod_grupo) AS max_id FROM grupos");
                    $fila_id = mysqli_fetch_assoc($ultima_id);
                    $nuevo_id = $fila_id['max_id'] + 1; // calculamos el siguiente


                    //3. Definir query
                    if(isset($_FILES['foto']) && $_FILES['foto']['name'] != "") {
                        $consulta = "INSERT INTO grupos(cod_grupo,nombre,nacionalidad,biografia,foto) VALUES('$nuevo_id','$nombre','$nacionalidad','$biografia','$file_name');"; 
                    }else {
                        $consulta = "INSERT INTO grupos(cod_grupo,nombre,nacionalidad,biografia) VALUES('$nuevo_id','$nombre','$nacionalidad','$biografia');";
                    }
                    $id_grupo = $nuevo_id;
                    
                }


                    //4. ejecutar query
                    $resultado = mysqli_query($conexion, $consulta);


                    //5.cerrar conexion
                    mysqli_close($conexion);

                    header("Location:formulario_album.php?cod_grupo=$id_grupo");

            }catch(mysqli_sql_exception $msg) {
                $error = $msg->getCode();
                $mensaje = $msg->getMessage();
                header("Location:formulario_grupo?error=$error&mensaje=$mensaje");
                exit();
            }



}else {
    header("Location:formulario_grupo.php");
    exit();
}

?>