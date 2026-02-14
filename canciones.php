<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Canciones</title>
</head>
<body>
    <header>
        <?php include "cabecera.php"  ?>
        
    </header>
    
    <main class="bg-white">
        <div class="container d-flex flex-column align-items-center pt-3">
        <h1 class="title mt-3d">Canciones<?php $titulo ?></h1>
        <?php
            $ruta = "./media/img/albumes/";

            try {
                require("conexion_discoteca.php");
            }catch(Throwable $error) {
                echo "Mensaje: ".$error->getMessage();
            }

            if(isset($_GET["cod_album"])) {
                $cod_album = $_GET["cod_album"];
            

                try {
                    //1.Conexion
                    $conexion = mysqli_connect($servidor,$usuario, $password,$bbdd);
                    mysqli_query($conexion, "SET NAMES 'UTF8'");

                    //2. Selecionar base de datos
                    mysqli_select_db($conexion,$bbdd);

                    //3. Definir query
                    $consulta = "SELECT * FROM `canciones` WHERE cod_album=$cod_album ORDER BY cod_cancion;";
                    $consultaAlbum = "SELECT * FROM `albumes` WHERE cod_album=$cod_album;";

                    //4. Ejecutar query
                    $resultado = mysqli_query($conexion, $consulta);
                    $resultadoAlbum = mysqli_query($conexion, $consultaAlbum);

                    // 5.imprimir resultado
                    $album = mysqli_fetch_assoc($resultadoAlbum);
                    $titulo = $album["titulo"];
                    
                    echo "<div class='row justify-content-center w-100'>";
                    echo "<div class='card mt-4 mb-3 col-12 col-lg-6'>";
                    echo "<img src='$ruta$album[portada]' class='card-img-top' alt='Portada de $album[titulo]'>";
                    echo "<p class='title'>$album[titulo]</p>";        
                    while($fila = mysqli_fetch_array($resultado)) {
                          echo  "<div class='card-header'>
                                    $fila[num_pista]-$fila[titulo]
                                </div>";
                          echo  "<ul class='list-group list-group-flush'>
                                <li class='list-group-item'>$fila[duracion]</li>
                            </ul>";
                    }
                    echo "</div>";
                    echo "</div>";
                    //6.Cerrar conexion
                    mysqli_close($conexion);
                }catch(mysqli_sql_exception $msg) {
                    echo "<p>Error nº ".$msg->getCode()."</p>";
                    echo "<p>Mensaje: ".$msg->getMessage()."</p>";
                }

            }else {
                header("Location:grupos.php");
                exit();
            }

        ?>
        </div>
    </main>
    <footer>

    </footer>
</body>
</html>