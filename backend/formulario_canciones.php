<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>Insertar canciones</title>
</head>
<?php include "./cabecera_back.php";
       require_once("sesion.php");
  ?>
    
    <?php
       // require_once("sesion.php");
        try {
            require("../conexion_discoteca.php");
        }catch(Throwable $error) {
            echo "Mensaje: ".$error->getMessage();
            exit();
        }

        

        if(isset($_GET["mensaje"])) {
            $mensaje = $_GET["mensaje"];
            if(isset($_GET["error"])) {
                $error = $_GET["error"];
                echo "<h2 class='alert alert-warning text-center'>Error: $error: $mensaje</h2>";
            }else if($mensaje) {
                echo "<h2 class='alert alert-success text-center'>$mensaje</h2>";

                
            }
        }

        

        
        //1. Establacer conexion
                $conexion = mysqli_connect($servidor, $usuario,$password, $bbdd);
                mysqli_query($conexion, "SET NAMES 'UTF8'");

                //2. Selecionar base de datos
                mysqli_select_db($conexion,$bbdd);

                //3. Definir query
                $consulta = "SELECT titulo,cod_album FROM albumes ORDER BY titulo;";
                //$consulta_grupos = "SELECT nombre,cod_grupo FROM grupos ORDER BY nombre;";


                //4. Ejecutar query y recoger el resultado
                $resultado = mysqli_query($conexion, $consulta);
                //$resultado_grupos = mysqli_query($conexion, $consulta_grupos);

                
                $titulo = "";
                $duracion = "";
                $cod_cancion = "";
                $num_pista = "";
                $boton = "Guardar";
                $input_id = "";
                $cod_cancion_editar = "";
                $tituloH1 = "Añadir canción";


                //editar cancion
                if(isset($_GET["cod_cancion"])) {
                    $cod_cancion = $_GET["cod_cancion"];
                    $consultaCancion = "SELECT * FROM canciones WHERE cod_cancion=$cod_cancion;";
                    $resultadoCancion = mysqli_query($conexion, $consultaCancion);
                    $cancion = mysqli_fetch_assoc($resultadoCancion);
                    $boton = "Editar";
                    $input_id = "<input type='number' name='cod_cancion_editar' value='$cod_cancion'>";
                    

                    $titulo = $cancion["titulo"];
                    $duracion = $cancion["duracion"];
                    $num_pista = $cancion["num_pista"];
                    $cod_album = $cancion["cod_album"];
                    $cod_cancion_editar = "<input type='number' name='cod_cancion_editar' value='$cancion[cod_cancion]'>";

                    //3. Definir query
                    $consultaAlbum = "SELECT titulo FROM albumes WHERE cod_album=$cod_album;";

                    //4. resultado consulta 
                    $resultadoAlbum = mysqli_query($conexion, $consultaAlbum);
                    //4 sacar album
                    $album = mysqli_fetch_assoc($resultadoAlbum);

                    $tituloH1 = "Editar $cancion[titulo] de $album[titulo]";
                }

                if(isset($_GET["cod_album"])) {
                    $cod_album = $_GET["cod_album"];
                    $consultaAlbum = "SELECT titulo FROM albumes WHERE cod_album=$cod_album;";
                    $resultadoAlbum = mysqli_query($conexion, $consultaAlbum);
                    $album = mysqli_fetch_assoc($resultadoAlbum);
                    $tituloH1 = "Anadir canción al álbum: $album[titulo]";

                }
                
    ?>
    
    <body>
        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-11 col-md-8 col-lg-6">
                    <h1><?php echo $tituloH1 ?></h1>
                
                <form name="formulario" action="anadir_cancion.php" method="post" enctype="application/x-www-form-urlencoded">
                    <div>
                        <label class="form-label">Título:</label>
                        <input class="form-control" type="text" name="titulo" minlength="1" maxlength="50" value="<?php echo $titulo ?>" required>
                    </div>
                    <div>
                        <label class="form-label">Duracion:</label>
                        <input class="form-control" type="text" name="duracion" minlength="8" maxlength="8" value="<?php echo $duracion ?>" required>
                    </div>
                    
                    <div>
                        <?php
                            echo $cod_cancion_editar;


                            if(isset($_GET["cod_album"])) {
                                $album_id = $_GET["cod_album"];
                            } else if (isset($cod_album)) { 
                                $album_id = $cod_album; 
                            } else {
                                $album_id = null;
                            }

                            if($album_id) {
                                echo "<input type='hidden' name='cod_album' value='$album_id'>";
                            } else {
                                // si no hay cod_album elegimos el album
                                echo "<select name='cod_album' class='form-control mt-3'>";
                                while($fila = mysqli_fetch_array($resultado)) {
                                    echo "<option value='$fila[cod_album]'>$fila[titulo]</option>";
                                }
                                echo "</select>";
                }
                            
                        ?>
                    </div>

                    <div>
                        <label class="form-label">Número de pista:</label>
                        <input class="form-control" type="number" name="num_pista" minlength="1" maxlength="2" value=<?php echo $num_pista ?> required>
                    </div>
                
                    <div class="mt-3">
                        <input type="submit" class="btn btn-success" name="enviar" value="<?php echo $boton ?>">
                        <input type="reset" class="btn btn-danger" value="Vaciar campos">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>