<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Grupos</title>
</head>
<body>
    <header>
        <?php include "cabecera.php"  ?>
    </header>
    <main >
        <h1 class="title">Grupos</h1>
        <div class="container">
     <?php
            $ruta = "./media/img/grupos/";
            try {
                require("conexion_discoteca.php");
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
                                        <img src='$ruta$fila[foto]' class='card-img-top' alt='Portada de $fila[nombre]' title='Portada de $fila[nombre]'>
                                        <div class='card-body text-center'>
                                            <h5 class='card-title'>$fila[nombre]</h5>
                                            <p class='card-text bio'>$fila[biografia]</p>
                                            <span class='d-block text-center'>ver más...</span>
                                            <a href='albumes.php?cod_grupo=$fila[cod_grupo]' class='btn btn-outline-primary mt-2'>Ver álbumes</a>
                                        </div>
                                    </div>
                            </div>";
                            
                    }
                "</div>";

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

</body>
</html>