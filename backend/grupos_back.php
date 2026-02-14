<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/styles.css">
    <title>Grupos</title>
</head>
<?php include "./cabecera_back.php";
       require_once("sesion.php");
  ?>
<body>
        
    <main >
        
        <div class="container">
        <h1 class="title">Grupos</h1>
     <?php
            $ruta = "../media/img/grupos/";
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
                $consulta = "SELECT * FROM grupos ORDER BY nombre;";

                //4. Ejecutar query
                $resultado = mysqli_query($conexion, $consulta);

                // 5.imprimir resultado
                echo "<div class='row justify-content-center'>";
                    while($fila = mysqli_fetch_array($resultado)) {
                        
                        echo  
                            "<div class='col-12 col-md-6 col-xl-4 d-flex justify-content-center'>
                                    <div class='card mt-5' style='width: 18rem;'>
                                        <img src='$ruta$fila[foto]' class='card-img-top' alt='Portada de $fila[nombre]'>
                                        <div class='card-body d-flex flex-column align-items-center text-center'>
                                            <h5 class='card-title'>$fila[nombre]</h5>
                                            <a href='albumes_back.php?cod_grupo=$fila[cod_grupo]' class='btn btn-primary mt-2'>Ver álbumes</a>
                                            <a href='formulario_grupo.php?cod_grupo=$fila[cod_grupo]' class='btn btn-success mt-2'>Editar</a>
                                            <a href='borrar.php?cod_grupo=$fila[cod_grupo]' class='btn btn-danger mt-2' onclick='return borrar()'>Eliminar</a>
                                        </div>
                                    </div>
                            </div>";
                            
                    }
                echo "</div>";

                //6.Cerrar conexion
                mysqli_close($conexion);
            }catch(mysqli_sql_exception $msg) {
                echo "<p>Error nº ".$msg->getCode()."</p>";
                echo "<p>Mensaje: ".$msg->getMessage()."</p>";
            }


        
        ?>
        </div>
    </main>
    <footer>

    </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        function borrar() {
            return confirm("Estás seguro?");
        }
    </script>
</body>
</html>