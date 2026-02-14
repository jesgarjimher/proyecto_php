<!DOCTYPE html>
<html lang="eesn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anadir genero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<?php include "./cabecera_back.php";
       require_once("sesion.php");
  ?>
<body>
    
    <?php
        require("../conexion_discoteca.php");

        $input_id = null;
        $genero = "";
        $boton = "Guardar";

    ?>
  <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-11 col-md-8 col-lg-6">
                <form name="formulario" action="anadir_genero.php" method="post" enctype="application/x-www-form-urlencoded">
                    <div>
                        <label class="form-label">Género:</label>
                        <input class="form-control" type="text" name="genero" minlength="1" maxlength="50" value="<?php echo $genero?>" required>
                    </div>
                
                    <?php echo $input_id; ?>
                    <div class="mt-3">
                        <input type="submit" class="btn btn-success" name="enviar" value="<?php echo $boton; ?>">
                        <input type="reset" class="btn btn-danger" value="Borrar">
                    </div>
                </form>
            </div>
       </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>