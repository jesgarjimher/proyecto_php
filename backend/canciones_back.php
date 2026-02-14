<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Canciones</title>
</head>
<body>
    <?php include "./cabecera_back.php";
       require_once("sesion.php");
      ?>
    <main class="bg-black">

    <?php
            if(isset($_GET["mensaje"])) {
                $mensaje = $_GET["mensaje"];
            if($mensaje) {
                echo "<h2 class='alert alert-success text-center'>$mensaje</h2>";
            }else if(isset($_GET["error"])) {
                $error = $_GET["error"];
                echo "<h2 class='alert alert-warning text-center'>Error: $error: $mensaje</h2>";
            }
            }

        ?>
        <div class="container d-flex flex-column align-items-center pt-3">

        <?php
            $ruta = "../media/img/albumes/";

            try {
                require("../conexion_discoteca.php");
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
                    echo "<h1>$album[titulo]</h1>";

                    echo "<div class='row justify-content-center w-100'>";
                    echo "<div class='card mt-4 mb-3 col-12 col-lg-6'>";
                    echo "<img src='$ruta$album[portada]' class='card-img-top' alt='Portada de $album[titulo]'>";
                    echo "<p class='title'>$album[titulo]</p>"; 
                    while($fila = mysqli_fetch_array($resultado)) {
                          echo  "<div class='card-header'>
                                    $fila[num_pista]-$fila[titulo]
                                    <a class='btn btn-outline-success' href='anadir_cancion.php?cod_cancion=$fila[cod_cancion]'>Editar</a>
                                    <a class='btn btn-outline-danger' href='borrar.php?cod_cancion=$fila[cod_cancion]&cod_album=$cod_album' onclick='return borrar()'>Eliminar</a>
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
                header("Location:grupos_back.php");
                exit();
            }

        ?>
        </div>
    </main>
    <script>
        function borar() {
            return confirm("Estás seguro?");
        }
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>