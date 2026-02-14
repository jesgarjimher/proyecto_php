<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Álbumes</title>
</head>
<body class="bg-black">
    
    <?php include "./cabecera_back.php";
       require_once("sesion.php");

    
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
    
    <main class="container pt-5 pb-5">
    <h1>Álbumes</h1>
     <?php


            $ruta = "../media/img/albumes/";

            try {
                require("../conexion_discoteca.php");
            }catch(Throwable $error) {
                echo "Mensaje: ".$error->getMessage();
            }

            
            try {
                //1.Conexion
                $conexion = mysqli_connect($servidor,$usuario, $password,$bbdd);
                mysqli_query($conexion, "SET NAMES 'UTF8'");

                //2. Selecionar base de datos
                mysqli_select_db($conexion,$bbdd);

                //3. Definir query
                //desplegable generos
                $consultaGeneros = "SELECT DISTINCT g.genero, g.cod_genero FROM generos g
                                    INNER JOIN albumes_generos alb_gen ON g.cod_genero = alb_gen.cod_genero;";
                
                $resultadoDesplegable = mysqli_query($conexion, $consultaGeneros);

                echo "<form action='albumes_back.php' method='GET' class='mb-4 d-flex flex-column align-items-center'>";
                echo "<label class='form-label w-50'>Filtrar por género: </label>";
                echo "<select name='cod_genero' class='form-control w-50' onchange='this.form.submit()'>";
                echo "<option value=''>Todos los géneros</option>";
                while($fila = mysqli_fetch_array($resultadoDesplegable)) {
                    if(isset($_GET["cod_genero"])) {
                        if($_GET["cod_genero"] == $fila["cod_genero"]) {
                            $seleccionado = "selected";
                        }else {
                            $seleccionado = "";
                        }
                    }
                        echo "<option value=$fila[cod_genero] $seleccionado>$fila[genero]</option>";
                }
                echo "</select>";
                echo "</form>";
                //grupos

                if (isset($_GET["cod_genero"]) && $_GET["cod_genero"] != "") {
                // Filtrar por GÉNERO
                    $cod_genero = (int)$_GET["cod_genero"];
                    $consulta = "SELECT a.* FROM albumes a 
                                    INNER JOIN albumes_generos ag ON a.cod_album = ag.cod_album 
                                    WHERE ag.cod_genero = $cod_genero 
                                    ORDER BY a.titulo;";
                    }else if(isset($_GET["cod_grupo"])) {
                        //si venimos de grupos
                        $cod_grupo = $_GET["cod_grupo"];
                        $consulta = "SELECT * FROM albumes WHERE cod_grupo=$cod_grupo ORDER BY titulo;";

                    }else {
                        //si venimos del enlace o url directamente, mostramos todos
                        $consulta = "SELECT * FROM albumes ORDER BY titulo;";
                    }
                
                //4. Ejecutar query
                $resultado = mysqli_query($conexion, $consulta);

                // 5.imprimir resultado
                echo "<div class='row justify-content-center'>";
                while($fila = mysqli_fetch_array($resultado)) {
                    echo "<div class='col-12 col-md-6 col-xl-4 d-flex justify-content-center mb-5'>";
                    echo "<div class='card mt-5' style='width: 18rem;'>";
                    echo    "<h2>$fila[titulo]</h2>";
                    echo    "<a href='canciones_back.php?cod_album=$fila[cod_album]'><img src='$ruta$fila[portada]' class='card-img-top'></a>";
                    echo    "<a href='canciones_back.php?cod_album=$fila[cod_album]' class='btn btn-primary mt-2'>Ver canciones</a>";
                    echo    "<a href='borrar.php?cod_album=$fila[cod_album]' class='btn btn-danger mt-2' onclick='return borrar()'>Eliminar</a>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";

                //6.Cerrar conexion
                mysqli_close($conexion);
            }catch(mysqli_sql_exception $msg) {
                echo "<p>Error nº ".$msg->getCode()."</p>";
                echo "<p>Mensaje: ".$msg->getMessage()."</p>";
            }



        ?>
    </main>
    <footer>

    </footer>
    <script>
        function borrar() {
            return confirm("Estás seguro?");
        }
    </script>
</body>
</html>