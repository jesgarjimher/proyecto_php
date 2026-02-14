<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar grupo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<?php include "./cabecera_back.php"  ?>
<body>
    
    <?php
        require_once("sesion.php");
        
        require("../conexion_discoteca.php");


        $input_id = "";
        $nombre = "";
        $nacionalidad = "";
        $biografia = "";
        $boton = "Guardar";
        $titulo = "Anadir grupo";

        $conexion = mysqli_connect($servidor, $usuario, $password, $bbdd);

        if(isset($_GET["cod_grupo"])) {
            $cod_grupo = $_GET["cod_grupo"];
            $consulta = "SELECT * FROM grupos WHERE cod_grupo=$cod_grupo;";
            $resultado = mysqli_query($conexion, $consulta);
            $grupo = mysqli_fetch_assoc($resultado);

            
            $input_id = "<input type='number' name='cod_grupo_editar' value='$cod_grupo'>";
            $boton = "Editar";
            $titulo = "Editar $grupo[nombre]";
            $nombre = $grupo["nombre"];
            $nacionalidad = $grupo["nacionalidad"];
            $biografia = $grupo["biografia"];
        }
    ?>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-11 col-md-8 col-lg-6">
                <h1><?php echo $titulo ?></h1>
                    <form name="formulario" action="anadir_grupo.php" method="post" enctype="multipart/form-data">
                <div>
                    <label class="form-label">Nombre:</label>
                    <input class="form-control" type="text" name="nombre" minlength="1" maxlength="50" value="<?php echo $nombre?>" required>
                </div>
                <div>
                    <label class="form-label">Nacionalidad:</label>
                    <input class="form-control" type="text" name="nacionalidad" minlength="2" maxlength="50" value="<?php echo $nacionalidad?>" required>
                </div>
                <div>
                    <label class="form-label">Biografía:</label>
                    <input class="form-control" type="text"  name="biografia" minlength="5" maxlength="200" value="<?php echo $biografia?>" required>
                </div>
                
                <div>
                    <label class="form-label">Foto del grupo</label>
                    <input class="form-control" type="file" name="foto">
                </div>
                <?php echo $input_id; ?>
                <div class="mt-3">
                    <input type="submit" class="btn btn-success" name="enviar" value="<?php echo $boton; ?>">
                    <input type="reset" class="btn btn-danger" value="Vaciar campos">
                </div>
            </form>
            </div>
            
        </div>
        
    
    
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>