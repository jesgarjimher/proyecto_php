<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>Insertar álbum</title>
</head>
<?php include "./cabecera_back.php";
       require_once("sesion.php");
  ?>
<body>
    
    <?php
        require_once("./cabecera_back.php");
       require_once("sesion.php");

       if(isset($_GET["mensaje"])) {
            $mensaje = $_GET["mensaje"];
            if(isset($_GET["error"])) {
                $error = $_GET["error"];
                echo "<h2 class='alert alert-warning text-center'>$error: $mensaje</h2>";
            }
        }

        try {
            require("../conexion_discoteca.php");
        }catch(Throwable $error) {
            echo "Mensaje: ".$error->getMessage();
            exit();
        }

        

    ?>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-11 col-md-8 col-lg-6">
                <h1>Formulario álbum</h1>
                <form name="formulario" action="anadir_album.php" method="post" enctype="multipart/form-data">
                    <div>
                        <label class="form-label">Título:</label>
                        <input class="form-control" type="text" name="titulo" minlength="1" maxlength="50" required>
                    </div>
                    <div>
                        <label class="form-label">Fecha:</label>
                        <input class="form-control" type="number" name="fecha" minlength="4" maxlength="4" required>
                    </div>
                    
                    <div>
                        <?php
                            //1. Establacer conexion
                            $conexion = mysqli_connect($servidor, $usuario,$password, $bbdd);
                            mysqli_query($conexion, "SET NAMES 'UTF8'");

                            //2. Selecionar base de datos
                            mysqli_select_db($conexion,$bbdd);

                            //3. Definir query
                            $consulta = "SELECT genero, cod_genero FROM generos ORDER BY genero;";
                            $consulta_grupos = "SELECT nombre,cod_grupo FROM grupos ORDER BY nombre;";


                            //4. Ejecutar query y recoger el resultado
                            $resultado = mysqli_query($conexion, $consulta);
                            $resultado_grupos = mysqli_query($conexion, $consulta_grupos);

                            if(isset($_GET["cod_grupo"])) {
                                $cod_grupo = $_GET["cod_grupo"];
                                $cod_grupo_input ="<input class='form-control' type='number'  name='cod_grupo' minlength='1' maxlength='200' value='$cod_grupo' hidden required>";
                                echo $cod_grupo_input;

                            }else {
                                echo "<select name='cod_grupo' class='form-control mt-2'>";
                                while($fila = mysqli_fetch_array($resultado_grupos)) {
                                    echo "<option value='$fila[cod_grupo]'>$fila[nombre]</option>";
                                }
                                echo "</select>";
                            }
                                

                                //5.Mostrar por pantalla  TENGO QUE METER AQUI EL COD ALBUM NO EL GENERO< AUNQUE EL GENRO TB
                                echo "<select name='cod_genero' class='form-control mt-2'>";
                                while($fila = mysqli_fetch_array($resultado)) {
                                    echo "<option value='$fila[cod_genero]'>$fila[genero]</option>";
                                }
                                echo "</select>";
                            
                        ?>
                    </div>
                    <div>
                        <label class="form-label">Portada del álbum</label>
                        <input class="form-control" type="file" name="portada">
                    </div>
                    <div class="mt-3">
                        <input type="submit" class="btn btn-success" name="enviar" value="Enviar">
                        <input type="reset" class="btn btn-danger" value="vaciar campos">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>